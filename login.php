<?php


	require("functions.php");

	if (isset($_SESSION["userId"])) {
		
		header("Location: data.php");
		exit();
	}	
	
	
	//var_dump($_GET);
	
	//echo"<br>";
	
	//var_dump($_POST);
	
	//MUUTUJAD
	$signupEmail = "";
	$signupEmailError = "";
	
	//kas keegi vajutas nuppu ja see on olemas
	
	if (isset ($_POST["signupEmail"])) {
		
		//on olemas
		//kas epost on tühi	
		if (empty ($_POST["signupEmail"])) {
			
			//on tühi
			$signupEmailError="Väli on kohustuslik";
		} else {
			
			$signupEmail = $_POST["signupEmail"];
		}
	}
	
	$signupPasswordError = "";
	
	//kas keegi vajutas nuppu ja see on olemas
	
	if (isset ($_POST["signupPassword"])) {
		
		//on olemas	
		if (empty ($_POST["signupPassword"])) {
			
			//on tühi
			$signupPasswordError="Väli on kohustuslik";
		
		} else {
			
			//parool ei olnud tühi
			
			if ( strlen ($_POST["signupPassword"]) < 8 ) {
				
				$SignupPasswordError = "*Parool peab olema vähemalt 8 tähemärki pikk";
			}
		}
	}

	$firstNameError = "";
	
	//kas keegi vajutas nuppu ja see on olemas
	
	if (isset ($_POST["firstName"])) {
		
		//on olemas
		if (empty ($_POST["firstName"])) {
			
			//on tühi
			$firstNameError="Väli on kohustuslik";
		}
	}

	$surnameError = "";
	
	//kas keegi vajutas nuppu ja see on olemas

	if (isset ($_POST["surname"])) {
	
		//on olemas
		if (empty ($_POST["surname"])) {
			
			//on tühi
			$surnameError="Väli on kohustuslik";
		}
	}

	$addressError = "";
	
	//kas keegi vajutas nuppu ja see on olemas

	if (isset ($_POST["address"])) {
	
		//on olemas
		if (empty ($_POST["address"])) {
			
			//on tühi
			$addressError="Väli on kohustuslik";
		}
	}

	//vaikimisi väärtus
	$gender = "";
	
	if (isset ($_POST["gender"])) {
		if (empty ($_POST["gender"])) {
			$genderError = "* Väli on kohustuslik!";
		} else {
			$gender = $_POST["gender"];
		}
		
	} 

	
	
	if ( $signupEmailError == "" &&
		 $signupPasswordError == "" &&
		 isset($_POST["signupEmail"]) &&
		 isset($_POST["signupPassword"])
	
	) {
		
		//vigu ei olnud, kõik on olemas
		echo "Salvestan...<br>";
		echo "email " .$signupEmail. "<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
		
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo $password."<br>";
		
		signup($signupEmail, $password);
		
	}
	
	$notice = "";
	
	if ( isset($_POST["loginEmail"]) &&
		 isset($_POST["loginPassword"]) &&
		 !empty($_POST["loginEmail"]) &&
		 !empty($_POST["loginPassword"])
	) {
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
		<p style="color:red;" ><?=$notice;?></p>
		<form method="POST">
		
			<input name="loginEmail" placeholder="e-mail" type="email">
			
			<br><br>
			
			<input name="loginPassword" placeholder="Parool" type="password">
			
			<br><br>
			
			<input type="submit" value="Logi sisse">
		
		</form>
		
		<h1>Loo kasutaja</h1>

		<form method="POST">
		
			<input name="signupEmail" placeholder="e-mail" value="<?=$signupEmail;?>" type="email"> <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<input name="signupPassword" placeholder="Parool" type="password"> <?php echo $signupPasswordError; ?>
			
			<br><br>
			
		<h3>Sisesta oma nimi</h3>
		
			<input name="firstName" placeholder="First Name" type="text"> <?php echo $firstNameError; ?>
			
			<br><br>
			
			<input name="surname" placeholder="Surname" type="text"> <?php echo $surnameError; ?>
			
			<br><br>
	
		<h3>Sisesta oma asukoht</h3>
			
			<input name="address" placeholder="address" type="text"> <?php echo $addressError; ?>
			
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
			
			<input type="submit" value="Loo kasutaja">

		</form>
			
	</body>
</html> 
