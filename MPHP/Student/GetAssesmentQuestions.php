 <?php	
	// By Bilal Ahmad
	// Get the assesment questions
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["StudentID"] = "1";
		//$_POST["SubjectID"] = "39";
		//$_POST["FetchQuestions"] = "true";
		checkPost($_POST, array("StudentID", "SubjectID", "FetchQuestions"));
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		// check for open or close
		$con->Query("SELECT Value FROM criteria WHERE Entity='Assesment'");
		$row = $con->GetAssoc();
		$status = $row["Value"];
		if($status != "Open")
			throw new exception("Subject assesment not open.");
		
		$con->Query("SELECT AssesmentID FROM assesment " .				// checking is assement already done
					"WHERE SubjectID = '" . $_POST["SubjectID"] . "' " .
					"AND StudentID = '" . $_POST["StudentID"] . "'");
		if(!$con->IsEmptySet())
			throw new Exception ("Assesment alredy done of this subject");
		if($_POST["FetchQuestions"] == "true")							// get questions if requested
		{
			$con->Query("SELECT QuestionDetail, QuestionID FROM question");
			if(!$con->IsEmptySet())
			{
				$output[] = $con->GetAll();
				jprint($output);
			}
			else jerror("No Questions uploaded");
		}
		else jsuccess("Valid subject for assesment");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>