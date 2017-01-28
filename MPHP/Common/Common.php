<?php
	// By Bilal Ahmad
	//------------------------------------------
	// including connection class
	define("DIR_CONTENT", "../../Contents/");
	define("DIR_STUDENT_IMAGE", "../../uploadimages/student/");
	define("DIR_STUDENT_DOCUMENTS", "../../userdocuments/student/");
	define("DIR_ATTENDANT_IMAGE", "../../uploadimages/attendant/");
	define("DIR_TEACHER_IMAGE", "../../uploadimages/teacher/");
	define("EMAIL_SUBJECT_RECOVER", "MSIS: Password Recovery");
	define("FORMAT_DATE", "m/d/Y");
	define("FORMAT_TIME", "H:i");
	
	include_once("Connection.php");
	// this function weakly performes the verification of request
	// return weather requester is of our system or not
	function Verify($_post)
	{
		// requester send some identification code
		if(isset($_post["MSISVerificationCode"]))
		{
			// check code matches or not
			if($_post["MSISVerificationCode"] == "F3DJD6FFQ4XQTQFPGK478MDQ8")
				return;
		}
		throw new Exception("404 Page not found");
	}
	
	// echo the data in json form
	function jprint($data)
	{ print(utf8_decode_all(json_encode(utf8_encode_all($data)))); }
	// echo the success in json form 
	function jsuccess($data)
	{
		$output[][] = array("Success" => $data);
		jprint($output);
	}
	function jsuccessWithID($data, $id)
	{
		$output[][] = array("Success" => $data, "ID" => $id);
		jprint($output);
	}
	// echo the error in json form
	function jerror($data)
	{ 
		$output[][] = array("Error" => $data);
		print(json_encode($output));
	}
	// read file in bolock of bytes with encoding
	function getEncodedFile($name)
	{
		if(!file_exists($name))
			throw new Exception("File not exist");
		$str = base64_encode(file_get_contents($name));
		return $str;
	}
	// check post values are set
	function checkPost($_post, $values)
	{
		$len = count($values);
		for($i = 0; $i < $len; $i++)
		{
			if(!isset($_post[$values[$i]]))
				throw new Exception("404 Page not found");
		}
	}
	// check variable are are set
	function checkIsSet($varArr)
	{
		$len = count($varArr);
		for($i = 0; $i < $len; $i++)
		{
			if(!isset($varArr[$i]))
				return false;
		}
		return true;
	}
	// get column from table
	function getColumnArray($tbl, $columnArray)
	{
		$len = count($tbl) - 1;
		$clmn = array();
		while($len >= 0)
			$clmn[] = $tbl[$len--][$columnArray];
		return $clmn;
	}
	// get column from table
	function getColumnArrayIf($tbl, $column, $iColumn, $iValue)
	{
		$len = count($tbl) - 1;
		$clmn = array();
		while($len >= 0)
		{	
			if($tbl[$len][$iColumn] == $iValue)
				$clmn[] = $tbl[$len][$column];
			$len--;
		}
		return $clmn;
	}
	// new line
	function nl($i = 0)
	{
		while($i-- >= 0) echo "<br/>";
	}
	// insert log info in db
	function writeLog($connection, $userType, $userID, $action)
	{
		$connection->QueryWS("INSERT INTO logfile(UserType, UserID, Date, Action) VALUES " .
							"('" . $userType . "', " .
							"'" . $userID . "', " .
							"'" . date("d-n-o") . "', " .
							"'" . $action  . "')");
		if($connection->GetRowsEffected() == 0)
			throw new Exception("Unable to maintain log");
	}
	// delete items from array
	function deleteItems($trg, $src)
	{
		for($i = count($src) - 1; $i >= 0; $i--)
		{
			$pos = array_search($src[$i], $trg);
			unset($trg[$pos]);
		}
		return array_values($trg);
	}
	// copy items from array to an array
	function copyItems(&$trg, $src, $fields)
	{
		for($i = count($fields) - 1; $i >= 0; $i--)
		{
			$trg[$fields[$i]] = $src[$fields[$i]];
		}
		return array_values($trg);
	}
	// give assinment string arrays
	function makeAsignStrings($clns, $vals)
	{
		$strs = array();
		for($i = count($clns) - 1; $i >= 0; $i--)
		{
			if($vals[$i] == "true")
				$strs[] = $clns[$i] . " = b'1'";
			else if($vals[$i] == "false")
					$strs[] = $clns[$i] . " = b'0'";
				else
					$strs[] = $clns[$i] . " = '" . $vals[$i] . "'";
		}
		return array_values($strs);
	}
	// give assinment string arrays
	function makeAssocAsignStrings($dataArray, &$data)
	{
		$strs = array();
		$tempData = array();
		while ($val = current($dataArray))
		{
			if($val == "true")
				$strs[] = key($dataArray) . " = b'1'";
			else if($val == "false")
					$strs[] = key($dataArray) . " = b'0'";
				else
					$strs[] = key($dataArray) . " = '" . $val . "'";
			$tempData[key($dataArray)] = $val;
			next($dataArray);
		}
		$data = $tempData;
		return array_values($strs);
	}
	// Generates random password
	function getRandomPassword()
	{
		return "" + rand(55555, 99999);				// generates a random sequence of 5 digit
	}
	// gives us grade
	function getGrade($num)
	{
		if($num >= 90) return "A";
		if($num >= 85) return "A-";
		if($num >= 80) return "B+";
		if($num >= 75) return "B";
		if($num >= 70) return "B-";
		if($num >= 65) return "C+";
		if($num >= 60) return "C";
		if($num >= 55) return "C-";
		if($num >= 50) return "D";
		return "F";
	}
	// gives us grade
	function getGP($num)
	{
		if($num >= 90) return "4";
		if($num >= 85) return "3.7";
		if($num >= 80) return "3.3";
		if($num >= 75) return "3.0";
		if($num >= 70) return "2.7";
		if($num >= 65) return "2.3";
		if($num >= 60) return "2";
		if($num >= 55) return "1.7";
		if($num >= 50) return "1.3";
		if($num >= 60) return "2";
		if($num >= 55) return "1.7";
		if($num >= 50) return "1.3";
		return "F";
	}
	// gives us day name
	function getDay($num)
	{
		if($num == "0") return "Sunday";
		if($num == "1") return "Monday";
		if($num == "2") return "Tuesday";
		if($num == "3") return "Wednesday";
		if($num == "4") return "Thrusday";
		if($num == "5") return "Friday";
		if($num == "6") return "Saturday";
	}
	
	// **************************************************************************
	// from php documentation
	function utf8_encode_all($dat) // -- It returns $dat encoded to UTF8 
	{
		if (is_string($dat)) return utf8_encode($dat); 
		if (!is_array($dat)) return $dat; 
		$ret = array(); 
		foreach($dat as $i=>$d) $ret[$i] = utf8_encode_all($d); 
		return $ret; 
	} 
	// from php documentation
	function utf8_decode_all($dat) // -- It returns $dat decoded from UTF8 
	{ 
		if (is_string($dat)) return utf8_decode($dat); 
		if (!is_array($dat)) return $dat; 
		$ret = array(); 
		foreach($dat as $i=>$d) $ret[$i] = utf8_decode_all($d); 
		return $ret; 
	} 
	
	//****************************************************************************
	// send email
	function sendEmail($to,$subject,$msg)
	{
		//return;
		//Send Email to the Subscribed Users <Testing>----//
		$headers = "MSIS mail sercer";
		mail($to,$subject,$msg,$headers);
	}
	// send sms api code
	function sendSMS($number, $message)
	{
		//return;
		//$number = "03236233870";
		$verification_code="arsl@n";
		$query_string_var = array();
		$query_string_var['uname'] = "akhalid"; // Madatory : Username
		$query_string_var['transkey'] = "@khali#"; // Mandatory : Unique transaction Key
		
		$query_string_var['rno'] = $number; // Mandatory : Receivers Number
		$query_string_var['authcode'] = md5($query_string_var['transkey'].$verification_code.$query_string_var['rno']); // this is IMPORTANT
		$query_string_var['msg'] = $message; // Mandatory : SMS Text Message
		
		$query_string_var['details'] = "0"; // Optional: To get detailed Report
		$query_string_var['rmode'] = "no"; // Optional: Call back/return method remote page.
		
		//$query_string_var['rpath'] = "http://thetreehousepsychiatry.com/admin/add_appointment_actionrec.php"; // Optional: web address to return to
		$query_string_var['rpath'] = "http://localhost/SIS_Web/admin/registercoordinator.php"; // Optional: web address to return to
		$query_string_var['mode'] = "normal"; // Optional: for testing
		
		$query_string = '';
		foreach($query_string_var as $key=>$val) {
			$query_string .= $key.'='.urlencode($val).'&';
		}
		$query_string = substr($query_string, 0, -1); // removes the last '&' from the query string
		
		/*Checking if cURL extension is installed*/
		if  (!in_array  ('curl', get_loaded_extensions())) { return false;}
		else // if cURL is available - CONTINUE
		{

			$ch = curl_init('http://smsdakia.com/app/remote/post.sms');
			
			curl_setopt($ch, CURLOPT_POST, TRUE); // Comment this line to use the default GET method.
			curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Setting this option to 1,TRUE will cause the curl_exec function to return the contents instead of echoing them to the browser.
			$curl_result = curl_exec($ch);
			$curl_info = curl_getinfo($ch);
			$curl_err = curl_error($ch);
			curl_close($ch);
			
			/* Checking if the connection to the gateway was successfully established*/
			/*if( !$curl_err && !($curl_result === FALSE) && ($curl_info['http_code'] < 400) )
			{	
				include "response_descriptions.php";
				
				if($query_string_var['rmode']=="xml") // if Results are returned as a XML
				{
					$xml_response = new SimpleXmlElement($curl_result, LIBXML_NOCDATA);
					$response =get_object_vars($xml_response);
					if($response['errors']) return false;
					return true;
				}
				else // if Results are returned as a string
				{
					$result=explode("\r\n",$curl_result);
					
					foreach($result as $attribute)
					{
						$keyvalue=explode(":",$attribute);
						$response[$keyvalue[0]]=$keyvalue[1];
					}
					if($response['errors']) return false;
					return true;
				}
			} // CLOSING - if( !$curl_err && !($curl_result === FALSE) && ($curl_info['http_code'] < 400) )
			else { return false;}
			*/
		}// CLOSING - else of if  (!in_array  ('curl', get_loaded_extensions())) {
	} // Closing else of if(!sizeof($_POST) && !sizeof($_GET))
?>