<?php
	session_start();
	if (isset ($_SESSION['AdminID']))
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html><!--html5 supported page -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title> View Coordinator</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
	<?php include"../common/tablelibrary.php"; ?><!-- View Table Sorter Related Liberaries -->
	<!-- funtion for deleting a user from system-->
	 <script>
		function deleteuser(id)
		{
			var cnfrm=confirm("Are you sure you want to delete?");
			if(cnfrm)
			{
				window.location="deletecoordinator.php?delete_id="+id;
			}
		}
	</script>
</head>
<!--Start of Body Tag -->
<body>	
	<?php include"adminheader.php"; ?> <!-- Side Bar Menu for Administrator -->
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
                        	<div class="da-panel collapsible">
                            	<div class="da-panel-header">
                                	<span class="da-panel-title">
                                        <img src="../images/list.png" alt="List" />
                                        <b>List of Coordinators</b>
                                    </span>
                                </div>
                                <div class="da-panel-content">
                                    <table id="da-ex-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Username</th>
                                                <th>Mobile</th>
                                                <th>Email</th>
												<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											include_once('../common/config.php'); //including DB Connection File
											$res=mysql_query("SELECT * FROM `coordinator`"); // applying query to generate list of diciplines
											while($row = mysql_fetch_array($res))//will return the list of coordinators from database
												{
												$deleteID=$row['CoordinatorID']; //maintaing the Delete ID for deleting ny record
											?>
                                            <tr>
											   <td><?php echo $row['Name'];?></td><!-- printing name of coordinator -->
											   
											   <td>
													<?php
														$desID=$row['DepartmentID'];//setting discipline id
														$ser=mysql_query("SELECT * FROM `departments` WHERE DepartmentID='$desID'"); // applying query to generate diciplines name
														$rows = mysql_fetch_array($ser);//will return the list of coordinators from database
														echo $rows['Name'];
													?>
												</td><!-- printing discipline name-->
												
												<td><?php echo $row['Username'];?></td><!-- printing username--> 
												<td><?php echo $row['MobileNumber'];?></td> <!-- printing mobile-->
												<td><?php echo $row['Email'];?></td><!-- printing email-->
												<td><a href="updatecoordinator.php?id=<?php echo $row['CoordinatorID'];?>">
												<img src="../images/ic_edit.png" width="12" height="12" alt="Edit"></a>
												<!--
												<a href="#">
												<img src="../images/ic_cancel.png"width="12" height="12" alt="Cancel"></a>-->
												<a href="viewcoordinatorprofile.php?id=<?php echo $row['CoordinatorID'];?>"><img src="../images/ic_zoom.png"width="12" height="12" alt="View"></a>
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
		redirect_to("clogin.php?msg=Login First!");
	}
?>