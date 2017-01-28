 <?php	
	// By Bilal Ahmad
	// Get the sections of a teacher
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["TeacherID"] = "1";
		checkPost($_POST, array("TeacherID"));	
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT DISTINCT class.SubjectID, section.SectionID, discipline.DisciplineCode, section.Semester, section.SectionCode " .
					"FROM subjecttoteach JOIN class JOIN section JOIN discipline " .
					"ON subjecttoteach.ClassID = class.ClassID " .
					"AND class.SectionID = section.SectionID " .
					"AND section.DisciplineID = discipline.DisciplineID " .
					"WHERE subjecttoteach.TeacherID = '" . $_POST["TeacherID"] . "'");
		if(!$con->IsEmptySet())
		{
			$res = $con->GetAll();
			for($i = count($res) - 1; $i >= 0; $i--)
				$result[] = array("SectionID" => $res[$i]["SectionID"], "SubjectID" => $res[$i]["SubjectID"], "Name" => $res[$i]["DisciplineCode"] . "-" . $res[$i]["Semester"] . $res[$i]["SectionCode"]);
			$output[] = $result;
			jprint($output);
		}
		else jerror("No Section Alotted.");
		
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>