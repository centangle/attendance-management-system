<?php
	session_start();
	if (isset ($_SESSION['AdminID']))
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title> Update Attendant</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
</head>
<!--Start of Body Tag -->
<body>	
	<?php include"adminheader.php"; ?> <!-- Side Bar Menu for Administrator -->
	<div>   
        <h1 class="h1Special">&nbsp;&nbsp;&nbsp;Updating Attendant Record</h1>
    </div>
						<?php
							if(is_numeric($_GET['ErrorID']))//getting message ids from action file
							$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
							switch($error){
								case 1://message 1 case
									echo'<script type="text/javascript">alert("Error: Room is already alloted.");</script>';//showing the alert box to notify the message to the user
									break;
								case 2://message 2 case
									echo'<script type="text/javascript">alert("Error: CNIC No Already Existed.");</script>';//showing the alert box to notify the message to the user
									break;
								case 3://message 3 case
									echo'<script type="text/javascript">alert("Error: Join Date must be greater than Date of Birth.");</script>';//showing the alert box to notify the message to the user
									break;
								case 4://message 4 case
									echo'<script type="text/javascript">alert("Error: Mobile Number Already Existed.");</script>';//showing the alert box to notify the message to the user
									break;
								case 5://message 5 case
									echo'<script type="text/javascript">alert("Error: Phone Number Already Existed.");</script>';//showing the alert box to notify the message to the user
									break;
								case 6://message 6 case
									echo'<script type="text/javascript">alert("Error: Email Already Existed.");</script>';//showing the alert box to notify the message to the user
									break;
								case 7://message 7 case
									echo'<script type="text/javascript">alert("Error: Minimum Age should be 22.");</script>';//showing the alert box to notify the message to the user
									break;
								case 8://message 8 case
									echo'<script type="text/javascript">alert("Error: Join Date Must be less than Current Date.");</script>';//showing the alert box to notify the message to the user
									break;
							}
						?>
    <div> <!-- Form Wizard for updating attendant -->
	
									<?php
											include_once("../common/commonfunctions.php"); //including Common function library
											include_once('../common/config.php');
											
											$unsafe=$_GET['id'];
											$safeID=clean($unsafe);//cleaning variable for prevention of sql injection
											
											$r=mysql_query("SELECT * FROM `attendent` WHERE AttendentID='$safeID'");
											$res=mysql_fetch_array($r);
									?>
			
			
		<form action="update_attendant_action.php?id=<?php echo $safeID;?>" method="POST"> <!-- Start of update attendant form -->
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
									<option selected><?php echo $res['RoomID'];?></option>
									<?php 
										include_once('../common/config.php'); //including DB Connection File
										$result = mysql_query("SELECT room.RoomID, room.RoomCode, room.Floor, block.Name FROM room JOIN block ON room.BlockID=block.BlockID"); // applying query to generate room numbers
										
										while($rows = mysql_fetch_array($result)) //will return the list of rooms from database
										{
										echo "<option value='$rows[RoomID]'>".$rows['RoomCode']."-".$rows['Name']."-"."Floor ".$rows['Floor']."</option>";
										}
									?>
								</select>
								</td>
							</tr>
							<tr>
								<td>
									<label>Password: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="attendantPassword" id="attendantPassword" placeholder="Enter password" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['APassword'])) {$unsafe=$_SESSION['APassword']; $safe=clean($unsafe); echo $safe; unset($_SESSION['APassword']);}} else echo $res['Password'];?>" required />
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
									<input type="text" name="attendantName" id="attendantName"  placeholder="Enter name" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['Name'])) {$unsafe=$_SESSION['Name']; $safe=clean($unsafe); echo $safe; unset($_SESSION['Name']);}} else echo $res['Name'];?>" pattern="[a-zA-Z][a-zA-Z ]+" required />
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
									<input type="text" name="attendantFatherName" id="attendantFatherName" placeholder="Enter fathername" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['FatherName'])) {$unsafe=$_SESSION['FatherName']; $safe=clean($unsafe); echo $safe; unset($_SESSION['FatherName']);}} else echo $res['FatherName'];?>" pattern="[a-zA-Z][a-zA-Z ]+" required />
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
									<input type="text" name="attendantCNIC" id="attendantCNIC" placeholder="3520294594631"  value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['CNIC'])) {$unsafe=$_SESSION['CNIC']; $safe=clean($unsafe); echo $safe; unset($_SESSION['CNIC']);}} else echo $res['CNICNo'];?>" required />
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
									<input type="text" name="attendantDOB" id="datepicker" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['DOB'])) {$unsafe=$_SESSION['DOB']; $safe=clean($unsafe); echo $safe; unset($_SESSION['DOB']);}} else echo $res['DOB'];?>" placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[/.](0[1-9]|[12][0-9]|3[01])[/.](19|20)\d\d$" required />
									&nbsp;<span><font color="grey">Hint: mm/dd/yyyy</font></span>
									<!--<script>
									  $(function() {
										$( "#datepicker" ).datepicker({ minDate:"-80Y", maxDate: "-19Y 8M"});
									  });-->
								</td>
							</tr>
							<tr>
								<td>
									<label>Join Date: <font color="red">*</font></label><!-- have to use the calendar widget here-->
								</td>
								<td>
									<input type="text" name="attendantJoinDate" id="joindatepicker" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['JoinDate'])) {$unsafe=$_SESSION['JoinDate']; $safe=clean($unsafe); echo $safe; unset($_SESSION['JoinDate']);}} else echo $res['JoinDate'];?>" placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[/.](0[1-9]|[12][0-9]|3[01])[/.](19|20)\d\d$" required />
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
									<input type="text" name="attendantMobileNumber" id="attendantMobileNumber" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['Mobile'])) {$unsafe=$_SESSION['Mobile']; $safe=clean($unsafe); echo $safe; unset($_SESSION['Mobile']);}} else echo $res['MobileNumber'];?>" placeholder="03335368987"  pattern="[0-0]{1}[3-3]{1}[0-9]{9}" required/>
									&nbsp;<span><font color="grey">Hint: 03335367987</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Phone No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="attendantPhoneNumber" id="attendantPhoneNumber" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['Phone'])) {$unsafe=$_SESSION['Phone']; $safe=clean($unsafe); echo $safe; unset($_SESSION['Phone']);}} else echo $res['PhoneNumber'];?>" placeholder="0514435968" pattern="[0-0]{1}[1-9]{2}[0-9]{7}" required/>
									&nbsp;<span><font color="grey">Hint: 0514438064</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Email: <font color="red">*</font></label>
								</td>
								<td>
									<input type="email" name="attendantEmail" id="attendantEmail" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['Email'])) {$unsafe=$_SESSION['Email']; $safe=clean($unsafe); echo $safe; unset($_SESSION['Email']);}} else echo $res['Email'];?>" placeholder="something@mail.com" required/>
									&nbsp;<span><font color="grey">Hint: abc@mail.com</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Permanent Address: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="attendantPermanentAddress" id="attendantPermanentAddress" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['PAddress'])) {$unsafe=$_SESSION['PAddress']; $safe=clean($unsafe); echo $safe; unset($_SESSION['PAddress']);}} else echo $res['PermanentAddress'];?>" placeholder="Enter address" required/>
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
									<input type="text" name="attendantPermanentCity" id="attendantPermanentCity" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['PCity'])) {$unsafe=$_SESSION['PCity']; $safe=clean($unsafe); echo $safe; unset($_SESSION['PCity']);}} else echo $res['PermanentCity'];?>" placeholder="Enter city" pattern="[a-zA-Z][a-zA-Z ]+" required />
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
									<input type="text" name="attendantTempAddress" id="attendantTempAddress" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['TAddress'])) {$unsafe=$_SESSION['TAddress']; $safe=clean($unsafe); echo $safe; unset($_SESSION['TAddress']);}} else echo $res['TempAddress'];?>" placeholder="Enter address" required />
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
									<input type="text" name="attendantTempCity" id="attendantTempCity" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['TCity'])) {$unsafe=$_SESSION['TCity']; $safe=clean($unsafe); echo $safe; unset($_SESSION['TCity']);}} else echo $res['TempCity'];?>" placeholder="Enter city" pattern="[a-zA-Z][a-zA-Z ]+" required />
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
						<input type="submit" value="Update"/><hr/>
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