<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!--developed by Arslan Khalid -->
<!DOCTYPE html>	<!-- for supporting Html 5 tags -->

<html xmlns="http://www.w3.org/1999/xhtml"> <!-- according to standards of w3.ord -->
<head>
	<title> Add Solution Details</title>	<!--title of the page -->
	<?php include"../common/library.php"; ?><!-- Common Libraries containg CSS and Java script files-->
	
	<!--function for validating the text area -->
	<script language="javascript" type="text/javascript">
	function imposeMaxLength(Object, MaxLen)
	{
	  return (Object.value.length <= MaxLen);
	}
	</script>
</head>
<?php
	if(is_numeric($_GET['ErrorID']))//getting message ids from action file
	$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
	switch($error){
		case 5://message 5 case
			echo'<script type="text/javascript">alert("Error: Invalid File Size/Extention.");</script>';//showing the alert box to notify the message to the user
			break;
	}
?>

<body>
	<?php include"teacherheader.php"; ?><!--side bar menu for the Student -->
		<?php 				
			include_once("../common/commonfunctions.php"); //including Common function library
			include_once("../common/config.php"); //including Common function library
			
			$profileID=$_SESSION['TeacherID'];//unsafe variable
			$id=clean($profileID);//cleaning id to preven SQL Injection
			
			if(is_numeric($_GET['tid']))
			$unsafe=$_GET['tid'];
			$taskID=clean($unsafe);//cleaning the variable
			
			if(is_numeric($_GET['sbID']))
			$unsafe=$_GET['sbID'];
			$subjectID=clean($unsafe);//cleaning the variable
			
			if(is_numeric($_GET['scID']))
			$unsafe=$_GET['scID'];
			$sectionID=clean($unsafe);//cleaning the variable
			
			$unsafe="RegisterCourse";
			$courseAllotment=clean($unsafe);
			
			$unsafe="Close";
			$status=clean($unsafe);
			
			$res = mysql_query("SELECT *FROM `criteria` WHERE `Entity` ='$courseAllotment' AND `Value`='$status'");//SELECTING THE  records 
			$row = mysql_fetch_array($res);//fetching record as a set of array of selected value
			
			if($row)
			{
				$res1 = mysql_query("SELECT *FROM `criteria` WHERE `Entity` ='CUD' AND `Value`='Open'");//SELECTING THE  records 
				$row1 = mysql_fetch_array($res1);//fetching record as a set of array of selected value
				if($row1)
				{
		?>	
				<form method="POST" enctype="multipart/form-data" action="insertsolutiondetails.php?tid=<?php echo $taskID;?>&sbID=<?php echo $subjectID;?>&scID=<?php echo $sectionID;?>" ><!-- Add Lectures details Form-->
				<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting"> <!-- for alignment of the form -->
					<tr>
						<td colspan="4"> 
							<hr/>	
							<h2 align="center">Add Solution Details</h2>
							<hr/>
						</td>
					</tr>
					
					<tr>
						<td style="font-weight:bold; font-size:15px;">Solution: <font color="red">*</font></td>
						<td colspan="2">
							<input class="specialInput" type="file" name="task" id="task" required /><!--getting Input file -->
							<span><font color="grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hint: (.rar|.zip) MaxSize: 
							<?php
								$sql=mysql_query("SELECT *FROM criteria WHERE Entity='UploadFileSize'");//getting the upload file size criteria
								$row=mysql_fetch_array($sql);
								echo $row['Value']." MB";
							?></font></span>
						</td>
					</tr>
					
					<tr>
						<td colspan="4" align="center">
							<input type="submit" value="Submit"/> | <a href="addtasksolution.php?sbID=<?php echo $subjectID;?>&scID=<?php echo $sectionID;?>"><button type="button">GoBack</button></a>
							<hr/>
						</td>
					</tr>
				</table>
				</form>
	<?php 
		}
		else
			{
	?>
			<div class="inlineSetting">
			<h4 class="alert_success"><?php echo "Addition/Updation/Deletion is Closed by the Coordinator."?></h4>
			</div>
	<?php
			}
	}
	else{
	?>
	<div class="inlineSetting">
	<h4 class="alert_success"><?php echo "Course Registeration Open: Add Task Not Availiable."?></h4>
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
