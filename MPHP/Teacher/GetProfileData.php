 <?php	
	// By Bilal Ahmad
	// Get the teacher profile data
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["TeacherID"] = "1";
		checkPost($_POST, array("TeacherID"));	
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT teacher.Name, teacher.Email, teacher.PhoneNumber, teacher.MobileNumber, departments.Name AS Department " .
						"FROM teacher JOIN departments " .
						"ON teacher.DepartmentID = departments.DepartmentID " .
						"WHERE teacher.TeacherID = '" . $_POST["TeacherID"] . "'");// making query
		$about = $con->GetAssoc();		// get row
		$output[][] = $about;			// get rows
		jprint($output);
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>