<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>

<?php
	
		include_once("../common/config.php");		// including common functions
		include_once("../common/commonfunctions.php"); //including Common function library
		
		$profileID=$_SESSION['TeacherID'];//unsafe variable
		$id=clean($profileID);//cleaning id to preven SQL Injection
		$subjectIDs = json_decode($_GET["SubjectIDs"]);//decoding the subject ids in an array
		
		if($subjectIDs==NULL)
		redirect_to("viewofferedcourses.php?ErrorID=1");//redirect to viewoffered page if null value passed.. Server Side Validation
		
		//---------------Delete If Submitting List Again---------------//
		$sql=mysql_query("DELETE *FROM subjectofinterest WHERE TeacherID='$id'");
		$counts= count($subjectIDs);//total numbers of IDs selected by the teacher
			
		for($i=0; $i<$counts; $i++)
		{
			mysql_query("INSERT INTO `subjectofinterest`(`SubjectID`, `TeacherID`) VALUES ('$subjectIDs[$i]','$id')");
		}
		
		redirect_to("viewofferedcourses.php?ErrorID=2");
		?>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting toward login page if session is not maintained
	}
?>