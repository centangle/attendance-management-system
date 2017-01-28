<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->
<script>
	function loadsection(str){
			$.ajax({
			url: 'get_sec.php?q='+str,
			success: function(data) {
			$('#res2').html(data);
			//alert('Loaded.');
	  }
	});
	}
	
</script>

<?php
	include_once('../common/config.php'); //including DB Connection File

	$unsafe=$_GET['q'];//getting the id of the block
	
	$sql=("SELECT *FROM discipline WHERE DisciplineID='$unsafe'");
	$result1=mysql_query($sql);
	$rows3 = mysql_fetch_array($result1);
	$totalSmester=$rows3['TotalSemester'];//total semesters
	
?>

	<select name="semester" id="getS" onchange="loadsection(this.value);">
	<option>--Select--</option>
	<?php
	for($i=1; $i<=$totalSmester;$i++)
	{
	echo "<option value='$i'>".$i."</option>"; //will return the list of semesters
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