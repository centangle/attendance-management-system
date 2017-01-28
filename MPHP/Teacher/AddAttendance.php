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
		checkPost($_POST, array("TeacherID", "LectureID", "StudentIDs", "Status"));
		Verify($_POST);				 				// verifying requester
		extract($_POST);
		
		$con = new Connection();					// make connections
		$con->Start();								// start connection
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
		$row = $con->GetAssoc();
		$add = $row["Value"];
		
		if($add == "Open")
		{
			$studentIDs = json_decode($_POST["StudentIDs"]);
			$status = json_decode($_POST["Status"]);
			
			$insSt = "";
			for($i = count($studentIDs) - 1; $i >= 0; $i--)
			{
				$insSt .= "('" . $_POST["LectureID"] . "', '" . $studentIDs[$i] . "', b'" . $status[$i] . "')";
				if($i != 0)
					$insSt .= ", ";
			}
			$con->Query("INSERT INTO attendance (LectureID, StudentID, Present) VALUES $insSt");
			if($con->GetRowsEffected() == 0)
				jerror("Error adding attendance");
			else
			{
				writeLog($con, "Teacher", $TeacherID, "Add an attendance");
				jsuccess("Attendance added");
			}
		}
		else jerror("Add attendance not allowed");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>