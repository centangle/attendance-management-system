<?php	
	// By Bilal Ahmad
	// set the teacher profile data
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions

		checkPost($_POST, array("TeacherID", "Columns", "Values"));	
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$strs = makeAsignStrings(json_decode($_POST["Columns"]), json_decode($_POST["Values"]));
		$con->QueryWS("UPDATE teacher SET " . implode(", ", $strs) . " WHERE TeacherID = '" . $_POST["TeacherID"] . "'");// making query
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