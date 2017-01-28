<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title>Send Email</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
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
			<h4 class="alert_success">Email Notification for Special Events, News and Special Schedules.</h4>
		</div>
		
		<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Email Notification:</h3></header>
			<div class="module_content"><!-- Showing the notification form for sending alert to the users of the system-->
					<div>
						<form method="POST" action="send_email_action.php" >
						<table width="100%" align="center">
							<tr>
								<td style="font-weight:bold; font-size:15px;">Select User: </td>
								<td>
									<select name="tableType" id="tableType"><!--Generate a List of users-->
										<option value="all">ALL</option>
										<option value="student">Students</option>
										<option value="parent">Student Parents</option>
										<option value="teacher">Teachers</option>
										<option value="coordinator">Coordinators</option>
										<option value="attendent">Attendants</option>
									</select>
								</td><!--Selecting the User type to send notification -->
							</tr>
							
							<tr>
								<td style="font-weight:bold; font-size:15px;">Details: <font color="red">*</font></td>
								<td>
									<textarea rows="15" cols="50" name="notificationDetails" id="notificationDetails" required></textarea>
								</td><!--Admin Will Write Message Here-->
							</tr>
							
							<tr>
								<td colspan="2" align="center"><input type="submit" value="SEND"></td>
							</tr>
						</table>
						</form>
					</div>
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
