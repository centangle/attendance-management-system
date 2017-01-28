<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!--page developed by Arslan Khalid -->
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
            <p>MSIS Teacher</p>
        </div>
        <div class="breadcrumbs_container">
            <article class="breadcrumbs"><a href="index.php">Teacher Panel</a>
                <div class="breadcrumb_divider"></div>
                <a class="current">Dashboard</a></article>
            <div class="btn_view_site"><a href="logout.php">logout</a></div>
        </div>
    </section>
    <!-- end of secondary bar -->
	
	<!-- start of side bar -->
    <aside id="sidebar" class="column">
        <a href="index.php"><h3>Dashboard</h3></a>
		<a href="mystudents.php"><h3>My Students</h3></a>
        <!--<a href="blanksheets.php"><h3>Blank Sheets</h3></a>-->
		
        <!--<h3>Queries</h3>
        <ul class="toggle">
            <li class="icn_settings"><a href="sendnotification.php">Send SMS</a></li>
			<li class="icn_settings"><a href="sendemail.php">Send Email</a></li>
			<li class="icn_settings"><a href="#">Forum</a></li>
        </ul>
     
		<hr />
        <h3>Courses</h3>
       
		<ul class="toggle">
            <li class="icn_photo"><a href="viewofferedcourses.php">View Offered Courses</a></li>
			<li class="icn_photo"><a href="viewallotedcourses.php">View Alloted Courses</a></li>
        </ul>
		-->
        <hr />
		 <h3>Lectures</h3>
        <ul class="toggle">
            <li class="icn_new_article"><a href="addattendance.php">Add Lecture</a></li>
   			<li class="icn_photo"><a href="attendanceoverview.php">View Lectures</a></li>
        </ul>
		<!--<hr />
		<h3>Tasks</h3>
        <ul class="toggle">
            <li class="icn_new_article"><a href="addtask.php">Add Task</a></li>
            <li class="icn_new_article"><a href="addtasksolution.php">Add Task Solution</a></li>
			<li class="icn_photo"><a href="viewtasks.php">View Task</a></li>
			<li class="icn_photo"><a href="marksreports.php">Task Marks Reports</a></li>
        </ul>
		<hr />
		<h3>Articles</h3>
        <ul class="toggle">
            <li class="icn_new_article"><a href="addarticle.php">Add Articles</a></li>
            <li class="icn_photo"><a href="viewarticle.php">View Articles</a></li>
        </ul>
		<hr />
		<h3>Timetable</h3>
        <ul class="toggle">
            <li class="icn_photo"><a href="viewtimetable.php">View TimeTable</a></li>
			<li class="icn_photo"><a href="viewsectiontimetable.php">View Section TimeTable</a></li>
			<li class="icn_photo"><a href="viewroomstatus.php">View Room Status</a></li>
        </ul>
		<hr />
		 <h3>Downloads</h3>
        <ul class="toggle">
			<li class="icn_folder"><a href="downloadmanual.php" target="_blank">User Manual</a></li>
			<li class="icn_folder"><a href="downloadapp.php" target="_blank">Mobile Application</a></li>
        </ul>-->
		<hr />
		<h3>Profile</h3>
        <ul class="toggle">
            <li class="icn_profile"><a href="teacherprofile.php">View Profile</a></li>
			<!--<li class="icn_folder"><a href="teacherfolder.php">Documents</a></li>-->
            <li class="icn_edit_article"><a href="logout.php">Logout</a></li>
        </ul>
		<hr />
        <!--		
        <h3>Marks</h3>
        <ul class="toggle">
            <li class="icn_new_article"><a href="#">Add Marks</a></li>
            <li class="icn_edit_article"><a href="#">Modify Marks</a></li>
			<li class="icn_jump_back"><a href="#">Change Marks Type</a></li>
        </ul>
		-->
        <footer>
            <hr />
            <p><strong>Copyright &copy; 2016 <a href="http://centangle.com" target="_blank">Centangle Interactive</a></strong></p>
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
