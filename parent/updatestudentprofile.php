<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title> Update Student Profile</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
</head>
<!--Start of Body Tag -->
<body>	
	<?php include"studentheader.php"; ?> <!-- Side Bar Menu for Administrator -->
	<div>   
        <h1 class="h1Special">&nbsp;&nbsp;&nbsp;Updating Student Profile</h1>
    </div>
    <div> <!-- Form Wizard for updating Student -->
									<?php
											include_once("../common/commonfunctions.php"); //including Common function library
											include_once('../common/config.php');
											
											$unsafe=$_GET['id'];
											$safeID=clean($unsafe);//cleaning variable for prevention of sql injection
											
											$r=mysql_query("SELECT * FROM `student` WHERE StudentID='$safeID'");
											$res=mysql_fetch_array($r);
									?>
	
		<form action="update_studentprofile_action.php?id=<?php echo $safeID;?>" method="POST"> <!-- Start of Update Student form -->
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
									<label>Password: <font color="red">*</font></label>
								</td>
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
									<input type="email" name="studentEmail" id="studentEmail" value="<?php echo $res['EmailAddress'];?>" placeholder="abc@mail.com" required />
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
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="Update" /><hr/>
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
		
		redirect_to("../parentlogin.php?msg=Login First!"); //redirecting toward login page if session is not maintained
	}
?>
