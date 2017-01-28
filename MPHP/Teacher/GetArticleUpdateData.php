 <?php	
	// By Bilal Ahmad
	// Uploads a file of a lecture
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["ArticleID"] = '1';
		
		checkPost($_POST, array("ArticleID"));
		Verify($_POST);				 				// verifying requester
		extract($_POST);
		
		$con = new Connection();					// make connections
		$con->Start();								// start connection
		
		// check for portal alow
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
		$row = $con->GetAssoc();
		if($row["Value"] == "Close")
			throw new Exception("Updating article not allowed");
		
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'UploadFileSize'");
		$row = $con->GetAssoc();
		$validSize = $row["Value"];		// get size
		$con->Query("SELECT Title, Whom, Description, ContentID FROM article " .
					"WHERE ArticleID = '$ArticleID'"); // get details
		if(!$con->IsEmptySet())
		{
			$output[] = $con->GetAll();
			$output[0][0]["Length"] = $validSize;
			jprint($output);
		}
		else jerror("No articles found with this title.");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>