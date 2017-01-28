<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!--developed by Arslan Khalid -->
<!DOCTYPE html>	<!-- for supporting Html 5 tags -->

<html xmlns="http://www.w3.org/1999/xhtml"> <!-- according to standards of w3.ord -->
<head>
	<title> Update Task Details</title>	<!--title of the page -->
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
					
					$sql19=mysql_query("SELECT *FROM task WHERE TaskID='$taskID'");
					$row19=mysql_fetch_array($sql19);
					$type=$row19['TaskType'];
					
		?>	
				<div class="inlineSetting">
				<h4 class="alert_success"><?php echo "Note: DueDate and IssueDate should be same in Case of Quiz/Sessional/Final";?></h4>
				</div>
				<form method="POST" enctype="multipart/form-data" action="updatetaskdetails_action.php?tid=<?php echo $taskID;?>&sbID=<?php echo $subjectID;?>&scID=<?php echo $sectionID;?>&tt=<?php echo $type;?>" ><!-- Add Lectures details Form-->
				<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting"> <!-- for alignment of the form -->
					<tr>
						<td colspan="4"> 
							<hr/>	
							<h2 align="center">Update <?php  if($type=='a')
																echo "Assignment";
																 else if($type=='q')
																		echo "Quiz";
																		 else if ($type=='s')
																				echo "Sessional";
																					else echo "Final";
				?>  Details</h2>
							<hr/>
						</td>
					</tr>
					
					<tr>
						<td style="font-weight:bold; font-size:15px;">Title:<font color="red">*</font></td>
						<td> 
							<input type="text" name="taskTitle" id="taskTitle" placeholder="Enter title" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['tasTitle'])) {$unsafe=$_SESSION['tasTitle']; $lecTitle=clean($unsafe); echo $lecTitle; unset($_SESSION['tasTitle']);}} else echo $row19['Title'];?>" required /><!-- Taking input of title of the lecture-->
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
							<input type="text" name="taskMarks" id="taskMarks" placeholder="Enter total marks" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['tasMark'])) {$unsafe=$_SESSION['tasMark']; $lecTitle=clean($unsafe); echo $lecTitle; unset($_SESSION['tasMark']);}} else echo $row19['TotalMarks'];?>" required /><!-- Taking input of title of the lecture-->
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
							<input type="text" name="issueDate" id="issueDate"  placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[/.](0[1-9]|[12][0-9]|3[01])[/.](19|20)\d\d" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['isueDate'])) {$unsafe=$_SESSION['isueDate']; $lecDate=clean($unsafe); echo $lecDate; unset($_SESSION['isueDate']);}} else echo $row19['IssueDate'];?>" required />
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
							<input type="text" name="dueDate" id="dueDate"  placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[/.](0[1-9]|[12][0-9]|3[01])[/.](19|20)\d\d" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['dueDate'])) {$unsafe=$_SESSION['dueDate']; $lecDate=clean($unsafe); echo $lecDate; unset($_SESSION['dueDate']);}} else echo $row19['DueDate'];?>" required />
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
						<?php
						$isContent=$row19['ContentID'];
						if($isContent==NULL)
						{
						?>
						<td>
							<input type="file" name="taskContent" id="taskContent" /><!--getting Input file -->
							
							<span><font color="grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hint: (.rar|.zip) MaxSize: 
							<?php
								$sql=mysql_query("SELECT *FROM criteria WHERE Entity='UploadFileSize'");//getting the upload file size criteria
								$row=mysql_fetch_array($sql);
								echo $row['Value']." MB";
							?></font></span>
						</td>
						<?php 
						}
						else
						{
							echo "<td>";
							$cid=$row19['ContentID']; 
							$sql=mysql_query("SELECT *FROM content WHERE ContentID='$cid'"); 
							$row=mysql_fetch_array($sql); 
							echo "<b>AttachedFile: ".$row['FileName']."</b>";
							echo "</td>";  
						}
						?>
						</td>
						<td style="font-weight:bold; font-size:15px;">Solution: </td>
						<?php
						$isContent=$row19['SolutionID'];
						if($isContent==NULL)
						{
							echo "<td colspan='2'>";
							$cid=$row19['SolutionID']; 
							$sql=mysql_query("SELECT *FROM content WHERE ContentID='$cid'"); 
							$row=mysql_fetch_array($sql); 
							echo "<b>Not Avalible</b>";
							echo "</td>";  
						}
						else
							{
							echo "<td colspan='2'>";
							$cid=$row19['SolutionID']; 
							$sql=mysql_query("SELECT *FROM content WHERE ContentID='$cid'"); 
							$row=mysql_fetch_array($sql); 
							echo "<b>AttachedFile: ".$row['FileName']."</b>";
							echo "</td>";  
						}
						?>
					</tr>
					
					<tr>
						<td style="font-weight:bold; font-size:15px;">Description: <font color="red">*</font></td><!--Description of the lecture -->
						<td colspan="3">
							<textarea name="taskDetails" value="taskDetails" rows="3" cols="66" onkeypress="return imposeMaxLength(this, 150);" required><?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['tasDetails'])) { $unsafe=$_SESSION['tasDetails']; $lecDetail=clean($unsafe); $lecDetail=str_replace('\r\n', ' ',$lecDetail); echo $lecDetail; unset($_SESSION['tasDetails']);}} else echo $row19['Description'];?></textarea>
							&nbsp;<span><font color="grey">Max Characters: 150</font></span>
						</td>
					</tr>
					
					<tr>
						<td colspan="4" align="center">
							<input type="submit" value="Submit"/> | <a href="taskdetails.php?tid=<?php echo $taskID;?>&sbID=<?php echo $subjectID;?>&scID=<?php echo $sectionID;?>"><button type="button">GoBack</button></a>
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
