<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html><!--html5 supported page -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title>View Student</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
	<?php include"../common/tablelibrary.php"; ?><!-- View Table Sorter Related Liberaries -->
	
	 <script><!-- funtion for deleting a user from system-->
		function deleteuser(id)
		{
			var cnfrm=confirm("Are you sure you want to delete?");
			if(cnfrm)
			{
				window.location="deletestudent.php?delete_id="+id;
			}
		}
	</script>
</head>
<!--Start of Body Tag -->
<body>	
	<?php include"coordinatorheader.php"; ?> <!-- Side Bar Menu for Administrator -->
						<?php
							if(is_numeric($_GET['ErrorID']))//getting message ids from action file
							$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
							switch($error){
								case 5://message 5 case
									echo'<script type="text/javascript">alert("Success: Record Successfully Inserted.");</script>';//showing the alert box to notify the message to the user
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
                                                <th>Mobile</th>
                                                <th>Email</th>
												<th width="13%">Action</th>
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
												<td><?php echo $row['MobileNumber'];?></td> <!-- printing mobile-->
												<td><?php echo $row['EmailAddress'];?></td><!-- printing email-->
												<td><a href="updatestudent.php?id=<?php echo $row['StudentID'];?>">
												<img src="../images/ic_edit.png" width="12" height="12" alt="Edit"></a><!--edit Page Refference -->
												<!--
												<a href="#">
												<img src="../images/ic_cancel.png"width="12" height="12" alt="Cancel"></a><!--Delete Page Refference -->
												
												<a href="viewstudentprofile.php?id=<?php echo $row['StudentID'];?>">
												<img src="../images/ic_zoom.png"width="12" height="12" alt="Cancel"></a><!--Delete Page Refference -->
												</td>
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