<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title> Update Attendance</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
</head>
<body>
	<?php 
		include"teacherheader.php";//<!--side bar menu for the Student -->
	    include_once("../common/commonfunctions.php"); //including Common function library
	    include_once("../common/config.php"); //including Common function library
		
		$profileID=$_SESSION['TeacherID'];//unsafe variable
		$id=clean($profileID);//cleaning id to preven SQL Injection
		
		if(is_numeric($_GET['lid']))
		$unsafe=$_GET['lid'];
		$lectureID=clean($unsafe);//cleaning the variable
		
		if(is_numeric($_GET['sbID']))
		$unsafe=$_GET['sbID'];
		$subjectID=clean($unsafe);//cleaning the variable
		
		if(is_numeric($_GET['scID']))
		$unsafe=$_GET['scID'];
		$sectionID=clean($unsafe);//cleaning the variable
		
		if(is_numeric($_GET['sID']))
		$unsafe=$_GET['sID'];
		$studentID=clean($unsafe);//cleaning the variable
		
		
		$res1 = mysql_query("SELECT *FROM `criteria` WHERE `Entity` ='CUD' AND `Value`='Open'");//SELECTING THE  records 
		$row1 = mysql_fetch_array($res1);//fetching record as a set of array of selected value
		if($row1)
		{
	?>
	<!-- Query to Get the Details of the Selected Student -->
	<?php
		$sql1=mysql_query("SELECT *FROM attendance WHERE StudentID='$studentID' AND LectureID='$lectureID'");
		$row1=mysql_fetch_array($sql1);
	?>
	<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Update Attendance:</h3></header>
			<div class="module_content"><!-- Showing the list of subject for the lectures-->
					<div>
						<form action="update_attendance_action.php?lid=<?php echo $lectureID;?>&sbID=<?php echo $subjectID?>&scID=<?php echo $sectionID?>" method="POST">
						<table width="100%" align="center">
							<tr>
								<td style="font-weight:bold; font-size:15px;">Status: </td>
								<td style="color:grey;"> 
									<select name="status">
										<?php 
											$opt= $row1['Present'];//posting value from the database
											echo "<option value='$opt'>";
											if($opt=='0')
												echo "Absent";
												else 
													echo "Present";
											echo "</option>"
										?>
										<?php
											if($opt=='0')
											{
										?>
										<option value="1">Present</option>
										<?php }
											if($opt=='1')
											{
										?>
										<option value="0">Absent</option>
										<?php }?>
									<select>
								</td><!--Posting  Title-->
							</tr>
							
							<tr>
								<td colspan="4" align="center">
									<input type="submit" value="Update"/>
									|
									<a href="attendancedetails.php?lid=<?php echo $lectureID;?>&sbID=<?php echo $subjectID?>&scID=<?php echo $sectionID?>">
										<button type="button">GoBack</button>
									</a>
								</td>
							</tr>
						</table>
					</div>
				
				<div class="clear"></div>
			</div>
	</article><!-- end of stats article -->
	<?php
		}
		else
			{
	?>
			<div class="inlineSetting">
			<h4 class="alert_success"><?php echo "Addition/Updation/Deletion is Closed by the Coordinator. <a href='attendancedetails.php?lid=$lectureID&sbID=$subjectID&scID=$sectionID'>GoBack</a>"?></h4>
			</div>
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
