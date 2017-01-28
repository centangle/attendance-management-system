<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?><!-- Developed By: Arslan Khalid -->
<script>
function loadsemester(str){
			$.ajax({
			url: 'get_semester.php?q='+str,
			success: function(data) {
			$('#res1').html(data);
			//alert('Loaded.');
	  }
	});
	}
</script>
<?php
	include_once('../common/config.php'); //including DB Connection File

	$unsafe=$_GET['q'];//getting the id of the block
	
	$sql=("SELECT *FROM discipline WHERE DepartmentID='$unsafe'");
	$result1=mysql_query($sql);
	
?>

	<select name="discipline" onchange="loadsemester(this.value);">
	<option>--Select--</option>
	<?php
	while($rows3 = mysql_fetch_array($result1)) //will return the list of names of department
	{
	echo "<option value='$rows3[DisciplineID]'>".$rows3['DisciplineName']."</option>";
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