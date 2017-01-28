<?php
	include_once("common/commonfunctions.php"); //including Common function library

	//Start session
	session_start();
					//Include database connection details
			require_once('common/config.php');
			
			$stSession=$_POST['studentSession']; //post value of session
			$stDicipline=$_POST['studentDicipline'];//posting value of dicipline
			$stRollNo=$_POST['studentRollNo'];//posting value of roll no
			
			$registerationNo= $stSession."-".$stDicipline."-".$stRollNo;
			
			//Sanitize the POST values
			$login = clean($registerationNo);//posting vale to login variable after sanitizing
			$password = clean($_POST['studentPassword']);
			
			//Input Validations
			if($login == '') //if no values has been posted
			{
				$errmsg_arr[] = 'Login ID missing';//setting the error message
				$errflag = true;//settign error flag true
			}
			if($password == '')//if no value has been posted
			{
				$errmsg_arr[] = 'Password missing';//Settiing the error message
				$errflag = true;//setting error flag true
			}
			
			//If there are input validations, redirect back to the login form
			if($errflag) //if error flag is true 
			{
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr; // puting the fla status n the session variable
				session_write_close();//closing the session
				redirect_to("parentlogin.php?msg=Invalid Login Details");//retuning the error message back to the login page
				exit();//then exit
			}
				
				//Create query
				$qry="SELECT * FROM student WHERE RegistrationNo='$login' AND XPassword='$password'";
				$result=mysql_query($qry);
				$studentData=mysql_fetch_array($result);
				
				$studentID=$studentData['StudentID'];
				
				if($studentID)
				{
					session_start ();
					$_SESSION['StudentID']=$studentID;
					$_SESSION['RegistrationNo']=$login;
					
										//Maintaining Log File Enteries
					$unsafeID=$studentID;
					$safeStudentID=clean($unsafeID);//ID of the coordinator who is performing task
					$msg=clean("Log in MSIS System through Website");//action which is performed
					$user=clean("Student");//user type who performed the action
		
					writelog($user,$safeStudentID,$msg);//sending parameters to write log funtion which is in the common function library
					
					redirect_to("parent/index.php");
					exit;
				}
				
					else{
							redirect_to("parentlogin.php?msg=Invalid Login Details");
							exit();
						}
?>
