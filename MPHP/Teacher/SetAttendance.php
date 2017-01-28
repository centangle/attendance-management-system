 <?php	
	// By Bilal Ahmad
	// get the attendance
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["LectureID"] = '3';
		//$_POST["StudentIDs"] = '["1"]';
		//$_POST["Status"] = '["1"]';
		checkPost($_POST, array("LectureID", "StudentIDs", "Status"));
		Verify($_POST);				 				// verifying requester
		extract($_POST);
		
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
		$y = $con->GetAssoc();
		$add = $y["Value"];
		
		if($add == "Open")
		{
			$studentIDs = json_decode($_POST["StudentIDs"]);
			$status = json_decode($_POST["Status"]);
			
			$total = count($studentIDs);
			$done = 0;
			for($i = $total - 1; $i >= 0; $i--)
			{
				$con->Query("UPDATE attendance SET Present = b'" . $status[$i] . "' " .
							"WHERE LectureID = '$LectureID' " .
							"AND StudentID = '" . $studentIDs[$i] . "'");
				if($con->GetRowsEffected() != 0)
					$done++;
			}
			if($done == 0) jerror("Error in update record");
			else if($done != $total)jsuccess($done . " out of " . $total . " is done.");
			else jsuccess("Attendance updated");
		}
		else jerror("Update attendance not allowed.");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>