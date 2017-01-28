<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!--developed by Arslan Khalid -->
<!DOCTYPE html>	<!-- for supporting Html 5 tags -->

<html xmlns="http://www.w3.org/1999/xhtml"> <!-- according to standards of w3.ord -->
<head>
	<title> Student List</title>	<!--title of the page -->
	<?php include"../common/library.php"; 
			include"../common/tablelibrary.php";
	?><!-- Common Libraries containg CSS and Java script files-->
	<!-- Ajax function to Load Content -->
	<script>
		function loadoption(str){
			//alert(str);
			$.ajax({
			url: 'get_student.php?q='+str,
			success: function(data) {
			$('#result').html(data);
			//alert('Loaded.');
	  }
	});
	}

	function SetIndexValue(val, val1)
	{
		var ids= val+"."+val1;
		var cb= document.getElementById("toClass");
		cb.value=ids;//setting the value of the combo box
		
		var str;
		str=cb.value;//passing the value of the combo box
		
		loadoption(str);// loading the  data of set index oof combo box
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
		<header><h3>&nbsp;&nbsp;&nbsp;Current Sections:</h3></header>
			<div class="module_content">
				<table border="0" cellpadding="0" cellspacing="0" align="center"> <!-- for alignment of the form -->
					<tr>
						<td style="font-weight:bold; font-size:15px;">Select Class: </td>
						<td><pre>             </pre></td>
						<td>
							<select name="toClass" id="toClass" onchange="loadoption(this.value);"><!--Generate a List of classes of Current Semester -->
							<option>--Select--</option>
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
			</div>
	</article><!-- end of stats article -->
	
	<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting">
		<!-- inserting DataTable Code Here that shows the list of student enrolled in the selected section -->
		<tr>
			<td id="result">
				<div class="da-panel collapsible">
		<div class="da-panel-header">
			<span class="da-panel-title">
				<img src="../images/list.png" alt="List" />
				<b>List of Students</b>
			</span>
		</div>
		<div class="da-panel-content">
			<table id="da-ex-datatable-numberpaging" class="da-table">
				<thead>
					<tr><!--Headings of the page -->
						<th>Name</th>
						<th>Registeration No</th>
						<th>CNIC</th>
						<th>Mobile</th>
						<th>Email</th>
						<th width="13%">Profile</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			
		</div>
	</div>

			</td>
		</tr>
	</table>
	<?php 
	}
	else{
	?>
	<div class="inlineSetting">
	<h4 class="alert_success"><?php echo "Course Registeration Open: No Sections Assigned Yet."?></h4>
	</div>
	<?php }?>
	
	<?php
			if(is_numeric($_GET['sbID']) && is_numeric($_GET['scID']))
			{
				$unsafe=$_GET['sbID'];
				$subjectID=clean($unsafe);//cleaning the variable
				
				$unsafe=$_GET['scID'];
				$sectionID=clean($unsafe);//cleaning the variable
				
		?>
			<script>
				SetIndexValue(<?php echo $sectionID;?>,<?php echo $subjectID;?>);
			</script>
		<?php
			}
		?>
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
