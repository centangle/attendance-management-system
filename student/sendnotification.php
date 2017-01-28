<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title> Send SMS</title> <!--title of the page -->
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
	<?php 
		include"studentheader.php";//<!--side bar menu for the Student -->
	    include_once("../common/commonfunctions.php"); //including Common function library
	    include_once("../common/config.php"); //including Common function library
		
		$profileID=$_SESSION['StudentID'];//unsafe variable
		$id=clean($profileID);//cleaning id to preven SQL Injection
			
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
			<h4 class="alert_success">Course Registeration is Open. No Teachers Assigned Yet.</h4>
			</div>
	<?php } 
	else
		{
	?>
	<div class="inlineSetting">
	<h4 class="alert_success">Warning: Student Registeration-No will be attached with the Message.</h4>
	</div>
	<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Send Notification:</h3></header>
			<div class="module_content"><!-- Showing the list of subject for the registeration-->
				
					<div>
						<form method="POST" action="send_notification_action.php" >
						<table width="100%" align="center">
							<tr>
								<td style="font-weight:bold; font-size:15px;">Teacher of: </td>
								<td>
									<select name="toTeacher" id="toTeacher"><!--Generate a List of Subjects of Current Semester -->
										<?php
											$sql=mysql_query("SELECT subject.SubjectID, subject.Name, subjecttostudy.SectionID FROM subject JOIN subjecttostudy " .
												"ON subject.SubjectID = subjecttostudy.SubjectID " .
												"WHERE subjecttostudy.StudentID = '" .$id. "'");//executing the query to show the current semester subjects
											while($row=mysql_fetch_array($sql))//fetching the list of records 1-by-1
											{
												echo "<option value='$row[SubjectID].$row[SectionID]'>".$row['Name']."</option>";//[assing subject and class id
											}
										?>
									</select>
								</td><!--Selecting the Teacher to send notification -->
							</tr>
							
							<tr>
								<td style="font-weight:bold; font-size:15px;">Details: <font color="red">*</font></td>
								<td>
									<textarea rows="5" cols="50" name="notificationDetails" id="notificationDetails" required onkeypress="return imposeMaxLength(this, 157);"></textarea>
									&nbsp;<span><font color="grey">Max Characters: 157</font></span>
								</td><!--Student Will Write Message Here-->
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
	<?php } ?>
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
