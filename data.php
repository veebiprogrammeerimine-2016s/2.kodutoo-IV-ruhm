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
	
	
	if ( isset($_POST["age"]) && 
		 isset($_POST["color"]) && 
		 !empty($_POST["age"]) &&
		 !empty($_POST["color"]) 
	) {
		
		
		$color = cleanInput($_POST["color"]);
		
		saveEvent(cleanInput($_POST["age"]), $color);
	}
	
	$people = getAllPeople();
	
	echo "<pre>";
	var_dump($people[5]);
	echo "</pre>";
	
?>
<h1>Data</h1>

<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">Logi välja</a>
</p>

<h2>Salvesta sündmus</h2>
<form method="POST" >
	
	<label>Vanus</label><br>
	<input name="age" type="number">
	
	<br><br>
	<label>Värv</label><br>
	<input name="color" type="color">
	
	<br><br>
	
	<input type="submit" value="Salvesta">

</form>


<h2>Arhiiv</h2>

<?php 
	
	$html = "<table>";
	
		$html .= "<tr>";
			$html .= "<th>ID</th>";
			$html .= "<th>Vanus</th>";
			$html .= "<th>Värv</th>";
		$html .= "</tr>";
		
		//iga liikme kohta massiivis
		foreach ($people as $p) {
			
			$html .= "<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->age."</td>";
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
				
		echo "<p style ='  ".$style."  '>".$p->age."</p>";		
	 
	}
?>