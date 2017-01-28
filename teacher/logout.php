<?php
	session_start();
	function redirect_to($location) //Redirecct funtion take page name and redirect toward its
		{
			if (!headers_sent($file, $line))
			{
				header("Location: " . $location);//setting the location on give page
			} else {
				printf("<script>location.href='%s';</script>", urlencode($location));//performing URL encoding 
				# or deal with the problem
					}
			printf('<a href="%s">Moved</a>', urlencode($location));//moving towards the given location
			exit;
		}
	if (isset ($_SESSION['TeacherID']))//if session is already created than
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
    	redirect_to("../clogin.php?msg=Logout Succesfully");//session is not set now it will redirect to login page
    }
	?>