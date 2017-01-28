<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File

	/*$b=checkPost($_POST, array('articleTitle','articleWhom','articleDetails'));
	if(!$b)
	{
		redirect_to("addarticle.php?ErrorID=1");//retuning the error message back to the login page
		exit();//then exit
	}*/
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	
	//------Maintaining Session variable for redirecting them to previous form in case of Errors ---------//
	function SetSessionValues()
	{
		$_SESSION['ArtTitle']=$_POST['articleTitle'];
		$_SESSION['ArtWhom']=$_POST['articleWhom'];
		$_SESSION['ArtDetails']=$_POST['articleDetails'];
	}
	//-------------------------------------------------------------//
	
	$profileID=$_SESSION['TeacherID'];//unsafe variable
	$id=clean($profileID);//cleaning id to preven SQL Injection	
	
	$unsafe=$_POST['articleTitle'];//posting variable from form
	$artTitle=clean($unsafe);//cleaning for the prevention of SQL Injection
	
	$unsafe=$_POST['articleWhom'];//posting variable from form
	$artWhom=clean($unsafe);//cleaning for the prevention of SQL Injection
	
	$today=date('m/d/Y');
	
	$unsafe=$_POST['articleDetails'];//posting variable from form
	$tempDetails=clean($unsafe);//cleaning for the prevention of SQL Injection
	$artDetails=str_replace('\r\n', ' ',$tempDetails);//triming \r\n from the messge

	$lectureContentFile = $_FILES['articleContent']['name'];//posting content file path
	
	if($lectureContentFile!=NULL)
	{
		//--------------Image Validation------------------//
		$sql19=mysql_query("SELECT Value FROM criteria WHERE Entity='UploadFileSize'");
		$row19=mysql_fetch_array($sql19);
		$size=$row19[0];
		
		$validSize=$size * 1024 * 1024;//converting size into MBs
		
		//-----------------file extension checking code --------------------------//
		$allowedExts = array("rar", "zip");//alowed image extensions
			
		$extension = end(explode(".", $_FILES["articleContent"]["name"]));
		if (	(
					($_FILES["articleContent"]["type"] == "application/x-rar-compressed")
					||($_FILES["articleContent"]["type"] == "application/octet-stream")
					|| ($_FILES["articleContent"]["type"] == "application/zip")
				)
					&& ($_FILES["articleContent"]["size"] <= $validSize)// less than 5 MB file can be uploaded 
					&& in_array($extension, $allowedExts)
			)
		  {
		  }
		else
		  {
			SetSessionValues();
			redirect_to("addarticle.php?ErrorID=2"); //if file is greater than the given size or invalid extension
		  }
	}
	
		mysql_query("INSERT INTO `content`(`TeacherID`, `OnDate`) VALUES ('$id','$today')");
						
		$prevID=mysql_insert_id($link);// ($link=coonection parameter to be make sure it is showing right id)for getting the auto increament id which was assigned to this record
		$savePrevID=clean($prevID);
													
		mysql_query("INSERT INTO article (`TeacherID`, `Title`, `Description`, `Whom`, `ContentID`) 
											VALUES ('$id','$artTitle','$artDetails','$artWhom','$savePrevID')");
											
		$uploaddir   = '../Contents/';  //setting directory at server where image will moved
		$uploadfile	 = $savePrevID.".".$extension;//creating a file to upload at server
		move_uploaded_file($_FILES['articleContent']['tmp_name'],$uploaddir.$uploadfile);//moving the file to server according to given path
	
		$sql80="UPDATE `content` SET `FileName`='$uploadfile' WHERE ContentID='$savePrevID'";
		mysql_query($sql80);//executing query
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['TeacherID'];
	$teacherID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Added an article in MSIS System");//action which is performed
	$user=clean("Teacher");//user type who performed the action
	
	writelog($user,$teacherID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("addarticle.php?ErrorID=3");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
