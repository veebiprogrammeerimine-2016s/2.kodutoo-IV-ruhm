<?php 
	require("functions.php");
	
	//MUUTUJAD
	$food = $usernameError = $username = $birthday = "";
	
	// kas on sisseloginud, kui ei ole siis
	// suunata login lehele
	if (!isset ($_SESSION["userId"])) {
		header("Location: login.php");
		exit();	
	}
	
	//LOG OUT
	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	//USERNAME
	if (isset ($_POST["username"])) {
		if (empty ($_POST["username"])) {
		$usernameError = "* Väli on kohustuslik!";
	
		} else {
		if (strlen ($_POST["username"]) >18){
		$usernameError = "* Nickname ei tohi olla pikkem kui 18!";

		} else {
		$username = $_POST ["username"];
			}
		}
	}
	
	//KONTROLLIN,ET KÕIK ON OKEI JA VÕIB SALVESTADA
	if (isset($_POST["username"])&&
		isset($_POST["food"]) &&
		!empty($_POST["username"])&&
		!empty($_POST["food"])
		)
		
	{
	register_food($username,$_POST["birthday"],$_POST["food"],$_SESSION["userId"]);
	}
	
	
	$people = All_info();

?>

<html>
<p>
<h1>Salvesta andmed enda kohta</h1>
	Tere tulemast <?=$_SESSION["email"];?>!
	<a href="?logout=1">Logi välja</a>
</p>
<body>
<title>Registreerimise lõpp</title>


	
	<form method="POST">
	
	<p><label for="birthday">Kasutaja nimi:</label><br>
	<input name="username" type="text" placeholder="Kasutaja nimi" value=<?=$username;?>> 
	<br><font color="red"><?php echo $usernameError; ?></font>

	<p><label for="birthday">Sünnipäev:</label><br>
	<input name= "birthday" type="date" id="birthday" required>
	
	<p><label for="food">Vali oma lemmiku kööki:</label><br>
	<select name="food" id="food" required>
		<option value="">Näita</option>
		<option value="Abhaasia kook">Abhaasia köök</option>
		<option value="Australian kook">Australian köök</option>
		<option value="Austria kook">Austria köök</option>
		<option value="Aserbaidzaani kook<">Aserbaidžaani köök</option>
		<option value="Ameerika kook<">Ameerika köök</option>
		<option value="Araabia kook">Araabia köök</option>
		<option value="Argentiina kook">Argentiina köök</option>
		<option value="Armeenia kook">Armeenia köök</option>
		<option value="Valgevene kook">Valgevene köök</option>
		<option value="Bulgaaria kook">Bulgaaria köök</option>
		<option value="Brasiilia kook">Brasiilia köök</option>
		<option value="Ungari kook">Ungari köök</option>
		<option value="Havai kook">Havai köök</option>
		<option value="Hollandi kook">Hollandi köök</option>
		<option value="Kreeka kook">Kreeka köök</option>
		<option value="Gruusia kook">Gruusia köök</option>
		<option value="Taani kook">Taani köök</option>
		<option value="Juudi kook">Juudi köök</option>
		<option value="Iiri kook">Iiri köök</option>
		<option value="India kook">India köök</option>
		<option value="Inglise kook">Inglise köök</option>
		<option value="Itaalia kook">Itaalia köök</option>
		<option value="Hispaania kook">Hispaania köök</option>
		<option value="Kaukaasia kook">Kaukaasia köök</option>
		<option value="Hiina kook">Hiina köök</option>
		<option value="Korea kook">Korea köök</option>
		<option value="Kuuba kook">Kuuba köök</option>
		<option value="Lati kook">Läti köök</option>
		<option value="Leedu kook">Leedu köök</option>
		<option value="Mehhiko kook">Mehhiko köök</option>
		<option value="Moldaavia kook">Moldaavia köök</option>
		<option value="Mongoli kook">Mongoli köök</option>
		<option value="Saksa kook">Saksa köök</option>
		<option value="Norra kook">Norra köök</option>
		<option value="Poola kook">Poola köök</option>
		<option value="Portugali kook">Portugali köök</option>
		<option value="Rumeenia kook">Rumeenia köök</option>
		<option value="Vene kook">Vene köök</option>
		<option value="Tyrgi kook">Türgi köök</option>
		<option value="Ukraina kook">Ukraina köök</option>
		<option value="Soome kook">Soome köök</option>
		<option value="Prantsuse kook">Prantsuse köök</option>
		<option value="Tsehhi kook">Tšehhi köök</option>
		<option value="Rootsi kook">Rootsi köök</option>
		<option value="Soti kook">Šoti köök</option>
		<option value="Eesti kook">Eesti köök</option>
		<option value="Jaapani kook">Jaapani köök</option>
	</select>
	
	<br><br>
	<input type="submit" style="background-color:#A1D852; color:white;" value="Salvesta andmed">
	

</form>
</body>
</html>
<h2>Table</h2>
<?php 
	
$html = "<table>";
	
		$html .= "<tr>";
			$html .= "<th>ID</th>";
			$html .= "<th>Kasutaja</th>";
			$html .= "<th>Sünniaasta</th>";
			$html .= "<th>Köök</th>";
			$html .= "<th>TEST</th>";	
		$html .= "</tr>";
		
		//iga liikme kohta massiivis
		foreach ($people as $p) {
			
			$html .= "<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->username."</td>";
				$html .= "<td>".$p->birthday."</td>";
				$html .= "<td>".$p->food."</td>";
				$html .= "<td>".$p->user_id."</td>";	
			$html .= "</tr>";
		
		}
		
	$html .= "</table>";
	
	echo $html;
?>