<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>

<?php
	//PHP Queries developed by Bilal Ahmad Ghouri
	
		include_once("../common/config.php");		// including common functions
		include_once("../common/commonfunctions.php"); //including Common function library
		
		
		if(is_numeric($_GET['cid']))
		$unsafe=$_GET['cid'];
		$contentID=clean($unsafe);//cleaning the variable
		
		$sql1=mysql_query("SELECT FileName FROM content WHERE ContentID = '".$contentID."'");
			
		$res = mysql_fetch_assoc($sql1);
		$path="../Contents/".$res['FileName'];
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