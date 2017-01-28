<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!--html5 supported page -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title>Student Profile</title><!--Title of the Page-->
	<?php include"../common/library.php"; ?><!--Common Libraries which includes CSS and Javascript -->
</head>

<body>
	<?php include"adminheader.php"; ?><!--sidebar menu for the Admin -->
	<table class="inlineSetting" cellpadding="0" cellspacing="0">
		<tr>
			<td>
							<?php 				
									include_once("../common/commonfunctions.php"); //including Common function library
									include_once("../common/config.php"); //including Common function library
									if(is_numeric($_GET['id']))
									$profileID=$_GET['id'];//unsafe variable
									$id=clean($profileID);//cleaning id to preven SQL Injection
									$res = mysql_query("SELECT * FROM `student` WHERE `StudentID` ='$id'");//SELECTING THE user records who profile need to show
									$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
							?>
					<fieldset>
						<legend><h2>Student Profile:</h2></legend>
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
										
										<td style="font-weight:bold; font-size:15px;">Religon: </td>
										<td style="color:grey;"> <?php echo $row['Religon'];?></td><!--Posting  RegistrationNo-->
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:15px;">Semester: </td>
										<td style="color:grey;"> <?php echo $row['Semester'];?></td><!--Posting  JoinDate-->
										
										<td style="font-weight:bold; font-size:15px;">Registeration No: </td>
										<td style="color:grey;"> <?php echo $row['RegistrationNo'];?></td><!--Posting  RegistrationNo-->
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:15px;">Mobile No: </td>
										<td style="color:grey;"> <?php echo $row['MobileNumber'];?></td><!--Posting  Mobile Number-->
										
										<td style="font-weight:bold; font-size:15px;">Phone No: </td>
										<td style="color:grey;"> <?php echo $row['PhoneNumber'];?></td><!--Posting  Phone Number-->
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:15px;">Email: </td>
										<td style="color:grey;"> <?php echo $row['EmailAddress'];?></td><!--Posting  Email-->
										
										<?php
											$unsafeDiciplineID=$row['DisciplineID'];
											$safeDiciplineID=clean($unsafeDiciplineID);//cleaning id to prevent SQL Injection
											//echo $safeDiciplineID;
											$res1 = mysql_query("SELECT * FROM `discipline` WHERE `DisciplineID` ='$safeDiciplineID'");//SELECTING THE user records who profile need to show
											//echo $res1;
											$row1 = mysql_fetch_array($res1);//fetching record as a set of array of selected user
										
										?>
										<td style="font-weight:bold; font-size:15px;">Dicipline: </td>
										<td style="color:grey;"> <?php echo $row1['DisciplineName'];?></td><!--Posting  Dicipline-->
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
											<img src="../uploadimages/student/<?php echo $row['Image']?>" alt="profilePicture" width="140px" height="150px"/><!--Posting  Image-->
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
									<tr>
										<td colspan="4">
											<hr /><!-- Adding Seprator Line -->
										</td>
									</tr>
									<?php
										$res4 = mysql_query("SELECT * FROM `parentinfo` WHERE `ParentInfoID` ='$id'");//SELECTING THE user records who profile need to show
										$row4 = mysql_fetch_array($res4);//fetching record as a set of array of selected user
									?>
									<tr>
										<td style="font-weight:bold; font-size:15px;">Parent Mobile: </td>
										<td style="color:grey;"> <?php echo $row4['MobileNumber'];?></td><!--Posting  Parent Mobile Number-->
										
										<td style="font-weight:bold; font-size:15px;">Parent Email: </td>
										<td style="color:grey;"> <?php echo $row4['EmailAddress'];?></td><!--Posting Parent Email Address-->
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:15px;">Parent Office No: </td>
										<td style="color:grey;"> <?php echo $row4['OfficeNumber'];?></td><!--Posting  Parent Office No-->
										
										<td style="font-weight:bold; font-size:15px;">Office Fax No: </td>
										<td style="color:grey;"> <?php echo $row4['FaxNumber'];?></td><!--Posting  Parent Office Fax Number-->
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:15px;">Profession: </td>
										<td style="color:grey;"> <?php echo $row4['Profession']."  (".$row4['OrganizationType'].")";?></td><!--Posting  Profession detail and job type-->
										
										<td style="font-weight:bold; font-size:15px;">Grade: </td>
										<td style="color:grey;"> <?php echo $row4['Grade'];?></td><!--Posting  Father Grade-->
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:15px;">Income: </td>
										<td style="color:grey;"> <?php echo $row4['Income'];?></td><!--Posting  Father Income-->
										
										<td style="font-weight:bold; font-size:15px;">Phone No: </td>
										<td style="color:grey;"> <?php echo $row4['OrganizationAddress'];?></td><!--Posting  Phone Number-->
									</tr>
							</table>
							<p colspan="2" align="center"><a href="viewstudent.php"><button class="specialButton">View Students</button></a> | <a href="viewstudentresult.php?sid=<?php echo $id;?>"><button>View Result</button></a> | <a href="index.php"><button>Dashboard</button></a></p>
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
		
		redirect_to("../studentlogin.php?msg=Login First!"); //redirecting toward login page if session is not maintained
		//include("clogin.php");
	}
?>
