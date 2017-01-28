<?php
	session_start();
	include_once("../common/commonfunctions.php"); //including Common function library
	if (isset ($_SESSION['StudentID']))//if session is already created than
    {
?>

<?php

	session_start();
	session_unset();//destroy the session
		redirect_to("logout.php");//redirect to logout and session is not set this time

?>
<?php
	}
    else
    {
    	redirect_to("../studentlogin.php?msg=Logout Succesfully");//session is not set now it will redirect to login page
    }
	?>