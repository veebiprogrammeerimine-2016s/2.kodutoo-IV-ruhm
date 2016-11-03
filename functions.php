<?php 

	require("../../config.php");
	
	// see fail peab olema siis seotud kõigiga kusb
	// tahame sessiooni kasutada
	// saab kasutada nüüd $_SESSION muutujat
	session_start();
	
	$database = "if16_jsander";
	// functions.php
	
	function signup($email, $password, $phone, $gender) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, phone, gender) VALUE (?, ?, ?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ssss", $email, $password, $phone, $gender);
		
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
				//echo "ERROR";
				
				header("Location: data.php");
				exit();
				
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


	function saveEvent($email, $datestamp, $exercise, $sets, $reps, $weight) {

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("INSERT INTO workouts (email, datestamp, exercise, sets, reps, weight) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;

		$stmt->bind_param("sssiii", $_SESSION["userEmail"], $datestamp, $exercise, $sets, $reps, $weight);
        header("Location: data.php");

		if ( $stmt->execute() ) {
			echo "õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}

	}


    function getAllExercise() {

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("
			SELECT email, datestamp, exercise, sets, reps, weight
			FROM workouts WHERE email=?
		");
        $stmt->bind_param("s", $_SESSION["userEmail"]);
		$stmt->bind_result($email, $datestamp, $exercise, $sets, $reps, $weight);
		$stmt->execute();

		$results = array();

		// tsükli sisu tehakse nii mitu korda, mitu rida
		// SQL lausega tuleb
		while ($stmt->fetch()) {

			$human = new StdClass();
            $human->email = $email;
            $human->datestamp= $datestamp;
			$human->exercise = $exercise;
			$human->sets = $sets;
			$human->reps = $reps;
			$human->weight = $weight;


			//echo $color."<br>";
			array_push($results, $human);

		}

		return $results;

	}


	function cleanInput($input) {
		
		// input = "  romil  ";
		$input = trim($input);
		// input = "romil";
		
		// võtab välja \
		$input = stripslashes($input);
		
		// html asendab, nt "<" saab "&lt;"
		$input = htmlspecialchars($input);
		
		return $input;
		
	}

?>