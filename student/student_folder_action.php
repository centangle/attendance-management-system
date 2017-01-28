<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//Image uploading code here
	$studentImage = $_FILES['studentImage1']['name'];//posting image path
	$studentImage1 = $_FILES['studentImage2']['name'];//posting image path
	//$studentImage2 = $_FILES['studentImage3']['name'];//posting image path
	//$studentImage3 = $_FILES['studentImage4']['name'];//posting image path
	
	$profileID=$_SESSION['StudentID'];//unsafe variable
	$id=clean($profileID);//cleaning id to preven SQL Injection
	
	$res = mysql_query("SELECT * FROM `student` WHERE `StudentID` ='$id'");//SELECTING THE user records who profile need to show
	$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
	
	//$directorName=$row['CNICNo'];	
					
	mkdir("../userdocuments/student/".$id."", 0700);// creating a director by the name of the CNIC of student
	
	//-----------------image extension checking code --------------------------//
	$allowedExts = array("jpeg", "png", "jpg", "JPEG", "PNG", "JPG");//alowed image extensions
		
		$extension = end(explode(".", $_FILES["studentImage"]["name"]));
		if (	(
					($_FILES["studentImage"]["type"] == "image/jpeg")
					|| ($_FILES["studentImage"]["type"] == "image/png")
				)
					&& ($_FILES["studentImage"]["size"] < 155000)// less than 100 KB image can be uploaded 
					&& in_array($extension, $allowedExts)
			)
		  {
				if($_FILES['studentImage']['name']!= "")
				{
				$uploaddir   = '../userdocuments/student/'.$id.'/';  //setting directory at server where image will moved
				$uploadfile	 = $uploaddir.basename($_FILES['studentImage']['name']);//creating a file to upload at server
				move_uploaded_file($_FILES['studentImage']['tmp_name'],$uploadfile);//moving the file to server according to given path
				}
		  }
		else
		  {
			redirect_to("studentfolder.php?ErrorID=1"); //if file is greater than the given size or invalid extension
		  }
		  
		  $extension = end(explode(".", $_FILES["studentImage1"]["name"]));
		if (	(
					($_FILES["studentImage1"]["type"] == "image/jpeg")
					|| ($_FILES["studentImage1"]["type"] == "image/png")
				)
					&& ($_FILES["studentImage1"]["size"] < 155000)// less than 100 KB image can be uploaded 
					&& in_array($extension, $allowedExts)
			)
		  {
				if($_FILES['studentImage1']['name']!= "")
				{
				$uploaddir   = '../userdocuments/student/'.$id.'/';  //setting directory at server where image will moved
				$uploadfile	 = $uploaddir.basename($_FILES['studentImage1']['name']);//creating a file to upload at server
				move_uploaded_file($_FILES['studentImage1']['tmp_name'],$uploadfile);//moving the file to server according to given path
				}
		  }
		else
		  {
			redirect_to("studentfolder.php?ErrorID=2"); //if file is greater than the given size or invalid extension
		  }
		  /*
		  $extension = end(explode(".", $_FILES["studentImage2"]["name"]));
		if (	(
					($_FILES["studentImage2"]["type"] == "image/jpeg")
					|| ($_FILES["studentImage2"]["type"] == "image/png")
				)
					&& ($_FILES["studentImage2"]["size"] < 155000)// less than 100 KB image can be uploaded 
					&& in_array($extension, $allowedExts)
			)
		  {
				if($_FILES['studentImage2']['name']!= "")
				{
				$uploaddir   = '../userdocuments/student/'.$id.'/';  //setting directory at server where image will moved
				$uploadfile	 = $uploaddir.basename($_FILES['studentImage2']['name']);//creating a file to upload at server
				move_uploaded_file($_FILES['studentImage2']['tmp_name'],$uploadfile);//moving the file to server according to given path
				}
		  }
		else
		  {
			redirect_to("studentfolder.php?ErrorID=3"); //if file is greater than the given size or invalid extension
		  }
		  
		  if($_FILES['studentImage3']['name']!= "")
			{
			  $extension = end(explode(".", $_FILES["studentImage3"]["name"]));
				if (	(
							($_FILES["studentImage3"]["type"] == "image/jpeg")
							|| ($_FILES["studentImage3"]["type"] == "image/png")
						)
							&& ($_FILES["studentImage3"]["size"] < 155000)// less than 100 KB image can be uploaded 
							&& in_array($extension, $allowedExts)
					)
				  {
						$uploaddir   = '../userdocuments/student/'.$id.'/';  //setting directory at server where image will moved
						$uploadfile	 = $uploaddir.basename($_FILES['studentImage3']['name']);//creating a file to upload at server
						move_uploaded_file($_FILES['studentImage3']['tmp_name'],$uploadfile);//moving the file to server according to given path
				  }
				else
				  {
					redirect_to("studentfolder.php?ErrorID=4"); //if file is greater than the given size or invalid extension
				  }
			}*/
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	
	// Sql query for inserting record into student table
	$sql="INSERT INTO `studentfolder`
			(`FolderID`, `SSC`, `HSSC`) 
			VALUES ('$id','$studentImage','$studentImage1')"; //,'$studentImage2','$studentImage3')";
	mysql_query($sql); //executing query
	
	//Maintaining Log File Enteries
	$unsafeID=$_SESSION['StudentID'];
	$studentID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Added Certificate Images in MSIS System");//action which is performed
	$user=clean("Student");//user type who performed the action
	
	writelog($user,$studentID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("studentfolder.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../studentlogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
