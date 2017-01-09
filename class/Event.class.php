<?php
class Event
{

    private $connection;

    function __construct($mysqli)
    {
        $this->connection = $mysqli;
    }


    function saveEvent($email, $datestamp, $exercise, $sets, $reps, $weight) {

        $stmt = $this->connection->prepare("INSERT INTO workouts (email, datestamp, exercise, sets, reps, weight) VALUES (?, ?, ?, ?, ?, ?)");
        echo $this->connection->error;

        $stmt->bind_param("sssiii", $_SESSION["userEmail"], $datestamp, $exercise, $sets, $reps, $weight);
        header("Location: data.php");

        if ($stmt->execute() ) {
            echo "�nnestus";
        } else {
            echo "ERROR " . $stmt->error;
        }

    }


    function getAllExercise($q, $sort, $order) {

        $allowedSort = ["datestamp", "excercise"];

        // sort ei kuulu lubatud tulpade sisse
        if(!in_array($sort, $allowedSort)){
            $sort = "datestamp";
        }

        $orderBy = "ASC";

		if($order == "DESC") {
            $orderBy = "DESC";
        }

		echo "Sorting: ".$sort." ".$orderBy." ";


		if ($q != "") {
            //otsin
            echo "Searching: ".$q;

            $stmt = $this->connection->prepare("
				SELECT email, datestamp, exercise, sets, reps, weight
				FROM workouts
				WHERE deleted IS NULL
				AND ( datestamp LIKE ? OR exercise LIKE ? )
				ORDER BY $sort $orderBy
			");

            $searchWord = "%".$q."%";

            $stmt->bind_param("ss", $searchWord, $searchWord);

        } else {
            // ei otsi
            $stmt = $this->connection->prepare("
				SELECT email, datestamp, exercise, sets, reps, weight
				FROM workouts
				WHERE deleted IS NULL
				ORDER BY $sort $orderBy
			");
        }


        $stmt = $this->connection->prepare("
			SELECT id, email, datestamp, exercise, sets, reps, weight
			FROM workouts WHERE email=? AND deleted IS NULL
		");
        $stmt->bind_param("s", $_SESSION["userEmail"]);

        $stmt->bind_result($id, $email, $datestamp, $exercise, $sets, $reps, $weight);
        $stmt->execute();

        $results = array();

        // ts�kli sisu tehakse nii mitu korda, mitu rida
        // SQL lausega tuleb
        while ($stmt->fetch()) {

            $human = new StdClass();
            $human->id = $id;
            $human->email = $email;
            $human->datestamp = $datestamp;
            $human->exercise = $exercise;
            $human->sets = $sets;
            $human->reps = $reps;
            $human->weight = $weight;


            //echo $color."<br>";
            array_push($results, $human);

        }

        return $results;
        }


    function updateExercise($datestamp, $exercise, $sets, $reps, $weight, $id){

        $stmt = $this->connection->prepare("UPDATE workouts SET datestamp=?, exercise=?, sets=?, reps=?, weight=? WHERE id=? AND deleted IS NULL");
        $stmt->bind_param("ssiiii",$datestamp, $exercise, $sets, $reps, $weight, $id);

        // kas õnnestus salvestada
        if($stmt->execute()){
            // header
            echo "Saved changes!";
        } else {
            echo "Failed to save changes";
        }

        $stmt->close();

    }

    function deleteExercise($id){


        $stmt = $this->connection->prepare("
		UPDATE workouts SET deleted=NOW()
		WHERE id=?");
        $stmt->bind_param("i",$id);

        // kas õnnestus salvestada
        if($stmt->execute()){
            // õnnestus
            echo "Exercise deleted!";
        }

        $stmt->close();

    }
}

?>