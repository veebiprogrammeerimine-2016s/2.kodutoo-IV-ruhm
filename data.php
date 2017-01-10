<?php 

	//ühendan sessiooniga
	require("functions.php");
	

	//kui ei ole sisseloginud, suunan login lehele
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	//kas aadressireal on logout
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
		
	}


	//Save on error and incomplete form errors
	$datestamp = "";
	$exercise = "";
	$sets = "";
	$reps = "";
	$weight = "";

	$emptyDate = "*";
	$emptyExercise = "*";
	$emptySets = "*";
	$emptyReps = "*";
	$emptyWeight = "*";

if (isset ($_POST["datestamp"])) {
	if (empty ($_POST["datestamp"])) {
		$emptyDate = "* Please fill in date!";
	} else {
		$datestamp = $_POST["datestamp"];
	}
}

if (isset ($_POST["exercise"])) {
	if (empty ($_POST["exercise"])) {
		$emptyDate = "* Please fill in exercise!";
	} else {
		$exercise = $_POST["exercise"];
	}
}

if (isset ($_POST["sets"])) {
	if (empty ($_POST["sets"])) {
		$emptyDate = "* Please fill in sets!";
	} else {
		$sets = $_POST["sets"];
	}
}

if (isset ($_POST["reps"])) {
	if (empty ($_POST["reps"])) {
		$emptyDate = "* Please fill in reps!";
	} else {
		$reps = $_POST["reps"];
	}
}

if (isset ($_POST["weight"])) {
	if (empty ($_POST["weight"])) {
		$emptyDate = "* Please fill in weight!";
	} else {
		$weight = $_POST["weight"];
	}
}


if ( isset($_POST["datestamp"]) &&  //kontrollid kas kõik 5 välja üldse eksisteerivad
	isset($_POST["exercise"]) &&
	isset($_POST["sets"]) &&
	isset($_POST["reps"]) &&
	isset($_POST["weight"]) &&
	!empty($_POST["datestamp"]) &&
	!empty($_POST["exercise"]) &&
	!empty($_POST["sets"]) &&
	!empty($_POST["reps"]) &&
	!empty($_POST["weight"])
	) {
		echo "Saved.";
		saveEvent(($_SESSION["userEmail"]),($_POST["datestamp"]),($_POST["exercise"]), ($_POST["sets"]), ($_POST["reps"]), ($_POST["weight"]));
	} {
	//Retain entered data
	/*$savedDate = $_POST["datestamp"];
	$notice = login($_POST["exercise"], $_POST["loginPassword"]); */


	}
	
	$people = getAllExercise();
	


?>
<h1>Data</h1>

<?php echo $_SESSION["userEmail"];?>

<?=$_SESSION["userEmail"];?>

<p>
	Welcome! <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">Log out</a>
</p>

<h2>Insert Excercise</h2>
<form method="POST" >

	<label>Date</label><br>
	<input name="datestamp" type="date" value="<?=$datestamp;?>"> <?php echo $emptyDate; ?>

	<br><br>
	<label>Excercise</label><br>
	<input name="exercise" type="text" value="<?=$exercise;?>"> <?php echo $emptyExercise; ?>
	
	<br><br>
	<label>Sets</label><br>
	<input name="sets" type="number" value="<?=$sets;?>"> <?php echo $emptySets; ?>
	
	<br><br>
	<label>Reps</label><br>
	<input name="reps" type="number" value="<?=$reps;?>"> <?php echo $emptyReps; ?>

	<br><br>
	<label>Weight</label><br>
	<input name="weight" type="number" value="<?=$weight;?>"> <?php echo $emptyWeight; ?>

	<br><br>
	
	<input type="submit" value="Save">

</form>


<h2>Archive</h2>

<?php 

	
	$html = "<table>";
	
		$html .= "<tr>";
			$html .= "<th>email</th>";
			$html .= "<th>datestamp</th>";
			$html .= "<th>exercise</th>";
			$html .= "<th>sets</th>";
			$html .= "<th>reps</th>";
			$html .= "<th>weight</th>";
		$html .= "</tr>";
		
		//iga liikme kohta massiivis
		foreach ($people as $p) {
			
			$html .= "<tr>";
				$html .= "<td>".$p->email."</td>";
				$html .= "<td>".$p->datestamp."</td>";
				$html .= "<td>".$p->exercise."</td>";
				$html .= "<td>".$p->sets."</td>";
				$html .= "<td>".$p->reps."</td>";
				$html .= "<td>".$p->weight."</td>";
			$html .= "</tr>";
		
		}
		
	$html .= "</table>";
	
	echo $html;

?>