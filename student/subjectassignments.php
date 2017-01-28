<?php
	session_start();
	if (isset ($_SESSION['StudentID']))
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html><!--html5 supported page -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title> Subject Assignments</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
	<?php include"../common/tablelibrary.php"; ?><!-- View Table Sorter Related Liberaries -->
	
</head>
	<?php
		if(is_numeric($_GET['ErrorID']))//getting message ids from action file
		$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
		switch($error){
			case 5://message 5 case
				echo'<script type="text/javascript">alert("Assignment Details Not Uploaded Yet.");</script>';//showing the alert box to notify the message to the user
				break;
		}
	?>
<!--Start of Body Tag -->
<body>	
	<?php include"studentheader.php"; //<!-- Side Bar Menu for Administrator -->
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including Common function library
	include_once("../common/queryfunctions.php"); //including Common function library	
	
	if(is_numeric($_GET['id']) && is_numeric($_GET['sID']) )
		$unsafe=$_GET['id'];
		$subjectID=clean($unsafe);//cleaning the variable
		$unsafe=$_GET['sID'];
		$sectionID=clean($unsafe);//cleaning the variable
		
	$unSafe=$_GET['name'];//getting the subject name whos lecture list will be displayed
	$subName=clean($unSafe);
	
	$unSafe=$_GET['type'];//getting the tassk type
	$taskType=clean($unSafe);
	
	//Queries Developed By Bilal Ahmad Ghouri
	// query data
		$sql1=mysql_query("SELECT TaskID, Title, IssueDate, DueDate FROM task JOIN class ON class.ClassID = task.ClassID AND class.SubjectID = '"
								.$subjectID. "' AND class.SectionID = '" .$sectionID. "' AND task.TaskType = '" .$taskType. "'");
		
		if(mysql_num_rows($sql1))			// check no results
		{	
			while($row = mysql_fetch_assoc($sql1))
				$result[] = $row;		// add in array
		}
		else
			redirect_to("viewassignments.php?ErrorID=5");//redirecting toward view lecture page
	?>
	
	<table border="0" class="inlineSetting">
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td>
				<div class="da-panel collapsible">
					<div class="da-panel-header">
						<span class="da-panel-title">
							<img src="../images/list.png" alt="List" />
							<b>Assignments of <?php echo $subName;?></b>
						</span>
					</div>
					<div class="da-panel-content">
						<table id="da-ex-datatable-numberpaging" class="da-table">
							<thead>
								<tr>
									<th>Sr#</th>
									<th>Title</th>
									<th>Issue Date</th>
									<th>Due Date</th>
									<th>Details</th>
								</tr>
							</thead>
							
							<tbody>
								<?php 
								$resCount=count($result);
								
								for ($i=0; $i<$resCount;$i++)
								{
								?>
									<tr>
									   <td>
											<?php echo $i+1;?>
									   </td>
										<td>
											<?php echo $result[$i]['Title'];?>
									   </td>
									   <td>
											<?php echo $result[$i]['IssueDate'];?>
									   </td>
									   <td>
											<?php echo $result[$i]['DueDate'];?>
									   </td>
										<td>
											<a href="assignmentdetails.php?tid=<?php echo $result[$i]['TaskID'];?>&id=<?php echo $subjectID?>&sID=<?php echo $sectionID?>&name=<?php echo $subName;?>&type=<?php echo "a";?>">
											<img src="../images/ic_zoom.png"width="16" height="16" alt="View"> View
											</a>
										</td>
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>
						<p align="center"><a href="viewassignments.php"><button type="button">GoBack</button></a></p>
					</div>
				</div>
			</td>
		</tr>
	</table>
</body>
</html>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../studentlogin.php?msg=Login First!");
	}
?>