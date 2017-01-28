<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!--developed by Arslan Khalid -->
<!DOCTYPE html>	<!-- for supporting Html 5 tags -->

<html xmlns="http://www.w3.org/1999/xhtml"> <!-- according to standards of w3.ord -->
<head>
	<title> Attendance Details </title>	<!--title of the page -->
	<?php include"../common/library.php"; 
			include"../common/tablelibrary.php";
	?><!-- Common Libraries containg CSS and Java script files-->
	
</head>
<?php
		if(is_numeric($_GET['ErrorID']))//getting message ids from action file
		$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
		switch($error){
			case 1://message 1 case
				echo'<script type="text/javascript">alert("Error: No Lectures.");</script>';//showing the alert box to notify the message to the user
				break;
			case 2://message 2 case
				echo'<script type="text/javascript">alert("Error: No Class Registered on provided Information.");</script>';//showing the alert box to notify the message to the user
				break;
			case 3://message 3 case
				echo'<script type="text/javascript">alert("Success: Attendace Updated Successfully.");</script>';//showing the alert box to notify the message to the user
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
			
			if(is_numeric($_GET['sbID']) && is_numeric($_GET['scID']) && is_numeric($_GET['lid']))
			{
				$unsafe=$_GET['sbID'];
				$subjectID=clean($unsafe);//cleaning the variable
				
				$unsafe=$_GET['scID'];
				$sectionID=clean($unsafe);//cleaning the variable
				
				$unsafe=$_GET['lid'];
				$lectureID=clean($unsafe);
			}
			
			$unsafe="RegisterCourse";
			$courseAllotment=clean($unsafe);
			
			$unsafe="Close";
			$status=clean($unsafe);
			
			$res = mysql_query("SELECT * FROM `criteria` WHERE `Entity` ='$courseAllotment' AND `Value`='$status'");//SELECTING THE user records 
			$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
			if($row)
			{
		?>	
		<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting">
		<!-- inserting DataTable Code Here that shows the list of student enrolled in the selected section -->
		<tr>
			<td id="result">
				<div class="da-panel collapsible">
		<div class="da-panel-header">
			<span class="da-panel-title">
				<img src="../images/list.png" alt="List" />
				<b>Attendance Details</b>
			</span>
		</div>
		<div class="da-panel-content">
			<table id="da-ex-datatable-numberpaging" class="da-table">
				<thead>
					<tr><!--Headings of the page -->
						<th width="10%">Sr. #</th></th>
						<th width="30%">Name</th>
						<th width="30%">Registration No</th>
						<th width="20%">Stauts</th>
						<th width="10%">Update</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$sql1=mysql_query("SELECT *FROM attendance WHERE LectureID='$lectureID'");
						if(mysql_num_rows($sql1))
						{
						$i=0;
						while($row1=mysql_fetch_array($sql1))
						{
							$lecID=$row1['LectureID'];//lecture id from attendace table for updating the attendance
							$studentID=$row1['StudentID'];
							
							$sql2=mysql_query("SELECT *FROM student WHERE StudentID='$studentID'");
							$row2=mysql_fetch_array($sql2);//return the student record depennding upon the student id
							
					?>
					<tr>
						<td><?php  echo ($i+1);?></td>
						<td><?php  echo $row2['Name'];?></td>
						<td><?php  echo $row2['RegistrationNo'];?></td>
						<td><?php
								$present=$row1['Present'];
								if($present=="0")
									echo "A";
									else
										echo "P";
							?>
						</td>
						<td>
							<a href="updateattendance.php?lid=<?php echo $lectureID;?>&sbID=<?php echo $subjectID;?>&scID=<?php echo $sectionID;?>&sID=<?php echo $studentID;?>">
							<img src="../images/ic_edit.png" width="16" height="16" alt="Edit"></a>
						</td>
					</tr>
					<?php
						$i++;
						}
						}
						else
						{
							redirect_to("lateattendanceform.php?lid=$lectureID&sid=$sectionID&sbid=$subjectID");
							//echo "Attendance Not Marked";
						}
					?>
				</tbody>
			</table>
			<p align="center">
				<a href="attendanceoverview.php?sbID=<?php echo $subjectID?>&scID=<?php echo $sectionID?>">
					<button type="button">GoBack</button>
				</a>
			</p>
			
		</div>
	</div>

			</td>
		</tr>
	</table>
	<?php 
	}
	else{
	?>
	<div class="inlineSetting">
	<h4 class="alert_success"><?php echo "Course Registeration Open: No Sections Assigned Yet."?></h4>
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
