
<?php
require("functions.php");
require("helper.class.php");
	$Helper = new Helper();
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	
	$locationError = "*"; 
	$uploadError = "*";
	$downloadError = "*";
	$pingError = "*";
	$deviceError = "*";
	$nameError = "*";

 
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
		
	}
	
	if (isset ($_POST["location"]))
		{
		if( empty ($_POST["location"])){
			$locationError = "Error";}
		}
	if (isset ($_POST["upload"]))
		{
		if( empty ($_POST["upload"])){
			$uploadError = "Error";}
		}
		if (isset ($_POST["download"]))
		{
		if( empty ($_POST["download"])){
			$downloadError = "Error";}
		}
	if (isset ($_POST["ping"]))
		{
		if( empty ($_POST["ping"])){
			$pingError = "Error";}
		}
	if (isset ($_POST["device"]))
		{
		if( empty ($_POST["device"])){
			$deviceError = "Error";}
		}
	if (isset ($_POST["name"]))
		{
		if( empty ($_POST["name"])){
			$nameError = "Error";}
		}
	
	
	

		if($locationError == "*"  &&
			$uploadError == "*"	&&
			$downloadError == "*"	&&
			$pingError == "*"	&&
			$deviceError == "*"	&&
			$nameError == "*"&&
			isset($_POST["location"]) &&
			isset($_POST["upload"]) &&
			isset($_POST["download"]) &&
			isset($_POST["ping"]) &&
			isset($_POST["device"]) &&
			isset($_POST["name"])) {
		
			
			$location = $_POST["location"];
			$upload = $_POST["upload"];
			$download = $_POST["download"];
			$ping = $_POST["ping"];
			$device = $_POST["device"];
			$name = $_POST["name"];
			echo $location;
			echo $upload;
			echo $download;
			echo $ping;
			echo $device;
			
			$data->dataentry ($Helper->cleanInput($location), $Helper->cleanInput($upload), 
			$Helper->cleanInput($download), $Helper->cleanInput($ping), $Helper->cleaninput($device), $Helper->cleanInput($name));
			header("Location: dataview.php");
	  }
		
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	



?>

<!DOCTYPE html>
<html>
	<h1>Data</h1>



	<p>
		Welcome <a href="user.php"><?=$_SESSION["userEmail"];?></a>!
		<br><br>
		<a href="?logout=1">Log out</a>
		
		
	</p>
		
	<h1>Input Information</h1>
		<form method="POST">
			
			<input name="location" placeholder="Location" type="location"> <?php echo $locationError ?>
			<br> <br>
			<input name="upload" placeholder="Upload speed in mb/s" type="number"> <?php echo $uploadError ?>
			<br> <br>
			<input name="download" placeholder="Download speed in mb/s" type="number"> <?php echo $downloadError ?>
			<br> <br>
			<input name="ping" placeholder="Ping/latency" type="number"> <?php echo $pingError ?>
			<br> <br>
			 
				<select name = "device"> <?php echo $deviceError ?>
					<option value="mobile">Mobile</option>
					<option value="computer">Computer</option>
				</select>
			<br> <br>
			<input name="name" placeholder="Name" type="name"> <?php echo $nameError ?>
			<br><br>
			<input type="submit" value="Submit">
		</form>

</html>




