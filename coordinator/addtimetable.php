<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title>Add TimeTable</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
	
	<link href="../css/select2.css" rel="stylesheet"/>
    <script src="../css/select2.js"></script>
	
	<!-- Ajax function to Load Content -->
	<script>
		function loadsemester(str){
			$.ajax({
			url: 'get_s.php?q='+str,
			success: function(data) {
			$('#res1').html(data);
			//alert('Loaded.');
	  }
	});
	}
	
	function loadsemesterA(str,val1,val2,val3){
			$.ajax({
			url: 'get_s.php?q='+str+'&sem='+val1+'&sec='+val2+'&sub='+val3,
			success: function(data) {
			$('#res1').html(data);
			//alert('Loaded.');
	  }
	});
	}
	
	function SetIndexValue(val, val1, val2, val3)
	{
		var cb,str;
		
		cb= document.getElementById("getD");
		cb.value=val;//setting the value of the combo box
		
		//cb= document.getElementById("getS");
		//cb.value=val1;//setting the value of the combo box
		
		str=cb.value;
		loadsemesterA(str,val1,val2,val3);	
	}
	</script>

</head>
	<?php
		if(is_numeric($_GET['ErrorID']))//getting message ids from action file
		$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
		switch($error){
			case 1://message 1 case
				echo'<script type="text/javascript">alert("Error: Empty Fields are not allowed.");</script>';//showing the alert box to notify the message to the user
				break;
			case 2://message 2 case
				echo'<script type="text/javascript">alert("Error: Values already Exists in Database.");</script>';//showing the alert box to notify the message to the user
				break;
			case 3://message 3 case
				echo'<script type="text/javascript">alert("Error: Slot is not available.");</script>';//showing the alert box to notify the message to the user
				break;
			case 5://message 5 case
				echo'<script type="text/javascript">alert("Success: Timetable has been Added successfully.");</script>';//showing the alert box to notify the message to the user
				break;
		}
	?>
<body>
	<?php include"coordinatorheader.php"; ?><!--side bar menu for the Student -->			
		<?php
			include_once("../common/commonfunctions.php"); //including Common function library
			include_once("../common/config.php"); //including Common function library
			
			$profileID=$_SESSION['CoordinatorID'];//unsafe variable
			$id=clean($profileID);//cleaning id to preven SQL Injection
			
			$unsafe="ShowTimetable";
			$showTimetable=clean($unsafe);
			
			$unsafe="Close";
			$status=clean($unsafe);
			
			$res = mysql_query("SELECT * FROM `criteria` WHERE `Entity` ='$showTimetable' AND `Value`='$status'");//SELECTING THE user records 
			$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
			if($row)
			{
		?>
	<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Add TimeTable</h3></header>
			<div class="module_content"><!-- Showing the list of option-->
				<div>
					<table width="100%" align="center">
						<tr>
							<td style="font-weight:bold; font-size:15px;">
								Dicipline: 
							</td>
							<td>
								<select name="discipline" id="getD" onchange="loadsemester(this.value);">
									<option selected>--Select--</option>
									<?php
									$result = mysql_query("SELECT *FROM coordinator WHERE CoordinatorID='$id'"); //select the records of the coordinator
									$rows = mysql_fetch_array($result);
									
									$unsafe=$rows['DepartmentID'];// posting Department ID
									$depID=clean($unsafe);
			
									$sql=("SELECT *FROM discipline WHERE DepartmentID='$depID'");
									$result1=mysql_query($sql);
									
									while($rows3 = mysql_fetch_array($result1)) //will return the list of names of department
									{
										echo "<option value='$rows3[DisciplineID]'>".$rows3['DisciplineName']."</option>";
									}
								?>
								</select>
							</td>
						</tr>
						
						<tr>
							<td style="font-weight:bold; font-size:15px;">
								Semester:
							</td>
							<td id="res1">
								<select name="semester" id="getS">
								</select>
							</td>
						</tr>
						
						<tr>
							<td style="font-weight:bold; font-size:15px;">
								Section:
							</td>
							<td id="res2">
								<select name="section">
								</select>
							</td>
						</tr>
						
						<tr>
							<td style="font-weight:bold; font-size:15px;">
								Subject:
							</td>
							<td id="res3">
								<select name="subject">
								</select>
							</td>
						</tr>
					</table>
				</div>
			</div>
	</article><!-- end of stats article -->
	<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;TimeTable Details</h3></header>
			<div class="module_content"><!-- Showing the list of options-->
				<div id="tab">
				
				</div>
			</div>
	</article><!-- end of stats article -->
		<?php 
			}
		else
			{
		?>
		<div class="inlineSetting">
		<h4 class="alert_success"><?php echo "Show TimeTable is Open. Change Criteria First!"?></h4>
		</div>
		<?php
			}
		?>
		
		<?php
			if($_GET['ids'])
			{
				$values= $_GET['ids'];//getting the ids for setting the index values
				$pieces = explode(",", $values);//breaking on the basis of , character
				$diciplineID=$pieces[0];//dicpline id
				$semesterNo=$pieces[1];//semster no
				$sectionID=$pieces[2];// section id
				$subjectID=$pieces[3]; // subject id
		?>
			<script>
				SetIndexValue(<?php echo $diciplineID;?>,<?php echo $semesterNo;?>,<?php echo $sectionID;?>,<?php echo $subjectID;?>);
			</script>
		<?php
			}
		?>
</body>

</html>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>
