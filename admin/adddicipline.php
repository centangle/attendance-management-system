<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html> <!--html5 supported page -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title>Add Discipline</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
	
</head>
<!--Start of Body Tag -->
<body>	
	<?php include"adminheader.php"; ?> <!-- Side Bar Menu for Administrator -->
						<?php
							if(is_numeric($_GET['ErrorID']))//getting message ids from action file
							$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
							switch($error){
								case 1://message 1 case
									echo'<script type="text/javascript">alert("Error: Dicipline already Existed.");</script>';//showing the alert box to notify the message to the user
									break;
								case 5://message 5 case
									echo'<script type="text/javascript">alert("Success: Record Successfully Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
							}
						?>
	<div>   
        <h1 class="h1Special">&nbsp;&nbsp;&nbsp;Add New Discipline</h1>
    </div>
    <div> <!-- Form Wizard for Registering a new Dicipline -->
		<form action="add_dicipline_action.php" method="POST"> <!-- Start of Add new dicipline form -->
			<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting"> <!-- for alignment of the form -->
				<tr>
					<td colspan="2"> 
						<hr/>	
						<h2 class="StepTitle" align="center">Discipline Information</h2>
						<hr/>
					</td>
				</tr>
				<tr>
					<td width="50%">
						<table>
							<tr>
								<td>
									<label>Discipline Name: <font color="red">*</font></label> 
								</td>
								<style>
										.LV_invalid {
														color: red;
													}
								</style>
								<td>
									<input type="text" name="newDiciplineName" id="newDiciplineName" placeholder="enter dicipline name" pattern="[a-zA-Z][a-zA-Z ]+" required />
									&nbsp;<span><font color="grey">Hint: Bachelor in Geology</font></span>
									<script>
										var f12 = new LiveValidation('newDiciplineName');
										f12.add( Validate.Length, { maximum: 50 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Total Semesters: <font color="red">*</font></label> 
								</td>
								<td>
									<input type="text" name="newDiciplineSemester" id="newDiciplineSemester" placeholder="..8/10.." pattern="^[1-9][0-9]*$" required />
									&nbsp;<span><font color="grey">Hint: 8</font></span>
									<script>
										var f4 = new LiveValidation('newDiciplineSemester');
										f4.add( Validate.Numericality, { onlyInteger: true } );
										f4.add( Validate.Length, { maximum: 2 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Discipline Code: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="newDiciplineCode" id="newDiciplineCode" placeholder="enter code" pattern="^[a-zA-Z]+$" required />
									&nbsp;<span><font color="grey">Hint: BCS|BBA</font></span>
									<script>
										var f12 = new LiveValidation('newDiciplineCode');
										f12.add( Validate.Length, { maximum: 7 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Graduation Level: <font color="red">*</font></label>
								</td>
								<td>
									<select name="newGraduationLevel" id="newGraduationLevel">
									<?php 
										include_once('../common/config.php'); //including DB Connection File
										$result = mysql_query("SELECT * FROM `graduationlevel`"); // applying query to generate room numbers
										while($rows = mysql_fetch_array($result)) //will return the list of rooms from database
										{
										echo "<option value='$rows[GraduationLevelID]'>".$rows['GraduationLevelName']."</option>";
										}
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td>
									<label>Department: <font color="red">*</font></label>
								</td>
								<td>
									<select name="newDepartment" id="newDepartment">
									<?php 
										include_once('../common/config.php'); //including DB Connection File
										$result1 = mysql_query("SELECT * FROM `departments`"); // applying query to generate room numbers
										while($rows1 = mysql_fetch_array($result1)) //will return the list of rooms from database
										{
										echo "<option value='$rows1[DepartmentID]'>".$rows1['Name']."</option>";
										}
									?>
									</select>
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