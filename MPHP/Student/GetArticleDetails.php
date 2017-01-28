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
		$con->Query("SELECT Title, Whom, Description, ContentID FROM article " .
					"WHERE ArticleID = '$ArticleID'");
		if(!$con->IsEmptySet())
		{
			$output[] = $con->GetAll();
			$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
			$row = $con->GetAssoc();
			$output[0][0]["Update"] = $row["Value"];
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