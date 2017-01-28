<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!--developed by Arslan Khalid -->
<!DOCTYPE html>	<!-- for supporting Html 5 tags -->

<html xmlns="http://www.w3.org/1999/xhtml"> <!-- according to standards of w3.ord -->
<head>
	<title> Add Task Details</title>	<!--title of the page -->
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
			case 1://message 1 case
				echo'<script type="text/javascript">alert("Error: Empty Fields are not Allowed.");</script>';//showing the alert box to notify the message to the user
				break;
			case 2://message 2 case
				echo'<script type="text/javascript">alert("Error: DueDate must be greater than Issue Date in Case of Assignment. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
				break;
			case 3://message 3 case
				echo'<script type="text/javascript">alert("Error: DueDate must be equal to Issue Date in Case of Quiz, Sessional and Final. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
				break;
			case 5://message 5 case
				echo'<script type="text/javascript">alert("Error: Invalid File Size/Extention.");</script>';//showing the alert box to notify the message to the user
				break;
			case 6://message 6 case
				echo'<script type="text/javascript">alert("Error: Issue Date must be less than or equal to current date.");</script>';//showing the alert box to notify the message to the user
				break;
			case 8://message 8 case
				echo'<script type="text/javascript">alert("Success: Task added successfully.");</script>';//showing the alert box to notify the message to the user
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
				<div class="inlineSetting">
				<h4 class="alert_success"><?php echo "Note: DueDate and IssueDate should be same in Case of Quiz/Sessional/Final";?></h4>
				</div>
				<form method="POST" enctype="multipart/form-data" action="inserttaskdetails.php" ><!-- Add Lectures details Form-->
				<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting"> <!-- for alignment of the form -->
					<tr>
						<td colspan="4"> 
							<hr/>	
							<h2 align="center">Add Task Details</h2>
							<hr/>
						</td>
					</tr>
					<tr>
						<td style="font-weight:bold; font-size:15px;">Class: </td>
						<td>
							<select name="toClass" id="toClass"><!--Generate a List of classes of Current Semester -->
								<?php
									//for selecting the list of semester that teacher is teaching in this semester
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
						<td style="font-weight:bold; font-size:15px;">Type: </td>
						<td>
							<select name="taskType" id="taskType">
								<option value='a'>Assignment</option>
								<option value='q'>Quiz</option>
								<option value='s'>Sessionals</option>
								<option value='f'>Final</option>
							</select>
						</td>
					</tr>
					<tr>
						<td style="font-weight:bold; font-size:15px;">Title:<font color="red">*</font></td>
						<td> 
							<input type="text" name="taskTitle" id="taskTitle" placeholder="Enter title" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['tasTitle'])) {$unsafe=$_SESSION['tasTitle']; $lecTitle=clean($unsafe); echo $lecTitle; unset($_SESSION['tasTitle']);}}?>" required /><!-- Taking input of title of the lecture-->
							<!--error message color -->
							<style>
									.LV_invalid 
									{
										color: red;
									}
							</style>
							<!--live validation -->
							<script>
								var f12 = new LiveValidation('taskTitle');
								f12.add( Validate.Length, { maximum: 50 } );
							</script>
						</td>
						
						<td style="font-weight:bold; font-size:15px;">Total Marks:<font color="red">*</font></td>
						<td> 
							<input type="text" name="taskMarks" id="taskMarks" placeholder="Enter total marks" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['tasMark'])) {$unsafe=$_SESSION['tasMark']; $lecTitle=clean($unsafe); echo $lecTitle; unset($_SESSION['tasMark']);}}?>" required /><!-- Taking input of title of the lecture-->
							&nbsp;<span><font color="grey">Hint: Integer Only</font></span>
							<!--live validation -->
							<script>
								var f3 = new LiveValidation('taskMarks');
								f3.add( Validate.Numericality );
							</script>
						</td>
					</tr>
					<tr>
						<td style="font-weight:bold; font-size:15px;">Issue Date:<font color="red">*</font></td>
						<td>
							<input type="text" name="issueDate" id="issueDate"  placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[/.](0[1-9]|[12][0-9]|3[01])[/.](19|20)\d\d" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['isueDate'])) {$unsafe=$_SESSION['isueDate']; $lecDate=clean($unsafe); echo $lecDate; unset($_SESSION['isueDate']);}}?>" required />
							&nbsp;<span><font color="grey">Hint: mm/dd/yyyy</font></span>
							<!-- Jquery Plugin which picks date-->
							<script>
							  $(function() 
								{
									$( "#issueDate" ).datepicker({minDate:"-10Y", maxDate: "0D"});
								});
							</script>
						</td>
						
						<td style="font-weight:bold; font-size:15px;">Due Date:<font color="red">*</font></td>
						<td>
							<input type="text" name="dueDate" id="dueDate"  placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[/.](0[1-9]|[12][0-9]|3[01])[/.](19|20)\d\d" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['dueDate'])) {$unsafe=$_SESSION['dueDate']; $lecDate=clean($unsafe); echo $lecDate; unset($_SESSION['dueDate']);}}?>" required />
							&nbsp;<span><font color="grey">Hint: mm/dd/yyyy</font></span>
							<!-- Jquery Plugin which picks date-->
							<script>
							  $(function() 
								{
									$( "#dueDate" ).datepicker({minDate:"-10Y"});
								});
							</script>
						</td>
					</tr>
					
					<tr>
						<td style="font-weight:bold; font-size:15px;">Content: </td>
						<td colspan="2">
							<input class="specialInput" type="file" name="taskContent" id="taskContent" /><!--getting Input file -->
							<span><font color="grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hint: (.rar|.zip) MaxSize: 
							<?php
								$sql=mysql_query("SELECT *FROM criteria WHERE Entity='UploadFileSize'");//getting the upload file size criteria
								$row=mysql_fetch_array($sql);
								echo $row['Value']." MB";
							?></font></span>
						</td>
					</tr>
					
					<tr>
						<td style="font-weight:bold; font-size:15px;">Description: <font color="red">*</font></td><!--Description of the lecture -->
						<td colspan="3">
							<textarea name="taskDetails" value="taskDetails" rows="3" cols="66" onkeypress="return imposeMaxLength(this, 150);" required><?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['tasDetails'])) { $unsafe=$_SESSION['tasDetails']; $lecDetail=clean($unsafe); $lecDetail=str_replace('\r\n', ' ',$lecDetail); echo $lecDetail; unset($_SESSION['tasDetails']);}}?></textarea>
							&nbsp;<span><font color="grey">Max Characters: 150</font></span>
						</td>
					</tr>
					
					<tr>
						<td colspan="4" align="center">
							<input type="submit" value="Submit"/> | <button type="reset">Reset</button>
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
