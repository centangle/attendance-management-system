<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array('studentName','studentFatherName','studentCNIC','studentDOB','studentSection','studentJoinDate','studentReligon','studentPassword','studentPhoneNumber','studentMobileNumber','studentEmail','studentPermanentAddress','studentPermanentCity','studentTempAddress','studentTempCity','studentParentMobileNumber','studentParentOfficeNumber','studentFatherEmail','studentParentFaxNumber','studentFatherProfession','studentFatherGrade','studentFatherIncome','studentFatherOfficeAddress','studentParentOfficeType'));
	if(!$b)
	{
		session_unset();//destroy the session
		redirect_to("../clogin.php?msg=Unathuntic Source");//retuning the error message back to the login page
		exit();//then exit
	}

	$notsafeid=$_GET['id'];//getting ID of the Corrdinator who record need to update
	$sID=clean($notsafeid);//applying serverside validation and cleaning the variable
	
	//----------------------------------------------------------Basic Info Section ------------------------//
	
	$unsafe=$_POST['studentFatherName'];//posting father name
	$studentFatherName =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentName'];//posting name
	$studentName =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentPassword'];//posting  password
	$studentPassword =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentSection'];//posting Section ID
	$studentSection =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentCNIC'];//posting  CNIC
	$studentCNIC =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentDOB'];//posting  date of birth
	$studentDOB =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentJoinDate'];//posting  joining date
	$studentReligon =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['studentJoinDate'];//posting  joining date
	$studentJoinDate =clean($unsafe); //cleaning variable to prevent SQL injection
	
	if(strtotime($studentJoinDate)<strtotime($studentDOB)||strtotime($studentJoinDate)==strtotime($studentDOB)) redirect_to("updatestudent.php?ErrorID=3&id=$sID"); //if already exists than return with error code
	
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
	
	$sql=("UPDATE `student`
				SET 
				`Name`='$studentName',
				`FatherName`='$studentFatherName',
				`CNICNo`='$studentCNIC',
				`DOB`='$studentDOB',
				`JoinDate`='$studentJoinDate',
				`Religon`='$studentReligon',
				`Password`='$studentPassword',
				`PhoneNumber`='$studentPhoneNumber',
				`MobileNumber`='$studentMobileNumber',
				`EmailAddress`='$studentEmail',
				`PermanentAddress`='$studentPermanentAddress',
				`PermanentCity`='$studentPermanentCity',
				`TempAddress`='$studentTempAddress',
				`TempCity`='$studentTempCity',
				`SectionID`='$studentSection'
				 WHERE `StudentID`='$sID'");
	
	mysql_query($sql);//executing query
	//-------------Student Table Query Ends Here -----------------//
	
	$sql1=("UPDATE `parentinfo`
			SET 
			`MobileNumber`='$studentParentMobileNumber',
			`OfficeNumber`='$studentParentOfficeNumber',
			`EmailAddress`='$studentFatherEmail',
			`FaxNumber`='$studentParentFaxNumber',
			`Profession`='$studentFatherProfession',
			`Grade`='$studentFatherGrade',
			`Income`='$studentFatherIncome',
			`OrganizationAddress`='$studentFatherOfficeAddress',
			`OrganizationType`='$studentParentOfficeType'
			WHERE `ParentInfoID`='$sID'");
	
	mysql_query($sql1);//executing query
	//-----------Student Table Query Ends here-----------------//
	
	///Maintaining Log File Enteries
	$unsafeID=$_SESSION['CoordinatorID'];
	$coordinatorID=clean($unsafeID);//ID of the admin who is performing task
	$msg=clean("Updated a student record in MSIS System");//action which is performed
	$user=clean("Coordinator");//user type who performed the action
	
	writelog($user,$coordinatorID,$msg);//sending parameters to write log funtion which is in the common function library
	
	redirect_to("viewstudent.php?ErrorID=5");//redirecting toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
