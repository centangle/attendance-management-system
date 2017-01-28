 <?php	
	// By Bilal Ahmad
	// Get the teacher profile data
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		checkPost($_POST, array("TeacherID", "SubjectIDs"));	
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		
		$sbj = "";
		$subjectIDs = json_decode($_POST["SubjectIDs"]);
		$con->QueryWS("DELETE FROM subjectofinterest WHERE TeacherID = '" . $_POST["TeacherID"] . "'");
		for($i = count($subjectIDs) - 1; $i >= 0; $i--)
		{
			$sbj .= "(" . $_POST["TeacherID"] . ", " . $subjectIDs[$i] . ")";
			if($i != 0) $sbj .= ", ";
		}
		$con->QueryWS("INSERT INTO subjectofinterest (TeacherID, SubjectID) VALUES " . $sbj);
		if($con->GetRowsEffected() == 0)
			jerror("Unable to register.");
		else
		{
			$output[][] = array("Success" => "Cources has been registered");
			jprint($output);
		}
		
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>