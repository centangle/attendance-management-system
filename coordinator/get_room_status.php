<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once('../common/config.php'); //including DB Connection File
	include_once('../common/commonfunctions.php'); //including common function File
	include_once('../common/queryfunctions.php'); //including common function File
	include"../common/tablelibrary.php";//<!-- View Table Sorter Related Liberaries -->
	
	$unsafe=$_GET['d'];//getting the Day id
	$Day=clean($unsafe);//cleaning the variable for the prevention of SQL injection
	
	$unsafe=$_GET['l'];//getting the true/false for labs
	$Lab=clean($unsafe);//cleaning the variable
	
?>
	<!-- Queries Developed by Bilal Ahmad Ghouri -->
	<?php
		$sql=mysql_query("SELECT Value FROM criteria WHERE Entity='ShowTimetable'");
		$row=mysql_fetch_array($sql);
		$val=$row[0];//posting the value of the criteria
		if($val=="Close")
		{
			echo "<h1><font color='red'>Currently Not Available. Change Show TimeTable Criteria.</font></h1>";
			exit();
		}
		
		$Lab = $Lab == "true" ? "1" : "0";
		$sql1=mysql_query("SELECT r.RoomID, t.SlotID " .
					"FROM room r LEFT JOIN timetable t " .
					"ON r.RoomID = t.RoomID " .
					"WHERE r.Lab = '$Lab'");
		$rec=mysql_num_rows($sql1);
		if($rec!=0)
		{
			$rooms = GetAll($sql1);
			$i = count($rooms) - 1;
			$day = isset($Day) ? "AND Day = '$Day'" : "";
			while($i >= 0)
			{
				// get room info
				$sql2=mysql_query("SELECT DISTINCT room.RoomID, room.RoomCode, room.Floor, room.Lab, block.Name AS BlockName " .
							"FROM room JOIN block " .
							"ON room.BlockID = block.BlockID " .
							"WHERE room.RoomID = '" . $rooms[$i]["RoomID"] . "'");
				$room = mysql_fetch_assoc($sql2);
				$room["Lab"] = $room["Lab"] == "0" ? "No" : "Yes";
				
				// get free rooms
				$slots = getColumnArrayIf($rooms, "SlotID", "RoomID", $rooms[$i]["RoomID"]);
				if($slots[0] != null)
				{
					$sql3=mysql_query("SELECT Day, StartTime AS Start, EndTime AS End " .
								"FROM slot " .
								"WHERE SlotID NOT IN (" . implode(", ", $slots) . ") " .
								$day);
								
					$rec1==mysql_num_rows($sql3);
					
					if($rec1!=0)
					{
						$free = GetAll($sql3);
						while($row = current($free))	 // merging
						{
							copyItems($row, $room, array("RoomCode", "Floor", "Lab", "BlockName"));
							$row["Day"] = getDay($row["Day"]);
							$result[] = $row;
							next($free);
						}
					}
				}
				else
				{
					$row = array();
					copyItems($row, $room, array("RoomCode", "Floor", "Lab", "BlockName"));
					$row["Start"] = "*";
					$row["End"] = "*";
					$row["Day"] = "*";
					$result[] = $row;
				}
				$i -= count($slots);
			}
			if(isset($result))
			{
				$output = $result;//creating final array which contains the values
			}
			else
				{
					echo "<h1><font color='red'>No Free Rooms</font></h1>";
					exit();
				}
		}
		else 
		{
			echo "<h1><font color='red'>All rooms are free.</font></h1>";
			exit();
		}
?>
	<!--Table for Displaying the Rooms -->
	<div class="da-panel collapsible">
		<div class="da-panel-header">
			<span class="da-panel-title">
				<img src="../images/list.png" alt="List" />
				<b>Rooms Status</b>
			</span>
		</div>
		<div class="da-panel-content">
			<table id="da-ex-datatable-numberpaging" class="da-table">
				<thead>
					<tr><!--Headings of the page -->
						<th>Block</th>
						<th>Floor</th>
						<th>Room</th>
						<th>Lab</th>
						<th>Day</th>
						<th>Start</th>
						<th>End</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$total=count($output);
						for($i=0; $i<$total; $i++)
						{
					?>
					<tr>
						<td><?php echo $output[$i]['BlockName'];?></td>
						<td><?php echo $output[$i]['Floor'];?></td>
						<td><?php echo $output[$i]['RoomCode'];?></td>
						<td><?php echo $output[$i]['Lab'];?></td>
						<td><?php echo $output[$i]['Day'];?></td>
						<td><?php echo $output[$i]['Start'];?></td>
						<td><?php echo $output[$i]['End'];?></td>
					</tr>
					<?php
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
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>