<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<div>
<?php
	include_once('../common/config.php'); //including DB Connection File
	include_once('../common/commonfunctions.php'); //including query functions
	
	$id=$_GET['q'];//Section id and subject id
	
	$pieces = explode(".", $id);//breaking on the basis of . character
	$sectionID=$pieces[0];// section ID
	$subjectID=$pieces[1]; // subject ID
	
	$safeSection=clean($sectionID);//cleaning for the prevention of SQL injection
	$safeSubject=clean($subjectID);//cleaning for the prevention of SQL injection
	
	if($id!="0")
	{
?>
	<table align="center">
		<tr>
			<td><a href="viewattendancesheet.php?scID=<?php echo $safeSection; ?>&sbID=<?php echo $safeSubject; ?>" target="_blank"><button class="sheetButtons">Blank Attendance Sheet</button></a></td>
			<td><pre>    </pre></td>
			<td><a href="viewassignmentsheet.php?scID=<?php echo $safeSection; ?>&sbID=<?php echo $safeSubject; ?>" target="_blank"><button class="sheetButtons">Blank Assignment Sheet</button></a></td>
		</tr>
		<tr>
			<td><a href="viewquizsheet.php?scID=<?php echo $safeSection; ?>&sbID=<?php echo $safeSubject; ?>" target="_blank"><button class="sheetButtons">Blank Quiz Sheet</button></a></td>
			<td><pre>    </pre></td>
			<td><a href="viewsessionalsheet.php?scID=<?php echo $safeSection; ?>&sbID=<?php echo $safeSubject; ?>" target="_blank"><button class="sheetButtons">Blank Sessional Sheet</button></a></td>
		</tr>
		<tr>
			<td><a  href="viewfinalsheet.php?scID=<?php echo $safeSection;?>&sbID=<?php echo $safeSubject; ?>" target="_blank"><button class="sheetButtons">Final Attendance Sheet</button></a></td>
		</tr>
	</table>
	<?php
		}
		else
			{
	?>
	<h1><font color="red">No Section Selected</font></h1>
	<?php   } ?>
</div>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>