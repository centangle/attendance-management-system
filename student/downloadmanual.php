<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
{
?>

<?php
	
		include_once("../common/commonfunctions.php"); //including Common function library
		
		$path="../Contents/ConsoleManual.pdf";
		redirect_to($path);//redirecting toward login page if session is not maintained
?>

<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../studentlogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>