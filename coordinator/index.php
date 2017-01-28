<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->
<html xmlns="http://www.w3.org/1999/xhtml"> <!-- according to standards of w3.org -->
<head>
	<title> Coordinator Dashboard</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
	<?php include"../common/tablelibrary.php"; ?><!-- View Table Sorter Related Liberaries -->
</head>
<body>
	<?php include"coordinatorheader.php"; ?><!--side bar menu for the coordinator -->
	<table class="inlineSetting" cellpadding="0" cellspacing="0">
		<tr>
			<td>
							<?php 				
									include_once("../common/commonfunctions.php"); //including Common function library
									include_once("../common/config.php"); //including Common function library
									
									$profileID=$_SESSION['CoordinatorID'];//unsafe variable
									$id=clean($profileID);//cleaning id to preven SQL Injection
									$res = mysql_query("SELECT * FROM `coordinator` WHERE `CoordinatorID` ='$id'");//SELECTING THE user records who profile need to show
									$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
							?>
					<fieldset>
						<legend><h2>Coordinator Info:</h2></legend>
							<table cellpadding="10px" width="800" border="0" align="center"><!--setting up table fields for profile -->
									<tr>
										<td style="font-weight:bold; font-size:15px;">Name: </td>
										<td style="color:grey;"> <?php echo $row['Name'];?></td><!--Posting  Name-->
										
										<td style="font-weight:bold; font-size:15px;">Father Name: </td>
										<td style="color:grey;"> <?php echo $row['FatherName'];?></td><!--Posting  Father Name-->
										
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:15px;">Join Date: </td>
										<td style="color:grey;"> <?php echo $row['JoinDate'];?></td><!--Posting  JoinDate-->
										
										<td style="font-weight:bold; font-size:15px;">Username: </td>
										<td style="color:grey;"> <?php echo $row['Username'];?></td><!--Posting  Username-->
									</tr>
									
									<tr>
										<td style="font-weight:bold; font-size:15px;">Email: </td>
										<td style="color:grey;"> <?php echo $row['Email'];?></td><!--Posting  Email-->
										
										<?php
											$unsafeDiciplineID=$row['DepartmentID'];
											$safeDiciplineID=clean($unsafeDiciplineID);//cleaning id to prevent SQL Injection
											$res1 = mysql_query("SELECT * FROM `departments` WHERE `DepartmentID` ='$safeDiciplineID'");//SELECTING THE user records who profile need to show
											$row1 = mysql_fetch_array($res1);//fetching record as a set of array of selected user
										
										?>
										<td style="font-weight:bold; font-size:15px;">Department: </td>
										<td style="color:grey;"> <?php echo $row1['Name'];?></td><!--Posting  Dicipline-->
									</tr>
							</table>
					</fieldset>
			</td>
		</tr>
	</table>
	<table border="0" class="inlineSetting">
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td>
				<div class="da-panel collapsible">
					<div class="da-panel-header">
						<span class="da-panel-title">
							<img src="../images/list.png" alt="List" />
							<b>Log File Content</b>
						</span>
						
					</div>
					<div class="da-panel-content">
						<table id="da-ex-datatable-numberpaging" class="da-table">
							<thead>
								<tr>
									<th>UserType</th>
									<th>Username</th>
									<th>Date</th>
									<th>Detail</th>
								</tr>
							</thead>
							<tbody>
								<?php
								include_once('../common/config.php'); //including DB Connection File
								include_once("../common/commonfunctions.php"); //including Common function library
								
								$res=mysql_query("SELECT * FROM `logfile` WHERE UserID='$id' AND UserType='Coordinator'"); // applying query to generate list of diciplines
								while($row = mysql_fetch_array($res))//will return the list of coordinators from database
									{
								?>
								<tr>
								   <td><?php echo $row['UserType'];?></td><!-- printing --> 
								   <td>
										<?php
											$table=strtolower($row['UserType']);//setting user type
											$desID=$row['UserID'];
											if($table=="admin")
											{
												$ser=mysql_query("SELECT * FROM `admin` WHERE AdminID='$desID'"); // applying query to generate diciplines name
												$rows = mysql_fetch_array($ser);//will return the username from database
												echo $rows['Username'];
											}
											else if ($table=="coordinator")
													{
														$ser1=mysql_query("SELECT * FROM `coordinator` WHERE CoordinatorID='$desID'"); // applying query to generate diciplines name
														$rows1 = mysql_fetch_array($ser1);//will return the username from database
														echo $rows1['Username'];
													}
													else if($table=="student")
															{
																$ser2=mysql_query("SELECT * FROM `student` WHERE StudentID='$desID'"); // applying query to generate diciplines name
																$rows2 = mysql_fetch_array($ser2);//will return the username from database
																echo $rows2['RegistrationNo'];
															}
															else if($table=="attendent")
															{
																$ser2=mysql_query("SELECT * FROM `attendent` WHERE AttendentID='$desID'"); // applying query to generate diciplines name
																$rows2 = mysql_fetch_array($ser2);//will return the username from database
																echo $rows2['Username'];
															}
															else{
																	$ser3=mysql_query("SELECT * FROM `teacher` WHERE TeacherID='$desID'"); // applying query to generate diciplines name
																	$rows3 = mysql_fetch_array($ser3);//will return the username from database
																	echo $rows3['Username'];
																}
										?>
									</td><!-- printing username name-->
									
									
									<td><?php echo $row['Date'];?></td> <!-- printing Date-->
									<td><?php echo $row['Action'];?></td><!-- printing Detail of Action-->
								</tr>
								<?php 
									}
								?>
							</tbody>
						</table>
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
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>
