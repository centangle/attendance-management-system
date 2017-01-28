<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title>View Alloted Courses</title> <!--title of the page -->
	<?php 
		include"../common/library.php"; 
		include"../common/tablelibrary.php";
	?><!-- Common Libraries containg CSS and Java script files-->
	
	<script>
		function deleteuser(val, val1)
		{
			var cnfrm=confirm("Are you sure you want to delete?");
			if(cnfrm)
			{
				window.location="deleteallotedcourses.php?cid="+val+"&tid="+val1;
			}
		}
	</script>
	
</head>
	<?php
		if(is_numeric($_GET['ErrorID']))//getting message ids from action file
		$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
		switch($error){
			case 5://message 5 case
				echo'<script type="text/javascript">alert("Success: Alloted course deleted successfully.");</script>';//showing the alert box to notify the message to the user
				break;
		}
	?>
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
							<b>View Alloted Courses</b>
						</span>
					</div>
					<div class="da-panel-content">
						<table id="da-ex-datatable-numberpaging" class="da-table">
							<thead>
								<tr><!--Headings of the page -->
									<th>Serial No.</th>
									<th width="25%">Subject</th>
									<th width="10%">Code</th>
									<th width="10%">CreditHours</th>
									<th width="10%">Section</th>
									<th width="20%">Teacher</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									//code for displaying the list of classes in the selected section 
									$sql=mysql_query("SELECT *FROM subjecttoteach");
										$i=0;
										while($row=mysql_fetch_array($sql))
										{
								?>
									<tr>
										<td><?php echo ($i+1);?></td>
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
												$code=$row7['Code'];
												echo $code;
											?>
									   </td><!-- printing Subject code -->
									   <td>
											<?php
												$cH=$row7['CreditHours'];
												echo $cH;
											?>
									   </td><!-- printing Credit Hours -->
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
												$teacherID=$row['TeacherID'];
												$sql1=mysql_query("SELECT *FROM teacher WHERE TeacherID='$teacherID'");
												$row1=mysql_fetch_array($sql1);
												
												$name= $row1['Name'];
												echo $name;
											?>
									   </td><!-- printing name-->
									   
									   <td>
										<?php
											$unsafe="CourseAllotment";
											$courseAllotment=clean($unsafe);
											
											$unsafe="Open";
											$status=clean($unsafe);
											
											$res = mysql_query("SELECT * FROM `criteria` WHERE `Entity` ='$courseAllotment' AND `Value`='$status'");//SELECTING THE user records 
											$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
											if($row)
											{
										?>
										<a  href="javascript:deleteuser('<?php echo $classID;?>','<?php echo $teacherID;?>')">
											<img src="../images/ic_cancel.png"width="12" height="12" alt="Delete">
										</a>
										<?php
											}
											else
												{
										?>
											--
										<?php
												}
										?>
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
