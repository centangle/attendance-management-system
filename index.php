
<!DOCTYPE html>
<html lang="en">
    <head>
		<title>MSIS Main Page</title>
        <link rel="stylesheet" type="text/css" href="css/loginstyle.css" />
		<style>
				
		.myButton {
			
			-moz-box-shadow:inset 0px 1px 0px 0px #dcecfb;
			-webkit-box-shadow:inset 0px 1px 0px 0px #dcecfb;
			box-shadow:inset 0px 1px 0px 0px #dcecfb;
			
			background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #bddbfa), color-stop(1, #80b5ea));
			background:-moz-linear-gradient(top, #bddbfa 5%, #80b5ea 100%);
			background:-webkit-linear-gradient(top, #bddbfa 5%, #80b5ea 100%);
			background:-o-linear-gradient(top, #bddbfa 5%, #80b5ea 100%);
			background:-ms-linear-gradient(top, #bddbfa 5%, #80b5ea 100%);
			background:linear-gradient(to bottom, #bddbfa 5%, #80b5ea 100%);
			filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#bddbfa', endColorstr='#80b5ea',GradientType=0);
			
			background-color:#bddbfa;
			
			-moz-border-radius:6px;
			-webkit-border-radius:6px;
			border-radius:6px;
			
			border:1px solid #84bbf3;
			
			display:inline-block;
			color:#ffffff;
			font-family:arial;
			font-size:15px;
			font-weight:bold;
			padding:6px 24px;
			text-decoration:none;
			
			text-shadow:0px 1px 0px #528ecc;
			
		}
		.myButton:hover {
			
			background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #80b5ea), color-stop(1, #bddbfa));
			background:-moz-linear-gradient(top, #80b5ea 5%, #bddbfa 100%);
			background:-webkit-linear-gradient(top, #80b5ea 5%, #bddbfa 100%);
			background:-o-linear-gradient(top, #80b5ea 5%, #bddbfa 100%);
			background:-ms-linear-gradient(top, #80b5ea 5%, #bddbfa 100%);
			background:linear-gradient(to bottom, #80b5ea 5%, #bddbfa 100%);
			filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#80b5ea', endColorstr='#bddbfa',GradientType=0);
			
			background-color:#80b5ea;
		}
		.myButton:active {
			position:relative;
			top:1px;
		}
		
	</style>
	<link rel="shortcut icon" href="images/favicon.ico" /><!-- inserting the favicon for the site -->
	</head>
    <body>
        <div class="container">
			<br/><br/><br/>
			<br/>
			<header>
				<img src="images/black-logo-msis.png"> <!--Heading of the Page -->
				<br/><br/><br/>
				<img src="images/logoDetails.png"> <!--Heading of the Page -->
				<br/><br/>
				<br/><br/><br/>
				<br/><br/>
					<table border="0" style=" width: 600px; margin-left: auto; margin-right: auto;">
						<tr>
							<td colspan="4">
							</td>
						</tr>
						<tr>
							<td colspan>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<a href="studentlogin.php"><button type="button" class="myButton">Student Console</button></a>
									&nbsp;&nbsp;
								<a href="monitorlogin.php"><button type="button" class="myButton">Teacher Console</button></a>
									&nbsp;&nbsp;
							</td>
						</tr>
						
					</table>
							
			</header>
        </div>
    </body>
</html>