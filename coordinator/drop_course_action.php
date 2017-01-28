<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	include_once("../common/sendfunctions.php"); //including the SMS API and Mail Code
	
	$unsafe=$_GET['sid'];//getting the value
	$studentID=clean($unsafe);//cleaning the variable
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array('studentSubject','type'));
	if(!$b)
	{
		redirect_to("dropdetails.php?ErrorID=1&id=$studentID");//retuning the error message back to the login page
		exit();//then exit
	}
	
	$unsafe=$_POST['studentSubject']; //posting subjectID
	$subjectID =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['type']; //posting type
	$type =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$sql9=mysql_query("SELECT *FROM subjecttostudy WHERE StudentID='$studentID' AND SubjectID='$subjectID'");//selecting the subject which need to drop
	$row9=mysql_fetch_array($sql9);
	$stID = $row9[0];
	$sbID= $row9[1];
	mysql_query("INSERT INTO dropsubject (`StudentID`, `SubjectID`, `Type`) VALUES ('$stID','$sbID','$type')");//query for droping the subject

	//---Query for Deleting Subject from Current Semester Courses ------//
	mysql_query("DELETE FROM subjecttostudy WHERE StudentID='$studentID' AND SubjectID='$subjectID'");
	//--------------------------------------------------------------------//
	
	///Maintaining Log File Enteries
	$unsafeID=$_SESSION['CoordinatorID'];
	$coordinatorID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Drop a subject in MSIS System");//action which is performed
	$user=clean("Coordinator");//user type who performed the action
	writelog($user,$coordinatorID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("dropdetails.php?ErrorID=5&id=$studentID");//redirectinf toward  page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
