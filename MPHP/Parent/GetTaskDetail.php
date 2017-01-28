 <?php	
	// By Bilal Ahmad
	// Get the student detail of cources
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		checkPost($_POST, array("StudentID", "TaskID"));
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection

		// query data and make output
		$res = array();
		$con->Query("SELECT * FROM task WHERE TaskID = '" . $_POST["TaskID"] . "'");
		if(!$con->IsEmptySet())			// chek for no error	
		{
			$res = $con->GetAssoc();
			$con->Query("SELECT ObtainedMarks FROM marks WHERE TaskID = '" . $_POST["TaskID"] . "' AND StudentID = '" . $_POST["StudentID"] . "'");
			$row = $con->GetAssoc();
			if($row === false) $res["ObtainedMarks"] = "N/A";
			else $res["ObtainedMarks"] = $row["ObtainedMarks"];
			$result[] = $res;
			$output[] = $result;
		}
		else $output = array();
		jprint($output); 				// send results
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>