<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array('newRoomCode','newRoomBlock','newRoomFloor','newRoomLabInfo'));
	if(!$b)
	{
		redirect_to("addroom.php?ErrorID=2");//retuning the error message back to the login page
		exit();//then exit
	}	
	
	$unsafe=$_POST['newRoomCode'];//posting new room code
	$newRoomCode =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['newRoomBlock'];//posting new room block
	$newRoomBlock =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['newRoomFloor'];//posting new room floor number
	$newRoomFloor =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['newRoomLabInfo'];//posting new room floor number
	$newRoomLabInfo =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$result8=mysql_query("SELECT RoomCode FROM `room` WHERE `RoomCode` = '$newRoomCode' AND `BlockID`='$newRoomBlock' AND `Floor`='$newRoomFloor' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8);		//executing the query 
    if ($exist1 !==false ) {	
		redirect_to("addroom.php?ErrorID=1"); //if already exists than return with error code
       }
	
	$sql="INSERT INTO `room`(`RoomID`, `RoomCode`, `Block`, `Floor`,`Lab`)
			VALUES ('','$newRoomCode','$newRoomBlock','$newRoomFloor','$newRoomLabInfo')";//Query for inserting in room
	mysql_query($sql);//executing query
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['AdminID'];
	$adminID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("New room has been added");//action which is performed
	$user=clean("Admin");//user type who performed the action
	
	writelog($user,$adminID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("addroom.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
