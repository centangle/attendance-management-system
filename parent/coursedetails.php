<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title> Course Details</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
</head>
<body>
	<?php 
		include"studentheader.php";//<!--side bar menu for the Student -->
	    include_once("../common/commonfunctions.php"); //including Common function library
	    include_once("../common/config.php"); //including Common function library
		
		$profileID=$_SESSION['StudentID'];//unsafe variable
		$id=clean($profileID);//cleaning id to preven SQL Injection
		
		if(is_numeric($_GET['id']) && is_numeric($_GET['sID']) )
		$unsafe=$_GET['id'];
		$subjectID=clean($unsafe);//cleaning the variable
		$unsafe=$_GET['sID'];
		$sectionID=clean($unsafe);//cleaning the variable
	?>	
	<!-- Query to Get the Details of the Selected Subject -->
	<?php
		// Queries Developed By Bilal Ahmad Ghouri //
		$res = array();	// result array for holding the value
		
		// fetch subject info
		$sql1=mysql_query("SELECT * FROM subject WHERE SubjectID = '" .$subjectID. "'");
		$row = mysql_fetch_assoc($sql1);
		$res["Name"] = $row["Name"];
		$res["Code"] = $row["Code"];
		$res["CreditHours"] = $row["CreditHours"];
		$res["Lab"] = $row["Lab"] == "1" ? "Yes" : "No";
		$res["Description"] = $row["Description"];
		
		// fetch section info
		$sql2=mysql_query("SELECT SectionCode FROM section WHERE SectionID = '" .$sectionID. "'");
		$row = mysql_fetch_assoc($sql2);
		$res["SectionCode"] = $row["SectionCode"];
		
		// fetch semister of student and subject info
		$sql3=mysql_query("SELECT student.Semester FROM student JOIN catalog ON student.DisciplineID = catalog.DisciplineID AND student.StudentID = '" . 
													$id. "' AND catalog.SubjectID = '" .$subjectID. "' AND " . 
													"student.Semester = catalog.Semester");
		$row = mysql_fetch_array($sql3);
		$res["Previous"] = $row["Semester"] == null ? "Yes" : "No"; 
		
		// get subject studied
		$sql4=mysql_query("SELECT StudentID FROM subjectstudied WHERE StudentID = '" .$id. "' AND SubjectID = '" .$subjectID. "'");
		$row =mysql_fetch_assoc($sql4);
		$res["Repeat"] = $row["StudentID"] == null ? "No" : "Yes";
		
		// get teacher ID
		$sql5=mysql_query("SELECT TeacherID FROM subjecttoteach JOIN class ON subjecttoteach.ClassID = class.ClassID AND class.SectionID = '" .$sectionID. "' AND class.SubjectID = '" .$subjectID. "'");
		$row = mysql_fetch_assoc($sql5);
		
		// teacher name
		$sql6=mysql_query("SELECT Name FROM teacher WHERE TeacherID = '" .$row["TeacherID"]. "'");
		$row = mysql_fetch_array($sql6);
		$res["Teacher"] = $row["Name"] == null ? "N/A" : $row["Name"];
		
	?>
	<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Course Details:</h3></header>
			<div class="module_content"><!-- Showing the list of subject for details-->
				
					<div>
						<form>
						<table width="100%" align="center">
							<tr>
							<td style="font-weight:bold; font-size:15px;">Name: </td>
							<td style="color:grey;"> <?php echo $res['Name'];?></td><!--Posting  Name-->
							
							<td style="font-weight:bold; font-size:15px;">Code: </td>
							<td style="color:grey;"> <?php echo $res['Code'];?></td><!--Posting  Code-->
							</tr>
							
							<tr>
								<td style="font-weight:bold; font-size:15px;">Credit Hours: </td>
								<td style="color:grey;"> <?php echo $res['CreditHours'];?></td><!--Posting  Credit hours-->
								
								<td style="font-weight:bold; font-size:15px;">Lab: </td>
								<td style="color:grey;"> <?php echo $res['Lab'];?></td><!--Posting  Lab-->
							</tr>
							
							<tr>
								<td style="font-weight:bold; font-size:15px;">Section: </td>
								<td style="color:grey;"> <?php echo $res['SectionCode'];?></td><!--Posting  Section-->
								
								<td style="font-weight:bold; font-size:15px;">Teacher: </td>
								<td style="color:grey;"> <?php echo $res['Teacher'];?></td><!--Posting  Teacher-->
								
							</tr>
							
							<tr>
								<td style="font-weight:bold; font-size:15px;">Repeat: </td>
								<td style="color:grey;"> <?php echo $res['Repeat'];?></td><!--Posting  Repeat Info-->
								
								<td style="font-weight:bold; font-size:15px;">PreReq: </td>
								<td style="color:grey;"> <?php echo $res['Previous'];?></td><!--Posting  PreReq Info-->
							</tr>
							<tr>
								<td style="font-weight:bold; font-size:15px;">Description: </td>
								<td colspan="3" style="color:grey;"> <?php echo $res['Description'];?></td><!--Posting  Decription-->
							</tr>
							<tr>
								<td colspan="4" align="center"><a href="viewcourses.php"><button type="button">GoBack</button></a></td>
							</tr>
						</table>
					</div>
				
				<div class="clear"></div>
			</div>
	</article><!-- end of stats article -->
</body>

</html>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../parentlogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>
