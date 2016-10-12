<?php

	require("../../config.php");

	//see fail peab olema seotud kõigiga kus tahame sessiooni kasutada
	//saame nüüd kasutada $_SESSION muutujat
	session_start();

	$database = "if16_raitkeer";

	function signup($email, $password) {

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUE (?, ?)");
		
		//asendan küsimärgid
		//iga märgi kohta tuleb lisada üks täht - mis tüüpi muutuja on
		// s-string
		// i-int
		// d-double
		$stmt->bind_param("ss", $email, $password);
		
		//aitab leida viga eelmises käsus
		echo $mysqli->error;
		
		if ( $stmt->execute() ) {
			echo "õnnestus";
					
		} else {
			echo "ERROR ".$stmt->error;
			
		}
	}

	function login($email, $password) {
		
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
			SELECT id, email, password, created
			FROM user_sample
			WHERE email = ?
		
		");
		
		echo $mysqli->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//rea kohta tulba väärtus
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		
		//ainult SELECT'i puhul
		if($stmt->fetch()) {
			// oli olemas, rida käes
			//kasutaja sisestas sisselogimiseks
			$hash = hash("sha512", $password);
			
			if ($hash == $passwordFromDb) {
				echo "Kasutaja $id logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				header("Location: data.php");
				
				
			} else {
				$notice = "parool vale";
			}
			
			
		} else {
			
			//ei olnud ühtegi rida
			$notice = "Sellise emailiga ".$email." kasutajat ei ole olemas";
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $notice;
		
	}


	function colorEvent($vanus, $color) {

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO identTable (age, color) VALUE (?, ?)");
		echo $mysqli->error;
		//asendan küsimärgid
		//iga märgi kohta tuleb lisada üks täht - mis tüüpi muutuja on
		// s-string
		// i-int
		// d-double
		$stmt->bind_param("is",$vanus, $color);
		
		//aitab leida viga eelmises käsus
		
		
		if ( $stmt->execute() ) {
			echo "õnnestus";
					
		} else {
			echo "ERROR ".$stmt->error;
		}	
	}

	function getAllPeople () {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("SELECT id, age, color FROM identTable");
		
		$stmt->bind_result($id, $age, $color);
		
		$stmt->execute();
		
		$results = array();
		
		//tsükli sisu tehakse nii mitu korda, mitu rida SQL lausega tuleb
		while ($stmt->fetch()) {
			
			$human = new StdClass();
			$human->id = $id;
			$human->age = $age;
			$human->color = $color;
			
			//echo $color."<br>";
			
			array_push($results, $human);

		}
		
		return $results;
		
	}

	function cleanInput ($input) {
		
		//eemaldan algusest ja lõpust tühikud
		$input = trim($input);
		
		//võtab välja "\"
		$input = stripslashes($input);
		
		//html asendused nt.\ asemel unicode
		$input = htmlspecialchars($input);
		
		return $input;
		
	}












/*
Mitte just hea variant!

	function name($firstname, $lastname) {
		
		return $firstname . $lastname;
		
	}

	echo "Tere tulemast ". name("Rait ", "Keernik")."!";
	echo "<br>";
*/	

?>