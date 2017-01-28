 <?php	
	// By Bilal Ahmad
	// Get the student profile data
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		
		checkPost($_POST, array("StudentID"));	
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT Name, RegistrationNo, Semester, EmailAddress, PhoneNumber, MobileNumber FROM student WHERE StudentID = '" . $_POST["StudentID"] . "'");// making query
		$output[][] = $con->GetAssoc();	// get rows
		jprint($output);
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>