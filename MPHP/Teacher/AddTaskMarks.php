 <?php	
	// By Bilal Ahmad
	// Set marks of task
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["TaskID"] = "1";
		//$_POST["Values"] = '[{"ObtainedMarks":"10","StudentID":"1"},{"ObtainedMarks":"30","StudentID":"30"}]';
		
		checkPost($_POST, array("TaskID", "TeacherID", "Values"));
		Verify($_POST);				 	// verifying requester
		extract($_POST);
		
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
		$row = $con->GetAssoc();
		$add = $row["Value"];
		
		if($add == "Open")
		{
			$con->Query("SELECT Value FROM criteria WHERE Entity = 'LowMarks'");
			$row = $con->GetAssoc();
			$lowmarks = (int)$row["Value"];
			
			$con->Query("SELECT TotalMarks, Title FROM task WHERE TaskID = '$TaskID'");
			$row = $con->GetAssoc();
			$total = (int)$row["TotalMarks"];
			$title = $row["Title"];
			
			// Get students
			$data = json_decode($Values, true);
			$cmd = "";
			for($i = count($data) - 1; $i >= 0; $i--) // making multi insert
			{
				$cmd .= "('$TaskID', '" . $data[$i]["StudentID"] . "', '" . $data[$i]["ObtainedMarks"] . "')";
				if($i != 0) 
					$cmd .= ", ";
					
				// send notification
				$con->Query("SELECT MobileNumber, Name FROM student WHERE StudentID = '" . $data[$i]["StudentID"] . "'");
				$row = $con->GetAssoc();
				sendSMS($row["MobileNumber"], "Dear " . $row["Name"] . ', marks has been uploaded of task "' . $title . '"');
				if(((int)$data[$i]["ObtainedMarks"] / $total * 100) < $lowmarks)
				{
					$con->Query("SELECT MobileNumber FROM parentinfo WHERE ParentInfoID = '" . $data[$i]["StudentID"] . "'");
					sendSMS($row["MobileNumber"], "Dear parents of " . $row["Name"] . ", " .
												  "your child get marks lower than " . $lowmarks . "% " .
												  'of task "' . $title .'"');
				}
			}
			// inserting
			$con->QueryWS("INSERT INTO marks (TaskID, StudentID, ObtainedMarks) Values " . $cmd);
			if($con->GetRowsEffected() == 0) jerror("Unexpected error occured");
			else 
			{
				writeLog($con, "Teacher", $TeacherID, "Add marks of task");
				jsuccess("Marks successfully marked.");
			}
		}
		else jerror("Adding marks not allowed");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>