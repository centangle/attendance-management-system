<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	
	$notsafeid=$_GET['id'];//getting ID of the Attendant who record need to update
	$sID=clean($notsafeid);//applying serverside validation and cleaning the variable
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array('attendantAllotedRoom','attendantFatherName','attendantName','attendantPassword','attendantCNIC','attendantDOB','attendantJoinDate','attendantMobileNumber','attendantPhoneNumber','attendantEmail','attendantPermanentAddress','attendantPermanentCity','attendantTempAddress','attendantTempCity'));
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
	
	$sql19=mysql_query("SELECT *FROM attendent WHERE AttendentID='$sID'");//checking if room changed or not
	$row19=mysql_fetch_array($sql19);
	$alreadyRoomID=$row19['RoomID'];//posting the room id
	
	if($roomNoID != $alreadyRoomID)
	{
	$result8=mysql_query("SELECT RoomID FROM `attendent` WHERE `RoomID` = '$roomNoID' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8); //executing the query
    if ($exist1 !==false ) 
		{
			SetSessionValues();
			redirect_to("updateattendant.php?ErrorID=1&id=$sID");//if already exists return with error code
		}
	}
	
	$unsafe=$_POST['attendantFatherName'];//posting father name
	$attendantFName =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['attendantName'];//posting name
	$attendantName =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['attendantPassword'];//posting  password
	$attendantPassword =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['attendantCNIC'];//posting  CNIC
	$attendantCNIC =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$alreadyCNIC=$row19['CNICNo'];//posting the CNIC no
	if($attendantCNIC != $alreadyCNIC)
	{
	$result8=mysql_query("SELECT CNICNo FROM `attendent` WHERE `CNICNo` = '$attendantCNIC' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8); //executing the query
    if ($exist1 !==false ) 
		{
			SetSessionValues();
			redirect_to("updateattendant.php?ErrorID=2&id=$sID");//if already exists return with error code
		}
	}
	
	$unsafe=$_POST['attendantDOB'];//posting  date of birth
	$attendantDOB =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['attendantJoinDate'];//posting  joining date
	$attendantJoinDate =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$today=date('m/d/Y');//posting current date
	if(strtotime($attendantJoinDate)>strtotime($today))//if join date is greater than todays date show error
	{
		SetSessionValues();
		redirect_to("updateattendant.php?ErrorID=8id=$sID");
	}
	
	if(strtotime($attendantJoinDate)<strtotime($attendantDOB)||strtotime($attendantJoinDate)==strtotime($attendantDOB)) 
	{
		SetSessionValues();
		redirect_to("updateattendant.php?ErrorID=3&id=$sID"); //if already exists than return with error code
	}
	/*
	//-----Minimum age >=22 years ------------//
	$age=strtotime($attendantJoinDate)-strtotime($attendantDOB);
	if($age<694310400) 
	{
		SetSessionValues();
		redirect_to("registerattendant.php?ErrorID=7");
	}
	*/
	
	$unsafe=$_POST['attendantMobileNumber'];//posting  Mobile Number
	$attendantMobileNo =clean($unsafe); //cleaning variable to prevent SQL injection
	$alreadyMobileNumber=$row19['MobileNumber'];//posting the Mobile Number
	
	if($attendantMobileNo != $alreadyMobileNumber)
	{
	$result8=mysql_query("SELECT MobileNumber FROM `attendent` WHERE `MobileNumber` = '$attendantMobileNo' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8); //executing the query
    if ($exist1 !==false ) 
		{
			SetSessionValues();
			redirect_to("updateattendant.php?ErrorID=4&id=$sID");//if already exists return with error code
		}
	}
	
	$unsafe=$_POST['attendantPhoneNumber'];//posting  phone number
	$attendantPhoneNo =clean($unsafe); //cleaning variable to prevent SQL injection
	$alreadyPhoneNumber=$row19['PhoneNumber'];//posting the Phone Number
	
	if($attendantPhoneNo != $alreadyPhoneNumber)
	{
	$result8=mysql_query("SELECT PhoneNumber FROM `attendent` WHERE `PhoneNumber` = '$attendantPhoneNo' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8); //executing the query
    if ($exist1 !==false ) 
		{
			SetSessionValues();
			redirect_to("updateattendant.php?ErrorID=5&id=$sID");//if already exists return with error code
		}
	}
	
	$unsafe=$_POST['attendantEmail'];//posting  email
	$attendantEmail =clean($unsafe); //cleaning variable to prevent SQL injection
	$alreadyEmail=$row19['Email'];//posting the Email
	
	if($attendantEmail != $alreadyEmail)
	{
	$result8=mysql_query("SELECT Email FROM `attendent` WHERE `Email` = '$attendantEmail' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8); //executing the query
    if ($exist1 !==false ) 
		{
			SetSessionValues();
			redirect_to("updateattendant.php?ErrorID=6&id=$sID");//if already exists return with error code
		}
	}
	
	$unsafe=$_POST['attendantPermanentAddress'];//posting  permanent address
	$attendantPermAddress =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['attendantPermanentCity'];//posting  permanent city
	$attendantPermCity =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['attendantTempAddress'];//posting  Temporary Address
	$attendantTempAddress =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['attendantTempCity'];//posting  Temporary city
	$attendantTempCity =clean($unsafe); //cleaning variable to prevent SQL injection
	
	//setting new values for updating records
	$sql=("UPDATE `attendent`
				SET 
				`FatherName`='$attendantFName',
				`Name`='$attendantName',
				`RoomID`='$roomNoID',
				`CNICNo`='$attendantCNIC',
				`DOB`='$attendantDOB',
				`JoinDate`='$attendantJoinDate',
				`Password`='$attendantPassword',
				`PhoneNumber`='$attendantPhoneNo',
				`MobileNumber`='$attendantMobileNo',
				`Email`='$attendantEmail',
				`PermanentAddress`='$attendantPermAddress',
				`PermanentCity`='$attendantPermCity',
				`TempAddress`='$attendantTempAddress',
				`TempCity`='$attendantTempCity' 
				 WHERE `AttendentID`='$sID'");
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	
	mysql_query($sql);//executing query
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['AdminID'];
	$adminID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Update a record of attendant in MSIS System");//action which is performed
	$user=clean("Admin");//user type who performed the action
	
	writelog($user,$adminID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("viewattendant.php?ErrorID=7");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
