<?php
	session_start();
	if (isset ($_SESSION['StudentID']))//checking if session is already maintained
{
?>

<?php
	//PHP Queries developed by Bilal Ahmad Ghouri
	
		include_once("../common/config.php");		// including common functions
		include_once("../common/queryfunctions.php"); //including Common function library
		include_once("../common/commonfunctions.php"); //including Common function library
		
		$profileID=$_SESSION['StudentID'];//unsafe variable
		$id=clean($profileID);//cleaning id to preven SQL Injection
		$res9 = mysql_query("SELECT * FROM `student` WHERE `StudentID` ='$id'");//SELECTING THE user records who profile need to show
		$row9 = mysql_fetch_array($res9);//fetching record as a set of array of selected user
		$studentSemester=$row9['Semester'];
		
		$subjectIDs = json_decode($_GET["SubjectIDs"]);
		if($_GET["SubjectIDs"] != "" || count($subjectIDs) != 0)
		{
			$sql=mysql_query("SELECT SUM(CreditHours) AS CreditHours FROM subject " .
												"WHERE SubjectID IN (" . implode(", ", $subjectIDs) . ")");
			$vals=GetAssoc($sql);
			$totalCreditHours = $vals["CreditHours"];
			
			$sql1=mysql_query("SELECT * FROM criteria WHERE Entity = 'MinCreditHours' OR Entity = 'MaxCreditHours'");
			
			while($row = mysql_fetch_assoc($sql1))
			{
				if($row["Entity"] == "MinCreditHours")
					$minCreditHours = $row["Value"];
				else
					$maxCreditHours = $row["Value"];
			}
			$sql2=mysql_query("SELECT discipline.TotalSemester, student.SectionID FROM discipline JOIN student " .
							"ON discipline.DisciplineID = student.DisciplineID " .
							"WHERE student.StudentID = '" . $id . "'");
			$row =GetAssoc($sql2);
			$totalSemester = $row["TotalSemester"];
			$sectionID = $row["SectionID"];
			
			if($totalCreditHours != 0)
			{
				if(((int)$totalCreditHours >= (int)$minCreditHours &&
					(int)$totalCreditHours <= (int)$maxCreditHours) ||
					$totalSemester < $studentSemester)
				{
					$sql5=mysql_query("DELETE FROM subjecttostudy WHERE StudentID = '" . $id . "'");
					$values = "";
					for($i = count($subjectIDs) - 1; $i >= 0; $i--)
					{
						$values .= "(" . $id. ", " . $subjectIDs[$i] . ", " . $sectionID . ")";
						if($i != 0) $values .= ", "; 
					}
					$sql6=mysql_query("INSERT INTO subjecttostudy (StudentID, SubjectID, SectionID) VALUES " . $values);
					if(mysql_affected_rows($link) == 0)
						$output = array();
					else
						{	
							//Maintaining Log File Enteries
							$unsafeID=$_SESSION['StudentID'];
							$studentID=clean($unsafeID);//ID of the admin who is performing task
							$msg=clean("Register Courses For New Semester");//action which is performed
							$user=clean("Student");//user type who performed the action
							
							writelog($user,$studentID,$msg);//sending parameters to write log funtion which is in the common function library

							redirect_to("viewcourses.php?ErrorID=5");//redirecting toward register page
						}
				}
				else if((int)$totalCreditHours > (int)$maxCreditHours) 
						redirect_to("courseregisteration.php?ErrorID=1");//redirecting toward register page
					else redirect_to("courseregisteration.php?ErrorID=2");//redirecting toward register page
			}
		} else redirect_to("courseregisteration.php?ErrorID=3");//redirecting toward register page
?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../studentlogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>