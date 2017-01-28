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
		redirect_to("sendnotification.php?ErrorID=1");//retuning the error message back to the login page
		exit();//then exit
	}
	
	$unsafe=$_POST['toClass']; //posting the section id and subject id
	$necessaryIDs =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$pieces = explode(".", $necessaryIDs);//breaking on the basis of . character
	$sectionID=$pieces[0];// section ID
	$subjectID=$pieces[1]; // subject ID
	
	$unsafe=$_POST['notificationDetails']; //posting the detail of the notification
	$notificationDetails =clean($unsafe); //cleaning variable to prevent SQL injection
	$notificationDetails=str_replace('\r\n', ' ',$notificationDetails);//triming \r\n from the messge
	
	$unsafe=$_SESSION['TeacherID'];//posting value from session
	$teacherID=clean($unsafe);//cleaning variable to prevent SQL injection
	
	$sql=mysql_query("SELECT *FROM teacher WHERE TeacherID='$teacherID'");//query for selecting teacehr record based on teacher id
	$row=mysql_fetch_array($sql);
	
	$teacherName=$row['Name'];//posting name of the teacher
	
	$sql1=mysql_query("SELECT MobileNumber FROM student JOIN  subjecttostudy " .
					"ON subjecttostudy.StudentID = student.StudentID " .
					"WHERE subjecttostudy.SectionID ='".$sectionID."' AND subjecttostudy.SubjectID ='".$subjectID."'");//selecting all student based on the section id
					
	while($row1=mysql_fetch_array($sql1))
	{
		$studentMobile=$row1['MobileNumber'];//student mobile number
		
		$number=$studentMobile;
		$message=$notificationDetails."\n".$teacherName;
		sendSMS($number,$message);//sending message to student of the a section
	}
	
	redirect_to("sendnotification.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
