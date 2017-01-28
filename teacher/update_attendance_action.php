<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<?php
		include_once("../common/config.php");		// including common functions
		include_once("../common/commonfunctions.php"); //including Common function library
		
		$profileID=$_SESSION['TeacherID'];//unsafe variable
		$id=clean($profileID);//cleaning id to preven SQL Injection
	
		if(is_numeric($_GET['lid']))
		$unsafe=$_GET['lid'];
		$lectureID=clean($unsafe);//cleaning the variable
		
		if(is_numeric($_GET['sbID']))
		$unsafe=$_GET['sbID'];
		$subjectID=clean($unsafe);//cleaning the variable
		
		if(is_numeric($_GET['scID']))
		$unsafe=$_GET['scID'];
		$sectionID=clean($unsafe);//cleaning the variable
		
		$unsafe=$_POST['status'];
		$status=clean($unsafe);
		
		$sql=mysql_query("UPDATE `attendance`
						  SET `Present`='$status' 
						  WHERE `LectureID`='$lectureID'");
		
		//Maintaining Log File Enteries
		$unsafeID=$_SESSION['TeacherID'];
		$teacherID=clean($unsafeID);//ID of the admin who is performing task
		$msg=clean("Updated Attendance in MSIS System");//action which is performed
		$user=clean("Teacher");//user type who performed the action
		
		writelog($user,$teacherID,$msg);//sending parameters to write log funtion which is in the common function library

		redirect_to("attendancedetails.php?lid=$lectureID&sbID=$subjectID&scID=$sectionID&ErrorID=3");//redirecting the with the message
		?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>