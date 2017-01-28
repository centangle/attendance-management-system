<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
	//Page Developed by Arslan Khalid
?>
	<?php include"../common/library.php"; ?><!-- Common Libraries containg CSS and Java script files-->
	<!-- Print Page Libraries -->
	 <script type="text/javascript" src="../js/lightbox/jquery.lightbox.js"></script>
	  <script type="text/javascript" src="../js/jquery.printPage.js"></script>
	  <script type="text/javascript">  
	  $(document).ready(function() {
		$(".btnPrint").printPage();
	  });
	  </script>
	  <!-- Libraries Print Page Ends Here -->
	  
<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including Common function library
	
	$unsafe=$_GET['scID'];//getting sectionid
	$sectionID=clean($unsafe);//cleaning for the prevention of SQL Injection
	
	$unsafe=$_GET['sbID'];//getting subjectid
	$subjectID=clean($unsafe);//cleaning for the prevention of SQL Injection
	
	$unsafe=$_SESSION['TeacherID'];//getting teacehr id from the session variable
	$teacherID=clean($unsafe);//cleaning for the prevention of SQL Injection
?>
	<table align="center" border="0" width="900" cellspacing="0" cellpadding="0">
		<tr>
			<td rowspan="2"><img src="../images/black-logo-msis.png" alt="MSIS Logo" width="200" height="70"></td>
			<td><pre>       </pre></td>
			<td align="center" rowspan="2"><br/><h1><font color="grey">Mobile-based Student Information System</font></h1><h3>Marks Sheet of Quiz No: _______</h3></td>
		</tr>
	</table>
	<br/>
	<table align="center" border="0" width="900" cellspacing="0" cellpadding="0">
		<tr>
			<?php 
					$sql2=mysql_query("SELECT *FROM section WHERE SectionID='$sectionID'");
					$row2=mysql_fetch_array($sql2);
			?>
			<td><font color="grey" size="4">Program: </font></td>
			<td>
				<?php
					$unsafe=$row2['DisciplineID'];
					$desID=clean($unsafe);//cleaning the variable of discipline id
				
					$sql3=mysql_query("SELECT *FROM discipline WHERE DisciplineID='$desID'");
					$row3=mysql_fetch_array($sql3);
					
					$desName=$row3['DisciplineName'];//discipline name
					echo $desName;
				?>
			</td>
			
			<td><font color="grey" size="4">Section: </font></td>
			<td><?php $sectionCode=$row2['Semester']." (".$row2['SectionCode'].")"; echo $sectionCode;?></td>
			
			<td><font color="grey" size="4">Date: </font></td>
			<td><?php $today=date("m/d/Y"); echo $today;?></td>
		</tr>
		<?php
			$sql4=mysql_query("SELECT *FROM subject WHERE SubjectID='$subjectID'");
			$row4=mysql_fetch_array($sql4);
		?>
		<tr>
			<td><font color="grey" size="4">Subject: </font></td>
			<td><?php $subName=$row4['Name'];  echo $subName; ?></td>
			
			<td><font color="grey" size="4">Subject Code: </font></td>
			<td> <?php $subCode=$row4['Code'];  echo $subCode; ?></td>
			<td><font color="grey" size="4">Day: </font></td>
			<td><?php $day=date("l"); echo $day;?></td>
		</tr>
	</table>
	<br/><br/>
	<table align="center" border="1" width="900" cellspacing="4" cellpadding="6">
		<thead>
			<th>Sr.No.</th>
			<th>Registeration No</th>
			<th>Student Name</th>
			<th>Total Marks</th>
			<th>Obtained Marks</th>
		</thead>
		<tbody>
			<?php
				//query for selecting all the student who are enrolled in the selected subject
				$sql1=mysql_query("SELECT *FROM student JOIN  subjecttostudy " .
					"ON subjecttostudy.StudentID = student.StudentID " .
					"WHERE subjecttostudy.SectionID ='".$sectionID."' AND subjecttostudy.SubjectID ='".$subjectID."'");//selecting all student based on the section id and section id
				$i=0;	
				while($row1=mysql_fetch_array($sql1))//while fetching the list of records
				{
			?>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;<?php echo ($i+1);?></td>
					<td>&nbsp;&nbsp;&nbsp;<?php $studentReg=$row1['RegistrationNo']; echo $studentReg; ?></td>
					<td>&nbsp;&nbsp;&nbsp;<?php $studentName=$row1['Name']; echo $studentName;?></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			<?php
				$i++;
				}
			?>
		</tbody>
	</table>
	<p align="center">Click <a class="btnPrint" href="viewquizsheet.php?scID=<?php echo $sectionID;?>&sbID=<?php echo $subjectID;?>">Here</a> For Print Version</p>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>