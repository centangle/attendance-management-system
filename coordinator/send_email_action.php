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
	
	$unsafe=$_GET['sid'];//getting the value
	$studentID=clean($unsafe);//cleaning the variable
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array('notificationDetails'));
	if(!$b)
	{
		redirect_to("sendemail.php?ErrorID=1");//retuning the error message back to the login page
		exit();//then exit
	}
	
	$sql5=mysql_query("SELECT *FROM student WHERE StudentID='$studentID'");//query for selecting the student registeration number on the basis of student id
	$row5=mysql_fetch_array($sql5);
	
	$toEmail=$row5['EmailAddress'];
	
	$unsafe=$_POST['notificationDetails']; //posting the notification details
	$notificationDetails =clean($unsafe); //cleaning variable to prevent SQL injection
	$message=str_replace('\r\n', ' ',$notificationDetails);//triming \r\n from the messge
	
	//-------Email Values----------//
	$subjectText="Information for Student";
	$msg=$message."\nDepartment Coordinator";
	$fromEmail="coordinator@msis.com";

	sendEmail($toEmail,$subjectText,$msg,$fromEmail);//sending email
	
	redirect_to("studentnotifications.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
