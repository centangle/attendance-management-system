 <?php	
	// By Bilal Ahmad
	// Add lecture of a teacher
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["TeacherID"] = "1";
		//$_POST["Description"] = "d";
		//$_POST["Title"] = "a";
		//$_POST["Whom"] = "Sk";
		
		checkPost($_POST, array("Title", "Whom", "Description", "TeacherID"));
		Verify($_POST);				 	// verifying requester
		extract($_POST);
		
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
		$row = $con->GetAssoc();
		$add = $row["Value"];
		
		if($add == "Open")
		{
			$con->Query("INSERT INTO article (TeacherID, Title, Whom, Description) " .
						"VALUES ('$TeacherID', '$Title', '$Whom', '$Description')");
			if($con->GetRowsEffected() == 0) jerror("Unexpected error occured");
			else
			{
				writeLog($con, "Teacher", $TeacherID, "Add an article");
				jsuccessWithID("Article added successfully", $con->GetID());
			}
		}
		else jerror("Add lecture not allowed.");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>