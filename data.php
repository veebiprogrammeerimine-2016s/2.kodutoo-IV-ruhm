<?php
	//ühendan sessiooniga
	require("functions.php");
	
		// kui ei ole sisseloginud, suunan login lehele
		if(!isset($_SESSION["userId"])) {
			header("Location: login.php");
		}
	
		//kas aadressi real on logout
	if (isset($_GET["logout"])) {
		session_destroy();
		
		header("Location: login.php");
		
	}
	if ( isset($_POST["event"]) &&
	     isset($_POST["date"]) &&
		 !empty($_POST["event"]) &&
		 !empty($_POST["date"])
		 ) {
			 saveEvent($_POST["event"], $_POST["date"]);
			 }
			 
		$event = getAllEvents();
		//echo "<pre>";
		//var_dump($people);
		//echo "</pre>";
?>

<h1>Data</h1>

<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">logi välja</a>
	
</p>
<body>
	
		<h1>Salvesta andmed</h1>
		
		<form method="POST" >
		
			<label>ürituse nimi</label><br>
			<input type="text" name="event" >
			<br> <br>
			<label>kuupäev</label><br>
			<input type="date" name="date">
			<br> <br>
			<input type="submit" value="Salvesta">
		</form>

		
		<h2>Arhiiv</h2>

<?php
	$html = "<table>";
		
		$html .= "<tr>";
			$html .= "<th>ID</th>";
			$html .= "<th>üritus</th>";
			$html .= "<th>kuupäev</th>";
		$html .= "</tr>";
		
		foreach ($event as $e) {
			$html .= "<tr>";
			$html .= "<td>".$p->id."</td>";
			$html .= "<td>".$p->event."</td>";
			$html .= "<td>".$p->date."</td>";
		$html .= "</tr>";
			
		}
	
	
	
	$html .= "</table>";
	
	echo $html;
?>

