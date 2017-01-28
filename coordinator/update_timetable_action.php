<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	
	$unsafe=$_POST['slotID'];//posting slotID
	$slotID =clean($unsafe);//Cleaning for the Prevention of SQL Injection
	
	$unsafe=$_POST['roomID'];//posting roomID
	$roomID =clean($unsafe);//Cleaning for the Prevention of SQL Injection
	
	$unsafe=$_GET['cid'];//posting class no
	$getClassID =clean($unsafe);//Cleaning for the Prevention of SQL Injection
	
	$unsafe=$_GET['rid'];//posting room id
	$getRoomID =clean($unsafe);//Cleaning for the Prevention of SQL Injection
	
	$unsafe=$_GET['sid'];//posting slot id
	$getSlotID =clean($unsafe);//Cleaning for the Prevention of SQL Injection
	
	
	if($slotID!=$getSlotID || $roomID!=$getRoomID)
	{
		$result8=mysql_query("SELECT *FROM `timetable` WHERE `SlotID`='$slotID' AND `RoomID`='$roomID' AND `ClassID`='$classID' LIMIT 1" ); //checking either record already exists or not
		$exist1 = mysql_fetch_row($result8);		//executing the query 
		if ($exist1 !==false ) {	
			redirect_to("updatetimetable.php?ErrorID=2&cid=$getClassID&rid=$getRoomID&sid=$getSlotID"); //if already exists than return with error code
		   }
		
		$result8=mysql_query("SELECT *FROM `timetable` WHERE `SlotID`='$slotID' AND `RoomID`='$roomID' LIMIT 1" ); //checking either record already exists or not
		$exist1 = mysql_fetch_row($result8);		//executing the query 
		if ($exist1 !==false ) {	
			redirect_to("updatetimetable.php?ErrorID=3&cid=$getClassID&rid=$getRoomID&sid=$getSlotID"); //if already exists than return with error code
		   }
	}

	$sql="UPDATE `timetable` 
		  SET `SlotID`='$slotID',
			  `RoomID`='$roomID',
			  `ClassID`='$getClassID'
               WHERE ClassID='$getClassID' AND SlotID='$getSlotID' AND RoomID='$getRoomID'";
	//echo $sql; for testing values
	//exit();
	mysql_query($sql);//executing the query
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['CoordinatorID'];
	$coordinatorID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Update Table in MSIS System");//action which is performed
	$user=clean("Coordinator");//user type who performed the action
	
	writelog($user,$coordinatorID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("viewtimetable.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
