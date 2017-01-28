 <?php	
	// By Bilal Ahmad
	// Add task of a teacher
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		/*$_POST["SubjectID"] = "39";
		$_POST["SectionID"] = "1";
		$_POST["IssueDate"] = "3/4/2013";
		$_POST["DueDate"] = "3/4/2013";
		$_POST["Description"] = "as";
		$_POST["Title"] = "aaaa";
		$_POST["TeacherID"] = "1";
		$_POST["TotalMarks"] = "10";*/
		
		checkPost($_POST, array("TeacherID", "TaskType", "Title", "TotalMarks", "IssueDate", "DueDate", "Description", "SectionID", "SubjectID"));
		Verify($_POST);				 	// verifying requester
		
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
		$row = $con->GetAssoc();
		$add = $row["Value"];
		
		if($add == "Open")
		{
			extract($_POST);
			
			// validating
			$today = strtotime(date(FORMAT_DATE));
			$id = strtotime($IssueDate);
			
			if($id > $today) throw new Exception("Issue Date must not greater than today");
			if($DueDate != "null")
			{
				$dd = strtotime($DueDate);
				if($id >= $dd) throw new Exception("Due Date must be greater than IssueDate");
			}
			
			$con->Query("SELECT DISTINCT ClassID FROM class " .
						"WHERE SubjectID = '$SubjectID' " .
						"AND SectionID = '$SectionID'");
			$row = $con->GetAssoc();
			$ClassID = $row["ClassID"];
			
			if($ClassID != null)
			{
				$con->Query("INSERT INTO task " .
							"(Title, TaskType, IssueDate, DueDate, Description, TotalMarks, TeacherID, ClassID) " .
							"VALUES " .
							"('$Title', '$TaskType', '$IssueDate', '$DueDate', '$Description', '$TotalMarks', '$TeacherID', '$ClassID')");
				if($con->GetRowsEffected() == 0) throw new Error ("Unexpected error occured");
				else 
				{
					writeLog($con, "Teacher", $TeacherID, "Add a task.");
					jsuccessWithID("Task added successfully", $con->GetID());
				}
			}
			else jerror("Invalid section selected");
		}
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>