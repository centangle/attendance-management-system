 <?php	
	// By Bilal Ahmad
	// get the students for attendance
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["LectureID"] = '3';
		checkPost($_POST, array("LectureID"));
		Verify($_POST);				 				// verifying requester
		extract($_POST);
		
		$con = new Connection();					// make connections
		$con->Start();								// start connection
		$con->Query("SELECT Value FROM criteria WHERE Entity = 'CUD'");
		$row = $con->GetAssoc();
		$add = $row["Value"];
		
		$con->Query("SELECT  count(*) AS Count FROM attendance WHERE LectureID = '$LectureID'");
		$row = $con->GetAssoc();
		if($row["Count"] == "0")
		{
			if($add == "Open")
			{
				$con->Query("SELECT SubjectID, SectionID " . // get lecture details
							"FROM class JOIN lecture " .
							"ON class.ClassID = lecture.ClassID " .
							"WHERE lecture.LectureID = '$LectureID'");
				$row = $con->GetAssoc();
				$SectionID = $row["SectionID"];
				$SubjectID = $row["SubjectID"];
				if($SubjectID == null || $SectionID == null) // check wrong lecture input
					jerror("No lecture found by this Name");
				else
				{   // get student list
					$con->Query("SELECT student.StudentID, student.RegistrationNo, student.Name " .
								"FROM student JOIN subjecttostudy " .
								"ON student.StudentID = subjecttostudy.StudentID " .
								"WHERE subjecttostudy.SectionID = '$SectionID' " .
								"AND subjecttostudy.SubjectID = '$SubjectID'");
					if($con->GetRowsEffected() == 0)
						jerror("No student registered in this section");
					else
					{
						$output[] = $con->GetAll();	
						jprint($output);
					}
				}
			}
			else jerror("Add Attendance not allowed");
		}
		else jerror("Attendance already marked.");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>