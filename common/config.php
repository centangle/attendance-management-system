<?php

    define('DB_HOST', 'localhost');
    define('DB_USER', 'Enter Username Here');
    define('DB_PASSWORD', 'Enter Password Here');
    define('DB_DATABASE', 'Enter Database Name Here');
    	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = true;
	
	//Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	//else {echo "Okay";}
	
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}
        	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	//Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}
	//else {echo "DB is connected";}
?>