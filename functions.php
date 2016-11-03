<?php

	require("../../config.php");

	session_start();

	$database = "if16_stenly_4";
	// functions.php

	function signup($email, $password) {

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUE (?, ?)");
		echo $mysqli->error;

		$stmt->bind_param("ss", $email, $password);

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



	function saveEvent($points, $color) {

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("INSERT INTO tagasiside (points, color) VALUE (?, ?)");
		echo $mysqli->error;

		$stmt->bind_param("is", $points, $color);

		if ( $stmt->execute() ) {
			echo "õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}

	}

	function getAllPeople() {

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("
			SELECT id, points, color
			FROM tagasiside
		");
		$stmt->bind_result($id, $points, $color);
		$stmt->execute();

		$results = array();

		// tsükli sisu tehakse nii mitu korda, mitu rida
		// SQL lausega tuleb
		while ($stmt->fetch()) {

			$human = new StdClass();
			$human->id = $id;
			$human->points = $points;
			$human->lightColor = $color;


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

	function saveUserInterest ($interest) {

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("
			SELECT id FROM user_interests_4
			WHERE user_id=? AND interest_id=?
		");
		$stmt->bind_param("ii", $_SESSION["userId"], $interest);

		$stmt->execute();

		//kas oli rida
		if ($stmt->fetch()) {

			//oli olemas
			echo "juba olemas";
			//pärast returni enam koodi ei vaadata
			return;
		}

		// kui ei olnud, jõuame siia
		$stmt->close();

		$stmt = $mysqli->prepare("
			INSERT INTO user_interests_4 (user_id, interest_id)
			VALUES (?, ?)
		");

		echo $mysqli->error;

		$stmt->bind_param("ii", $_SESSION["userId"], $interest);

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





	/*function sum($x, $y) {

		return $x + $y;

	}

	echo sum(12312312,12312355553);
	echo "<br>";


	function hello($firstname, $lastname) {
		return
		"Tere tulemast "
		.$firstname
		." "
		.$lastname
		."!";
	}

	echo hello("romil", "robtsenkov");
	*/

?>
