 <?php	
	// By Bilal Ahmad
	// Set the student  profile data
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["Columns"] = '["PhoneNumber"]';
		//$_POST["Values"] = '["0516571880"]';
		//$_POST["StudentID"] = "1";
		
		checkPost($_POST, array("StudentID", "Columns", "Values"));	
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		
		$strs = makeAsignStrings(json_decode($_POST["Columns"]), json_decode($_POST["Values"]));
		$con->QueryWS("UPDATE student SET " . implode(", ", $strs) . " WHERE StudentID = '" . $_POST["StudentID"] . "'");// making query
		if($con->GetRowsEffected() == 1)
		{
			$result["Success"] = "Successfully Updated";
			$output[][] = $result;
			jprint($output);
		}
		else
			jprint("Problem occured during update");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>