<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>

<?php
		include_once("../common/config.php");		// including common functions
		include_once("../common/commonfunctions.php"); //including Common function library				
		include_once("../common/sendfunctions.php"); //including Common function library				
		
		$profileID=$_SESSION['TeacherID'];//unsafe variable
		$id=clean($profileID);//cleaning id to preven SQL Injection
		$studentNameSelected = "";
		$message="";
		$number = "";
		
		$presentIDs = json_decode($_GET["PresentIDs"]);//decoding the present student Ids in an array
		$absentIDs = json_decode($_GET["AbsentIDs"]);//decoding the absent student Ids in an array
		
		$unsafe = $_GET['lid'];//posting lecture id
		$lectureID=clean($unsafe);//cleaning the ID for the Prevention of SQL Injection
		
		$totalPresent= count($presentIDs);//total number of students which are present
		$totalAbsent= count($absentIDs);//total numbers of students which are absent
		
		for($i=0; $i<$totalPresent; $i++)//marking the present
		{
			mysql_query("INSERT INTO `attendance`(`LectureID`, `StudentID`, `Present`) VALUES ('$lectureID','$presentIDs[$i]','1')");
		}

		for($i=0; $i<$totalAbsent; $i++)//marking the absent
		{
			mysql_query("INSERT INTO `attendance`(`LectureID`, `StudentID`, `Present`) VALUES ('$lectureID','$absentIDs[$i]','0')");			
			$ab = mysql_query("SELECT *FROM `parentinfo` WHERE `ParentInfoID`='$absentIDs[$i]'");
			$row4 = mysql_fetch_array($ab);//fetching record as a set of array of selected user		
			$number = $row4['MobileNumber'];
			
			$ba = mysql_query("SELECT *FROM `student` WHERE `StudentID`='$absentIDs[$i]'");
			$row5 = mysql_fetch_array($ba);//fetching record as a set of array of selected user		
			$studentNameSelected = $row5['Name'];
			
			$message="Your Kid".$$studentNameSelected."is absent from school today ( ".date('Y-m-d')." )";		
			sendSMS($number,$message);
		}		
		redirect_to("addattendance.php?ErrorID=8");//redirecting the with the message
		?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>