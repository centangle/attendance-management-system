<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!--html5 supported page -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title>Coordinator Profile</title><!--Title of the Page-->
	<?php include"../common/library.php"; ?><!--Common Libraries which includes CSS and Javascript -->
</head>

<body>
	<?php include"adminheader.php"; ?><!--sidebar menu for the admin -->
	<table class="inlineSetting" cellpadding="0" cellspacing="0">
		<tr>
			<td>
							<?php 				
									include_once("../common/commonfunctions.php"); //including Common function library
									include_once("../common/config.php"); //including Common function library
									
									if(is_numeric($_GET['id']))
									$profileID=$_GET['id'];//unsafe variable
									$id=clean($profileID);//cleaning id to preven SQL Injection
									$res = mysql_query("SELECT * FROM `coordinator` WHERE `CoordinatorID` ='$id'");//SELECTING THE user records who profile need to show
									$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
							?>
					<fieldset>
						<legend><h2>Coordinator Profile:</h2></legend>
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
										<td style="font-weight:bold; font-size:15px;">Mobile No: </td>
										<td style="color:grey;"> <?php echo $row['MobileNumber'];?></td><!--Posting  Mobile Number-->
										
										<td style="font-weight:bold; font-size:15px;">Phone No: </td>
										<td style="color:grey;"> <?php echo $row['PhoneNumber'];?></td><!--Posting  Phone Number-->
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:15px;">Email: </td>
										<td style="color:grey;"> <?php echo $row['Email'];?></td><!--Posting  Email-->
										
										<?php
											$unsafeDepartmentID=$row['DepartmentID'];
											$safeDepartmentID=clean($unsafeDepartmentID);//cleaning id to prevent SQL Injection
											$res1 = mysql_query("SELECT * FROM `departments` WHERE `DepartmentID` ='$safeDepartmentID'");//SELECTING THE user records who profile need to show
											$row1 = mysql_fetch_array($res1);//fetching record as a set of array of selected user
										
										?>
										<td style="font-weight:bold; font-size:15px;">Department: </td>
										<td style="color:grey;"> <?php echo $row1['Name'];?></td><!--Posting  Dicipline-->
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:15px;">CNIC: </td><!--Posting  CNIC No-->
										<td style="color:grey;"> <?php echo $row['CNICNo'];?></td>
										
										<td style="font-weight:bold; font-size:15px;">Date of Birth: </td>
										<td style="color:grey;"> <?php echo $row['DOB'];?></td><!--Posting Date of Birth -->
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:15px;">Permanent City: </td><!--Posting  City-->
										<td style="color:grey;"> <?php echo $row['PermanentCity'];?></td>
										<td style="font-weight:bold; font-size:15px;">Image:</td>
										<td rowspan="4">
											<img src="../uploadimages/coordinator/<?php echo $row['Image']?>" alt="profilePicture" width="140px" height="150px"/><!--Posting  Image-->
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:15px;">Permanent Address: </td>
										<td colspan="2" style="color:grey;"> <?php echo $row['PermanentAddress'];?></td><!--Posting  Permanent Address-->
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:15px;">Temporary City: </td><!--Posting  City-->
										<td colspan="2" style="color:grey;"> <?php echo $row['TempCity'];?></td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:15px;">Temporary Address: </td><!--Posting  Address-->
										<td colspan="2" style="color:grey;"> <?php echo $row['TempAddress'];?></td>
										
									</tr>
							</table>
							<p colspan="2" align="center"><a href="viewcoordinator.php"><button class="specialButton">View Coordinators</button></a> | <a href="index.php"><input type="submit" value="Dashboard"/></a></p>
					</fieldset>
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
		
		redirect_to("../clogin.php?msg=Login First!");
		//include("clogin.php");
	}
?>
