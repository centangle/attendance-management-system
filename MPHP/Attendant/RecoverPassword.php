 <?php	
	// By Bilal Ahmad
	// Send new password to attendant
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");								// including common functions
		
		checkPost($_POST, array("Username"));
		Verify($_POST);														// verifying requester
		$con = new Connection();											// making connection object
		$con->start();														// initializing connection
		// get student email address
		$con->Query("SELECT Email, MobileNumber FROM attendent WHERE Username = '" . $_POST["Username"] . "'");
		$row = $con->GetAssoc();											// get result
		$number = $row["MobileNumber"];
		$emailAddr = $row["Email"];											// get email value
		if($row === false) throw new Exception("Invalid User Name");
		if($emailAddr === "" || $emailAddr == null) throw new Exception("Invalid email address");	// check for empty value
		$newPassword = getRandomPassword();									// new password
		// set new pass of student
		$res = $con->QueryWS("UPDATE attendent SET Password = '" . $newPassword . "' WHERE Username = '" . $_POST["Username"] . "'");
		if($con->GetRowsEffected() == 0)									// check for successfully updation
			throw new Exception("Error changing password");
		sendEmail($emailAddr, EMAIL_SUBJECT_RECOVER, "New password is: " . $newPassword);
		sendSMS("Your password has been changed. Check your mail box", $number);
		$result[] = array("Output" => "Check your mail box");				// make result
		$output[] = $result;												// attach result with output	
		jprint($output); 													// sending json object
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());											// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 													// closing connection
 ?>