 <?php	
	// By Bilal Ahmad
	// Uploads solution file of a task
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["Params"] = '[1, 1]';
		checkPost($_POST, array("Params"));
		checkPost($_FILES, array("uploadedfile"));
		Verify($_POST);				 				// verifying requester
		
		$paramArray = json_decode($_POST["Params"]);// decode params
		$TaskID = $paramArray[0];
		$TeacherID = $paramArray[1];
		
		$con = new Connection();					// make connections
		$con->Start();								// start connection		
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'UploadFileSize'");
		$y = $con->GetAssoc();
		$validSize = $y["Value"];		// get size
		
		$allowedExts = array("rar", "zip");			//alowed image extensions
		$exp = explode(".", $_FILES["uploadedfile"]["name"]);
		$extension = $exp[count($exp) - 1];			// move pointer to end
		if (in_array($extension, $allowedExts))
		{
			if($_FILES["uploadedfile"]["size"] != 0)
			{
				$fileSize = $_FILES["uploadedfile"]["size"] / 1048576;
				if($fileSize <= $validSize)			// less than 5 MB file can be uploaded 
				{
					$con->Query("SELECT SolutionID, DueDate FROM task WHERE TaskID = '$TaskID'");
					$row = $con->GetAssoc();
					$SolutionID = $row["SolutionID"];
					$DueDate = $row["DueDate"];
					
					if($SolutionID != null)
						throw new Exception("Content already set");		// check content already set
					if($DueDate != null)		// check due date passes or not
					{
						$today = strtotime(date(FORMAT_DATE));
						$dd = strtotime($DueDate);
						
						if($dd <= $today) throw new Exception("Due date not pass.");
					}
					$todayDate = date(FORMAT_DATE);
					$con->Query("INSERT INTO content (TeacherID, OnDate) VALUES ('$TeacherID', '$todayDate')");
					if($con->GetRowsEffected() == 0) throw new Error ("Unexpected error occured");
					$SolutionID = $con->GetID();
					
					$con->Query("UPDATE task SET SolutionID = '$SolutionID' WHERE TaskID = '$TaskID'");
					$targetPath = DIR_CONTENT . $SolutionID . "." . $extension;
					if(!file_exists($targetPath))		// check file already exist
					{
						move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $targetPath);
						$con->QueryWS("UPDATE content SET FileName = '" . ($SolutionID . "." . $extension) . "' WHERE ContentID = '$SolutionID'");
						jsuccess("File has been uploaded.");
					}
					else jerror("Content already exist.");
				}
				else jerror("Size must with in " . $validSize . " MB");
			}
			else jerror("File must not be empty.");
		}
		else jerror("Invalid file type " . $extension);
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>