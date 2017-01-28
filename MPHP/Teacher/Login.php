 <?php	
	// By Bilal Ahmad
	// Get the teacher login
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["Username"] = "a@msis.com";
		//$_POST["Password"] = "a";
		checkPost($_POST, array("Username", "Password"));	
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT TeacherID, DepartmentID, Name, Image FROM teacher WHERE Username = '" . $_POST["Username"] . "' AND Password = '" . $_POST["Password"] . "'");// making query
		$row = $con->GetAssoc();		// get rows
		
		if($row === false)
			throw new Exception("Invalid username or password");
		else
		{
			writeLog($con, "Teacher", $row["TeacherID"], "Login from mobile");
			$teacher[] = array("TeacherID" => $row["TeacherID"], 
						"Name" => $row["Name"],	
						"DepartmentID" => $row["DepartmentID"],							
						"Image" => getEncodedFile(DIR_TEACHER_IMAGE . $row["Image"])); // get student rec
			$output[] = $teacher;
			jprint($output); 			// send results
		}
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>