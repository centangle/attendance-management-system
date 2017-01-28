 <?php	
	// By Bilal Ahmad
	// get the attendance
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["LectureID"] = '3';
		//$_POST["Update"] = 'false';
		
		checkPost($_POST, array("LectureID", "Update"));
		Verify($_POST);				 				// verifying requester
		extract($_POST);
		
		$con = new Connection();					// make connections
		$con->Start();								// start connection
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
		$row = $con->GetAssoc();
		$update = $row["Value"];
		if($Update == "true" && $update != "Open")
			throw new Exception("Update not allowed.");
		
		$con->Query("SELECT student.StudentID, student.RegistrationNo, student.Name, attendance.Present " . // get attendance marked
					"FROM student JOIN attendance " .
					"ON student.StudentID = attendance.StudentID " .
					"WHERE attendance.LectureID = '$LectureID'");
		if($con->GetRowsEffected() != 0)	// if not marked
		{
			$output[] = $con->GetAll();
			$output[][] = array("Update" => $update);
			jprint($output);
		}
		else jerror("Attendance not marked.");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>