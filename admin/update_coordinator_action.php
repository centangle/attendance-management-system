<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
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
	$b=checkPost($_POST, array("coordinatorFatherName","coordinatorName","coordinatorPassword","coordinatorCNIC","coordinatorDOB","coordinatorJoinDate","coordinatorMobileNumber","coordinatorPhoneNumber","coordinatorEmail","coordinatorPermanentAddress","coordinatorPermanentCity","coordinatorTempAddress","coordinatorTempCity"));
	if(!$b)
	{
		session_unset();//destroy the session
		redirect_to("../clogin.php?msg=Unathuntic Source");//retuning the error message back to the login page
		exit();//then exit
	}
	
	//------------Maintaining Session Variables in Case of Errors ---------------------//
	function SetSessionValues()
	{
		$_SESSION['CName']=$_POST['coordinatorName'];
		$_SESSION['CFatherName']=$_POST['coordinatorFatherName'];
		$_SESSION['CPassword']=$_POST['coordinatorPassword'];
		$_SESSION['CCNIC']=$_POST['coordinatorCNIC'];
		$_SESSION['CDOB']=$_POST['coordinatorDOB'];
		$_SESSION['CJoinDate']=$_POST['coordinatorJoinDate'];
		$_SESSION['CMobile']=$_POST['coordinatorMobileNumber'];
		$_SESSION['CPhone']=$_POST['coordinatorPhoneNumber'];
		$_SESSION['CEmail']=$_POST['coordinatorEmail'];
		$_SESSION['CPAddress']=$_POST['coordinatorPermanentAddress'];
		$_SESSION['CPCity']=$_POST['coordinatorPermanentCity'];
		$_SESSION['CTAddress']=$_POST['coordinatorTempAddress'];
		$_SESSION['CTCity']=$_POST['coordinatorTempCity'];
	}
	//---------------------------------------------------------------------------------//
	
	$sql19=mysql_query("SELECT *FROM coordinator WHERE CoordinatorID='$sID'");//checking if room changed or not
	$row19=mysql_fetch_array($sql19);
	
	$unsafe=$_POST['coordinatorFatherName'];
	$coordinatorFatherName =clean($unsafe);//posting father name after cleaning 
	
	$unsafe=$_POST['coordinatorName'];
	$coordinatorName =clean($unsafe);//posting name after cleaning
	
	$unsafe=$_POST['coordinatorPassword'];
	$coordinatorPassword =clean($unsafe);//posting  password after cleaning
	
	$unsafe=$_POST['coordinatorCNIC'];
	$coordinatorCNIC =clean($unsafe);//posting  CNIC after cleaning
	
	$alreadyCNIC=$row19['CNICNo'];//posting the CNIC no
	if($coordinatorCNIC != $alreadyCNIC)
	{
	$result8=mysql_query("SELECT CNICNo FROM `coordinator` WHERE `CNICNo` = '$coordinatorCNIC' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8); //executing the query
    if ($exist1 !==false ) 
		{
			SetSessionValues();
			redirect_to("updatecoordinator.php?ErrorID=2&id=$sID");//if already exists return with error code
		}
	}
	
	
	$unsafe=$_POST['coordinatorDOB'];
	$coordinatorDOB =clean($unsafe);//posting  date of birth after cleaning
	
	$unsafe=$_POST['coordinatorJoinDate'];
	$coordinatorJoinDate =clean($unsafe);//posting  joining date after cleaning
	
	$today=date('m/d/Y');//posting current date
	if(strtotime($coordinatorJoinDate)>strtotime($today))//if join date is greater than todays date show error
	{
		SetSessionValues();
		redirect_to("updatecoordinator.php?ErrorID=8id=$sID");
	}
	
	if(strtotime($coordinatorJoinDate)<strtotime($coordinatorDOB)||strtotime($coordinatorJoinDate)==strtotime($coordinatorDOB)) 
	{
		SetSessionValues();
		redirect_to("updatecoordinator.php?ErrorID=3&id=$sID"); //if already exists than return with error code
	}
	
	/*
	//-----Minimum age >=22 years ------------//
	$age=strtotime($coordinatorJoinDate)-strtotime($coordinatorDOB);
	if($age<694310400) 
	{
		SetSessionValues();
		redirect_to("updatecoordinator.php?ErrorID=7id=$sID");
	}
	*/
	
	$unsafe=$_POST['coordinatorMobileNumber'];
	$coordinatorMobileNumber =clean($unsafe);//posting  Mobile Number after cleaning
	
	$alreadyMobileNumber=$row19['MobileNumber'];//posting the Mobile Number
	
	if($coordinatorMobileNumber != $alreadyMobileNumber)
	{
	$result8=mysql_query("SELECT MobileNumber FROM `coordinator` WHERE `MobileNumber` = '$coordinatorMobileNumber' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8); //executing the query
    if ($exist1 !==false ) 
		{
			SetSessionValues();
			redirect_to("updatecoordinator.php?ErrorID=4&id=$sID");//if already exists return with error code
		}
	}
	
	$unsafe=$_POST['coordinatorPhoneNumber'];
	$coordinatorPhoneNumber =clean($unsafe);//posting  phone number after cleaning
	
	$alreadyPhoneNumber=$row19['PhoneNumber'];//posting the Phone Number
	
	if($coordinatorPhoneNumber != $alreadyPhoneNumber)
	{
	$result8=mysql_query("SELECT PhoneNumber FROM `coordinator` WHERE `PhoneNumber` = '$coordinatorPhoneNumber' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8); //executing the query
    if ($exist1 !==false ) 
		{
			SetSessionValues();
			redirect_to("updatecoordinator.php?ErrorID=5&id=$sID");//if already exists return with error code
		}
	}
	
	$unsafe=$_POST['coordinatorEmail'];
	$coordinatorEmail =clean($unsafe);//posting  email after cleaning
	
	$alreadyEmail=$row19['Email'];//posting the Email
	
	if($coordinatorEmail != $alreadyEmail)
	{
	$result8=mysql_query("SELECT Email FROM `attendent` WHERE `Email` = '$coordinatorEmail' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8); //executing the query
    if ($exist1 !==false ) 
		{
			SetSessionValues();
			redirect_to("updatecoordinator.php?ErrorID=6&id=$sID");//if already exists return with error code
		}
	}
	
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
					`Name`='$coordinatorName',
					`FatherName`='$coordinatorFatherName',
					`CNICNo`='$coordinatorCNIC',
					`DOB`='$coordinatorDOB',
					`JoinDate`='$coordinatorJoinDate',
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
	$unsafeID=$_SESSION['AdminID'];
	$adminID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Change a record of coordinator in MSIS System");//action which is performed
	$user=clean("Admin");//user type who performed the action
	
	writelog($user,$adminID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("viewcoordinator.php?ErrorID=5");//redirecting toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
