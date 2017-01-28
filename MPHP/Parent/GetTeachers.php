 <?php	
	// By Bilal Ahmad
	//  get list of teachers
	
	$con = null;
	try
	{
		include_once("../Common/Common.php");		// including common functions
		
		//$_POST["StudentID"] = "1";
		checkPost($_POST, array("StudentID"));	
		Verify($_POST);				 	// verifying requester
		$con = new Connection();		// making connection object
		$con->start();					// initializing connection
		
		$con->Query("SELECT DISTINCT teacher.Name, teacher.TeacherID " .
						"FROM teacher " .
						"JOIN subjecttoteach ON subjecttoteach.TeacherID = teacher.TeacherID " .
						"JOIN class ON  class.ClassID = subjecttoteach.ClassID " .
						"JOIN subjecttostudy ON subjecttostudy.SectionID = class.SectionID " .
						"WHERE subjecttostudy.StudentID = '" . $_POST["StudentID"] . "'");
		if($con->IsEmptySet())
			jerror("No teacher alloted");
		else
		{
			$output[] = $con->GetAll();
			jprint($output);
		}
	}
	catch(Exception $e)
	{
		jerror($e->getMessage());		// Send occured Error
	}
	if($con != null) 
		$con->Terminate(); 				// closing connection	
 ?>