<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html> <!--html5 supported page -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title> Register Attendant</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
	
	<script LANGUAGE="JavaScript">
	function validate()
	{
		var extensions = new Array();//creating an empty array

		extensions[0] = "jpeg";//filling array with extension
		extensions[1] = "png";
		
		var image_file = document.form.attendantImage.value;//getting the value of the image
		var image_length = document.form.attendantImage.value.length;//getting the name length
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
        <h1 class="h1Special">&nbsp;&nbsp;&nbsp;Register New Attendant</h1>
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
									echo'<script type="text/javascript">alert("Error: Join Date must be greater than Date of Birth. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
								case 4://message 4 case
									echo'<script type="text/javascript">alert("Error: Invalid Extension or Size. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
								case 5://message 5 case
									echo'<script type="text/javascript">alert("Success: Record Successfully Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
								case 6://message 6 case
									echo'<script type="text/javascript">alert("Error: Room already alloted. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
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
    <div> <!-- Form Wizard for Registering a new attendant -->
		<form action="register_attendant_action.php" name="form" method="POST" enctype="multipart/form-data" onSubmit="return validate();"> <!-- Start of Register attendant form -->
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
									<label>Room No:  <font color="red">*</font></label>
								</td>
								<td>
									<select name="attendantAllotedRoom" id="attendantAllotedRoom">	<!-- Generate a list of departments from Database --> 
									<?php 
										include_once('../common/config.php'); //including DB Connection File
										include_once('../common/commonfunctions.php');
										
										//$result = mysql_query("SELECT * FROM `room`"); // applying query to generate room numbers
										
										$result = mysql_query("SELECT room.RoomID, room.RoomCode, room.Floor, block.Name FROM room JOIN block ON room.BlockID=block.BlockID"); // applying query to generate room numbers
										
										while($rows = mysql_fetch_array($result)) //will return the list of rooms from database
										{
										echo "<option value='$rows[RoomID]'>".$rows['RoomCode']."-".$rows['Name']."-"."Floor".$rows['Floor']."</option>";
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
									<input type="email" name="attendantUsername" id="attendantUsername" placeholder="Enter email" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['AUsername'])) {$unsafe=$_SESSION['AUsername']; $safe=clean($unsafe); echo $safe; unset($_SESSION['AUsername']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: abc@mail.com</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Password: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="attendantPassword" id="attendantPassword" placeholder="Enter password" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['APassword'])) {$unsafe=$_SESSION['APassword']; $safe=clean($unsafe); echo $safe; unset($_SESSION['APassword']);}}?>" required />
									&nbsp;<span><font color="grey">Min Length: 5</font></span>
									<style>
										.LV_invalid 
										{
											color: red;
										}
									</style>
									<script>
										var f4 = new LiveValidation('attendantPassword');
										f4.add( Validate.Length, { minimum: 5, maximum: 30 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Name: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="attendantName" id="attendantName"  placeholder="Enter name" pattern="[a-zA-Z][a-zA-Z ]+" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['Name'])) {$unsafe=$_SESSION['Name']; $safe=clean($unsafe); echo $safe; unset($_SESSION['Name']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: XYZ ABC</font></span>
									<script>
										var f4 = new LiveValidation('attendantName');
										f4.add( Validate.Length, { maximum: 30 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Father Name: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="attendantFatherName" id="attendantFatherName" placeholder="Enter fathername" pattern="[a-zA-Z][a-zA-Z ]+" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['FatherName'])) {$unsafe=$_SESSION['FatherName']; $safe=clean($unsafe); echo $safe; unset($_SESSION['FatherName']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: XYZ ABC</font></span>
									<script>
										var f4 = new LiveValidation('attendantFatherName');
										f4.add( Validate.Length, { maximum: 30 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>CNIC No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="attendantCNIC" id="attendantCNIC" placeholder="3520294594631" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['CNIC'])) {$unsafe=$_SESSION['CNIC']; $safe=clean($unsafe); echo $safe; unset($_SESSION['CNIC']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: 3520294594631</font></span>
									<script>
										var f4 = new LiveValidation('attendantCNIC');
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
									<input type="text" name="attendantDOB" id="datepicker"  placeholder="mm/dd/yyyy" pattern="^(0[1-9]|1[012])[/.](0[1-9]|[12][0-9]|3[01])[/.](19|20)\d\d$" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['DOB'])) {$unsafe=$_SESSION['DOB']; $safe=clean($unsafe); echo $safe; unset($_SESSION['DOB']);}}?>" required />
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
									<input type="file" name="attendantImage" id="attendantImage" required />
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
									<input type="text" name="attendantJoinDate" id="joindatepicker"  placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[/.](0[1-9]|[12][0-9]|3[01])[/.](19|20)\d\d$" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['JoinDate'])) {$unsafe=$_SESSION['JoinDate']; $safe=clean($unsafe); echo $safe; unset($_SESSION['JoinDate']);}}?>" required />
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
									<input type="text" name="attendantMobileNumber" id="attendantMobileNumber" placeholder="03335368987"  pattern="[0-0]{1}[3-3]{1}[0-9]{9}" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['Mobile'])) {$unsafe=$_SESSION['Mobile']; $safe=clean($unsafe); echo $safe; unset($_SESSION['Mobile']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: 03335367987</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Phone No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="attendantPhoneNumber" id="attendantPhoneNumber" placeholder="0514435968" pattern="[0-0]{1}[1-9]{2}[0-9]{7}" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['Phone'])) {$unsafe=$_SESSION['Phone']; $safe=clean($unsafe); echo $safe; unset($_SESSION['Phone']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: 0514438064</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Email: <font color="red">*</font></label>
								</td>
								<td>
									<input type="email" name="attendantEmail" id="attendantEmail"  placeholder="something@mail.com" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['Email'])) {$unsafe=$_SESSION['Email']; $safe=clean($unsafe); echo $safe; unset($_SESSION['Email']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: abc@mail.com</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Permanent Address: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="attendantPermanentAddress" id="attendantPermanentAddress" placeholder="Enter address" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['PAddress'])) {$unsafe=$_SESSION['PAddress']; $safe=clean($unsafe); echo $safe; unset($_SESSION['PAddress']);}}?>" required />
									<script>
										var f4 = new LiveValidation('attendantPermanentAddress');
										f4.add( Validate.Length, { maximum: 100 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>City: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="attendantPermanentCity" id="attendantPermanentCity"  placeholder="Enter city" pattern="[a-zA-Z][a-zA-Z ]+" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['PCity'])) {$unsafe=$_SESSION['PCity']; $safe=clean($unsafe); echo $safe; unset($_SESSION['PCity']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: Islamabad</font></span>
									<script>
										var f4 = new LiveValidation('attendantPermanentCity');
										f4.add( Validate.Length, { maximum: 25 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Temporary Address: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="attendantTempAddress" id="attendantTempAddress"  placeholder="Enter address" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['TAddress'])) {$unsafe=$_SESSION['TAddress']; $safe=clean($unsafe); echo $safe; unset($_SESSION['TAddress']);}}?>" required />
									<script>
										var f4 = new LiveValidation('attendantTempAddress');
										f4.add( Validate.Length, { maximum: 100 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>City <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="attendantTempCity" id="attendantTempCity" placeholder="Enter city" pattern="[a-zA-Z][a-zA-Z ]+" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['TCity'])) {$unsafe=$_SESSION['TCity']; $safe=clean($unsafe); echo $safe; unset($_SESSION['TCity']);}}?>" required />
									&nbsp;<span><font color="grey">Hint: Islamabad</font></span>
									<script>
										var f4 = new LiveValidation('attendantTempCity');
										f4.add( Validate.Length, { maximum: 25 } );
									</script>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="Submit" height="30px"/> | <button type="reset">Reset</button><hr/>
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