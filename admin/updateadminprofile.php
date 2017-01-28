<?php
	session_start();
	if (isset ($_SESSION['AdminID']))
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Update Admin Profile</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
</head>
<!--Start of Body Tag -->
<body>	
	<?php include"adminheader.php"; ?> <!-- Side Bar Menu for Administrator -->
	<div>   
        <h1 class="h1Special">&nbsp;&nbsp;&nbsp;Updating Admin Profile</h1>
    </div>
    <div> <!-- Form for Registering a new coordinator -->
	
									<?php
											include_once("../common/commonfunctions.php"); //including Common function library
											include_once('../common/config.php');
											
											$unsafe=$_GET['id'];
											$safeID=clean($unsafe);//cleaning variable for prevention of sql injection
											
											$r=mysql_query("SELECT * FROM `Admin` WHERE AdminID='$safeID'");
											$res=mysql_fetch_array($r);
									?>
		<form action="update_adminprofile_action.php?id=<?php echo $safeID;?>" method="POST"> <!-- Start of update coordinator form -->
			<table border="0" cellpadding="0" cellspacing="0"class="inlineSetting"> <!-- for alignment of the form -->
				<tr>
					<td colspan="2"> 
						<hr/>	
						<h2 class="StepTitle" class="h2Special" align="center">Basic Information Content</h2>
						<hr/>
					</td>
				</tr>
				<tr>
					<td width="50%">
						<table>
						<tr>
							<td>
								<label>Name: <font color="red">*</font> </label>
							</td>
							<td>
								<input type="text" name="adminName" id="adminName" value="<?php echo $res['Name']; ?>" pattern="[a-zA-Z][a-zA-Z ]+" placeholder="Enter name" required />
								&nbsp;<span><font color="grey">Hint: Imtiaz Khalid</font></span>
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
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>