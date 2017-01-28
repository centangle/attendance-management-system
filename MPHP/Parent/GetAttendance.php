 <?php	
	// By Bilal Ahmad
	// Get the student cources attendance
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["StudentID"] = "1";
		//$_POST["SubjectID"] = "39";
		//$_POST["SectionID"] = "1";
		checkPost($_POST, array("StudentID", "SubjectID", "SectionID"));
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection

		// query data and make output
		$res = array();
		$con->Query("SELECT lecture.LectureID, Date FROM lecture JOIN class ON lecture.ClassID = class.ClassID AND " .
																		"class.SectionID = '" . $_POST["SectionID"] . "' AND " .
																		"class.SubjectID = '" . $_POST["SubjectID"] . "'");
		if(!$con->IsEmptySet())			// chek for no error	
		{
			$lectures = $con->GetAll();
			$lecCount = count($lectures);
			for($i = 0; $i < $lecCount; $i++) // get attendance status of a statement
			{
				$con->Query("SELECT  Present FROM attendance WHERE LectureID = '" . $lectures[$i]["LectureID"] . "' AND " .
															" StudentID = '" . $_POST["StudentID"] . "'");
				
				$row = $con->GetAssoc();
				$pres = "N/A";	// make formate
				if(!$con->IsEmptySet()) $pres = $row["Present"] == "1" ? "P" : "A";
				$result[] = array("LectureID" => $lectures[$i]["LectureID"], "Date" => $lectures[$i]["Date"], "Present" => $pres);
			}
			$output[] = $result;
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