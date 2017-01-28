 <?php	
	// By Bilal Ahmad
	// Get the student task of selected cources
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		
		checkPost($_POST, array("SubjectID", "SectionID", "TaskType"));
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		
		// query data
		$con->Query("SELECT TaskID, Title, DueDate FROM task JOIN class ON class.ClassID = task.ClassID AND class.SubjectID = '"
								. $_POST["SubjectID"] . "' AND class.SectionID = '" . $_POST["SectionID"] . "' AND task.TaskType = '" . $_POST["TaskType"] . "'");
		
		if(!$con->IsEmptySet())			// check no results
		{	
			while($row = $con->GetAssoc())
				$result[] = $row;		// add in array
			
			$output[] = $result;
			jprint($output); 				// send results
		}
		else
			jerror("Task not uploaded");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>