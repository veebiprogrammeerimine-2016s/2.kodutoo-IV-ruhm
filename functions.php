<?php
	
	require("../../config.php");
	session_start();   
	
	$database = "if16_ksenbelo_4";
	//MUUTUJAD
	$email = $password = $signupSugu = "";
	$username = $birthday = $food = $userId = "";
	
	//REGISTREERIMINE
	function signup ($email,$password,$signupSugu) {
		$mysqli = new mysqli($GLOBALS["serverHost"],
		$GLOBALS["serverUsername"],
		$GLOBALS["serverPassword"],
		$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_food (email, password, gender) VALUES (?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("sss",$email, $password, $signupSugu);
		
		if ($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
	}
	
	//LOOGIMINE
	function login($email, $password){
		$mysqli = new mysqli($GLOBALS["serverHost"],
		$GLOBALS["serverUsername"],
		$GLOBALS["serverPassword"],
		$GLOBALS["database"]);	
		
		$stmt = $mysqli->prepare("
			SELECT id, email, password, created 
			FROM user_food
			WHERE email = ?
		");
		echo $mysqli->error;
		
		
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		if($stmt->fetch()) {
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb) {
				
				echo "kasutaja ".$id." logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["email"] = $emailFromDb;
				
				header("Location: data.php");
				exit();
				
			} else {
				$error = "parool vale";
			}
			
		} else {
	
			$error = "sellise emailiga ".$email." kasutajat ei olnud";
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $error;
		
	}
	
	//REGISTREERIMISE ANDMED
	function register_food($username, $birthday, $food){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);
		
		$stmt = $mysqli ->prepare("INSERT INTO user_food_finish (username, birthday, food, user_id) VALUE(?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("sssi", $username, $birthday, $food, $_SESSION["userId"]);
	
		if($stmt->execute() ) {
			
			echo "Õnnestus!","<br>";			
		
		}
	}
	
	function All_info(){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		SELECT id, username, birthday, food, user_id
		FROM user_food_finish 
		");
		
		$stmt->bind_result($id, $username, $birthday, $food, $user_id);
		$stmt->execute();
		
		$results = array();
		
		while ($stmt->fetch()) {
			
			$human = new StdClass();
			$human->id = $id;
			$human->username = $username;
			$human->birthday = $birthday;
			$human->food = $food;
			$human->user_id = $user_id;
			
			
			
			array_push($results, $human);	
		}
		
		return $results;
		
	}
	
	
	function cleanInput($input) {
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		return $input;
	}
?>