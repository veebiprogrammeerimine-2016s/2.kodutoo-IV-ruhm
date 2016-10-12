<?php
	//andmete salvestamine/näitamine mvp idee järgi.

	//ühendan sessiooniga
	require("functions.php");
	
	//kui ei ole sisse loginud, suunan login lehele.
	if(!isset($_SESSION["userId"])) {
		header("Location: KolmasPHP.php");
	}
	
	
	//kas aadressireal on logout
	if(isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: KolmasPHP.php");
		
	}
			if(ISSET($_POST["age"]) &&
			isset($_POST["varv"])){
				 $vanus = $_POST["age"];
				 $varvus = $_POST["varv"];
				 saveEvent($vanus, $varvus);
			}
	$people = getAllPeople();
/*echo "<pre>";
	var_dump($people);
echo "</pre>";*/
?>
<h1>Data</h1>



<p>

	Tere tulemast <?=$_SESSION["userEmail"];?>!<br><br>
	<a href="?logout=1">logi välja</a> 
</p>


	<p>
	<br><br>
		<form method="POST">
				<input name="age" type="text" placeholder="Vanus"> 
				
				<br><br>
				
				<input name="varv" value="Värvus" type="color"> 
				
				<br><br>
				
				<input type="submit" value = "Sisesta andmed">
				
		</form>
		
	</p>
	
	<h2>Arhiiv</h2>
	
	<?php
	
	
		$html = "<table>";
			$html .= "<tr>";
				$html .= "<th>ID</th>";
				$html .= "<th>Vanus</th>";
				$html .= "<th>Värv</th>";
			$html .="</tr>";
		
		
		
		foreach ($people as $p) {
			
			$html .= "<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->age."</td>";
				$html .= "<td>".$p->Color."</td>";
			$html .= "</tr>";
		}
		$html .= "</table>";			
	
	echo $html;
	
	
	?>
	
	<h2>Midagi huvitavat</h2>
	
	<?php
	
		foreach($people as $p) {

			$style = "
				background-color:".$p->Color.";
				width: 40px;
				height: 40px;
				border-radius: 20px;
				text-align: center;
				line-height: 40px;
				float: left;
				margin: 5px;
			";
			
			echo "<p style = '".$style."'>".$p->age."</p>";
			
		}