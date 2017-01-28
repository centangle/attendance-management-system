 <?php	
	// By Bilal Ahmad
	// Get the student login
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["RegistrationNo"] = "FA09-BCS-001";
		//$_POST["Password"] = "1";
		checkPost($_POST, array("RegistrationNo", "Password"));	
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT student.StudentID, student.Name, student.Semester, student.Image, discipline.TotalSemester " .
						"FROM student JOIN discipline " .
						"ON student.DisciplineID = discipline.DisciplineID " .
						"WHERE student.RegistrationNo = '" . $_POST["RegistrationNo"] . "' " .
						"AND student.XPassword = '" . $_POST["Password"] . "'");// making query
		$row = $con->GetAssoc();		// get rows
		
		if($row === false)
			throw new Exception("Invalid username or password");
		else
		{
			if($row["Semester"] > $row["TotalSemester"])
				$row["Semester"] = $row["TotalSemester"] + 1;
			unset($row["TotalSemester"]);
			writeLog($con, "Student", $row["StudentID"], "Login from mobile");
			$student[] = array("StudentID" => $row["StudentID"], 
						"Name" => $row["Name"],
						"Semester" => $row["Semester"],						
						"Image" => getEncodedFile(DIR_STUDENT_IMAGE . $row["Image"])); // get student rec
			
			// subject to study codes
			$con->Query("SELECT * FROM subjecttostudy WHERE StudentID = '" . $row["StudentID"] . "'");
			$sts = array();
			while($row = $con->GetAssoc()) $sts[] = $row;
			$subCount = count($sts);
			if ($subCount == 0) $subjects[] = array();
			for($i = 0; $i < $subCount; $i++)
			{
				$res = array();
				$res["SubjectID"] = $sts[$i]["SubjectID"];
				$res["SectionID"] = $sts[$i]["SectionID"];
				
				// fetch subject record
				$con->Query("SELECT Code FROM subject WHERE SubjectID = '" . $res["SubjectID"] . "'");
				$row = $con->GetAssoc();
				$res["Code"] = $row["Code"];
				
				$subjects[] = $res;
			}
			
			$output[] = $student;
			$output[] = $subjects;
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