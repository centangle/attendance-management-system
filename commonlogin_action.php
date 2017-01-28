<?php

	//Start session
	session_start();
	$loginType = $_POST['facultyCoordinator'];
	if($loginType=='coordinator')
	{
			//Include database connection details
			require_once('common/config.php');
			include_once("common/commonfunctions.php"); //including Common function library
			
			//Sanitize the POST values
			$login = clean($_POST['userLogin']);//posting vale to login variable after sanitizing
			$password = clean($_POST['userPassword']);

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
				redirect_to("clogin.php?msg=Invalid Email or Password");//retuning the error message back to the login page
				exit();//then exit
			}
			
			//Create query
			$qry="SELECT * FROM coordinator WHERE Username='$login' AND Password='$password'";
			$result=mysql_query($qry);
			$staffData=mysql_fetch_array($result);
			
			$staffID=$staffData['CoordinatorID'];
			
			if($staffID)
			{
				session_start ();
				$_SESSION['CoordinatorID']=$staffID;
				$_SESSION['Username']=$login;
				
				//Maintaining Log File Enteries
				$unsafeID=$staffID;
				$coordinatorID=clean($unsafeID);//ID of the coordinator who is performing task
				$msg=clean("Log in MSIS System through Website");//action which is performed
				$user=clean("Coordinator");//user type who performed the action
	
				writelog($user,$coordinatorID,$msg);//sending parameters to write log funtion which is in the common function library
				
				redirect_to("coordinator/index.php");
				exit;
			}
				else{
						redirect_to("clogin.php?msg=Invalid Email or Password");
						exit();
					}
	} else 
			if($loginType=='faculty')
	{
			//Include database connection details
			require_once('common/config.php');
			include_once("common/commonfunctions.php"); //including Common function library
			
			//Sanitize the POST values
			$login = clean($_POST['userLogin']);//posting vale to login variable after sanitizing
			$password = clean($_POST['userPassword']);

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
				redirect_to("clogin.php?msg=Invalid Email or Password");//retuning the error message back to the login page
				exit();//then exit
			}
			
			//Create query
			$qry="SELECT * FROM teacher WHERE Username='$login' AND Password='$password'";
			$result=mysql_query($qry);
			$facultyData=mysql_fetch_array($result);
			
			$facultyID=$facultyData['TeacherID'];
			
			if($facultyID)
			{
				session_start ();
				$_SESSION['TeacherID']=$facultyID;
				$_SESSION['Username']=$login;
				
				//Maintaining Log File Enteries
				$unsafeID=$facultyID;
				$teacherID=clean($unsafeID);//ID of the coordinator who is performing task
				$msg=clean("Log in MSIS System through Website");//action which is performed
				$user=clean("Teacher");//user type who performed the action
	
				writelog($user,$teacherID,$msg);//sending parameters to write log funtion which is in the common function library
				
				redirect_to("teacher/index.php");
				exit;
			}
			
				else{
						redirect_to("clogin.php?msg=Invalid Email or Password");
						exit();
					}
	} 
		else{
					//Include database connection details
			require_once('common/config.php');
			include_once("common/commonfunctions.php"); //including Common function library
			
			//Sanitize the POST values
			$login = clean($_POST['userLogin']);//posting vale to login variable after sanitizing
			$password = clean($_POST['userPassword']);

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
				redirect_to("clogin.php?msg=Invalid Email or Password");//retuning the error message back to the login page
				exit();//then exit
			}
				
				//Create query
				$qry="SELECT * FROM admin WHERE Username='$login' AND Password='$password'";
				$result=mysql_query($qry);
				$adminData=mysql_fetch_array($result);
				
				$adminID=$adminData['AdminID'];
				
				if($adminID)
				{
					session_start ();
					$_SESSION['AdminID']=$adminID;
					$_SESSION['Username']=$login;
					
					//Maintaining Log File Enteries
					$unsafeID=$adminID;
					$safeAdminID=clean($unsafeID);//ID of the coordinator who is performing task
					$msg=clean("Log in MSIS System through Website");//action which is performed
					$user=clean("Admin");//user type who performed the action
		
					writelog($user,$safeAdminID,$msg);//sending parameters to write log funtion which is in the common function library
					
					redirect_to("admin/index.php");
					exit;
				}
				
					else{
							redirect_to("clogin.php?msg=Invalid Email or Password");
							exit();
						}
			}
?>
