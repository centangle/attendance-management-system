 <?php	
	// By Bilal Ahmad
	// Get the student login page data
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");			// including common functions
		Verify($_POST);						// verifying requester
		$con = new Connection();			// making connection object
		$con->start();						// initializing connection
		$con->Query("SELECT * FROM session");// making query
		while($row = $con->GetAssoc())		// binding rows
			$sessionArr[] = $row;
		$con->Query("SELECT DisciplineID, DisciplineCode FROM discipline");// making query
		while($row = $con->GetAssoc())		// binding rows
			$disciplineArr[] = $row;
		$output[] = $sessionArr;			// Making result	
		$output[] = $disciplineArr;
		jprint($output); 					// sending json object
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());			// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 					// closing connection
 ?>