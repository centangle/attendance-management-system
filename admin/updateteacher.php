<?php
	session_start();
	if (isset ($_SESSION['AdminID']))
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
	<?php include"adminheader.php"; ?> <!-- Side Bar Menu for Administrator -->
	<div>   
        <h1 class="h1Special">&nbsp;&nbsp;&nbsp;Updating Teacher Record</h1>
    </div>
						<?php
							if(is_numeric($_GET['ErrorID']))//getting message ids from action file
							$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
							switch($error){
								case 2://message 2 case
									echo'<script type="text/javascript">alert("Error: CNIC No Already Existed.");</script>';//showing the alert box to notify the message to the user
									break;
								case 3://message 3 case
									echo'<script type="text/javascript">alert("Error: Join Date must be greater than Date of Birth");</script>';//showing the alert box to notify the message to the user
									break;
								
							}
						?>
    <div> <!-- Form for Registering a new teacher -->
									<?php
											include_once("../common/commonfunctions.php"); //including Common function library
											include_once('../common/config.php');
											
											$unsafe=$_GET['id'];
											$safeID=clean($unsafe);//cleaning variable for prevention of sql injection
											
											$r=mysql_query("SELECT * FROM `teacher` WHERE TeacherID='$safeID'");
											$res=mysql_fetch_array($r);
									?>
	
		<form action="update_teacher_action.php?id=<?php echo $safeID;?>" method="POST" enctype="multipart/form-data"> <!-- Start of update teacher form -->
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
									<label>Name: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="teacherName" id="teacherName" value="<?php echo $res['Name'];?>" placeholder="enter name" required/>
								</td>
							</tr>
							<tr>
								<td>
									<label>Father Name: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="teacherFatherName" id="teacherFatherName" value="<?php echo $res['FatherName'];?>" placeholder="enter fathername" required />
								</td>
							</tr>
							<tr>
								<td>
									<label>CNIC No: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="teacherCNIC" id="teacherCNIC" value="<?php echo $res['CNICNo'];?>" placeholder="3520294594631" required/>
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
									<input type="text" name="teacherDOB" id="datepicker" value="<?php echo $res['DOB'];?>" placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" required/>
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
									<input type="text" name="teacherJoinDate" id="joindatepicker" value="<?php echo $res['JoinDate'];?>" placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d"  required/>
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
									<input type="text" name="teacherMobileNumber" id="teacherMobileNumber" value="<?php echo $res['MobileNumber'];?>" placeholder="03335647898" pattern="[0-0]{1}[3-3]{1}[0-9]{9}" required/>
									&nbsp;<span><font color="grey">Hint: 03335367987</font></span>
								</td>
							</tr>
						</table>
					</td>
					<td width="50%">
						<table>
							
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
									<input type="email" name="teacherEmail" id="teacherEmail" value="<?php echo $res['Email'];?>" placeholder="something@mail.com" required/>
									&nbsp;<span><font color="grey">Hint: abc@mail.com</font></span>
								</td>
							</tr>
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
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>