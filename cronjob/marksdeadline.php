<?php
	
	include_once("../common/config.php"); //including DB Connection File
	include_once("../common/sendfunctions.php"); //including the SMS API and Mail Code
	
	$today=date('m/d/Y');//posting current date
	
	$result8=mysql_query("SELECT Value FROM `criteria` WHERE `Entity`='MarksDeadline'"); //checking the database Value
	$exist= mysql_fetch_row($result8); //executing the query
	
	$deadline=$exist[0];
	$dif=strtotime($deadline)-strtotime($today);
	
	if ($dif=="86400")
	{
		$sql1=mysql_query("SELECT *FROM teacher");
	
		$message="Sir/Madam: Tomorrow is Final Date for entering Marks for this semester\n after tommrow add/update marks option will be disabled.\nDepartment Coordinator";
		while($row1=mysql_fetch_array($sql1))
		{
			$number=$row1['MobileNumber'];
			sendSMS($number,$message);//sending message to Teachers
		}
		
		$msg="Tomorrow is Final Date for entering Marks for this semester\n So Change the CUD Criteria Tomorrow.\nDeadline Reminder";
		$sql2=mysql_query("SELECT *FROM coordinator");
		while($row2=mysql_fetch_array($sql2))
		{
			$num=$row2['MobileNumber'];
			sendSMS($num,$msg);//sending message to Coordinator to change the criteria
		}
		
	}
	
?>