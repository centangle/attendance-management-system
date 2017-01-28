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
	?><!-- Common Libraries containg CSS and Java script files-->
	
	<link href="../css/select2.css" rel="stylesheet"/>
    <script src="../css/select2.js"></script>
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
</head>
	<?php
		if(is_numeric($_GET['ErrorID']))//getting message ids from action file
		$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
		switch($error){
			case 2://message 2 case
				echo'<script type="text/javascript">alert("Error: Values already Exists in Database.");</script>';//showing the alert box to notify the message to the user
				break;
			case 3://message 3 case
				echo'<script type="text/javascript">alert("Error: Slot is not available.");</script>';//showing the alert box to notify the message to the user
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
			
			$unsafe=$_GET['sid'];//posting slotID
			$slotID =clean($unsafe);//Cleaning for the Prevention of SQL Injection
			
			$unsafe=$_GET['rid'];//posting roomID
			$roomID =clean($unsafe);//Cleaning for the Prevention of SQL Injection
			
			$unsafe=$_GET['cid'];//posting class id
			$classID =clean($unsafe);//Cleaning for the Prevention of SQL Injection
			
			$unsafe="ShowTimetable";
			$showTimetable=clean($unsafe);
			
			$unsafe="Close";
			$status=clean($unsafe);
			
			$res = mysql_query("SELECT * FROM `criteria` WHERE `Entity` ='$showTimetable' AND `Value`='$status'");//SELECTING THE user records 
			$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
			if($row)
			{
		?>
		<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Update TimeTable</h3></header>
			<div class="module_content"><!-- Showing the list of options-->
				<form method="POST" action="update_timetable_action.php?cid=<?php echo $classID;?>&rid=<?php echo $roomID;?>&sid=<?php echo $slotID;?>">
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
								<?php
									$sql4=mysql_query("SELECT *FROM slot WHERE SlotID='$slotID'");
									$row4=mysql_fetch_array($sql4);
								?>
								<select name="slotID" id="res5">
									<option selected value="<?php echo $slotID?>"><?php $opt=$row4['StartTime']." to ".$row4['EndTime']; echo $opt; ?></option>
								</select>
							</td>
						</tr>
						
						<tr>
							<td style="font-weight:bold; font-size:15px;">Select Room </td>
							<td>
								<select id="e1" name="roomID">
									
									<?php
									$sql5=mysql_query("SELECT room.RoomCode, room.Lab, room.Floor, block.Name FROM room JOIN block ON room.BlockID=block.BlockID WHERE room.RoomID='$roomID'");
									$row5=mysql_fetch_array($sql5);
									
									$lab=$row5['Lab'];
											if ($lab=="1")
											{
												echo "<option selected value='$roomID'>".$row5['RoomCode']."(Lab)-".$row5['Name']."-"."Floor".$row5['Floor']."</option>";
											}
											else 
											{
												echo "<option selected value='$roomID'>".$row5['RoomCode']."-".$row5['Name']."-"."Floor".$row5['Floor']."</option>";
											}
											
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
						
						<tr>
							<td colspan="2" align="center">
								<input type="submit" value="Update"/>
							</td>
						</tr>
				</form>
			</div>
		</article><!-- end of stats article -->
		
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
