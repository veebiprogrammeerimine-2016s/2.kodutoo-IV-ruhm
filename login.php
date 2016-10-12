<?php
	//var_dump($_GET);
	
	//echo "<br>";
	
	//var_dump($_POST);
	
	// $_POST["signupEmail"]
	
	// muutujad
	



	require("functions.php");
	
	
	/*if (isset($_SESSION["userId"])) {
		header("Location: data.php");
	}
	*/


	
	$signupEmailError = "";
	$loginEmailError = "";
	$loginPasswordError = "";
	$signupPasswordError = "";
	$emailErr = "";
	$signupPasswordError2 = "";
	$signupPasswordError3 = "";
	$signupEmail = "";
	$gender = "";
	$genderError = "";
	$mobileError = "";
	$mobile = "";
	$loginEmail = "";



	
	if (isset ($_POST["signupEmail"])) {
		if (empty($_POST["signupEmail"]))  {
			$signupEmailError = "<br><span style='color: red'>Täitke väli</span>";
		}
		
		elseif (!filter_var(($_POST["signupEmail"]), FILTER_VALIDATE_EMAIL) == true) {
					$emailErr = "<br><span style='color: red'>Sisestasite e-maili ebakorrektselt</span>"; 
		} else {
		
				$signupEmail = $_POST["signupEmail"];
		}
	}
	
	if (isset ($_POST["mobile"])) {
		if (empty($_POST["mobile"]))  {
			$mobileError = "<br><span style='color: red'>Täitke väli</span>";
		}
		
		else {
			
			
			$mobile = $_POST["mobile"];
		}
	}
	
	if (isset ($_POST["loginEmail"])) {
		
		if (empty($_POST["loginEmail"]))  {
			
			$loginEmailError = "<br><span style='color: red'>Sisesta e-mail</span>";
		}
		
	}
	
	if (isset ($_POST["loginPassword"])) {
		if (empty($_POST["loginPassword"]))  {
			
			$loginPasswordError = "<br><span style='color: red'>Parool jäi sisestamata</span>";
		}
	}
	
	if (isset ($_POST["signupPassword"])) {
		
		if (empty($_POST["signupPassword"]))  {
				$signupPasswordError = "<br><span style='color: red'>Täitke väli</span>";
				
		}	
		
		elseif (strlen($_POST["signupPassword"])<8) {
				$signupPasswordError2 = "<br><span style='color: red'>Parool peab olema vähemalt 8 tähemärki pikk</span>";
		
		}
		
		elseif (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,24}$/', ($_POST["signupPassword"]))) {
				$signupPasswordError3 = "<br><span style='color: red'>Parool peab sisaldama vähemalt ühte suurt tähte ja ühte numbrit</span>";
		}
		
		if (!isset ($_POST["gender"])) {
			
				$genderError = "<br><span style='color: red'>Vali sugu</span>";
			
		}	if (empty ($_POST["gender"])) {
				
				$genderError = "<br><span style='color: red'>Valige sugu</span>";
			} 
		
	}
	

	
	if ($signupEmailError == "" &&
		$signupPasswordError == "" &&
		$signupPasswordError2 == "" &&
		$signupPasswordError3 == "" &&
		$mobileError == "" &&
		$genderError == "" &&
		isset($_POST["signupEmail"]) &&
		isset($_POST["signupPassword"]) &&
	    isset($_POST["mobile"])&&
		isset($_POST["gender"])
		) 
	{
		
		
		$password = hash("sha512", $_POST["signupPassword"]);
		signup($signupEmail, $password, $mobile, $gender);
		
		
	}
	
	
	$notice = "";
	
	if(isset($_POST["loginEmail"])  &&
	   isset($_POST["loginPassword"]) &&
	   !empty($_POST["loginEmail"]) &&
	   !empty($_POST["loginPassword"])
	   ) {
		   
		  $notice = login($_POST["loginEmail"], $_POST["loginPassword"]); 
		  
	   }
	   
	 

	
	
	
	
	
	
	
	
?>

<!DOCTYPE html>
<html>

<link rel="stylesheet" type="text/css" href="login.css">


	<head>
		<title>Sisselogimine</title>
	</head>
	

	<body>
		
		<center><font color="white"><h1>Veebiprogrammeerimine</h1></font></center>
		
		<div class="form"><form name="log" id="log" method="POST" >
		<p style="color:red;"><?=$notice;?></p>
		
		<font color="white"><h2>Logi sisse</h2></font>
		
			<input name="loginEmail" value = "<?php if(isset($_POST['loginEmail'])) { echo $_POST['loginEmail']; } ?>" placeholder="E-mail" type="email" required/> <?php echo $loginEmailError;?>
			
			<br><br>
			
			<input name="loginPassword" placeholder="Parool" type="password" required/> <?php echo $loginPasswordError; ?>
			
			<br><br>
			
			<input type="submit" value="Logi sisse">
			

			
		</form></div>
		
		<br><br><br><br>
		
		<div class="form"><form name="reg" id="reg" method="POST" >
		<font color="white"><h1>Pole veel kasutajat?</h1></font>
		<font color="white"><h2>Loo kasutaja</h2></font>
			
			<input name="signupEmail" value="<?=$signupEmail;?>" placeholder="E-mail" type="email" required/> <?php echo $signupEmailError; echo $emailErr; ?>
			
			<br><br>
			
			<input name="signupPassword" placeholder="Parool" type="password" required/> <?php echo $signupPasswordError; echo $signupPasswordError2; echo $signupPasswordError3; ?>
			
			<br><br>
			
			<input name="mobile" placeholder="Telefoni number" type="tel" required/><?php echo $mobileError ?>
			<br><br>
			
			<table>
			<tr>
			<?php if ($gender == "f") { ?>
				<font color="white"><input type="radio" name="gender" value="f" checked> Female </font> 
			<?php } else { ?>
				<font color="white"><input type="radio" name="gender" value="f" required/> Female </font> 
			<?php } ?>
			
			<?php if ($gender == "m") { ?>
				<font color="white"><input type="radio" name="gender" value="m" checked> Male </font> 
			<?php } else { ?>
				<font color="white"><input type="radio" name="gender" value="m" required/> Male </font> 
			<?php } ?>
			<?php echo $genderError ?>
			
			</tr>
			</table>  

			<br>
			<input type="submit" value="Registreeri">
		</form></div>
		
		
		
	</body>
	
	
	

</html>