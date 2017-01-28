<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title> Assignment Details</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
</head>
<body>
	<?php 
		include"studentheader.php";//<!--side bar menu for the Student -->
	    include_once("../common/commonfunctions.php"); //including Common function library
	    include_once("../common/config.php"); //including Common function library
		
		$profileID=$_SESSION['StudentID'];//unsafe variable
		$id=clean($profileID);//cleaning id to preven SQL Injection
		
		if(is_numeric($_GET['tid']))
		$unsafe=$_GET['tid'];
		$taskID=clean($unsafe);//cleaning the variable
		
		//Keeping the IDs to go back tou List of Lectures page
		if(is_numeric($_GET['id']) && is_numeric($_GET['sID']) )
		$unsafe=$_GET['id'];
		$subjectID=clean($unsafe);//cleaning the variable
		$unsafe=$_GET['sID'];
		$sectionID=clean($unsafe);//cleaning the variable
		
		$unSafe=$_GET['name'];//getting the subject name whos lecture list will be displayed
		$subName=clean($unSafe);
		
		$unsafe=$_GET['type'];
		$type=clean($unsafe);
	?>	
	<!-- Query to Get the Details of the Selected Subject -->
	<?php
		// Queries Developed By Bilal Ahmad Ghouri //
		
		// query data and make output
		$res = array();
		$sql1=mysql_query("SELECT *FROM task WHERE TaskID = '".$taskID."'");
		if(mysql_num_rows($sql1))			// chek for no error	
		{
			$res = mysql_fetch_assoc($sql1);
			$sql2=mysql_query("SELECT ObtainedMarks FROM marks WHERE TaskID = '".$taskID."' AND StudentID = '".$id."'");
			$row = mysql_fetch_assoc($sql2);
			if($row === false) $res["ObtainedMarks"] = "N/A";
			else $res["ObtainedMarks"] = $row["ObtainedMarks"];
		}
		else redirect_to("subjectassignments.php?ErrorID=5&id=<?php echo $subjectID?>&sID=<?php echo $sectionID?>&name=<?php echo $subName;?>&type=<?php echo $type;?>");//redirecting toward subject lecture page
	?>
	<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Assignment Details:</h3></header>
			<div class="module_content"><!-- Showing the list of subject for the registeration-->
				
					<div>
						<form>
						<table width="100%" align="center">
							<tr>
							<td style="font-weight:bold; font-size:15px;">Title: </td>
							<td style="color:grey;"> <?php echo $res['Title'];?></td><!--Posting  Title-->
							
							<td style="font-weight:bold; font-size:15px;">Type: </td>
							<td style="color:grey;"> <?php echo "Assignemnt";?></td><!--Posting  Task Type-->
							</tr>
							
							<tr>
								<td style="font-weight:bold; font-size:15px;">Issue Date: </td>
								<td style="color:grey;"> <?php echo $res['IssueDate'];?></td><!--Posting  Issue Date-->
								
								<td style="font-weight:bold; font-size:15px;">Due Date: </td>
								<td style="color:grey;"> <?php echo $res['DueDate'];?></td><!--Posting Due Date-->
							</tr>
							
							<tr>
								<td style="font-weight:bold; font-size:15px;">Total Marks: </td>
								<td style="color:grey;"> <?php echo $res['TotalMarks'];?></td><!--Posting  Total Marks-->
								
								<td style="font-weight:bold; font-size:15px;">Obtained Marks: </td>
								<td style="color:grey;"> <?php echo $res['ObtainedMarks'];?></td><!--Posting  Obtained Marks-->
							</tr>
							
							<tr>
								<td style="font-weight:bold; font-size:15px;">Assignment: </td>
								<td style="color:grey;">
									<?php
										if($res['ContentID']!=NULL)
										{
									?>
											<a  target="_blank" href="downloadcontent.php?cid=<?php echo $res['ContentID']; ?>">
												<img src="../images/glyphicons_200_download.png"width="16" height="16" alt="download"/>
												&nbsp;Download
											</a>
									<?php
										}
										else
											{
									?>
											No Question Availible
									<?php   } ?>
									
									<td style="font-weight:bold; font-size:15px;">Assignment Solution: </td>
									<td style="color:grey;">
									<?php
										if($res['SolutionID']!=NULL)
										{
									?>
											<a  target="_blank" href="downloadcontent.php?cid=<?php echo $res['SolutionID']; ?>">
												<img src="../images/glyphicons_200_download.png"width="16" height="16" alt="download"/>
												&nbsp;Download
											</a>
									<?php
										}
										else
											{
									?>
											No Solutoin Availible
									<?php   } ?>
								</td><!--Posting content Info-->
							</tr>
							
							<tr>
								<td style="font-weight:bold; font-size:15px;">Description: </td>
								<td colspan="3" style="color:grey;"> <?php echo $res['Description'];?></td><!--Posting Description-->
							</tr>
							
							<tr>
								<td colspan="4" align="center">
									<a href="subjectassignments.php?&id=<?php echo $subjectID?>&sID=<?php echo $sectionID?>&name=<?php echo $subName;?>&type=<?php echo "a";?>">
										<button type="button">GoBack</button>
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
		
		redirect_to("../studentlogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>
