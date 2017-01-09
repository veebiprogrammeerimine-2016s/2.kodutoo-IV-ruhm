<?php
class User
{

    private $connection;

    // k�ivitatakse siis kui on = new User(see j�uab siia)
    function __construct($mysqli)
    {
        // this viitab sellele klassile ja selle
        // klassi muutujale
        $this->connection = $mysqli;
    }

    //Program functions

    function signup($email, $password, $phone, $gender) {

        //$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

        $stmt = $this->connection->prepare("INSERT INTO user_sample (email, password, phone, gender) VALUE (?, ?, ?, ?)");
        echo $this->connection->error;

        $stmt->bind_param("ssss", $email, $password, $phone, $gender);

        if ( $stmt->execute() ) {
            echo "Success!";
        } else {
            echo "ERROR ".$stmt->error;
        }

    }

    function login($email, $password) {

        $notice = "";

        //$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

        $stmt = $this->connection->prepare("
			SELECT id, email, password, created
			FROM user_sample
			WHERE email = ?
		");

        echo $this->connection->error;

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

        return $notice;

    }

}
?>