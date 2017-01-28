 <?php	
	// By Bilal Ahmad
	// Get detail of a lecture
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$today = date(FORMAT_DATE); 	// get today
		$today = strtotime($today); // get date
		$today = date(FORMAT_DATE, $today);
		
		$con->Query("SELECT task.Title, Task.ClassID, task.DueDate FROM task " .
					"WHERE task.DueDate = '$today' " .
					"AND task.TaskType = 'a'");
		$tasks = $con->GetAll();
		while($task = current($tasks))
		{
			$con->Query("SELECT * FROM class WHERE ClassID = '" . $task["ClassID"] . "'");
			$row = $con->GetAssoc();
			$sectionID = $row["SectionID"];
			$subjectID = $row["SubjectID"];
			// get numberes
			$con->Query("SELECT DISTINCT student.MobileNumber " .
						"FROM student JOIN subjecttostudy " .
						"ON student.StudentID = subjecttostudy.StudentID " .
						"WHERE subjecttostudy.SectionID = '$sectionID' " .
						"AND subjecttostudy.SubjectID = '$subjectID'");
			
			while($num = $con->GetAssoc()["MobileNumber"])
			{
				sendSMS($num, "You have to submit assignment '" . 
								$task["Title"] . "' on " . $task["DueDate"]);
			}
			next($tasks);
		}
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>