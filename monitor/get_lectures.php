<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<?php
	include_once('../common/config.php'); //including DB Connection File
	include_once('../common/commonfunctions.php'); //including query functions
	include"../common/tablelibrary.php";//<!-- View Table Sorter Related Liberaries -->
	$id=$_GET['q'];//Section id and subject id
	
	$pieces = explode(".", $id);//breaking on the basis of . character
	$sectionID=$pieces[0];// section ID
	$subjectID=$pieces[1]; // subject ID
	
	$safeSection=clean($sectionID);//cleaning for the prevention of SQL injection
	$safeSubject=clean($subjectID);//cleaning for the prevention of SQL injection
	
	if(is_numeric($id))
	{
?>
	<div class="da-panel collapsible">
		<div class="da-panel-header">
			<span class="da-panel-title">
				<img src="../images/list.png" alt="List" />
				<b>List of Lectures</b>
			</span>
		</div>
		<div class="da-panel-content">
			<table id="da-ex-datatable-numberpaging" class="da-table">
				<thead>
					<tr><!--Headings of the page -->
						<th width="13%">Lecture #</th></th>
						<th width="30%">Title</th>
						<th width="10%">Lab</th>
						<th width="20%">Date</th>
						<th width="14%">Attendance</th>
						<th width="13%">Detail</th>
					</tr>
				</thead>
				<tbody>
					<?php
						//code for displaying the list of student in the selected section 
						$sql=mysql_query("SELECT ClassID FROM class WHERE SubjectID='$safeSubject' AND SectionID='$safeSection'");
												
						if(mysql_num_rows($sql))
						{
							$row = mysql_fetch_assoc($sql);
							$classID=$row['ClassID'];
							
							$sql2=mysql_query("SELECT LectureID, Title, Date, Lab FROM lecture WHERE ClassID='$classID'");
							if(mysql_num_rows($sql2))
							{
								$i=0;
								while($row2=mysql_fetch_array($sql2))
								{
					?>
							<tr>
							   <td><?php echo ($i+1); ?></td><!-- printing Lecture Nummber -->
							   <td><?php echo $row2['Title']; ?></td><!-- printing Registeration Number name-->
							  
							   <td><?php 
										$isLab=$row2['Lab'];
										if($isLab=="0")
											echo "No";
											else echo "Yes";
									?>
							   </td> <!-- printing lab status-->
							   
							   <td><?php echo $row2['Date']; ?></td><!-- printing date-->
							   <td>
								<a href="attendancedetails.php?lid=<?php echo $row2['LectureID'];?>&sbID=<?php echo $safeSubject;?>&scID=<?php echo $safeSection;?>">
									<img src="../images/ic_zoom.png"width="16" height="16" alt="Cancel">View
								</a><!--view details Page Refference -->
							   </td>
							    <td>
								<a href="lecturedetails.php?lid=<?php echo $row2['LectureID'];?>&sbID=<?php echo $safeSubject;?>&scID=<?php echo $safeSection; ?>">
									<img src="../images/ic_zoom.png"width="16" height="16" alt="Cancel">View
								</a><!--view details Page Refference -->
							   </td>
							</tr>
				    <?php
								$i++;
								}
							}
							else redirect_to("attendanceoverview.php?ErrorID=1");
						}
						else redirect_to("attendanceoverview.php?ErrorID=2");
					?>
				</tbody>
			</table>
			
		</div>
	</div>
<?php
	}
	else
	{
		echo "<p align='center'><h1><font color='red'>No Section Selected</font></h1></p>";
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
			