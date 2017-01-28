<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!--developed by Arslan Khalid -->
<!DOCTYPE html>	<!-- for supporting Html 5 tags -->

<html xmlns="http://www.w3.org/1999/xhtml"> <!-- according to standards of w3.ord -->
<head>
	<title> Add Attendance Details</title>	<!--title of the page -->
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
				echo'<script type="text/javascript">alert("Error: Class Time Should between 1 to 1.5 Hours. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
				break;
			case 3://message 3 case
				echo'<script type="text/javascript">alert("Error: Lab Time Should be 3 Hours. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
				break;
			case 4://message 4 case
				echo'<script type="text/javascript">alert("Error: Start Time should be less than End Time. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
				break;
			case 5://message 5 case
				echo'<script type="text/javascript">alert("Error: Invalid File Size/Extention.");</script>';//showing the alert box to notify the message to the user
				break;
			case 6://message 6 case
				echo'<script type="text/javascript">alert("Error: Lecture Date must be less than or equal to current date.");</script>';//showing the alert box to notify the message to the user
				break;
			case 7://message 7 case
				echo'<script type="text/javascript">alert("Error: Start Time Should be Less than Current Time.");</script>';//showing the alert box to notify the message to the user
				break;
			case 8://message 8 case
				echo'<script type="text/javascript">alert("Success: Attendance added successfully.");</script>';//showing the alert box to notify the message to the user
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
				<form method="POST" enctype="multipart/form-data" action="insertlecturedetails.php" ><!-- Add Lectures details Form-->
				<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting"> <!-- for alignment of the form -->
					<tr>
						<td colspan="4"> 
							<hr/>	
							<h2 align="center">Add Attendance Details</h2>
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
						
						<td style="font-weight:bold; font-size:15px;">Title:<font color="red">*</font></td>
						<td> 
							<input type="text" name="lectureTitle" id="lectureTitle" placeholder="Enter title" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['LecTitle'])) {$unsafe=$_SESSION['LecTitle']; $lecTitle=clean($unsafe); echo $lecTitle; unset($_SESSION['LecTitle']);}}?>" required /><!-- Taking input of title of the lecture-->
							<!--error message color -->
							<style>
									.LV_invalid 
									{
										color: red;
									}
							</style>
							<!--live validation -->
							<script>
								var f12 = new LiveValidation('lectureTitle');
								f12.add( Validate.Length, { maximum: 30 } );
							</script>
						</td>
					</tr>
					<tr>
						<td style="font-weight:bold; font-size:15px;">Date:<font color="red">*</font></td>
						<td>
							<input type="text" name="lecturDate" id="lecturedatepicker"  placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[/.](0[1-9]|[12][0-9]|3[01])[/.](19|20)\d\d" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['LecDate'])) {$unsafe=$_SESSION['LecDate']; $lecDate=clean($unsafe); echo $lecDate; unset($_SESSION['LecDate']);}}?>" required />
							&nbsp;<span><font color="grey">Hint: mm/dd/yyyy</font></span>
							<!-- Jquery Plugin which picks date-->
							<script>
							  $(function() 
								{
									$( "#lecturedatepicker" ).datepicker({minDate:"-80Y", maxDate: "0D"});
								});
							</script>
						</td>
						<td style="font-weight:bold; font-size:15px;">Lab:<font color="red">*</font></td>
						<td>	
							<select name="isLab" id="isLab"><!--Select that is it lab or not -->
								<option value="0">No</option>
								<option value="1">Yes</option>
							</select>
						</td>
					</tr>
					<tr>
						<td style="font-weight:bold; font-size:15px;">Start Time:<font color="red">*</font> </td><!--starting time of the lecture -->
						<td>
							<input type="text" name="lectureStartTime" id="lectureStartTime" pattern="^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$" placeholder="hh:mm" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['LecStartTime'])) {$unsafe=$_SESSION['LecStartTime']; $lecStart=clean($unsafe); echo $lecStart; unset($_SESSION['LecStartTime']);}}?>"required />
							&nbsp;<span><font color="grey">Hint: hh:mm (24-Hour Time)</font></span>
						</td>
						
						<td style="font-weight:bold; font-size:15px;">End Time:<font color="red">*</font> </td><!--Ending Time time of the lecture -->
						<td>
							<input type="text" name="lectureEndTime" id="lectureEndTime" pattern="^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$" placeholder="hh:mm" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['LecEndTime'])) {$unsafe=$_SESSION['LecEndTime']; $lecEnd=clean($unsafe); echo $lecEnd; unset($_SESSION['LecEndTime']);}}?>" required />
							&nbsp;<span><font color="grey">Hint: hh:mm (24-Hour Time)</font></span>
						</td>
					</tr>
					<tr>
						<td style="font-weight:bold; font-size:15px;">Content: </td>
						<td colspan="2">
							<input class="specialInput" type="file" name="lectureContent" id="lectureContent" /><!--getting Input file -->
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
							<textarea name="lectureDetails" value="lectureDetails" rows="3" cols="66" onkeypress="return imposeMaxLength(this, 100);" required><?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['LecDetails'])) { $unsafe=$_SESSION['LecDetails']; $lecDetail=clean($unsafe); $lecDetail=str_replace('\r\n', ' ',$lecDetail); echo $lecDetail; unset($_SESSION['LecDetails']);}}?></textarea>
							&nbsp;<span><font color="grey">Max Characters: 100</font></span>
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
	<h4 class="alert_success"><?php echo "Course Registeration Open: Attendance Not Availiable."?></h4>
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
