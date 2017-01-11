<?php

	require("../../config.php");

	session_start();

	$database = "if16_stenly_4";
	// functions.php

	function signup($email, $password, $created) {

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, created) VALUES (?, ?, ?)");
		echo $mysqli->error;

		$stmt->bind_param("ssd", $email, $password, $created);

		if ( $stmt->execute() ) {
			echo "õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}

	}

	function login($email, $password) {

		$notice = "";

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("SELECT id, email, password, created FROM user_sample WHERE email = ?");

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
				$notice = "Vale parool!";
			}


		} else {

			//ei olnud ühtegi rida
			$notice = "Sellise emailiga ".$email." kasutajat ei ole olemas";
		}


		$stmt->close();
		$mysqli->close();

		return $notice;





	}



	function saveFeedback($points, $color, $address) {

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("INSERT INTO tagasiside (points, color, address) VALUE (?, ?, ?)");
		echo $mysqli->error;

		$stmt->bind_param("iss", $points, $color, $address);

		if ( $stmt->execute() ) {
			echo "Salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}

		$stmt->close();
		$mysqli->close();

	}

	function getAllFeedback() {

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("SELECT id, points, color, address FROM tagasiside");
		$stmt->bind_result($id, $points, $color, $address);
		$stmt->execute();

		$results = array();

		// tsükli sisu tehakse nii mitu korda, mitu rida
		// SQL lausega tuleb
		while ($stmt->fetch()) {

			$human = new StdClass();
			$human->id = $id;
			$human->points = $points;
			$human->lightColor = $color;
			$human->address = $address;


			//echo $color."<br>";
			array_push($results, $human);

		}

		return $results;

	}


	function cleanInput($input) {
		$input = trim($input);
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
