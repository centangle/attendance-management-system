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
	$b=checkPost($_POST, array('attendantAllotedRoom','attendantFatherName','attendantName','attendantUsername','attendantPassword','attendantCNIC','attendantDOB','attendantJoinDate','attendantMobileNumber','attendantPhoneNumber','attendantEmail','attendantPermanentAddress','attendantPermanentCity','attendantTempAddress','attendantTempCity'));
	if(!$b)
	{
		session_unset();//destroy the session
		redirect_to("../clogin.php?msg=Unathuntic Source");//retuning the error message back to the login page
		exit();//then exit
	}
	
	//------------Maintaining Session Variables in Case of Errors ---------------------//
	function SetSessionValues()
	{
		$_SESSION['Name']=$_POST['attendantName'];
		$_SESSION['FatherName']=$_POST['attendantFatherName'];
		$_SESSION['AUsername']=$_POST['attendantUsername'];
		$_SESSION['APassword']=$_POST['attendantPassword'];
		$_SESSION['CNIC']=$_POST['attendantCNIC'];
		$_SESSION['DOB']=$_POST['attendantDOB'];
		$_SESSION['JoinDate']=$_POST['attendantJoinDate'];
		$_SESSION['Mobile']=$_POST['attendantMobileNumber'];
		$_SESSION['Phone']=$_POST['attendantPhoneNumber'];
		$_SESSION['Email']=$_POST['attendantEmail'];
		$_SESSION['PAddress']=$_POST['attendantPermanentAddress'];
		$_SESSION['PCity']=$_POST['attendantPermanentCity'];
		$_SESSION['TAddress']=$_POST['attendantTempAddress'];
		$_SESSION['TCity']=$_POST['attendantTempCity'];
	}
	//---------------------------------------------------------------------------------//
	
	$unsafe=$_POST['attendantAllotedRoom']; //posting id of the alloted room
	$roomNoID =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$result8=mysql_query("SELECT RoomID FROM `attendent` WHERE `RoomID` = '$roomNoID' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8); //executing the query
    if ($exist1 !==false ) 
	{
		SetSessionValues();
		redirect_to("registerattendant.php?ErrorID=6");//if already exists return with error code
    }
	
	$unsafe=$_POST['attendantFatherName'];//posting father name
	$attendantFName =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['attendantName'];//posting name
	$attendantName =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['attendantUsername'];//posting username
	$attendantUsername =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$result8=mysql_query("SELECT Username FROM `attendent` WHERE `Username` = '$attendantUsername' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8); //executing the query
    if ($exist1 !==false ) 
	{
		SetSessionValues();
		redirect_to("registerattendant.php?ErrorID=1");//if already exists return with error code
    }
	
	$unsafe=$_POST['attendantPassword'];//posting  password
	$attendantPassword =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['attendantCNIC'];//posting  CNIC
	$attendantCNIC =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$result8=mysql_query("SELECT CNICNo FROM `attendent` WHERE `CNICNo` = '$attendantCNIC' LIMIT 1" ); 
	$exist = mysql_fetch_row($result8); //executing query
    if ($exist !==false ) 
	{
		SetSessionValues();
		redirect_to("registerattendant.php?ErrorID=2");//if already exists than return with error code
    }
	
	$unsafe=$_POST['attendantDOB'];//posting  date of birth
	$attendantDOB =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['attendantJoinDate'];//posting  joining date
	$attendantJoinDate =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$today=date('m/d/Y');//posting current date
	if(strtotime($attendantJoinDate)>strtotime($today))//if join date is greater than todays date show error
	{
		SetSessionValues();
		redirect_to("registerattendant.php?ErrorID=11");
	}
	
	if(strtotime($attendantJoinDate)<strtotime($attendantDOB)||strtotime($attendantJoinDate)==strtotime($attendantDOB)) 
	{
		SetSessionValues();
		redirect_to("registerattendant.php?ErrorID=3"); //if already exists than return with error code
	}
	
	/*
	//-----Minimum age >=22 years ------------//
	$age=strtotime($attendantJoinDate)-strtotime($attendantDOB);
	if($age<694310400) 
	{
		SetSessionValues();
		redirect_to("registerattendant.php?ErrorID=10");
	}
	*/
	
	$unsafe=$_POST['attendantMobileNumber'];//posting  Mobile Number
	$attendantMobileNo =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$result8=mysql_query("SELECT MobileNumber FROM `attendent` WHERE `MobileNumber` = '$attendantMobileNo' LIMIT 1" ); 
	$exist = mysql_fetch_row($result8); //executing query
    if ($exist !==false ) 
	{
		SetSessionValues();
		redirect_to("registerattendant.php?ErrorID=7");//if already exists than return with error code
    }
	
	$unsafe=$_POST['attendantPhoneNumber'];//posting  phone number
	$attendantPhoneNo =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$result8=mysql_query("SELECT PhoneNumber FROM `attendent` WHERE `PhoneNumber` = '$attendantPhoneNo' LIMIT 1" ); 
	$exist = mysql_fetch_row($result8); //executing query
    if ($exist !==false ) 
	{
		SetSessionValues();
		redirect_to("registerattendant.php?ErrorID=8");//if already exists than return with error code
    }
	   
	$unsafe=$_POST['attendantEmail'];//posting  email
	$attendantEmail =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$result8=mysql_query("SELECT Email FROM `attendent` WHERE `Email` = '$attendantEmail' LIMIT 1" ); 
	$exist = mysql_fetch_row($result8); //executing query
    if ($exist !==false ) 
	{
		SetSessionValues();
		redirect_to("registerattendant.php?ErrorID=9");//if already exists than return with error code
    }
	
	$unsafe=$_POST['attendantPermanentAddress'];//posting  permanent address
	$attendantPermAddress =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['attendantPermanentCity'];//posting  permanent city
	$attendantPermCity =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['attendantTempAddress'];//posting  Temporary Address
	$attendantTempAddress =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['attendantTempCity'];//posting  Temporary city
	$attendantTempCity =clean($unsafe); //cleaning variable to prevent SQL injection
	
	//Image uploading code here
	//$attendantImage = $_FILES['attendantImage']['name'];//posting image path

		//-----------------image extension checking code --------------------------//
	$allowedExts = array("jpeg", "png");//alowed image extensions
		
		$extension = end(explode(".", $_FILES["attendantImage"]["name"]));
		if (	(
					($_FILES["attendantImage"]["type"] == "image/jpeg")
					|| ($_FILES["attendantImage"]["type"] == "image/png")
				)
					&& ($_FILES["attendantImage"]["size"] < 105000)// less than 100 KB image can be uploaded 
					&& in_array($extension, $allowedExts) && $_FILES['attendantImage']['name']!=""
			)
		  {
		  }
		else
		  {
			SetSessionValues();
			redirect_to("registerattendant.php?ErrorID=4"); //if already exists than return with error code
		  }
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	
	// Sql query for inserting record into room table
	$sql="INSERT INTO `attendent`
		(`AttendentID`, `FatherName`, `Name`, `RoomID`, `CNICNo`, `DOB`, `JoinDate`, `Username`, `Password`, `PhoneNumber`, `MobileNumber`, `Email`, `PermanentAddress`, `PermanentCity`, `TempAddress`, `TempCity`)
		VALUES ('','$attendantFName','$attendantName','$roomNoID','$attendantCNIC','$attendantDOB','$attendantJoinDate','$attendantUsername','$attendantPassword','$attendantPhoneNo','$attendantMobileNo','$attendantEmail','$attendantPermAddress','$attendantPermCity','$attendantTempAddress','$attendantTempCity')";
	mysql_query($sql);//executing query
	
	$prevID=mysql_insert_id($link);// ($link=coonection parameter to be make sure it is showing right id)for getting the auto increament id which was assigned to this attendant
	$savePrevID=clean($prevID);

				$uploaddir   = '../uploadimages/attendant/';  //setting directory at server where image will moved
				$uploadfile	 = $savePrevID.".".$extension;//creating a file to upload at server
				move_uploaded_file($_FILES['attendantImage']['tmp_name'],$uploaddir.$uploadfile);//moving the file to server according to given path
	$sql="UPDATE `attendent` SET `Image`='$uploadfile' WHERE AttendentID='$savePrevID'";
	mysql_query($sql);//executing query
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['AdminID'];
	$adminID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Register a new attendant in MSIS System");//action which is performed
	$user=clean("Admin");//user type who performed the action
	
	writelog($user,$adminID,$msg);//sending parameters to write log funtion which is in the common function library
	
	//------Getting SMS Attributes---------//
	$message ="Mr/Ms: ".$attendantName." Your are registed on MSIS\n Username=".$attendantUsername."\nand Password ".$attendantPassword."";
	$number=$attendantMobileNo;
	sendSMS($number,$message);
	
	
	//------------Getting Email Message Attributes------------//
	$toEmail=$attendantEmail;
	$subjectText= "MSIS Account Registered";
	$fromEmail="admin@msis.com";
	$msg="Mr/Ms: ".$attendantName." Your are registed on MSIS\n Username=".$attendantUsername."\nand Password ".$attendantPassword."\nYou can change your password after login to the System.";
	sendEmail($toEmail,$subjectText,$msg,$fromEmail);
	
	redirect_to("registerattendant.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
