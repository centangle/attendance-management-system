 <?php	
	// By Bilal Ahmad
	// Set assesment answers
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["SectionID"] = "1";
		//$_POST["StudentID"] = "1";
		//$_POST["SubjectID"] = "39";
		//$_POST["Answers"] = "[3,3,3,4,2,4,2,1,5,3,4,2,1,5]";
		//$_POST["QuestionIDs"] = "[14,13,12,11,10,9,8,7,6,5,4,3,2,1]";
		
		checkPost($_POST, array("StudentID", "SectionID", "SubjectID", "Answers", "QuestionIDs"));	
		Verify($_POST);				 	// verifying requester
		
		$ans = json_decode($_POST["Answers"]);
		$totalQuestions = count($ans);
		$avg = 0;
		for($i = 0; $i < $totalQuestions; $i++)
			$avg += (int)$ans[$i];
		$per = $avg / ($totalQuestions * 5) *100;
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT subjecttoteach.TeacherID FROM subjecttoteach JOIN class JOIN subjecttostudy " .
					"ON subjecttostudy.SectionID = class.SectionID " .
					"AND class.ClassID = subjecttoteach.ClassID " .
					"WHERE subjecttostudy.StudentID = '" . $_POST["StudentID"] . "' " .
					"AND subjecttostudy.SubjectID = '" . $_POST["SubjectID"] . "'");
		if(!$con->IsEmptySet())
		{
			$row = $con->GetAssoc();
			$teacherID = $row["TeacherID"];
			$con->Query("SELECT Semester FROM student WHERE StudentID = '" . $_POST["StudentID"] . "'");
			$row = $con->GetAssoc();
			$semester = $row["Semester"]; // inset in assessment answers
			$con->QueryWS("INSERT INTO assesment (StudentID, SubjectID, SectionID, TeacherID, Semester, Average) " .
							"VALUES ('" . $_POST["StudentID"] . "', '" . $_POST["SubjectID"] . "', '" . $_POST["SectionID"] . "', '$teacherID', '$semester', '$per')");
			if($con->GetRowsEffected() != 0)
			{
				$qestionIDs = json_decode($_POST["QuestionIDs"]);
				$assesmentID = $con->GetID();
				$ansVal = "";
				for($i = 0; $i < $totalQuestions; $i++)
				{
					$ansVal .= "('$assesmentID', '" . $qestionIDs[$i] . "', '" . $ans[$i] . "')";
					if($i != $totalQuestions - 1)
						$ansVal .= ",";
				}
				$con->QueryWS("INSERT INTO answer (AssesmentID, QuestionID, AnswerDetail) VALUES " . $ansVal);
				if($con->GetRowsEffected() != 0)
				{
					$output[][] = array("Success" => "Assessment has beesn submitted");;
					jprint($output);
				}
				else jerror("Error in submitting");
			}
			else jerror("Error in submitting");
		}
		else jerror("Error in submitting");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>