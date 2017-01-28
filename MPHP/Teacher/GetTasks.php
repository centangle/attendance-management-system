 <?php	
	// By Bilal Ahmad
	// Get Tasks
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["SubjectID"] = '39';
		//$_POST["SectionID"] = '1';
		//$_POST["Type"] = 'a';
		checkPost($_POST, array("Type", "SubjectID", "SectionID"));
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection

		// query data and make output
		$res = array();
		$con->Query("SELECT TaskID, Title, IssueDate FROM task JOIN class " .
					"ON task.ClassID = class.ClassID " .
					"AND class.SectionID = '" . $_POST["SectionID"] . "' " .
					"AND class.SubjectID = '" . $_POST["SubjectID"] . "' " .
					"AND task.TaskType = '" . $_POST["Type"] . "' ");
		if(!$con->IsEmptySet())			// chek for no error	
		{
			$output[] = $con->GetAll();
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