<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title> Course Assesment</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
</head>
						<?php
							if(is_numeric($_GET['ErrorID']))//getting message ids from action file
							$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
							switch($error){
								case 1://message 5 case
									echo'<script type="text/javascript">alert("Error: Check  All the Radio Buttons.");</script>';//showing the alert box to notify the message to the user
									break;
							}
						?>
<body>
	<?php include"studentheader.php"; ?><!--side bar menu for the Student -->
		<?php 				
			include_once("../common/commonfunctions.php"); //including Common function library
			include_once("../common/config.php"); //including Common function library
			
			
			//--------------Checking Either Course Assesment is Availible or Not -------------//
			$unsafe="Assesment";
			$courseAssesment=clean($unsafe);
			
			$unsafe="Open";
			$status=clean($unsafe);
			
			$res = mysql_query("SELECT * FROM `criteria` WHERE `Entity` ='$courseAssesment' AND `Value`='$status'");//SELECTING THE user records 
			$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
			if($row)
			{
	
			$profileID=$_SESSION['StudentID'];//unsafe variable
			$id=clean($profileID);//cleaning id to preven SQL Injection
			
			$unsafe=$_GET['id'];
			$subjectID=clean($unsafe);
			$unsafe=$_GET['sID'];
			$sectionID=clean($unsafe);
			
			//---------------queries for getting the teacher id on the basis of section id and subject id-------//
			$sql6=mysql_query("SELECT `ClassID` FROM `class` WHERE `SubjectID`='$subjectID' AND `SectionID`='$sectionID'");

			if(mysql_num_rows($sql6))			// check no results
			{
				$row6=mysql_fetch_array($sql6);
				$classID=$row6['ClassID'];
			}
			else 
				redirect_to("viewassesment.php?ErrorID=1");//redirecting toward view lecture page
			$sql7=mysql_query("SELECT `TeacherID` FROM `subjecttoteach` WHERE `ClassID`='$classID'");
			
			if(mysql_num_rows($sql6))			// check no results
			{
				$row7=mysql_fetch_array($sql7);
				$teacherID=$row7['TeacherID'];
			}
			else 
				redirect_to("viewassesment.php?ErrorID=2");//redirecting toward view lecture page
			
		?>
	<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Teacher/Course and Self Assessment</h3></header>
			<div class="module_content"><!-- Showing the list of subject for the registeration-->
				<div>
					<form method="POST" action="submitassesment.php?cID=<?php echo $subjectID; ?>&tID=<?php echo $teacherID;?>&scID=<?php echo $sectionID;?>">
					<table width="100%" align="center">
						<?php
							$sql8=mysql_query("SELECT *FROM question");
							
							while($row8=mysql_fetch_array($sql8))
							{
						?>
						<tr>
							<td><font color="black" size="2.5"><b>Question <?php echo$row8['QuestionID'];?>:</b> <?php echo $row8['QuestionDetail']?></font></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="radio" name="ans<?php echo$row8['QuestionID'];?>" value="1"/>&nbsp;Below Average  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="ans<?php echo$row8['QuestionID'];?>" value="2"/>&nbsp;Average  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="ans<?php echo$row8['QuestionID'];?>" value="3"/>&nbsp;Good  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="ans<?php echo$row8['QuestionID'];?>" value="4"/>&nbsp;Very Good	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="ans<?php echo$row8['QuestionID'];?>" value="5"/>&nbsp;Excellent
							</td>
						</tr>
						<?php
							}
						?>
						
						<tr>
							<td colspan="2" align="center">
								<input type="submit" value="Submit"/>
							</td>
						</tr>
					</table>
				</div>
				<div class="clear"></div>
		</div>
	</article><!-- end of stats article -->
	<?php 
	}
	else{
	?>
	<div class="inlineSetting">
	<h4 class="alert_success"><?php echo "Course Assesment is Closed."?></h4>
	</div>
	<?php }?>
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
