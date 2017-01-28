 <?php	
	// By Bilal Ahmad
	// Get the subject semester marks
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions

		checkPost($_POST, array("StudentID", "Semester"));
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		
		// get course from catalog
		$con->Query("SELECT SubjectID, catalog.Semester FROM catalog JOIN student ON catalog.DisciplineID = student.DisciplineID AND " .
						"catalog.Semester <= '" . $_POST["Semester"] . "' AND student.StudentID = '" . $_POST["StudentID"] . "' AND " .
						"student.Semester > '" . $_POST["Semester"] . "' ORDER BY catalog.SubjectID");
		if(!$con->IsEmptySet())
		{
			$catalog = $con->GetAll();
			$subjectIDs = getColumnArray($catalog, "SubjectID");
			$con->Query("SELECT SubjectID, Name, CreditHours FROM subject WHERE SubjectID IN (". implode(", ", $subjectIDs) . ") ORDER BY SubjectID");
			if(!$con->IsEmptySet())
			{
				$subjects = $con->GetAll();
				// get subject detail
				$con->Query("SELECT SubjectID, Marks, GPA FROM subjectstudied WHERE SubjectID IN (". implode(", ", $subjectIDs) . ") " .
																"AND StudentID = '" . $_POST["StudentID"] . "' ORDER BY SubjectID");
				if(!$con->IsEmptySet())
				{
					$marks = $con->GetAll();
					
					$con->Query("SELECT discipline.TotalSemester FROM discipline JOIN student " .
						"ON discipline.DisciplineID = student.DisciplineID " .
						"WHERE student.StudentID = '" . $_POST["StudentID"] . "'");
					$y = $con->GetAssoc();
					$sem = $y["TotalSemester"];
					if($_POST["Semester"] > $sem)
						$_POST["Semester"] = "8";
					
					$gpaSubjects = array();
					$subjectsGPAs = 0;
					$creditHours = 0;
					$reqSemSubjectsGPAs = 0;
					$reqSemCreditHours = 0;
					$cataloglen = count($catalog);
					for($i = 0, $j = 0; $i < $cataloglen; $i++) // make output formate and calculate gpa, cgpa
					{
						if($catalog[$i]["Semester"] == $_POST["Semester"])
						{
							if($subjects[$i]["SubjectID"] == $marks[$j]["SubjectID"])
								$result[] = array("Name" => $subjects[$i]["Name"], "Grade" => getGrade($marks[$j]["Marks"]), "GPA" => $marks[$j]["GPA"]);
							else $result[] = array("Name" => $subjects[$i]["Name"], "Grade" => "F", "GPA" => "0.0");
							
							$reqSemSubjectsGPAs += (float)$marks[$j]["GPA"] * (int)$subjects[$i]["CreditHours"];
							$reqSemCreditHours += (int)$subjects[$i]["CreditHours"];
						}
						if($subjects[$i]["SubjectID"] == $marks[$j]["SubjectID"])
						{
							$subjectsGPAs += (float)$marks[$j]["GPA"] * (int)$subjects[$i]["CreditHours"];
							$creditHours += (int)$subjects[$i]["CreditHours"];
							$j++;
						}
					}
					$output[] = $result;
					$output[][] = array("GPA" => sprintf('%0.2f', $reqSemSubjectsGPAs / $reqSemCreditHours),
										"CGPA" => sprintf('%0.2f', $subjectsGPAs / $creditHours));
				}
				else $output = array();
			}
			else $output = array();
		}
		else $output = array();
		jprint($output); 				// send results
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>