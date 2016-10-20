<?php
	require("../../config.php");
	//functions.php

	/*
	$nimi = "Krister";
	$perenimi = "Tarnamaa";
	function sum($x, $y) {
		
		return $x + $y;
		
	}
	
	echo sum(12312312,12312355553);
	echo "<br><br>";

	
	function tere($nimi, $perenimi) {
		return "Tere tulemast ".$nimi." ".$perenimi."!";
	}
	//echo "Tere tulemast: ".$nimi." ".$perenimi;
	echo tere("mina", "sina");
	*/
	//see fail peab olema siis seotud kõigiga, kus tahame sessiooni kasutada
	//saab kasutada nüüd $_SESSION muutujat.
	session_start();
	
	$database = "if16_kristarn";
	function signup($email, $password, $sugu, $auto) {
		
				 
				 $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
				 $stmt = $mysqli->prepare("INSERT INTO kodutoo_KrisTarn (email, password, sugu, lemmikauto) VALUE (?, ?, ?, ?) ");
				 
				 //asendan küsimärgid
				 //iga märgi kohta tuleb lisada üks täht - mis tüüpi muutuja on
				 // s - string
				 // i - int
				 // d - double
				 $stmt->bind_param("ssss", $email, $password, $sugu, $auto);
				 //t'ida käsku
				 if( $stmt->execute()){
					 echo "õnnestus";
				 } else {
						echo "<br>"."ERROR: ".$stmt->error;
					 
				 }	
		
	}
	
	function login($email, $password) {
	
				$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
				 $stmt = $mysqli->prepare("
				  
					SELECT id, email, password, sugu, Lemmikauto, created
					FROM kodutoo_KrisTarn
					WHERE email = ?
					
				 ");
				 
				 echo $mysqli->error;
				 
				 $stmt->bind_param("s", $email);
				
				//rea kohta tulba väärtus
				$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $suguFromDb, $autoFromDb, $created);
				
				$stmt->execute();
				
				//ainult SELECT'i puhul
				if($stmt->fetch()){
					//oli olemas, rida käes
					//kasutaja sisestas sisselogimiseks
					$hash = hash("sha512", $password);
					
					if ($hash == $passwordFromDb) {
						
						//oli sama
						echo"Kasutaja $id logis sisse";
						
						$_SESSION["userId"] = $id;
						$_SESSION["userEmail"] = $emailFromDb;
						
						header("Location: data.php");
						
					} else {
						
						//polnud sama
						$notice ="sitt parool";
						
					}
					
				} else {
					
					//ei olnud ühtegi rida
					$notice = "Sellise emailiga: ".$email."kasutajat ei ole olemas.";
				}
				return $notice;
	}
	
		function saveEvent($age, $color) {
		
				 
				 $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
				 $stmt = $mysqli->prepare("INSERT INTO Vile (age, color) VALUE (?, ?)");
				 
				 //asendan küsimärgid
				 //iga märgi kohta tuleb lisada üks täht - mis tüüpi muutuja on
				 // s - string
				 // i - int
				 // d - double
				 $stmt->bind_param("is", $age, $color);
				 //t'ida käsku
				 if( $stmt->execute()){
					 echo "õnnestus";
				 } else {
						echo "<br>"."ERROR: ".$stmt->error;
					 
				 }	
		
	}	
	
			function getAllPeople() {
				 
				 $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
		
				$stmt = $mysqli->prepare("
					SELECT id, age, color
					FROM Vile
				");
	
			$stmt->bind_result($id, $age, $color);
		
			$stmt->execute();
			
			$results = array();
			
			// tsüklit tehakse nii mitu korda, mitu rida sql lausega tuleb.			
			while ($stmt->fetch()) {
				
				$human = new StdClass();
				$human->id = $id;
				$human->age = $age;
				$human->Color = $color;
			
					//echo $color."<br>";
					array_push($results, $human);
					
			}
			
			return $results;
	}			
	
			function cleanInput($input) {
				
				// input = "  mina  "
				$input = trim($input);
				// input = "mina"
				
				//võtab välja \ tähemärgid
				$input = stripslashes($input);
				
				// html asendab ">" &gt -iga
				$input = htmlspecialchars($input);
				
				//otsib välja $inputis ";" ja kui on olemas muudab inputi "jamaks", mis ei lase lauset läbi.
				if (strpos($input, ';') > -1) {
				
				$input = "jama";
				
				return $input;
				
				} else {
				
				return $input;
				
				}
				
				
				
			}
	
	
	
	?>