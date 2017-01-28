<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->
	 <script type="text/javascript">
		function delete()
		{
			var cnfrm=confirm("Are you sure you want to delete?");
			if(cnfrm)
			{
				window.location="deletetimetable.php";
			}
		}
	</script>
<?php
	include_once('../common/config.php'); //including DB Connection File
	include_once('../common/commonfunctions.php'); //including common functions File
	
	$subjectID=$_GET['q'];//posting subject id
	$diciplineID=$_GET['d'];//posting department ID
	$semesterNo=$_GET['s']; //posting Semester Number
	$sectionID=$_GET['sec'];//posting section id
	
	//echo $subjectID." ".$diciplineID." ".$semesterNo." ".$sectionID;
	
	$sql3=mysql_query("SELECT *FROM class WHERE SubjectID='$subjectID' AND SectionID='$sectionID'");
	$row3=mysql_fetch_array($sql3);
	
	$unsafe=$row3['ClassID'];//posting classID
	$classID=clean($unsafe);//cleaning the variable
?>

	<?php
		if ($subjectID!="0")
		{
	?>
	<div class="da-panel collapsible">
		<div class="da-panel-header">
			<span class="da-panel-title">
				<img src="../images/list.png" alt="List" />
				<b>Time Table Details</b>
			</span>
		</div>
		<div class="da-panel-content">
			<table id="da-ex-datatable-numberpaging" class="da-table">
				<thead>
					<tr><!--Headings of the page -->
						<th>Class#</th>
						<th>Time</th>
						<th>Day</th>
						<th>Room</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						//code for displaying the list of classes in the selected section 
						$sql=mysql_query("SELECT *FROM timetable WHERE ClassID='$classID'");
							$i=0;
							while($row=mysql_fetch_array($sql))
							{
					?>
							<tr>
							   <td><?php echo ($i+1); ?></td><!-- printing class no -->
							   <td>
									<?php
										$slotID=$row['SlotID'];
										$sql1=mysql_query("SELECT *FROM slot WHERE SlotID='$slotID'");
										$row1=mysql_fetch_array($sql1);
										
										$time= $row1['StartTime']." to ".$row1['EndTime'];
										echo $time;
									?>
							   </td><!-- printing time-->
							   <td>
									<?php
										$day=$row1['Day'];
										if($day==1)
											echo "Monday";
											if($day==2)
												echo "Tuesday";
													if($day==3)
													echo "Wednesday";
														if($day==4)
														echo "Thursday";
															if($day==5)
															echo "Friday";
																if($day==6)
																echo "Saturday";
									?>
							   </td><!-- printing Day-->
							   <td>
									<?php
										$roomID= $row['RoomID'];
										$sql9=mysql_query("SELECT room.RoomCode, room.Lab, room.Floor, block.Name FROM room JOIN block ON room.BlockID=block.BlockID WHERE room.RoomID='$roomID'");
										$row9=mysql_fetch_array($sql9);
										
										$room=$row9['RoomCode']."-".$row9['Name']."-"."Floor".$row9['Floor'];
										echo $room;
									?>
							   </td> <!-- printing room-->
							   <td>
								<a href="updatetimetable.php">
									<img src="../images/ic_edit.png" width="12" height="12" alt="Edit">
								</a>
								<a  href="javascript:delete()">
									<img src="../images/ic_cancel.png"width="12" height="12" alt="Delete">
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

	<?php
		}
		else
			{
	?>
		<h1><font color="red">No Subject Selected</font></h1>
	<?php
			}
	?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>
	