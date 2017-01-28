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
		redirect_to("sendnotification.php?ErrorID=1");//retuning the error message back to the login page
		exit();//then exit
	}
	
	$unsafe=$_POST['notificationDetails']; //posting the detail of the notification
	$notificationDetails =clean($unsafe); //cleaning variable to prevent SQL injection
	$notificationDetails=str_replace('\r\n', ' ',$notificationDetails);//triming \r\n from the messge
	
	$sql1=mysql_query("SELECT *FROM student WHERE StudentID='$studentID'");//selecting all student based on the section id
	$row1=mysql_fetch_array($sql1);
	
	$studentMobile=$row1['MobileNumber'];//student mobile number
	
	$number=$studentMobile;
	$message=$notificationDetails."\nDepartment Coordinator";
	sendSMS($number,$message);//sending message to student of the a section
	
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
