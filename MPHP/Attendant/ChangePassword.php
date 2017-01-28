 <?php	
	// By Bilal Ahmad
	// change password to attendant
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		
		checkPost($_POST, array("AttendantID", "Password"));
		Verify($_POST);					// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		
		// get student email address
		$res = $con->QueryWS("UPDATE attendent SET Password = '" . $_POST["Password"] . "' WHERE AttendentID = '" . $_POST["AttendantID"] . "'");
		if($con->GetRowsEffected() == 0)// check for empty value
			throw new Exception("Error Changing Password");
		
		$result[] = array("Output" => "Password changed."); // make result
		$output[] = $result;		// attach result with output	
		jprint($output); 			// sending json object

	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection
 ?>