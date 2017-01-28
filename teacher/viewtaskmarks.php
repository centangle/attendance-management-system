<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title>View Task Marks</title> <!--title of the page -->
	<?php 
		include"../common/library.php"; 
		include"../common/tablelibrary.php";
	?><!-- Common Libraries containg CSS and Java script files-->
</head>
	<?php
		if(is_numeric($_GET['ErrorID']))//getting message ids from action file
		$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
		switch($error){
			case 3://message 3 case
				echo'<script type="text/javascript">alert("Success: Marks Updated Successfully.");</script>';//showing the alert box to notify the message to the user
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
			
			$unsafe="RegisterCourse";
			$showTimetable=clean($unsafe);
			
			$unsafe="Close";
			$status=clean($unsafe);
			
			$res = mysql_query("SELECT * FROM `criteria` WHERE `Entity` ='$showTimetable' AND `Value`='$status'");//SELECTING THE user records 
			$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
			if($row)
			{
				$sql12=mysql_query("SELECT *FROM task WHERE TaskID='$taskID'");
				$row12=mysql_fetch_array($sql12);
				
				$taskName=$row12['Title'];
				$totalMarks=$row12['TotalMarks'];
				
		?>
	<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting">
		<!-- inserting DataTable Code Here that shows the list of student enrolled in the selected section -->
		<tr>
			<td>
				<div class="da-panel collapsible">
					<div class="da-panel-header">
						<span class="da-panel-title">
							<img src="../images/list.png" alt="List" />
							<b>Marks of Students in : <?php echo $taskName;?></b>
						</span>
					</div>
					<div class="da-panel-content">
						<table id="da-ex-datatable-numberpaging" class="da-table">
							<thead>
								<tr><!--Headings of the page -->
									<th>Sr#</th>
									<th width="20%">Name</th>
									<th width="20%">Registeration No</th>
									<th width="20%">Total Marks</th>
									<th width="20%">Obtained Marks</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									//code for displaying the list of classes in the selected section 
									$sql=mysql_query("SELECT *FROM marks WHERE TaskID='$taskID'");
										$i=0;
										while($row=mysql_fetch_array($sql))
										{
											$tID=$row['TaskID'];
											$stID=$row['StudentID'];
											
											$sql12=mysql_query("SELECT *FROM student WHERE StudentID='$stID'");
											$row12=mysql_fetch_array($sql12);
								?>
									<tr>
									   <td>
											<?php 
												echo ($i+1);
											?>
									   </td><!-- printing record no -->
									   
									   <td>
											<?php 
												$title=$row12['Name'];
												echo $title;
											?>
									   </td><!-- printing Title -->
									   
									   <td>
											<?php
												$whom= $row12['RegistrationNo'];
												echo $whom;
											?>
									   </td><!-- printing registration number-->
									   <td>
											<?php
												echo $totalMarks;
											?>
									   </td><!-- printing total marks details-->
									   <td>
											<?php
												$obtMarks=$row['ObtainedMarks'];
												echo $obtMarks;
											?>
									   </td><!-- printing obtain marks details-->
									   <td>
										<a  href="updatemarks.php?tid=<?php echo $tID;?>&sbID=<?php echo $subjectID;?>&scID=<?php echo $sectionID?>&stID=<?php echo $stID;?>">
											<img src="../images/ic_edit.png"width="12" height="12" alt="Delete">
											Update
										</a>
									   </td>
									</tr>
								<?php
										$i++;
										}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</td>
		</tr>
	</table>
	<p align="center">
		<a href="viewtasks.php?sbID=<?php echo $subjectID;?>&scID=<?php echo $sectionID;?>">
			<button type="button">GoBack</button>
		</a>
	</p>
		
		<?php 
			}
		else
			{
		?>
		<div class="inlineSetting">
		<h4 class="alert_success"><?php echo "Course Registeration Open: Articles Option Is Currently Not Availiable."?></h4>
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
