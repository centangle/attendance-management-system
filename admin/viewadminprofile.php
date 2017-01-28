<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!--html5 supported page -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title> Admin Profile</title><!--Title of the Page-->
	<?php include"../common/library.php"; ?><!--Common Libraries which includes CSS and Javascript -->
</head>

<body>
	<?php include"adminheader.php"; ?><!--sidebar menu for the administrator -->
	<table class="inlineSetting" cellpadding="0" cellspacing="0">
		<tr>
			<td>
							<?php 				
									include_once("../common/commonfunctions.php"); //including Common function library
									include_once("../common/config.php"); //including Common function library
									
									$profileID=$_SESSION['AdminID'];//unsafe variable
									$id=clean($profileID);//cleaning id to preven SQL Injection
									$res = mysql_query("SELECT * FROM `admin` WHERE `AdminID` ='$id'");
									$row = mysql_fetch_array($res);
							?>
					<fieldset>
						<legend><h2>Administrator Profile:</h2></legend>
							<table cellpadding="10px" width="300" border="0">
									<tr>
										<td style="font-weight:bold; font-size:15px;">Name: </td>
										<td style="color:grey;"> <?php echo $row['Name'];?></td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:15px;">Username: </td>
										<td style="color:grey;"> <?php echo $row['Username'];?></td>
									</tr>
							</table>
							<p colspan="2" align="center"><a href="index.php"><input type="submit" value="Go Back"/></a> | <a href="index.php"><input type="submit" value="Dashboard"/></a></p>
					</fieldset>
			</td>
		</tr>
	</table>
</body>
</html>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../clogin.php?msg=Login First!");
		//include("clogin.php");
	}
?>
