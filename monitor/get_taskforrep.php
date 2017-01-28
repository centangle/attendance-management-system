<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<?php
	include_once('../common/config.php'); //including DB Connection File
	include_once('../common/queryfunctions.php'); //including query functions
	include_once('../common/commonfunctions.php'); //including query functions
	include"../common/tablelibrary.php";//<!-- View Table Sorter Related Liberaries -->
	$id=$_GET['q'];//Section id and subject id
	
	$pieces = explode(".", $id);//breaking on the basis of . character
	$sectionID=$pieces[0];// section ID
	$subjectID=$pieces[1]; // subject ID
	
	$unsafe=$_SESSION['TeacherID'];
	$teacherID=clean($unsafe);//cleaning the variable
	
	if(is_numeric($id))
	{
?>
	<div class="da-panel collapsible">
		<div class="da-panel-header">
			<span class="da-panel-title">
				<img src="../images/list.png" alt="List" />
				<b>List of Tasks</b>
			</span>
		</div>
		<div class="da-panel-content">
			<table id="da-ex-datatable-numberpaging" class="da-table">
				<thead>
					<tr><!--Headings of the page -->
						<th>Title</th>
						<th>Type</th>
						<th>Issue Date</th></th>
						<th>Class</th>
						<th>Details</th>
					</tr>
				</thead>
				<tbody>
					<?php
						//code for displaying the list of student in the selected section 
						$sql=mysql_query("SELECT *FROM task WHERE TeacherID='$teacherID'");
						
						while($row=mysql_fetch_array($sql))
						{
							$unsafe=$row['TaskID'];
							$taskID=clean($unsafe);
					?>
							<tr>
							   <td><?php echo $row['Title']; ?></td><!-- printing title -->
							   <td>
									<?php
										$type=$row['TaskType'];
										 if($type=='a')
											echo "Assignment";
											else if($type=='q')
													echo "Quiz";
													else if($type=='s')
															echo "Sessional";
																else echo "Final";
									?>
							   </td><!-- printing TaskType-->
							   <td><?php echo $row['IssueDate']; ?></td><!-- printing issue date-->
							   <td>
									<?php
										$sql1=mysql_query("SELECT *FROM section WHERE SectionID='$sectionID'");
										$row1=mysql_fetch_array($sql1);
										
										$class= $row1['Semester']."(".$row1['SectionCode'].")";// will post some value like 8A
										
										$disciplineID=$row1['DisciplineID'];
										
										$sql2=mysql_query("SELECT *FROM discipline WHERE DisciplineID='$disciplineID'");
										$row2=mysql_fetch_array($sql2);
										$disName=$row2['DisciplineCode'];
										
										echo $disName."-".$class;
									?>
								</td> <!-- printing class-->
							   <td>
								<a href="viewmarksreport.php?tid=<?php echo $taskID;?>&sbID=<?php echo $subjectID;?>&scID=<?php echo $sectionID; ?>" target="_blank">
									<img src="../images/ic_zoom.png"width="16" height="16" alt="View"> View
								</a><!--View Page Refference -->
							   </td><!-- printing description-->
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
			