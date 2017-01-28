 <?php	
	// By Bilal Ahmad
	// Get the attendant login
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["Username"] = "arslankhalid@msis.com";
		//$_POST["Password"] = "1";
		checkPost($_POST, array("Username", "Password"));	
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT AttendentID AS AttendantID, Name, RoomID, Image FROM attendent WHERE Username = '" . $_POST["Username"] . "' AND Password = '" . $_POST["Password"] . "'");// making query
		$row = $con->GetAssoc();		// get rows
		
		if($row === false)
			throw new Exception("Invalid username or password");
		else
		{
			writeLog($con, "Attendant", $row["AttendantID"], "Login from mobile");
			$attendant[] = array("AttendantID" => $row["AttendantID"], 
						"Name" => $row["Name"],
						"RoomID" => $row["RoomID"],						
						"Image" => getEncodedFile(DIR_ATTENDANT_IMAGE . $row["Image"])); // get student rec
			$output[] = $attendant;
			jprint($output); 			// send results
		}
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>