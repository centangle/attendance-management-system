<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html> <!--html5 supported page -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title>Add Department</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
</head>
<!--Start of Body Tag -->
<body>	
	<?php include"adminheader.php"; ?> <!-- Side Bar Menu for Administrator -->
						<?php
							if(is_numeric($_GET['ErrorID']))//getting message ids from action file
							$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
							switch($error){
								case 1://message 5 case
									echo'<script type="text/javascript">alert("Error: Department already existed.");</script>';//showing the alert box to notify the message to the user
									break;
								case 5://message 5 case
									echo'<script type="text/javascript">alert("Success: Record Successfully Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
							}
						?>
	<div>   
        <h1 class="h1Special" >&nbsp;&nbsp;&nbsp;Add New Department</h1>
    </div>
    <div> <!-- Form Wizard for adding a new department -->
		<form action="add_department_action.php" method="POST"> <!-- Start of add new department form -->
			<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting"> <!-- for alignment of the form -->
				<tr>
					<td colspan="2"> 
						<hr/>	
						<h2 class="StepTitle" align="center">Department Information</h2>
						<hr/>
					</td>
				</tr>
				<tr>
					<td width="50%">
						<table>
							<tr>
								<td>
									<label>Department Name: <font color="red">*</font></label> 
								</td>
								<td>
									<input type="text" name="newDaprtmentName" id="newDaprtmentName" placeholder="enter department name" pattern="[a-zA-Z][a-zA-Z ]+" required/>
									&nbsp;<span><font color="grey">Hint: Computer Science</font></span>
									<script>
										var f4 = new LiveValidation('newDaprtmentName');
										f4.add( Validate.Length, { maximum: 30 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Department Code: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="newDepartmentCode" id="newDepartmentCode" placeholder="enter department code" pattern="^[a-zA-Z]+$" required/>
									&nbsp;<span><font color="grey">Hint: CS</font></span>
									<script>
										var f4 = new LiveValidation('newDepartmentCode');
										f4.add( Validate.Length, { maximum: 10 } );
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