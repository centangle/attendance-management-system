<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	
	$unsafe=$_GET['sid'];//posting slotID
	$slotID =clean($unsafe);//Cleaning for the Prevention of SQL Injection
	
	$unsafe=$_GET['rid'];//posting roomID
	$roomID =clean($unsafe);//Cleaning for the Prevention of SQL Injection
	
	$unsafe=$_GET['cid'];//posting class id
	$classID =clean($unsafe);//Cleaning for the Prevention of SQL Injection
	
	$sql="DELETE FROM timetable WHERE ClassID='$classID' AND RoomID='$roomID' AND SlotID='$slotID'";
	//echo $sql; for testing values
	//exit();
	mysql_query($sql);//executing the query
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['CoordinatorID'];
	$coordinatorID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Delete Time Table in MSIS System");//action which is performed
	$user=clean("Coordinator");//user type who performed the action
	
	writelog($user,$coordinatorID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("viewtimetable.php?ErrorID=1");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
