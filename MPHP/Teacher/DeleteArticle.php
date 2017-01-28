 <?php	
	// By Bilal Ahmad
	// Uploads a file of a lecture
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["ArticleID"] = '2';
		
		checkPost($_POST, array("ArticleID"));
		Verify($_POST);				 				// verifying requester
		extract($_POST);
		
		$con = new Connection();					// make connections
		$con->Start();								// start connection
		$con->Query("SELECT ContentID FROM article " .
					"WHERE ArticleID = '$ArticleID'");
		if(!$con->IsEmptySet())
		{
			$row = $con->GetAssoc();
			$ContentID = $row["ContentID"];
			if($ContentID != "null")
			{
				$con->Query("SELECT FileName FROM content " .
					"WHERE ContentID = '$ContentID'");
				$row = $con->GetAssoc();
				$FileName = DIR_CONTENT + $row["FileName"];
				if(file_exists($FileName))		// check file already exist
					unlink($FileName);
				$con->QueryWS("DELETE FROM content WHERE ContentID = '$ContentID'");
			}
			$con->QueryWS("DELETE FROM article WHERE ArticleID = '$ArticleID'");
			jsuccess("Article deleted");
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