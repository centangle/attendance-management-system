<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html><!--html5 supported page -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title> Register Teacher</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
	<script LANGUAGE="JavaScript">
	function validate()
	{
		var extensions = new Array();//creating an empty array

		extensions[0] = "jpeg";//filling array with extension
		extensions[1] = "png";
		
		var image_file = document.form.teacherImage.value;//getting the value of the image
		var image_length = document.form.teacherImage.value.length;//getting the name length
		var pos = image_file.lastIndexOf('.') + 1;//setting the position 
		var ext = image_file.substring(pos, image_length);//extracting the image extension
		var final_ext = ext.toLowerCase();//converting to lower alphabets letters for comparison

		for (i = 0; i < extensions.length; i++)
		{
			if(extensions[i] == final_ext)//comparing the extensions
			{
			return true;
			}
		}
		 
		alert("You must upload an image file with one of the following extensions: "+ extensions.join(', ') +".");//returning the error message
		return false;
	}
	</script>
</head>
<!--Start of Body Tag -->
<body>	
	<?php include"adminheader.php"; ?> <!-- Side Bar Menu for Administrator -->
	<div>   
        <h1 class="h1Special">&nbsp;&nbsp;&nbsp;Register New Teacher</h1>
    </div>
						<?php
							if(is_numeric($_GET['ErrorID']))//getting message ids from action file
							$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
							switch($error){
								case 1://message 1 case
									echo'<script type="text/javascript">alert("Error: Username is already in Database. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
								case 2://message 2 case
									echo'<script type="text/javascript">alert("Error: CNIC is already in Database. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
								case 3://message 3 case
									echo'<script type="text/javascript">alert("Error: Join Date must be greater than Date of Birth");</script>';//showing the alert box to notify the message to the user
									break;
								case 4://message 4 case
									echo'<script type="text/javascript">alert("Error: Invalid Extension or Size.");</script>';//showing the alert box to notify the message to the user
									break;
								case 5://message 5 case
									echo'<script type="text/javascript">alert("Success: Record Successfully Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
								case 7://message 7 case
									echo'<script type="text/javascript">alert("Error: Mobile Number Already Existed. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
								case 8://message 8 case
									echo'<script type="text/javascript">alert("Error: Phone Number Already Existed. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
								case 9://message 9 case
									echo'<script type="text/javascript">alert("Error: Email Already Exited. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
								case 10://message 10 case
									echo'<script type="text/javascript">alert("Error: Minimum Age should be 22. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
								case 11://message 11 case
									echo'<script type="text/javascript">alert("Error: Join Date Must be less than Current Date. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
							}
						?>
    <div> <!-- Form for Registering a new teacher -->
		<form action="register_teacher_action.php" name="form" method="POST" enctype="multipart/form-data" onSubmit="return validate();"> <!-- Start of Register teacher form -->
			<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting"> <!-- for alignment of the form -->
				<tr>
					<td colspan="2"> 
						<hr/>
						<h2 class="StepTitle" align="center">Basic Information Content</h2>
						<hr/>
					</td>
				</tr>
				<tr>
					<td width="50%">
						<table>
							<tr>
								<td>
									<label>Department: <font color="red">*</font></label> 
								</td>
								<td>
									<select name="teacherAllotedDepartment" id="teacherAllotedDepartment">	<!-- Generate a list of departments from Database --> 
										<?php 
											include_once('../common/config.php'); //including DB Connection File
											include_once('../common/commonfunctions.php');
											
											$result = mysql_query("SELECT * FROM `departments`"); // applying query to generate list of departments
											while($rows = mysql_fetch_array($result)) //will return the list department name
											{
												
											echo "<option value='$rows[DepartmentID]'>".$rows['Name']."-(".$rows['Code'].")"."</option>";
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>
									<label>Username: <font color="red">*</font></label> 
								</td>
								<td>
									<input type="email" name="teacherUsername" id="teacherUsername" placeholder="Enter email" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['TUsername'])) {$unsafe=$_SESSION['TUsername']; $safe=clean($unsafe); echo $safe; unset($_SESSION['TUsername']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: abc@mail.com</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Password: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="teacherPassword" id="teacherPassword" placeholder="Enter password" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['TPassword'])) {$unsafe=$_SESSION['TPassword']; $safe=clean($unsafe); echo $safe; unset($_SESSION['TPassword']);}}?>" required />
									&nbsp;<span><font color="grey">Min Length: 5</font></span>
									<style>
										.LV_invalid 
										{
											color: red;
										}
									</style>
									<script>
										var f4 = new LiveValidation('teacherPassword');
										f4.add( Validate.Length, { minimum: 5, maximum: 30 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Name: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="teacherName" id="teacherName" placeholder="Enter name" pattern="[a-zA-Z][a-zA-Z ]+" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['TName'])) {$unsafe=$_SESSION['TName']; $safe=clean($unsafe); echo $safe; unset($_SESSION['TName']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: XYZ ABC</font></span>
									<script>
										var f4 = new LiveValidation('teacherName');
										f4.add( Validate.Length, { maximum: 30 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Father Name: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="teacherFatherName" id="teacherFatherName" placeholder="Enter fathername" pattern="[a-zA-Z][a-zA-Z ]+" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['TFatherName'])) {$unsafe=$_SESSION['TFatherName']; $safe=clean($unsafe); echo $safe; unset($_SESSION['TFatherName']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: XYZ ABC</font></span>
									<script>
										var f4 = new LiveValidation('teacherFatherName');
										f4.add( Validate.Length, { maximum: 30 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>CNIC No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="teacherCNIC" id="teacherCNIC" placeholder="3520294594631" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['TCNIC'])) {$unsafe=$_SESSION['TCNIC']; $safe=clean($unsafe); echo $safe; unset($_SESSION['TCNIC']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: 3520294594631</font></span>
									<script>
										var f4 = new LiveValidation('teacherCNIC');
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
									<input type="text" name="teacherDOB" id="datepicker" placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[/.](0[1-9]|[12][0-9]|3[01])[/.](19|20)\d\d$" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['TDOB'])) {$unsafe=$_SESSION['TDOB']; $safe=clean($unsafe); echo $safe; unset($_SESSION['TDOB']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: mm/dd/yyyy</font></span>
									<!--<script>
									  $(function() {
										$( "#datepicker" ).datepicker();
									  });
									</script>-->
								</td>
							</tr>
							<tr>
								<td>
									<label>Image: <font color="red">*</font></label>
								</td>
								<td>
									<input type="file" name = "teacherImage" id="teacherImage" required />
									<span><font color="grey">Hint: (*.png|*.jpeg) MaxSize:100KB</font></span>
								</td>
							</tr>
						</table>
					</td>
					<td width="50%">
						<table>
							<tr>
								<td>
									<label>Join Date: <font color="red">*</font></label><!-- have to use the calendar widget here-->
								</td>
								<td>
									<input type="text" name="teacherJoinDate" id="joindatepicker" placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[/.](0[1-9]|[12][0-9]|3[01])[/.](19|20)\d\d$" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['TJoinDate'])) {$unsafe=$_SESSION['TJoinDate']; $safe=clean($unsafe); echo $safe; unset($_SESSION['TJoinDate']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: mm/dd/yyyy</font></span>
									<script>
									  $(function() 
										{
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
									<input type="text" name="teacherMobileNumber" id="teacherMobileNumber"  placeholder="03335367073" pattern="[0-0]{1}[3-3]{1}[0-9]{9}" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['TMobile'])) {$unsafe=$_SESSION['TMobile']; $safe=clean($unsafe); echo $safe; unset($_SESSION['TMobile']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: 03335367987</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Phone No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="teacherPhoneNumber" id="teacherPhoneNumber"  placeholder="0514478963" pattern="[0-0]{1}[1-9]{2}[0-9]{7}" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['TPhone'])) {$unsafe=$_SESSION['TPhone']; $safe=clean($unsafe); echo $safe; unset($_SESSION['TPhone']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: 0514438064</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Email: <font color="red">*</font></label>
								</td>
								<td>
									<input type="email" name="teacherEmail" id="teacherEmail"  placeholder="Enter email" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['TEmail'])) {$unsafe=$_SESSION['TEmail']; $safe=clean($unsafe); echo $safe; unset($_SESSION['TEmail']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: abc@mail.com</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Permanent Address: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="teacherPermanentAddress" id="teacherPermanentAddress" placeholder="Enter address" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['TPAddress'])) {$unsafe=$_SESSION['TPAddress']; $safe=clean($unsafe); echo $safe; unset($_SESSION['TPAddress']);}}?>" required />
									<script>
										var f4 = new LiveValidation('teacherPermanentAddress');
										f4.add( Validate.Length, { maximum: 100 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>City: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="teacherPermanentCity" id="teacherPermanentCity" placeholder="Enter city" pattern="[a-zA-Z][a-zA-Z ]+" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['TPCity'])) {$unsafe=$_SESSION['TPCity']; $safe=clean($unsafe); echo $safe; unset($_SESSION['TPCity']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: Islamabad</font></span>
									<script>
										var f4 = new LiveValidation('teacherPermanentCity');
										f4.add( Validate.Length, { maximum: 25 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Temporary Address: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="teacherTempAddress" id="teacherTempAddress" placeholder="Enter address" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['TTAddress'])) {$unsafe=$_SESSION['TTAddress']; $safe=clean($unsafe); echo $safe; unset($_SESSION['TTAddress']);}}?>" required />
									<script>
										var f4 = new LiveValidation('teacherTempAddress');
										f4.add( Validate.Length, { maximum: 100 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>City: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="teacherTempCity" id="teacherTempCity" placeholder="Enter city" pattern="[a-zA-Z][a-zA-Z ]+" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['TTCity'])) {$unsafe=$_SESSION['TTCity']; $safe=clean($unsafe); echo $safe; unset($_SESSION['TTCity']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: Islamabad</font></span>
									<script>
										var f4 = new LiveValidation('teacherTempCity');
										f4.add( Validate.Length, { maximum: 25 } );
									</script>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="Submit"/> | <button type="reset">Reset</button><hr/>
					</td>
				</tr>
			</table>
		</form>
    </div>
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