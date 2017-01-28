 <?php	
	// By Bilal Ahmad
	// send email to teacher of students
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["SectionID"] = "1";
		//$_POST["Message"] = "msg";
		checkPost($_POST, array("SectionID", "Message", "SubjectID"));	
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT EmailAddress FROM student JOIN  subjecttostudy " .
					"ON subjecttostudy.StudentID = student.StudentID " .
					"WHERE subjecttostudy.SubjectID = '" . $_POST["SubjectID"] . "' " .
					"AND subjecttostudy.SectionID = '" . $_POST["SectionID"] . "'");
		
		if(!$con->IsEmptySet())
		{
			$emails = $con->GetColumnArray("EmailAddress");
			$count = count($emails);
			for($i = $count - 1; $i >= 0; $i--) // sending columns
				sendEmail($emails[$i], "MSIS: Teacher Notification", $_POST["Message"]);
			$output[][] = array("Success" => $count . " Emails has been sent.");
			jprint($output);
		}
		else jerror("No students registered in this section");
		
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>