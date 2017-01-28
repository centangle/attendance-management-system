 <?php	
	// By Bilal Ahmad
	// Add lecture of a teacher
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//[TeacherID=1, Title=vhh, Date=05/13/2013, StartTime=15:00:00, EndTime=16:30:00, Description=aya, Lab=false, SectionID=1, SubjectID=40]
		/*$_POST["SubjectID"] = "40";
		$_POST["SectionID"] = "1";
		$_POST["Date"] = "05/13/2013";
		$_POST["StartTime"] = "15:00:00";
		$_POST["EndTime"] = "16:30:00";
		$_POST["Description"] = "as";
		$_POST["Title"] = "aaaa";
		$_POST["Lab"] = "false";
		$_POST["TeacherID"] = "1";*/
		
		checkPost($_POST, array("Title", "Date", "StartTime", "TeacherID", "Lab", "EndTime", "Description", "SectionID", "SubjectID"));
		Verify($_POST);				 	// verifying requester
		extract($_POST);
		
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
		$row = $con->GetAssoc();
		$add = $row["Value"];
		
		if($add == "Open")
		{
			// validating
			date_default_timezone_set('UTC');
			$now = strtotime(date(FORMAT_TIME, time() + (5 * 60 * 60)));
			$start = strtotime($StartTime);
			$end = strtotime($EndTime);
			$today = strtotime(date(FORMAT_DATE));
			$lectureDate = strtotime($Date);
			
			if($lectureDate > $today) throw new Exception("Invalid date entered");
			if($start >= $end) throw new Exception("Start time must be less than end time ");
			if($lectureDate == $today) if($start >= $now || $end >= $now) throw new Exception("Start time and end time must be less than now");
			$minHourLimit = $Lab == "true" ? 10800 : 3600;
			$duration = ($end - $start);
			if($duration < $minHourLimit) throw new Exception("Lecture duration is invalid");
			
			$con->Query("SELECT DISTINCT ClassID FROM class " .
						"WHERE SubjectID = '$SubjectID' " .
						"AND SectionID = '$SectionID'");
			$row = $con->GetAssoc();
			$ClassID = $row["ClassID"];
			if($ClassID != null)
			{
				$con->Query("SELECT count(1) AS Count FROM lecture " .
							"WHERE Date = '$Date' " .
							"AND ClassID = '$ClassID' " .
							"AND ((StartTime <= '$StartTime' AND EndTime >= '$StartTime') " .
							"OR (StartTime <= '$EndTime' AND EndTime >= '$EndTime') " .
							"OR (StartTime >= '$StartTime' AND EndTime <= '$EndTime') " .
							"OR (StartTime = '$EndTime' AND EndTime = '$EndTime'))");
				
				$row = $con->GetAssoc();
				if($row["Count"] == "0")
				{					
					$Lab = $Lab == "true" ? "1" : "0";
					$con->Query("INSERT INTO lecture " .
								"(Title, Date, StartTime, EndTime, Description, ClassID, Lab) " .
								"VALUES " .
								"('$Title', '$Date', '$StartTime', '$EndTime', '$Description', '$ClassID', b'$Lab')");
					if($con->GetRowsEffected() == 0) throw new Error ("Unexpected error occured");
					else 
					{
						writeLog($con, "Teacher", $TeacherID, "Add a lecture");
						jsuccessWithID("Lecture added successfully", $con->GetID());
					}
				}
				else jerror("Invalid timmings.");
			}
			else jerror("Invalid section selected");
		}
		else jerror("Add lecture not allowed.");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>