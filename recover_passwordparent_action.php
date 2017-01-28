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
		redirect_to("recoverpasswordparent.php?ErrorID=2");//retuning the error message back to the login page
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
	$stID=$exist2['StudentID'];
	
	$result19=mysql_query("SELECT  *FROM `parentinfo` WHERE `ParentInfoID` = '$stID'"); //checking either record already exists or not
	$exist3 = mysql_fetch_array($result19); //executing the query

	$sql
	
	//------Getting SMS Attributes---------//
	$name=$exist2['FatherName'];//inserting name
	$email=$exist3['EmailAddress'];//inserting email
	$number=$exist3['MobileNumber'];//inserting mobile number
	$password=$exist2['XPassword'];
	
	//------------Getting Email Message Attributes------------//
	$toEmail=$email;
	$subjectText= "MSIS Account Password";
	$fromEmail="admin@msis.com";
	$msg="Mr/Ms: ".$name." Your passowrd of MSIS Accounts is ".$password."\n Login to system and stay connected to MSIS.";
	sendEmail($toEmail,$subjectText,$msg,$fromEmail);
	
	redirect_to("recoverpasswordparent.php?ErrorID=5");//redirectinf toward register page
?>
