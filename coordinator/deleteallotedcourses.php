<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	include_once("../common/sendfunctions.php"); //including the SMS API and Mail Code
	
	$unsafe=$_GET['tid'];//posting TeacherID
	$teacherID =clean($unsafe);//Cleaning for the Prevention of SQL Injection
	
	$unsafe=$_GET['cid'];//posting class id
	$classID =clean($unsafe);//Cleaning for the Prevention of SQL Injection
	
	$sql="DELETE FROM subjecttoteach WHERE ClassID='$classID' AND TeacherID='$teacherID'";
	//echo $sql; for testing values
	//exit();
	mysql_query($sql);//executing the query
	
	//------Getting SMS Attributes---------//
	$sql1=mysql_query("SELECT *FROM teacher WHERE TeacherID='$teacherID'");
	$row1=mysql_fetch_array($sql1);

	$teacherNumber=$row1['MobileNumber'];
	$teacherEmail=$row1['Email'];
	
	
	
	$sql2=mysql_query("SELECT *FROM class WHERE ClassID='$classID'");
	$row2=mysql_fetch_array($sql2);
	$subjectID=$row2['SubjectID'];
	
	$sql3=mysql_query("SELECT *FROM subject WHERE SubjectID='$subjectID'");
	$row3=mysql_fetch_array($sql3);
	$subjectName=$row3['SubjectID'];
	
	
	$message ="Sir/Madam: ".$subjectName." is re-alloted to other faculty member. Check Details on MSIS Teacher Portal.";
	$number=$teacherNumber;
	sendSMS($number,$message);//sending SMS on the Teacher Number about the course allotment
	
	
	//------------Getting Email Message Attributes------------//
	$toEmail=$teacherEmail;
	$subjectText= "New Course Alloted";
	$fromEmail="admin@msis.com";
	$msg="Sir/Madam: Subject:".$subjectName." is re-alloted to other faculty member. Check Detials on MSIS Teacher Portal.";
	sendEmail($toEmail,$subjectText,$msg,$fromEmail);
	
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['CoordinatorID'];
	$coordinatorID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Delete Alloted Course in MSIS System");//action which is performed
	$user=clean("Coordinator");//user type who performed the action
	
	writelog($user,$coordinatorID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("viewallotedcourses.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
