<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!--html5 supported page -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title> Admin Dashboard</title>
	<?php include"../common/library.php"; ?><!--Common Libraries which includes CSS and Javascript -->
	<?php include"../common/tablelibrary.php"; ?><!-- View Table Sorter Related Liberaries -->
</head>

<body>
	<?php include"adminheader.php"; ?><!--sidebar menu for the administrator -->
	<table border="0" class="inlineSetting">
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td>
                        	<div class="da-panel collapsible">
                            	<div class="da-panel-header">
                                	<span class="da-panel-title">
                                        <img src="../images/list.png" alt="List" />
                                        <b>Log File Content</b>
                                    </span>
                                    
                                </div>
                                <div class="da-panel-content">
                                    <table id="da-ex-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>UserType</th>
												<th>Username</th>
                                                <th>Date</th>
                                                <th>Detail</th>
												<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											include_once('../common/config.php'); //including DB Connection File
											include_once("../common/commonfunctions.php"); //including Common function library
											
											$res=mysql_query("SELECT * FROM `logfile`"); // applying query to generate list of diciplines
											while($row = mysql_fetch_array($res))//will return the list of coordinators from database
												{
											?>
                                            <tr>
											   <td><?php echo $row['UserType'];?></td><!-- printing --> 
											   <td>
													<?php
														$table=strtolower($row['UserType']);//setting user type
														$desID=$row['UserID'];
														if($table=="admin")
														{
															$ser=mysql_query("SELECT * FROM `admin` WHERE AdminID='$desID'"); // applying query to generate diciplines name
															$rows = mysql_fetch_array($ser);//will return the username from database
															echo $rows['Username'];
														}
														else if ($table=="coordinator")
																{
																	$ser1=mysql_query("SELECT * FROM `coordinator` WHERE CoordinatorID='$desID'"); // applying query to generate diciplines name
																	$rows1 = mysql_fetch_array($ser1);//will return the username from database
																	echo $rows1['Username'];
																}
																else if($table=="student")
																		{
																			$ser2=mysql_query("SELECT * FROM `student` WHERE StudentID='$desID'"); // applying query to generate diciplines name
																			$rows2 = mysql_fetch_array($ser2);//will return the username from database
																			echo $rows2['RegistrationNo'];
																		}
																		else if($table=="attendent")
																		{
																			$ser2=mysql_query("SELECT * FROM `attendent` WHERE AttendentID='$desID'"); // applying query to generate diciplines name
																			$rows2 = mysql_fetch_array($ser2);//will return the username from database
																			echo $rows2['Username'];
																		}
																		else{
																				$ser3=mysql_query("SELECT * FROM `teacher` WHERE TeacherID='$desID'"); // applying query to generate diciplines name
																				$rows3 = mysql_fetch_array($ser3);//will return the username from database
																				echo $rows3['Username'];
																			}
													?>
												</td><!-- printing username name-->
												
												
												<td><?php echo $row['Date'];?></td> <!-- printing Date-->
												<td><?php echo $row['Action'];?></td><!-- printing Detail of Action-->
												<td>
													<a href="viewusersprofile.php?id=<?php echo $desID;?>&type=<?php echo $table?>">
													<img src="../images/ic_zoom.png"width="12" height="12" alt="view"></a>
												</td>
											</tr>
											<?php 
												}
											?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
			</td>
		</tr>
	</table>
</body>
</html>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../clogin.php?msg=Login First!");
		//include("clogin.php");
	}
?>
