<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
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
            <p>MSIS Coordinator</p>
            <!-- <a class="logout_user" href="#" title="Logout">Logout</a> -->
        </div>
        <div class="breadcrumbs_container">
            <article class="breadcrumbs"><a href="index.php">Coordinator Panel</a>
                <div class="breadcrumb_divider"></div>
                <a class="current">Dashboard</a></article>
            <div class="btn_view_site"><a href="logout.php">logout</a></div>
        </div>
    </section>
    <!-- end of secondary bar -->
	
	<!-- start of side bar -->
    <aside id="sidebar" class="column">
        
        <a href="index.php"><h3>Dashboard</h3></a>
		<a href="classattendance.php"><h3>Class Attendance</h3></a>
		
		<h3>Courses</h3>
        <ul class="toggle">
            <li class="icn_edit_article"><a href="courseallotment.php">Course Allotment</a></li>
			<li class="icn_edit_article"><a href="viewallotedcourses.php">View Alloted Courses</a></li>
        </ul>
		<hr />
        <h3>Manage Courses</h3>
        <ul class="toggle">
			<li class="icn_new_article"><a href="dropcourses.php">Drop/Withdraw Courses</a></li>
        </ul>
		<hr />
        <h3>Notifications</h3>
        <ul class="toggle">
			<li class="icn_new_article"><a href="studentnotifications.php">Send Notification</a></li>
        </ul>
		<hr />
        <h3>Student</h3>
        <ul class="toggle">
            <li class="icn_edit_article"><a href="viewstudent.php">View Student</a></li>
			<li class="icn_new_article"><a href="registerstudent.php">Register Student</a></li>
        </ul>
		<hr />
        <h3>TimeTable</h3>
        <ul class="toggle">
            <li class="icn_new_article"><a href="addtimetable.php">Add TimeTable</a></li>
			<li class="icn_edit_article"><a href="viewtimetable.php">View TimeTable</a></li>
			<li class="icn_new_article"><a href="viewroomstatus.php">View Room Status</a></li>
        </ul>
		<hr />
        <h3>DB Operations</h3>
        <ul class="toggle">
            <li class="icn_new_article"><a href="addsection.php">Add Section</a></li>
			<li class="icn_new_article"><a href="criteria.php">Main Criteria</a></li>
        </ul>
        <hr />
        <h3>Downloads</h3>
        <ul class="toggle">
			<li class="icn_folder"><a href="downloadmanual.php" target="_blank">User Manual</a></li>
        </ul>
		<hr />
		<h3>Profile</h3>
        <ul class="toggle">
            <li class="icn_settings"><a href="coordinatorprofile.php">Profile</a></li>
            <li class="icn_jump_back"><a href="logout.php">Logout</a></li>
        </ul>
		<hr />
        <footer>
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
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>
