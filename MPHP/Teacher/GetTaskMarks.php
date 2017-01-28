 <?php	
	// By Bilal Ahmad
	// Get marks of task
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		$_POST["TaskID"] = "1";
		
		checkPost($_POST, array("TaskID", "Update"));
		Verify($_POST);				 	// verifying requester
		extract($_POST);
		
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		
		if($Update == "true")			// check for update allowed
		{
			$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
			$y = $con->GetAssoc();
			$add = $y["Value"];
			
			if($add != "Open") throw new Exception("Updating not allowed");
		}
		
		$con->Query("SELECT DISTINCT student.StudentID, student.RegistrationNo, student.Name, marks.ObtainedMarks " .
					"FROM marks JOIN student " .
					"ON marks.StudentID = student.StudentID " .
					"WHERE marks.TaskID = '$TaskID'");
		if($con->IsEmptySet()) jerror("Marks not added");
		else
		{
			$output[] = $con->GetAll();
			$con->Query("SELECT TotalMarks FROM task WHERE TaskID = '$TaskID'");
			$y = $con->GetAssoc();
			$marks = $y["TotalMarks"];
			$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
			$y = $con->GetAssoc();
			$update = $y["Value"];
			$output[][] = array("TotalMarks" => $marks, "Update" => $update);
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