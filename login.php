<?php
	//võtab ja kopeerib faili sisu

	require("../../config.php");
	require("functions.php");
	
	if (isset ($_SESSION["userId"]))
	{	
		header("Location: data.php");
	}
	

	//MUUTUJAD
	$loginEmailError = $loginPasswordError = $loginEmail = "";
	$signupEmailError = $signupEmail = $signupPasswordError = "";
	
	//LOOGIMINE SISSE
	if (isset ($_POST["loginEmail"])) {
		if (empty ($_POST["loginEmail"])) {
		$loginEmailError = "* Väli on kohustuslik!";
		
	} else {
		//EMAIL ON KORRAS
		$loginEmail = $_POST ["loginEmail"];
		}
	}

	if (isset ($_POST["loginPassword"])) {
		if (empty ($_POST["loginPassword"])) {
		$loginPasswordError = "* Väli on kohustuslik!";
		
		} else {
			
		if (strlen ($_POST["loginPassword"]) <6)
		$loginPasswordError = "* Parool peab olema vähemalt 6 tähemärkki pikk!";
		}
	}

	
	$error = "";
	//KONTROLLIN,ET KÕIK ON OKEI JA VÕIB SISSELOOGIDA
	
	if(isset($_POST["loginEmail"]) && 
		isset($_POST["loginPassword"]) &&
		!empty($_POST["loginEmail"]) && 
		!empty($_POST["loginPassword"])
		)
		
	{
	$error =login($_POST["loginEmail"], $_POST["loginPassword"]);
	}

	
	
?>

<!DOCTYPE html>

<html>
		
	<head>
	<title>Sisselogimise leht</title>
		
		<center>
		<style>	
	body {
		background-image:	url("https://pp.vk.me/c636017/v636017905/28122/Jjn90hQPABY.jpg");
		background-repeat: no-repeat;
		background-position: left top;
		background-attachment: fixed;
		}
		
	.MVPborder {
		width: 450px;
		height: 125px;
		border:3px solid;
		border-color:#A1D852;
		margin: 20px;
		} 
		</style>
		</head>
		
		<body>
			<h1>Logi sisse</h1>
			<form method="POST" >
				
				<label></label><br>
				<?php echo $error; ?><br><br>
				<input name="loginEmail" type = "email" placeholder="E-post" value="<?=$loginEmail;?>">
				<br><font color="red"><?php echo $loginEmailError; ?></font></br>
					
				<input name="loginPassword" type = "password" placeholder="Parool"> 
				<font color="red"><br><?php echo $loginPasswordError;   ?></font></br>
					
				<input type="submit" style="background-color:#A1D852; color:white" value="Logi sisse">
				<input type="button" onClick="location.href='register.php'" style="background-color:#A1D852; 
				color:white" value="Loo uut kasutaja">

			</form>	
		</body>
		

</html>