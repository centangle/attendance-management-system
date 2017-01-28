<?php
	session_start();
	include_once("common/commonfunctions.php"); //including Common function library

	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
	{
		redirect_to("student/index.php");//redirecting toward login page if session is not maintained
	}
	
	//if any message from other page is recieved
	//$msg=$_GET['msg'];
?>
<!DOCTYPE html><!-- Html5 supported page -->
<html lang="en">
    <head>
		<title>Student Login</title><!-- title of the page -->
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
				<h2>Login for Students</h2> <!-- User Types who can login through this form -->
			</header>
			
			<section class="main"> <!-- Main content area of the page -->
				<form class="form-3" method="POST" action="studentlogin_action.php"> <!-- login for for the students -->
				    <p class="clearfix">
				        <label for="login">Username:</label> <!--Username field -->
				        <input type="text" name="studentUsername" id="studentUsername" placeholder="Username" required/> <!-- student roll no -->
						<style>
							.LV_invalid 
							{
								color: rgb(0, 163, 204);
							}
						</style>
						<script>
								var f4 = new LiveValidation('studentUsername');
								f4.add( Validate.Length, { maximum: 35 } );
								f4.add( Validate.Length, { minimum: 3 } );
						</script>
				    </p>
				    <p class="clearfix">
				        <label for="password">Password:</label>
				        <input type="password" name="studentPassword" id="studentPassword" placeholder="Password" required/> 
				    </p>
					<br />
				    <p class="clearfix" align="center">
				        <input type="submit" name="submit" value="Sign in"><!--submit form button-->
				    </p> 
					<br/>
					<p style="color:red;text-align:center"><?php if(isset($_GET['msg'])) echo $msg=$_GET['msg'];?></p><!--for Mentioning Errors-->
					<!--<p class="clearfix" align="center">
						<a href="recoverpassword.php"><font color="grey"><u>Forget Password</u></font></a>
				    </p>-->
				</form>
			</section>
			
        </div>
    </body>
</html>