# School & Attendance Management System

### Modules: ### 
Markup :  ### Attendance, Task & Quiz, Communication, Events & Announcements, Dynamic Timetable, Parent, Student, Teacher, Coordinator ###

School & Attendance Management System (SAMS) is developed as mobile and web based application. SAMS users’ can access their relevant information from anywhere and stay in contact with campus activities.

* The main functions of MSIS are mentioned below:
* Semester wise result of Student(s)
* Course and Teacher assessment
* Assignment, Lecture, Quizzes, Attendance		           		
* Allotment of Teachers 						
* Communication between Teacher and Student				
* Time tables (Teacher + Student)					
* Availability of resources (Online Lectures Links, course related helping links and research articles)						
* Mobile alerts
* Teacher and Student educational documents

### Configuring Server 
- Open Command Line and clone the project from (https://github.com/centangle/attendance-management-system.git) to 'wamp/www' Folder
```
git clone https://github.com/centangle/attendance-management-system.git
```
- After cloning the project in the 'wamp/www' folder go to project folder and configure the database connection 
```

### Configure Database Connection				
- Go to wamp/www/projectfolder/common/config.php and insert database & login details to link it with the Database (Database Query is available at 'wamp/www/projectfolder/common/DBQuery)'
```
database name : cent_school.sql
```
Import the 'sql' file content using 'phpmyadmin'
```

```	
	...................................................
	admin/
	common/
	Contents/	
	coordinator/  
	cronjob/
	css/							
	font/
	images/
	js/
	monitor/
	MPHP/
	parent/
	student/
	tableview/
	teacher/
	uploadimages/
	userdocuments/
	clogin.php
	common_functions.php
	commonlogin_actoin.php
	index.php
	LICENSE.MD
	monitorlogin.php
	monitorloginaction.php
	parentlogin.php
	parentlogin_action.php
	README.MD
	recover_facultypassword_action.php
	recover_password_action.php
	recover_passwordparent_action.php
	recoverfacultypassword.php
	recoverpassword.php
	recoverpasswordparent.php
	studentlogin.php
	studentlogin_action.php
	...................................................
```					

## How to access
- Go to http://localhost/attendance-management-system/index.php 
- Monitor Login =>  Usernmae: bilalghouri@msis.com | password : bilal
- Student Login =>  Usernmae: arslan | password : 1
- Teacher Login =>  Usernmae: bilalghouri@msis.com | password : bilal
- Coordinator Login => Username: arslankhd@msis.com | password: arslan
- 