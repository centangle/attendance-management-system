 <?php	
	// By Bilal Ahmad
	// mark class attendant
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["ClassID"] = "1";
		//$_POST["SlotID"] = "1";
		//$_POST["Status"] = "0";
		
		checkPost($_POST, array("ClassID", "SlotID", "Status"));	
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$_POST["Status"] = $_POST["Status"] == "true" ? "1" : "0";
		$day = date("N");				// get day of current
		date_default_timezone_set('UTC');
		$time = date(FORMAT_TIME, time() + (5 * 60 * 60));
		$date = date(FORMAT_DATE);
		
		$con->Query("SELECT Day FROM  slot " .
					"WHERE  SlotID = '" . $_POST['SlotID'] . "' " .
					"AND Day = '$day' " .
					"AND StartTime <= '$time' " .
					"AND EndTime >= '$time'"); // validate time
		if(!$con->IsEmptySet())
		{
			$con->QueryWS("DELETE FROM classattendance  " .	// delete existed attendance
						"WHERE ClassID = '" . $_POST['ClassID'] . "' " .
						"AND SlotID = '" . $_POST['SlotID'] . "' " .
						"AND Date = '$date'");
			$res = $con->QueryWS("INSERT INTO classattendance (ClassID, SlotID, Date, Status) " .	// insert attendance
						"VALUES ('" . $_POST['ClassID'] . "', '" . $_POST['SlotID'] . "', '$date', b'" . $_POST['Status'] . "')");
			if($res === false) jerror("Cannot mark atendance");
			else 
			{
				if($_POST["Status"] == "0")
				{
					// get teacher data
					$con->Query("SELECT DISTINCT teacher.MobileNumber, teacher.Name " .
								"FROM teacher JOIN subjecttoteach " .
								"ON teacher.TeacherID = subjecttoteach.TeacherID " .
								"WHERE subjecttoteach.ClassID = '" . $_POST["ClassID"] . "'");
					$row = $con->GetAssoc();
					$number = $row["MobileNumber"];
					$name = $row["Name"];
					$con->Query("SELECT StartTime, EndTime FROM slot WHERE SlotID = '" . $_POST["SlotID"] . "'");
					$row = $con->GetAssoc();
					sendSMS($number, "Mr/Ms. " . $name . ", you did not take today's lecture on " . $row["StartTime"] . 
									 " to " . $row["EndTime"] . ". Report to department as soon as possible.");
				}
				$output[][] = array("Success" => "Attendance has been marked");	// make output structured
				jprint($output);												// print output
			}
		}
		else jerror("Out of time Attendance not allowed");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>