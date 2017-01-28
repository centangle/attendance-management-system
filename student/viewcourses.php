<?php
	session_start();
	if (isset ($_SESSION['StudentID']))
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html><!--html5 supported page -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title> View Courses</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
	<?php include"../common/tablelibrary.php"; ?><!-- View Table Sorter Related Liberaries -->
	
</head>
<!--Start of Body Tag -->
<body>	
	<?php include"studentheader.php"; ?> <!-- Side Bar Menu for Administrator -->
						<?php
							if(is_numeric($_GET['ErrorID']))//getting message ids from action file
							$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
							switch($error){
								case 5://message 5 case
									echo'<script type="text/javascript">alert("Registeration Compeleted. You can change the courses untill registeration is open.");</script>';//showing the alert box to notify the message to the user
									break;
							}
						?>
						
						<?php
							include_once("../common/config.php");		// including common functions
							include_once("../common/queryfunctions.php"); //including Common function library
							include_once("../common/commonfunctions.php"); //including Common function library
							
							// By Bilal Ahmad
							// Get the student current semester subjects
							
							$profileID=$_SESSION['StudentID'];//unsafe variable
							$id=clean($profileID);//cleaning id to preven SQL Injection
							
							// fetching subjects information save record in one array of subject and section
							$sql1=mysql_query("SELECT * FROM subjecttostudy WHERE StudentID = '" . "$id" . "'");
							if( mysql_num_rows($sql1) )
							{
								while($row = mysql_fetch_assoc($sql1)) $sts[] = $row;
								$subCount = count($sts);
								for($i = 0; $i < $subCount; $i++)
								{
									$res = array();
									$res["SubjectID"] = $sts[$i]["SubjectID"];
									$res["SectionID"] = $sts[$i]["SectionID"];
									
									// fetch subject record
									$sql2=mysql_query("SELECT Name,Code,CreditHours,Lab FROM subject WHERE SubjectID = '" . $res["SubjectID"] . "'");
									$row = mysql_fetch_assoc($sql2);
									//posting value of the selected subject
									$res["Name"] = $row["Name"];
									$res["Code"] = $row["Code"];
									$res["CreditHours"] = $row["CreditHours"];
									$res["Lab"] = $row["Lab"];
									
									$subjects[] = $res;
								}
							}
							else
								{
						?>
								<!-- if No Courses are registered -->
									<div class="inlineSetting">
									<h4 class="alert_success">:No Courses Registered: <a href="courseregisteration.php"><u>Click</u></a> to Register Courses.</h4>
									</div>
								<?php
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
                                        <b>List of Courses</b>
                                    </span>
                                </div>
                                <div class="da-panel-content">
                                    <table id="da-ex-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Course Name</th>
                                                <th>Code</th>
												<th>CreditHours</th>
												<th>Details</th>
                                            </tr>
                                        </thead>
										
                                        <tbody>
                                            <?php 
											$resCount=count($subjects);
											
											for ($i=0; $i<$resCount;$i++)
											{
											?>
												<tr>
												   <td>
														<?php echo $i+1;?>
												   </td>
												   <td>
														<?php echo $subjects[$i]['Name'];?>
												   </td>
												    <td>
														<?php echo $subjects[$i]['Code'];?>
												   </td>
												   <td>
														<?php echo "(".$subjects[$i]['CreditHours'].",".$subjects[$i]['Lab'].")";?>
												   </td>
													<td>
														<a href="coursedetails.php?id=<?php echo $subjects[$i]['SubjectID'];?>&sID=<?php echo $subjects[$i]['SectionID'];?>">
														<img src="../images/ic_zoom.png"width="16" height="16" alt="View"> View
														</a>
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
		redirect_to("../studentlogin.php?msg=Login First!");
	}
?>