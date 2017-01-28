 <?php	
	// By Bilal Ahmad
	// Set detail of a lecture
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["Values"] = '{"Date":"05\/7\/2013","EndTime":"11:00:00","StartTime":"08:00:00","Lab":"true"}';
		//$_POST["LectureID"] = '3';
		
		checkPost($_POST, array("LectureID", "Values"));	
		Verify($_POST);				 		// verifying requester
		extract($_POST);
		
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
		$y = $con->GetAssoc();
		$add = $y["Value"];
		
		if($add == "Open")
		{
			$data = null;
			$dataArray = json_decode($Values);	// get sql string
			$dataString = makeAssocAsignStrings($dataArray, $data);
			extract($data);
			
			$con = new Connection();		// making connection object
			$con->start();					// initializing connection
			
			// validating
			if(isset($StartTime) && isset($EndTime) && isset($Date))
			{
				// calculate times
				date_default_timezone_set('UTC');
				$now = strtotime(date(FORMAT_TIME, time() + (5 * 60 * 60)));
				$start = strtotime($StartTime);
				$end = strtotime($EndTime);
				$today = strtotime(date(FORMAT_DATE));
				$lectureDate = strtotime($Date);
				
				// validating date time
				if($lectureDate > $today) throw new Exception("Date cannot be greater than today");
				if($start >= $end) throw new Exception("Start time must be less than end time ");
				if($lectureDate == $today) if($start >= $now || $end >= $now) throw new Exception("Start time and end time must be less than now");
				
				// validate duration 
				$minHourLimit = $Lab == "true" ? 10800 : 3600;
				$duration = ($end - $start);
				if($duration < $minHourLimit) throw new Exception("Lecture duration is invalid");
				
				$con->Query("SELECT ClassID FROM lecture " .
							"WHERE LectureID = '$LectureID'");
				$y = $con->GetAssoc();
				$ClassID = $y["ClassID"];
				if($ClassID != null)
				{
					$con->Query("SELECT count(1) AS Count FROM lecture " .
								"WHERE Date = '$Date' " .
								"AND ClassID = '$ClassID' " .
								"AND ((StartTime <= '$StartTime' AND EndTime >= '$StartTime') " .
								"OR (StartTime <= '$EndTime' AND EndTime >= '$EndTime') " .
								"OR (StartTime >= '$StartTime' AND EndTime <= '$EndTime') " .
								"OR (StartTime = '$EndTime' AND EndTime = '$EndTime'))");
					
					$y = $con->GetAssoc();
					if($y["Count"] != "0")
						throw new Exception("Invalid timming.");
				}
				else throw new Exception("Invalid lecture selected.");
			}
			$con->QueryWS("UPDATE lecture SET " . implode(", ", $dataString) . " WHERE LectureID = '$LectureID'");// making query
			if($con->GetRowsEffected() == 0) jerror("Unexpected error occured");
			jsuccess("Lecture has been updated");
		}
		else jerror("Update lecture not allowed");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>