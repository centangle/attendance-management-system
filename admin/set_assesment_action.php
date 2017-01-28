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
	$b=checkPost($_POST, array('assesmentStatus'));
	if(!$b)
	{
		redirect_to("criteria.php?ErrorID=1");//retuning the error message back to the login page
		exit();//then exit
	}
	
	$unsafe=$_POST['assesmentStatus']; //posting the user typr where notification will be sended
	$assesmentStatus =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$result8=mysql_query("SELECT *FROM `criteria` WHERE `Entity`='Assesment' AND `Value`='$assesmentStatus'" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8); //executing the query
    if ($exist1 !==false ) {
		if($assesmentStatus=="Open")
		{
			redirect_to("criteria.php?ErrorID=2");//if already exists return with error code
		}
		else
			redirect_to("criteria.php?ErrorID=3");//if already exists return with error code
       }
	$sql=mysql_query("UPDATE `criteria` SET `Value`='$assesmentStatus' WHERE `Entity`='Assesment'");
	
	redirect_to("criteria.php?ErrorID=4");//redirecting toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
