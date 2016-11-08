<?php

	require("../../config.php");

	session_start();

	$database = "if16_raitkeer";


	function signup($email, $password, $firstName, $surname, $address) {

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_list (email, password, firstName, surname, address) VALUE (?, ?, ?, ?, ?)");
		
		$stmt->bind_param("sssss", $email, $password, $firstName, $surname, $address);
		
		if ( $stmt->execute() ) {
		}
	}

	function login($email, $password) {
		
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
			SELECT id, email, password, created
			FROM user_list
			WHERE email = ?
		
		");
		
		echo $mysqli->error;
		
		$stmt->bind_param("s", $email);
		
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		
		if($stmt->fetch()) {
			
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
			
			$notice = "Sellise emailiga ".$email." kasutajat ei ole olemas";
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $notice;
		
	}

	function saveApples($variety, $location, $quantity, $price) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO Apples (variety, location, quantity, price) VALUE (?, ?, ?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ssdd", $variety, $location, $quantity, $price);
		
		if ( $stmt->execute() ) {}
	}	
	
	
	function getApples () {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("SELECT id, variety, location, quantity, price FROM Apples");
		
		$stmt->bind_result($id, $variety, $location, $quantity, $price);
		
		$stmt->execute();
		
		$results = array();
		
		while ($stmt->fetch()) {
			
			$offer = new StdClass();
			$offer->id = $id;
			$offer->variety = $variety;
			$offer->location = $location;
			$offer->quantity = $quantity;
			$offer->price = $price;
			
			array_push($results, $offer);

		}
		
		return $results;
		
	}
	

	function cleanInput ($input) {
		
		$input = trim($input);
		
		//võtab välja "\"
		//$input = stripslashes($input);
		
		//html asendused nt.\ asemel unicode
		$input = htmlspecialchars($input);
		
		return $input;
		
	}


?>