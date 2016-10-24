<?php
	require ("../../config.php");
	/*function hello($firstname, $lastname) { 
		return "Tere tulemast ".$firstname." ".$lastname."!";
		
	}
	echo hello("Kent", "Loog");
	echo "<br>";
	*/
	// SEE FAIL PEAB OLEMA SIIS SEOTUD KÕIGIGA KUS TAHAME SESSIOONI KASUTADA, SAAB KASUTADA NUUD $_SESSION MUUTUJUAT	
	
	session_start();
	
	$database = "if16_kentloog";
	
	
	function signup($email, $password, $gender, $birthdate) {
			
			
			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("INSERT INTO mvp_user (email, password, gender, birthdate) VALUE (?, ?, ?, ?)");
			echo $mysqli->error;
			
			$stmt->bind_param("ssss", $email, $password, $gender, $_POST["birthdate"]);
			
			if ($stmt->execute() ){
				echo "õnnestus";
			} else {
				echo "ERROR".$stmt->error;
			}
		}
	
	function login($email, $password) {
		
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("SELECT id, email, password, created, gender, birthdate FROM mvp_user WHERE email = ?");
			
			echo $mysqli->error;
			
			$stmt->bind_param("s", $email);
			
			$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created, $gender, $birthdate);
			
			$stmt->execute();
			// ainult SELECTi puhul
			if($stmt->fetch()) {
				//oli olemas, rida käes
				$hash = hash("sha512", $password);
				if ($hash == $passwordFromDb){
					echo "Kasutaja $id logis sisse";
					
					$_SESSION["userId"] = $id;
					$_SESSION["userEmail"] = $emailFromDb;
					
					header("Location: data.php");
					
					} else {
						$notice = "parool vale";
				}
			} else {
				// ei olnud ühtegi rida
				$notice = "Sellise emailiga ".$email." kasutajat ei ole olemas";
			}
			
			return $notice;
			
		
	}
	function saveEvent($event, $date, $location) {
			
			
			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("INSERT INTO mvp (event, date, location) VALUE (?, ?, ?)");
			echo $mysqli->error;
			
			$stmt->bind_param("sss", $event, $date, $location);
			
			if ($stmt->execute() ){
				echo "õnnestus";
			} else {
				echo "ERROR".$stmt->error;
			}
		}
		
		
	function getAllEvents (){
			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			$stmt = $mysqli->prepare("SELECT id, event, date, location FROM mvp ORDER BY date");
			$stmt->bind_result($id, $event, $date, $location);
			$stmt->execute();
			
			$results = array();
			// Tsükli sisu tehake nii mitu korda, mitu rida SQL lausega tuleb
			while($stmt->fetch()) {
				//echo $color."<br>";
				$upcomingEvent= new StdClass();
				$upcomingEvent->id = $id;
				$upcomingEvent->event = $event;
				$upcomingEvent->date = $date;
				$upcomingEvent->location = $location;
				
				array_push($results, $upcomingEvent);
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
	function saveInterest ($interest) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("INSERT INTO interests (interest) VALUES (?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("s", $interest);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	function saveUserInterest ($interestid) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id FROM user_interests WHERE user_id=? AND interest_id=?");
		
		$stmt->bind_param("ii", $_SESSION["userId"], $interestid);

		$stmt->execute();
		
		if ($stmt->fetch())  {
			
			echo "juba olemas";
			return;
		}
		
		$stmt->close();
		
		$stmt = $mysqli->prepare("INSERT INTO user_interests (user_id, interest_id) VALUES (?, ?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("ii", $_SESSION["userId"], $interestid);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	function getAllInterests() {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
			SELECT id, interest
			FROM interests
		");
		echo $mysqli->error;
		
		$stmt->bind_result($id, $interest);
		$stmt->execute();
		
		
		//tekitan massiivi
		$result = array();
		
		// tee seda seni, kuni on rida andmeid
		// mis vastab select lausele
		while ($stmt->fetch()) {
			
			//tekitan objekti
			$i = new StdClass();
			
			$i->id = $id;
			$i->interest = $interest;
		
			array_push($result, $i);
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}
	function getUserInterests() {
	
	$mysqli = new mysqli(
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("
		SELECT interest 
		FROM interests
		JOIN user_interests 
		ON user_interests.interest_id=interests.id
		WHERE user_interests.user_id=?
	");
	
	}
?>
