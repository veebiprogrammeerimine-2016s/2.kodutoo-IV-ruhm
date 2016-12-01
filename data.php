<?php
	//ühendan sessiooniga 
	require("functions.php");
	
	$eventError = "*";
		
	if (isset ($_POST["event"])) {
			if (empty ($_POST["event"])) {
				$eventError = "*Sisesta ürituse nimi!";
			} else {
				$event = $_POST["event"];
		}
		
	} 
	
	$dateError = "*";
	
	if (isset ($_POST["date"])) {
			if (empty ($_POST["date"])) {
				$dateError = "*Sisesta kuupäev!";
			} else {
				$date = $_POST["date"];
		}
		
	} 
	
	$locationError = "*";
	
	if (isset ($_POST["location"])) {
			if (empty ($_POST["location"])) {
				$locationError = "*Sisesta ürituse asukoht!";
			} else {
				$location = $_POST["location"];
		}
		
	} 
	
	
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
		 isset($_POST["location"]) &&
		 !empty($_POST["event"]) &&
		 !empty($_POST["date"])&&
		 !empty($_POST["location"])
		 ) {
			 saveEvent (cleanInput($_POST["event"]), cleanInput($_POST["date"]), cleanInput($_POST["location"]));
			 
			 header("Location: data.php");
			 
			 }
			 
		$event = getAllEvents();
		//echo "<pre>";
		//var_dump($people);
		//echo "</pre>";
?>

<h1>Data</h1>

<p>
	Tere tulemast <a href="user.php"><?=$_SESSION["userEmail"];?></a>!
	<a href="?logout=1">logi välja</a>
	
</p>
<body>
	
		<h1>Salvesta andmed</h1>
		
		<form method="POST" >
		
			<label>ürituse nimi</label><br>
			<input type="text" name="event" > <?php echo $eventError; ?>
			<br> <br>
			<label>kuupäev</label><br>
			<input type="date" name="date"> <?php echo $dateError; ?>
			<br> <br>
			<input type="text" name="location"> <?php echo $locationError; ?>
			<br> <br>
			
			<input type="submit" value="Salvesta">
		</form>

		
		<h2>Arhiiv</h2>

<?php
	$html = "<table>";
		
		$html .= "<tr>";
			$html .= "<th>ID</th>";
			$html .= "<th>event</th>";
			$html .= "<th>date</th>";
			$html .= "<th>location</th>";
		$html .= "</tr>";
		
		foreach ($event as $e) {
			$html .= "<tr>";
			$html .= "<td>".$e->id."</td>";
			$html .= "<td>".$e->event."</td>";
			$html .= "<td>".$e->date."</td>";
			$html .= "<td>".$e->location."</td>";
		$html .= "</tr>";
			
		}
	
	
	
	$html .= "</table>";
	
	echo $html;
?>

