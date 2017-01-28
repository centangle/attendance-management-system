<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

	<!-- ajax function for loading the slots -->
	<script>
	function loadslots(str){
				$.ajax({
				url: 'get_slots.php?q='+str,
				success: function(data) {
				$('#res5').html(data);
				//alert('Loaded.');
		  }
		});
		}
	</script>

	<script>
        $(document).ready(function() { $("#e1").select2(); });
    </script>
	
<?php
	include_once('../common/config.php'); //including DB Connection File
	
	$subjectID=$_GET['q'];//posting subject id
	$diciplineID=$_GET['d'];//posting department ID
	$semesterNo=$_GET['s']; //posting Semester Number
	$sectionID=$_GET['sec'];//posting section id
	
	//echo $subjectID." ".$diciplineID." ".$semesterNo." ".$sectionID;
	
?>
	<!-- CSS + javascript for Select box widget -->
	<link href="../css/select2.css" rel="stylesheet"/>
    <script src="../css/select2.js"></script>
	<?php
		if ($subjectID!="0")
		{
	?>
	<!--add time table form -->
	<form method="POST" action="add_timetable_action.php">
		<table width="100%" align="center">
			<tr>
				<td style="font-weight:bold; font-size:15px;">Select Day: </td>
				<td>
					<select name="day" onchange="loadslots(this.value);">
						<option>--Select--</option>
						<option value="1">Monday</option>
						<option value="2">Tuesday</option>
						<option value="3">Wednesday</option>
						<option value="4">Thursday</option>
						<option value="5">Friday</option>
						<option value="6">Saturday</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td style="font-weight:bold; font-size:15px;">Select Slot: </td>
				<td>
					<select name="slotID" id="res5">
					</select>
				</td>
			</tr>
			
			<tr>
				<td style="font-weight:bold; font-size:15px;">Select Room </td>
				<td>
					<select id="e1" name="roomID">
						<?php
						$result = mysql_query("SELECT room.RoomID, room.RoomCode, room.Lab, room.Floor, block.Name FROM room JOIN block ON room.BlockID=block.BlockID"); // applying query to generate room numbers
										
						while($rows = mysql_fetch_array($result)) //will return the list of rooms from database
						{
							$lab=$rows['Lab'];
								if ($lab=="1")
								{
									echo "<option value='$rows[RoomID]'>".$rows['RoomCode']."(Lab)-".$rows['Name']."-"."Floor".$rows['Floor']."</option>";
								}
									else echo "<option value='$rows[RoomID]'>".$rows['RoomCode']."-".$rows['Name']."-"."Floor".$rows['Floor']."</option>";
						}
						?>
					</select>
				</td>
			</tr>
			
			<!-- hidden Fields -->
			<input type="hidden" name="diciplineID" value="<?php echo $diciplineID;?>"/>
			<input type="hidden" name="semesterNo" value="<?php echo $semesterNo;?>"/>
			<input type="hidden" name="sectionID" value="<?php echo $sectionID;?>"/>
			<input type="hidden" name="subjectID" value="<?php echo $subjectID;?>"/>
			
			<tr>
				<td colspan="2" align="center">
					<input type="submit" value="Submit"/>
				</td>
			</tr>
	</form>
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
	