<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	
	$notsafeid=$_GET['id'];//getting ID of the Corrdinator who record need to update
	$sID=clean($notsafeid);//applying serverside validation and cleaning the variable
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array('teacherPassword','teacherPhoneNumber','teacherMobileNumber','teacherEmail','teacherPermanentAddress','teacherPermanentCity','teacherTempAddress','teacherTempCity'));
	if(!$b)
	{
		session_unset();//destroy the session
		redirect_to("../clogin.php?msg=Unathuntic Source");//retuning the error message back to the login page
		exit();//then exit
	}
	
	$unsafe=$_POST['teacherPassword'];//posting  password
	$teacherPassword =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['teacherMobileNumber'];//posting  Mobile Number
	$teacherMobileNumber =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['teacherPhoneNumber'];//posting  phone number
	$teacherPhoneNumber =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['teacherEmail'];//posting  email
	$teacherEmail =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['teacherPermanentAddress'];//posting  permanent address
	$teacherPermanentAddress =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['teacherPermanentCity'];//posting  permanent city
	$teacherPermanentCity =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['teacherTempAddress'];//posting  Temporary Address
	$teacherTempAddress =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['teacherTempCity'];//posting  Temporary city
	$teacherTempCity =clean($unsafe); //cleaning variable to prevent SQL injection
	
	
	$sql=("UPDATE `teacher` 
			SET 
			`Password`='$teacherPassword',
			`PhoneNumber`='$teacherPhoneNumber',
			`MobileNumber`='$teacherMobileNumber',
			`Email`='$teacherEmail',
			`PermanentAddress`='$teacherPermanentAddress',
			`PermanentCity`='$teacherPermanentCity',
			`TempAddress`='$teacherTempAddress',
			`TempCity`='$teacherTempCity'
			WHERE `TeacherID`='$sID'");
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	mysql_query($sql); //executing query
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['TeacherID'];
	$adminID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Updated teacher profile in MSIS System");//action which is performed
	$user=clean("Teacher");//user type who performed the action
	
	writelog($user,$adminID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("teacherprofile.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
