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
	$b=checkPost($_POST, array('studentName','studentFatherName','studentCNIC','studentDOB','studentJoinDate','studentReligon','studentPassword','studentPhoneNumber','studentMobileNumber','studentEmail','studentPermanentAddress','studentPermanentCity','studentTempAddress','studentDiscipline','studentTempCity','studentSession','studentRollNo','studentParentMobileNumber','studentParentOfficeNumber','studentFatherEmail','studentParentFaxNumber','studentFatherProfession','studentFatherGrade','studentFatherIncome','studentFatherOfficeAddress','studentParentOfficeType'));
	if(!$b)
	{
		session_unset();//destroy the session
		redirect_to("../clogin.php?msg=Unathuntic Source");//retuning the error message back to the login page
		exit();//then exit
	}
	
	//----------------------------------------------------------Basic Info Section ------------------------//
	
	$unsafe=$_POST['studentFatherName'];//posting father name
	$studentFatherName =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentName'];//posting name
	$studentName =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentSession'];//posting Session ID
	$studentSession =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentDiscipline'];//posting Discipline ID
	$studentDiscipline =clean($unsafe); //cleaning variable to prevent SQL injection
	
	//$unsafe=$_POST['studentSection'];//posting Section ID
	//$studentSection =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentRollNo'];//posting RollNo
	$studentRollNo =clean($unsafe); //cleaning variable to prevent SQL injection
	
	//Creating Student Registeration Number
	$result=mysql_query("SELECT * FROM `discipline` WHERE DisciplineID='$studentDiscipline'"); // applying query to generate list of diciplines
	$rows=mysql_fetch_array($result);
	$studentD=$rows['DisciplineCode'];//getting discipline code like BCS, EE
	
	$result1=mysql_query("SELECT * FROM `session` WHERE SessionID='$studentSession'"); // applying query to generate list of diciplines
	$rows1=mysql_fetch_array($result1);//getting Session code like Fa09 or sp10 
	$studentS=$rows1['Code'];
	
	$unsafe=$studentS."-".$studentD."-".$studentRollNo;
	$studentRegisterationNumber= clean($unsafe); //cleaning variable to prevent SQL injection
	//--------------------------//
	$result8=mysql_query("SELECT RegistrationNo FROM `student` WHERE `RegistrationNo` = '$studentRegisterationNumber' LIMIT 1" ); //checking either record already exists or not
	$exist1 = mysql_fetch_row($result8);		//executing the query 
    if ($exist1 !==false ) {	
		redirect_to("registerstudent.php?ErrorID=1"); //if already exists than return with error code
       }
	//---------------------//
	
	$unsafe=$_POST['studentPassword'];//posting  password
	$studentPassword =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentCNIC'];//posting  CNIC
	$studentCNIC =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$result8=mysql_query("SELECT CNICNo FROM `student` WHERE `CNICNo` = '$studentCNIC' LIMIT 1" ); 
	$exist = mysql_fetch_row($result8); 
    if ($exist !==false ) {
		redirect_to("registerstudent.php?ErrorID=2"); //if already exists than return with error code
       }
	
	$unsafe=$_POST['studentDOB'];//posting  date of birth
	$studentDOB =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentReligon'];//posting  joining date
	$studentReligon =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentJoinDate'];//posting  joining date
	$studentJoinDate =clean($unsafe); //cleaning variable to prevent SQL injection
	
	//echo "bdate=".$bdate." and jdate=".$jdate;
	if(strtotime($studentJoinDate)<strtotime($studentDOB)||strtotime($studentJoinDate)==strtotime($studentDOB)) redirect_to("registerstudent.php?ErrorID=3"); //if already exists than return with error code
	
	$unsafe=$_POST['studentMobileNumber'];//posting  Mobile Number
	$studentMobileNumber =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentPhoneNumber'];//posting  phone number
	$studentPhoneNumber =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentEmail'];//posting  email
	$studentEmail =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentPermanentAddress'];//posting  permanent address
	$studentPermanentAddress =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentPermanentCity'];//posting  permanent city
	$studentPermanentCity =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentTempAddress'];//posting  Temporary Address
	$studentTempAddress =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentTempCity'];//posting  Temporary city
	$studentTempCity =clean($unsafe); //cleaning variable to prevent SQL injection
	
	//Image uploading code here
	$studentImage = $_FILES['studentImage']['name'];//posting image path
	
	//-----------------image extension checking code --------------------------//
	$allowedExts = array("jpeg", "png");//alowed image extensions
		
		$extension = end(explode(".", $_FILES["studentImage"]["name"]));
		if (	(
					($_FILES["studentImage"]["type"] == "image/jpeg")
					|| ($_FILES["studentImage"]["type"] == "image/png")
				)
					&& ($_FILES["studentImage"]["size"] < 105000)// less than 100 KB image can be uploaded 
					&& in_array($extension, $allowedExts)
			)
		  {
				if($_FILES['studentImage']['name']!= "")
				{
				$uploaddir   = '../uploadimages/student/';  //setting directory at server where image will moved
				$uploadfile	 = $uploaddir.basename($_FILES['studentImage']['name']);//creating a file to upload at server
				move_uploaded_file($_FILES['studentImage']['tmp_name'],$uploadfile);//moving the file to server according to given path
				}
		  }
		else
		  {
			redirect_to("registerstudent.php?ErrorID=4"); //if already exists than return with error code
		  }
		  
	
	//--------------------------------------------Parent Info Table Query Start Here ---------//
	$unsafe=$_POST['studentParentMobileNumber'];//posting student parent mobile number
	$studentParentMobileNumber =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentParentOfficeNumber'];//posting student parrent office number
	$studentParentOfficeNumber =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentParentFaxNumber'];//posting student parent office fax number
	$studentParentFaxNumber =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentFatherEmail'];//posting student father email
	$studentFatherEmail =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentParentOfficeType'];//posting student parent office type
	$studentParentOfficeType =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentFatherProfession'];//posting student parent profession
	$studentFatherProfession =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentFatherGrade'];//posting student parent grade
	$studentFatherGrade =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentFatherIncome'];//posting student parent father income
	$studentFatherIncome =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentFatherOfficeAddress'];//posting student father office address
	$studentFatherOfficeAddress =clean($unsafe); //cleaning variable to prevent SQL injection
	//----------------------------------------//
	
	
	
	// Sql query for inserting record into student table
	$sql="INSERT INTO `student`(`StudentID`, `Name`, `FatherName`, `CNICNo`, `Image`, `DOB`, `JoinDate`, `Religon`, `RegistrationNo`, `Password`, `PhoneNumber`, `MobileNumber`, `EmailAddress`, `PermanentAddress`, `PermanentCity`, `TempAddress`, `Semester`, `Status`, `DisciplineID`, `TempCity`, `SessionID`, `SectionID`, `RollNo`) 
			VALUES ('','$studentName','$studentFatherName','$studentCNIC','$studentImage','$studentDOB','$studentJoinDate','$studentReligon','$studentRegisterationNumber','$studentPassword','$studentPhoneNumber','$studentMobileNumber','$studentEmail','$studentPermanentAddress','$studentPermanentCity','$studentTempAddress','1','new','$studentDiscipline','$studentTempCity','$studentSession','NULL','$studentRollNo')";
	//echo $sql;//printing for checking either values are comming or not
	mysql_query($sql);//executing query
	//-------------Student Table Query Ends Here -----------------//
	
	$prevID=mysql_insert_id($link);// ($link=coonection parameter to be make sure it is showing right id)for getting the auto increament id which was assigned to this student in student table
	$savePrevID=clean($prevID);
	// Sql query for inserting record into parent info table
	$sql1="INSERT INTO `parentinfo`(`ParentInfoID`, `MobileNumber`, `OfficeNumber`, `EmailAddress`, `FaxNumber`, `Profession`, `Grade`, `Income`, `OrganizationAddress`, `OrganizationType`) 
			VALUES ('$savePrevID','$studentParentMobileNumber','$studentParentOfficeNumber','$studentFatherEmail','$studentParentFaxNumber','$studentFatherProfession','$studentFatherGrade','$studentFatherIncome','$studentFatherOfficeAddress','$studentParentOfficeType')";
	//echo $sql1;
	mysql_query($sql1);//executing query
	//-----------Student Table Query Ends here-----------------//
	
	///Maintaining Log File Enteries
	$unsafeID=$_SESSION['CoordinatorID'];
	$coordinatorID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Register a new Student in MSIS System");//action which is performed
	$user=clean("Coordinator");//user type who performed the action
	
	//------Getting SMS Attributes---------//
	$message ="Mr/Ms: ".$studentName." Your are registered on MSIS\n Username=".$studentRegisterationNumber."\nand Password ".$studentPassword."";
	$message1 ="Mr/Ms: ".$studentName." Your are required to upload\n the previous degree documents";
	
	$number=$studentMobileNumber;
	sendSMS($number,$message);
	sendSMS($number,$message1);
	
	$message ="Mr/Ms: ".$studentFatherName." Your Son/Daughter is registered on MSIS\n Username=".$studentRegisterationNumber."\nand Password ".$studentPassword."";
	$number=$studentParentMobileNumber;
	sendSMS($number,$message);
	
	//------------Getting Email Message Attributes------------//
	$toEmail=$studentEmail;
	$subjectText= "MSIS Account Registered";
	$fromEmail="admin@msis.com";
	$msg="Mr/Ms: ".$studentName." Your are registed on MSIS\n Username=".$studentRegisterationNumber."\nand Password ".$studentPassword."\nYou can change your password after login to the System.";
	sendEmail($toEmail,$subjectText,$msg,$fromEmail);
	
	$toEmail=$studentFatherEmail;
	$subjectText= "MSIS Account Registered";
	$fromEmail="admin@msis.com";
	$msg="Mr/Ms: ".$studentFatherName." Your Son/Daughter is registered on MSIS\n Username=".$studentRegisterationNumber."\nand Password ".$studentPassword."";
	sendEmail($toEmail,$subjectText,$msg,$fromEmail);
	
	writelog($user,$coordinatorID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("registerstudent.php?ErrorID=5");//redirecting toward register page
?>
<?php
}
else
	{
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
