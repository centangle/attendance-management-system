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
	
	$unsafe=$_POST['diciplineID'];//posting dicipline id
	$diciplineID =clean($unsafe);//Cleaning for the Prevention of SQL Injection
	
	$unsafe=$_POST['semesterNo'];//posting semster no
	$semesterNo =clean($unsafe);//Cleaning for the Prevention of SQL Injection
	
	$unsafe=$_POST['sectionID'];//posting section id
	$sectionID =clean($unsafe);//Cleaning for the Prevention of SQL Injection
	
	$unsafe=$_POST['subjectID'];//posting subject id
	$subjectID =clean($unsafe);//Cleaning for the Prevention of SQL Injection
	
	$mix=$diciplineID.",".$semesterNo.",".$sectionID.",".$subjectID;
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array('slotID','roomID','diciplineID','semesterNo','sectionID','subjectID'));
	if(!$b)
	{
		redirect_to("addtimetable.php?ErrorID=1&ids=$mix");//retuning the error message back to the login page
	}	
	
	$sql3=mysql_query("SELECT *FROM class WHERE SubjectID='$subjectID' AND SectionID='$sectionID'");
	$row3=mysql_fetch_array($sql3);
	
	$unsafe=$row3['ClassID'];//posting classID
	$classID=clean($unsafe);//cleaning the variable
	
	$result8=mysql_query("SELECT *FROM `timetable` WHERE `SlotID`='$slotID' AND `RoomID`='$roomID' AND `ClassID`='$classID' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8);		//executing the query 
    if ($exist1 !==false ) {	
		redirect_to("addtimetable.php?ErrorID=2&ids=$mix"); //if already exists than return with error code
       }
	  
	$result8=mysql_query("SELECT *FROM `timetable` WHERE `SlotID`='$slotID' AND `RoomID`='$roomID' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8);		//executing the query 
    if ($exist1 !==false ) {	
		redirect_to("addtimetable.php?ErrorID=3&ids=$mix"); //if already exists than return with error code
       }

	
	$sql="INSERT INTO `timetable`(`SlotID`,`RoomID`, `ClassID`) VALUES ('$slotID','$roomID','$classID')";
	//echo $sql; for testing values
	//exit();
	mysql_query($sql);//executing the query
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['CoordinatorID'];
	$coordinatorID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Add Time Table in MSIS System");//action which is performed
	$user=clean("Coordinator");//user type who performed the action
	
	writelog($user,$coordinatorID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("addtimetable.php?ErrorID=5&ids=$mix");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
