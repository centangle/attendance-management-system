 <?php	
	// By Bilal Ahmad
	// send email to a teacher
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["StudentID"] = "1";
		//$_POST["TeacherID"] = "1";
		//$_POST["Message"] = "msg";
		checkPost($_POST, array("StudentID", "TeacherID", "Message"));	
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		
		$con->Query("SELECT RegistrationNo FROM student WHERE StudentID = '" . $_POST["StudentID"] . "'");
		$row = $con->GetAssoc();
		$regNo = $row["RegistrationNo"];
		$con->Query("SELECT Email FROM teacher WHERE TeacherID = '" . $_POST["TeacherID"] . "'");
		$row = $con->GetAssoc();
		$email = $row["Email"];
		$msg = $_POST["Message"] . "From: " . $regNo;
		sendEmail($email, "MSIS: StudentQuery" . ' => ' . $regNo, $msg);
		jsuccess("Message has been send");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>