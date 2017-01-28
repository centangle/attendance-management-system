<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php

	include_once("../common/config.php"); //including DB Connection File
	include_once("../common/commonfunctions.php"); //including Common function library
	
	$notsafeid=$_GET['id'];//getting ID of the Corrdinator who record need to update
	$sID=clean($notsafeid);//applying serverside validation and cleaning the variable

	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array("coordinatorPassword","coordinatorMobileNumber","coordinatorPhoneNumber","coordinatorEmail","coordinatorPermanentAddress","coordinatorPermanentCity","coordinatorTempAddress","coordinatorTempCity"));
	if(!$b)
	{
		session_unset();//destroy the session
		redirect_to("../clogin.php?msg=Unathuntic Source");//retuning the error message back to the login page
		exit();//then exit
	}
	
	$unsafe=$_POST['coordinatorPassword'];
	$coordinatorPassword =clean($unsafe);//posting  password after cleaning
	
	$unsafe=$_POST['coordinatorMobileNumber'];
	$coordinatorMobileNumber =clean($unsafe);//posting  Mobile Number after cleaning
	
	$unsafe=$_POST['coordinatorPhoneNumber'];
	$coordinatorPhoneNumber =clean($unsafe);//posting  phone number after cleaning
	
	$unsafe=$_POST['coordinatorEmail'];
	$coordinatorEmail =clean($unsafe);//posting  email after cleaning
	
	$unsafe=$_POST['coordinatorPermanentAddress'];
	$coordinatorPermanentAddress =clean($unsafe);//posting  permanent address after cleaning
	
	$unsafe=$_POST['coordinatorPermanentCity'];
	$coordinatorPermanentCity =clean($unsafe);//posting  permanent city after cleaning
	
	$unsafe=$_POST['coordinatorTempAddress'];
	$coordinatorTempAddress =clean($unsafe);//posting  Temporary Address after cleaning
	
	$unsafe=$_POST['coordinatorTempCity'];
	$coordinatorTempCity =clean($unsafe);//posting  Temporary city after cleaning
	
	//setting new values for updating records
		$sql=("UPDATE `coordinator` SET
					`Password`='$coordinatorPassword',
					`PhoneNumber`='$coordinatorPhoneNumber',
					`MobileNumber`='$coordinatorMobileNumber',
					`Email`='$coordinatorEmail',
					`PermanentAddress`='$coordinatorPermanentAddress',
					`PermanentCity`='$coordinatorPermanentCity',
					`TempAddress`='$coordinatorTempAddress',
					`TempCity`='$coordinatorTempCity' 
					WHERE `CoordinatorID`='$sID'");
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
			
	mysql_query($sql);//executing query
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['CoordinatorID'];
	$adminID=clean($unsafeID);//ID of the admin who is performing task after cleaning
	$msg=clean("Updated coordinator profile in MSIS System");//action which is performed
	$user=clean("Coordinator");//user type who performed the action
	
	writelog($user,$adminID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("coordinatorprofile.php?ErrorID=5");//redirecting toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
