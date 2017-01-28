<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	include_once("../common/sendfunctions.php"); //including the SMS API and Mail Code
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array('teacherAllotedDepartment','teacherName','teacherFatherName','teacherCNIC','teacherDOB','teacherJoinDate','teacherUsername','teacherPassword','teacherPhoneNumber','teacherMobileNumber','teacherEmail','teacherPermanentAddress','teacherPermanentCity','teacherTempAddress','teacherTempCity'));
	if(!$b)
	{
		session_unset();//destroy the session
		redirect_to("../clogin.php?msg=Unathuntic Source");//retuning the error message back to the login page
		exit();//then exit
	}
	
	//------------Maintaining Session Variables in Case of Errors ---------------------//
	function SetSessionValues()
	{
		$_SESSION['TName']=$_POST['teacherName'];
		$_SESSION['TFatherName']=$_POST['teacherFatherName'];
		$_SESSION['TUsername']=$_POST['teacherUsername'];
		$_SESSION['TPassword']=$_POST['teacherPassword'];
		$_SESSION['TCNIC']=$_POST['teacherCNIC'];
		$_SESSION['TDOB']=$_POST['teacherDOB'];
		$_SESSION['TJoinDate']=$_POST['teacherJoinDate'];
		$_SESSION['TMobile']=$_POST['teacherMobileNumber'];
		$_SESSION['TPhone']=$_POST['teacherPhoneNumber'];
		$_SESSION['TEmail']=$_POST['teacherEmail'];
		$_SESSION['TPAddress']=$_POST['teacherPermanentAddress'];
		$_SESSION['TPCity']=$_POST['teacherPermanentCity'];
		$_SESSION['TTAddress']=$_POST['teacherTempAddress'];
		$_SESSION['TTCity']=$_POST['teacherTempCity'];
	}
	//---------------------------------------------------------------------------------//
	
	$unsafe=$_POST['teacherAllotedDepartment'];//posting id of the alloted room
	$teacherAllotedDepartment =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['teacherFatherName'];//posting father name
	$teacherFatherName =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['teacherName'];//posting name
	$teacherName =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['teacherUsername'];//posting username
	$teacherUsername =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$result8=mysql_query("SELECT Username FROM `teacher` WHERE `Username` = '$teacherUsername' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8); //executing the query
    if ($exist1 !==false ) 
	{
		SetSessionValues();
		redirect_to("registerteacher.php?ErrorID=1");//if already exists than return with error code
    }
	
	$unsafe=$_POST['teacherPassword'];//posting  password
	$teacherPassword =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['teacherCNIC'];//posting  CNIC
	$teacherCNIC =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$result8=mysql_query("SELECT CNICNo FROM `teacher` WHERE `CNICNo` = '$teacherCNIC' LIMIT 1" ); 
	$exist = mysql_fetch_row($result8); //executing the query
    if ($exist !==false ) 
	{
		SetSessionValues();
		redirect_to("registerteacher.php?ErrorID=2"); //if already exists than return with error code
    }
	
	$unsafe=$_POST['teacherDOB'];//posting  date of birth
	$teacherDOB =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['teacherJoinDate'];//posting  joining date
	$teacherJoinDate =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$today=date('m/d/Y');//posting current date
	if(strtotime($teacherJoinDate)>strtotime($today))//if join date is greater than todays date show error
	{
		SetSessionValues();
		redirect_to("registerteacher.php?ErrorID=11");
	}
	
	if(strtotime($teacherJoinDate)<strtotime($teacherDOB)||strtotime($teacherJoinDate)==strtotime($teacherDOB)) 
	{
		SetSessionValues();
		redirect_to("registerteacher.php?ErrorID=3"); //if already exists than return with error code
	}
	/*
	//-----Minimum age >=22 years ------------//
	$age=strtotime($teacherJoinDate)-strtotime($teacherDOB);
	if($age<694310400) 
	{
		SetSessionValues();
		redirect_to("registerteacher.php?ErrorID=10");
	}
	*/
	
	$unsafe=$_POST['teacherMobileNumber'];//posting  Mobile Number
	$teacherMobileNumber =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$result8=mysql_query("SELECT MobileNumber FROM `teacher` WHERE `MobileNumber` = '$teacherMobileNumber' LIMIT 1" ); 
	$exist = mysql_fetch_row($result8); //executing query
    if ($exist !==false ) 
	{
		SetSessionValues();
		redirect_to("registerteacher.php?ErrorID=7");//if already exists than return with error code
    }
	
	$unsafe=$_POST['teacherPhoneNumber'];//posting  phone number
	$teacherPhoneNumber =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$result8=mysql_query("SELECT PhoneNumber FROM `teacher` WHERE `PhoneNumber` = '$teacherPhoneNumber' LIMIT 1" ); 
	$exist = mysql_fetch_row($result8); //executing query
    if ($exist !==false ) 
	{
		SetSessionValues();
		redirect_to("registerteacher.php?ErrorID=8");//if already exists than return with error code
    }
	
	$unsafe=$_POST['teacherEmail'];//posting  email
	$teacherEmail =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$result8=mysql_query("SELECT Email FROM `teacher` WHERE `Email` = '$teacherEmail' LIMIT 1" ); 
	$exist = mysql_fetch_row($result8); //executing query
    if ($exist !==false ) 
	{
		SetSessionValues();
		redirect_to("registerteacher.php?ErrorID=9");//if already exists than return with error code
    }
	
	$unsafe=$_POST['teacherPermanentAddress'];//posting  permanent address
	$teacherPermanentAddress =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['teacherPermanentCity'];//posting  permanent city
	$teacherPermanentCity =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['teacherTempAddress'];//posting  Temporary Address
	$teacherTempAddress =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['teacherTempCity'];//posting  Temporary city
	$teacherTempCity =clean($unsafe); //cleaning variable to prevent SQL injection
	
	
	//Image uploading code here
	$teacherImage = $_FILES['teacherImage']['name'];//posting image path

	//-----------------image extension checking code --------------------------//
	$allowedExts = array("jpeg", "png");//alowed image extensions
		
		$extension = end(explode(".", $_FILES["teacherImage"]["name"]));
		if (	(
					($_FILES["teacherImage"]["type"] == "image/jpeg")
					|| ($_FILES["teacherImage"]["type"] == "image/png")
				)
					&& ($_FILES["teacherImage"]["size"] < 105000)// less than 100 KB image can be uploaded 
					&& in_array($extension, $allowedExts)
			)
		  {
		  }
		else
		  {
			SetSessionValues();
			redirect_to("registerteacher.php?ErrorID=4"); //if already exists than return with error code
		  }
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	
	// Sql query for inserting record into teacher table
	$sql="INSERT INTO `teacher`
			(`TeacherID`, `DepartmentID`, `Name`, `FatherName`, `CNICNo`, `DOB`, `JoinDate`, `Username`, `Password`, `PhoneNumber`, `MobileNumber`, `Email`, `PermanentAddress`, `PermanentCity`, `TempAddress`, `TempCity`) 
			VALUES ('','$teacherAllotedDepartment','$teacherName','$teacherFatherName','$teacherCNIC','$teacherDOB','$teacherJoinDate','$teacherUsername','$teacherPassword','$teacherPhoneNumber','$teacherMobileNumber','$teacherEmail','$teacherPermanentAddress','$teacherPermanentCity','$teacherTempAddress','$teacherTempCity')";
	mysql_query($sql); //executing query
		
	$prevID=mysql_insert_id($link);// ($link=coonection parameter to be make sure it is showing right id)for getting the auto increament id which was assigned to this attendant
	$savePrevID=clean($prevID);
	
	$uploaddir   = '../uploadimages/teacher/';  //setting directory at server where image will moved
	$uploadfile	 = $savePrevID.".".$extension;//creating a file to upload at server
	move_uploaded_file($_FILES['teacherImage']['tmp_name'],$uploaddir.$uploadfile);//moving the file to server according to given path
	
	$sql="UPDATE `teacher` SET `Image`='$uploadfile' WHERE TeacherID='$savePrevID'";
	mysql_query($sql);//executing query
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['AdminID'];
	$adminID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Register a new teacher in MSIS System");//action which is performed
	$user=clean("Admin");//user type who performed the action
	
	writelog($user,$adminID,$msg);//sending parameters to write log funtion which is in the common function library
	

	//------Getting SMS Attributes---------//
	$message ="Mr/Ms: ".$teacherName." Your are registed on MSIS\n Username=".$teacherUsername."\nand Password ".$teacherPassword."";
	$message1 ="Mr/Ms: ".$studentName." Your are required to upload\n the previous degree documents";
	
	$number=$teacherMobileNumber;
	sendSMS($number,$message);
	sendSMS($number,$message1);
	
	//------------Getting Email Message Attributes------------//
	$toEmail=$teacherEmail;
	$subjectText= "MSIS Account Registered";
	$fromEmail="admin@msis.com";
	$msg="Mr/Ms: ".$teacherName." Your are registed on MSIS\n Username=".$teacherUsername."\nand Password ".$teacherPassword."\nYou can change your password after login to the System.";
	sendEmail($toEmail,$subjectText,$msg,$fromEmail);
	
	redirect_to("registerteacher.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
