<?php

      //see fail peab olema seotud k6igiga kus
      //tahame sessiooni kasutada
      //saab kasutada nyyd $_SESSION muutujat
      require("../../config.php");

      session_start();

      $database = "if16_taankomm";
      //functions.php

        function signup($signupEmail, $password, $firstname, $lastname, $birthdate,
    		$gender, $profession, $hobbies) {

          //loon yhenduse

      		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"],
      		$GLOBALS["database"]);

      		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, firstname,
          lastname, birthdate, gender, profession, hobbies) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
          echo $mysqli->error;
      		//asendan kysim2rgid
      		//iga m2rgi kohta tuleb lisada yks t2ht - mis tyypi muutuja on
      		//s - string
      		//i - int
      		//d - double
      		$stmt->bind_param("ssssssss", $signupEmail, $password, $firstname, $lastname, $birthdate,
      		$gender, $profession, $hobbies);

      		if ($stmt->execute()) {
      			echo "Õnnestus! Logi nüüd sisse ka!";

      		} else {
      			echo "ERROR ".$stmt->error;

      		}

        }

        function login($email, $password) {

          $notice = " ";

          $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"],
      		$GLOBALS["database"]);

      		$stmt = $mysqli->prepare("SELECT id, email, password, created
          FROM user_sample
          WHERE email = ?
          ");

      		echo $mysqli->error;

          //asendan kysim2rgi
          $stmt->bind_param("s", $email);

          //rea kohta tulba v22rtus
          $stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);

          $stmt->execute();

          //ainult SELECTi puhul
          if($stmt->fetch()) {
              //oli olemas, rida k2es
              //kasutaja sisestad sisselogimiseks
              $hash = hash("sha512", $password);

              if ($hash == $passwordFromDb) {
                echo "Kasutaja $id logis sisse";

                $_SESSION["userId"] = $id;
                $_SESSION["userEmail"] = $emailFromDb;

                header("Location: data.php");
                exit();

              } else {
                $notice = "Parool vale";
              }
          } else {

            //ei olnud yhtegi rida
            $notice = "Sellise emailiga $email kasutajat ei ole olemas";
          }

          return $notice;

        }


        function saveSong($Autor, $Esitaja, $Pealkiri, $Aasta, $Kestvus, $Plaat, $Zanr, $Kommentaar) {

          $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"],
          $GLOBALS["database"]);

          $stmt = $mysqli->prepare("INSERT INTO songregister (Autor, Esitaja, Pealkiri, Loomise_aasta, Kestvus,
            Plaat, Žanr, Kommentaar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
          echo $mysqli->error;

          $stmt->bind_param("sssiisss", $Autor, $Esitaja, $Pealkiri, $Aasta,
           $Kestvus, $Plaat, $Zanr, $Kommentaar);

          if ($stmt->execute()) {
            echo "Õnnestus!";
          } else {
            echo "ERROR ".$stmt->error;

          }

        }

        function getAllSongs() {

          $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"],
          $GLOBALS["database"]);

          $stmt = $mysqli->prepare("
          SELECT id, Autor, Esitaja, Pealkiri, Loomise_aasta, Kestvus, Plaat, Žanr, Kommentaar FROM songregister
          ");
          $stmt->bind_result($id, $Autor, $Esitaja, $Pealkiri, $Aasta, $Kestvus, $Plaat, $Zanr, $Kommentaar);
          $stmt->execute();

          $results = array();
          //tsykli sisu tehakse nii mitu korda, mitu rida
          //SQL lausega tuleb
          while ($stmt->fetch()) {

            $human = new StdClass();
            $human->id = $id;
            $human->autor = $Autor;
            $human->esitaja = $Esitaja;
            $human->pealkiri = $Pealkiri;
            $human->loomise_aasta = $Aasta;
            $human->kestvus = $Kestvus;
            $human->plaat = $Plaat;
            $human->zanr = $Zanr;
            $human->kommentaar = $Kommentaar;

            //echo $age."<br>";
            //echo $color."<br>";
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

      /*function hello($firstname, $lastname) {

        return "Tere tulemast ".ucfirst($firstname)." ".ucfirst($lastname)."!";

      }

      echo hello("taaniel", "kõmmus");

      echo "<br>";
      */

 ?>
