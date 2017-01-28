 <?php	
	// By Bilal Ahmad
	// Get the class atttendance data
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		
		checkPost($_POST, array("RoomID"));	
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$day = date("N");				// get day of current
		date_default_timezone_set('UTC');
		$time = date("H:i", time() + (5 * 60 * 60));
		
		$con->Query("SELECT slot.SlotID, slot.Day, slot.EndTime, slot.StartTime, timetable.ClassID FROM slot JOIN timetable " .
						"ON slot.SlotID = timetable.SlotID " .
						"WHERE timetable.RoomID = '" . $_POST["RoomID"] . "' " .
						"AND slot.Day = '" . $day . "' " .
						"AND slot.StartTime <= '" . $time . "' " .
						"AND slot.EndTime >= '" . $time . "'"); 	// getting start time of all lectures to be taken on this day
		if($_POST["RoomID"] == "null")
			jerror("No room assigned");
		else if(!$con->IsEmptySet())
		{
			$class = $con->GetAssoc();						// get table
			$con->Query("SELECT subject.Name FROM subject JOIN  class " .
							"ON subject.SubjectID = class.SubjectID " .
							"WHERE class.ClassID = '" . $class["ClassID"] . "'");
			$row = $con->GetAssoc();
			$class["Subject"] = $row["Name"];
			
			$output[][] = $class;							// make output structured
			jprint($output);								// print output
		}
		else jerror("No class to mark.");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>