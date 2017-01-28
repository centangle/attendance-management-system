<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array('sectionDiscipline','newSectionName','newSectionSemester'));
	if(!$b)
	{
		session_unset();//destroy the session
		redirect_to("../clogin.php?msg=Unathuntic Source");//retuning the error message back to the login page
		exit();//then exit
	}	
	
	$unsafe=$_POST['sectionDiscipline'];//posting new section dicipline
	$sectionDiscipline =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['newSectionName'];//posting new section name/code like A, B
	$upperCase=strtoupper($unsafe);
	$newSectionName =clean($upperCase); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['newSectionSemester'];//posting new section name
	$newSectionSemester =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$result8=mysql_query("SELECT SectionCode FROM `section` WHERE `SectionCode` = '$newSectionName' AND `Semester`='$newSectionSemester' AND `DisciplineID`='$sectionDiscipline' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8);		//executing the query 
    if ($exist1 !==false ) {	
		redirect_to("addsection.php?ErrorID=1"); //if already exists than return with error code
       }
	
	
	$sql="INSERT INTO `section`(`DisciplineID`, `Semester`, `SectionCode`) 
								VALUES ('$sectionDiscipline','$newSectionSemester','$newSectionName')";
	mysql_query($sql);//executing the query
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['CoordinatorID'];
	$coordinatorID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("New Section has been added");//action which is performed
	$user=clean("Coordinator");//user type who performed the action
	
	writelog($user,$coordinatorID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("addsection.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
