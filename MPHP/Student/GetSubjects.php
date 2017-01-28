 <?php	
	// By Bilal Ahmad
	// Get the student current subject code
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		
		checkPost($_POST, array("StudentID"));
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		
		// fetching subjects information save record in one array of subject and section
		$con->Query("SELECT * FROM subjecttostudy WHERE StudentID = '" . $_POST["StudentID"] . "'");
		if(!$con->IsEmptySet())
		{
			while($row = $con->GetAssoc()) $sts[] = $row;
			$subCount = count($sts);
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
			$output[] = $subjects;
		}
		else
			$output = array();
		jprint($output); 			// send results
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>