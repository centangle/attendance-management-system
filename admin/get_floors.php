<!-- Developed By: Arslan Khalid -->

<?php
	include_once('../common/config.php'); //including DB Connection File
	$unsafe=$_GET['q'];//getting the id of the block
	
	//--------------------getting number of floor depending upon the block ----------------------//
	$sql=("SELECT *FROM block WHERE BlockID='$_GET[q]'");
	$result1=mysql_query($sql);
	$rows3 = mysql_fetch_array($result1);
?>

	<select name="newRoomFloor">
	<?php
	for($i=1; $i<=$rows3[2]; $i++)
	{
		echo "<option value='$i'>Floor".$i."</option>";
	}
	?>
	</select>