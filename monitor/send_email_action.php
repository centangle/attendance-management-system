<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	include_once("../common/sendfunctions.php"); //including the SMS API and Mail Code
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array('toClass','notificationDetails'));
	if(!$b)
	{
		redirect_to("sendemail.php?ErrorID=1");//retuning the error message back to the login page
		exit();//then exit
	}
	
	$unsafe=$_SESSION['TeacherID'];//posting value from session
	$teacherID=clean($unsafe);//cleaning variable to prevent SQL injection
	
	$sql5=mysql_query("SELECT *FROM teacher WHERE TeacherID='$teacherID'");//query for selecting the student registeration number on the basis of student id
	$row5=mysql_fetch_array($sql5);
	$teacherEmail=$row5['Email'];
	$teacherName=$row5['Name'];
	
	$unsafe=$_POST['toClass']; //posting the section id and subject id
	$necessaryIDs =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$pieces = explode(".", $necessaryIDs);//breaking on the basis of . character
	$sectionID=$pieces[0];// section ID
	$subjectID=$pieces[1]; // subject ID	
	
	$unsafe=$_POST['notificationDetails']; //posting the notification details
	$notificationDetails =clean($unsafe); //cleaning variable to prevent SQL injection
	$message=str_replace('\r\n', ' ',$notificationDetails);//triming \r\n from the messge
	
	//-------Email Values----------//
	$subjectText="Information for Student";
	$msg=$message."\n".$teacherName;
	$fromEmail=$teacherEmail;
					
	$sql=mysql_query("SELECT EmailAddress FROM student JOIN  subjecttostudy " .
					"ON subjecttostudy.StudentID = student.StudentID " .
					"WHERE subjecttostudy.SectionID ='".$sectionID."' AND subjecttostudy.SubjectID ='".$subjectID."'");//selecting all student based on the section id
	
	while($row=mysql_fetch_array($sql))
	{
		$toEmail=$row['EmailAddress'];//student Email
		sendEmail($toEmail,$subjectText,$msg,$fromEmail);//sending email
	}
	
	redirect_to("sendemail.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
