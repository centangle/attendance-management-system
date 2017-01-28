 <?php	
	// By Bilal Ahmad
	// Get detail of a lecture
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["LectureID"] = "3";
		checkPost($_POST, array("LectureID"));
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
		$row = $con->GetAssoc();
		$update = $row["Value"];
		
		// query data and make output
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'UploadFileSize'");
		$row = $con->GetAssoc();
		$validSize = $row["Value"];		// get size
		
		if($validSize != null)
		{
			$con->Query("SELECT Title, Date, StartTime, EndTime, Lab, Description, ContentID FROM lecture WHERE LectureID = '" . $_POST["LectureID"] . "'");
			if(!$con->IsEmptySet())			// chek for no record	
			{
				// format data
				$lec = $con->GetAssoc();
				$lec["Lab"] = $lec["Lab"] == "1" ? "true" : "false";
				$lec["Length"] = $validSize;
				$lec["Update"] = $update;
				$output[][] = $lec;
			}
			else $output = array();
			jprint($output); 				// send results
		}
		else jerror("Unexpected error occured");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>