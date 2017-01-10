<?php 
	
	require("functions.php");
	
	// SISSELOGIMISE PUHUL SUUNAMINE DATA LEHELE
	if (isset($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}
	
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	// MUUTUJAD
	$signupEmail = "";
	$signupEmailError = "*";
	$signupPassword = "*";
	$signupPasswordError = "*";
	$signupPhone = "";
	$signupPhoneError = "*";
	$loginSavedEmail = "";
	$gender = "";
	$genderError = "*";
	$loginEmailError = "";
	
	
	
	// SIGN UP EMAIL AND PASSWORD
	if (isset ($_POST["signupEmail"])) {
		if (empty ($_POST["signupEmail"])) {
			$signupEmailError = "* Väli on kohustuslik!";
		} else {
			$signupEmail = $_POST["signupEmail"];
		}
	} 
	
	if (isset ($_POST["signupPassword"])) {
		if (empty ($_POST["signupPassword"])) {
			$signupPasswordError = "* Väli on kohustuslik!";
		} else {
			// KONTROLL ET PAROOLIVÄLI POLNUD TÜHI
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				$signupPasswordError = "* Parool peab olema vähemalt 8 tähemärki pikk!";
			}
		}
	
	if (isset ($_POST["loginPassword"])) {
		if (empty ($_POST["loginPassword"])) {
			$loginError = "* Väli on kohustuslik!";
		}
	}
	
	
	// SIGN UP PHONENUMBER
	if (isset ($_POST["signupPhone"])) {
		if (empty ($_POST["signupPhone"])) {
			$signupPhoneError = "* Väli on kohustuslik!";
		} else {
			$signupPhone = $_POST["signupPhone"];
			}
		}
		
	/* GENDER */
		if (!isset ($_POST["gender"])) {
			//error
		}else {
			// annad väärtuse
		}
		
		
		if (isset ($_POST["gender"])) {
		
			$gender = $_POST["gender"];
			
		} else {
			$genderError = "* Väli on kohustuslik!";
		}
		
		
	}
	
	
	
	
	
	if ( $signupEmailError == "*" AND
		 $signupPasswordError == "*" &&
		 $genderError == "*" &&
		 isset($_POST["signupEmail"]) && 
		 isset($_POST["signupPassword"]) 
	  ) {
		
		//vigu ei olnud, kõik on olemas	
		echo "Salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo $password."<br>";
		
		signup($signupEmail, $password, $signupPhone, $gender);
	}
	
	$notice = "";
	//kas kasutaja tahab sisse logida
	if ( isset($_POST["loginEmail"]) && 
		 isset($_POST["loginPassword"]) && 
		 !empty($_POST["loginEmail"]) &&
		 !empty($_POST["loginPassword"]) 
	) {
		// login Autofill 
		$loginSavedEmail = $_POST["loginEmail"];
		$notice = login($_POST["loginEmail"], $_POST["loginPassword"]);
		}

	
?>



<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise leht</title>
	</head>
	<body>

		<h1>Logi sisse</h1>
		<p style="color:red;"><?=$notice;?></p>
		<form method="POST" >
		
			<input name="loginEmail" placeholder="E-post" type="email" value="<?=$loginSavedEmail;?>"> <?php echo $loginEmailError; ?>
			<br><br>

			<input name="loginPassword" placeholder="Parool" type="password">
			<br><br>
			
			<input type="submit" value="Logi sisse">
		
		</form>
		
		<h1>Loo kasutaja</h1>
		
		<form method="POST" >
			
			<input name="signupEmail" placeholder="E-post" type="email" value="<?=$signupEmail;?>"> <?php echo $signupEmailError; ?>
			<br><br>
			
			<input name="signupPassword" placeholder="Parool" type="password"> <?php echo $signupPasswordError; ?>
			<br><br>
			
			<input name="signupPhone" placeholder="Telefoni number" type="signupPhone" value="<?=$signupPhone;?>"> <?php echo $signupPhoneError; ?>
			<br><br>
			

			<?php if ($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked> female<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="female" > female<br>
			<?php } ?>
			
			<?php if ($gender == "male") { ?>
				<input type="radio" name="gender" value="male" checked> male<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="male" > male<br>
			<?php } ?>
			
			<?php if ($gender == "other") { ?>
				<input type="radio" name="gender" value="other" checked> other<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="other" > other<br>
			<?php } ?>
			
			 <?php echo $genderError; ?> <br><br>
			
			<input type="submit" value="Loo kasutaja">
		
		</form>

	</body>
</html>