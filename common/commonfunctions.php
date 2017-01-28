<?php
	//Developed by Arslan Khalid
	
	function redirect_to($location) //Redirecct funtion take page name and redirect toward its
		{
			if (!headers_sent($file, $line))
			{
				header("Location: " . $location);//setting the location on give page
			} else {
				printf("<script>location.href='%s';</script>", $location);//performing URL encoding 
				# or deal with the problem
					}
			printf('<a href="%s">Moved</a>', $location);//moving towards the given location
			exit;
		}
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str)
	{
			$str = @trim($str);//triming the extra character if added through invalid source
			if(get_magic_quotes_gpc())
			{
				$str = stripslashes($str);
			}
		return mysql_real_escape_string($str); //returing the safe variable back for SQL statement
	}
	
	function writelog($userType,$userID,$action)
	{
		//Getting date from the system
		$currentDate= date("d-n-o");
		//Sql query for inserting the actioninformation in log file
		$logSql="INSERT INTO `logfile`
						(`LogID`, `UserType`, `UserID`, `Date`, `Action`) 
						VALUES ('','$userType','$userID','$currentDate','$action')";
		mysql_query($logSql);//executing query
	}
	
	// check post values are set
	function checkPost($_post, $values)
	{
		$len = count($values);
		for($i = 0; $i < $len; $i++)
		{
			if(!isset($_post[$values[$i]])) return false;
			else if($_post[$values[$i]] == "") return false;
		}
		return true;
	}
	
	// check Text area Speacial
	function checkTexArea($_post, $values)
	{
		$len = count($values);
		for($i = 0; $i < $len; $i++)
		{
			if(!isset($_post[$values[$i]])) return false;
			else if($_post[$values[$i]] == "") return false;
		}
		return true;
	}
	
?>