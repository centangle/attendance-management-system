<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title> Register Student</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
</head>
<!--Start of Body Tag -->
<body>	
	<?php include"coordinatorheader.php"; ?> <!-- Side Bar Menu for Administrator -->
	<div>   
        <h1 class="h1Special">&nbsp;&nbsp;&nbsp;Register New Student</h1>
    </div>
						<?php
							if(is_numeric($_GET['ErrorID']))//getting message ids from action file
							$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
							switch($error){
								case 1://message 1 case
									echo'<script type="text/javascript">alert("Error: Registeration No already assigned. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
								case 2://message 2 case
									echo'<script type="text/javascript">alert("Error: CNIC is already in Database. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
								case 3://message 3 case
									echo'<script type="text/javascript">alert("Error: Join Date must be greater than Date of Birth");</script>';//showing the alert box to notify the message to the user
									break;
								case 4://message 4 case
									echo'<script type="text/javascript">alert("Error: Error: Invalid Extension or Size.");</script>';//showing the alert box to notify the message to the user
									break;
								case 5://message 5 case
									echo'<script type="text/javascript">alert("Success: Record Successfully Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
							}
						?>
    <div> <!-- Form Wizard for Registering a new Student -->
		<form action="register_student_action.php" method="POST" enctype="multipart/form-data"> <!-- Start of Register Student form -->
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
						$getCoordinatorDiscipline=$rows['DepartmentID'];//setting the discipline ID in which coordinator can register students
				?>
				<tr>
					<td width="50%">
						<table>
							<tr>
								<td>
									<label>Session: <font color="red">*</font></label> 
								</td>
								<td>
									<select name="studentSession" id="studentSession">	<!-- Generate a list of Discipline from Database for Coordinator --> 
										<?php 
											$result = mysql_query("SELECT * FROM `session`"); // applying query to generate list of diciplines
											while($rows = mysql_fetch_array($result)) //will return the list of Sessions from database
											{
												
											echo "<option value='$rows[SessionID]'>".$rows['Code']."</option>";
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>
									<label>Discipline: <font color="red">*</font></label> 
								</td>
								<td>
									<select name="studentDiscipline" id="studentDiscipline">	<!-- Generate a list of Discipline from Database for Coordinator --> 
										<?php 
											$result = mysql_query("SELECT * FROM `discipline` WHERE DepartmentID='$getCoordinatorDiscipline'"); // applying query to generate list of diciplines
											while($rows = mysql_fetch_array($result)) //will return the list of disciplines from database
											{
											echo "<option value='$rows[DisciplineID]'>".$rows['DisciplineCode']."</option>";
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>
									<label>Roll No: <font color="red">*</font></label> 
								</td>
								<style>
									.LV_invalid 
									{
										color: red;
									}
								</style>
								<td>
									<input type="text" name="studentRollNo" id="studentRollNo" placeholder="015" required />
									&nbsp;<span><font color="grey">Hint: 015</font></span>
									<script>
										var f4 = new LiveValidation('studentRollNo');
										f4.add( Validate.Numericality, { onlyInteger: true } );
										f4.add( Validate.Length, { maximum: 3 } );
									</script>
								</td>
							</tr>
							
							<tr>
								<td>
									<label>Password: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentPassword" id="studentPassword" placeholder="enter password" required />
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
									<input type="text" name="studentName" id="studentName" placeholder="enter name" required />
								</td>
							</tr>
							<tr>
								<td>
									<label>Father Name: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentFatherName" id="studentFatherName" placeholder="enter fathername" required />
								</td>
							</tr>
							<tr>
								<td>
									<label>CNIC No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentCNIC" id="studentCNIC" placeholder="3520294594631" required />
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
									<input type="text" name="studentDOB" id="studentDOB" placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" required />
									&nbsp;<span><font color="grey">Hint: mm/dd/yyyy</font></span>
									<!--<script>
									  $(function() {
										$( "#studentDOB" ).datepicker();
									  });
									</script>-->
								</td>
							</tr>
							<tr>
								<td>
									<label>Image: <font color="red">*</font></label>
								</td>
								<td>
									<input type="file" name = "studentImage" id = "studentImage" required />
									<span><font color="grey">Hint: (*.png|*.jpeg) MaxSize:100KB</font></span>
								</td>
							</tr>
						</table>
					</td>
					<td width="50%">
						<table>
							<tr>
								<td>
									<label>Religon: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentReligon" id="studentReligon" placeholder="islam" required />
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
									<input type="text" name="studentJoinDate" id="studentJoinDate"  placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" required />
									&nbsp;<span><font color="grey">Hint: mm/dd/yyyy</font></span>
									<script>
									  $(function() {
										$( "#joindatepicker" ).datepicker({minDate:"-80Y", maxDate: "0D"});
									  });
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Mobile No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentMobileNumber" id="studentMobileNumber" pattern="[0-0]{1}[3-3]{1}[0-9]{9}" placeholder="03335367073" required />
									&nbsp;<span><font color="grey">Hint: 03335367987</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Phone No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentPhoneNumber" id="studentPhoneNumber" pattern="[0-0]{1}[1-9]{2}[0-9]{7}" placeholder="0514433996" required />
									&nbsp;<span><font color="grey">Hint: 0514438064</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Email: <font color="red">*</font></label>
								</td>
								<td>
									<input type="email" name="studentEmail" id="studentEmail" placeholder="abc@mail.com" required />
									&nbsp;<span><font color="grey">Hint: abc@mail.com</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Permanent Address: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentPermanentAddress" id="studentPermanentAddress" placeholder="enter address" required />
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
									<input type="text" name="studentPermanentCity" id="studentPermanentCity" placeholder="enter city" required />
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
									<input type="text" name="studentTempAddress" id="studentTempAddress" placeholder="enter address" required />
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
									<input type="text" name="studentTempCity" id="studentTempCity" placeholder="enter city" required />
									<script>
										var f4 = new LiveValidation('studentTempCity');
										f4.add( Validate.Length, { maximum: 25 } );
									</script>
								</td>
							</tr>
						</table>
					</td>
				</tr>
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
									<input type="text" name="studentParentMobileNumber" id="studentParentMobileNumber" placeholder="03335367078" pattern="[0-0]{1}[3-3]{1}[0-9]{9}" required />
									&nbsp;<span><font color="grey">Hint: 03335367987</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Office No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentParentOfficeNumber" id="studentParentOfficeNumber" placeholder="0519256898" pattern="[0-0]{1}[1-9]{2}[0-9]{7}" required />
									&nbsp;<span><font color="grey">Hint: 0514438064</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Fax No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="studentParentFaxNumber" id="studentParentFaxNumber" placeholder="0514438978" pattern="[0-0]{1}[1-9]{2}[0-9]{7}" required />
									&nbsp;<span><font color="grey">Hint: 0514438064</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Email: <font color="red">*</font></label>
								</td>
								<td>
									<input type="email" name="studentFatherEmail" id="studentFatherEmail" placeholder="abc@mail.com" required />
									&nbsp;<span><font color="grey">Hint: abc@mail.com</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Office Type: <font color="red">*</font></label>
								</td>
								<td>
									 <select name="studentParentOfficeType" id="studentParentOfficeType">
										<option selected value="Government">Government</option>
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
									<input type="text" name="studentFatherProfession" id="studentFatherProfession" placeholder="enter profession" required />
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
									<input type="text" name="studentFatherGrade" id="studentFatherGrade" placeholder="enter grade" required />
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
									<input type="text" name="studentFatherIncome" id="studentFatherIncome" placeholder="enter income" required />
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
									<input type="text" name="studentFatherOfficeAddress" id="studentFatherOfficeAddress" placeholder="enter office address" required />
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
