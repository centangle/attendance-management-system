 <?php	
	// By Bilal Ahmad
	// get article update
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["SectionID"] = '1';
		//$_POST["SubjectID"] = '40';
		
		checkPost($_POST, array("SectionID", "SubjectID"));
		Verify($_POST);				 				// verifying requester
		extract($_POST);
		
		$con = new Connection();					// make connections
		$con->Start();								// start connection
		
		// check for portal alow
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
		$row = $con->GetAssoc();
		if($row["Value"] == "Close")
			throw new Exception("Adding article not allowed");
		
		// get articles
		$con->Query("SELECT DISTINCT a.ArticleID, a.Title " .
					"FROM article a JOIN subjecttoteach s " .
					"ON a.TeacherID = s.TeacherID " .
					"JOIN class c " .
					"ON s.ClassID = c.ClassID " .
					"WHERE c.SubjectID = '$SubjectID' " .
					"AND c.SectionID = '$SectionID'");
		if(!$con->IsEmptySet())
		{
			$output[] = $con->GetAll();
			jprint($output);
		}
		else jerror("No articles added.");
		
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>