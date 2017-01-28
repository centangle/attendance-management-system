 <?php	
	// By Bilal Ahmad
	// send sms to students of a teacher
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["SectionID"] = "1";
		//$_POST["SubjectID"] = "39";
		//$_POST["Message"] = "mjjjsg";
		checkPost($_POST, array("SubjectID", "SectionID", "Message"));	
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT MobileNumber FROM student JOIN  subjecttostudy " .
					"ON subjecttostudy.StudentID = student.StudentID " .
					"WHERE subjecttostudy.SubjectID = '" . $_POST["SubjectID"] . "' " .
					"AND subjecttostudy.SectionID = '" . $_POST["SectionID"] . "'");
		
		if(!$con->IsEmptySet())
		{
			$numbers = $con->GetColumnArray("MobileNumber");
			$count = count($numbers);
			for($i = $count - 1; $i >= 0; $i--)		// sending sms
				sendSMS($numbers[$i], $_POST["Message"]);
			$output[][] = array("Success" => $count . " Messages has been sent.");
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