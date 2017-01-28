<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array('studentPassword','studentPhoneNumber','studentMobileNumber','studentEmail','studentPermanentAddress','studentPermanentCity','studentTempAddress','studentTempCity'));
	if(!$b)
	{
		session_unset();//destroy the session
		redirect_to("../parentlogin.php?msg=Unathuntic Source");//retuning the error message back to the login page
		exit();//then exit
	}

	$notsafeid=$_GET['id'];//getting ID of the who record need to update
	$sID=clean($notsafeid);//applying serverside validation and cleaning the variable
	
	//----------------------------------------------------------Basic Info Section ------------------------//
	
	$unsafe=$_POST['studentPassword'];//posting  password
	$studentPassword =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentMobileNumber'];//posting  Mobile Number
	$studentMobileNumber =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentPhoneNumber'];//posting  phone number
	$studentPhoneNumber =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentEmail'];//posting  email
	$studentEmail =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentPermanentAddress'];//posting  permanent address
	$studentPermanentAddress =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentPermanentCity'];//posting  permanent city
	$studentPermanentCity =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentTempAddress'];//posting  Temporary Address
	$studentTempAddress =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentTempCity'];//posting  Temporary city
	$studentTempCity =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$sql=("UPDATE `student`
				SET 
				`Password`='$studentPassword',
				`PhoneNumber`='$studentPhoneNumber',
				`MobileNumber`='$studentMobileNumber',
				`EmailAddress`='$studentEmail',
				`PermanentAddress`='$studentPermanentAddress',
				`PermanentCity`='$studentPermanentCity',
				`TempAddress`='$studentTempAddress',
				`TempCity`='$studentTempCity'
				 WHERE `StudentID`='$sID'");
	
	mysql_query($sql);//executing query
	
	//-----------Student Table Query Ends here-----------------//
	
	///Maintaining Log File Enteries
	$unsafeID=$_SESSION['StudentID'];
	$stID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Updated student profile in MSIS System");//action which is performed
	$user=clean("Student");//user type who performed the action
	
	writelog($user,$stID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("studentprofile.php?ErrorID=5");//redirecting toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../parentlogin.php?msg=Login First!"); //redirecting toward login page if session is not maintained
	}
?>
