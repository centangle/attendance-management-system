<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File

	$b=checkPost($_POST, array('toClass','lectureTitle','lecturDate','isLab','lectureStartTime','lectureEndTime','lectureDetails'));
	if(!$b)
	{
		redirect_to("addattendance.php?ErrorID=1");//retuning the error message back to the login page
		exit();//then exit
	}
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	
	//------Maintaining Session variable for redirecting them to previous form in case of Errors ---------//
	function SetSessionValues()
	{
		$_SESSION['LecTitle']=$_POST['lectureTitle'];
		$_SESSION['LecDate']=$_POST['lecturDate'];
		$_SESSION['LecStartTime']=$_POST['lectureStartTime'];
		$_SESSION['LecEndTime']=$_POST['lectureEndTime'];
		$_SESSION['LecDetails']=$_POST['lectureDetails'];
	}
	//-------------------------------------------------------------//
	
	$profileID=$_SESSION['TeacherID'];//unsafe variable
	$id=clean($profileID);//cleaning id to preven SQL Injection
	
	$res = mysql_query("SELECT * FROM `teacher` WHERE `TeacherID` ='$id'");//SELECTING THE user records who profile need to show
	$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
	
	$unsafe=$_POST['toClass']; //posting the section id and subject id
	$necessaryIDs =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$pieces = explode(".", $necessaryIDs);//breaking on the basis of . character
	$sectionID=$pieces[0];// section ID
	$subjectID=$pieces[1]; // subject ID
	
	$unsafe=$_POST['lectureTitle'];//posting variable from form
	$lectureTitle=clean($unsafe);//cleaning for the prevention of SQL Injection
	
	$unsafe=$_POST['lecturDate'];//posting variable from form
	$lecturDate=clean($unsafe);//cleaning for the prevention of SQL Injection
	
	$unsafe=$_POST['isLab'];//posting variable from form
	$isLab=clean($unsafe);//cleaning for the prevention of SQL Injection
	
	$unsafe=$_POST['lectureStartTime'];//posting variable from form
	$tempStartTime=clean($unsafe);//cleaning for the prevention of SQL Injection
	$finalStartTime=$tempStartTime.":00";
	
	$unsafe=$_POST['lectureEndTime'];//posting variable from form
	$tempEndTime=clean($unsafe);//cleaning for the prevention of SQL Injection
	$finalEndTime= $tempEndTime.":00";
	
	$today=date('m/d/Y');
	if(strtotime($lecturDate)>strtotime($today))//if lecture date is greater than todays date show error
	{
		SetSessionValues();
		redirect_to("addattendance.php?ErrorID=6");
	}
	if(strtotime($finalStartTime)>=strtotime($finalEndTime))
	{
		SetSessionValues();
		redirect_to("addattendance.php?ErrorID=4"); //if file is greater than the given size or invalid extension
	}
	
	$currentTime=date("H:i",time()+(5*3600));//getting the current time from php Time Function
	$finalCurrentTime=strtotime($currentTime);
	$sTime=strtotime($finalStartTime);//converting start time into integer for comparison

	if($lecturDate==$today && $sTime>$finalCurrentTime)//if user enters the starting time greater the current time than its shows error
	{
		SetSessionValues();
		redirect_to("addattendance.php?ErrorID=7"); //redirecting toward add attendance page with error code
	}
	
	$timedifference=(strtotime($finalEndTime)-strtotime($finalStartTime))/3600;//converting the time into hours
	
	if($isLab=="0")
	{
		if($timedifference<"1" || $timedifference>"1.5")//validating class time
		{
			SetSessionValues();
			redirect_to("addattendance.php?ErrorID=2"); //if file is greater than the given size or invalid extension
		}
	}
		else
			{
				if($timedifference!="3")//validating Lab Time
				{
				SetSessionValues();
				redirect_to("addattendance.php?ErrorID=3"); //if file is greater than the given size or invalid extension
				}
			}
	
	$unsafe=$_POST['lectureDetails'];//posting variable from form
	$tempDetails=clean($unsafe);//cleaning for the prevention of SQL Injection
	$lectureDetails=str_replace('\r\n', ' ',$tempDetails);//triming \r\n from the messge

	$lectureContentFile = $_FILES['lectureContent']['name'];//posting content file path
	
	//---------Getting the Class ID on the Basis of Section id and subject ID -------------//
	$query1=mysql_query("SELECT `ClassID` FROM `class` WHERE `SubjectID`='$subjectID' AND `SectionID`='$sectionID'");
	$rowQuery=mysql_fetch_array($query1);
	$classID=$rowQuery['ClassID'];//class id
	//-----------------------------------------------------------------------------------//

	
	if($lectureContentFile==NULL)
	{
		mysql_query("INSERT INTO `lecture`(`Title`, `ClassID`, `Description`, `Date`, `Lab`, `StartTime`, `EndTime`) 
							VALUES ('$lectureTitle','$classID','$lectureDetails','$lecturDate','$isLab','$finalStartTime','$finalEndTime')");
		
	}//else portion ahead
	
	if($lectureContentFile!=NULL)
	{
		//--------------Image Validation------------------//
		$sql19=mysql_query("SELECT *FROM criteria WHERE Entity='UploadFileSize'");
		$row19=mysql_fetch_array($sql19);
		$size=$row19['Value'];
		
		$validSize=$size * 1024 * 1024;//converting size into MBs
		
		//-----------------file extension checking code --------------------------//
		$allowedExts = array("rar", "zip");//alowed image extensions
			
		$extension = end(explode(".", $_FILES["lectureContent"]["name"]));
		if (	(
					($_FILES["lectureContent"]["type"] == "application/x-rar-compressed")
					||($_FILES["lectureContent"]["type"] == "application/octet-stream")
					|| ($_FILES["lectureContent"]["type"] == "application/zip")
				)
					&& ($_FILES["lectureContent"]["size"] <= $validSize)// less than 5 MB file can be uploaded 
					&& in_array($extension, $allowedExts)
			)
		  {
		  }
		else
		  {
			SetSessionValues();
			redirect_to("addattendance.php?ErrorID=5"); //if file is greater than the given size or invalid extension
		  }
		
		mysql_query("INSERT INTO `content`(`TeacherID`, `OnDate`)
						VALUES ('$id','$today')");
						
		$prevID=mysql_insert_id($link);// ($link=coonection parameter to be make sure it is showing right id)for getting the auto increament id which was assigned to this record
		$savePrevID=clean($prevID);
		
		mysql_query("INSERT INTO `lecture`(`Title`, `ClassID`, `Description`, `Date`, `Lab`, `StartTime`, `EndTime`, `ContentID`) 
							VALUES ('$lectureTitle','$classID','$lectureDetails','$lecturDate','$isLab','$finalStartTime','$finalEndTime','$savePrevID')");

		$uploaddir   = '../Contents/';  //setting directory at server where image will moved
		$uploadfile	 = $savePrevID.".".$extension;//creating a file to upload at server
		move_uploaded_file($_FILES['lectureContent']['tmp_name'],$uploaddir.$uploadfile);//moving the file to server according to given path
	
		$sql80="UPDATE `content` SET `FileName`='$uploadfile' WHERE ContentID='$savePrevID'";
		mysql_query($sql80);//executing query
	}
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	
	$lecID=mysql_insert_id($link);// ($link=coonection parameter to be make sure it is showing right id)for getting the auto increament id which was assigned to this record
	$saveLecID=clean($lecID);//last assigned lecture ID
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['TeacherID'];
	$teacherID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Added Lecture Details in MSIS System");//action which is performed
	$user=clean("Teacher");//user type who performed the action
	
	writelog($user,$teacherID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("attendanceform.php?lid=$saveLecID&sid=$sectionID&sbid=$subjectID");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
