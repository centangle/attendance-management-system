<!-- Developed By Arslan Khalid -->
<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title> Student Documents</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
	<!-- Print Page Libraries -->
	 <script type="text/javascript" src="../js/lightbox/jquery.lightbox.js"></script>
	  <script type="text/javascript" src="../js/jquery.printPage.js"></script>
	  <script type="text/javascript">  
	  $(document).ready(function() {
		$(".btnPrint").printPage();
	  });
	  </script>
	  <!-- Libraries Print Page Ends Here -->
</head>
<body>
	<?php include"studentheader.php"; ?><!--side bar menu for the Student -->
						
						<?php
							if(is_numeric($_GET['ErrorID']))//getting message ids from action file
							$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
							switch($error){
								case 1://message 1 case
									echo'<script type="text/javascript">alert("Error: Invalid Extention/Size of SSC Image. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
								case 2://message 2 case
									echo'<script type="text/javascript">alert("Error: Invalid Extention/Size of HSSC Image. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
								/*
								case 3://message 3 case
									echo'<script type="text/javascript">alert("Error: JInvalid Extention/Size of GC Image. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
								case 4://message 4 case
									echo'<script type="text/javascript">alert("Error: Invalid Extention/Size of PGC Image. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
									break;*/
								case 5://message 5 case
									echo'<script type="text/javascript">alert("Success: Record Successfully Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
							}
						?>
	
	
		<?php 				
			include_once("../common/commonfunctions.php"); //including Common function library
			include_once("../common/config.php"); //including Common function library
			
			$unsafe=$_SESSION['StudentID']; //unsafe id
			$safeID=clean($unsafe);//cleaning the id for the prevention of SQL injection
			
			$res = mysql_query("SELECT FolderID FROM `studentfolder` WHERE `FolderID`='$safeID' LIMIT 1");//SELECTING THE user records who profile need to show
			$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
			
			if($row)
			{
		?>					
							<?php 	
									$res8 = mysql_query("SELECT *FROM `student` WHERE `StudentID`='$safeID'");//SELECTING THE user records who profile need to show
									$row8 = mysql_fetch_array($res8);//fetching record as a set of array of selected user
									//$directorName=$row8['CNICNo'];
									$res9 = mysql_query("SELECT *FROM `studentfolder` WHERE `FolderID` ='$safeID'");//SELECTING THE user records who profile need to show
									$row9 = mysql_fetch_array($res9);//fetching record as a set of array of selected user
									
							?>
	<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Educational Documents</h3></header>
			<div class="module_content">
								<table width="80%">
                                        <tr>
											<td>
												<label><h2>SSC Certificate: </h2></label>
											</td>
											
											<td>
												<img class="img-rounded" src="../userdocuments/student/<?php echo $safeID;?>/<?php echo $row9['SSC'];?>" alt="sscPic"/><!--Posting  Image-->
											</td>
											<td>
												<label><a class="btnPrint" href="ssc.php?pid=<?php echo $safeID;?>"><h2>Print</h2></a></label>
											</td>
										</tr>
										<tr>
											<td>
												<label><h2>HSSC Certificate: </h2></label>
											</td>
											
											<td>
												<img class="img-rounded" src="../userdocuments/student/<?php echo $safeID;?>/<?php echo $row9['HSSC'];?>" alt="hsscPic"/><!--Posting  Image-->
											</td>
											<td>
												<label><a class="btnPrint" href="hssc.php?pid=<?php echo $safeID;?>"><h2>Print</h2></a></label>
											</td>
										</tr>
										<!--
										<tr>
											<td>
												<label><h2>GC Certificate: </h2></label>
											</td>
											
											<td>
												<img class="img-rounded" src="../userdocuments/student/<?php //echo $safeID;?>/<?php //echo $row9['GC'];?>" alt="gcPic"/>											</td>
											<td>
												<label><h2>Print </h2></label>
											</td>
										</tr>
										<tr>
											<td>
												<label><h2>Post-Graduation Certificate: </h2></label>
											</td>
											
											<td>
												<img class="img-rounded" src="../userdocuments/student/<?php //echo $safeID;?>/<?php //echo $row9['PGC'];?>" alt="pgcPic"/>
											</td>
											<td>
												<label><h2>Print</h2></label>
											</td>
										</tr>-->
                                    </table>
                                
				<div class="clear"></div>
			</div>
	</article><!-- end of stats article -->
	
	<?php 
	}
	else{
	?>
	<div class="inlineSetting">
	<h4 class="alert_success"><?php echo "Upload the educational documents mentioned below"?></h4><!--Displaying the error message + displaying the Form for inserting the images -->
	</div>
	
	<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Required Documents</h3></header>
			<div class="module_content">
							<div>
								<form action="student_folder_action.php" method="POST" enctype="multipart/form-data"> <!-- Start of student Document upload form -->
                                    <table width="100%">
                                        <tr>
											<td>
												<label>SSC Certificate: <font color="red">*</font></label>
											</td>
											<td>
												<input class="specialInput" type="file" name = "studentImage" id="studentImage" required /><!--getting Input image -->
												<span><font color="grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hint: (*.png|*.jpeg) MaxSize:150KB</font></span>
											</td>
										</tr>
										<tr>
											<td>
												<label>HSSC Certificate: <font color="red">*</font></label>
											</td>
											<td>
												<input class="specialInput" type="file" name = "studentImage1" id="studentImage1" required /><!--getting Input image -->
												<span><font color="grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hint: (*.png|*.jpeg) MaxSize:150KB</font></span>
											</td>
										</tr>
										<!--
										<tr>
											<td>
												<label>Graduation Ceritficate: </label>
											</td>
											<td>
												<input class="specialInput" type="file" name = "studentImage3" id="studentImage3" required/>
												<span><font color="grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hint: (*.png|*.jpeg) MaxSize:150KB</font></span>
											</td>
										</tr>
										<tr>
											<td>
												<label>:Post-Graduation Certificate</label>
											</td>
											<td>
												<input class="specialInput" type="file" name = "studentImage4" id="studentImage4"/>
												<span><font color="grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hint: (*.png|*.jpeg|*.jpg) MaxSize:150KB</font></span>
											</td>
										</tr>-->
										<tr>
											<td colspan="2" align="center">
												<input type="submit" value="Submit"/>
											</td>
										</tr>
                                    </table>
								</form>
                            </div>
				
				<div class="clear"></div>
			</div>
	</article><!-- end of stats article -->
	
	<?php }?>
</body>

</html>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../studentlogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>
