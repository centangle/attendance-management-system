<!-- Developed By: Arslan Khalid -->

<?php
	include_once("common/commonfunctions.php"); //including Common function library
	include_once("common/config.php"); //including DB Connection File
	include_once("common/sendfunctions.php"); //including the SMS API and Mail Code
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array('userRegisterationNumber'));
	if(!$b)
	{
		redirect_to("recoverpassword.php?ErrorID=2");//retuning the error message back to the login page
		exit();//then exit
	}
	
	$unsafe=$_POST['userRegisterationNumber']; //posting id of the alloted room
	$userRegisterationNumber =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$result8=mysql_query("SELECT RegistrationNo FROM `student` WHERE `RegistrationNo` = '$userRegisterationNumber' LIMIT 1" ); //checking either record already exists or not
	
	$exist1 = mysql_fetch_row($result8); //executing the query
    if ($exist1 ==false ) {
		redirect_to("recoverpassword.php?ErrorID=1");//if already exists return with error code
       }
	
   
	$result9=mysql_query("SELECT  *FROM `student` WHERE `RegistrationNo` = '$userRegisterationNumber'"); //checking either record already exists or not
	$exist2 = mysql_fetch_array($result9); //executing the query
	
	
	//------Getting SMS Attributes---------//
	$name=$exist2['Name'];//inserting name
	$email=$exist2['EmailAddress'];//inserting email
	$number=$exist2['MobileNumber'];//inserting mobile number
	$password=$exist2['Password'];
	/*
	$message ="Mr/Ms: ".$name." Your password has been emailed\n on your email.";
	sendSMS($number,$message);
	*/
	
	//------------Getting Email Message Attributes------------//
	$toEmail=$email;
	$subjectText= "MSIS Account Password";
	$fromEmail="admin@msis.com";
	$msg="Mr/Ms: ".$name." Your passowrd of MSIS Accounts is ".$password."\n Login to system and stay connected to MSIS.";
	sendEmail($toEmail,$subjectText,$msg,$fromEmail);
	
	redirect_to("recoverpassword.php?ErrorID=5");//redirectinf toward register page
?>
