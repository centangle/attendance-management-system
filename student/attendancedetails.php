<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title> Attendance Details</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
</head>

<body>
	<?php 
	
		include"studentheader.php";//<!--side bar menu for the Student -->
	    include_once("../common/commonfunctions.php"); //including Common function library
	    include_once("../common/config.php"); //including Common function library
		
		$profileID=$_SESSION['StudentID'];//unsafe variable
		$id=clean($profileID);//cleaning id to preven SQL Injection
		
		if(is_numeric($_GET['lid']))
		$unsafe=$_GET['lid'];
		$lectureID=clean($unsafe);//cleaning the variable
		
		//Keeping the IDs to go back tou List of Lectures page
		if(is_numeric($_GET['id']) && is_numeric($_GET['sID']) )
		$unsafe=$_GET['id'];
		$subjectID=clean($unsafe);//cleaning the variable
		$unsafe=$_GET['sID'];
		$sectionID=clean($unsafe);//cleaning the variable
		
		$unSafe=$_GET['name'];//getting the subject name whos lecture list will be displayed
		$subName=clean($unSafe);
	?>	
	<!-- Query to Get the Details of the Selected Subject -->
	<?php
		// Queries Developed By Bilal Ahmad Ghouri //
		
		// query data and make output
		$res = array();
		$sql1=mysql_query("SELECT Title, Date, StartTime, EndTime, Lab, Description, ContentID FROM lecture WHERE LectureID = '" .$lectureID. "'");
		//echo ("SELECT Title, Date, StartTime, EndTime, Lab, Description, ContentID, RoomID FROM lecture WHERE LectureID = '" .$lectureID. "'");
		if(mysql_num_rows($sql1))			// chek for no error	
		{
			$lec = mysql_fetch_assoc($sql1);
			$lec["Lab"] = $lec["Lab"] == "1" ? "Yes" : "No";
			
			$lec['Duration']= (strtotime($lec['EndTime'])-strtotime($lec['StartTime']))/3600 . " Hours";
		}
		else redirect_to("subjectattendance.php?ErrorID=5&id=<?php echo $subjectID?>&sID=<?php echo $sectionID?>&name=<?php echo $subName;?>");//redirecting toward subject lecture page
	?>
	<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Lecture Details:</h3></header>
			<div class="module_content"><!-- Showing the list of subject for the registeration-->
				
					<div>
						<form>
						<table width="100%" align="center">
							<tr>
							<td style="font-weight:bold; font-size:15px;">Title: </td>
							<td style="color:grey;"> <?php echo $lec['Title'];?></td><!--Posting  Title-->
							
							<td style="font-weight:bold; font-size:15px;">Date: </td>
							<td style="color:grey;"> <?php echo $lec['Date'];?></td><!--Posting  Date-->
							</tr>
							
							<tr>
								<td style="font-weight:bold; font-size:15px;">Start Time: </td>
								<td style="color:grey;"> <?php echo $lec['StartTime'];?></td><!--Posting  Start Time-->
								
								<td style="font-weight:bold; font-size:15px;">End Time: </td>
								<td style="color:grey;"> <?php echo $lec['EndTime'];?></td><!--Posting End Time-->
							</tr>
							
							<tr>
								<td style="font-weight:bold; font-size:15px;">Lab: </td>
								<td style="color:grey;"> <?php echo $lec['Lab'];?></td><!--Posting  Lab Info-->
								
								<td style="font-weight:bold; font-size:15px;">Duration: </td>
								<td style="color:grey;"> <?php echo $lec['Duration'];?></td><!--Posting  Lab Info-->
								
							</tr>
							
							<tr>
								<td style="font-weight:bold; font-size:15px;">Description: </td>
								<td colspan="3" style="color:grey;"> <?php echo $lec['Description'];?></td><!--Posting Description-->
							</tr>
							<tr>
								<td style="font-weight:bold; font-size:15px;">Contents: </td>
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
											No Content Availible
									<?php   } ?>
								</td><!--Posting content Info-->
							</tr>
							<tr>
								<td colspan="4" align="center">
									<a href="subjectattendance.php?id=<?php echo $subjectID?>&sID=<?php echo $sectionID?>&name=<?php echo $subName;?>">
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
