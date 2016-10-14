<?php
	

	require("upload.php");
	
	if (!isset($_SESSION["userId"])) {
		
		header("Location: login.php");
		exit();
	}
	
	
	$successPost = "";
	
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
	}
	
	if (isset($_GET["success"])) {
		
		$successPost = "The file has been uploaded.";
	}

	
	
	
	
	
	
	
	
	
	/*if (!empty($_POST["caption"]) &&
		!empty($_POST["imgurl"]) &&
		isset($_POST["caption"]) &&
		isset($_POST["imgurl"])
		) 
	{
		submit(cleanInput($_POST["caption"]), cleanInput($_POST["imgurl"]));
		header("Location: data.php");
		exit();
	}*/
	
	
	
	$people = getAllPeople();
?>

<!DOCTYPE html>
<html>

<link rel="stylesheet" type="text/css" href="data.css">
<h1>Olete sisselogitud</h1>

<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">Log out</a>
</p>

<div class="form">


		
		
		<font color="white"><h2>Submit a post</h2></font>
		

		
		
		
			<form name="postpic" action="upload.php" method="post" enctype="multipart/form-data">

				Select image to upload:
				<input type="file" name="fileToUpload" id="fileToUpload">  <?php echo $successPost; ?>
				<br><br>
				<input type="submit" value="Upload Image" name="submit">
			</form>
		
		
		
		
</div>
		
		<br><br>
		
<div class="fixed">
Greg Nesselmann 2016
</div>



	
	<?php
		/*
		$html = "<div class="form">";
	
		$html .= "<h2>Submitted posts</h2>";
	
		$html .= "<table>";
		
			$html .= "<tr>";
				$html .= "<th>ID</th>";
				$html .= "<th>Caption</th>";
				$html .= "<th>Image URL</th>";
			$html .= "</tr>";
		
		
			foreach ($people as $p) {
				$html .= "<tr>";
					$html .= "<td>". $p->id."</td>";
					$html .= "<td>". $p->caption."</td>";
					$html .= "<td>".$p->imgurl."</td>";
				$html .= "</tr>";
			}
		
		
		$html .= "</table>";
		
		$html .= "</div>";
		
		echo $html;
		
		*/
	?>
	
	<?php
		
		$html = "";

		foreach ($people as $p) {
			$html .= "<br><br>";
			$html .= "<div class='form'> ";
	
				//$html .= "<td>". $p->id."</td>";
				$html .= "<h3>". $p->caption."</h3>";
				$html .= "<p>"."<img src=".$p->imgurl. ">"."</p>";
				$html .= "<br><br>";
			$html .= "</div>";
		}
	
		
		
		echo $html;
	?>

	
	
	<?php 


	/*foreach($people as $p) {
		
		$style = "
		    background-color:".$p->imgurl.";
			width: 40px;
			height: 40px;
			border-radius: 20px;
			text-align: center;
			line-height: 39px;
			float: left;
			margin: 20px;
		";
				
		echo "<p style = '".$style."'>"."</p>";
		
	}*/
	?>
	
	
</html>