 <?php	
	// By Bilal Ahmad
	// Set Task details
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["Values"] = '{"IssueDate":"5\/3\/2013","DueDate":"5\/4\/2013"}';
		//$_POST["TaskID"] = '3';
		
		checkPost($_POST, array("TaskID", "Values"));	
		Verify($_POST);				 	// verifying requester
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
			
			// validating
			if(isset($IssueDate) && isset($DueDate))
			{
				$today = strtotime(date(FORMAT_DATE));
				$id = strtotime($IssueDate);
				if($id > $today) throw new Exception("Issue Date must not greater than today");
				if($DueDate != "null")
				{
					$dd = strtotime($DueDate);
					if($id >= $dd) throw new Exception("Due Date must be greater than IssueDate");
				}
			}	
			// verify marks are greater than marked one
			if(isset($TotalMarks))
			{
				$con->Query("SELECT count(1) AS Count FROM marks " .
							"WHERE TaskID = '$TaskID' " .
							"AND ObtainedMarks > '$TotalMarks'");
				$row = $con->GetAssoc();
				if($row["Count"] != "0")
					throw new Exception("Obtained marks cannot be less than marked marks.");
			}
			
			$con->QueryWS("UPDATE task SET " . implode(", ", $dataString) . " WHERE TaskID = '$TaskID'");// making query
			if($con->GetRowsEffected() == 0) jerror("Error Updating task");
			else jsuccess("task has been updated");
		}
		else jerror("Update task not allowed");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>