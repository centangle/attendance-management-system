<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
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
				echo'<script type="text/javascript">alert("Error: Assesment Already Open. No Record Updated");</script>';//showing the alert box to notify the message to the user
				break;
			case 3://message 3 case
				echo'<script type="text/javascript">alert("Error: Assesment Already Close. No Record Updated");</script>';//showing the alert box to notify the message to the user
				break;
			case 4://message 4 case
				echo'<script type="text/javascript">alert("Success: Assesment Criteria Updated.");</script>';//showing the alert box to notify the message to the user
				break;
			case 5://message 5 case
				echo'<script type="text/javascript">alert("Error: Interest List Already Open. No Record Updated");</script>';//showing the alert box to notify the message to the user
				break;
			case 6://message 6 case
				echo'<script type="text/javascript">alert("Error: Interes List Already Close. No Record Updated");</script>';//showing the alert box to notify the message to the user
				break;
			case 7://message 7 case
				echo'<script type="text/javascript">alert("Success: Interest List Criteria Updated.");</script>';//showing the alert box to notify the message to the user
				break;
			case 8://message 8 case
				echo'<script type="text/javascript">alert("Error: Course Registeration Already Open. No Record Updated");</script>';//showing the alert box to notify the message to the user
				break;
			case 9://message 9 case
				echo'<script type="text/javascript">alert("Error: Course Registeration Already Close. No Record Updated");</script>';//showing the alert box to notify the message to the user
				break;
			case 10://message 10 case
				echo'<script type="text/javascript">alert("Success: Course Registeration Criteria Updated.");</script>';//showing the alert box to notify the message to the user
				break;
			case 11://message 11 case
				echo'<script type="text/javascript">alert("Error: Value Already Existed. No Record Updated");</script>';//showing the alert box to notify the message to the user
				break;
			case 12://message 12 case
				echo'<script type="text/javascript">alert("Success: Maximum Credit Hours Criteria Updated.");</script>';//showing the alert box to notify the message to the user
				break;
			case 13://message 13 case
				echo'<script type="text/javascript">alert("Error: Value Already Existed. No Record Updated");</script>';//showing the alert box to notify the message to the user
				break;
			case 14://message 14 case
				echo'<script type="text/javascript">alert("Success: Minimum Credit Hours Criteria Updated.");</script>';//showing the alert box to notify the message to the user
				break;
			case 15://message 15 case
				echo'<script type="text/javascript">alert("Error: Value Already Existed. No Record Updated");</script>';//showing the alert box to notify the message to the user
				break;
			case 16://message 16 case
				echo'<script type="text/javascript">alert("Success: Subject Repeat Criteria Updated.");</script>';//showing the alert box to notify the message to the user
				break;
			case 17://message 17 case
				echo'<script type="text/javascript">alert("Success: Value already existed.");</script>';//showing the alert box to notify the message to the user
				break;
			case 18://message 18 case
				echo'<script type="text/javascript">alert("Success: Upload File Size Criteria Updated.");</script>';//showing the alert box to notify the message to the user
				break;
			case 19://message 19 case
				echo'<script type="text/javascript">alert("Error: Course Allotment Already Open. No Records Updated");</script>';//showing the alert box to notify the message to the user
				break;
			case 20://message 20 case
				echo'<script type="text/javascript">alert("Error Course Allotment Already Closed: No Records Updated.");</script>';//showing the alert box to notify the message to the user
				break;
			case 21://message 21 case
				echo'<script type="text/javascript">alert("Success: Course Allotment Criteria Updated.");</script>';//showing the alert box to notify the message to the user
				break;
		}
	?>
<body>
	<?php include"adminheader.php"; //<!--side bar menu for the Admin -->
	include_once("../common/config.php"); //including DB Connection File
	?>
	
		<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Maintain Criteria:</h3></header>
			<div class="module_content"><!-- Showing the notification form for sending alert to the users of the system-->
					<div>
						<table width="100%" align="center">
						<form method="POST" action="set_assesment_action.php"><!-- Set Criteria Form-->
							<tr>
								<td style="font-weight:bold; font-size:12px;">Course Assesment: <font color="red">*</font></td>
								<td>
									<select name="assesmentStatus" id="assesmentStatus">
										<option value="Open" selected>Open</option>
										<option value="Close">Close</option>
									</select>
								</td>
								<td>
									<b>Database Stauts:</b><!-- previous Database Stauts in database -->
									<?php
										$sql=mysql_query("SELECT Value FROM criteria WHERE Entity='Assesment'");
										$row=mysql_fetch_array($sql);
										
										echo $row['Value'];
									?>
								</td>
								<td>
									<input type="submit"  value="Submit">
								</td>
							</tr>
						</form>
						
						<tr><td colspan="4"><hr /></td></tr>
						
						<form method="POST" action="set_interestlist_action.php"><!-- Set Criteria Form-->
							<tr>
								<td style="font-weight:bold; font-size:12px;">Interest List: <font color="red">*</font></td>
								<td>
									<select name="interesListStatus" id="interesListStatus">
										<option value="Open" selected>Open</option>
										<option value="Close">Close</option>
									</select>
								</td>
								<td>
									<b>Database Stauts:</b><!-- previous Database Stauts in database -->
									<?php
										$sql1=mysql_query("SELECT *FROM criteria WHERE Entity='InterestCourse'");
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
						
						<form method="POST" action="set_courseregisteration_action.php" ><!-- Set Criteria Form-->
							<tr>
								<td style="font-weight:bold; font-size:12px;">Course Registeration: <font color="red">*</font></td>
								<td>
									<select name="courseRegisterationStatus" id="courseRegisterationStatus">
										<option value="Open" selected >Open</option>
										<option value="Close">Close</option>
									</select>
								</td>
								<td>
									<b>Database Stauts:</b><!-- previous Database Stauts in database -->
									<?php
										$sql2=mysql_query("SELECT *FROM criteria WHERE Entity='RegisterCourse'");
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
						
						<form method="POST" action="set_courseallotment_action.php" ><!-- Set Criteria Form-->
							<tr>
								<td style="font-weight:bold; font-size:12px;">Course Allotment: <font color="red">*</font></td>
								<td>
									<select name="courseAllotmentStatus" id="courseAllotmentStatus">
										<option value="Open" selected >Open</option>
										<option value="Close">Close</option>
									</select>
								</td>
								<td>
									<b>Database Stauts:</b><!-- previous Database Stauts in database -->
									<?php
										$sql7=mysql_query("SELECT *FROM criteria WHERE Entity='CourseAllotment'");
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
						
						<form method="POST" action="set_maxcredit_action.php"><!-- Set Criteria Form-->
							<tr>
								<td style="font-weight:bold; font-size:12px;">Max Credit Hours:<font color="red">*</font></td>
								<td>
									<input type="text" name="maxCreditHours" id="maxCreditHours" placeholder="max credit hour limit" pattern="^[1-9][0-9]*$" required />
									<span><font color="grey">Hint: Integer<font></span>
								</td>
								<td>
									<b>Database Stauts:</b><!-- previous Database Stauts in database -->
									<?php
										$sql3=mysql_query("SELECT *FROM criteria WHERE Entity='MaxCreditHours'");
										$row3=mysql_fetch_array($sql3);
										
										echo $row3['Value'];
									?>
								</td>
								<td>
									<input type="submit" value="Submit">
								</td>
							</tr>
						</form>
						
						<tr><td colspan="4"><hr /></td></tr>
						
						<form method="POST" action="set_mincredit_action.php"><!-- Set Criteria Form-->
							<tr>
								<td style="font-weight:bold; font-size:12px;">Min Credit Hours: <font color="red">*</font></td>
								<td>
									<input type="text" name="minCreditHours" id="minCreditHours" placeholder="min credit hour limit" pattern="^[1-9][0-9]*$" required />
									<span><font color="grey">Hint: Integer<font></span>
								</td>
								<td>
									<b>Database Stauts:</b><!-- previous Database Stauts in database -->
									<?php
										$sql4=mysql_query("SELECT *FROM criteria WHERE Entity='MinCreditHours'");
										$row4=mysql_fetch_array($sql4);
										
										echo $row4['Value'];
									?>
								</td>
								<td>
									<input type="submit" value="Submit">
								</td>
							</tr>
						</form>
						
						<tr><td colspan="4"><hr /></td></tr>
						
						<form method="POST" action="set_subjectrepeat_action.php"><!-- Set Criteria Form-->
							<tr>
								<td style="font-weight:bold; font-size:12px;">Subject Repeat: <font color="red">*</font></td>
								<td>
									<input type="text" name="subjectRepeat" id="subjectRepeat" placeholder="subject repeat limit" pattern="^[1-9][0-9]*$" required />
									<span><font color="grey">Hint: Integer<font></span>
								</td>
								<td>
									<b>Database Stauts:</b><!-- previous Database Stauts in database -->
									<?php
										$sql5=mysql_query("SELECT *FROM criteria WHERE Entity='SubjectRepeat'");
										$row5=mysql_fetch_array($sql5);
										
										echo $row5['Value'];
									?>
								</td>
								<td>
									<input type="submit" value="Submit">
								</td>
							</tr>
						</form>
						<tr><td colspan="4"><hr /></td></tr>
						<form method="POST" action="set_uploadsize_action.php"><!-- Set Criteria Form-->
							<tr>
								<td style="font-weight:bold; font-size:12px;">Max Upload Size: <font color="red">*</font></td>
								<td>
									<input type="text" name="uploadSize" id="uploadSize" placeholder="upload file size limit" pattern="^[1-9][0-9]*$" required />
									<span><font color="grey">Hint: Integer<font></span>
								</td>
								<td>
									<b>Database Stauts:</b><!-- previous Database Stauts in database -->
									<?php
										$sql6=mysql_query("SELECT *FROM criteria WHERE Entity='UploadFileSize'");
										$row6=mysql_fetch_array($sql6);
										
										echo $row6['Value']." MB";
									?>
								</td>
								<td>
									<input type="submit" value="Submit">
								</td>
							</tr>
						</form>
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
