<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	include_once("../common/sendfunctions.php"); //including the SMS API and Mail Code
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	
		$unsafe=$_GET['cID'];//getting subject id
		$subjectID=clean($unsafe);//cleaning subject id
		
		$unsafe=$_GET['tID'];//getting teacher id	
		$teacherID=clean($unsafe);//cleaning teacher id
	
		$unsafe=$_GET['scID'];//getting section id
		$sectionID=clean($unsafe);//cleaning subject id
		
		
		$unsafe=$_SESSION['StudentID'];//posting student id
		$studentID=clean($unsafe);//cleaning student id
		
		
	
	//checking if $post is not set or empty
	$b=checkPost($_POST, array('ans1','ans2','ans3','ans4','ans5','ans6','ans7','ans8','ans9','ans10','ans11','ans12','ans13','ans14'));
	if(!$b)
	{
		redirect_to("courseassesment.php?ErrorID=1&id=$subjectID&sID=$sectionID");//retuning the error message back to the login page
		exit();//then exit
	}
		
	$sql19=mysql_query("SELECT *FROM student WHERE StudentID='$studentID'");
	$row19=mysql_fetch_array($sql19);
		
		$studentSemester=$row19['Semester'];
		
	$ar=mysql_query("SELECT COUNT(*) as total FROM  `question`");//getting the Number of question from database
	$row=mysql_fetch_array($ar);
	$totalQuestions=$row['total'];
	
	$unsafe=$_POST['ans1']; //posting answer value
	$ans1 =clean($unsafe);
	
	$unsafe=$_POST['ans2']; //posting answer value
	$ans2 =clean($unsafe);
	
	$unsafe=$_POST['ans3']; //posting answer value
	$ans3 =clean($unsafe);
	
	$unsafe=$_POST['ans4']; //posting answer value
	$ans4 =clean($unsafe);
	
	$unsafe=$_POST['ans5']; //posting answer value
	$ans5 =clean($unsafe);
	
	$unsafe=$_POST['ans6']; //posting answer value
	$ans6 =clean($unsafe);
	
	$unsafe=$_POST['ans7']; //posting answer value
	$ans7 =clean($unsafe);
	
	$unsafe=$_POST['ans8']; //posting answer value
	$ans8 =clean($unsafe);
	
	$unsafe=$_POST['ans9']; //posting answer value
	$ans9 =clean($unsafe);
	
	$unsafe=$_POST['ans10']; //posting answer value
	$ans10 =clean($unsafe);
	
	$unsafe=$_POST['ans11']; //posting answer value
	$ans11 =clean($unsafe);
	
	$unsafe=$_POST['ans12']; //posting answer value
	$ans12 =clean($unsafe);
	
	$unsafe=$_POST['ans13']; //posting answer value
	$ans13 =clean($unsafe);
	
	$unsafe=$_POST['ans14']; //posting answer value
	$ans14 =clean($unsafe);
	
	$sumOfAns=($ans1+$ans2+$ans3+$ans4+$ans5+$ans6+$ans7+$ans8+$ans9+$ans10+$ans11+$ans12+$ans13+$ans14);
	
	$average=($sumOfAns/($totalQuestions*5))*100;//calculating average

	
	$sql3=("INSERT INTO `assesment`
				(`StudentID`, `SubjectID`, `SectionID`, `TeacherID`, `Semester`, `Average`) 
				VALUES ('$studentID','$subjectID','$sectionID','$teacherID','$studentSemester','$average')");//query for filling the assesment criteria
	
	mysql_query($sql3);

	$prevID=mysql_insert_id($link);// ($link=coonection parameter to be make sure it is showing right id)for getting the auto increament id which was assigned to this student in student table
	$savePrevID=clean($prevID);
	
	$sql2=("INSERT INTO `answer`(`AssesmentID`, `QuestionID`, `AnswerDetail`) 
					VALUES ('$savePrevID','1','$ans1'),
					('$savePrevID','2','$ans2'),
					('$savePrevID','3','$ans3'),
					('$savePrevID','4','$ans4'),
					('$savePrevID','5','$ans5'),
					('$savePrevID','6','$ans6'),
					('$savePrevID','7','$ans7'),
					('$savePrevID','8','$ans8'),
					('$savePrevID','9','$ans8'),
					('$savePrevID','10','$ans10'),
					('$savePrevID','11','$ans11'),
					('$savePrevID','12','$ans12'),
					('$savePrevID','13','$ans13'),
					('$savePrevID','14','$ans14')
		  ");
		 
	//echo $sql2;
	mysql_query($sql2);
	//exit();
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['StudentID'];
	$studentID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Filled an Assesment Form");//action which is performed
	$user=clean("Student");//user type who performed the action
	
	writelog($user,$studentID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("viewassesment.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../studentlogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
