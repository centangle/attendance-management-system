<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<script>
	function loadtable(str){
			var d,s, sec,cb;
			
			cb=document.getElementById("getD");//section
			d=cb.value;
			
			cb=document.getElementById("getS");//section
			s=cb.value;
			
			cb=document.getElementById("getSec");//section
			sec=cb.value;
			
			$.ajax({
			url: 'get_timetable.php?q='+str+'&d='+d+'&s='+s+'&sec='+sec,
			success: function(data) {
			$('#tab').html(data);
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

	<select name="subject" id="getSub" onchange="loadtable(this.value);">
	<option value="0">--Select--</option>
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