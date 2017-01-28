<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title>View Class Attendance</title> <!--title of the page -->
	<?php 
		include"../common/library.php"; 
		include"../common/tablelibrary.php";
	?><!-- Common Libraries containg CSS and Java script files-->
	
</head>
<body>
	<?php include"coordinatorheader.php"; ?><!--side bar menu for the Student -->			
		<?php
			include_once("../common/commonfunctions.php"); //including Common function library
			include_once("../common/config.php"); //including Common function library
			
			$profileID=$_SESSION['CoordinatorID'];//unsafe variable
			$id=clean($profileID);//cleaning id to preven SQL Injection
			
		?>
	<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting">
		<!-- inserting DataTable Code Here that shows the list of student enrolled in the selected section -->
		<tr>
			<td>
				<div class="da-panel collapsible">
					<div class="da-panel-header">
						<span class="da-panel-title">
							<img src="../images/list.png" alt="List" />
							<b>Class Attendance Information</b>
						</span>
					</div>
					<div class="da-panel-content">
						<table id="da-ex-datatable-numberpaging" class="da-table">
							<thead>
								<tr><!--Headings of the page -->
									<th width="25%">Subject</th>
									<th width="10%">Section</th>
									<th>Time</th>
									<th>Date</th>
									<th width="20%">Teacher</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php
									//code for displaying the list of classes in the selected section 
									$sql=mysql_query("SELECT *FROM classattendance");
										while($row=mysql_fetch_array($sql))
										{
								?>
									<tr>
									   <td>
											<?php 
												$classID=$row['ClassID'];
												
												$sql8=mysql_query("SELECT *FROM class WHERE ClassID='$classID'");//query
												$row8=mysql_fetch_array($sql8);
												
												$subID=$row8['SubjectID'];//subjectID
												$secID=$row8['SectionID'];
												
												$sql7=mysql_query("SELECT *FROM subject WHERE SubjectID='$subID'");
												$row7=mysql_fetch_array($sql7);
												
												$subName=$row7['Name'];
												echo $subName;
												
											?>
									   </td><!-- printing Subject -->
									   <td>
											<?php 
												$sql6=mysql_query("SELECT *FROM section WHERE SectionID='$secID'");
												$row6=mysql_fetch_array($sql6);
												
												$section=$row6['Semester'].$row6['SectionCode'];
												echo $section;
											?>
									   </td><!-- printing Section -->
									   <td>
											<?php
												$slotID=$row['SlotID'];
												
												$sql17=mysql_query("SELECT *FROM slot WHERE SlotID='$slotID'");
												$row17=mysql_fetch_array($sql17);
												
												$time=$row17['StartTime']." to ".$row17['EndTime'];
												echo $time;
											?>
									   </td><!--printing Time -->
									   <td>
											<?php echo $row['Date'];?>
									   </td><!--Pritning Date -->
									   <td>
											<?php
												$sql19=mysql_query("SELECT *FROM subjecttoteach WHERE ClassID='$classID'");
												$row19=mysql_fetch_array($sql19);
												$teacherID=$row19['TeacherID'];
												
												$sql1=mysql_query("SELECT *FROM teacher WHERE TeacherID='$teacherID'");
												$row1=mysql_fetch_array($sql1);
												
												$name= $row1['Name'];
												echo $name;
											?>
									   </td><!-- printing name-->
									   <td>
											<?php
												$st=$row['Status'];
												if($st=='0')
													echo "Absent";
													else echo "Present";
											?>
									   </td><!--printing Status -->
									</tr>
								<?php
										}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</td>
		</tr>
	</table>
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
