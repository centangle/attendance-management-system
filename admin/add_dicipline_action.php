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
	$b=checkPost($_POST, array('newDiciplineName','newDiciplineCode','newGraduationLevel','newDepartment','newDiciplineSemester'));
	if(!$b)
	{
		session_unset();//destroy the session
		redirect_to("../clogin.php?msg=Unathuntic Source");//retuning the error message back to the login page
		exit();//then exit
	}	
	
	$unsafe=$_POST['newDiciplineName'];//posting new Dicipline Name
	$newDiciplineName =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['newDiciplineCode'];//posting new room Dicipline Code
	$newDiciplineCode =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['newGraduationLevel'];//posting Graduation Level
	$newRoomFloor =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['newDepartment'];//posting Department
	$newDepartment =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['newDiciplineSemester'];//posting No. of Semesters
	$newDiciplineSemester =clean($unsafe); //cleaning variable to prevent SQL injection
	
	
	$result8=mysql_query("SELECT DisciplineName FROM `discipline` WHERE `DisciplineName` = '$newDiciplineName' AND `TotalSemester`='$newDiciplineSemester' AND `DisciplineCode`='$newDiciplineCode' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8);		//executing the query 
    if ($exist1 !==false ) {	
		redirect_to("adddicipline.php?ErrorID=1"); //if already exists than return with error code
       }
	   
	
	$sql="INSERT INTO `discipline`(`DisciplineName`, `DisciplineCode`, `TotalSemester`, `GraduationLevelID`, `DepartmentID`) 
			VALUES ('$newDiciplineName','$newDiciplineCode','$newDiciplineSemester','$newRoomFloor','$newDepartment')";//Query for inserting discipline
	mysql_query($sql);//executing query
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['AdminID'];
	$adminID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("New dicipline has been added");//action which is performed
	$user=clean("Admin");//user type who performed the action
	
	writelog($user,$adminID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("adddicipline.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
