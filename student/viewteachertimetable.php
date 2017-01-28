<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title>Teacher Timetable</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->

	<!-- Ajax function to Load Content -->
	<script>
		function loadtimetable(){
			var cb, str, str1;
			cb=document.getElementById('getDay');
			str=cb.value;
			
			cb=document.getElementById('ofTeacher');
			str1=cb.value;
			
			$.ajax({
			url: 'get_teacher_timetable.php?d='+str+'&t='+str1,
			success: function(data) {
			$('#tab').html(data);
			//alert('Loaded.');
	  }
	});
	}
	
	</script>

</head>
<body>
	<?php include"studentheader.php"; ?><!--side bar menu for the Student -->			
		<?php
			include_once("../common/commonfunctions.php"); //including Common function library
			include_once("../common/config.php"); //including Common function library
			
			$profileID=$_SESSION['StudentID'];//unsafe variable
			$id=clean($profileID);//cleaning id to preven SQL Injection
		?>
	<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;View Teacher Time Table</h3></header>
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
							<td style="font-weight:bold; font-size:15px;">
								Teacher Subject:
							</td>
							<td>
								<select name="ofTeacher" id="ofTeacher"><!--Generate a List of Subjects of Current Semester -->
									<?php
										$sql=mysql_query("SELECT subject.SubjectID, subject.Name, subjecttostudy.SectionID FROM subject JOIN subjecttostudy " .
											"ON subject.SubjectID = subjecttostudy.SubjectID " .
											"WHERE subjecttostudy.StudentID = '" .$id. "'");//executing the query to show the current semester subjects
										while($row=mysql_fetch_array($sql))//fetching the list of records 1-by-1
										{
											echo "<option value='$row[SubjectID].$row[SectionID]'>".$row['Name']."</option>";//[assing subject and class id
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<button onclick="loadtimetable();">Search</button>
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
		
		redirect_to("../studentlogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>
