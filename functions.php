<?php
	
	$database = "if16_greg_4";
	
	require("../../config.php");
	
	// see fail peab olema seotud kõigiga kus tahame sessiooni kasutada
	// saab kasutada nüüd $_SESSION muutujat.
	session_start();
	
	
	

	
	function signup($email, $password, $mobile, $gender) {
		$database = "if16_greg_4";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, mobile, gender) values (?, ?, ?, ?)");
		
		echo $mysqli->error;
		// s -string
		// i - int
		// d- double
		//
		$stmt->bind_param("ssis", $email, $password, $mobile, $gender);
		
		
		if ($stmt->execute()) {
			echo "<span style='background: #000000;font-size: 250%;color: green'>Kasutaja $email loodi edukalt</span>";
		} else {
			
			echo "<span style='background: #000000;font-size: 250%;color: red'>Täitke kõik väljad</span>";//.$stmt->error;
		}
	}
	
	
	function login($email, $password) {
		
		$database = "if16_greg_4";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$notice = 
		$stmt = $mysqli->prepare("
		
		
		
		SELECT id, email, password, created
		FROM user_sample
		WHERE email = ?
		
		
		");
		
		echo $mysqli->error;
		//küsimärgi asendus
		$stmt->bind_param("s", $email);
		//rea kohta tulba väärtus
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		//ainult selecti puhul
		if($stmt->fetch()) {
			
			$hash = hash("sha512", $password);
			
			if ($hash == $passwordFromDb) {
				echo "kasutaja $id logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				header("Location: data.php");
				exit();
			}
			else {
					
					$notice = "Sisestasite parooli valesti";
				}
			//oli olemas rida käes
			
		} else{
			
			
			//ei olnud ühtegi rida
			$notice = "Emailiga $email kasutajat ei eksisteeri andmebaasis";
			
		}
		
		return $notice;
		
	}



	/*function submit($caption, $imgurl) {
		
		$database = "if16_greg_4";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO submissions (caption, imgurl) values (?, ?)");
		
		echo $mysqli->error;
		// s -string
		// i - int
		// d- double
		//
		$stmt->bind_param("ss", $caption, $imgurl);
		
		
		if ($stmt->execute()) {
			echo "<span style='background: #000000;font-size: 250%;color: green'>Your post was submitted successfully</span>";
		} else {
			echo "<span style='background: #000000;font-size: 250%;color: red'>There was an error submitting your post</span>";//.$stmt->error;
		}
	}*/
	
	
	
	function getAllPeople() {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		
		$stmt = $mysqli->prepare("
			SELECT id,caption,imgurl
			FROM submissions
		
		");
		
		
		$stmt->bind_result($id,$caption,$imgurl);
		$stmt->execute();
		
		
		
		
		$results = array();
		
		//tsükeldab nii mitu korda kui mitu rida SQL lausega tuleb
		while ($stmt->fetch()) {
			
			$human = new StdClass();
			$human->id = $id;
			$human->caption = $caption;
			$human->imgurl = $imgurl;
			
			array_push($results, $human);
			
		}
		
		return $results;
		
	}
	
	function cleanInput($input) {
		
		return htmlspecialchars(stripslashes(trim($input)));
		
	}
	
	
	
	







/*
	
	function sum($x, $y) {
		
		return $x + $y;
		
	}
	
	echo sum(132, 145);
	echo "<br>";
	
	
	
	
	function hello($firstname, $lastname) {
		
		return "Tere tulemast ".$firstname." ".$lastname."!";
		
	}
	
	echo hello("Greg","N");

*/



?>