<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title>Maintain Criteria</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
</head>
	<?php
		if(is_numeric($_GET['ErrorID']))//getting message ids from action file
		$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
		switch($error){
			case 1://message 1 case
				echo'<script type="text/javascript">alert("Error: Empty field are not allowed.");</script>';//showing the alert box to notify the message to the user
				break;
			case 2://message 2 case
				echo'<script type="text/javascript">alert("Error: Add/Update Lecture Already Open. No Record Updated");</script>';//showing the alert box to notify the message to the user
				break;
			case 3://message 3 case
				echo'<script type="text/javascript">alert("Error: Add/Update Lecture Already Close. No Record Updated");</script>';//showing the alert box to notify the message to the user
				break;
			case 4://message 4 case
				echo'<script type="text/javascript">alert("Success: Add/Update Lecture Criteria Updated.");</script>';//showing the alert box to notify the message to the user
				break;
			case 5://message 5 case
				echo'<script type="text/javascript">alert("Error: LowMarks Value Already Existed. No Record Updated");</script>';//showing the alert box to notify the message to the user
				break;
			case 6://message 6 case
				echo'<script type="text/javascript">alert("Success: LowMarks Criteria Updated Successfully");</script>';//showing the alert box to notify the message to the user
				break;
			case 7://message 7 case
				echo'<script type="text/javascript">alert("Error: Show Timetable Already Open. No Record Updated");</script>';//showing the alert box to notify the message to the user
				break;
			case 8://message 8 case
				echo'<script type="text/javascript">alert("Error: Show Timetable Already Close. No Record Updated");</script>';//showing the alert box to notify the message to the user
				break;
			case 9://message 9 case
				echo'<script type="text/javascript">alert("Success: Show Timetable Criteria Updated Successfully.");</script>';//showing the alert box to notify the message to the user
				break;
			case 10://message 10 case
				echo'<script type="text/javascript">alert("Error: Marks Deadline Already Existed. No Record Updated.");</script>';//showing the alert box to notify the message to the user
				break;
			case 11://message 11 case
				echo'<script type="text/javascript">alert("Error: Marks Deadline Should be Greater than Current Date.");</script>';//showing the alert box to notify the message to the user
				break;
			case 12://message 12 case
				echo'<script type="text/javascript">alert("Success: Marks Deadline Criteria Updated Successfully.");</script>';//showing the alert box to notify the message to the user
				break;
		}
	?>
<body>
	<?php include"coordinatorheader.php"; //<!--side bar menu for the Admin -->
	include_once("../common/config.php"); //including DB Connection File
	?>
	
		<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Maintain Criteria:</h3></header>
			<div class="module_content"><!-- Showing the notification form for sending alert to the users of the system-->
					<div>
						<table width="100%" align="center">
						<form method="POST" action="set_cud_action.php"><!-- Set Criteria Form-->
							<tr>
								<td style="font-weight:bold; font-size:12px;">Create/Update/Delete(CUD):<font color="red">*</font></td>
								<td>
									<select name="cudStatus" id="cudStatus">
										<option value="Open" selected>Open</option>
										<option value="Close">Close</option>
									</select>
								</td>
								<td>
									<b>Database Stauts:</b><!-- previous Database Stauts in database -->
									<?php
										$sql=mysql_query("SELECT Value FROM criteria WHERE Entity='CUD'");
										$row=mysql_fetch_array($sql);
										
										echo $row['Value'];
									?>
								</td>
								<td>
									<input type="submit"  value="Submit"/>
								</td>
							</tr>
						</form>
						
						<tr><td colspan="4"><hr /></td></tr>
						
						<form method="POST" action="set_lowmarks_action.php"><!-- Set Criteria Form-->
							<tr>
								<td style="font-weight:bold; font-size:12px;">Low Marks: <font color="red">*</font></td>
								<td>
									<input type="text" name="lowMarksStatus" id="lowMarksStatus" placeholder="Low marks limit" pattern="^[1-9][0-9]*$" required />
									<span><font color="grey">Hint: Integer<font></span>
								</td>
								<td>
									<b>Database Stauts:</b><!-- previous Database Stauts in database -->
									<?php
										$sql1=mysql_query("SELECT *FROM criteria WHERE Entity='LowMarks'");
										$row1=mysql_fetch_array($sql1);
										
										echo $row1['Value'];
									?>
								</td>
								<td>
									<input type="submit" value="Submit">
								</td>
							</tr>
						</form>
						
						<tr><td colspan="4"><hr /></td></tr>
						
						<form method="POST" action="set_showtimetable_action.php" ><!-- Set Criteria Form-->
							<tr>
								<td style="font-weight:bold; font-size:12px;">Show TimeTable: <font color="red">*</font></td>
								<td>
									<select name="timeTabStatus" id="timeTabStatus">
										<option value="Open" selected >Open</option>
										<option value="Close">Close</option>
									</select>
								</td>
								<td>
									<b>Database Stauts:</b><!-- previous Database Stauts in database -->
									<?php
										$sql7=mysql_query("SELECT *FROM criteria WHERE Entity='ShowTimetable'");
										$row7=mysql_fetch_array($sql7);
										
										echo $row7['Value'];
									?>
								</td>
								<td>
									<input type="submit" value="Submit">
								</td>
							</tr>
						</form>
						
						<tr><td colspan="4"><hr /></td></tr>
						
						<form method="POST" action="set_deadline_action.php" ><!-- Set Criteria Form-->
							<tr>
								<td style="font-weight:bold; font-size:12px;">CUD Deadline: <font color="red">*</font></td>
								<td>
									<input type="text" name="deadlineDate" id="deadlineDate"  placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[/.](0[1-9]|[12][0-9]|3[01])[/.](19|20)\d\d$" required />
									&nbsp;<span><font color="grey">Hint: mm/dd/yyyy</font></span>
									<script>
									  $(function() 
										{
											$( "#deadlineDate" ).datepicker({minDate:"0D", maxDate: "+80Y"});
										});
									</script>
								</td>
								<td>
									<b>Database Stauts:</b><!-- previous Database Stauts in database -->
									<?php
										$sql2=mysql_query("SELECT *FROM criteria WHERE Entity='MarksDeadline'");
										$row2=mysql_fetch_array($sql2);
										
										echo $row2['Value'];
									?>
								</td>
								<td>
									<input type="submit" value="Submit">
								</td>
							</tr>
						</form>
						
						<tr><td colspan="4"><hr /></td></tr>
						
						</table>
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
