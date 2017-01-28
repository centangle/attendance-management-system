<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title> Student Dashboard</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
	<?php include"../common/tablelibrary.php"; ?><!-- View Table Sorter Related Liberaries -->
</head>

<body>
	<?php include"studentheader.php"; ?><!--side bar menu for the Student -->
							<?php 				
									include_once("../common/commonfunctions.php"); //including Common function library
									include_once("../common/config.php"); //including Common function library
									
									$profileID=$_SESSION['StudentID'];//unsafe variable
									$id=clean($profileID);//cleaning id to preven SQL Injection
									$res = mysql_query("SELECT * FROM `student` WHERE `StudentID` ='$id'");//SELECTING THE user records who profile need to show
									$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
							?>
	<div>
        <table class="dashboardInfoTable" cellpadding="0" cellspacing="0">
            <tr>
                <td rowspan="4" ><img src="../uploadimages/student/<?php echo $row['Image']?>" alt="profilePicture" width="110px" height="120px"/><!--Posting  Image--></td>
            </tr>
            <tr>
                <td ><h4>Name: </h4></td>
                <td ><?php echo $row['Name'];?></td>
                <td ><h4>Registration No: </h4></td>
                <td > <?php echo $row['RegistrationNo'];?></td>
            </tr>
										<?php
											$unsafeDiciplineID=$row['DisciplineID'];
											$safeDiciplineID=clean($unsafeDiciplineID);//cleaning id to prevent SQL Injection
											//echo $safeDiciplineID;
											$res1 = mysql_query("SELECT * FROM `discipline` WHERE `DisciplineID` ='$safeDiciplineID'");//SELECTING THE user records who profile need to show
											//echo $res1;
											$row1 = mysql_fetch_array($res1);//fetching record as a set of array of selected user
										
										?>
            <tr>
                <td ><h4>Program: </h4></td>
                <td > <?php echo $row1['DisciplineName'];?></td>
										<?php
											$unsafeSectionID=$row['SectionID'];
											$safeSectionID=clean($unsafeSectionID);//cleaning id to prevent SQL Injection
											$res12 = mysql_query("SELECT * FROM `section` WHERE `SectionID` ='$safeSectionID'");//SELECTING THE user records who profile need to show
											$row11 = mysql_fetch_array($res12);//fetching record as a set of array of selected user
										
										?>
                <td ><h4>Section: </h4></td>
                <td ><?php echo $row1['DisciplineCode']."-".$row['Semester'].$row11['SectionCode'];?> </td>
            </tr>
            <tr>
                <td ><h4>Mobile: </h4></td>
                <td > <?php echo $row['MobileNumber'];?></td>
                <td ><h4>Email: </h4></td>
                <td > <?php echo $row['EmailAddress'];?></td>
            </tr>
        </table>
    </div>
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
								$res=mysql_query("SELECT * FROM `logfile` WHERE UserID='$id' AND UserType='Student'"); // applying query to generate list of diciplines
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
		
		redirect_to("../studentlogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>
