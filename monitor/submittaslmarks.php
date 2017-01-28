<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>

<?php
		include_once("../common/config.php");		// including common functions
		include_once("../common/commonfunctions.php"); //including Common function library
		include_once("../common/sendfunctions.php");
		
		$profileID=$_SESSION['TeacherID'];//unsafe variable
		$id=clean($profileID);//cleaning id to preven SQL Injection
		
		$studentMarks = json_decode($_GET["MarksVals"]);//decoding the present student Ids in an array
		
		$unsafe = $_GET['tID'];//postin id
		$taskID=clean($unsafe);//cleaning the ID for the Prevention of SQL Injection
		
		$unsafe = $_GET['sbID'];//postin id
		$subjectID=clean($unsafe);//cleaning the ID for the Prevention of SQL Injection
		
		$unsafe = $_GET['scID'];//postin id
		$sectionID=clean($unsafe);//cleaning the ID for the Prevention of SQL Injection
		
		$sql13=mysql_query("SELECT *FROM criteria WHERE Entity='LowMarks'");
		$row13=mysql_fetch_array($sql13);
		$lowMarks=$row13['Value'];
		
		$sql12=mysql_query("SELECT *FROM task WHERE TaskID='$taskID'");
		$row12=mysql_fetch_array($sql12);
		
		$totalMarks=$row12['TotalMarks'];
		$title=$row12['Title'];
		
		
		$sql=mysql_query("SELECT *FROM subjecttostudy WHERE SubjectID='$subjectID' AND SectionID='$sectionID'");//selecting the student id for marking the attendance
		$i=0;
		while($row=mysql_fetch_array($sql))//while fetching the list of records from database
		{
			$unsafe=$row['StudentID'];//posting the student id who attendance will be marked
			$studentID=clean($unsafe);//cleaning the variable for the prevention of SQL injection
			$marks=$studentMarks[$i];
			
			$average= ($marks/$totalMarks)*100;
			
			mysql_query("INSERT INTO `marks`(`TaskID`, `StudentID`, `ObtainedMarks`) VALUES ($taskID,'$studentID','$marks')");//inserting the marks of the student in a specific task
			
			$sql71=mysql_query("SELECT *FROM student WHERE StudentID='$studentID'");//selecting all student based on the section id and section id
			$row71=mysql_fetch_array($sql71);//while fetching the list of records
			
			$studentNumber=$row71['MobileNumber'];
			$name=$row71['Name'];
			
			$message="Mr/Ms:".$name." Marks Has Been Updated of ".$title." on MSIS.";
			sendSMS($studentNumber,$message);//sending SMS on the Student Mobile for announcement of the assignment
			
			if($average<=$lowMarks)
			{
				$sql72=mysql_query("SELECT *FROM parentinfo WHERE ParentInfoID='$studentID'");//selecting all student based on the section id and section id
				$row72=mysql_fetch_array($sql72);//while fetching the list of records
				$parentNumber=$row72['MobileNumber'];
				$message="Respected Madam/Sir \n Your Son/Daughter ".$name." Got Lower than ".$lowMarks."% Marks of task ".$title.".";
				sendSMS($parentNumber,$message);//sending SMS
			}
			$i++;
		}
		
		redirect_to("viewtasks.php?ErrorID=1&sbID=$subjectID&scID=$sectionID");//redirecting the with the message
		?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>