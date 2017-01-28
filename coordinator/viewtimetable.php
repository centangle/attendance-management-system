<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title>View TimeTable</title> <!--title of the page -->
	<?php 
		include"../common/library.php"; 
		include"../common/tablelibrary.php";
	?><!-- Common Libraries containg CSS and Java script files-->
	
	<script>
		function deleteuser(val, val1, val2)
		{
			var cnfrm=confirm("Are you sure you want to delete?");
			if(cnfrm)
			{
				window.location="deletetimetable.php?cid="+val+"&rid="+val1+"&sid="+val2;
			}
		}
	</script>
	
</head>
	<?php
		if(is_numeric($_GET['ErrorID']))//getting message ids from action file
		$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
		switch($error){
			case 1://message 1 case
				echo'<script type="text/javascript">alert("Success: Timetable Deleted Successfully.");</script>';//showing the alert box to notify the message to the user
				break;
			case 5://message 5 case
				echo'<script type="text/javascript">alert("Success: Timetable has been Updated successfully.");</script>';//showing the alert box to notify the message to the user
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
			
			$unsafe="ShowTimetable";
			$showTimetable=clean($unsafe);
			
			$unsafe="Close";
			$status=clean($unsafe);
			
			$res = mysql_query("SELECT * FROM `criteria` WHERE `Entity` ='$showTimetable' AND `Value`='$status'");//SELECTING THE user records 
			$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
			if($row)
			{
		?>
	<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting">
		<!-- inserting DataTable Code Here that shows the list of student enrolled in the selected section -->
		<tr>
			<td>
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
									<th width="20%">Subject</th>
									<th width="7%">Section</th>
									<th width="20%">Time</th>
									<th width="10%">Day</th>
									<th width="27%">Room</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									//code for displaying the list of classes in the selected section 
									$sql=mysql_query("SELECT *FROM timetable");
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
												
												$lab=$row9['Lab'];
												if($lab=='0')
												{
													$room=$row9['RoomCode']."-".$row9['Name']."-"."Floor".$row9['Floor'];
													echo $room;
												}
												else 
												{
													$room=$row9['RoomCode']."-".$row9['Name']."-"."Floor".$row9['Floor']."- (Lab)";
													echo $room;
												}
											?>
									   </td> <!-- printing room-->
									   <td>
										<a href="updatetimetable.php?cid=<?php echo $classID;?>&rid=<?php echo $roomID;?>&sid=<?php echo $slotID;?>">
											<img src="../images/ic_edit.png" width="12" height="12" alt="Edit">
										</a>
										<a  href="javascript:deleteuser('<?php echo $classID;?>','<?php echo $roomID;?>','<?php echo $slotID;?>')">
											<img src="../images/ic_cancel.png"width="12" height="12" alt="Delete">
										</a>
									   </td>
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
		
		<?php 
			}
		else
			{
		?>
		<div class="inlineSetting">
		<h4 class="alert_success"><?php echo "Show TimeTable is Open. Change Criteria First!"?></h4>
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
