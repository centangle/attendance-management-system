					<?php
						$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
						
						?>
<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<title>Recover Password</title>
        <link rel="stylesheet" type="text/css" href="css/loginstyle.css" />
		<link rel="shortcut icon" href="images/favicon.ico" /><!-- inserting the favicon for the site -->
		<script src="js/login/modernizr.custom.63321.js"></script>
		<!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
    </head>
    <body>
        <div class="container">
			<header>
				<h1><strong>MSIS</strong> Recover Password</h1> <!--Heading of the Page -->
				<h2>Password Recovery for Students</h2> <!-- User Types who can login through this form -->
			</header>
			
			<section class="main"> <!--main panel of the page -->
				<form class="form-1" method="POST" action="recover_password_action.php">
					<p class="field"> <!--username field -->
						<input type="text" name="userRegisterationNumber" id="userRegisterationNumber" placeholder="Enter Registeration Number" required/>
						<i class="icon-user icon-large"></i> <!-- user logo -->
					</p>
					&nbsp;<span><font color="grey">Format: FA09-BCS-015 (All Capital)</font></span>
					<br/><br/>
					<p>
						<font color="red">
							<?php  if(is_numeric($error) && $error==1)
										echo "Error: Invalid Registeration Number!";
										if($error==2 && is_numeric($error))
											echo "Error: Empty fields are not allowed!";
												if($error==5 && is_numeric($error))
													echo "Success: Password has been emailed.";
							?>
					</p>
					<p class="submit">
						<button type="submit" name="submit"><i class="icon-arrow-right icon-large"></i></button> <!-- Submit Form Button -->
					</p>
					<p align="center">
						<a href="studentlogin.php"><input class="GoButton" type="button" value="GoBack"/></a>
					</p>
				</form>
			</section>
        </div>
    </body>
</html>