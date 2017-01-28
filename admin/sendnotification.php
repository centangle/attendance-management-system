<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title>Send Notification</title> <!--title of the page -->
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
			case 5://message 5 case
				echo'<script type="text/javascript">alert("Success: Message successfully dilevered.");</script>';//showing the alert box to notify the message to the user
				break;
		}
	?>
<body>
	<?php include"adminheader.php"; ?><!--side bar menu for the admin -->
		
		<div class="inlineSetting">
			<h4 class="alert_success">SMS Notification for Special Events, News and Special Schedules.</h4>
		</div>
		
		<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Send Notification:</h3></header>
			<div class="module_content"><!-- Showing the notification form for sending alert to the users of the system-->
				
					<div>
						<form method="POST" action="send_notification_action.php" >
						<table width="100%" align="center">
							<tr>
								<td style="font-weight:bold; font-size:15px;">Select User: </td>
								<td>
									<select name="tableType" id="tableType"><!--Generate a List of users-->
										<option value="all">ALL</option>
										<option value="student">Students</option>
										<option value="parent">Student Parent</option>
										<option value="teacher">Teachers</option>
										<option value="coordinator">Coordinators</option>
										<option value="attendent">Attendants</option>
									</select>
								</td><!--Selecting the User type to send notification -->
							</tr>
							
							<tr>
								<td style="font-weight:bold; font-size:15px;">Details: <font color="red">*</font></td>
								<td>
									<pre><textarea rows="5" cols="50" name="notificationDetails" id="notificationDetails" required onkeypress="return imposeMaxLength(this, 160);"></textarea></pre>
									&nbsp;<span><font color="grey">Max Characters: 160</font></span>
								</td><!--Admin Will Write Message Here-->
							</tr>
							
							<tr>
								<td colspan="2" align="center"><input type="submit" value="SEND"></td>
							</tr>
						</table>
						</form>
					</div>
				
				<div class="clear"></div>
			</div>
	</article><!-- end of stats article -->
</body>

</body>

</html>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../studentlogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>
