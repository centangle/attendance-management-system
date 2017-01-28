 <?php	
	// By Bilal Ahmad
	// Get the registration data
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		
		checkPost($_POST, array("StudentID", "Semester"));
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		
		// check for open or close
		$con->Query("SELECT Value FROM criteria WHERE Entity='RegisterCourse'");
		$row = $con->GetAssoc();
		$status = $row["Value"];			// get criteria value from db and check its status
		if($status != "Open")
			throw new exception("Subject registeration not open.");
		
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'SubjectRepeat'");
		$row = $con->GetAssoc();
		$repeatCriteria = $row["Value"];
		$con->Query("SELECT catalog.Semester, catalog.SubjectID, subjectstudied.StudentID AS SID FROM catalog LEFT OUTER JOIN subjectstudied " .
						"ON catalog.SubjectID = subjectstudied.SubjectID " .
						"WHERE (catalog.Semester < '" . $_POST["Semester"] . "' " .
						"AND (subjectstudied.SubjectID IS NULL " .
						"OR (subjectstudied.StudentID = '" . $_POST["StudentID"] . "' " .
						"AND subjectstudied.Marks <= '" . $repeatCriteria . "')))" .
						"OR catalog.Semester = '" . $_POST["Semester"] . "'");	// get subjects from catelog
		$subjects = $con->GetAll();
		
		$allowed = array();
		$nullSIDs = array();	// get subjects those are not studied
		for($i = count($subjects) - 1; $i >= 0; $i--)
		{
			if($subjects[$i]["SID"] == null) $nullSIDs[] = $subjects[$i]["SubjectID"];
			$allowed[] = $subjects[$i]["SubjectID"];
		}
		if(count($allowed) != 0 && count($nullSIDs) != 0) // filter pre-reqs
		{	
			$con->Query("SELECT SubjectID FROM prereq WHERE SubjectID IN (" . implode(", ", $nullSIDs ) . ")" . 
														"AND PreReqID IN (" . implode(", ", $nullSIDs ) . ")");
			$notAllowedSIDs = $con->GetColumnArray("SubjectID");
			$allowed = deleteItems($allowed, $notAllowedSIDs);
		}
		
		if(count($allowed) != 0) // make final output combine info needed in form
		{
			$con->Query("SELECT SubjectID, Name, CreditHours, Lab FROM subject WHERE SubjectID IN (" . implode(", ", $allowed) . ")");
			$regSubjects = $con->GetAll();
			$con->Query("SELECT SubjectID FROM subjecttostudy WHERE StudentID = '" . $_POST["StudentID"] . "'");
			$already = $con->GetColumnArray("SubjectID");
			
			for($i = count($regSubjects)- 1; $i >= 0; $i--)
			{
				$res = array();
				for($j = count($subjects) - 1; $j >= 0; $j--)
				{
					if($subjects[$j]["SubjectID"] == $regSubjects[$i]["SubjectID"])
					{
						copyItems($res, $regSubjects[$i], array("SubjectID", "Name","CreditHours"));
						$ch = (int)$res["CreditHours"];
						$ch = $regSubjects[$i]["Lab"] == "1" ? "(" . ($ch - 1) . ", 1)" : "(" . $ch . ", 0)";
						$res["CreditHours"] = $res["CreditHours"] . $ch;
						$res["Semester"] = $subjects[$j]["Semester"];
						$pos = array_search($regSubjects[$i]["SubjectID"], $already);
						$res["Exist"] = !($pos === false);
						$result[] = $res;
						break;
					}
				}
			}
			$output[] = $result;
			jprint($output); 			// send results
		}
		else jprint("Course Information is invalid");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>