 <?php	
	// By Bilal Ahmad
	// Get marks of task
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["TaskID"] = "1";
		//$_POST["SubjectID"] = "39";
		//$_POST["SectionID"] = "1";
		
		checkPost($_POST, array("TaskID", "SubjectID", "SectionID"));
		Verify($_POST);				 	// verifying requester
		extract($_POST);
		
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
		$y = $con->GetAssoc();
		$add = $y["Value"];
		if($add == "Open")
		{
			$con->Query("SELECT count(*) AS Count FROM marks WHERE TaskID = '$TaskID'");
			$y = $con->GetAssoc();
			if($y["Count"] == "0")
			{
				// Get students
				$con->Query("SELECT student.StudentID, student.Name, student.RegistrationNo " .
							"FROM student JOIN subjecttostudy " .
							"ON student.StudentID = subjecttostudy.StudentID " .
							"WHERE subjecttostudy.SectionID = '$SectionID' " .
							"AND subjecttostudy.SubjectID = '$SubjectID'");
				// validating
				if($con->IsEmptySet()) jerror("No student registered in this section");
				else
				{
					$output[] = $con->GetAll();
					$con->Query("SELECT TotalMarks FROM task WHERE TaskID = '$TaskID'");
					$output[] = $con->GetAll();
					jprint($output);
				}
			}
			else jerror("Task already marked");
		}
		else jerror("Adding marks not allowed");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>