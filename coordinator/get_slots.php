<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once('../common/config.php'); //including DB Connection File

	$unsafe=$_GET['q'];//getting the id of the block
	
	$sql=("SELECT *FROM slot WHERE Day='$unsafe'");
	$result1=mysql_query($sql);	
?>

	<select name="slotID">
	<?php
	while($rows3 = mysql_fetch_array($result1))
	{
		echo "<option value='$rows3[SlotID]'>".$rows3['StartTime']." to ".$rows3['EndTime']."</option>"; //will return the list of timmings
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