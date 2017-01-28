<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!--developed by Arslan Khalid -->
<!DOCTYPE html>	<!-- for supporting Html 5 tags -->

<html xmlns="http://www.w3.org/1999/xhtml"> <!-- according to standards of w3.ord -->
<head>
	<title> Update Task Marks</title>	<!--title of the page -->
	<?php include"../common/library.php"; ?><!-- Common Libraries containg CSS and Java script files-->
</head>
<?php
		if(is_numeric($_GET['ErrorID']))//getting message ids from action file
		$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
		switch($error){
			case 1://message 1 case
				echo'<script type="text/javascript">alert("Error: Empty Fields are not Allowed.");</script>';//showing the alert box to notify the message to the user
				break;
			case 2://message 2 case
				echo'<script type="text/javascript">alert("Error: Obtained Marks Should be Less than Total Marks. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
				break;
		}
?>

<body>
	<?php include"teacherheader.php"; ?><!--side bar menu for the Student -->
		<?php 				
			include_once("../common/commonfunctions.php"); //including Common function library
			include_once("../common/config.php"); //including Common function library
			
			$profileID=$_SESSION['TeacherID'];//unsafe variable
			$id=clean($profileID);//cleaning id to preven SQL Injection
			
			if(is_numeric($_GET['tid']))
			$unsafe=$_GET['tid'];
			$taskID=clean($unsafe);//cleaning the variable
			
			if(is_numeric($_GET['sbID']))
			$unsafe=$_GET['sbID'];
			$subjectID=clean($unsafe);//cleaning the variable
			
			if(is_numeric($_GET['scID']))
			$unsafe=$_GET['scID'];
			$sectionID=clean($unsafe);//cleaning the variable
			
			if(is_numeric($_GET['stID']))
			$unsafe=$_GET['stID'];
			$studentID=clean($unsafe);//cleaning the variable
			
			$unsafe="RegisterCourse";
			$courseAllotment=clean($unsafe);
			
			$unsafe="Close";
			$status=clean($unsafe);
			
			$res = mysql_query("SELECT *FROM `criteria` WHERE `Entity` ='$courseAllotment' AND `Value`='$status'");//SELECTING THE  records 
			$row = mysql_fetch_array($res);//fetching record as a set of array of selected value
			
			if($row)
			{
				$res1 = mysql_query("SELECT *FROM `criteria` WHERE `Entity` ='CUD' AND `Value`='Open'");//SELECTING THE  records 
				$row1 = mysql_fetch_array($res1);//fetching record as a set of array of selected value
				if($row1)
				{
					$sql12=mysql_query("SELECT *FROM marks WHERE TaskID='$taskID' AND StudentID='$studentID'");
					$row12=mysql_fetch_array($sql12);
		?>	
				<form method="POST" enctype="multipart/form-data" action="updatemarks_action.php?tid=<?php echo $taskID;?>&sbID=<?php echo $subjectID;?>&scID=<?php echo $sectionID?>&stID=<?php echo $studentID?>" ><!-- Add Lectures details Form-->
				<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting"> <!-- for alignment of the form -->
					<tr>
						<td colspan="4"> 
							<hr/>	
							<h2 align="center">Update Task Marks</h2>
							<hr/>
						</td>
					</tr>
					<tr>
						<td style="font-weight:bold; font-size:15px;">Total Marks:<font color="red">*</font></td>
						<td> 
							<input type="text" name="taskMarks" id="taskMarks" placeholder="Enter Obtained Marks" pattern="^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['tasMark'])) {$unsafe=$_SESSION['tasMark']; $lecTitle=clean($unsafe); echo $lecTitle; unset($_SESSION['tasMark']);}} else echo $row12['ObtainedMarks'];?>" required /><!-- Taking input of title of the lecture-->
							&nbsp;<span><font color="grey">Hint: Float Value Only</font></span>
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center">
							<input type="submit" value="Submit"/> | <a href="viewtaskmarks.php?tid=<?php echo $taskID;?>&sbID=<?php echo $subjectID;?>&scID=<?php echo $sectionID?>"><button type="button">GoBack</button></a>
							<hr/>
						</td>
					</tr>
				</table>
				</form>
	<?php 
		}
		else
			{
	?>
			<div class="inlineSetting">
			<h4 class="alert_success"><?php echo "Addition/Updation/Deletion is Closed by the Coordinator."?></h4>
			</div>
	<?php
			}
	}
	else{
	?>
	<div class="inlineSetting">
	<h4 class="alert_success"><?php echo "Course Registeration Open: Add Task Not Availiable."?></h4>
	</div>
	<?php }?>
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
