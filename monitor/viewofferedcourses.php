<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title> Offered Courses</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
	<script>
		function IsValid(len)
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
			
			if(j == 0)
				alert("Select cources first");
			else
			{
				
				for(var i = 0; i<ids.length; i++)
				{
					idss += ids[i];
					if(i != (ids.length - 1))
						idss += ",";
				}
				idss = "[" + idss + "]";
				var cnfrm=confirm("Are You Want to Submit Registeration?");
				if(cnfrm)
				{
					window.location="submitinterestlist.php?SubjectIDs=" + idss;
				}
			}
		}
	</script>
</head>
						<?php
							if(is_numeric($_GET['ErrorID']))//getting message ids from action file
							$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
							switch($error){
								case 1://message 1 case
									echo'<script type="text/javascript">alert("Error: Select Courses First.");</script>';//showing the alert box to notify the message to the user
									break;
								case 2://message 2 case
									echo'<script type="text/javascript">alert("Success: Course List Submitted.");</script>';//showing the alert box to notify the message to the user
									break;
							}
						?>
<body>
	<?php include"teacherheader.php"; ?><!--side bar menu for the Student -->
		<?php 				
			include_once("../common/commonfunctions.php"); //including Common function library
			include_once("../common/config.php"); //including Common function library
			
			$unsafe="InterestCourse";
			$courseAllotment=clean($unsafe);
			
			$unsafe="Open";
			$status=clean($unsafe);
			
			$res = mysql_query("SELECT * FROM `criteria` WHERE `Entity` ='$courseAllotment' AND `Value`='$status'");//SELECTING THE user records 
			$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
			if($row)
			{
		?>					
		<?php
			$profileID=$_SESSION['TeacherID'];//unsafe variable
			$id=clean($profileID);//cleaning id to preven SQL Injection
		?>
		<div class="inlineSetting">
		<h4 class="alert_success">Course Interest List is  Open: Select your Course Interest List</h4>
		</div>
		<?php
			$sql8=mysql_query("SELECT TeacherID FROM subjectofinterest WHERE TeacherID='$id'");
			$row8=mysql_fetch_array($sql8);
			if($row8)
			{
		?>
		<div class="inlineSetting">
		<h4 class="alert_success">Interest List Submitted. Previously list will be cancelled on submission of new list.</h4>
		</div>
		<?php }?>
	<article class="module width_full_scroll">
			<header><h3>&nbsp;&nbsp;&nbsp;Course Interest List</h3></header>
			<div class="module_content"><!-- Showing the list of subject for the submitting the interest list-->
				<div>
					<table width="100%" align="center">
						<tr>
							<td><font color="black"><h4>Select</h4></font></td>
							<td><font color="black"><h4>Subject Name</h4></font></td>
							<td><font color="black"><h4>Subject Code</h4></font></td>
							<td><font color="black"><h4>Semester</h4></font></td>
							<td><font color="black"><h4>Credit Hours</h4></font></td>
						</tr>
						<tr><td colspan="5"><hr/></td></tr>
							<?php 
								$sql1=mysql_query("SELECT *FROM teacher WHERE TeacherID='$id'");
								$row1=mysql_fetch_array($sql1);
								
								$unsafe=$row1['DepartmentID'];
								$depID=clean($unsafe);
								
								$sql=mysql_query("SELECT subject.SubjectID, subject.Name, subject.Code, subject.CreditHours, catalog.Semester 
											FROM subject JOIN catalog ON subject.SubjectID=catalog.SubjectID WHERE DepartmentID='$depID'");
								$i=0;
								while($row=mysql_fetch_array($sql))
								{
									
							?>
							<tr>
							   <td>
									<input type="checkbox" name="<?php echo $row['SubjectID'];?>" id="chk_<?php echo $i;?>"/>
							   </td>
							   <td>
									<?php echo $row['Name'];?>
							   </td>
								<td>
									<?php echo $row['Code'];?>
							   </td>
							   <td>
									<?php echo $row['Semester'];?>
							   </td>
								<td>
									<?php echo $row['CreditHours'];?>
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
				<div class="clear"></div>
		</div>
	<p align="center">
		<a href="Javascript:IsValid(<?php echo $i;?>)"><button type="button">Submit</button></a>
	</p>
	</article><!-- end of stats article -->
	
	<?php 
	}
	else{
	?>
	<div class="inlineSetting">
	<h4 class="alert_success"><?php echo "Offered Courses List is Closed."?></h4>
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
