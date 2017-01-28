<?php
	session_start();
	if (isset ($_SESSION['CoordinatorID']))//checking if session is already maintained
{
?>
<!DOCTYPE html><!-- Html5 supported Pages -->

<html xmlns="http://www.w3.org/1999/xhtml">  <!-- according to standards of w3.org -->
<head>
	<title> View Result</title> <!--title of the page -->
	<?php include"../common/library.php"; ?><!-- common libraries includes CSS and java scripting -->
	
	<!-- Ajax function to Load Content -->
	<script>
		function loadoption(str, id){
			//alert(str);
			$.ajax({
			url: 'get_result.php?q='+str+'&sid='+id,
			success: function(data) {
			$('#result').html(data);
			//alert('Loaded.');
	  }
	});
	}
	</script>
	
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
	<?php 
		include"coordinatorheader.php";//<!--side bar menu for the Student -->
	    include_once("../common/commonfunctions.php"); //including Common function library
	    include_once("../common/config.php"); //including Database Connection library
		
		$profileID=$_GET['sid'];//unsafe variable
		$id=clean($profileID);//cleaning id to preven SQL Injection
		
		$result = mysql_query("SELECT student.Semester, discipline.TotalSemester FROM student JOIN discipline " .
								"ON student.DisciplineID = discipline.DisciplineID " .
								"WHERE student.StudentID='$id'"); // applying query to generate room numbers
		
		$rows = mysql_fetch_array($result);
		$totalSemester=$rows['Semester'] > $rows['TotalSemester'] ? $rows['TotalSemester'] + 1 : $rows['Semester'];
	?>
	<div class="inlineSetting">   
        <table>
			<tr>
				<td style="font-weight:bold; font-size:15px;">
					Select Semester:
				</td>
				<td>
					<select onchange="loadoption(this.value,<?php echo $id;?>);">
						<option selected>--Select--</option>
						<?php  //will return the list of rooms from database
							for($i=1; $i<=($totalSemester-1); $i++)
							{
							echo "<option value='$i'>Semester ".$i."</option>";//posting the value of the selected semester
							}
						?>
					</select>
				</td>
			</tr>
		</table>
    </div>
	
	<article class="module width_full">
			<header><h3>&nbsp;&nbsp;&nbsp;Semester Result:</h3></header>
			<div class="module_content">
				<div id="result">
						
				</div>
				<div class="clear"></div>
			</div>
	</article><!-- end of stats article -->
	<p align="center">
		<a href="viewstudentprofile.php?id=<?php echo $id;?>">
			<button>
				View Profile
			</button>
		</a>
	</p>
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
