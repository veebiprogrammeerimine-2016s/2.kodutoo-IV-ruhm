<?php 

	require ("../../config.php");

	session_start();
	$database = "if16_thetloff";

	function signup($email, $password) 
	{

		$mysqli = new mysqli(
			$GLOBALS["serverHost"], 
			$GLOBALS["serverUsername"], 
			$GLOBALS["serverPassword"], 
			$GLOBALS["database"]);

		$stmt = $mysqli->prepare("
			INSERT INTO mvp_161006 (email, password) VALUE (?, ?)");
		$stmt ->bind_param("ss", $email, $password);

		if ($stmt->execute() ) {
			echo "õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
	}

	function login($email, $password) 
	{
		$notice = "";

		$mysqli = new mysqli(
			$GLOBALS["serverHost"], 
			$GLOBALS["serverUsername"], 
			$GLOBALS["serverPassword"], 
			$GLOBALS["database"]);

		$stmt = $mysqli->prepare("
			SELECT id, email, password
			FROM mvp_161006
			WHERE email = ?");

		echo $mysqli->error;

		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $emailFormDb, $passwordFormDb);
		$stmt->execute();

		if ($stmt->fetch()) {
			$hash = hash ("sha512", $password);
			if ($hash == $passwordFormDb) {
				echo "kasutaja $id logis sisse";
				$_SESSION["userid"] =$id;
				$_SESSION["userEmail"] =$emailFormDb;
				header("Location: data_2.php");
				exit();
			} else {
				$notice = "parool on vale";
			} 
		} else {
			$notice = "sellise emailiga  ".$email."kasutajat ei ole olemas";
		}
		return $notice;
	}

	function saveEvent($place, $duration, $end_duration) 
	{
		$mysqli = new mysqli(
			$GLOBALS["serverHost"], 
			$GLOBALS["serverUsername"], 
			$GLOBALS["serverPassword"], 
			$GLOBALS["database"]);

		$stmt = $mysqli->prepare("
			INSERT INTO duration (user_id, place, duration, end_duration) VALUES (?, ?, ?, ?)");

		$stmt ->bind_param("isss", $_SESSION["userid"], $place, $duration, $end_duration);

		if ($stmt->execute() ) {
			echo "õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
	}

	function getAllPlayers ()
	{
		$mysqli = new mysqli(
			$GLOBALS["serverHost"], 
			$GLOBALS["serverUsername"], 
			$GLOBALS["serverPassword"], 
			$GLOBALS["database"]);
		$stmt = $mysqli->prepare("
			SELECT place, duration, end_duration
			FROM duration
			");

		$stmt->bind_result($place, $duration, $end_duration);
		$stmt->execute();

		$results = array();
		while ($stmt->fetch())	{
			$player = new StdClass();
			$player->place = $place;
			$player->duration = $duration;
			$player->end_duration = $end_duration;

			array_push($results, $player);
		}
		return $results;
	}

	function cleanInput ($input) 
	{
// kustutab alguses ja lõpus olevad tühikud ära
		$input = trim($input);
// kustutab \ tagurpidi kaldkriipsud
		$input = stripslashes($input);
		$input = htmlspecialchars($input);

		return $input;

	}

 ?>