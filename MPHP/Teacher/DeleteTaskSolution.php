<?php	
	// By Bilal Ahmad
	// set the teacher profile data
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["TaskID"] = '3';
		//$_POST["SolutionID"] = '1';
		checkPost($_POST, array("TaskID", "SolutionID"));	
		Verify($_POST);				 	// verifying requester
		extract($_POST);
		
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT FileName FROM content " .
					"WHERE ContentID = '$SolutionID'");
		$row = $con->GetAssoc();
		$FileName = DIR_CONTENT + $row["FileName"];
		if(file_exists($FileName))		// check file already exist
			unlink($FileName);
		$con->QueryWS("UPDATE task SET SolutionID = null WHERE TaskID = '$TaskID'");
		$con->QueryWS("DELETE FROM content WHERE ContentID = '$SolutionID'");
		jsuccess("Solution has been deleted.");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
?>