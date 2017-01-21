<?php
	
	//jäta email meelde kodutöö
	//tühjad väljad kohustuslikud
	//äkki muudad lemmikauto margi input type text-iks?
	
	require("functions.php");
	$notice="";
	if(isset($_SESSION["userId"])) {
	
	header("Location: data.php");
	
	}
	//var_dump($_GET);
	
	//echo "<br>";

	//var_dump($_POST);
	
	//muutujad
	$signupEmailError = "";
	$signupPasswordError = "";
	$LoginEmailError = "";
	$loginPasswordError = "";
	
		if (isset ($_POST["signupEmail"])){
		
		if (empty ($_POST["signupEmail"])) {
			
			$signupEmailError = "V2li on kohustuslik";
		}

	}
		if (isset ($_POST["SignupPassword"])){
		
		if (empty ($_POST["SignupPassword"])) {
			
			$signupPasswordError = "V2li on kohustuslik";
		} else {
		if (strlen($_POST["SignupPassword"])<8 ) {
			$signupPasswordError = "Parool peab olema vähemalt 8 tähemärki";
		}
	}
		}
	
		if ( $signupEmailError == "" && 
			 $signupPasswordError == "" && 
			 isset($_POST["signupEmail"]) &&
			 isset($_POST["SignupPassword"])
			 ) {
				 
				 //vigu ei olnud, kõik on olemas
				 echo "Salvestan...<br>";
				 $password = hash("sha512", $_POST["SignupPassword"]);
				 $signupEmail = $_POST["signupEmail"];
				 $sugu = $_POST["Gender"];
				 $auto = $_POST["Autosort"];
				 echo "email ".$signupEmail."<br>";
				 signup($signupEmail, $password, $sugu, $auto); //sugu ja auto siia! Config.php ja functions.php-le muudatused (uus andmebaas 'n shiz)!
			 }
			
		//kas kasutaja tahab sisse logida
				
		if (isset($_POST["LoginEmail"]) &&
			isset($_POST["loginPassword"]) &&
			!empty($_POST["LoginEmail"]) &&
			!empty($_POST["loginPassword"]) ) {
				$notice = login($_POST["LoginEmail"], $_POST["loginPassword"]);
			}
		
			
		
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title> Sisselogimise katsetamiseks leht</title>
	</head>
	<body>

		<h1> Sisselogimise leht</h1>
		<p style="color:red;"><?=$notice;?></p>
		<form method="POST">
			<label>E-post</label><br>
			<input name="LoginEmail" type="email"> <?php echo $LoginEmailError;?>
			
			<br><br>
			
			<input name="loginPassword" placeholder="Parool" type="password"> <?php echo $loginPasswordError;?>
		
			<br><br>
			<input type="submit" value = "Logi sisse">
			
		</form>
				<h1>Loo kasutaja</h1>
				<form method="POST">
			<label>Signup E-post</label><br>
			<input name="signupEmail" type="email"> 
			<?php echo $signupEmailError;?>
				
			<br><br>
			
			<input name="SignupPassword" placeholder="Parool" type="password"> <?php echo $signupPasswordError;?>
		
			<br><br>
			<input type="Radio" name = "Gender" value="Male" Checked>
			<label> Mees</label>
			<br>
			<input type="Radio" name = "Gender" value="Female">
			<label> Naine </label>
			<br>
			<input type="Radio" name = "Gender" value="The Dark Lord">
			<label> Meie tume isand Cthulu </label>
			<br><br>
			<label> Lemmik autosort? </label>
			<select name = "Autosort">
			  <option value="Volvo">Volvo</option>
			  <option value="Saab">Saab</option>
			  <option value="Mercedes">Mercedes</option>
			  <option value="Audi">Audi</option>
			</select>
			<br><br>
			<input type="submit" value = "Loo kasutaja">
			</form>
	</body>
</html>
	

