<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->
<script>
	function loadsubjects(str){			
			$.ajax({
			url: 'get_sub1.php?q='+str,
			success: function(data) {
			$('#res3').html(data);
			//alert('Loaded.');
	  }
	});
	}
</script>

<?php
	include_once('../common/config.php'); //including DB Connection File

	$unsafe=$_GET['q'];//getting the id of the block
	
	$sql=("SELECT *FROM section WHERE Semester='$unsafe'");
	$result1=mysql_query($sql);	
?>

	<select name="section" id="getSec" onchange="loadsubjects(this.value);">
	<option>--Select--</option>
	<?php
	while($rows3 = mysql_fetch_array($result1))
	{
	echo "<option value='$rows3[SectionID]'>".$rows3['SectionCode']."</option>"; //will return the list of sections
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