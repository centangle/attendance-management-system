<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<?php
	include_once("../common/commonfunctions.php"); //including Common function library
	include_once("../common/config.php"); //including DB Connection File
	include_once("../common/sendfunctions.php"); //including the SMS API and Mail Code
	
	//---------------------------------SERVER SIDE VALIDATION STARTS HERE --------------------------------------------------------------//
	//checking if $post is not set or empty
	$b=checkPost($_POST, array('tableType','notificationDetails'));
	if(!$b)
	{
		redirect_to("sendnotification.php?ErrorID=1");//retuning the error message back to the login page
		exit();//then exit
	}
	
	$unsafe=$_POST['tableType']; //posting the user typr where notification will be sended
	$tableType =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['notificationDetails']; //posting detials of the notification
	$notificationDetails =clean($unsafe); //cleaning variable to prevent SQL injection
	$message=$notificationDetails."\nMSIS Admin";//posting message after cleaning
	
	$message=str_replace('\r\n', ' ',$message);//removing \r\n from the text
	
	if($tableType=="student")
	{
		$sql=mysql_query("SELECT *FROM student");//selecting all students 1-by-1
		while($row=mysql_fetch_array($sql))
		{
			$studentMobile=$row['MobileNumber'];//posting number of the student
			sendSMS($studentMobile,$message);//sending alert to the student
		}
	}
		else
			if($tableType=="teacher")
			{
				$sql1=mysql_query("SELECT *FROM teacher");//selecting all teacher 1-by-1
				while($row1=mysql_fetch_array($sql1))
				{
					$teacherMobile=$row1['MobileNumber'];//posting number of the teacher
					sendSMS($teacherMobile,$message);//sending alert to the teacher
				}
			}
				else
					if($tableType=="coordinator")
					{
						$sql2=mysql_query("SELECT *FROM coordinator");//selecting all coordinator 1-by-1
						while($row2=mysql_fetch_array($sql2))
						{
							$coordinatorMobile=$row2['MobileNumber'];//posting number of the coordinator
							sendSMS($coordinatorMobile,$message);//sending alert to the coordinator
						}
					}
						else
							if($tableType=="attendent")
							{
								$sql3=mysql_query("SELECT *FROM attendent");//selecting all attendent 1-by-1
								while($row3=mysql_fetch_array($sql3))
								{
									$attendentMobile=$row3['MobileNumber'];//posting number of the attendent
									sendSMS($attendentMobile,$message);//sending alert to the attendent
								}
							}
								else
									if($tableType=="parent")
									{
										$sql4=mysql_query("SELECT *FROM parentinfo");//selecting all parents 1-by-1
										while($row4=mysql_fetch_array($sql4))
										{
											$parentMobile=$row4['MobileNumber'];//posting number of the parent
											echo $parentMobile;
											sendSMS($parentMobile,$message);//sending alert to the parent
										}
									}
								else
								{
									//---------Student Messages----------//
									$sql=mysql_query("SELECT *FROM student");//selecting all students 1-by-1
									while($row=mysql_fetch_array($sql))
									{
										$studentMobile=$row['MobileNumber'];//posting number of the student
										sendSMS($studentMobile,$message);//sending alert to the student
									}
									//---------Teacher Messages----------//
									$sql1=mysql_query("SELECT *FROM teacher");//selecting all teacher 1-by-1
									while($row1=mysql_fetch_array($sql1))
									{
										$teacherMobile=$row1['MobileNumber'];//posting number of the teacher
										sendSMS($teacherMobile,$message);//sending alert to the teacher
									}
									//---------coordinator Messages----------//
									$sql2=mysql_query("SELECT *FROM coordinator");//selecting all coordinator 1-by-1
									while($row2=mysql_fetch_array($sql2))
									{
										$coordinatorMobile=$row2['MobileNumber'];//posting number of the coordinator
										sendSMS($coordinatorMobile,$message);//sending alert to the coordinator
									}
									//---------attendant Messages----------//
									$sql3=mysql_query("SELECT *FROM attendent");//selecting all attendent 1-by-1
									while($row3=mysql_fetch_array($sql3))
									{
										$attendentMobile=$row3['MobileNumber'];//posting number of the attendent
										sendSMS($attendentMobile,$message);//sending alert to the attendent
									}
									
									//---------parent Messages-------------//
									$sql4=mysql_query("SELECT *FROM parentinfo");//selecting all parents 1-by-1
									while($row4=mysql_fetch_array($sql4))
									{
										$parentMobile=$row4['MobileNumber'];//posting number of the attendent
										sendSMS($parentMobile,$message);//sending alert to the attendent
									}
								}
	redirect_to("sendnotification.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
