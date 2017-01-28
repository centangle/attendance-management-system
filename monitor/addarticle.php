<?php
	session_start();
	if (isset ($_SESSION['TeacherID']))//checking if session is already maintained
{
?>
<!--developed by Arslan Khalid -->
<!DOCTYPE html>	<!-- for supporting Html 5 tags -->

<html xmlns="http://www.w3.org/1999/xhtml"> <!-- according to standards of w3.ord -->
<head>
	<title> Article Details</title>	<!--title of the page -->
	<?php include"../common/library.php"; ?><!-- Common Libraries containg CSS and Java script files-->
	
	<!--function for validating the text area -->
	<script language="javascript" type="text/javascript">
	function imposeMaxLength(Object, MaxLen)
	{
	  return (Object.value.length <= MaxLen);
	}
	
	function validate()
	{
		var extensions = new Array();//creating an empty array

		extensions[0] = "rar";//filling array with extension
		extensions[1] = "zip";
		
		var _file = document.form.articleContent.value;//getting the value of the file
		var _length = document.form.articleContent.value.length;//getting the name length
		var pos = _file.lastIndexOf('.') + 1;//setting the position 
		var ext = _file.substring(pos, _length);//extracting the image extension
		var final_ext = ext.toLowerCase();//converting to lower alphabets letters for comparison

		for (i = 0; i < extensions.length; i++)
		{
			if(extensions[i] == final_ext)//comparing the extensions
			{
			return true;
			}
		}
		 
		alert("You must upload an image file with one of the following extensions: "+ extensions.join(', ') +".");//returning the error message
		return false;
	}
	</script>
</head>
<?php
		if(is_numeric($_GET['ErrorID']))//getting message ids from action file
		$error=$_GET['ErrorID'];//posting it to a variable after checking is it numeric or not
		switch($error){
			case 1://message 1 case
				echo'<script type="text/javascript">alert("Error: Empty Fields are not Allowed.");</script>';//showing the alert box to notify the message to the user
				break;
			case 2://message 2 case
				echo'<script type="text/javascript">alert("Error: Invalid File Size/Extention.");</script>';//showing the alert box to notify the message to the user
				break;
			case 3://message 8 case
				echo'<script type="text/javascript">alert("Success: Article added successfully.");</script>';//showing the alert box to notify the message to the user
				break;
		}
?>

<body>
	<?php include"teacherheader.php"; ?><!--side bar menu for the Student -->
		<?php 				
			include_once("../common/commonfunctions.php"); //including Common function library
			include_once("../common/config.php"); //including Common function library
			
			$profileID=$_SESSION['TeacherID'];//unsafe variable
			$id=clean($profileID);//cleaning id to preven SQL Injection
			
			$unsafe="RegisterCourse";
			$courseAllotment=clean($unsafe);
			
			$unsafe="Close";
			$status=clean($unsafe);
			
			$res = mysql_query("SELECT * FROM `criteria` WHERE `Entity` ='$courseAllotment' AND `Value`='$status'");//SELECTING THE user records 
			$row = mysql_fetch_array($res);//fetching record as a set of array of selected user
			if($row)
			{
		?>	
	
	<form method="POST"  name="form" enctype="multipart/form-data" action="insertarticledetails.php" onSubmit="return validate();"><!-- Add article details Form-->
	<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting"> <!-- for alignment of the form -->
		<tr>
			<td colspan="4"> 
				<hr/>	
				<h2 align="center">Add Article Details</h2>
				<hr/>
			</td>
		</tr>
		<tr>
			<td style="font-weight:bold; font-size:15px;">Title:<font color="red">*</font></td>
			<td> 
				<input type="text" name="articleTitle" id="articleTitle" placeholder="Enter title" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['ArtTitle'])) {$unsafe=$_SESSION['ArtTitle']; $lecTitle=clean($unsafe); echo $lecTitle; unset($_SESSION['ArtTitle']);}}?>" required /><!-- Taking input of title of the article-->
				&nbsp;<span><font color="grey">Max Length: 50</font></span>
				<!--error message color -->
				<style>
						.LV_invalid 
						{
							color: red;
						}
				</style>
				<!--live validation -->
				<script>
					var f12 = new LiveValidation('articleTitle');
					f12.add( Validate.Length, { maximum: 50 } );
				</script>
			</td>
			
			<td style="font-weight:bold; font-size:15px;">Recomended Student:<font color="red">*</font></td>
			<td> 
				<input type="text" name="articleWhom" id="articleWhom" placeholder="undergraduate students" value="<?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['ArtWhom'])) {$unsafe=$_SESSION['ArtWhom']; $whom=clean($unsafe); echo $whom; unset($_SESSION['ArtWhom']);}}?>" required /><!-- Taking input of about the recomended students-->
				&nbsp;<span><font color="grey">Max Length: 50</font></span>
				<!--error message color -->
				<style>
						.LV_invalid 
						{
							color: red;
						}
				</style>
				<!--live validation -->
				<script>
					var f12 = new LiveValidation('articleWhom');
					f12.add( Validate.Length, { maximum: 50 } );
				</script>
			</td>
		</tr>
		<tr>
			<td style="font-weight:bold; font-size:15px;">Description: <font color="red">*</font></td><!--Description of the lecture -->
			<td colspan="3">
				<textarea name="articleDetails" value="articleDetails" rows="3" cols="66" onkeypress="return imposeMaxLength(this, 200);" required><?php if(is_numeric($_GET['ErrorID'])) {session_start(); if(isset($_SESSION['ArtDetails'])) { $unsafe=$_SESSION['ArtDetails']; $lecDetail=clean($unsafe); $lecDetail=str_replace('\r\n', ' ',$lecDetail); echo $lecDetail; unset($_SESSION['ArtDetails']);}}?></textarea>
				&nbsp;<span><font color="grey">Max Characters: 200</font></span>
			</td>
		</tr>
		<tr>
			<td style="font-weight:bold; font-size:15px;">Content: <font color="red">*</font></td>
			<td colspan="2">
				<input class="specialInput" type="file" name="articleContent" id="articleContent" required /><!--getting Input file -->
				<span><font color="grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hint: (.rar|.zip) MaxSize: 
				<?php
					$sql=mysql_query("SELECT *FROM criteria WHERE Entity='UploadFileSize'");//getting the upload file size criteria
					$row=mysql_fetch_array($sql);
					echo $row['Value']." MB";
				?></font></span>
			</td>
		</tr>
		<tr>
			<td colspan="4" align="center">
				<input type="submit" value="Submit"/> | <button type="reset">Reset</button>
				<hr/>
			</td>
		</tr>
	</table>
	</form>
	<?php 
	}
	else{
	?>
	<div class="inlineSetting">
	<h4 class="alert_success"><?php echo "Course Registeration Open: Articles Option Is Currently Not Availiable."?></h4>
	</div>
	<?php }?>
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
