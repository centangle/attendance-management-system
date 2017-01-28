 <?php	
	// By Bilal Ahmad
	// get article update
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["TeacherID"] = '1';
		
		checkPost($_POST, array("TeacherID"));
		Verify($_POST);				 				// verifying requester
		extract($_POST);
		
		$con = new Connection();					// make connections
		$con->Start();								// start connection
		
		// check for portal alow
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
		$row = $con->GetAssoc();
		if($row["Value"] == "Close")
			throw new Exception("Adding article not allowed");
		
		$con->Query("SELECT ArticleID, Title FROM article " .
					"WHERE TeacherID = '$TeacherID'");
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