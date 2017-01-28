 <?php	
	// By Bilal Ahmad
	// Uploads a file of a lecture
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		//$_POST["SubjectID"] = '39';
		//$_POST["SectionID"] = '1';
		checkPost($_POST, array("SubjectID", "SectionID"));
		Verify($_POST);				 				// verifying requester
		extract($_POST);
		
		$con = new Connection();					// make connections
		$con->Start();								// start connection
		$con->Query("SELECT ClassID FROM class " .
					"WHERE SubjectID = '$SubjectID' " .
					"AND SectionID = '$SectionID'");
		if(!$con->IsEmptySet())
		{
			$row = $con->GetAssoc();
			$ClassID = $row["ClassID"];
			$con->Query("SELECT LectureID, Title, Date, Lab FROM lecture " .
						" WHERE ClassID = '$ClassID'");
			if(!$con->IsEmptySet())
			{
				$output[] = $con->GetAll();
				$i = count($output) - 1;
				while($i > 0)
				{
					$title = $output[$i]["Lab"] == "1" ? $output[$i]["Title"] . " (Lab)" : $output[$i]["Title"];
					$result[] = array("LectureID" => $output[$i]["LectureID"], "Title" => $title, 
										"Date" => $output[$i]["Date"], "Lab" => $output[$i]["Lab"]);
					$i--;
				}
				jprint($output);
			}
			else jerror("No lecture conducted");
		}
		else jerror("No class registered of provided info.");
		
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>