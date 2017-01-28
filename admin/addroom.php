<?php
	session_start();
	if (isset ($_SESSION['AdminID']))//checking if session is already maintained
{
?>
<!-- Developed By: Arslan Khalid -->

<!DOCTYPE html> <!--html5 supported page -->

<html xmlns="http://www.w3.org/1999/xhtml"><!-- according to standards of w3.org -->
<head>
	<title>Add Room</title> <!-- Title of the Page -->
	<?php include"../common/library.php"; ?> <!-- Common Libraries which includes the CSS and Javascript files and functions -->
	<!-- Ajax function to Load Content -->
	<script>
		function loadoption(str){
			$.ajax({
			url: 'get_floors.php?q='+str,
			success: function(data) {
			$('#result').html(data);
			//alert('Loaded.');
	  }
	});
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
								case 1://message 5 case
									echo'<script type="text/javascript">alert("Error: Room Already Existed.");</script>';//showing the alert box to notify the message to the user
									break;
								case 2://message 1 case
									echo'<script type="text/javascript">alert("Error: Empty Fields are not allowed. No Record Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
								case 5://message 5 case
									echo'<script type="text/javascript">alert("Success: Record Successfully Inserted.");</script>';//showing the alert box to notify the message to the user
									break;
							}
						?>
	<div>   
        <h1 class="h1Special" >&nbsp;&nbsp;&nbsp;Add New Room</h1>
    </div>
    <div> <!-- Form Wizard for Registering a new Room -->
		<form action="add_room_action.php" method="POST"> <!-- Start of Add new room form -->
			<table border="0" cellpadding="0" cellspacing="0" class="inlineSetting"> <!-- for alignment of the form -->
				<tr>
					<td colspan="2"> 
						<hr/>	
						<h2 class="StepTitle" align="center">Room Information</h2>
						<hr/>
					</td>
				</tr>
				<tr>
					<td width="50%">
						<table>
							<tr>
								<td>
									<label>Room Code: <font color="red">*</font></label>
								</td>
								<td>
									<input type="text" name="newRoomCode" id="newRoomCode" placeholder="Enter room code" pattern="^[0-9][0-9]*$"required />
									&nbsp;<span><font color="grey">Hint: 208 or 003 or 102</font></span>
									<style>
										.LV_invalid {
														color: red;
													}
									</style>
									<script>
											var f4 = new LiveValidation('newRoomCode');
											f4.add( Validate.Numericality, { onlyInteger: true } );
											f4.add( Validate.Length, { maximum: 5 } );
									</script>
								</td>
							</tr>
							<tr>
								<td>
									<label>Academic Block: <font color="red">*</font></label>
								</td>
								<td>
									<select name="newRoomBlock" id="newRoomBlock"  onchange="loadoption(this.value);">
									<option>-Select-</option>
									<?php 
										include_once('../common/config.php'); //including DB Connection File
										$result = mysql_query("SELECT * FROM `block`"); // applying query to generate room numbers
										while($rows = mysql_fetch_array($result)) //will return the list of rooms from database
										{
										echo "<option value='$rows[BlockID]'>".$rows['Name']."</option>";
										}
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td>
									<label>Floor: <font color="red">*</font></label>
								</td>
								<td id="result">
									<select name="newRoomFloor"	>
									<option></option>
									</select>
								</td>
							</tr>
							<tr>
								<td>
									<label>Lab: <font color="red">*</font></label>
								</td>
								<td>
									<select name="newRoomLabInfo" id="newRoomLabInfo">
										<option value="0" selected>No</option>
										<option value="1">Yes</option>
									</select>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="Submit" height="30px"/> | <button type="reset">Reset</button><hr/>
					</td>
				</tr>
			</table>
		</form>
    </div>
</body>
</html>
<?php
}
else
	{
		include_once("../common/commonfunctions.php"); //including Common function library
		
		redirect_to("../clogin.php?msg=Login First!");//redirecting to login page if session is not maintained
	}
?>