 <?php	
	// By Bilal Ahmad
	// Get list of lectures
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		
		checkPost($_POST, array("SubjectID", "SectionID"));
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection

		// query data and make output
		$res = array();
		$con->Query("SELECT LectureID, Title, Date, Lab FROM lecture JOIN class ON lecture.ClassID = class.ClassID AND " .
																		"class.SectionID = '" . $_POST["SectionID"] . "' AND " .
																		"class.SubjectID = '" . $_POST["SubjectID"] . "'");
		if(!$con->IsEmptySet())			// chek for no error	
		{
			while($row = $con->GetAssoc())
			{
				$title = $row["Lab"] == "1" ? $row["Title"] . " (Lab)" : $row["Title"];
				$result[] = array("LectureID" => $row["LectureID"], "Title" => $title, "Date" => $row["Date"], "Lab" => $row["Lab"]);
			}
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