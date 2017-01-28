<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title> Update Teacher</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
</head>
<!--Start of Body Tag -->
<body>	
	<?php include"teacherheader.php"; ?> <!-- Side Bar Menu for Teacher -->
	<div>   
        <h1 class="h1Special">&nbsp;&nbsp;&nbsp;Updating Teacher Profile</h1>
    </div>
    <div> <!-- Form for Registering a new teacher -->
									<?php
											include_once("../common/commonfunctions.php"); //including Common function library
											include_once('../common/config.php');
											
											$unsafe=$_GET['id'];
											$safeID=clean($unsafe);//cleaning variable for prevention of sql injection
											
											$r=mysql_query("SELECT * FROM `teacher` WHERE TeacherID='$safeID'");
											$res=mysql_fetch_array($r);
									?>
	
		<form action="update_teacherprofile_action.php?id=<?php echo $safeID;?>" method="POST" enctype="multipart/form-data"> <!-- Start of update teacher form -->
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
								<style>
									.LV_invalid 
									{
										color: red;
									}
								</style>
								<td>
									<input type="text" name="teacherPassword" id="teacherPassword" value="<?php echo $res['Password'];?>" placeholder="enter password" required/>
									<script>
										var f4 = new LiveValidation('teacherPassword');
										f4.add( Validate.Length, { minimum: 5, maximum: 30 } );
									</script>
								</td>
							</tr>
							
							<tr>
								<td>
									<label>Mobile No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="teacherMobileNumber" id="teacherMobileNumber" value="<?php echo $res['MobileNumber'];?>" placeholder="03335647898" pattern="[0-0]{1}[3-3]{1}[0-9]{9}" required/>
									&nbsp;<span><font color="grey">Hint: 03335367987</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Phone No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="teacherPhoneNumber" id="teacherPhoneNumber"value="<?php echo $res['PhoneNumber'];?>" placeholder="0514489659" pattern="[0-0]{1}[1-9]{2}[0-9]{7}" required/>
									&nbsp;<span><font color="grey">Hint: 0514438064</font></span>
								</td>
							</tr>
							<tr>
								<td>
									<label>Email: <font color="red">*</font></label>
								</td>
								<td>
									<input type="email" name="teacherEmail" id="teacherEmail" value="<?php echo $res['Email'];?>" placeholder="abc@mail.com" required/>
									&nbsp;<span><font color="grey">Hint: abc@mail.com</font></span>
								</td>
							</tr>
						</table>
					</td>
					<td width="50%">
						<table>
							
							
							<tr>
								<td>
									<label>Permanent Address: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="teacherPermanentAddress" id="teacherPermanentAddress" value="<?php echo $res['PermanentAddress'];?>" placeholder="enter address" required/>
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
									<input type="text" name="teacherPermanentCity" id="teacherPermanentCity" value="<?php echo $res['PermanentCity'];?>" placeholder="enter city" required />
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
									<input type="text" name="teacherTempAddress" id="teacherTempAddress" value="<?php echo $res['TempAddress'];?>" placeholder="enter address" required />
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
									<input type="text" name="teacherTempCity" id="teacherTempCity" value="<?php echo $res['TempCity'];?>" placeholder="enter city" required />
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
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>