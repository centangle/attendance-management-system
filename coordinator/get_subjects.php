<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<script>
function loadteachers(str){
			$.ajax({
			url: 'get_teachers.php?q='+str,
			success: function(data) {
			$('#res4').html(data);
			//alert('Loaded.');
	  }
	});
	}
</script>


<?php
	include_once('../common/config.php'); //including DB Connection File

	$unsafe=$_GET['q'];//getting the id of the block
	
	$sql=("SELECT subject.Name, subject.SubjectID FROM subject JOIN class ON subject.SubjectID = class.SubjectID WHERE class.SectionID= '$unsafe'");
	$result1=mysql_query($sql);	
?>

	<select name="subject" onchange="loadteachers(this.value);">
	<option>--Select--</option>
	<?php
	while($rows3 = mysql_fetch_array($result1))
	{
	echo "<option value='$rows3[SubjectID]'>".$rows3['Name']."</option>"; //will return the list of semesters
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