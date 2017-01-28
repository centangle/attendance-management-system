<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title>View TimeTable</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->

	<!-- Ajax function to Load Content -->
	<script>
		function loadtimetable(){
			var cb, str, str1;
			cb=document.getElementById('getDay');
			str=cb.value;
			
			$.ajax({
			url: 'get_teacher_timetable.php?d='+str,
			success: function(data) {
			$('#tab').html(data);
			//alert('Loaded.');
	  }
	});
	}
	
	</script>

</head>
<body>
	<?php include"teacherheader.php"; ?><!--side bar menu for the Student -->			
		<?php
			include_once("../common/commonfunctions.php"); //including Common function library
			include_once("../common/config.php"); //including Common function library
			
			$profileID=$_SESSION['TeacherID'];//unsafe variable
			$id=clean($profileID);//cleaning id to preven SQL Injection
		?>
	<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;View Time Table</h3></header>
			<div class="module_content"><!-- Showing the list of option-->
				<div>
					<table width="100%" align="center">
						<tr>
							<td style="font-weight:bold; font-size:15px;">
								Day: 
							</td>
							<td>
								<select id="getDay">
									<option value="no">--Select--</option>
									<option value="1">Monday</option>
									<option value="2">Tuesday</option>
									<option value="3">Wednesday</option>
									<option value="4">Thursday</option>
									<option value="5">Friday</option>
									<option value="6">Saturday</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<button onclick="loadtimetable();">View</button>
							</td>
						</tr>
					</table>
				</div>
			</div>
	</article><!-- end of stats article -->
	<!--loading contents Here from Ajax Function -->
	<table class="inlineSetting"> <!-- for alignment of the form -->
		<tr>
			<td id="tab">
			
			</td>
		</tr>
	</table>
</body>

</html>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>
