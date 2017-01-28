<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title> Add Task Marks</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
	<script>
		function isValid(len,tID,sbID,scID,tm)
		{
			var j = 0;
			var ids = Array();
			var idsi = Array();
			
			var idss = "";//for student marks
			var idssi = "";//for student ids
			
			
			for(var i = 0; i<len; i++)
			{
				var cb = document.getElementById("chk_" + i);
				if(cb.value=="")
				{
					alert("Enter Marks in All Input Fields");
					return;
				}
				else 
					if(isNaN(cb.value))
						{
							alert("All Input Field Must Contain an Integer Value");
							return;
						}
						else if(cb.value>tm)
								{
									alert("Obtained Marks Should be Less or Equal to Total Marks("+tm+")");
									return;
								}
								else
								{
									ids[j++] = cb.value;//posting marks of the student
								}
			}
			
			for(var i = 0; i<ids.length; i++)//creating array of student marks
			{
				idss += ids[i];
				
				if(i != (ids.length - 1))
					idss += ",";
			}
			idss = "[" + idss + "]";//collecting the Marks of the student
			
			var cnfrm=confirm("Are You Want to Submit Marks?");
			if(cnfrm)
			{
				window.location="submittaslmarks.php?MarksVals="+idss+"&tID="+tID+"&sbID="+sbID+"&scID="+scID;
			}
		}
	</script>
</head>
<body>
	<?php 
		include"teacherheader.php";//including side bar menu for the user
		include_once("../common/commonfunctions.php");//including common function library
		include_once("../common/config.php");//including Database connection library
	
		$profileID=$_SESSION['TeacherID'];//unsafe variable
		$id=clean($profileID);//cleaning id to preven SQL Injection
		
		$unsafe=$_GET['tid'];//getting taskID
		$taskID=clean($unsafe);//cleaning ID for the prevention of SQL injection
		
		$unsafe=$_GET['sbID'];//getting subjectID
		$subjectID=clean($unsafe);//cleaning ID for the prevention of SQL injection
		
		$unsafe=$_GET['scID'];//getting  sectionID
		$sectionID=clean($unsafe);//cleaning ID for the prevention of SQL injection

		$unsafe=$_GET['tm'];//getting  sectionID
		$totMarks=clean($unsafe);//cleaning ID for the prevention of SQL injection


		$sql3=mysql_query("SELECT *FROM subject WHERE SubjectID='$subjectID'");//query for selecting the subject name
		$row3=mysql_fetch_array($sql3);
		
		$subjectName=$row3['Name'];//posting subject name
		
	?>
	<article class="module width_full_scroll">
			<header><h3>&nbsp;&nbsp;&nbsp; List of Students Enrolled in <?php echo $subjectName; ?></h3></header>
			<div class="module_content"><!-- Showing the list of Students for marking attendance-->
				<div>
					<table width="100%" align="center">
						<tr>
							<td width="15%"><font color="black"><h4>Sr. #</h4></font></td>
							<td width="25%"><font color="black"><h4>Registeration No</h4></font></td>
							<td width="25%"><font color="black"><h4>Student Name</h4></font></td>
							<td><font color="black"><h4>Semester</h4></font></td>
							<td width="15%"><font color="black"><h4>Obtained Marks</h4></font></td><!-- table headings -->
						</tr>
						<tr><td colspan="5"><hr/></td></tr>
							<?php 
								$sql=mysql_query("SELECT *FROM subjecttostudy WHERE SubjectID='$subjectID' AND SectionID='$sectionID'");//selecting the student id for marking the attendance
								$i=0;
								while($row=mysql_fetch_array($sql))//while fetching the list of records from database
								{
									$unsafe=$row['StudentID'];//posting the student id who attendance will be marked
									$studentID=clean($unsafe);//cleaning the variable for the prevention of SQL injection
									
									$sql1=mysql_query("SELECT *FROM student WHERE StudentID='$studentID'");//selecting the student records
									$row1=mysql_fetch_array($sql1);
							?>
							<tr>
							   <td>
									<?php echo ($i+1);?>
							   </td>
					
							   <td>
									<?php echo $row1['RegistrationNo'];?>
							   </td>
							   
							   <td>
									<?php echo $row1['Name'];?>
							   </td>
							   
							   <td>
									<?php echo $row1['Semester']?>
							   </td>
							   
							   <td>
									<input class="smallinput" type="text" name="<?php echo $studentID;?>" id="chk_<?php echo $i;?>" pattern="^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$" required />
									<!--<input type="checkbox" name="<?php //echo $row1['StudentID'];?>" id="chk_<?php //echo $i;?>"/>-->
							   </td>
							</tr>
							<?php
								$i++;
							}
							?>
							<tr>
								<td colspan="5">
									<hr/>
								</td>
							</tr>
					</table>
				</div>
		</div>
		<p align="center">
			<a href="Javascript:isValid(<?php echo $i;?>,<?php echo $taskID;?>,<?php echo $subjectID;?>,<?php echo $sectionID;?>,<?php echo $totMarks;?>)">
				<button type="button">Add Marks</button>
			</a>
			|
			<a href="viewtasks.php?sbID=<?php echo $subjectID;?>&scID=<?php echo $sectionID;?>">
				<button type="button">GoBack</button>
			</a>
		</p>
	</article><!-- end of stats article -->
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
