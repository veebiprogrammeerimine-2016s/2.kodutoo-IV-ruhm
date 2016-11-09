<?php



	require("functions.php");
	
	
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	$data = $Event->getAllData();
	

?>
<!DOCTYPE html>

<html>

<title> Results </title>

	<h1> Full table view </h1>
	
	
<?php 

	
	$html = "<table>";
	
		$html .= "<tr>";
			$html .= "<th>Location</th>";
			$html .= "<th>Upload mbps</th>";
			$html .= "<th>download mbps</th>";
			$html .= "<th>ping</th>";
			$html .= "<th>device</th>";
			$html .= "<th>name</th>";
		$html .= "</tr>";
		
		//iga liikme kohta massiivis
		foreach ($data as $d) {
			
			$html .= "<tr>";
				$html .= "<td>".$d->location."</td>";
				$html .= "<td>".$d->upload."</td>";
				$html .= "<td>".$d->download."</td>";
				$html .= "<td>".$d->ping."</td>";
				$html .= "<td>".$d->device."</td>";
				$html .= "<td>".$d->name."</td>";
                

			$html .= "</tr>";
		
		}
		
	$html .= "</table>";
	
	echo $html;
	
?>
<a href="data.php">Return</a>

</html>



