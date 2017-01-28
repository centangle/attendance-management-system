<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>

<?php
	
		include_once("../common/commonfunctions.php"); //including Common function library
		
		$path="../Contents/Teacher.apk";
		redirect_to($path);//redirecting toward login page if session is not maintained
?>

<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>