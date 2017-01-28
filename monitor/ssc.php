
<?php 				
			include_once("../common/commonfunctions.php"); //including Common function library
			include_once("../common/config.php"); //including Common function library
			
			$unsafe=$_GET['pid']; //unsafe id
			$safeID=clean($unsafe);//cleaning the id for the prevention of SQL injection
			
	
			$res9 = mysql_query("SELECT *FROM `teacherfolder` WHERE `TeacherFolderID` ='$safeID'");//SELECTING THE user records who profile need to show		
			$row9 = mysql_fetch_array($res9);//fetching record as a set of array of selected user
	?>

	<img class="img-rounded" src="../userdocuments/teacher/<?php echo $safeID;?>/<?php echo $row9['SSC'];?>" alt="sscPic"/>

