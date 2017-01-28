 <?php	
	// By Bilal Ahmad
	// Get Task details
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["TaskID"] = '1';
		checkPost($_POST, array("TaskID"));
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		extract($_POST);
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
		$row = $con->GetAssoc();
		$update = $row["Value"];
		
		// query data and make output
		$res = array();
		$con->Query("SELECT Title, TotalMarks, IssueDate, DueDate, ContentID, SolutionID, Description " .
					"FROM task " .
					"WHERE TaskID = '$TaskID'");
		if(!$con->IsEmptySet())			// chek for no error	
		{
			$result = $con->GetAssoc();
			$con->Query("SELECT Value FROM criteria WHERE Entity = 'UploadFileSize'");
			if(!$con->IsEmptySet())
			{
				$row = $con->GetAssoc();
				$result["Length"] = $row["Value"];
				$result["Update"] = $update;
				// get size
				$output[][] = $result;
			}
			else $output = array();
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