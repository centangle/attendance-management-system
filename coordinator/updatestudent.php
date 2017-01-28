<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title> Update Student</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
</head>
<!--Start of Body Tag -->
<body>	
	<?php include"coordinatorheader.php"; ?> <!-- Side Bar Menu for Administrator -->
	<div>   
        <h1 class="h1Special">&nbsp;&nbsp;&nbsp;Updating Student Record</h1>
    </div>
						<?php
							if(is_numeric($_GET['ErrorID']))//getting message ids from action file
							$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
							switch($error){
								case 3://message 3 case
									echo'<script type="text/javascript">alert("Error: Join Date must be greater than Date of Birth");</script>';//showing the alert box to notify the message to the user
									break;
							}
						?>
    <div> <!-- Form Wizard for Registering a new Student -->
									<?php
											include_once("../common/commonfunctions.php"); //including Common function library
											include_once('../common/config.php');
											
											$unsafe=$_GET['id'];
											$safeID=clean($unsafe);//cleaning variable for prevention of sql injection
											
											$r=mysql_query("SELECT * FROM `student` WHERE StudentID='$safeID'");
											$res=mysql_fetch_array($r);
									?>
	
		<form action="update_student_action.php?id=<?php echo $safeID;?>" method="POST" enctype="multipart/form-data"> <!-- Start of Register Student form -->
			<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting"> <!-- for alignment of the form -->
				<tr>
					<td colspan="2"> 
						<hr/>	
						<h2 class="StepTitle" align="center">Basic Information Content</h2>
						<hr/>
					</td>
				</tr>
				<?php
					include_once('../common/config.php'); //including DB Connection File
					$coodinatorID=$_SESSION['CoordinatorID'];
					$result = mysql_query("SELECT * FROM `coordinator` WHERE CoordinatorID='$coodinatorID'"); // applying query to generate list of diciplines
					$rows = mysql_fetch_array($result);//will return the list of record from database
						$getCoordinatorDiscipline=$rows['DisciplineID'];//setting the discipline ID in which coordinator can register students
				?>
				<tr>
					<td width="50%">
						<table>
							<tr>
								<td>
									<label>Section: <font color="red">*</font></label> 
								</td>
								<td>
									<select name="studentSection" id="studentSection">	<!-- Generate a list of Sections from Database for Coordinator --> 
										<option selected><?php echo $res['SectionID'];?></option>
										<?php 
											$result3 = mysql_query("SELECT * FROM `section` WHERE Semester='1'"); // applying query to generate list of sections
											while($rows3 = mysql_fetch_array($result3)) //will return the list of disciplines from database
											{
											echo "<option value='$rows3[SectionID]'>".$rows3['SectionCode']."</option>";
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>
									<label>Password: <font color="red">*</font></label>
								</td>
								<style>
									.LV_invalid 
									{
										color: red;
									}
								</style>
								<td>
									<input type="text" name="studentPassword" id="studentPassword" value="<?php echo $res['Password'];?>" placeholder="enter password" required />
									<script>
										var f4 = new LiveValidation('studentPassword');
										f4.add( Validate.Length, { minimum: 5, maximum: 30 } );
									</script>
								</td>
							</tr>
							
							<tr>
								<td>
									<label>Name: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentName" id="studentName" value="<?php echo $res['Name'];?>" placeholder="enter name" required />
								</td>
							</tr>
							<tr>
								<td>
									<label>Father Name: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentFatherName" id="studentFatherName" value="<?php echo $res['FatherName'];?>" placeholder="enter fathername" required />
								</td>
							</tr>
							<tr>
								<td>
									<label>CNIC No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentCNIC" id="studentCNIC" value="<?php echo $res['CNICNo'];?>" placeholder="3520294594631" required />
									&nbsp;<span><font color="grey">Hint: 3520294594631</font></span>
									<script>
											var f4 = new LiveValidation('studentCNIC');
										f4.add( Validate.Numericality, { onlyInteger: true } );
										f4.add( Validate.Length, { minimum: 13, maximum: 13 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Birth Date: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentDOB" id="studentDOB" value="<?php echo $res['DOB'];?>" placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" required />
									&nbsp;<span><font color="grey">Hint: mm/dd/yyyy</font></span>
									<!--<script>
									  $(function() {
										$( "#datepicker" ).datepicker({ minDate:"-80Y", maxDate: "-19Y 8M"});
									  });-->
								</td>
							</tr>
							<tr>
								<td>
									<label>Religon: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentReligon" id="studentReligon" value="<?php echo $res['Religon'];?>" placeholder="islam" required />
									<script>
										var f4 = new LiveValidation('studentReligon');
										f4.add( Validate.Length, { maximum: 10 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Join Date: <font color="red">*</font></label><!-- have to use the calendar widget here-->
								</td>
								<td>
									<input type="text" name="studentJoinDate" id="studentJoinDate" value="<?php echo $res['JoinDate'];?>"  placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" required />
									&nbsp;<span><font color="grey">Hint: mm/dd/yyyy</font></span>
									<script>
									  $(function() {
										$( "#joindatepicker" ).datepicker({minDate:"-80Y", maxDate: "0D"});
									  });
									</script>
								</td>
							</tr>
						</table>
					</td>
					<td width="50%">
						<table>
							
							<tr>
								<td>
									<label>Mobile No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentMobileNumber" id="studentMobileNumber" value="<?php echo $res['MobileNumber'];?>" pattern="[0-0]{1}[3-3]{1}[0-9]{9}" placeholder="03335367073" required />
									&nbsp;<span><font color="grey">Hint: 03335367987</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Phone No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentPhoneNumber" id="studentPhoneNumber" value="<?php echo $res['PhoneNumber'];?>" pattern="[0-0]{1}[1-9]{2}[0-9]{7}" placeholder="0514433996" required />
									&nbsp;<span><font color="grey">Hint: 0514438064</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Email: <font color="red">*</font></label>
								</td>
								<td>
									<input type="email" name="studentEmail" id="studentEmail" value="<?php echo $res['EmailAddress'];?>" placeholder="something@mail.com" required />
									&nbsp;<span><font color="grey">Hint: abc@mail.com</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Permanent Address: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentPermanentAddress" id="studentPermanentAddress" value="<?php echo $res['PermanentAddress'];?>" placeholder="enter address" required />
									<script>
										var f4 = new LiveValidation('studentPermanentAddress');
										f4.add( Validate.Length, { maximum: 100 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>City: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentPermanentCity" id="studentPermanentCity" value="<?php echo $res['PermanentCity'];?>" placeholder="enter city" required />
									<script>
										var f4 = new LiveValidation('studentPermanentCity');
										f4.add( Validate.Length, { maximum: 25 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Temporary Address: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentTempAddress" id="studentTempAddress" value="<?php echo $res['TempAddress'];?>" placeholder="enter address" required />
									<script>
										var f4 = new LiveValidation('studentTempAddress');
										f4.add( Validate.Length, { maximum: 100 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>City <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentTempCity" id="studentTempCity" value="<?php echo $res['TempCity'];?>" placeholder="enter city" required />
									<script>
										var f4 = new LiveValidation('studentTempCity');
										f4.add( Validate.Length, { maximum: 25 } );
									</script>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<?php
				//echo $safeID;
					$r1=mysql_query("SELECT * FROM `parentinfo` WHERE ParentInfoID='$safeID'");//for fetching the parent records for editing
					//echo $r1;
					$res1=mysql_fetch_array($r1);
				?>
				<tr>
					<td colspan="2"><hr/>
						<h2 class="StepTitle" align="center">Parent Information Content</h2><hr/> <!-- Content of Second Section-->
					<td>
				</tr>
				<tr>
					<td width="50%">
						<table>
							<tr>
								<td>
									<label>Mobile No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentParentMobileNumber" id="studentParentMobileNumber" value="<?php echo $res1['MobileNumber'];?>" placeholder="03335367078" pattern="[0-0]{1}[3-3]{1}[0-9]{9}" required />
								</td>
							</tr>
							<tr>
								<td>
									<label>Office No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentParentOfficeNumber" id="studentParentOfficeNumber" value="<?php echo $res1['OfficeNumber'];?>" placeholder="0519256898" pattern="\d{3}\d{7}" required />
								</td>
							</tr>
							<tr>
								<td>
									<label>Fax No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentParentFaxNumber" id="studentParentFaxNumber" value="<?php echo $res1['FaxNumber'];?>" placeholder="0514438978" pattern="\d{3}\d{7}" required />
								</td>
							</tr>
							<tr>
								<td>
									<label>Email: <font color="red">*</font></label>
								</td>
								<td>
									<input type="email" name="studentFatherEmail" id="studentFatherEmail" value="<?php echo $res1['EmailAddress'];?>" placeholder="something@mail.com" required />
								</td>
							</tr>
							<tr>
								<td>
									<label>Office Type: <font color="red">*</font></label>
								</td>
								<td>
									 <select name="studentParentOfficeType" id="studentParentOfficeType">
										<option selected><?php echo $res1['OrganizationType'];?></option>
										<option value="Government">Government</option>
										<option value="Private">Private</option>
									 </select>
								</td>
							</tr>
						</table>
					</td>
					<td width="50%">
						<table>
							<tr>
								<td>
									<label>Profession: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentFatherProfession" value="<?php echo $res1['Profession'];?>" id="studentFatherProfession" placeholder="teacher/acountant" required />
									<script>
										var f4 = new LiveValidation('studentFatherProfession');
										f4.add( Validate.Length, { maximum: 30 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Grade: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentFatherGrade" id="studentFatherGrade" value="<?php echo $res1['Grade'];?>" placeholder="enter grade" required />
									<script>
										var f4 = new LiveValidation('studentFatherGrade');
										f4.add( Validate.Length, { maximum: 10 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Income: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentFatherIncome" id="studentFatherIncome" value="<?php echo $res1['Income'];?>" placeholder="enter income" required />
									 <script>
										var f4 = new LiveValidation('studentFatherIncome');
										f4.add( Validate.Numericality, { onlyInteger: true } );
									 </script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Office Address: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentFatherOfficeAddress" id="studentFatherOfficeAddress" value="<?php echo $res1['OrganizationAddress'];?>"  placeholder="enter office address" required />
									<script>
										var f4 = new LiveValidation('studentFatherOfficeAddress');
										f4.add( Validate.Length, { maximum: 50 } );
									</script>
								</td>
							</tr>
						</table>	
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="Submit"/><hr/>
					</td>
				</tr>
			</table>
		</form>
    </div>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>
