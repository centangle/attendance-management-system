<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title>View Article</title> <!--title of the page -->
	<?php 
		include"../common/library.php"; 
		include"../common/tablelibrary.php";
	?><!-- Common Libraries containg CSS and Java script files-->
	
</head>
<body>
	<?php include"studentheader.php"; ?><!--side bar menu for the Student -->			
		<?php
			include_once("../common/commonfunctions.php"); //including Common function library
			include_once("../common/config.php"); //including Common function library
			
			$unsafe="RegisterCourse";
			$showTimetable=clean($unsafe);
			
			$unsafe="Close";
			$status=clean($unsafe);
			
			$res = mysql_query("SELECT * FROM `criteria` WHERE `Entity` ='$showTimetable' AND `Value`='$status'");//SELECTING THE user records 
			$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
			if($row)
			{
		?>
	<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting">
		<!-- inserting DataTable Code Here that shows the list of student enrolled in the selected section -->
		<tr>
			<td>
				<div class="da-panel collapsible">
					<div class="da-panel-header">
						<span class="da-panel-title">
							<img src="../images/list.png" alt="List" />
							<b>List of Articles</b>
						</span>
					</div>
					<div class="da-panel-content">
						<table id="da-ex-datatable-numberpaging" class="da-table">
							<thead>
								<tr><!--Headings of the page -->
									<th>Sr.#</th>
									<th width="20%">Title</th>
									<th width="20%">Article For</th>
									<th width="35%">Details</th>
									<th width="20%">Teacher</th>
									<th>Content</th>
								</tr>
							</thead>
							<tbody>
								<?php
									//code for displaying the list of classes in the selected section 
									$sql=mysql_query("SELECT *FROM article");
										$i=0;
										while($row=mysql_fetch_array($sql))
										{
								?>
									<tr>
									   <td>
											<?php 
												echo ($i+1);
											?>
									   </td><!-- printing article no -->
									   
									   <td>
											<?php 
												$title=$row['Title'];
												echo $title;
											?>
									   </td><!-- printing Title -->
									   
									   <td>
											<?php
												$whom= $row['Whom'];
												echo $whom;
											?>
									   </td><!-- printing article users-->
									   <td>
											<?php
												$det= $row['Description'];
												echo $det;
											?>
									   </td><!-- printing article details-->
									   <td>
											<?php
												$tID= $row['TeacherID'];
												$sql9=mysql_query("SELECT *FROM teacher WHERE TeacherID='$tID'");
												$row9=mysql_fetch_array($sql9);
												
												$tName=$row9['Name'];//teacher Name
												echo $tName;
											?>
									   </td><!-- printing article details-->
									   <td>
											<a  target="_blank" href="downloadcontent.php?cid=<?php echo $row['ContentID']; ?>">
												<img src="../images/glyphicons_200_download.png"width="16" height="16" alt="download"/>
											</a>
									   </td>
									</tr>
								<?php
										$i++;
										}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</td>
		</tr>
	</table>
		
		<?php 
			}
		else
			{
		?>
		<div class="inlineSetting">
		<h4 class="alert_success"><?php echo "Course Registeration Open: Articles Option Is Currently Not Availiable."?></h4>
		</div>
		<?php
			}
		?>
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
