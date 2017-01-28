<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title> Mark Attendance</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
	<script>
		function isValid(len,lecID)
		{
			var a = getAbsent(len);
			var p = getPresent(len);
			var cnfrm=confirm("Are You Want to Submit Attendance?");
			if(cnfrm)
			{
				window.location="submitattendance.php?PresentIDs="+p+"&AbsentIDs="+a+"&lid="+lecID;
			}
		}
		function getPresent(len)
		{
			var j = 0;
			var ids = Array();
			var idss = "";
			for(var i = 0; i<len; i++)
			{
				var cb = document.getElementById("chk_" + i);
				if(cb.checked == true)
				{
					ids[j++] = cb.name;
				}
			}
			
			for(var i = 0; i<ids.length; i++)
			{
				idss += ids[i];
				if(i != (ids.length - 1))
					idss += ",";
			}
			idss = "[" + idss + "]";//collecting the ids of the student
			return idss;
		}
		
		function getAbsent(len)
		{
			var j = 0;
			var ids = Array();
			var idss = "";
			for(var i = 0; i<len; i++)
			{
				var cb = document.getElementById("chk_" + i);
				if(cb.checked == false)
				{
					ids[j++] = cb.name;
				}
			}
			for(var i = 0; i<ids.length; i++)
			{
				idss += ids[i];
				if(i != (ids.length - 1))
					idss += ",";
			}
			idss = "[" + idss + "]";//collecting the ids of the student
			return idss;
		}
		
		function IsValidAll(len)//if user select the all button than
		{
		    var button = document.getElementById("selectButton");
		    if(button.innerHTML=="Select All")
				button.innerHTML="UnSelect All";//changing the button text
				else
					if(button.innerHTML=="UnSelect All")
						button.innerHTML="Select All";//changing the button text
						
			for(var i = 0; i<len; i++)
			{
				var cb = document.getElementById("chk_" + i);
				if(cb.checked==false)//if no checl box is selected
				{
					cb.checked=true;//selecting the check box
				}
				else
					if(cb.checked==true)//if check box is already selected
					{
						cb.checked=false;//un selecting the checkbox
					}
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
		
		$unsafe=$_GET['lid'];//getting lectureID
		$lectureID=clean($unsafe);//cleaning ID for the prevention of SQL injection
		
		$unsafe=$_GET['sid'];//getting sectionID
		$sectionID=clean($unsafe);//cleaning ID for the prevention of SQL injection
		
		$unsafe=$_GET['sbid'];//getting subjectID
		$subjectID=clean($unsafe);//cleaning ID for the prevention of SQL injection
		
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
							<td width="15%"><font color="black"><h4>Status</h4></font></td><!-- table headings -->
							<td width="25%"><font color="black"><h4>Registeration No</h4></font></td>
							<td width="25%"><font color="black"><h4>Student Name</h4></font></td>
							<td><font color="black"><h4>Semester</h4></font></td>
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
									<input type="checkbox" name="<?php echo $row1['StudentID'];?>" id="chk_<?php echo $i;?>"/>
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
			<a href="Javascript:IsValidAll(<?php echo $i;?>)">
				<button type="button" id="selectButton">Select All</button>
			</a>
			|
			<a href="Javascript:isValid(<?php echo $i;?>,<?php echo $lectureID;?>)">
				<button type="button">Submit</button>
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
