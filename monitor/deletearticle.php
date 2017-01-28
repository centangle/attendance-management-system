<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	
	$unsafe=$_GET['id'];//posting slotID
	$artID =clean($unsafe);//Cleaning for the Prevention of SQL Injection
	
	$sql1=mysql_query("SELECT *FROM article WHERE ArticleID='$artID'");
	$row1=mysql_fetch_array($sql1);
	
	$contentID=$row1['ContentID'];//deleting record from content table
	
	$sql="DELETE FROM article WHERE ArticleID='$artID'";
	mysql_query($sql);//executing the query
	
	$sql2="DELETE FROM content WHERE ContentID='$contentID'";
	mysql_query($sql2);//executing the query
	
	$sql19=mysql_query("SELECT *FROM content WHERE ContentID='$contentID'");
	$row19=mysql_fetch_assoc($sql19);
	
	$fileName=$row19['FileName'];//file name
	
	unlink("../Contents/".$fileName);//deleting file from server
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['TeacherID'];
	$teacherID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Delete an Article in MSIS System");//action which is performed
	$user=clean("Teacher");//user type who performed the action
	
	writelog($user,$teacherID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("viewarticle.php?ErrorID=1");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
