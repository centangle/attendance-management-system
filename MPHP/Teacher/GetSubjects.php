 <?php	
	// By Bilal Ahmad
	// Get all subjects of a department
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["DepartmentID"] = "4";
		//$_POST["TeacherID"] = "1";
		checkPost($_POST, array("TeacherID", "DepartmentID"));	
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		
		// check for open or close
		$con->Query("SELECT Value FROM criteria WHERE Entity='InterestCourse'");
		$row = $con->GetAssoc();
		$status = $row["Value"];	// get criteria from database and check its status
		if($status != "Open")
			throw new exception("Registration of interested subject not open.");
		
		$con->Query("SELECT DISTINCT subject.Lab, subject.SubjectID, catalog.Semester, subject.CreditHours, subject.Name FROM subject JOIN catalog " .
						"ON subject.DepartmentID = '" . $_POST["DepartmentID"] . "' ".
						"AND catalog.SubjectID = subject.SubjectID");
		if($con->IsEmptySet())
			jerror("Error Reading subjects");
		else
		{
			$regSubjects = $con->GetAll();
			$con->Query("SELECT SubjectID FROM subjectofinterest " .
							"WHERE TeacherID = '" . $_POST["TeacherID"] . "'");
			
			$already = $con->GetColumnArray("SubjectID");
			for($i = count($regSubjects) - 1; $i >= 0; $i--)
			{
				$ch = (int)$regSubjects[$i]["CreditHours"];
				$ch = $regSubjects[$i]["Lab"] == "1" ? "(" . ($ch - 1) . ", 1)" : "(" . $ch . ", 0)";
				$regSubjects[$i]["CreditHours"] = $regSubjects[$i]["CreditHours"] . $ch;
				$pos = array_search($regSubjects[$i]["SubjectID"], $already);
				$regSubjects[$i]["Exist"] = !($pos === false);
				unset($regSubjects[$i]["Lab"]);
			}
			$output[] = $regSubjects;
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