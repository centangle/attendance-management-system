 <?php	
	// By Bilal Ahmad
	// get free rooms
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["Values"] = '{"Day":"1","Lab":"true"}';
		
		checkPost($_POST, array("Values"));
		Verify($_POST);					// verifying requester
		extract($_POST);
		
		$Values = json_decode($Values, true);
		extract($Values);
		
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'ShowTimetable'");
		$y = $con->GetAssoc();
		if ($y["Value"] == "Close")
			throw new Exception("View room status not open");
		
		$Lab = $Lab == "true" ? "1" : "0";
		$con->Query("SELECT r.RoomID, t.SlotID " .
					"FROM room r LEFT JOIN timetable t " .
					"ON r.RoomID = t.RoomID " .
					"WHERE r.Lab = '$Lab'");
		if(!$con->IsEmptySet())
		{
			$rooms = $con->GetAll();
			$i = count($rooms) - 1;
			$day = isset($Day) ? "AND Day = '$Day'" : "";
			while($i >= 0)
			{
				// get room info
				$con->Query("SELECT DISTINCT room.RoomID, room.RoomCode, room.Floor, room.Lab, block.Name AS BlockName " .
							"FROM room JOIN block " .
							"ON room.BlockID = block.BlockID " .
							"WHERE room.RoomID = '" . $rooms[$i]["RoomID"] . "'");
				$room = $con->GetAssoc();
				$room["Lab"] = $room["Lab"] == "0" ? "No" : "Yes";
				
				// get free rooms
				$slots = getColumnArrayIf($rooms, "SlotID", "RoomID", $rooms[$i]["RoomID"]);
				if($slots[0] != null)
				{
					$con->Query("SELECT Day, StartTime AS Start, EndTime AS End " .
								"FROM slot " .
								"WHERE SlotID NOT IN (" . implode(", ", $slots) . ") " .
								$day);
					if(!$con->IsEmptySet())
					{
						$free = $con->GetAll();
						while($row = current($free))	 // merging
						{
							copyItems($row, $room, array("RoomCode", "Floor", "Lab", "BlockName"));
							$row["Day"] = getDay($row["Day"]);
							$result[] = $row;
							next($free);
						}
					}
				}
				else
				{
					$row = array();
					copyItems($row, $room, array("RoomCode", "Floor", "Lab", "BlockName"));
					$row["Start"] = "*";
					$row["End"] = "*";
					$row["Day"] = "*";
					$result[] = $row;
				}
				$i -= count($slots);
			}
			if(isset($result))
			{
				$output[] = $result;
				jprint($output);
			}
			else jerror("No free rooms.");
		}
		else jerror("All rooms are free");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection
 ?>