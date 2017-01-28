<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html><!--html5 supported page -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title>Student Notifications</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
	<?php include"../common/tablelibrary.php"; ?><!-- View Table Sorter Related Liberaries -->
</head>
<!--Start of Body Tag -->
<body>	
	<?php include"coordinatorheader.php"; ?> <!-- Side Bar Menu for Administrator -->
						<?php
							if(is_numeric($_GET['ErrorID']))//getting message ids from action file
							$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
							switch($error){
								case 5://message 5 case
									echo'<script type="text/javascript">alert("Success: Message Delivered Successfully.");</script>';//showing the alert box to notify the message to the user
									break;
							}
						?>
	<table border="0" class="inlineSetting">
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td>
				<?php
					include_once('../common/config.php'); //including DB Connection File
					include_once("../common/commonfunctions.php"); //including Common function library
					
					$coodinatorID=$_SESSION['CoordinatorID'];
					$safeCID=clean($coodinatorID);
					$result = mysql_query("SELECT * FROM `coordinator` WHERE CoordinatorID='$safeCID'"); // applying query to generate list of diciplines
					$rows = mysql_fetch_array($result);//will return the list of record from database
						$getCoordinatorDiscipline=$rows['DepartmentID'];//setting the discipline ID in which coordinator can register students
				?>
				
				<div class="grid_4">
                        	<div class="da-panel collapsible">
                            	<div class="da-panel-header">
                                	<span class="da-panel-title">
                                        <img src="../images/list.png" alt="List" />
                                        <b>List of Students</b>
                                    </span>
                                </div>
                                <div class="da-panel-content">
                                    <table id="da-ex-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Registeration No</th>
                                                <th>CNIC</th>
                                                <th>Send SMS</th>
                                                <th>Send Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											//include_once('../common/config.php'); //including DB Connection File
											
											$allowedDiscipline= array();//creating an array for inserting list of disciplines
											$queryExp= mysql_query("SELECT * FROM `discipline` WHERE DepartmentID='$getCoordinatorDiscipline'");
											
											while($values=mysql_fetch_assoc($queryExp))
											{
												$allowedDiscipline[]=$values['DisciplineID'];
											}
											$res=mysql_query("SELECT * FROM `student` WHERE DisciplineID IN(".implode(",",$allowedDiscipline).")"); // applying query to generate list of diciplines
											while($row = mysql_fetch_array($res))//will return the list of coordinators from database
												{
												$deleteID=$row['StudentID']; //maintaing the Delete ID for deleting ny record
											?>
                                            <tr>
											   <td><?php echo $row['Name'];?></td><!-- printing name of student -->
											   
											   <td>
													<?php
														echo $row['RegistrationNo'];//setting registration number
													?>
												</td><!-- printing discipline name-->
												
												<td><?php echo $row['CNICNo'];?></td><!-- printing CNIC-->
												
												<td>
													<a href="sendnotification.php?id=<?php echo $row['StudentID'];?>">
														<img src="../images/ic_plus.png" width="16" height="16" alt="New">
														Add Details
													</a>
												</td><!-- printing icons-->
												<td>
													<a href="sendemail.php?id=<?php echo $row['StudentID'];?>">
														<img src="../images/ic_plus.png" width="16" height="16" alt="New">
														Add Details
													</a>
												</td><!-- printing icons-->
											</tr>
											<?php 
												}
											?>
                                        </tbody>
                                    </table>
									
                                </div>
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
		redirect_to("clogin.php?msg=Login First!");
		//include("clogin.php");
	}
?>