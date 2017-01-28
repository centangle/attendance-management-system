 <?php	
	// By Bilal Ahmad
	// Get the profile data attendant
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		
		checkPost($_POST, array("AttendantID"));	
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT Name, RoomID, Username, Email, PhoneNumber, MobileNumber FROM attendent WHERE AttendentID = '" . $_POST["AttendantID"] . "'");// making query
		$about = $con->GetAssoc();		// get row
		if($about["RoomID"])
		{
			$con->Query("SELECT room.RoomCode, room.Floor, block.Name FROM room JOIN block " .
						"ON room.BlockID = block.BlockID " .
						"WHERE room.RoomID = '" . $about["RoomID"] . "'");
			$room = $con->GetAssoc();
		}
		if($room)
		{
			$about["Room"] = $room["RoomCode"];
			$about["Floor"] = $room["Floor"];
			$about["Block"] = $room["Name"];
		}
		else
		{
			$about["Room"] = "N/A";
			$about["Floor"] = "N/A";
			$about["Block"] = "N/A";
		}
		unset($about["RoomID"]);
		$output[][] = $about;	// get rows
		jprint($output);
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>