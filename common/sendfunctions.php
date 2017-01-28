<?php
	function sendSMS($number,$message)
	{		include "smsGateway.php";		
			$smsGateway = new SmsGateway('arslan.khalid34@gmail.com', '1507cri102isb');		
			$deviceID = 36339;		
			$options = [		'send_at' => strtotime('+10 minutes'), // Send the message in 10 minutes		
			'expires_at' => strtotime('+1 hour') // Cancel the message in 1 hour if the message is not yet sent		
			];		
			//Please note options is no required and can be left out		
			$result = $smsGateway->sendMessageToNumber($number, $message, $deviceID, $options);		
	}
	
	function sendEmail($toEmail,$subjectText="MSIS Notification",$msg,$fromEmail="Admin@msis.com")
	{
		return;
		//Send Email to the Subscribed Users <Testing>----//
				$to=$toEmail;
				$subject=$subjectText;
				$message=$msg;
				$from=$fromEmail;
				$headers = "From:" . $from;
				mail($to,$subject,$message,$headers);
	}
?>