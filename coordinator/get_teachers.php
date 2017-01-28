<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once('../common/config.php'); //including DB Connection File

	$unsafe=$_GET['q'];//getting the id of the block
	
	$sql=("SELECT *FROM subjectofinterest WHERE SubjectID='$unsafe'");
	$result1=mysql_query($sql);	
	$rows3 = mysql_fetch_array($result1);
	
	$unsafe= $rows3['TeacherID'];
	
	$sql1=mysql_query("SELECT *FROM teacher WHERE TeacherID='$unsafe'");
?>
	<select name="teacher">
	<option>--Select--</option>
	<?php
	while($rows4 = mysql_fetch_array($sql1))
	{
	echo "<option value='$rows4[TeacherID]'>".$rows4['Name']."</option>"; //will return the name of the teacher
	}
	?>
	</select>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>