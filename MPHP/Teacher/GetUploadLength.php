 <?php	
	// By Bilal Ahmad
	// Gives the max lecture content size
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		Verify($_POST);				 	// verifying requester
		
		$con = new Connection();					// make connections
		$con->Start();								// start connection
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
		$y = $con->GetAssoc();
		$cud = $y["Value"];
		if($cud == "Open")
		{
			$con->Query("SELECT Value FROM criteria WHERE Entity = 'UploadFileSize'");
			$y = $con->GetAssoc();
			$validSize = $y["Value"];		// get size
			
			if($validSize != null)
			{	
				$output[][] = array("Length" => $validSize);
				jprint($output);
			}
			else jerror("Unexpected error occured");
		}
		else jerror("Add or Update not allowed");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>