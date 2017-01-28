 <?php	
	// By Bilal Ahmad
	// Get teacher time table of classes
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["SectionID"] = '1';
		//$_POST["SubjectID"] = '40';
		//$_POST["Day"] = '3';
		
		checkPost($_POST, array("SectionID", "SubjectID", "Day"));
		Verify($_POST);				 				// verifying requester
		extract($_POST);
		
		$con = new Connection();					// make connections
		$con->Start();								// start connection
		
		// get class info
		$con->Query("SELECT subjecttoteach.TeacherID " .
					"FROM subjecttoteach JOIN class " .
					"ON subjecttoteach.ClassID = class.ClassID " .
					"WHERE class.SubjectID = '$SubjectID' " .
					"AND class.SectionID = '$SectionID'");
		$y = $con->GetAssoc();
		$TeacherID = $y["TeacherID"];
		if(!$con->IsEmptySet())
		{
			$con->Query("SELECT slot.StartTime, slot.EndTime, timetable.RoomID, timetable.ClassID " .
						"FROM timetable JOIN subjecttoteach JOIN slot " .
						"ON timetable.ClassID = subjecttoteach.ClassID " .
						"AND timetable.SlotID = slot.SlotID " .
						"WHERE subjecttoteach.TeacherID = '$TeacherID' " .
						"AND slot.Day = '$Day'");
			if(!$con->IsEmptySet())
			{
				$tts = $con->GetAll();
				for($i = count($tts) - 1; $i >= 0; $i--)
				{
					// get room info
					$con->Query("SELECT room.RoomCode, room.Floor, room.Lab, block.Name AS BlockName " .
								"FROM room JOIN block " .
								"ON room.BlockID = block.BlockID " .
								"WHERE room.RoomID = '" . $tts[$i]["RoomID"] . "'");
					$room = $con->GetAssoc();
					$room["Lab"] = $room["Lab"] == "0" ? "No" : "Yes";
					
					// get subject info
					$con->Query("SELECT class.SectionID, subject.Name " .
								"FROM class JOIN subject " .
								"ON class.SubjectID = subject.SubjectID " .
								"WHERE class.ClassID = '" . $tts[$i]["ClassID"] . "'");
					$subject = $con->GetAssoc();
					$sectionID = $subject["SectionID"];
					// section info
					$con->Query("SELECT section.Semester, section.SectionCode, discipline.DisciplineCode " .
								"FROM section JOIN discipline " .
								"ON section.DisciplineID = discipline.DisciplineID " .
								"WHERE section.SectionID = '$sectionID'");
					$section = $con->GetAssoc();
					
					// merging
					$row = array();
					copyItems($row, $room, array("RoomCode", "Floor", "Lab", "BlockName"));
					$row["Section"] = $section["DisciplineCode"] . "-" . 
									  $section["Semester"] . 
									  $section["SectionCode"];
					$row["Subject"] = $subject["Name"];
					$row["Start"] = $tts[$i]["StartTime"];
					$row["End"] = $tts[$i]["EndTime"];
					$result[] = $row;
				}
				$output[] = $result;
				jprint($output);
			}
			else jerror("No class on " . getDay($Day));
		}
		else jerror("No teacher assigned");
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>