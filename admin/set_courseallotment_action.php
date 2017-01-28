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
	$b=checkPost($_POST, array('courseAllotmentStatus'));
	if(!$b)
	{
		redirect_to("criteria.php?ErrorID=1");//retuning the error message back to the login page
		exit();//then exit
	}
	
	$unsafe=$_POST['courseAllotmentStatus']; //posting the user typr where notification will be sended
	$courseAllotmentStatus =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$result8=mysql_query("SELECT *FROM `criteria` WHERE `Entity`='CourseAllotment' AND `Value`='$courseAllotmentStatus'" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8); //executing the query
    if ($exist1 !==false ) {
		if($courseAllotmentStatus=="Open")
		{
			redirect_to("criteria.php?ErrorID=19");//if already exists return with error code
		}
		else
			redirect_to("criteria.php?ErrorID=20");//if already exists return with error code
       }
	$sql=mysql_query("UPDATE `criteria` SET `Value`='$courseAllotmentStatus' WHERE `Entity`='CourseAllotment'");
	
	redirect_to("criteria.php?ErrorID=21");//redirecting toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
