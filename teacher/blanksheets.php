<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!--developed by Arslan Khalid -->
<!DOCTYPE html>	<!-- for supporting Html 5 tags -->

<html xmlns="http://www.w3.org/1999/xhtml"> <!-- according to standards of w3.ord -->
<head>
	<title> Blank Sheets</title>	<!--title of the page -->
	<?php include"../common/library.php"; ?><!-- Common Libraries containg CSS and Java script files-->
	
	<!-- Ajax function to Load Content -->
	<script>
		function loadoption(str){
			//alert(str);
			$.ajax({
			url: 'get_data.php?q='+str,
			success: function(data) {
			$('#result').html(data);
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
			
			$unsafe="RegisterCourse";
			$courseAllotment=clean($unsafe);
			
			$unsafe="Close";
			$status=clean($unsafe);
			
			$res = mysql_query("SELECT * FROM `criteria` WHERE `Entity` ='$courseAllotment' AND `Value`='$status'");//SELECTING THE user records 
			$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
			if($row)
			{
		?>	
	<article class="module width_full">
		<header><h3>&nbsp;&nbsp;&nbsp;Blank Sheets:</h3></header>
			<div class="module_content">
				<table border="0" cellpadding="0" cellspacing="0" align="center"> <!-- for alignment of the form -->
					<tr>
						<td style="font-weight:bold; font-size:15px;">Select Class: </td>
						<td colspan="2">
							<select name="toClass" id="toClass"  onchange="loadoption(this.value);"><!--Generate a List of classes of Current Semester -->
							<option value="0">--Select--</option>
								<?php
									//for selecting the list of semester with Sections that teacher is teaching in this semester
									$sql=mysql_query("SELECT DISTINCT section.SectionID, class.SubjectID, discipline.DisciplineCode, section.Semester, section.SectionCode " .
											"FROM subjecttoteach JOIN class JOIN section JOIN discipline " .
											"ON subjecttoteach.ClassID = class.ClassID " .
											"AND class.SectionID = section.SectionID " .
											"AND section.DisciplineID = discipline.DisciplineID " .
											"WHERE subjecttoteach.TeacherID = '".$id."'");
									while($row=mysql_fetch_array($sql))
									{
										echo "<option value='$row[SectionID].$row[SubjectID]'>".$row['DisciplineCode']."-".$row['Semester']."(".$row['SectionCode'].")"."</option>";
									}
								?>
							</select>
						</td>
					</tr>
				</table>
				<div id="result"><!--getting the values of the select box through ajax -->
				</div>
			</div>
	</article><!-- end of stats article -->
	
	<?php 
	}
	else{
	?>
	<div class="inlineSetting">
	<h4 class="alert_success"><?php echo "Course Registeration Open: No Sections Assigned Yet."?></h4>
	</div>
	<?php }?>
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
