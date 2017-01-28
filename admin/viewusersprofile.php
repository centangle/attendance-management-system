<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!--html5 supported page -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title>Teacher Profile</title><!--Title of the Page-->
	<?php include"../common/library.php"; ?><!--Common Libraries which includes CSS and Javascript -->
</head>

<body>
	<?php include"adminheader.php"; ?><!--sidebar menu for the admin -->
	<table class="inlineSetting" cellpadding="0" cellspacing="0">
		<tr>
			<td>
							<?php 				
									include_once("../common/commonfunctions.php"); //including Common function library
									include_once("../common/config.php"); //including Common function library
									
									if(is_numeric($_GET['id']))
									$profileID=$_GET['id'];//unsafe variable
									$unSafeProfileType=$_GET['type'];
									
									$desID=clean($profileID);//cleaning id to preven SQL Injection
									$pType=clean($unSafeProfileType);
									$table=strtolower($pType);
													if($table=="admin")
														{
															$ser=mysql_query("SELECT * FROM `admin` WHERE AdminID='$desID'"); // applying query to generate diciplines name
															$rows = mysql_fetch_array($ser);//will return the username from database
															redirect_to("viewadminprofile.php");
														}
														else if ($table=="coordinator")
																{
																	$ser1=mysql_query("SELECT * FROM `coordinator` WHERE CoordinatorID='$desID'"); // applying query to generate diciplines name
																	$rows1 = mysql_fetch_array($ser1);//will return the username from database
																	redirect_to("viewcoordinatorprofile.php?id=$desID");
																}
																else if($table=="student")
																		{
																			$ser2=mysql_query("SELECT * FROM `student` WHERE StudentID='$desID'"); // applying query to generate diciplines name
																			$rows2 = mysql_fetch_array($ser2);//will return the username from database
																			redirect_to("viewstudentprofile.php?id=$desID");
																		}
																		else if($table=="attendant")
																		{
																			$ser2=mysql_query("SELECT * FROM `student` WHERE StudentID='$desID'"); // applying query to generate diciplines name
																			$rows2 = mysql_fetch_array($ser2);//will return the username from database
																			redirect_to("viewattendantprofile.php?id=$desID");
																		}
																		else{
																				$ser3=mysql_query("SELECT * FROM `teacher` WHERE TeacherID='$desID'"); // applying query to generate diciplines name
																				$rows3 = mysql_fetch_array($ser3);//will return the username from database
																				redirect_to("viewteacherprofile.php?id=$desID");
																			}
							?>
					
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
