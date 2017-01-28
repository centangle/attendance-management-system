<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title> Drop Courses</title> <!--title of the page -->
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
				echo'<script type="text/javascript">alert("Success: Subject has been Droped/Withdraw successfully.");</script>';//showing the alert box to notify the message to the user
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
			<h4 class="alert_success">Course Registeration is Open. This Module is Not Available.</h4>
			</div>
	<?php } 
	else
		{
	?>
	<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Details for Drop/Withdraw:</h3></header>
			<div class="module_content"><!-- Showing the notification form for sending alert to the users of the system-->
					<div>
						<form method="POST" action="drop_course_action.php?sid=<?php echo $studentID;?>">
						<table width="100%" align="center">
							<tr>
								<td style="font-weight:bold; font-size:15px;">
									Select Subject:
								</td>
								<td>
									<select name="studentSubject" id="studentSubject" class="selectBigger">	<!-- Generate a list of subjects from Database for Coordinator --> 
										<?php 
											$result = mysql_query("SELECT *FROM subjecttostudy WHERE StudentID='$studentID'"); // applying query to generate list of subject
											while($rows = mysql_fetch_array($result)) //will return the list of Sessions from database
											{
												$subID=$rows['SubjectID'];
												$sql10=mysql_query("SELECT *FROM Subject WHERE SubjectID='$subID'");
												$row10=mysql_fetch_array($sql10);
												
												echo "<option value='$subID'>".$row10['Name']."</option>";
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td style="font-weight:bold; font-size:15px;">
									Select Type: 
								</td>
								<td>
									<select name="type" id="type" class="selectBigger">
										<option value="D">Drop Course</option>
										<option value="W">Withdraw Course</option>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center"><input type="submit" value="Submit"></td>
							</tr>
						</table>
						</form>
					</div>
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
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>
