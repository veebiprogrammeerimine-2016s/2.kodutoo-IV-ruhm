<?php
	require("../../config.php");
	$database = "if16_ukupode";


	
	function submit($start,$finish)
	{
		$database ="if16_ukupode";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO gps (start, finish) VALUES (?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("ss", $start, $finish);
	
		if ($stmt->execute())
		{
			echo "<br>õnnestus";	
		}
		else
		{
			echo "error".$stmt->error;
		}
	}
	
	function numberDoesExist($nr, $points){
		foreach($points as $p){
			if (in_array($nr,$p)){
				return true;
			}
		}
		
		return false;
	}
	
	
	function mostUsed($filter) {
	
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$arr = ["start", "finish"];
		
		if (!in_array($filter,$arr))
		{
			echo "error ----";
			return;
		}
			
			$stmt = $mysqli->prepare("
				SELECT $filter,count($filter) 
				FROM gps 
				GROUP BY $filter
				ORDER BY COUNT($filter) DESC LIMIT 3;;
				
			");
			//SESSION USER ID
			
			//$stmt->bind_param("ssss", $startnumber,$startnumber,$startnumber,$startnumber);
			
			echo $mysqli->error;
			
			$stmt->bind_result($start, $count);
			$stmt->execute();
			
			
			//tekitan massiivi
			$result = array();
			
			// tee seda seni, kuni on rida andmeid
			// mis vastab select lausele
			while ($stmt->fetch()) {
				
				//tekitan objekti
				$i = new StdClass();
				
				$i->start = $start;
				$i->count = $count;
			
				array_push($result, $i);
			}
			
			$stmt->close();
			$mysqli->close();
			
			return $result;
			
		
	}
	
	
	
?>