<!-- Developed By Arslan Khalid -->
<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
{
?>

 <!-- start of header bar -->
    <header id="header">
        <hgroup>
            <h1 class="site_title"><a href="index.php"><img src="../images/logo-msis.png" width="180" height="45" alt="MSIS Logo" style="padding-top: 5px;"></a></h1>
            <h2 class="section_title">Mobile-based Student Information System</h2>
        </hgroup>
    </header>
    <!-- end of header bar -->
	
	<!-- Start of secondary bar -->
    <section id="secondary_bar">
        <div class="user">
            <p>MSIS Parent</p>
            <!-- <a class="logout_user" href="#" title="Logout">Logout</a> -->
        </div>
        <div class="breadcrumbs_container">
            <article class="breadcrumbs"><a href="index.php">Parent Panel</a>
                <div class="breadcrumb_divider"></div>
                <a class="current">Dashboard</a></article>
            <div class="btn_view_site"><a href="logout.php">logout</a></div>
        </div>
    </section>
    <!-- end of secondary bar -->
	
	<!-- start of side bar -->
    <aside id="sidebar" class="column">
        <a href="index.php"><h3>Dashboard</h3></a>
        <h3>Courses</h3>
        <ul class="toggle">
            <li class="icn_add_user"><a href="viewcourses.php">Summary</a></li>
            <li class="icn_view_users"><a href="viewlectures.php">Lectures</a></li>
			<li class="icn_profile"><a href="viewattendance.php">Attendance</a></li>
        </ul>
        <hr />
        <h3>Tasks</h3>
        <ul class="toggle">
            <li class="icn_security"><a href="viewassignments.php">Assignments</a></li>
            <li class="icn_jump_back"><a href="viewquizez.php">Quizez</a></li>
			<li class="icn_jump_back"><a href="viewsessional.php">Sessional I & II</a></li>
			<li class="icn_jump_back"><a href="viewfinal.php">Final</a></li>
        </ul>
        <hr />
        <h3>Result</h3>
        <ul class="toggle">
            <li class="icn_settings"><a href="viewresult.php">Result Card</a></li>
        </ul>
		<hr />
		<h3>TimeTable</h3>
        <ul class="toggle">
            <li class="icn_photo"><a href="viewtimetable.php">View TimeTable</a></li>
        </ul>
		<hr />
       <h3>Downloads</h3>
        <ul class="toggle">
			<li class="icn_folder"><a href="downloadmanual.php" target="_blank">User Manual</a></li>
			<li class="icn_folder"><a href="downloadapp.php" target="_blank">Mobile Application</a></li>
        </ul>
		<hr />
       <h3>Profile</h3>
        <ul class="toggle">
            <li class="icn_profile"><a href="studentprofile.php">View Profile</a></li>
            <li class="icn_edit_article"><a href="logout.php">Logout</a></li>
        </ul>
		<hr/>
        <footer>
            <hr />
            <p><strong>Copyright &copy; 2013 MSIS Systems</strong></p>
            <hr />
        </footer>
    </aside>
    <!-- end of sidebar -->
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../parentlogin.php?msg=Login First!"); //redirecting toward login page if session is not maintained
	}
?>