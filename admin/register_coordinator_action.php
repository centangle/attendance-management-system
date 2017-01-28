<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php

	include_once("../common/config.php"); //including DB Connection File
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/sendfunctions.php"); //including the SMS API and Mail Code
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array("coordinatorAllotedDiscipline","coordinatorFatherName","coordinatorName","coordinatorUsername","coordinatorPassword","coordinatorCNIC","coordinatorDOB","coordinatorJoinDate","coordinatorMobileNumber","coordinatorPhoneNumber","coordinatorEmail","coordinatorPermanentAddress","coordinatorPermanentCity","coordinatorTempAddress","coordinatorTempCity"));
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
		$_SESSION['CUsername']=$_POST['coordinatorUsername'];
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
	
	$unsafe=$_POST['coordinatorAllotedDiscipline'];
	$coordinatorAllotedDiscipline =clean($unsafe);//posting id of the alloted room after cleaning 
	
	$unsafe=$_POST['coordinatorFatherName'];
	$coordinatorFatherName =clean($unsafe);//posting father name after cleaning 
	
	$unsafe=$_POST['coordinatorName'];
	$coordinatorName =clean($unsafe);//posting name after cleaning
	
	$unsafe=$_POST['coordinatorUsername'];
	$coordinatorUsername =clean($unsafe);//posting username after cleaning
	
	
	$result8=mysql_query("SELECT Username FROM `coordinator` WHERE `Username`='$coordinatorUsername' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8);		//executing the query 
    if ($exist1 !==false ) 
	{	
		SetSessionValues();
		redirect_to("registercoordinator.php?ErrorID=1"); //if not exists than return with error code
	}
	
	$unsafe=$_POST['coordinatorPassword'];
	$coordinatorPassword =clean($unsafe);//posting  password after cleaning
	
	$unsafe=$_POST['coordinatorCNIC'];
	$coordinatorCNIC =clean($unsafe);//posting  CNIC after cleaning
	
	$result8=mysql_query("SELECT CNICNo FROM `coordinator` WHERE `CNICNo` = '$coordinatorCNIC' LIMIT 1" ); 
	$exist = mysql_fetch_row($result8); 
    if ($exist !==false ) 
	{
		SetSessionValues();
		redirect_to("registercoordinator.php?ErrorID=2"); //if already exists than return with error code
	}
	   
	$unsafe=$_POST['coordinatorDOB'];
	$coordinatorDOB =clean($unsafe);//posting  date of birth after cleaning
		
	$unsafe=$_POST['coordinatorJoinDate'];
	$coordinatorJoinDate =clean($unsafe);//posting  joining date after cleaning
	
	$today=date('m/d/Y');//posting current date
	if(strtotime($attendantJoinDate)>strtotime($today))//if join date is greater than todays date show error
	{
		SetSessionValues();
		redirect_to("registercoordinator.php?ErrorID=11");
	}
	
	if(strtotime($coordinatorJoinDate)<strtotime($coordinatorDOB)||strtotime($coordinatorJoinDate)==strtotime($coordinatorDOB))
	{
		SetSessionValues();
		redirect_to("registercoordinator.php?ErrorID=3"); //if already exists than return with error code
	}
	
	/*
	//-----Minimum age >=22 years ------------//
	$age=strtotime($coordinatorJoinDate)-strtotime($coordinatorDOB);
	if($age<694310400)
	{
		SetSessionValues();
		redirect_to("registercoordinator.php?ErrorID=10");
	}
	*/
	
	$unsafe=$_POST['coordinatorMobileNumber'];
	$coordinatorMobileNumber =clean($unsafe);//posting  Mobile Number after cleaning
	
	$result8=mysql_query("SELECT MobileNumber FROM `coordinator` WHERE `MobileNumber` = '$coordinatorMobileNumber' LIMIT 1" ); 
	$exist = mysql_fetch_row($result8); //executing query
    if ($exist !==false ) 
	{
		SetSessionValues();
		redirect_to("registercoordinator.php?ErrorID=7");//if already exists than return with error code
    }
	
	$unsafe=$_POST['coordinatorPhoneNumber'];
	$coordinatorPhoneNumber =clean($unsafe);//posting  phone number after cleaning
	
	$result8=mysql_query("SELECT PhoneNumber FROM `coordinator` WHERE `PhoneNumber` = '$coordinatorPhoneNumber' LIMIT 1" ); 
	$exist = mysql_fetch_row($result8); //executing query
    if ($exist !==false ) 
	{
		SetSessionValues();
		redirect_to("registercoordinator.php?ErrorID=8");//if already exists than return with error code
    }
	
	$unsafe=$_POST['coordinatorEmail'];
	$coordinatorEmail =clean($unsafe);//posting  email after cleaning
	
	$result8=mysql_query("SELECT Email FROM `coordinator` WHERE `Email` = '$coordinatorEmail' LIMIT 1" ); 
	$exist = mysql_fetch_row($result8); //executing query
    if ($exist !==false ) 
	{
		SetSessionValues();
		redirect_to("registercoordinator.php?ErrorID=9");//if already exists than return with error code
    }
	
	$unsafe=$_POST['coordinatorPermanentAddress'];
	$coordinatorPermanentAddress =clean($unsafe);//posting  permanent address after cleaning
	
	$unsafe=$_POST['coordinatorPermanentCity'];
	$coordinatorPermanentCity =clean($unsafe);//posting  permanent city after cleaning
	
	$unsafe=$_POST['coordinatorTempAddress'];
	$coordinatorTempAddress =clean($unsafe);//posting  Temporary Address after cleaning
	
	$unsafe=$_POST['coordinatorTempCity'];
	$coordinatorTempCity =clean($unsafe);//posting  Temporary city after cleaning
	
	//Image uploading code here
	$coordinatorImage =$_FILES['coordinatorImage']['name'];//posting image path
	
	
	//-----------------image extension checking code --------------------------//
	$allowedExts = array("jpeg", "png");//alowed image extensions
		
		$extension = end(explode(".", $_FILES["coordinatorImage"]["name"]));
		if (	(
					($_FILES["coordinatorImage"]["type"] == "image/jpeg")
					|| ($_FILES["coordinatorImage"]["type"] == "image/png")
				)
					&& ($_FILES["coordinatorImage"]["size"] < 105000)// less than 100 KB image can be uploaded 
					&& in_array($extension, $allowedExts)
			)
		  {
		  }
		else
		  {
			SetSessionValues();
			redirect_to("registercoordinator.php?ErrorID=4"); //if already exists than return with error code
		  }

	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	
	// Sql query for inserting record into coordinator table
	$sql="INSERT INTO `coordinator`
			(`CoordinatorID`, `DepartmentID`, `Name`, `FatherName`, `CNICNo`, `DOB`, `JoinDate`, `Username`, `Password`, `PhoneNumber`, `MobileNumber`, `Email`, `PermanentAddress`, `PermanentCity`, `TempAddress`, `TempCity`) 
			VALUES ('','$coordinatorAllotedDiscipline','$coordinatorName','$coordinatorFatherName','$coordinatorCNIC','$coordinatorDOB','$coordinatorJoinDate','$coordinatorUsername','$coordinatorPassword','$coordinatorPhoneNumber','$coordinatorMobileNumber','$coordinatorEmail','$coordinatorPermanentAddress','$coordinatorPermanentCity','$coordinatorTempAddress','$coordinatorTempCity')";
			
	mysql_query($sql);//executing query
	
	$prevID=mysql_insert_id($link);// ($link=coonection parameter to be make sure it is showing right id)for getting the auto increament id which was assigned to this coordinator
	$savePrevID=clean($prevID);
	
	$uploaddir   = '../uploadimages/coordinator/';  //setting directory at server where image will moved
	$uploadfile	 = $savePrevID.".".$extension;//creating a file to upload at server
	move_uploaded_file($_FILES['coordinatorImage']['tmp_name'],$uploaddir.$uploadfile);//moving the file to server according to given path
	
	$sql="UPDATE `coordinator` SET `Image`='$uploadfile' WHERE CoordinatorID='$savePrevID'";
	mysql_query($sql);//executing query
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['AdminID'];
	$adminID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Register a new Coordinator in MSIS System");//action which is performed
	$user=clean("Admin");//user type who performed the action
	
	writelog($user,$adminID,$msg);//sending parameters to write log funtion which is in the common function library
	//------Getting SMS Attributes---------//
	$message ="Mr/Ms: ".$coordinatorName." Your are registered on MSIS\n Username=".$coordinatorUsername."\nand Password ".$coordinatorPassword."";
	$number=$coordinatorMobileNumber;
	sendSMS($number,$message);
	
	
	//------------Getting Email Message Attributes------------//
	$toEmail=$coordinatorEmail;
	$subjectText= "MSIS Account Registered";
	$msg="Mr/Ms: ".$coordinatorName." Your are registered on MSIS\n Username=".$coordinatorUsername."\nand Password ".$coordinatorPassword."\nYou can change your password after login to the System.";
	$fromEmail="admin@msis.com";
	sendEmail($toEmail,$subjectText,$msg,$fromEmail);
	
	redirect_to("registercoordinator.php?ErrorID=5");//redirecting toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>

