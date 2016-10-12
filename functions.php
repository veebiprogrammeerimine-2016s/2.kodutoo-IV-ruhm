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
	function saveEvent($event, $date) {
			
			
			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("INSERT INTO mvp (üritus, kuupäev) VALUE (?, ?)");
			echo $mysqli->error;
			
			$stmt->bind_param("ss", $event, $date);
			
			if ($stmt->execute() ){
				echo "õnnestus";
			} else {
				echo "ERROR".$stmt->error;
			}
		}
		
		
	function getAllEvents (){
			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			$stmt = $mysqli->prepare("SELECT id, üritus, kuupäev FROM mvp");
			$stmt->bind_result($id, $event, $date);
			$stmt->execute();
			
			$results = array();
			// Tsükli sisu tehake nii mitu korda, mitu rida SQL lausega tuleb
			while($stmt->fetch()) {
				//echo $color."<br>";
				$upcomingEvent= new StdClass();
				$upcomingEvent->id = $id;
				$upcomingEvent->event = $event;
				$upcomingEvent->date = $date;
				
				array_push($results, $upcomingEvent);
			}
			
			return $results;
			
			
			
		}
	
	
?>