<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	include_once("../common/sendfunctions.php"); //including the SMS API and Mail Code
	
	$profileID=$_SESSION['StudentID'];//unsafe variable
	$id=clean($profileID);//cleaning id to preven SQL Injection
	
	$sql5=mysql_query("SELECT *FROM student WHERE StudentID='$id'");//query for selecting the student registeration number on the basis of student id
	$row5=mysql_fetch_array($sql5);
	$studentRegNo=$row5['RegistrationNo'];//registeration number of student
	$studentEmail=$row5['EmailAddress'];
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array('toTeacher','notificationDetails'));
	if(!$b)
	{
		redirect_to("sendemail.php?ErrorID=1");//retuning the error message back to the login page
		exit();//then exit
	}
	
	$unsafe=$_POST['toTeacher']; //posting the teacher info 
	$toTeacher =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$pieces = explode(".", $toTeacher);//breaking on the basis of . character
	$subjectID=$pieces[0];// subject ID
	$sectionID=$pieces[1]; // sectionID ID
	
	$sql=mysql_query("SELECT ClassID FROM class WHERE SubjectID='$subjectID' AND SectionID='$sectionID'");//query for selecting the class id depending upon the section id and class id
	$row=mysql_fetch_array($sql);
	$classID=$row['ClassID'];//class id of the teacher
	
	$sql1=mysql_query("SELECT TeacherID FROM subjecttoteach WHERE ClassID='$classID'");//query for selecting the teacherid on the basis of class id
	$row1=mysql_fetch_array($sql1);
	$teacherID=$row1['TeacherID'];//teacher ID
	
	$sql2=mysql_query("SELECT *FROM teacher WHERE TeacherID='$teacherID'");//query for selecting the teacher records on the basis of teacher id
	$row2=mysql_fetch_array($sql2);
	$teacherEmail=$row2['Email'];//teacher Mobile Number
	
	$unsafe=$_POST['notificationDetails']; //posting the notification details
	$notificationDetails =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$message=$notificationDetails."\n".$studentRegNo;
	$message=str_replace('\r\n', ' ',$message);//triming \r\n from the messge

	//echo $message."to-------------"."------from:".$studentEmail;
	//echo $teacherEmail;
	//exit();
	$subjectText="Query From Student";
	
	sendEmail($teacherEmail,$subjectText,$message,$studentEmail);//sending the email 
	
	redirect_to("sendemail.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../studentlogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
