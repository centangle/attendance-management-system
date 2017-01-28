 <?php	
	// By Bilal Ahmad
	// Set detail of a lecture
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["Values"] = '{"Date":"05\/7\/2013","EndTime":"11:00:00","StartTime":"08:00:00","Lab":"true"}';
		//$_POST["LectureID"] = '3';
		
		checkPost($_POST, array("ArticleID", "Values"));	
		Verify($_POST);				 		// verifying requester
		extract($_POST);
		
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
		$y = $con->GetAssoc();
		$add = $y["Value"];
		
		if($add == "Open")
		{
			$data = null;
			$dataArray = json_decode($Values);	// get sql string
			$dataString = makeAssocAsignStrings($dataArray, $data);
			extract($data);
			
			$con = new Connection();		// making connection object
			$con->start();					// initializing connection
			
			$con->QueryWS("UPDATE article SET " . implode(", ", $dataString) . " WHERE ArticleID = '$ArticleID'");// making query
			if($con->GetRowsEffected() == 0) jerror("Unexpected error occured");
			jsuccess("Article has been updated");
		}
		else jerror("Update article not allowed");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>