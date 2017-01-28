 <?php	
	// By Bilal Ahmad
	// Get students list of a section
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["SubjectID"] = '39';
		//$_POST["SectionID"] = '1';
		checkPost($_POST, array("SubjectID", "SectionID"));
		Verify($_POST);				 				// verifying requester
		extract($_POST);
		
		$con = new Connection();					// make connections
		$con->Start();								// start connection
		$con->Query("SELECT DISTINCT student.StudentID, student.DisciplineID, student.Semester, student.RegistrationNo, student.Name " .
					"FROM student JOIN subjecttostudy " .
					"ON student.StudentID = subjecttostudy.StudentID " .
					"WHERE subjecttostudy.SubjectID = '$SubjectID' " .
					"AND subjecttostudy.SectionID = '$SectionID'");
		if($con->IsEmptySet()) jerror("No students in this section.");
		else
		{
			$result = $con->GetAll();
			
			$i = count($result) - 1;
			while($i >= 0)
			{
				// get total semester
				$con->Query("SELECT TotalSemester " .
					"FROM discipline " .
					"WHERE DisciplineID = '" . $result[$i]["DisciplineID"] . "'");
				$row = $con->GetAssoc();
				if($result[$i]["Semester"] > $row["TotalSemester"])
					$result[$i]["Semester"] = $row["TotalSemester"] + 1;
				unset($result[$i]["DisciplineID"]);
				$i--;
			}
			$output[] = $result;
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