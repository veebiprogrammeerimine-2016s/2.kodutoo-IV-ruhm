<?php

	//Ühendan sessiooniga
	require("../../config.php");
	require("functions.php");

	
	//Kui ei ole sisse loginud, suunan login lehele
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
	}
	
	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: login.php");
	}
	
	if(isset($_POST["food"]) && 
	isset($_POST["kcal"]) &&
	isset($_POST["day"]) &&
	!empty($_POST["food"]) &&
	!empty($_POST["kcal"]) &&
	!empty($_POST["day"]))  {
		tabelisse2($_POST["food"], $_POST["kcal"], $_POST["day"]);
	}
	
	$foods = getAllFoods();
	
	/*
	echo "<pre>";
	var_dump ($people);
	echo "</pre>";
	*/
	
?>
<h1>Data</h1>

<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>
	<a href="?logout=1">Logi välja</a>
</p>
<br>

<form method="POST">
	<input name="food" placeholder="Toit" type="text"> <br><br>
	<input name="kcal" placeholder="Kcal" type="number"> <br><br>
	<input name="day" placeholder="Päev" type="text"> <br><br>
	<input type="submit" value="Sisesta andmed">
</form>

<h2>Arhiiv</h2>

<?php

	$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>ID</th>";
		$html .= "<th>Toit</th>";
		$html .= "<th>Kcal</th>";
		$html .= "<th>Päev</th>";
	$html .= "</tr>";

	//iga liikme kohta massiivis
	foreach ($foods as $f) {
		$html .= "<tr>";
			$html .= "<th>".$f->id."</th>";
			$html .= "<th>".$f->food."</th>";
			$html .= "<th>".$f->kcal."</th>";
			$html .= "<th>".$f->day."</th>";
		$html .= "</tr>";
	}
	$html .= "</table>";
	echo $html;
?>


<?php
	/*
	foreach($people as $p){
		
		$style = "
		
			background-color:".$p->lightColor.";
			width: 40px;
			height: 40px;
			border-radius: 20px;
			text-align: center;
			line-height: 39px;
			float: left;
			margin: 20px;
		
		";
		
		echo "<p style='".$style."'>".$p->age."</p>";
		
	}
	*/
?>















