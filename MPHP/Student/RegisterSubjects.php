 <?php	
	// By Bilal Ahmad
	// Register subjects to a student
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		
		checkPost($_POST, array("StudentID", "SubjectIDs", "Semester"));
		Verify($_POST);				 	// verifying requester
		
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		
		$subjectIDs = json_decode($_POST["SubjectIDs"]);
		if($_POST["SubjectIDs"] == "" || count($subjectIDs) == 0)
			throw new Exception("No subjects selected");
		$con->Query("SELECT SUM(CreditHours) AS CreditHours FROM subject " .
											"WHERE SubjectID IN (" . implode(", ", $subjectIDs) . ")");
		$row = $con->GetAssoc();
		$totalCreditHours = $row["CreditHours"];
		$con->Query("SELECT * FROM criteria WHERE Entity = 'MinCreditHours' OR Entity = 'MaxCreditHours'");
		while($row = $con->GetAssoc())
		{
			if($row["Entity"] == "MinCreditHours")
				$minCreditHours = $row["Value"];
			else
				$maxCreditHours = $row["Value"];
		}
		$con->Query("SELECT discipline.TotalSemester, student.SectionID FROM discipline JOIN student " .
						"ON discipline.DisciplineID = student.DisciplineID " .
						"WHERE student.StudentID = '" . $_POST["StudentID"] . "'");
		$row = $con->GetAssoc();
		$totalSemester = $row["TotalSemester"];
		$sectionID = $row["SectionID"];
		if($totalCreditHours != 0)
		{
			if(((int)$totalCreditHours >= (int)$minCreditHours &&
				(int)$totalCreditHours <= (int)$maxCreditHours) ||
				$totalSemester < $_POST["Semester"])
			{
				$con->QueryWS("DELETE FROM subjecttostudy WHERE StudentID = '" . $_POST["StudentID"] . "'");
				$values = "";
				for($i = count($subjectIDs) - 1; $i >= 0; $i--)
				{
					$values .= "(" . $_POST["StudentID"] . ", " . $subjectIDs[$i] . ", " . $sectionID . ")";
					if($i != 0) $values .= ", "; 
				}
				$con->QueryWS("INSERT INTO subjecttostudy (StudentID, SubjectID, SectionID) VALUES " . $values);
				if($con->GetRowsEffected() == 0)
					$output = array();
				else
					$output[][] = array("Success" => "Subjects has been registered");
				jprint($output); 			// send results
			}
			else if((int)$totalCreditHours > (int)$maxCreditHours) 
					jerror("Max credit hours limit: " . $maxCreditHours);
				else jerror("Min credit hours limit: " . $minCreditHours);
		}
		else jerror("Select some subject first");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>