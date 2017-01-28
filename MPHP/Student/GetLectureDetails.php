 <?php	
	// By Bilal Ahmad
	// Get detail of a lecture
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["LectureID"] = "3";
		checkPost($_POST, array("LectureID"));
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection

		// query data and make output
		$res = array();	//detail from lecture table of a lecture
		$con->Query("SELECT Title, Date, StartTime, EndTime, Lab, Description, ContentID FROM lecture WHERE LectureID = '" . $_POST["LectureID"] . "'");
		if(!$con->IsEmptySet())			// chek for no error	
		{
			// format data
			$lec = $con->GetAssoc();
			$lec["Lab"] = $lec["Lab"] == "1" ? "Yes" : "No";
			$lec["Duration"] = (strtotime($lec["EndTime"]) - strtotime($lec["StartTime"])) /  (3600) . " Hours";
			$output[][] = $lec;
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