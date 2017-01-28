<?php
	session_start();
	include_once("common/commonfunctions.php"); //including Common function library

	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
	{
		redirect_to("parent/index.php");//redirecting toward login page if session is not maintained
	}
	
	//if any message from other page is recieved
	//$msg=$_GET['msg'];
?>
<!DOCTYPE html><!-- Html5 supported page -->
<html lang="en">
    <head>
		<title>Parent Login</title><!-- title of the page -->
        <link rel="stylesheet" type="text/css" href="css/loginstyle.css" /><!--login page style Sheets-->
		<script src="js/login/modernizr.custom.63321.js"></script><!-- login page scripting -->
		<script src="js/livevalidation_standalone.js"></script>
		<!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
		<link rel="shortcut icon" href="images/favicon.ico" /><!-- inserting the favicon for the site -->
    </head>
    <body>
        <div class="container"><!-- main content area-->
			<header>
				<h1><strong>MSIS</strong> Login</h1> <!--Heading of the Page -->
				<h2>Login for Parents</h2> <!-- User Types who can login through this form -->
			</header>
			
			<section class="main"> <!-- Main content area of the page -->
				<form class="form-3" method="POST" action="parentlogin_action.php"> <!-- login for for the students -->
				    <p class="clearfix">
				        <label for="login">Username</label> <!--Username field -->
						<select name="studentSession" id="studentSession"> <!-- generating list of sessions from database -->
							<?php 
									include_once('common/config.php'); //including DB Connection File
									$result = mysql_query("SELECT * FROM `session`"); // applying query to generate list of diciplines
									while($rows = mysql_fetch_array($result)) //will return the list of Sessions from database
									{
										
									echo "<option value='$rows[Code]'>".$rows['Code']."</option>";
									}
							?>
						</select>&nbsp;&nbsp;&nbsp;
						<select name="studentDicipline" id="studentDiscipline"> <!-- generating list of dicipline from database -->
							<?php 
									include_once('common/config.php'); //including DB Connection File
									$rs = mysql_query("SELECT * FROM `discipline`"); // applying query to generate list of diciplines
									while($row = mysql_fetch_array($rs)) //will return the list of rooms from database
									{
										
									echo "<option value='$row[DisciplineCode]'>".$row['DisciplineCode']."</option>";
									}
								?>
						</select>&nbsp;
				        <input type="text" name="studentRollNo" id="studentRollNo" width="30" required/> <!-- student roll no -->
						<style>
							.LV_invalid 
							{
								color: rgb(0, 163, 204);
							}
						</style>
						<script>
								var f4 = new LiveValidation('studentRollNo');
								f4.add( Validate.Numericality, { onlyInteger: true } );
								f4.add( Validate.Length, { maximum: 3 } );
								f4.add( Validate.Length, { minimum: 3 } );
						</script>
				    </p>
				    <p class="clearfix">
				        <label for="password">Password</label><!--password field -->
				        <input type="password" name="studentPassword" id="studentPassword" placeholder="Password" required/> 
				    </p>
					<br />
				    <p class="clearfix" align="center">
				        <input type="submit" name="submit" value="Sign in"><!--submit form button-->
				    </p> 
					<br/>
					<p style="color:red;text-align:center"><?php if(isset($_GET['msg'])) echo $msg=$_GET['msg'];?></p><!--for Mentioning Errors-->
					<p class="clearfix" align="center">
						<a href="recoverpasswordparent.php"><font color="grey"><u>Forget Password</u></font></a><!--submit form button-->
				    </p>
				</form>
			</section>
			
        </div>
    </body>
</html>