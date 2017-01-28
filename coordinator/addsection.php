<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html> <!--html5 supported page -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title>Add Section</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
						<?php
							if(is_numeric($_GET['ErrorID']))//getting message ids from action file
							$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
							switch($error){
								case 1://message 1 case
									echo'<script type="text/javascript">alert("Error: Section already existed.");</script>';//showing the alert box to notify the message to the user
									break;
								case 5://message 5 case
									echo'<script type="text/javascript">alert("Success: Record Successfully Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
							}
						?>
</head>
<!--Start of Body Tag -->
<body>	
	<?php include"coordinatorheader.php"; ?> <!-- Side Bar Menu for Coordinator -->
	<div>   
        <h1 class="h1Special" >&nbsp;&nbsp;&nbsp;Add New Section</h1>
    </div>
    <div> <!-- Form Wizard for adding a new department -->
		<form action="addsection_action.php" method="POST"> <!-- Start of add new section form -->
			<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting"> <!-- for alignment of the form -->
				<tr>
					<td colspan="2"> 
						<hr/>	
						<h2 class="StepTitle" align="center">Section Information</h2><!--Main Heading -->
						<hr/>
					</td>
				</tr>
				<tr>
					<td width="50%">
						<table>
							<?php
								include_once('../common/config.php'); //including DB Connection File
								$coodinatorID=$_SESSION['CoordinatorID'];
								$result = mysql_query("SELECT * FROM `coordinator` WHERE CoordinatorID='$coodinatorID'"); // applying query to generate list of diciplines
								$rows = mysql_fetch_array($result);//will return the list of record from database
									$getCoordinatorDiscipline=$rows['DepartmentID'];//setting the discipline ID in which coordinator can register students
							?>
							<tr>
								<td>
									<label>Discipline: <font color="red">*</font></label> 
								</td>
								<td>
									<select name="sectionDiscipline" id="sectionDiscipline">	<!-- Generate a list of Discipline from Database for Coordinator --> 
										<?php 
											$result = mysql_query("SELECT * FROM `discipline` WHERE DepartmentID='$getCoordinatorDiscipline'"); // applying query to generate list of diciplines
											while($rows = mysql_fetch_array($result)) //will return the list of disciplines from database
											{
											echo "<option value='$rows[DisciplineID]'>".$rows['DisciplineCode']."</option>";
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>
									<label>Section Name: <font color="red">*</font></label> <!--Section Name which will be added-->
								</td>
								<td>
									<input type="text" name="newSectionName" id="newSectionName" placeholder="enter section" pattern="^[a-zA-Z]+$" required />
									&nbsp;<span><font color="grey">Hint: A or B</font></span>
									<script>
										var f12 = new LiveValidation('newSectionName');
										f12.add( Validate.Length, { maximum: 1 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Semester: <font color="red">*</font></label>
								</td>
								<td>
									<select name="newSectionSemester" id="newSectionSemester"><!--Providing the list of semester-->
									<option value="1" selected>1st Semester</option>
									<option value="2">2nd Semester</option>
									<option value="3">3rd Semester</option>
									<option value="4">4th Semester</option>
									<option value="5">5th Semester</option>
									<option value="6">6th Semester</option>
									<option value="7">7th Semester</option>
									<option value="8">8th Semester</option>
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