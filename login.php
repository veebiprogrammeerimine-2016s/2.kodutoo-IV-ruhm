

<?php
echo date("d.m.Y");
?>

<html>
<head>
<style type="text/css">
#clock {color:black;}


</style>
<script type="text/javascript">

function updateClock (){
  var currentTime = new Date ( );
  var currentHours = currentTime.getHours ();
  var currentMinutes = currentTime.getMinutes ();
  var currentSeconds = currentTime.getSeconds();
  currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;
  var timeOfDay = ''; 

  var currentTimeString = currentHours + ":" + currentMinutes + ':' + currentSeconds+ " " + timeOfDay;

  document.getElementById("clock").innerHTML = currentTimeString;
}

</script>
</head>

<body onLoad="updateClock(); setInterval('updateClock()', 1000 )">
<span id="clock">&nbsp;</span>
</body>

</html>

<h1 align="center">Kadunud ja leitud lemmikloomad</h1>

<?php 
	//var_dump($_POST);
	//var_dump(isset($_POST["signupEmail"]));
	
	
	require("functions.php");
	
	// kui on sisseloginud siis suunan data lehele
	if (isset($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}
	
	//var_dump($_GET);
	
	//echo "<br>";
	
	//var_dump($_POST);
	
	//MUUTUJAD
	$signupEmailError = "*";
	$signupEmail = "";
	
	//kas keegi vajutas nuppu ja see on olemas
	
	if (isset ($_POST["signupEmail"])) {
		
		//on olemas
		// kas epost on tühi
		if (empty ($_POST["signupEmail"])) {
			
			// on tühi
			$signupEmailError = "* Väli on kohustuslik!";
			
		} else {
			// email on olemas ja õige
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
				
				$signupPasswordError = "* Parool peab olema vähemalt 8 tähemärki pikk!";
				
			}
			
		}
		
		/* GENDER */
		
		if (!isset ($_POST["gender"])) {
			
			//error
		}else {
			// annad väärtuse
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
	
	
	
	
	if( isset($_POST["signupEmail"]) &&
	isset($_POST["signupPassword"])&&
	empty($signupEmailError) && 
	empty($signupPasswordError) 
	) 
	
	{	
		$password = hash("sha512", $_POST["signupPassword"]);	
		echo $password."<br>";
		signup($signupEmail, $password);	
	}
	
	$notice = "";
	//kas kasutaja tahab sisse logida
	if ( isset($_POST["loginEmail"]) && 
		 isset($_POST["loginPassword"]) && 
		 !empty($_POST["loginEmail"]) &&
		 !empty($_POST["loginPassword"]) 
	) {
		
		$notice = login($_POST["loginEmail"], $_POST["loginPassword"]);
		
	}
?>

<!DOCTYPE html>

<div align="center">

<html>
	<head>
		<title>Sisselogimise leht</title>
		<br><br><br><br><br><br><br><br><br><br><br><br>
		<style>	
	body {
		background-image:	url("http://www.lifestylepets.org/wp-content/uploads/2015/11/pet_composite-670x300.jpg");
		background-repeat: no-repeat;
		background-position: 50% 8%;
		background-attachment: fixed;
		}
</style>
	</head>
	<body>

		<h1>Logi sisse</h1>
		<p style="color:red;"><?=$notice;?></p>
		<form method="POST" >
			
			<label>E-post</label><br>
			<input name="loginEmail" type="email">
			
			<br><br>

			<input name="loginPassword" placeholder="Parool" type="password">
			
			<br><br>
			
			<input type="submit" value="Logi sisse">
		
		</form>
		
		
		<h1>Loo kasutaja</h1>
		
		<form method="POST" >
			
			<label>E-post</label><br>
			<input name="signupEmail" type="email" value="<?=$signupEmail;?>">
			<br><?php echo $signupEmailError; ?></br>
			
			<br>
			
			<input name="signupPassword" placeholder="Parool" type="password"> 
			<br><?php echo $signupPasswordError; ?></br>
			
			
		<p><label for="gender">Sugu:</label><br>
		<select name = "gender"  id="gender" required><br><br>
		<option value="">Näita</option>
		<option value="Mees">Mees</option>
		<option value="Naine">Naine</option>
		</select><br>
			
			
		<br>
		Sünnipäev:<br>
		<input type="date" name="birthday">
		<br><br>
	
			<input type="submit" value="Loo kasutaja">
		
		</form>
</div>
	</body>
</html>