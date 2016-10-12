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



	if (isset($_POST["color"]) &&
			isset($_POST["age"]) &&
			!empty($_POST["color"]) &&
			!empty($_POST["age"])
	) {

			$color = cleanInput($_POST["color"]);
			saveEvent(cleanInput($_POST["color"], $_POST["age"]), $color);
	}

	$people = getAllpeople();
	echo "<pre>";
	var_dump($people);
	echo "</pre>";

?>
<h1>Data</h1>

<?php echo$_SESSION["userEmail"];?>

<?=$_SESSION["userEmail"];?>

<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">logi välja</a>
</p>


	<form method= "POST" >
		<label>Choose color</label><br>
		<input name="color" type="color">

		<br><br>

		<label>Choose age</label><br>
		<input name="age" placeholder="age" type="number">

		<br><br>

		<input type="submit" value="Save">

	</form>

<h2>Arhiiv</h2>

<?php

 $html ="<table>";
 	$html .="<tr>";
		$html .="<th>ID</th>";
		$html .="<th>Vanus</th>";
		$html .="<th>Värv</th>";
	$html .="</tr>";
	//iga liikme kohta massiivis($people)
	foreach ($people as $p) {

		$html .="<tr>";
	 		$html .="<td>".$p->id."</td>";
	 		$html .="<td>".$p->lightcolor."</td>";
	 		$html .="<td>".$p->age."</td>";
	 	$html .="</tr>";

	}


 $html .="</table>";

 echo $html;


?>

<h2>Midagi huvitavat</h2>

<?php

 foreach($people as $p) {
	 $style = "

	 background-color:".$p->lightcolor.";
	 width: 40px;
	 height: 40px;
	 border-radius: 20px;
	 text-align: center;
	 line-height: 39px;
	 float: left;
	 margin: 20px;

	 ";

	 echo"<p style =' ".$style." '>".$p->age."</p>";
 }




?>
