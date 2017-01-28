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
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array('deadlineDate'));
	if(!$b)
	{
		redirect_to("criteria.php?ErrorID=1");//retuning the error message back to the login page
		exit();//then exit
	}
	
	$unsafe=$_POST['deadlineDate']; //posting the user typr where notification will be sended
	$Status =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$today=date('m/d/Y');//posting current date
	
	$result8=mysql_query("SELECT *FROM `criteria` WHERE `Entity`='MarksDeadline' AND `Value`='$Status'" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8); //executing the query
    if ($exist1 !==false ) {
			redirect_to("criteria.php?ErrorID=10");//if already exists return with error code
       }
	   
	if(strtotime($today)>=strtotime($Status))//if join date is greater than todays date show error
	{
		redirect_to("criteria.php?ErrorID=11");//if not valid return with error code
	}
	$sql=mysql_query("UPDATE `criteria` SET `Value`='$Status' WHERE `Entity`='MarksDeadline'");
	
	
	$sql1=mysql_query("SELECT *FROM teacher");
	
	$message="Sir/Madam: Markd Deadline for this semester is ".$Status."\nDepartment Coordinator";
	while($row1=mysql_fetch_array($sql1))
	{
		$number=$row1['MobileNumber'];
		sendSMS($number,$message);//sending message to Teachers
	}
	
	redirect_to("criteria.php?ErrorID=12");//redirecting toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
