<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->
<!DOCTYPE html> <!--html5 supported page -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title> Register Coordinator</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
	<script LANGUAGE="JavaScript">
	function validate()
	{
		var extensions = new Array();//creating an empty array
		extensions[0] = "jpeg";//filling array with extension
		extensions[1] = "png";
		var image_file = document.form.coordinatorImage.value;//getting the value of the image
		var image_length = document.form.coordinatorImage.value.length;//getting the name length
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
        <h1 class="h1Special">&nbsp;&nbsp;Register New Coordinator</h1>
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
									echo'<script type="text/javascript">alert("Error: Error: Invalid Extension or Size.");</script>';//showing the alert box to notify the message to the user
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
    <div> <!-- Form for Registering a new coordinator -->
		<form action="register_coordinator_action.php" name="form" method="POST" enctype="multipart/form-data" onSubmit="return validate();"> <!-- Start of Register coordinator form -->
			<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting"> <!-- for alignment of the form -->
				<tr>
					<td colspan="2"> 
						<hr/>	
						<h2 class="StepTitle" class="h2Special" align="center">Basic Information Content</h2>
						<hr/>
					</td>
				</tr>
				<tr>
					<td width="50%">
						<table>
						<tr><td >
						<label>Discipline: <font color="red">*</font></label></td>
						<td >
							<select name="coordinatorAllotedDiscipline" id="coordinatorAllotedDiscipline">	<!-- Generate a list of departments from Database --> 
								<?php 
									include_once('../common/config.php'); //including DB Connection File
									include_once('../common/commonfunctions.php');
									
									$result = mysql_query("SELECT * FROM `departments`"); // applying query to generate list of diciplines
									while($rows = mysql_fetch_array($result)) //will return the list of rooms from database
									{
									echo "<option value='$rows[DepartmentID]'>".$rows['Name']."</option>";
									}
								?>
							</select>
						</td><tr>
						<td >
						<label>Username: <font color="red">*</font> </label></td>
						<td >
							<input type="email" name="coordinatorUsername" id="coordinatorUsername"  placeholder="Enter email" value="<?php if(is_numeric($_GET['ErrorID'])){ session_start(); if(isset($_SESSION['CUsername'])){ $unsafe=$_SESSION['CUsername']; $safe=clean($unsafe); echo $safe; unset($_SESSION['CUsername']);}}?>" required />
							&nbsp;<span><font color="grey">Hint: abc@mail.com</font></span>
						</td></tr>
						<tr>
						<td >
						<label>Password: <font color="red">*</font> </label></td>
						<td >
							<input type="text" name="coordinatorPassword" id="coordinatorPassword" placeholder="Enter password" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['CPassword'])) {$unsafe=$_SESSION['CPassword']; $safe=clean($unsafe); echo $safe; unset($_SESSION['CPassword']);}}?>" required />
							&nbsp;<span><font color="grey">Min Length: 5</font></span>
								<style>
									.LV_invalid 
									{
										color: red;
									}
								</style>
								<script>
									var f4 = new LiveValidation('coordinatorPassword');
									f4.add( Validate.Length, { minimum: 5, maximum: 30 } );
								</script>
						</td></tr>
						<tr>
						<td >
						<label>Name: <font color="red">*</font> </label></td>
						<td >
							<input type="text" name="coordinatorName" id="coordinatorName" placeholder="Enter name" pattern="[a-zA-Z][a-zA-Z ]+" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['CName'])) {$unsafe=$_SESSION['CName']; $safe=clean($unsafe); echo $safe; unset($_SESSION['CName']);}}?>" required />
							&nbsp;<span><font color="grey">Hint: XYZ ABC</font></span>
							<script>
								var f4 = new LiveValidation('coordinatorName');
								f4.add( Validate.Length, { maximum: 30 } );
							</script>
						</td>
						</tr>
						<tr>
							<td >
						<label>Father Name: <font color="red">*</font></label></td>
						<td >
							<input type="text" name="coordinatorFatherName" id="coordinatorFatherName" placeholder="Enter father name"  pattern="[a-zA-Z][a-zA-Z ]+" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['CFatherName'])) {$unsafe=$_SESSION['CFatherName']; $safe=clean($unsafe); echo $safe; unset($_SESSION['CFatherName']);}}?>"required />
							&nbsp;<span><font color="grey">Hint: XYZ ABC</font></span>
							<script>
								var f4 = new LiveValidation('coordinatorFatherName');
								f4.add( Validate.Length, { maximum: 30 } );
							</script>
						</td>
						</tr>
						<tr>
						<td >
						<label>CNIC No: <font color="red">*</font></label></td>
						<td >
							<input type="text" name="coordinatorCNIC" id="coordinatorCNIC" placeholder="3520294594631" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['CCNIC'])) {$unsafe=$_SESSION['CCNIC']; $safe=clean($unsafe); echo $safe; unset($_SESSION['CCNIC']);}}?>" required />
								&nbsp;<span><font color="grey">Hint: 3520294594631</font></span>
							<script>
								var f4 = new LiveValidation('coordinatorCNIC');
								f4.add( Validate.Numericality, { onlyInteger: true } );
								f4.add( Validate.Length, { minimum: 13, maximum: 13} );
							</script></td></tr>
							<tr>
						<td >
						<label>Birth Date: <font color="red">*</font> </label></td>
						<td >
							<input type="text" id="datepicker" name="coordinatorDOB" placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[/.](0[1-9]|[12][0-9]|3[01])[/.](19|20)\d\d$" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['CDOB'])) {$unsafe=$_SESSION['CDOB']; $safe=clean($unsafe); echo $safe; unset($_SESSION['CDOB']);}}?>" required />
							&nbsp;<span><font color="grey">Hint: mm/dd/yyyy</font></span>
							<!--<script>
							  $(function() {
								$( "#datepicker" ).datepicker({ minDate:"-80Y", maxDate: "-19Y 8M"});
							  });-->
							</script>
							</td>
							</tr>
							<tr>
						<td >
						<label>Image: <font color="red">*</font></label></td>
						<td >
							<input type="file" name="coordinatorImage" id="coordinatorImage" required />
								<span><font color="grey">Hint: (*.png|*.jpeg) MaxSize:100KB</font></span>
							</td>
						</tr>
						</table>
					</td>
					<td width="50%">
						<table>
						<tr>
							<td >
								<label class>Join Date: <font color="red">*</font></label><!-- have to use the calendar widget here-->
							</td>
							<td >
								<input type="text" name="coordinatorJoinDate" id="joindatepicker" placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[/.](0[1-9]|[12][0-9]|3[01])[/.](19|20)\d\d$" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['CJoinDate'])) {$unsafe=$_SESSION['CJoinDate']; $safe=clean($unsafe); echo $safe; unset($_SESSION['CJoinDate']);}}?>" required />
								&nbsp;<span><font color="grey">Hint: mm/dd/yyyy</font></span>
								<script>
								  $(function() {
									$( "#joindatepicker" ).datepicker({minDate:"-80Y", maxDate: "0D"});
								  });
								</script>
							</td>
						</tr>
						<tr>
							<td >
								<label>Mobile No: <font color="red">*</font></label>
							</td>
							<td >
								<input type="text" name="coordinatorMobileNumber" id="coordinatorMobileNumber" placeholder="Enter mobile number"  pattern="[0-0]{1}[3-3]{1}[0-9]{9}" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['CMobile'])) {$unsafe=$_SESSION['CMobile']; $safe=clean($unsafe); echo $safe; unset($_SESSION['CMobile']);}}?>" required />
								&nbsp;<span><font color="grey">Hint: 03335367987</font></span>
							</td>
						</tr>
						<tr>													 
							<td >
								<label>Phone No: <font color="red">*</font></label>
							</td>
							<td >
								<input type="text" name="coordinatorPhoneNumber" id="coordinatorPhoneNumber"  placeholder="Enter phone number" pattern="[0-0]{1}[1-9]{2}[0-9]{7}" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['CPhone'])) {$unsafe=$_SESSION['CPhone']; $safe=clean($unsafe); echo $safe; unset($_SESSION['CPhone']);}}?>" required />
								&nbsp;<span><font color="grey">Hint: 0514438064</font></span>
							</td>
						</tr>
						<tr>
							<td >
								<label>Email: <font color="red">*</font></label>
							</td>
							<td >
								<input type="email" name="coordinatorEmail" id="coordinatorEmail" placeholder="Enter email" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['CEmail'])) {$unsafe=$_SESSION['CEmail']; $safe=clean($unsafe); echo $safe; unset($_SESSION['CEmail']);}}?>" required />
								&nbsp;<span><font color="grey">Hint: abc@mail.com</font></span>
							</td>
						</tr>
						<tr>
							<td >
								<label>Permanent Address: <font color="red">*</font></label>
							</td>
							<td >
								<input type="text" name="coordinatorPermanentAddress" id="coordinatorPermanentAddress" placeholder="Enter address" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['CPAddress'])) {$unsafe=$_SESSION['CPAddress']; $safe=clean($unsafe); echo $safe; unset($_SESSION['CPAddress']);}}?>" required />
								<script>
										var f4 = new LiveValidation('coordinatorPermanentAddress');
										f4.add( Validate.Length, { maximum: 100 } );
									</script>
							</td>
						</tr>
						<tr>
							<td >
								<label>City: <font color="red">*</font></label>
							</td>
							<td >
								<input type="text" name="coordinatorPermanentCity" id="coordinatorPermanentCity" placeholder="Enter city" pattern="[a-zA-Z][a-zA-Z ]+" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['CPCity'])) {$unsafe=$_SESSION['CPCity']; $safe=clean($unsafe); echo $safe; unset($_SESSION['CPCity']);}}?>" required />
								&nbsp;<span><font color="grey">Hint: Islamabad</font></span>
								<script>
										var f4 = new LiveValidation('coordinatorPermanentCity');
										f4.add( Validate.Length, { maximum: 25 } );
									</script>
							</td>
						</tr>
						<tr>
							<td >
								<label>Temporary Address: <font color="red">*</font></label>
							</td>
							<td >
								<input type="text" name="coordinatorTempAddress" id="coordinatorTempAddress" placeholder="Enter address" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['CTAddress'])) {$unsafe=$_SESSION['CTAddress']; $safe=clean($unsafe); echo $safe; unset($_SESSION['CTAddress']);}}?>" required />
								<script>
										var f4 = new LiveValidation('coordinatorTempAddress');
										f4.add( Validate.Length, { maximum: 100 } );
								</script>
							</td>
						</tr>
						<tr>
							<td >
								<label>City <font color="red">*</font></label>
							</td>
							<td >
								<input type="text" name="coordinatorTempCity" id="coordinatorTempCity" placeholder="Enter city" pattern="[a-zA-Z][a-zA-Z ]+" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['CTCity'])) {$unsafe=$_SESSION['CTCity']; $safe=clean($unsafe); echo $safe; unset($_SESSION['CTCity']);}}?>" required />
								&nbsp;<span><font color="grey">Hint: Islamabad</font></span>
								<script>
										var f4 = new LiveValidation('coordinatorTempCity');
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
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>