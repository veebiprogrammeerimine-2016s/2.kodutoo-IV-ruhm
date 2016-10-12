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

	function cleanInput ($input) 
	{
// kustutab alguses ja lõpus olevad tühikud ära
		$input = trim($input);
// kustutab \ tagurpidi kaldkriipsud
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
// SAMA return htmlspecialchars(stripslashes($input(trim)));


	}

 ?>