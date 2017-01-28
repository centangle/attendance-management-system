<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	include_once("../common/sendfunctions.php"); //including the SMS API and Mail Code
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array('subject','allotedTeacher','section'));
	if(!$b)
	{
		redirect_to("courseallotment.php?ErrorID=1");//retuning the error message back to the login page
		exit();//then exit
	}
	
	$unsafe=$_POST['allotedTeacher'];//posting id of the alloted teacher
	$allotedTeacherID =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['subject'];//posting subject id
	$subjectID =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['section'];//posting section id
	$sectionID =clean($unsafe); //cleaning variable to prevent SQL injection
	
	//echo $allotedTeacherID."-------".$subjectID."----------".$sectionID;
	$sql=mysql_query("SELECT *FROM class WHERE SubjectID='$subjectID' AND SectionID='$sectionID'");
	$row=mysql_fetch_array($sql);
	
	$unsafe=$row['ClassID'];
	$classID=clean($unsafe);
	
	$result8=mysql_query("SELECT ClassID FROM `subjecttoteach` WHERE `ClassID`='$classID' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8); //executing the query
    if ($exist1 !==false ) {
		redirect_to("courseallotment.php?ErrorID=2");//if already exists than return with error code
       }
	   
	//----checking that 1 teacher can teach only one subject per section-----//
	$sql1=mysql_query("SELECT *FROM class WHERE ClassID='$classID'");
	$row1=mysql_fetch_array($sql1);
	$currentSectionID=$row1['SectionID'];
	
	$sql2=mysql_query("SELECT *FROM subjecttoteach WHERE TeacherID='$allotedTeacherID'");
	while($row2=mysql_fetch_array($sql2))
	{
		$cID=$row2['ClassID'];
		
		$sql2=mysql_query("SELECT *FROM class WHERE ClassID='$cID'");
		$row2=mysql_fetch_array($sql2);
		$prevSectionID=$row2['SectionID'];
		if($prevSectionID==$currentSectionID)
		{
			redirect_to("courseallotment.php?ErrorID=3");//if already exists than return with error code
		}
	}
	
	mysql_query("INSERT INTO `subjecttoteach`(`TeacherID`, `ClassID`) VALUES ('$allotedTeacherID','$classID')");//inserting record in the table
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['CoordinatorID'];
	$coordinatorID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Alloted a course to teacher.");//action which is performed
	$user=clean("Coordinator");//user type who performed the action
	
	writelog($user,$coordinatorID,$msg);//sending parameters to write log funtion which is in the common function library
	
	
	//------Getting SMS Attributes---------//
	$sql1=mysql_query("SELECT *FROM teacher WHERE TeacherID='$allotedTeacherID'");
	$row1=mysql_fetch_array($sql1);
	
	$teacherNumber=$row1['MobileNumber'];
	$teacherEmail=$row1['Email'];
	
	$sql2=mysql_query("SELECT *FROM subject WHERE SubjectID='$subjectID'");
	$row2=mysql_fetch_array($sql2);
	$subjectName=$row2['Name'];
	
	$message ="Sir/Madam: ".$subjectName." is alloted to you. Check Details on MSIS Teacher Portal.";
	$number=$teacherNumber;
	sendSMS($number,$message);//sending SMS on the Teacher Number about the course allotment
	
	
	//------------Getting Email Message Attributes------------//
	$toEmail=$teacherEmail;
	$subjectText= "New Course Alloted";
	$fromEmail="admin@msis.com";
	$msg="Sir/Madam: Subject:".$subjectName." is alloted to you. Check Detials on MSIS Teacher Portal.\n Timetable will be provided soon on Teacher's Portal.";
	sendEmail($toEmail,$subjectText,$msg,$fromEmail);
	
	redirect_to("courseallotment.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
