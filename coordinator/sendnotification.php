<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title> Send Notification</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
	<!--function for validating the text area -->
	<script language="javascript" type="text/javascript">
	function imposeMaxLength(Object, MaxLen)
	{
	  return (Object.value.length <= MaxLen);
	}
	</script>
</head>
	<?php
		if(is_numeric($_GET['ErrorID']))//getting message ids from action file
		$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
		switch($error){
			case 1://message 1 case
				echo'<script type="text/javascript">alert("Error: Empty field are not allowed.");</script>';//showing the alert box to notify the message to the user
				break;
		}
	?>
	
<body>
	<?php 
	include"coordinatorheader.php";//<!--side bar menu for the Student -->
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including Common function library
	
	$profileID=$_GET['id'];//unsafe variable
	$studentID=clean($profileID);//cleaning id to preven SQL Injection
		
	//checking either registeration is opened or not
	$unsafe="RegisterCourse";
	$courseRegisteration=clean($unsafe);
	
	$unsafe="Open";
	$status=clean($unsafe);
	
	$res = mysql_query("SELECT * FROM `criteria` WHERE `Entity` ='$courseRegisteration' AND `Value`='$status'");//SELECTING THE user records 
	$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
	if($row)
	{
	?>	
		<div class="inlineSetting">
		<h4 class="alert_success">Course Registeration is Open. Notifications Not Avaliable.</h4>
		</div>
	<?php } 
	else
		{
	?>
	<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Send Notification:</h3></header>
			<div class="module_content"><!-- Showing Fprm for sending alert to students-->
					<div>
						<form method="POST" action="send_notification_action.php?sid=<?php echo $studentID;?>" >
						<table width="100%" align="center">
							<tr>
								<td style="font-weight:bold; font-size:15px;">Details: <font color="red">*</font></td>
								<td>
									<textarea rows="5" cols="50" name="notificationDetails" id="notificationDetails" required onkeypress="return imposeMaxLength(this, 145);"></textarea>
									&nbsp;<span><font color="grey">Max Characters: 145</font></span>
								</td><!--teacher Will Write Message Here-->
							</tr>
							
							<tr>
								<td colspan="2" align="center"><input type="submit" value="SEND"></a></td>
							</tr>
						</table>
					</div>
				
				<div class="clear"></div>
			</div>
	</article><!-- end of stats article -->
	<?php
		}
	?>
</body>

</html>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>
