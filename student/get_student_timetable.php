<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
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
	
	$unsafe=$_SESSION['StudentID'];
	$StudentID=clean($unsafe);
	
?>

	<!-- Queries Developed by Bilal Ahmad Ghouri -->
	<?php
		if($Day=="no")
		{
			echo "<h1><font color='red'>Select any Day First.</font></h1>";
			exit();
		}
		else
		{
		$sql=mysql_query("SELECT Value FROM criteria WHERE Entity='ShowTimetable'");
		$row=mysql_fetch_array($sql);
		$val=$row[0];//posting the value of the criteria
		if($val=="Close")
		{
			echo "<h1><font color='red'>Currently Not Available. Change Show TimeTable Criteria.</font></h1>";
			exit();
		}
		
		// get class info
		$sql1=mysql_query("SELECT class.ClassID " .
					"FROM class JOIN subjecttostudy " .
					"ON class.SubjectID = subjecttostudy.SubjectID " .
					"AND class.SectionID = subjecttostudy.SectionID " .
					"WHERE subjecttostudy.StudentID = '$StudentID'");
		$cols=GetAll($sql1);
		$classes = GetColumnArray($cols,"ClassID");
		
		$rec=mysql_num_rows($sql1);
		
		if($rec!=0)
		{
			$sql2=mysql_query("SELECT slot.StartTime, slot.EndTime, timetable.RoomID, timetable.ClassID " .
						"FROM timetable JOIN slot " .
						"ON timetable.SlotID = slot.SlotID " .
						"WHERE timetable.ClassID IN (" . implode(", ", $classes) . ") " .
						"AND slot.Day = '$Day'");
			
			$rec1=mysql_num_rows($sql2);
			if($rec1!=0)
			{
				$tts = GetAll($sql2);
				for($i = count($tts) - 1; $i >= 0; $i--)
				{
					// get room info
					$sql3=mysql_query("SELECT room.RoomCode, room.Floor, room.Lab, block.Name AS BlockName " .
								"FROM room JOIN block " .
								"ON room.BlockID = block.BlockID " .
								"WHERE room.RoomID = '" . $tts[$i]["RoomID"] . "'");
					$room = GetAssoc($sql3);
					$room["Lab"] = $room["Lab"] == "0" ? "No" : "Yes";
					
					// get subject info
					$sql4=mysql_query("SELECT class.SectionID, subject.Name " .
								"FROM class JOIN subject " .
								"ON class.SubjectID = subject.SubjectID " .
								"WHERE class.ClassID = '" . $tts[$i]["ClassID"] . "'");
					$subject = GetAssoc($sql4);
					
					$sectionID = $subject["SectionID"];
					// section info
					$sql5=mysql_query("SELECT section.Semester, section.SectionCode, discipline.DisciplineCode " .
								"FROM section JOIN discipline " .
								"ON section.DisciplineID = discipline.DisciplineID " .
								"WHERE section.SectionID = '$sectionID'");
					$section = GetAssoc($sql5);
					
					// merging
					$row = array();
					copyItems($row, $room, array("RoomCode", "Floor", "Lab", "BlockName"));
					$row["Section"] = $section["DisciplineCode"] . "-" . 
									  $section["Semester"] . 
									  $section["SectionCode"];
					$row["Subject"] = $subject["Name"];
					$row["Start"] = $tts[$i]["StartTime"];
					$row["End"] = $tts[$i]["EndTime"];
					$result[] = $row;
				}
				$output = $result;//creating the final array which contains the values
			}
			else {
					echo ("<h1><font color='red'>No class on ".getDay($Day)."</font></h1>");
					exit();
				}
		}
		else
			{
				echo ("<h1><font color='red'>You are not registered in any class.</font></h1>");
				exit();
			}
?>
	<!--Table for Displaying the Rooms -->
	<div class="da-panel collapsible">
		<div class="da-panel-header">
			<span class="da-panel-title">
				<img src="../images/list.png" alt="List" />
				<b>TimeTable Details</b>
			</span>
		</div>
		<div class="da-panel-content">
			<table id="da-ex-datatable-numberpaging" class="da-table">
				<thead>
					<tr><!--Headings of the page -->
						<th>Section</th>
						<th>Subject</th>
						<th>Lab</th>
						<th>Block</th>
						<th>Floor</th>
						<th>Room</th>
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
						<td><?php echo $output[$i]['Section'];?></td>
						<td><?php echo $output[$i]['Subject'];?></td>
						<td><?php echo $output[$i]['Lab'];?></td>
						<td><?php echo $output[$i]['BlockName'];?></td>
						<td><?php echo $output[$i]['Floor'];?></td>
						<td><?php echo $output[$i]['RoomCode'];?></td>
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
	?>

<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../studentlogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>