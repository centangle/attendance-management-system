<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File

	$profileID=$_SESSION['TeacherID'];//unsafe variable
	$id=clean($profileID);//cleaning id to preven SQL Injection
	
	if(is_numeric($_GET['tid']))
	$unsafe=$_GET['tid'];
	$taskID=clean($unsafe);//cleaning the variable
	
	if(is_numeric($_GET['sbID']))
	$unsafe=$_GET['sbID'];
	$subjectID=clean($unsafe);//cleaning the variable
	
	if(is_numeric($_GET['scID']))
	$unsafe=$_GET['scID'];
	$sectionID=clean($unsafe);//cleaning the variable
	
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	$today=date('m/d/Y');
	
	$lectureContentFile=$_FILES["task"]["name"];//posting content file path
	
	
	if($lectureContentFile!=NULL)
	{
		//--------------Image Validation------------------//
		$sql19=mysql_query("SELECT *FROM criteria WHERE Entity='UploadFileSize'");
		$row19=mysql_fetch_array($sql19);
		$size=$row19['Value'];
		
		$validSize=$size * 1024 * 1024;//converting size into MBs
		
		//-----------------file extension checking code --------------------------//
		$allowedExts = array("rar", "zip");//alowed image extensions
			
		$extension = end(explode(".", $_FILES["task"]["name"]));
		if (	(
					($_FILES["task"]["type"] == "application/x-rar-compressed")
					||($_FILES["task"]["type"] == "application/octet-stream")
					|| ($_FILES["task"]["type"] == "application/zip")
				)
					&& ($_FILES["task"]["size"] <= $validSize)// less than 5 MB file can be uploaded 
					&& in_array($extension, $allowedExts)
			)
		  {
		  }
		else
		  {
			redirect_to("addsolutiondetails.php?ErrorID=5&tid=$taskID&sbID=$subjectID&scID=$sectionID"); //if file is greater than the given size or invalid extension
		  }
		
		mysql_query("INSERT INTO `content`(`TeacherID`, `OnDate`)
						VALUES ('$id','$today')");
						
		$prevID=mysql_insert_id($link);// ($link=coonection parameter to be make sure it is showing right id)for getting the auto increament id which was assigned to this record
		$savePrevID=clean($prevID);
		
		mysql_query("UPDATE task
						SET `SolutionID`='$savePrevID'
						WHERE `TaskID`='$taskID'");

		$uploaddir   = '../Contents/';  //setting directory at server where image will moved
		$uploadfile	 = $savePrevID.".".$extension;//creating a file to upload at server
		move_uploaded_file($_FILES['task']['tmp_name'],$uploaddir.$uploadfile);//moving the file to server according to given path
	
		$sql80="UPDATE `content` SET `FileName`='$uploadfile' WHERE ContentID='$savePrevID'";
		mysql_query($sql80);//executing query
	}
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['TeacherID'];
	$teacherID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Added TasK Solution in MSIS System");//action which is performed
	$user=clean("Teacher");//user type who performed the action
	
	writelog($user,$teacherID,$msg);//sending parameters to write log funtion which is in the common function library
	redirect_to("addtasksolution.php?ErrorID=2&sbID=$subjectID&scID=$sectionID");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
