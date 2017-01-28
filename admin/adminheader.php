<?php
	session_start();
	if (isset ($_SESSION['AdminID']))
{
?>
<!-- Developed By: Arslan Khalid -->

<!-- start of header bar -->
    <header id="header">
        <hgroup>
             <h1 class="site_title"><a href="index.php"><img src="../images/logo-msis.png" width="180" height="45" alt="MSIS Logo" style="padding-top: 5px;"></a></h1>
            <h2 class="section_title">Mobile based Student Information System</h2><!--Name of the Project-->
        </hgroup>
    </header>
    <!-- end of header bar -->
	
	<!-- Start of secondary bar -->
    <section id="secondary_bar">
        <div class="user">
            <p>MSIS Administrator</p>
        </div>
        <div class="breadcrumbs_container">
            <article class="breadcrumbs"><a href="index.php">Admin Panel</a>
                <div class="breadcrumb_divider"></div>
                <a class="current">Dashboard</a></article>
            <div class="btn_view_site"><a href="logout.php">logout</a></div>
        </div>
    </section>
    <!-- end of secondary bar -->
	
	<!-- start of side bar -->
    <aside id="sidebar" class="column"> <!--Sidebar menu content  start here -->
        
        <a href="index.php"><h3>Dashboard</h3></a>
        <h3>Notification</h3>
        <ul class="toggle">
			<li class="icn_categories"><a href="sendnotification.php">Send SMS</a></li>
			<li class="icn_categories"><a href="sendemail.php">Send Email</a></li>
        </ul>
		<hr />
        <h3>Manage Users</h3>
        <ul class="toggle">
			<li><hr/></li>
			<li class="icn_view_users"><a href="viewcoordinator.php">View Coordinator</a></li>
            <li class="icn_add_user"><a href="registercoordinator.php">Register Coordinator</a></li>
			<li><hr/></li>
			<li class="icn_view_users"><a href="viewteacher.php">View Teacher</a></li>
            <li class="icn_add_user"><a href="registerteacher.php">Register Teacher</a></li>
			<li><hr/></li>
			<li class="icn_view_users"><a href="viewattendant.php">View Attendant</a></li>
            <li class="icn_add_user"><a href="registerattendant.php">Register Attendant</a></li>
			<li><hr/></li>
			<li class="icn_view_users"><a href="viewstudent.php">View Student</a></li>
        </ul>
        <hr />
        <h3>DB Operations</h3>
        <ul class="toggle">
			<li class="icn_new_article"><a href="criteria.php">Maintain Criteria</a></li>
            <li class="icn_new_article"><a href="adddepartment.php">Add Department</a></li>
            <li class="icn_new_article"><a href="addroom.php">Add Room</a></li>
            <li class="icn_new_article"><a href="adddicipline.php">Add Discipline</a></li>
            <li class="icn_new_article"><a href="addblock.php">Add Block</a></li>
			<li class="icn_new_article"><a href="addsession.php">Add Session</a></li>
        </ul>
        <hr />
        <h3>Downloads</h3>
        <ul class="toggle">
			<li class="icn_folder"><a href="downloadmanual.php" target="_blank">User Manual</a></li>
        </ul>
		<hr />
        <h3>Profile</h3>
        <ul class="toggle">
            <li class="icn_profile"><a href="adminprofile.php">Profile</a></li>
            <li class="icn_jump_back"><a href="logout.php">Logout</a></li>
        </ul>
		<hr />
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
		
		redirect_to("../clogin.php?msg=Login First!");
		//include("clogin.php");
	}
?>