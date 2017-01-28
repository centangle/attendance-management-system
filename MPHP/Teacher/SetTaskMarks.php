 <?php	
	// By Bilal Ahmad
	// Set marks of task
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["TaskID"] = "1";
		//$_POST["Values"] = '[{"ObtainedMarks":"12","StudentID":"1"},{"ObtainedMarks":"30","StudentID":"30"}]';
		
		checkPost($_POST, array("TaskID", "Values"));
		Verify($_POST);				 	// verifying requester
		extract($_POST);
		
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
		$y = $con->GetAssoc();
		$add = $y["Value"];
		
		if($add == "Open")
		{
			// Get students
			$data = json_decode($Values, true);
			$cmd = "";
			$done = 0;
			
			$con->Query("SELECT Value FROM criteria WHERE Entity = 'LowMarks'");
			$lowmarks = (int)$y["Value"];
			
			$con->Query("SELECT TotalMarks, Title FROM task WHERE TaskID = '$TaskID'");
			$row = $con->GetAssoc();
			$total = (int)$row["TotalMarks"];
			$title = $row["Title"];
			
			for($i = count($data) - 1; $i >= 0; $i--) // making multi insert
			{
				$con->QueryWS("UPDATE marks SET ObtainedMarks = '" . $data[$i]["ObtainedMarks"] . "' " .
							  "WHERE TaskID = '$TaskID' AND StudentID = '" . $data[$i]["StudentID"] . "'");
				if($con->GetRowsEffected() != 0)
					$done++;
					
				// send notification
				$con->Query("SELECT MobileNumber, Name FROM student WHERE StudentID = '" . $data[$i]["StudentID"] . "'");
				$row = $con->GetAssoc();
				sendSMS($row["MobileNumber"], "Dear " . $row["Name"] . ', marks has been updated of task "' . $title . '"');
				if(((int)$data[$i]["ObtainedMarks"] / $total * 100) < $lowmarks)
				{
					$con->Query("SELECT MobileNumber FROM parentinfo WHERE ParentInfoID = '" . $data[$i]["StudentID"] . "'");
					sendSMS($row["MobileNumber"], "Dear parents of " . $row["Name"] . ", " .
												  "your child get marks lower than " . $lowmarks . "% " .
												  'of task "' . $title .'"');
				}
			}
			if($done == 0) jerror("Unable to update marks.");
			else jsuccess("marks updated successfully.");
		}
		else jerror("Updating marks not allowed");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>