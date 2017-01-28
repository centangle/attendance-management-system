<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title> Update Coordinator Profile</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
</head>
<!--Start of Body Tag -->
<body>	
	<?php include"coordinatorheader.php"; ?> <!-- Side Bar Menu for coordinator -->
	<div>   
        <h1 class="h1Special">&nbsp;&nbsp;&nbsp;Updating Coordinator Profile</h1>
    </div>
    <div> <!-- Form for Registering a new coordinator -->
	
									<?php
											include_once("../common/commonfunctions.php"); //including Common function library
											include_once('../common/config.php');
											
											$unsafe=$_GET['id'];
											$safeID=clean($unsafe);//cleaning variable for prevention of sql injection
											
											$r=mysql_query("SELECT * FROM `coordinator` WHERE CoordinatorID='$safeID'");
											$res=mysql_fetch_array($r);
									?>
		<form action="update_coordinatorprofile_action.php?id=<?php echo $safeID;?>" method="POST" enctype="multipart/form-data"> <!-- Start of update coordinator profile form -->
			<table border="0" cellpadding="0" cellspacing="0"class="inlineSetting"> <!-- for alignment of the form -->
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
						<tr>
						<td >
						<label>Password: <font color="red">*</font> </label></td>
						<style>
							.LV_invalid 
							{
								color: red;
							}
						</style>
						<td>
							<input type="text" name="coordinatorPassword" id="coordinatorPassword" value="<?php echo $res['Password'];  ?>" placeholder="enter password" required/>
									<script>
										var f4 = new LiveValidation('coordinatorPassword');
										f4.add( Validate.Length, { minimum: 5, maximum: 30 } );
									</script>
						</td>
						</tr>
							<tr>
								<td >
									<label>Mobile No: <font color="red">*</font></label>
								</td>
								<td >
									<input type="text" name="coordinatorMobileNumber" id="coordinatorMobileNumber" placeholder="0333 5397089" value="<?php echo $res['MobileNumber'];  ?>"  pattern="[0-0]{1}[3-3]{1}[0-9]{9}" required/>
									&nbsp;<span><font color="grey">Hint: 03335367987</font></span>
								</td>
							</tr>
							<tr>
							<td >
								<label>Phone No: <font color="red">*</font></label>
							</td>
							<td >
								<input type="text" name="coordinatorPhoneNumber" id="coordinatorPhoneNumber"  placeholder="051 4438567" value="<?php echo $res['PhoneNumber'];  ?>" pattern="\d{3}\d{7}" required/>
								&nbsp;<span><font color="grey">Hint: 0514438064</font></span>
							</td>
						</tr>
						<tr>
							<td >
								<label>Email: <font color="red">*</font></label>
							</td>
							<td >
								<input type="email" name="coordinatorEmail" id="coordinatorEmail" placeholder="something@mail.com" value="<?php echo $res['Email'];  ?>" required />
								&nbsp;<span><font color="grey">Hint: abc@mail.com</font></span>
							</td>
						</tr>
						</table>
					</td>
					<td width="50%">
						<table>
						<tr>
							<td >
								<label>Permanent Address: <font color="red">*</font></label>
							</td>
							<style>
								.LV_invalid 
								{
									color: red;
								}
							</style>
							<td >
								<input type="text" name="coordinatorPermanentAddress" id="coordinatorPermanentAddress" placeholder="enter address" value="<?php echo $res['PermanentAddress'];  ?>" required />
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
								<input type="text" name="coordinatorPermanentCity" id="coordinatorPermanentCity" placeholder="enter city" value="<?php echo $res['PermanentCity'];  ?>" required />
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
								<input type="text" name="coordinatorTempAddress" id="coordinatorTempAddress" placeholder="enter address" value="<?php echo $res['TempAddress'];  ?>" required />
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
								<input type="text" name="coordinatorTempCity" id="coordinatorTempCity" placeholder="enter city" value="<?php echo $res['TempCity'];  ?>" required />
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
						<input type="submit" value="Submit"/><hr/>
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