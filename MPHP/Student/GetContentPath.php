 <?php	
	// By Bilal Ahmad
	// Get the content path
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		
		checkPost($_POST, array("ContentID"));
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		
		$res = array();
		$con->Query("SELECT FileName FROM content WHERE ContentID = '" . $_POST["ContentID"] . "'");
		if($con->IsEmptySet())
			throw new Exception("File not found");
			
		$res = $con->GetAssoc();
		$res = DIR_CONTENT . $res["FileName"];
		$result[]["FileName"] = $res;
		$output[] = $result;
		jprint($output); 				// send results
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>