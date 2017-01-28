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
		redirect_to("sendemail.php?ErrorID=1");//retuning the error message back to the login page
		exit();//then exit
	}
	
	$unsafe=$_POST['tableType']; //posting the user typr where notification will be sended
	$tableType =clean($unsafe); //cleaning variable to prevent SQL injection
	
	$unsafe=$_POST['notificationDetails']; //posting detials of the notification
	$notificationDetails =clean($unsafe); //cleaning variable to prevent SQL injection
	$message=$notificationDetails."<br />MSIS Admin";//posting message after cleaning
	
	$message=str_replace('\r\n', ' ',$message);//removing \r\n from the text
	
	if($tableType=="student")
	{
		$sql=mysql_query("SELECT *FROM student");//selecting all students 1-by-1
		while($row=mysql_fetch_array($sql))
		{
			$toEmail=$row['EmailAddress'];//posting Email of the student
			sendEmail($toEmail,$message);//sending Email to the student
		}
	}
		else
			if($tableType=="teacher")
			{
				$sql1=mysql_query("SELECT *FROM teacher");//selecting all teacher 1-by-1
				while($row1=mysql_fetch_array($sql1))
				{
					$toEmail=$row1['Email'];//posting Email of the teacher
					sendEmail($toEmail,$message);//sending Email to the teacher
				}
			}
				else
					if($tableType=="coordinator")
					{
						$sql2=mysql_query("SELECT *FROM coordinator");//selecting all coordinator 1-by-1
						while($row2=mysql_fetch_array($sql2))
						{
							$toEmail=$row2['Email'];//posting Email of the coordinator
							sendEmail($toEmail,$message);//sending Email to the coordinator
						}
					}
						else
							if($tableType=="attendent")
							{
								$sql3=mysql_query("SELECT *FROM attendent");//selecting all attendent 1-by-1
								while($row3=mysql_fetch_array($sql3))
								{
									$toEmail=$row3['Email'];//posting Email of the attendent
									sendEmail($toEmail,$message);//sending Email to the attendent
								}
							}
								else
									if($tableType=="parent")
									{
										$sql4=mysql_query("SELECT *FROM parentinfo");//selecting all parents 1-by-1
										while($row4=mysql_fetch_array($sql4))
										{
											$toEmail=$row4['EmailAddress'];//posting Email of the parents
											sendEmail($toEmail,$message);//sending Email to the parents
										}
									}
										else
										{
											//---------Student Messages----------//
											$sql=mysql_query("SELECT *FROM student");//selecting all students 1-by-1
											while($row=mysql_fetch_array($sql))
											{
												$toEmail=$row['Email'];//posting Email of the student
												sendEmail($toEmail,$message);//sending Email to the student
											}
											//---------Teacher Messages----------//
											$sql1=mysql_query("SELECT *FROM teacher");//selecting all teacher 1-by-1
											while($row1=mysql_fetch_array($sql1))
											{
												$toEmail=$row1['Email'];//posting Email of the teacher
												sendEmail($toEmail,$message);//sending Email to the teacher
											}
											//---------coordinator Messages----------//
											$sql2=mysql_query("SELECT *FROM coordinator");//selecting all coordinator 1-by-1
											while($row2=mysql_fetch_array($sql2))
											{
												$toEmail=$row2['Email'];//posting Email of the coordinator
												sendEmail($toEmail,$message);//sending Email to the coordinator
											}
											//---------attendant Messages----------//
											$sql3=mysql_query("SELECT *FROM attendent");//selecting all attendent 1-by-1
											while($row3=mysql_fetch_array($sql3))
											{
												$toEmail=$row3['Email'];//posting Email of the attendent
												sendEmail($toEmail,$message);//sending Email to the attendent
											}
										}
	redirect_to("sendemail.php?ErrorID=5");//redirectinf toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>
