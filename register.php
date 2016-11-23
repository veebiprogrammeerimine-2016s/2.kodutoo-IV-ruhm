<?php
	
	require("../../config.php");
	require("functions.php");

	//Muutujad
	$signupEmail = $signupPassword = $signupEmailError = $signupPasswordError = "";
	
	//REGISTREERIMINE
	//EMAIL
	if (isset ($_POST["signupEmail"])) {
		if (empty ($_POST["signupEmail"])) {
		$signupEmailError = "* Väli on kohustuslik!";
		} else {
		//KUI EMAIL ON KORRAS
		$signupEmail = $_POST["signupEmail"];
		}
	}

	
	//PAROOL	
	if (isset ($_POST["signupPassword"])) {
		if (empty ($_POST["signupPassword"])) {
		$signupPasswordError = "* Väli on kohustuslik!";
		} else {	
		}if (strlen ($_POST["signupPassword"]) <6)
		$signupPasswordError = "* Parool peab olema vähemalt 6 tähemärkki pikk!";
	}
	
	// KÕIK ON KORRAS
	if( isset($_POST["signupEmail"]) &&
		isset($_POST["signupPassword"]) &&
		empty($signupPasswordError)&&
		empty($signupEmailError)
	)
	
	{
	$signupPassword = hash("sha512", $_POST["signupPassword"]);
	signup($signupEmail, $signupPassword,$_POST["signupSugu"]);
	}
	
?>


<html>
	<h1>Loo kasutaja</h1>
	<form method="POST" >
	<label></label><br>	
		
		<input name="signupEmail" type = "email" placeholder="E-post" value="<?=$signupEmail;?>">
		<br><font color="red"><?php echo $signupEmailError; ?></font></br>
					
		<input name="signupPassword" type = "password" placeholder="Parool"> 
		<br><font color="red"><?php echo $signupPasswordError; ?></font></br>
		
		<p><label for="signupSugu">Sugu:</label><br>
		<select name = "signupSugu"  id="signupSugu" required><br><br>
		<option value="">Näita</option>
		<option value="Mees">Mees</option>
		<option value="Naine">Naine</option>
		</select><br><br>
				
		<input type="submit" style="background-color:#A1D852; color:white;" value="Loo kasutaja">
		<input type="button" onClick="location.href='login.php'" style="background-color:#A1D852; color:white;" value="Tagasi">

	</form>		
	
</html>