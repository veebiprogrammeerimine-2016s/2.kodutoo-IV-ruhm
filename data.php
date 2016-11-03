<?php
	//ühendan sessiooniga
	require("functions.php");

	//kui ei ole sisseloginud, suunan login lehele
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}

	//kas aadressireal on logout
	if (isset($_GET["logout"])) {

		session_destroy();

		header("Location: login.php");
		exit();

	}


	if ( isset($_POST["points"]) &&
		 isset($_POST["color"]) &&
		 !empty($_POST["points"]) &&
		 !empty($_POST["color"])
	) {


		$color = cleanInput($_POST["color"]);

		saveEvent(cleanInput($_POST["points"]), $color);
	}

	$people = getAllPeople();

	echo "<pre>";
	var_dump($people);
	echo "</pre>";

?>
<h1>Data</h1>

<?php echo$_SESSION["userEmail"];?>

<?=$_SESSION["userEmail"];?>

<p>
	Tere tulemast <a href="user.php"><?=$_SESSION["userEmail"];?></a>!
	<a href="?logout=1">logi välja</a>
</p>

<h1>Anna oma üürikorterile hinnang</h1>

<p>
	Palun anna oma endisele üürikorterile hinnang ühest kümneni
</p>

<form method="POST" >

	<label>Punktid (1-10)</label><br>
	<input name="points" type="number">

	<br><br>
	<label>Värv</label><br>
	<input name="color" type="color">

	<br><br>
	<label>Nimi</label><br>
	<input name="name" type="text">

	<br<br>

	<input type="submit" value="Salvesta">

</form>


<h2>Arhiiv</h2>

<?php


	$html = "<table>";

		$html .= "<tr>";
			$html .= "<th>ID</th>";
			$html .= "<th>points</th>";
			$html .= "<th>Värv</th>";
		$html .= "</tr>";

		//iga liikme kohta massiivis
		foreach ($people as $p) {

			$html .= "<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->points."</td>";
				$html .= "<td>".$p->lightColor."</td>";
			$html .= "</tr>";

		}

	$html .= "</table>";

	echo $html;

?>

<h2>Midagi huvitavat</h2>

<?php


	foreach($people as $p) {

		$style = "

		    background-color:".$p->lightColor.";
			width: 40px;
			height: 40px;
			border-radius: 20px;
			text-align: center;
			line-height: 39px;
			float: left;
			margin: 10px;
		";

		echo "<p style ='  ".$style."  '>".$p->points."</p>";

	}


?>
