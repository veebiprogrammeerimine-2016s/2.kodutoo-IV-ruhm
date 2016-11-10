<?php 
	
	
	
	require("functions.php");
	
	
	
	if (isset($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}
	

	$signupEmailError = "*";
	$signupEmail = "";
	
	if (isset ($_POST["signupEmail"])) {
		

		if (empty ($_POST["signupEmail"])) {
			
			// on tühi
			$signupEmailError = "* Required";
			
		} else {
			
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	} 
	
	$signupPasswordError = "*";
	
	if (isset ($_POST["signupPassword"])) {
		
		if (empty ($_POST["signupPassword"])) {
			
			$signupPasswordError = "* Väli on kohustuslik!";
			
		} else {
			
			// parool ei olnud tühi
			
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "* Parool peab olema vähemalt 8 tähemärkki pikk!";
				
			}
			
		}
		
		
		
	}
	
	$signupAgeError = "*";
	
	if (isset ($_POST["signupAge"])) {
		

		if (empty ($_POST["signupAge"])) {
			
			
			$signupAgeError = "* Required";
			
		}
		
	} 

	$signupNameError = "*";
	
	if (isset ($_POST["signupName"])) {
		

		if (empty ($_POST["signupName"])) {
			
			
			$signupNameError = "* Required";
			
		}
		
	} 
	
	if (isset ($_POST["signuplName"])) {
		

		if (empty ($_POST["signuplName"])) {
			
			
			$signupNameError = "* Required";
			
		}
		
	} 
	
	if (isset ($_POST["signupDName"])) {
		

		if (empty ($_POST["signupDName"])) {
			
			
			$signupNameError = "* Required";
			
		}
		
	} 
	
	if ( $signupEmailError == "*" AND
		 $signupPasswordError == "*" &&
		 $signupAgeError == "*" &&
		 $signupNameError == "*" &&
		 isset($_POST["signupEmail"]) && 
		 isset($_POST["signupPassword"]) &&
		 isset($_POST["signupAge"]) &&
		 isset($_POST["signupName"]) &&
		 isset($_POST["signuplName"]) &&
		 isset($_POST["signupDName"])
	  ) {
		
		
		echo "email ".$signupEmail."<br>";
		
		$signupAge = $_POST["signupAge"];
		$signupName = $_POST["signupName"];
		$signuplName = $_POST["signuplName"];
		$signupDName = $_POST["signupDName"];
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo $password."<br>";
		echo $signupAge;
		echo $signupName;
		echo $signupAge;
		
		$User->signup($signupEmail, $password, $signupAge, $signupName, $signuplName, $signupDName);
		
		
	}
	
	$notice = "";
	
	if ( isset($_POST["loginEmail"]) && 
		 isset($_POST["loginPassword"]) && 
		 !empty($_POST["loginEmail"]) &&
		 !empty($_POST["loginPassword"]) 
	) {
		
		$notice = $User->login($_POST["loginEmail"], $_POST["loginPassword"]);
		
	}

	

	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login Page</title>
	</head>
	<body>

		<h1>Log in</h1>
		<p style="color:red;"><?=$notice;?></p>
		<form method="POST" >
			
			<label>E-mail</label><br>
			<input name="loginEmail" type="email">
			
			<br><br>

			<input name="loginPassword" placeholder="Parool" type="password">
			
			<input type="submit" value="Logi sisse">
		
		</form>
		
		<h1>Loo kasutaja</h1>
		
		<form method="POST" >
			
			<label>E-post</label><br>
			<input name="signupEmail" type="email" value="<?=$signupEmail;?>"> <?php echo $signupEmailError; ?>
			
			<br><br>

			<input name="signupPassword" placeholder="Parool" type="password"> <?php echo $signupPasswordError; ?>
			
			<br><br>
			
			<input name="signupAge" type="number"> <?php echo $signupAgeError; ?>
			
			<br><br>
			
			<input name="signupName" placeholder ="First Name" type="name"> <?php echo $signupNameError; ?>
			
			<br><br>
			
			<input name="signuplName" placeholder="Last Name" type="name"> <?php echo $signupNameError; ?>
			
			<br><br>
			
			<input name="signupDName" placeholder="Username" type="name"> <?php echo $signupNameError; ?>
			
			<br><br>
			
			<input type="submit" value="Create Account">
		
		</form>

	</body>
</html>

