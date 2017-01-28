<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//Image uploading code here
	$teacherImage = $_FILES['teacherImage1']['name'];//posting image path
	$teacherImage1 = $_FILES['teacherImage2']['name'];//posting image path
	$teacherImage2 = $_FILES['teacherImage3']['name'];//posting image path
	$teacherImage3 = $_FILES['teacherImage4']['name'];//posting image path
	
	$profileID=$_SESSION['TeacherID'];//unsafe variable
	$id=clean($profileID);//cleaning id to preven SQL Injection
	
	$res = mysql_query("SELECT * FROM `teacher` WHERE `TeacherID` ='$id'");//SELECTING THE user records who profile need to show
	$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
	
	//$directorName=$row['CNICNo'];	
					
	mkdir("../userdocuments/teacher/".$id."", 0700);// creating a director by the name of the CNIC of teacher
	
	//-----------------image extension checking code --------------------------//
	$allowedExts = array("jpeg", "png", "jpg", "JPEG", "PNG", "JPG");//alowed image extensions
		
		$extension = end(explode(".", $_FILES["teacherImage"]["name"]));
		if (	(
					($_FILES["teacherImage"]["type"] == "image/jpeg")
					|| ($_FILES["teacherImage"]["type"] == "image/png")
				)
					&& ($_FILES["teacherImage"]["size"] < 155000)// less than 100 KB image can be uploaded 
					&& in_array($extension, $allowedExts)
			)
		  {
				if($_FILES['teacherImage']['name']!= "")
				{
				$uploaddir   = '../userdocuments/teacher/'.$id.'/';  //setting directory at server where image will moved
				$uploadfile	 = $uploaddir.basename($_FILES['teacherImage']['name']);//creating a file to upload at server
				move_uploaded_file($_FILES['teacherImage']['tmp_name'],$uploadfile);//moving the file to server according to given path
				}
		  }
		else
		  {
			redirect_to("teacherfolder.php?ErrorID=1"); //if file is greater than the given size or invalid extension
		  }
		  
		  $extension = end(explode(".", $_FILES["teacherImage1"]["name"]));
		if (	(
					($_FILES["teacherImage1"]["type"] == "image/jpeg")
					|| ($_FILES["teacherImage1"]["type"] == "image/png")
				)
					&& ($_FILES["teacherImage1"]["size"] < 155000)// less than 100 KB image can be uploaded 
					&& in_array($extension, $allowedExts)
			)
		  {
				if($_FILES['teacherImage1']['name']!= "")
				{
				$uploaddir   = '../userdocuments/teacher/'.$id.'/';  //setting directory at server where image will moved
				$uploadfile	 = $uploaddir.basename($_FILES['teacherImage1']['name']);//creating a file to upload at server
				move_uploaded_file($_FILES['teacherImage1']['tmp_name'],$uploadfile);//moving the file to server according to given path
				}
		  }
		else
		  {
			redirect_to("teacherfolder.php?ErrorID=2"); //if file is greater than the given size or invalid extension
		  }
		  
		  $extension = end(explode(".", $_FILES["teacherImage2"]["name"]));
		if (	(
					($_FILES["teacherImage2"]["type"] == "image/jpeg")
					|| ($_FILES["teacherImage2"]["type"] == "image/png")
				)
					&& ($_FILES["teacherImage2"]["size"] < 155000)// less than 100 KB image can be uploaded 
					&& in_array($extension, $allowedExts)
			)
		  {
				if($_FILES['teacherImage2']['name']!= "")
				{
				$uploaddir   = '../userdocuments/teacher/'.$id.'/';  //setting directory at server where image will moved
				$uploadfile	 = $uploaddir.basename($_FILES['teacherImage2']['name']);//creating a file to upload at server
				move_uploaded_file($_FILES['teacherImage2']['tmp_name'],$uploadfile);//moving the file to server according to given path
				}
		  }
		else
		  {
			redirect_to("teacherfolder.php?ErrorID=3"); //if file is greater than the given size or invalid extension
		  }
		  
		  if($_FILES['teacherImage3']['name']!= "")
			{
			  $extension = end(explode(".", $_FILES["teacherImage3"]["name"]));
				if (	(
							($_FILES["teacherImage3"]["type"] == "image/jpeg")
							|| ($_FILES["teacherImage3"]["type"] == "image/png")
						)
							&& ($_FILES["teacherImage3"]["size"] < 155000)// less than 100 KB image can be uploaded 
							&& in_array($extension, $allowedExts)
					)
				  {
						$uploaddir   = '../userdocuments/teacher/'.$id.'/';  //setting directory at server where image will moved
						$uploadfile	 = $uploaddir.basename($_FILES['teacherImage3']['name']);//creating a file to upload at server
						move_uploaded_file($_FILES['teacherImage3']['tmp_name'],$uploadfile);//moving the file to server according to given path
				  }
				else
				  {
					redirect_to("teacherfolder.php?ErrorID=4"); //if file is greater than the given size or invalid extension
				  }
			}
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	
	// Sql query for inserting record into teacher table
	$sql="INSERT INTO `teacherfolder`
			(`TeacherFolderID`, `SSC`, `HSSC`, `GC`, `PGC`) 
			VALUES ('$id','$teacherImage','$teacherImage1','$teacherImage2','$teacherImage4')";
	mysql_query($sql); //executing query
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['TeacherID'];
	$teacherID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Added Certificate Images in MSIS System");//action which is performed
	$user=clean("Teacher");//user type who performed the action
	
	writelog($user,$teacherID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("teacherfolder.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
