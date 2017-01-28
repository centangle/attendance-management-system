<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title> Task Details</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
</head>
<?php
		if(is_numeric($_GET['ErrorID']))//getting message ids from action file
		$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
		switch($error){
			case 8://message 8 case
				echo'<script type="text/javascript">alert("Success: Task Updated successfully.");</script>';//showing the alert box to notify the message to the user
				break;
		}
?>
<body>
	<?php 
		include"teacherheader.php";//<!--side bar menu for the Student -->
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
		
	?>	
	<?php
		// query data and make output
		$sql1=mysql_query("SELECT *FROM task WHERE TaskID='$taskID'");
		$lec=mysql_fetch_array($sql1);
		$type=$lec['TaskType'];
	?>
	<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;
				<?php  if($type=='a')
						echo "Assignment";
						 else if($type=='q')
								echo "Quiz";
								 else if ($type=='s')
										echo "Sessional";
											else echo "Final";
				?> Details:</h3></header>
			<div class="module_content"><!-- Showing the list of subject for the lectures-->
					<div>
						<form>
						<table width="100%" align="center">
							<tr>
							<td style="font-weight:bold; font-size:15px;">Title: </td>
							<td style="color:grey;"> <?php echo $lec['Title'];?></td><!--Posting  Title-->
							
							<td style="font-weight:bold; font-size:15px;">Total Marks: </td>
							<td style="color:grey;"> <?php echo $lec['TotalMarks'];?></td><!--Posting  Date-->
							</tr>
							
							<tr>
								<td style="font-weight:bold; font-size:15px;">Issue Date: </td>
								<td style="color:grey;"> <?php echo $lec['IssueDate'];?></td><!--Posting  Issue Date-->
								
								<td style="font-weight:bold; font-size:15px;">Due Date: </td>
								<td style="color:grey;"> <?php echo $lec['DueDate'];?></td><!--Posting Due Date-->
							</tr>
							
							<tr>
								<td style="font-weight:bold; font-size:15px;">Content: </td>
								<td style="color:grey;">
									<?php
										if($lec['ContentID']!=NULL)
										{
									?>
											<a  target="_blank" href="downloadcontent.php?cid=<?php echo $lec['ContentID']; ?>">
												<img src="../images/glyphicons_200_download.png"width="16" height="16" alt="download"/>
												&nbsp;Download
											</a>
									<?php
										}
										else
											{
									?>
											Not Availible
									<?php   } ?>
								</td><!--Posting content Info-->
								
								<td style="font-weight:bold; font-size:15px;">Solution: </td>
								<td style="color:grey;">
									<?php
										if($lec['SolutionID']!=NULL)
										{
									?>
											<a  target="_blank" href="downloadcontent.php?cid=<?php echo $lec['SolutionID']; ?>">
												<img src="../images/glyphicons_200_download.png"width="16" height="16" alt="download"/>
												&nbsp;Download
											</a>
									<?php
										}
										else
											{
									?>
											Not Availible
									<?php   } ?>
								</td><!--Posting content Info-->
							</tr>
							
							<tr>
								<td style="font-weight:bold; font-size:15px;">Description: </td>
								<td colspan="3" style="color:grey;"> <?php echo $lec['Description'];?></td><!--Posting Description-->
							</tr>
							<tr>
								<td colspan="4" align="center">
									<a href="viewtasks.php?sbID=<?php echo $subjectID;?>&scID=<?php echo $sectionID;?>">
										<button type="button">GoBack</button>
									</a>
									|
									<a href="updatetaskdetails.php?tid=<?php echo $taskID;?>&sbID=<?php echo $subjectID;?>&scID=<?php echo $sectionID;?>">
										<button type="button">Update</button>
									</a>
								</td>
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
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>
