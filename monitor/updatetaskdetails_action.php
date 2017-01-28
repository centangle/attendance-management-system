<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	
	if(is_numeric($_GET['tid']))
	$unsafe=$_GET['tid'];
	$lectureID=clean($unsafe);//cleaning the variable
	
	if(is_numeric($_GET['sbID']))
	$unsafe=$_GET['sbID'];
	$subjectID=clean($unsafe);//cleaning the variable
	
	if(is_numeric($_GET['scID']))
	$unsafe=$_GET['scID'];
	$sectionID=clean($unsafe);//cleaning the variable
	
	$unsafe=$_GET['tt'];
	$taskType=clean($unsafe);//cleaning the variable
	
	$b=checkPost($_POST, array('taskTitle','taskMarks','issueDate','dueDate','taskDetails'));
	if(!$b)
	{
		redirect_to("updatetaskdetails.php?ErrorID=1&tid=$lectureID&sbID=$subjectID&scID=$sectionID");//retuning the error message back to the login page
		exit();//then exit
	}
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	
	//------Maintaining Session variable for redirecting them to previous form in case of Errors ---------//
	function SetSessionValues()
	{
		$_SESSION['tasTitle']=$_POST['taskTitle'];
		$_SESSION['tasMark']=$_POST['taskMarks'];
		$_SESSION['isueDate']=$_POST['issueDate'];
		$_SESSION['dueDate']=$_POST['dueDate'];
		$_SESSION['tasDetails']=$_POST['taskDetails'];
	}
	//-------------------------------------------------------------//
	
	$profileID=$_SESSION['TeacherID'];//unsafe variable
	$id=clean($profileID);//cleaning id to preven SQL Injection
	
	$unsafe=$_POST['taskTitle'];//posting variable from form
	$taskTitle=clean($unsafe);//cleaning for the prevention of SQL Injection
	
	$unsafe=$_POST['taskMarks'];//posting variable from form
	$taskMarks=clean($unsafe);//cleaning for the prevention of SQL Injection
	
	$unsafe=$_POST['issueDate'];//posting variable from form
	$issueDate=clean($unsafe);//cleaning for the prevention of SQL Injection
	
	$unsafe=$_POST['dueDate'];//posting variable from form
	$dueDate=clean($unsafe);//cleaning for the prevention of SQL Injection
	
	$unsafe=$_POST['taskDetails'];//posting variable from form
	$tempDetails=clean($unsafe);//cleaning for the prevention of SQL Injection
	$taskDetails=str_replace('\r\n', ' ',$tempDetails);//triming \r\n from the messge
	
	$today=date('m/d/Y');
	
	if($taskType=='a')
	{
		if(strtotime($dueDate)<=strtotime($issueDate))//if lecture date is greater than todays date show error
		{
			SetSessionValues();
			redirect_to("updatetaskdetails.php?ErrorID=2&tid=$lectureID&sbID=$subjectID&scID=$sectionID");
		}
	}
	
	if($taskType=='q' || $taskType=='s' || $taskType=='f')
	{
		if(strtotime($dueDate)!=strtotime($issueDate))//if lecture date is greater than todays date show error
		{
			SetSessionValues();
			redirect_to("updatetaskdetails.php?ErrorID=3&tid=$lectureID&sbID=$subjectID&scID=$sectionID");
		}
	}
	
	if(strtotime($issueDate)>strtotime($today))//if isue date date is greater than todays date show error
	{
		SetSessionValues();
		redirect_to("updatetaskdetails.php?ErrorID=6&tid=$lectureID&sbID=$subjectID&scID=$sectionID");
	}

	$lectureContentFile = $_FILES['taskContent']['name'];//posting content file path

	if($lectureContentFile==NULL)
	{
		mysql_query("UPDATE `task` 
							SET
							`IssueDate`='$issueDate',
							`DueDate`='$dueDate',
							`TotalMarks`=$taskMarks,
							`Title`='$taskTitle',
							`Description`='$taskDetails' 
							WHERE `TaskID`='$lectureID'");
	}
	
	if($lectureContentFile!=NULL)
	{
		//--------------Image Validation------------------//
		$sql19=mysql_query("SELECT *FROM criteria WHERE Entity='UploadFileSize'");
		$row19=mysql_fetch_array($sql19);
		$size=$row19['Value'];
		
		$validSize=$size * 1024 * 1024;//converting size into MBs
		
		//-----------------file extension checking code --------------------------//
		$allowedExts = array("rar", "zip");//alowed image extensions
			
		$extension = end(explode(".", $_FILES["taskContent"]["name"]));
		if (	(
					($_FILES["taskContent"]["type"] == "application/x-rar-compressed")
					||($_FILES["taskContent"]["type"] == "application/octet-stream")
					|| ($_FILES["taskContent"]["type"] == "application/zip")
				)
					&& ($_FILES["taskContent"]["size"] <= $validSize)// less than 5 MB file can be uploaded 
					&& in_array($extension, $allowedExts)
			)
		  {
		  }
		else
		  {
			SetSessionValues();
			redirect_to("updatetaskdetails.php?ErrorID=5&tid=$lectureID&sbID=$subjectID&scID=$sectionID"); //if file is greater than the given size or invalid extension
		  }
		
		mysql_query("INSERT INTO `content`(`TeacherID`, `OnDate`)
						VALUES ('$id','$today')");
						
		$prevID=mysql_insert_id($link);// ($link=coonection parameter to be make sure it is showing right id)for getting the auto increament id which was assigned to this record
		$savePrevID=clean($prevID);
		
		mysql_query("UPDATE `task` 
							SET
							`IssueDate`='$issueDate',
							`DueDate`='$dueDate',
							`ContentID`='$savePrevID'
							`TotalMarks`=$taskMarks,
							`Title`='$taskTitle',
							`Description`='$taskDetails' 
							WHERE `TaskID`='$lectureID'");

		$uploaddir   = '../Contents/';  //setting directory at server where image will moved
		$uploadfile	 = $savePrevID.".".$extension;//creating a file to upload at server
		move_uploaded_file($_FILES['taskContent']['tmp_name'],$uploaddir.$uploadfile);//moving the file to server according to given path
	
		$sql80="UPDATE `content` SET `FileName`='$uploadfile' WHERE ContentID='$savePrevID'";
		mysql_query($sql80);//executing query
	}
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['TeacherID'];
	$teacherID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Update TasK Details in MSIS System");//action which is performed
	$user=clean("Teacher");//user type who performed the action
	
	writelog($user,$teacherID,$msg);//sending parameters to write log funtion which is in the common function library
	
	if($taskType=='a')
	{
		$sql71=mysql_query("SELECT *FROM student JOIN  subjecttostudy " .
						"ON subjecttostudy.StudentID = student.StudentID " .
						"WHERE subjecttostudy.SectionID ='".$sectionID."' AND subjecttostudy.SubjectID ='".$subjectID."'");//selecting all student based on the section id and section id

		$message="Mr/Ms: An Assignment Information has been updated on MSIS.\n Due Date of Assignment is".$dueDate.".";
		while($row71=mysql_fetch_array($sql71))//while fetching the list of records
		{
			$studentNumber=$row71['MobileNumber'];
			sendSMS($studentNumber,$message);//sending SMS on the Student Mobile for announcement of the assignment
		}
	}
	
	redirect_to("taskdetails.php?ErrorID=8&tid=$lectureID&sbID=$subjectID&scID=$sectionID");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
