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
	
	$safeSection=clean($sectionID);//cleaning for the prevention of SQL injection
	$safeSubject=clean($subjectID);//cleaning for the prevention of SQL injection
	
	if(is_numeric($id))
	{
?>
	<div class="da-panel collapsible">
		<div class="da-panel-header">
			<span class="da-panel-title">
				<img src="../images/list.png" alt="List" />
				<b>List of Students</b>
			</span>
		</div>
		<div class="da-panel-content">
			<table id="da-ex-datatable-numberpaging" class="da-table">
				<thead>
					<tr><!--Headings of the page -->
						<th>Name</th>
						<th>Registeration No</th>
						<th>CNIC</th>
						<th>Mobile</th>
						<th>Email</th>
						<th width="13%">Profile</th>
					</tr>
				</thead>
				<tbody>
					<?php
						//code for displaying the list of student in the selected section 
						$sql=mysql_query("SELECT *FROM subjecttostudy WHERE SubjectID='$safeSubject' AND SectionID='$safeSection'");
						echo ("SELECT *FROM subjecttostudy WHERE SubjectID='$safeSubject' AND SectionID='$safeSection'");
						while($row=mysql_fetch_array($sql))
						{
							$unsafe=$row['StudentID'];
							$studentID=clean($unsafe);
							
							$sql1=mysql_query("SELECT *FROM student WHERE StudentID='$studentID'");
							while($row1=mysql_fetch_array($sql1))
							{
					?>
							<tr>
							   <td><?php echo $row1['Name']; ?></td><!-- printing name of student -->
							   <td><?php echo $row1['RegistrationNo']; ?></td><!-- printing Registeration Number name-->
							   <td><?php echo $row1['CNICNo']; ?></td><!-- printing CNIC-->
							   <td><?php echo $row1['MobileNumber']; ?></td> <!-- printing mobile-->
							   <td><?php echo $row1['EmailAddress']; ?></td><!-- printing email-->
							   <td>
								<a href="viewstudentprofile.php?id=<?php echo $studentID;?>&sbID=<?php echo $safeSubject;?>&scID=<?php echo $safeSection; ?>">
									<img src="../images/ic_zoom.png"width="16" height="16" alt="Cancel">View
								</a><!--Delete Page Refference -->
							   </td>
							</tr>
				    <?php
							}
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
			