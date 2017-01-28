 <?php	
	// By Bilal Ahmad
	// Get the subject Details
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		
		checkPost($_POST, array("StudentID", "SubjectID", "SectionID"));
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$res = array();					// result array
		
		// fetch subject info
		$con->Query("SELECT * FROM subject WHERE SubjectID = '" . $_POST["SubjectID"] . "'");
		$row = $con->GetAssoc();
		$res["Name"] = $row["Name"];
		$res["Code"] = $row["Code"];
		$res["CreditHours"] = $row["CreditHours"];
		$res["Lab"] = $row["Lab"] == "1" ? "Yes" : "No";
		$res["Description"] = $row["Description"];
		
		// fetch section info
		$con->Query("SELECT SectionCode FROM section WHERE SectionID = '" . $_POST["SectionID"] . "'");
		$row = $con->GetAssoc();
		$res["SectionCode"] = $row["SectionCode"];
		
		// fetch semister of student and subject info
		$con->Query("SELECT student.Semester FROM student JOIN catalog ON student.DisciplineID = catalog.DisciplineID AND student.StudentID = '" . 
													$_POST["StudentID"] . "' AND catalog.SubjectID = '" . $_POST["SubjectID"] . "' AND " . 
													"student.Semester = catalog.Semester");
		$row = $con->GetAssoc();
		$res["Previous"] = $row["Semester"] == null ? "Yes" : "No"; 
		
		// get subject studied
		$con->Query("SELECT StudentID FROM subjectstudied WHERE StudentID = '" . $_POST["StudentID"] . "' AND SubjectID = '" . $_POST["SubjectID"] . "'");
		$row = $con->GetAssoc();
		$res["Repeat"] = $row["StudentID"] == null ? "No" : "Yes";
		
		// get teacher ID
		$con->Query("SELECT TeacherID FROM subjecttoteach JOIN class ON subjecttoteach.ClassID = class.ClassID AND class.SectionID = '" . $_POST["SectionID"] . "' AND class.SubjectID = '" . $_POST["SubjectID"] . "'");
		$row = $con->GetAssoc();
		
		// teacher name
		$con->Query("SELECT Name FROM teacher WHERE TeacherID = '" . $row["TeacherID"] . "'");
		$row = $con->GetAssoc();
		$res["Teacher"] = $row["Name"] == null ? "N/A" : $row["Name"];
		
		$result[] = $res;
		$output[] = $result;
		jprint($output); 			// send results
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>