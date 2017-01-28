<?php
	session_start();
	if (isset ($_SESSION['StudentID']))
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html><!--html5 supported page -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title> Subject Lectures</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
	<?php include"../common/tablelibrary.php"; ?><!-- View Table Sorter Related Liberaries -->
	
</head>
	<?php
		if(is_numeric($_GET['ErrorID']))//getting message ids from action file
		$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
		switch($error){
			case 5://message 5 case
				echo'<script type="text/javascript">alert("Details Not Uploaded Yet.");</script>';//showing the alert box to notify the message to the user
				break;
		}
	?>
<!--Start of Body Tag -->
<body>	
	<?php include"studentheader.php"; //<!-- Side Bar Menu for Administrator -->
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including Common function library
	include_once("../common/queryfunctions.php"); //including Common function library	
	
	$profileID=$_SESSION['StudentID'];//unsafe variable
	$id=clean($profileID);//cleaning id to preven SQL Injection
	
	if(is_numeric($_GET['id']) && is_numeric($_GET['sID']) )
		$unsafe=$_GET['id'];
		$subjectID=clean($unsafe);//cleaning the variable
		$unsafe=$_GET['sID'];
		$sectionID=clean($unsafe);//cleaning the variable
		
	$unSafe=$_GET['name'];//getting the subject name whos lecture list will be displayed
	$subName=clean($unSafe);
	
	//Queries Developed By Bilal Ahmad Ghouri
	// query data and make output
		$res = array();
		$sql1=mysql_query("SELECT LectureID, Title, Date, Lab FROM lecture JOIN class ON lecture.ClassID = class.ClassID AND " .
																		"class.SectionID = '" .$sectionID. "' AND " .
																		"class.SubjectID = '" .$subjectID. "'");
		if(mysql_num_rows($sql1))			// chek for no error	
		{
			while($row = mysql_fetch_assoc($sql1))
			{
				$title = $row["Lab"] == "1" ? $row["Title"] . "" : $row["Title"];
				$result[] = array("LectureID" => $row["LectureID"], "Title" => $title, "Date" => $row["Date"], "Lab" => $row["Lab"]);
			}
		}
		else redirect_to("viewlectures.php?ErrorID=5");//redirecting toward view lecture page
	?>
	
	<table border="0" class="inlineSetting">
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td>
				<div class="da-panel collapsible">
					<div class="da-panel-header">
						<span class="da-panel-title">
							<img src="../images/list.png" alt="List" />
							<b>Lectures of <?php echo $subName;?></b>
						</span>
					</div>
					<div class="da-panel-content">
						<table id="da-ex-datatable-numberpaging" class="da-table">
							<thead>
								<tr>
									<th>Lecture No</th>
									<th>Topic</th>
									<th>Lab</th>
									<th>Date</th>
									<th>Full Detail</th>
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
											<?php if ($result[$i]['Lab']==1) echo "Yes"; else echo "No";?>
									   </td>
									   <td>
											<?php echo $result[$i]['Date'];?>
									   </td>
										<td>
											<a href="lecturedetails.php?lid=<?php echo $result[$i]['LectureID'];?>&id=<?php echo $subjectID?>&sID=<?php echo $sectionID?>&name=<?php echo $subName;?>">
											<img src="../images/ic_zoom.png"width="16" height="16" alt="View"> View
											</a>
										</td>
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>
						<p align="center"><a href="viewlectures.php"><button type="button">GoBack</button></a></p>
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