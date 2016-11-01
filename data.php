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
		echo "õnnestus";
		saveEvent(($_SESSION["userEmail"]),($_POST["datestamp"]),($_POST["exercise"]), ($_POST["sets"]), ($_POST["reps"]), ($_POST["weight"]));
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
	<input name="datestamp" type="date">

	<br><br>
	<label>Excercise</label><br>
	<input name="exercise" type="text">
	
	<br><br>
	<label>Sets</label><br>
	<input name="sets" type="number">
	
	<br><br>
	<label>Reps</label><br>
	<input name="reps" type="number">

	<br><br>
	<label>Weight</label><br>
	<input name="weight" type="number">

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

