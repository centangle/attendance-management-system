<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	
	$notsafeid=$_GET['id'];//getting ID of the USERS who record need to update
	$sID=clean($notsafeid);//applying serverside validation and cleaning the variable
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array('adminName'));
	if(!$b)
	{
		session_unset();//destroy the session
		redirect_to("../clogin.php?msg=Unathuntic Source");//retuning the error message back to the login page
		exit();//then exit
	}
	
	$unsafe=$_POST['adminName'];//posting name
	$adminName =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$sql=("UPDATE `admin`
			SET
			`Name`='$adminName'
			 WHERE  `AdminID`='$sID'");
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	
	mysql_query($sql);//executing query
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['AdminID'];
	$adminID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Update profile of Admin in MSIS System");//action which is performed
	$user=clean("Admin");//user type who performed the action
	
	writelog($user,$adminID,$msg);//sending parameters to write log funtion which is in the common function library
	
	
	redirect_to("adminprofile.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
