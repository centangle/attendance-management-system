<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/sendfunctions.php");
	include_once("../common/config.php"); //including DB Connection File

	if(is_numeric($_GET['tid']))
	$unsafe=$_GET['tid'];
	$taskID=clean($unsafe);//cleaning the variable
	
	if(is_numeric($_GET['sbID']))
	$unsafe=$_GET['sbID'];
	$subjectID=clean($unsafe);//cleaning the variable
	
	if(is_numeric($_GET['scID']))
	$unsafe=$_GET['scID'];
	$sectionID=clean($unsafe);//cleaning the variable
	
	if(is_numeric($_GET['stID']))
	$unsafe=$_GET['stID'];
	$studentID=clean($unsafe);//cleaning the variable
	
	$b=checkPost($_POST, array('taskMarks'));
	if(!$b)
	{
		redirect_to("updatemarks.php?ErrorID=1&tid=$taskID&sbID=$subjectID&scID=$sectionID&stID=$studentID");//retuning the error message back to the login page
		exit();//then exit
	}
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	
	//------Maintaining Session variable for redirecting them to previous form in case of Errors ---------//
	function SetSessionValues()
	{
		$_SESSION['tasMark']=$_POST['taskMarks'];
	}
	//-------------------------------------------------------------//
	
	$unsafe=$_POST['taskMarks'];//posting variable from form
	$taskMarks=clean($unsafe);//cleaning for the prevention of SQL Injection
	
	$sql12=mysql_query("SELECT *FROM task WHERE TaskID='$taskID'");
	$row12=mysql_fetch_array($sql12);
	
	$totalMarks=$row12['TotalMarks'];
	$title=$row12['Title'];
	
	$average=($taskMarks/$totalMarks)*100;

	$sql13=mysql_query("SELECT *FROM criteria WHERE Entity='LowMarks'");
	$row13=mysql_fetch_array($sql13);
	
	$lowMarks=$row13['Value'];
	
	if($taskMarks>$totalMarks)
	{
		SetSessionValues();
		redirect_to("updatemarks.php?ErrorID=2&tid=$taskID&sbID=$subjectID&scID=$sectionID&stID=$studentID");//retuning the error message back to the login page
		exit();
	}
	
	$sql80="UPDATE marks SET `ObtainedMarks`='$taskMarks' WHERE StudentID='$studentID' AND TaskID='$taskID'";
	mysql_query($sql80);//executing query
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['TeacherID'];
	$teacherID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Updated TasK Marks in MSIS System");//action which is performed
	$user=clean("Teacher");//user type who performed the action
	
	writelog($user,$teacherID,$msg);//sending parameters to write log funtion which is in the common function library
	
	//-=-----------Sending SMS to Respective Students-------------//
	$sql71=mysql_query("SELECT *FROM student WHERE StudentID='$studentID'");//selecting all student based on the section id and section id
	$row71=mysql_fetch_array($sql71);//while fetching the list of records
	
	$studentNumber=$row71['MobileNumber'];
	$name=$row71['Name'];
	
	$message="Mr/Ms:".$name." Marks Has Been Updated of ".$title.".";
	sendSMS($studentNumber,$message);//sending SMS on the Student Mobile for announcement of the assignment
	
	if($average<=$lowMarks)
	{
		$sql72=mysql_query("SELECT *FROM parentinfo WHERE ParentInfoID='$studentID'");//selecting all student based on the section id and section id
		$row72=mysql_fetch_array($sql72);//while fetching the list of records
		$parentNumber=$row72['MobileNumber'];
		$message="Respected Madam/Sir \n Your Son/Daughter ".$name." Got Lower than ".$lowMarks."% Marks of task ".$title.".";
		sendSMS($parentNumber,$message);//sending SMS on the Student Mobile for announcement of the assignment
	}
	//---------------------------------------------//
	redirect_to("viewtaskmarks.php?ErrorID=3&tid=$taskID&sbID=$subjectID&scID=$sectionID");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
