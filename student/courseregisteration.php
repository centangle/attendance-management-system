<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title> Course Registeration</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
	<script>
		function IsValid(len)
		{
			var j = 0;
			var ids = Array();
			var idss = "";
			for(var i = 0; i<len; i++)
			{
				var cb = document.getElementById("chk_" + i);
				if(cb.checked == true)
				{
					ids[j++] = cb.name;
				}
			}
			
			if(j == 0)
				alert("Select cources first");
			else
			{
				
				for(var i = 0; i<ids.length; i++)
				{
					idss += ids[i];
					if(i != (ids.length - 1))
						idss += ",";
				}
				idss = "[" + idss + "]";
				var cnfrm=confirm("Are You Want to Submit Registeration?");
				if(cnfrm)
				{
					window.location="submitregisteration.php?SubjectIDs=" + idss;
				}
			}
		}
	</script>
</head>
						<?php
							if(is_numeric($_GET['ErrorID']))//getting message ids from action file
							$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
							switch($error){
								case 1://message 5 case
									echo'<script type="text/javascript">alert("Error: Maximum Credit Hours Limit is 22.");</script>';//showing the alert box to notify the message to the user
									break;
								case 2://message 2 case
									echo'<script type="text/javascript">alert("Error: Minimum Credit Hours Limit is 12.");</script>';//showing the alert box to notify the message to the user
									break;
								case 3://message 3 case
									echo'<script type="text/javascript">alert("Success: Course Registeration Submitted.");</script>';//showing the alert box to notify the message to the user
									break;
							}
						?>
<body>
	<?php include"studentheader.php"; ?><!--side bar menu for the Student -->
		<?php 				
			include_once("../common/commonfunctions.php"); //including Common function library
			include_once("../common/config.php"); //including Common function library
			
			$unsafe="RegisterCourse";
			$courseRegisteration=clean($unsafe);
			
			$unsafe="Open";
			$status=clean($unsafe);
			
			$res = mysql_query("SELECT * FROM `criteria` WHERE `Entity` ='$courseRegisteration' AND `Value`='$status'");//SELECTING THE user records 
			$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
			if($row)
			{
		
			$profileID=$_SESSION['StudentID'];//unsafe variable
			$id=clean($profileID);//cleaning id to preven SQL Injection
		?>
	<div class="inlineSetting">
	<h4 class="alert_success">:Course Registration is Open:</h4>
	</div>
	<div class="inlineSetting">
		<h4 class="alert_success">Registration Submitted. Previous list will be cancelled on submission of new list. <u><b><a href="viewcourses.php">View Courses</a></b></u>.</h4>
	</div>
	<?php 
		include_once("../common/queryfunctions.php"); //including Common function library
		
		$res1 = mysql_query("SELECT * FROM `student` WHERE StudentID='$id'");//SELECTING THE user records
		$row1 = mysql_fetch_array($res1);//fetching record as a set of array of selected user	
		$sutdentSemester=$row1['Semester'];
		
		// By Bilal Ahmad
		// Get the registration data
		
		$sql=mysql_query("SELECT Value FROM criteria WHERE Entity = 'SubjectRepeat'");//checking the repeate criteria
		$assocReturn= GetAssoc($sql);
		$repeatCriteria = $assocReturn['Value'];
		$sql=mysql_query("SELECT catalog.Semester, catalog.SubjectID, subjectstudied.StudentID AS SID FROM catalog LEFT OUTER JOIN subjectstudied " .
						"ON catalog.SubjectID = subjectstudied.SubjectID " .
						"WHERE (catalog.Semester < '" . $sutdentSemester . "' " .
						"AND (subjectstudied.SubjectID IS NULL " .
						"OR (subjectstudied.StudentID = '" .$id. "' " .
						"AND subjectstudied.Marks <= '" . $repeatCriteria . "')))" .
						"OR catalog.Semester = '" . $sutdentSemester . "'");
		$subjects = GetAll($sql);//Select the Subject from cata log after seeing which subject you have already studied depending upon the crieteria and show the next smester subjects for registeration
		
		$allowed = array();//creating an array
		$nullSIDs = array();//creating an array
		for($i = count($subjects) - 1; $i >= 0; $i--)
		{
			if($subjects[$i]["SID"] == null) $nullSIDs[] = $subjects[$i]["SubjectID"];
			$allowed[] = $subjects[$i]["SubjectID"];
		}
		if(count($allowed) != 0 && count($nullSIDs) != 0)
		{	
			$sql5=mysql_query("SELECT SubjectID FROM prereq WHERE SubjectID IN (" . implode(", ", $nullSIDs ) . ")" . 
														"AND PreReqID IN (" . implode(", ", $nullSIDs ) . ")");
			$notAllowedSIDs = GetColumnsArray("SubjectID",$sql5);
			$allowed = deleteItems($allowed, $notAllowedSIDs);
		}
		
		if(count($allowed) != 0)
		{
			$sql3=mysql_query("SELECT SubjectID, Name, Code, CreditHours, Lab FROM subject WHERE SubjectID IN (" . implode(", ", $allowed) . ")");
			$regSubjects = GetAll($sql3);
			$sql4=mysql_query("SELECT SubjectID FROM subjecttostudy WHERE StudentID = '" . $id . "'");
			$already = GetColumnsArray("SubjectID",$sql4);
			
			for($i = count($regSubjects)- 1; $i >= 0; $i--)
			{
				$res = array();
				for($j = count($subjects) - 1; $j >= 0; $j--)
				{
					if($subjects[$j]["SubjectID"] == $regSubjects[$i]["SubjectID"])
					{
						copyItems($res, $regSubjects[$i], array("SubjectID", "Name", "Code", "CreditHours"));
						$ch = (int)$res["CreditHours"];
						$ch = $regSubjects[$i]["Lab"] == "1" ? "(" . ($ch - 1) . ", 1)" : "(" . $ch . ", 0)";
						$res["CreditHours"] = $res["CreditHours"] . $ch;
						$res["Semester"] = $subjects[$j]["Semester"];
						$pos = array_search($regSubjects[$i]["SubjectID"], $already);
						$res["Exist"] = !($pos === false);
						$result[] = $res;
						break;
					}
				}
			}
		}
	?>
	<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Course Registeration List</h3></header>
			<div class="module_content"><!-- Showing the list of subject for the registeration-->
				<div>
					<table width="100%" align="center">
						<tr>
							<td><font color="black"><h4>Select</h4></font></td>
							<td><font color="black"><h4>Subject Name</h4></font></td>
							<td><font color="black"><h4>Subject Code</h4></font></td>
							<td><font color="black"><h4>Semester</h4></font></td>
							<td><font color="black"><h4>Credit Hours</h4></font></td>
						</tr>
						<tr><td colspan="5"><hr/></td></tr>
						<?php 
						$resCount=count($result);
						
						for ($i=0; $i<$resCount;$i++)
						{
						?>
							<tr>
							   <td>
									<input type="checkbox" name="<?php echo $result[$i]['SubjectID'];?>" id="chk_<?php echo $i;?>"/>
							   </td>
							   <td>
									<?php echo $result[$i]['Name'];?>
							   </td>
								<td>
									<?php echo $result[$i]['Code'];?>
							   </td>
							   <td>
									<?php echo $result[$i]['Semester'];?>
							   </td>
								<td>
									<?php echo $result[$i]['CreditHours'];?>
								</td>
							</tr>
						<?php
						}
						?>
						<tr>
							<td colspan="5"><hr/></td>
						</tr>
						<tr>
							<?php
								$result8=mysql_query("SELECT *FROM `criteria` WHERE Entity='MaxCreditHours' LIMIT 1");
								$exist1 = mysql_fetch_array($result8);
							?>
							<td>Min Credit Hours: <?php echo $exist1['Value'];?> </td>
							
							<td colspan="3" align="center">
								<a href="Javascript:IsValid(<?php echo $resCount;?>)"><button type="button">Submit</button></a>
							</td>
							<?php
								$result9=mysql_query("SELECT *FROM `criteria` WHERE Entity='MinCreditHours'");
								$exist2 = mysql_fetch_array($result9);
							?>
							<td>Min Credit Hours: <?php echo $exist2['Value'];?></td>
						</tr>
					</table>
				</div>
				<div class="clear"></div>
		</div>
	</article><!-- end of stats article -->
	<?php 
	}
	else{
	?>
	<div class="inlineSetting">
	<h4 class="alert_success"><?php echo "Course Registeration is Closed."?></h4>
	</div>
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
