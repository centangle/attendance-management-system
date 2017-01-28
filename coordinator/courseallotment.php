<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title>Course Allotment</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
	
	<link href="../css/select2.css" rel="stylesheet"/>
    <script src="../css/select2.js"></script>
	
	<!-- Ajax function to Load Content -->
	<script>
		function loadoption(str){
			$.ajax({
			url: 'get_discipline.php?q='+str,
			success: function(data) {
			$('#res').html(data);
			//alert('Loaded.');
	  }
	});
	}
	
	</script>
	<script>
        $(document).ready(function() { $("#e1").select2(); });
    </script>

</head>
	<?php
		if(is_numeric($_GET['ErrorID']))//getting message ids from action file
		$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
		switch($error){
			case 1://message 1 case
				echo'<script type="text/javascript">alert("Error: Empty Fields are not allowed.");</script>';//showing the alert box to notify the message to the user
				break;
			case 2://message 2 case
				echo'<script type="text/javascript">alert("Error: Subject fot this section is already alloted.");</script>';//showing the alert box to notify the message to the user
				break;
			case 3://message 3 case
				echo'<script type="text/javascript">alert("Error: Course if this section is already alloted to the selected teacher.");</script>';//showing the alert box to notify the message to the user
				break;
			case 5://message 5 case
				echo'<script type="text/javascript">alert("Success: Course has been alloted successfully.");</script>';//showing the alert box to notify the message to the user
				break;
		}
	?>
<body>
	<?php include"coordinatorheader.php"; ?><!--side bar menu for the Student -->
		<?php 				
			include_once("../common/commonfunctions.php"); //including Common function library
			include_once("../common/config.php"); //including Common function library
			
			$unsafe="CourseAllotment";
			$courseAllotment=clean($unsafe);
			
			$unsafe="Open";
			$status=clean($unsafe);
			
			$res = mysql_query("SELECT * FROM `criteria` WHERE `Entity` ='$courseAllotment' AND `Value`='$status'");//SELECTING THE user records 
			$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
			if($row)
			{
		?>					
		<?php
			$profileID=$_SESSION['CoordinatorID'];//unsafe variable
			$id=clean($profileID);//cleaning id to preven SQL Injection
			
		?>
	<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Course Allotment</h3></header>
			<div class="module_content"><!-- Showing the list of subject for the registeration-->
				<div>
					<form method="POST" action="course_allotment_action.php">
					<table width="100%" align="center">
						<tr>
							<td style="font-weight:bold; font-size:15px;">
								Department: 
							</td>
							<td>
								<select onchange="loadoption(this.value);">
									<option selected>--Select--</option>
									<?php
									$result = mysql_query("SELECT *FROM coordinator WHERE CoordinatorID='$id'"); //select the records of the coordinator
									$rows = mysql_fetch_array($result);
									
									$unsafe=$rows['DepartmentID'];// posting Department ID
									$depID=clean($unsafe);
									
									$sql9=mysql_query("SELECT *FROM departments WHERE DepartmentID='$depID'");
									
									while($row9=mysql_fetch_array($sql9)) //will return the list of names of department
										{
										echo "<option value='$row9[DepartmentID]'>".$row9['Name']."-(".$row9['Code'].")"."</option>";
										}
									?>
								</select>
							</td>
						</tr>
						
						<tr>
							<td style="font-weight:bold; font-size:15px;">
								Discipline:
							</td>
							<td id="res">
								<select name="discipline">
								</select>
							</td>
						</tr>
						
						<tr>
							<td style="font-weight:bold; font-size:15px;">
								Semester:
							</td>
							<td id="res1">
								<select name="semester">
								</select>
							</td>
						</tr>
						
						<tr>
							<td style="font-weight:bold; font-size:15px;">
								Section:
							</td>
							<td id="res2">
								<select name="section">
								</select>
							</td>
						</tr>
						
					</table>
					<hr/>
					<table width="100%" align="center">
						<tr>
							<td style="font-weight:bold; font-size:15px;">
								Subjects:
							</td>
							<td id="res3">
								<select name="subject">
								</select>
							</td>
						</tr>
						<tr>
							<td style="font-weight:bold; font-size:15px;">
								Interested Teachers:
							</td>
							<td id="res4">
								<select name="teacher">
								</select>
							</td>
							
							<td style="font-weight:bold; font-size:15px;">
								Search Teacher:
							</td>
							<td>
									<select id="e1" name="allotedTeacher">
									<?php
									$sql19=mysql_query("SELECT *FROM teacher WHERE DepartmentID='$depID'");
									while($row19=mysql_fetch_array($sql19))
									{
										echo "<option value='$row19[TeacherID]'>".$row19['Name']."</option>";
									}	
									?>
									</select>
							</td>
						</tr>
						<tr>
							<td colspan="4" align="center">
								<input type="submit" value="Submit"/>
							</td>
						</tr>
					</table>
					<hr/>
					</form>
				</div>
		</div>
	</article><!-- end of stats article -->
	<br/><br/><br/>
	<?php 
	}
	else{
	?>
	<div class="inlineSetting">
	<h4 class="alert_success"><?php echo "Course Allotment is Closed."?></h4>
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
