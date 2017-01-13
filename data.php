<?php
	//ühendan sessionniga
	require("functions.php");
	
	//kui ei ole sisse loginud, suunan login lehele
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}
	
	//kas aadressireal on logout
	if (isset($_GET["logout"])) {
		SESSION_destroy();
		header("Location: login.php");
		exit();
	}
	
	//kontrollin kas tühi
		if ( isset($_POST["City"]) && 
		 isset($_POST["Cinema"]) && 
		 isset($_POST["Movie"]) &&
		 isset($_POST["Genre"]) &&
		 isset($_POST["Comment"]) &&
		 isset($_POST["Rating"]) &&
		 !empty($_POST["City"]) &&
		 !empty($_POST["Cinema"]) &&
		 !empty($_POST["Movie"]) &&
		 !empty($_POST["Genre"]) &&
		 !empty($_POST["Comment"]) &&
		 !empty($_POST["Rating"])
	) { 
	
	
		$Cinema = cleanInput($_POST["Cinema"]);
		
		saveEvent(cleanInput($_POST["City"]), ($_POST["Cinema"]), ($_POST["Movie"]), ($_POST["Genre"]), ($_POST["Comment"]), 
		($_POST["Rating"]));
		header("Location: login.php");
		exit();
	}
	$people=getAllPeople();
	echo"<pre>";
	//var_dump($people[1]);
	echo"</pre>";
	
	
	
	
	$City= "";
	$Cinema = "";
	$Movie = "";
	$Genre = "" ;
	$Comment = "" ;
	$Rating= "" ;
	
	
	
	

	
	$CityError= "*";
	if (isset ($_POST["City"])) {
		if (empty ($_POST["City"])) {
			$CityError = "* Väli on kohustuslik!";
		} else {
			$City = $_POST["City"];
		}
	}
	
	$CinemaError= "*";
	if (isset ($_POST["Cinema"])) {
		if (empty ($_POST["Cinema"])) {
			$CinemaError = "* Väli on kohustuslik!";
		} else {
			$Cinema = $_POST["Cinema"];
		}
	}
	
	$MovieError= "*";
	if (isset ($_POST["Movie"])) {
		if (empty ($_POST["Movie"])) {
			$MovieError = "* Väli on kohustuslik!";
		} else {
			$Movie = $_POST["Movie"];
		}
	}
	
	$GenreError= "*";
	if (isset ($_POST["Genre"])) {
		if (empty ($_POST["Genre"])) {
			$GenreError = "* Väli on kohustuslik!";
		} else {
			$Genre = $_POST["Genre"];
		}
	}
	
	$CommentError= "*";
	if (isset ($_POST["Comment"])) {
		if (empty ($_POST["Comment"])) {
			$CommentError = "* Väli on kohustuslik!";
		} else {
			$Comment = $_POST["Comment"];
		}
	}
	
	$RatingError= "*";
	if (isset ($_POST["Rating"])) {
		if (empty ($_POST["Rating"])) {
			$RatingError = "* Väli on kohustuslik!";
		} else {
			$Rating = $_POST["Rating"];
		}
	}
	
	if(isset ($_POST["Rating"])) {
		if(empty ($_POST["Rating"])){
			$RatingError = "* Väli on kohustuslik!";
		} else{
		$Rating = $_POST["Rating"];
		}
	}
	

	if(isset ($_POST["Comment"])) {
		if(empty ($_POST["Comment"])){
			$CommentError = "* Väli on kohustuslik!";
		} else{
		$Comment = $_POST["Comment"];
		}
	}
	
	
	if(isset ($_POST["Genre"])) {
		if(empty ($_POST["Genre"])){
			$GenreError = "* Väli on kohustuslik!";
		} else{
		$Genre = $_POST["Genre"];
		}
	}

	
	if(isset ($_POST["Movie"])) {
		if(empty ($_POST["Movie"])){
			$MovieError = "* Väli on kohustuslik!";
		} else{
		$Movie = $_POST["Movie"];
		}
	}
	
	
	if(isset ($_POST["Cinema"])) {
		if(empty ($_POST["Cinema"])){
			$CinemaError = "* Väli on kohustuslik!";
		} else{
		$Cinema = $_POST["Cinema"];
		}
	}
	
	if(isset ($_POST["City"])) {
		if(empty ($_POST["City"])){
			$CityError = "* Väli on kohustuslik!";
		} else{
		$City = $_POST["City"];
		}
	}

	
	
	
?>
<h1>Data</h1>

<?php echo$_SESSION["userEmail"];?>

<?=$_SESSION["userEmail"];?>


<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">logi välja</a>
</p>

<h2>Salvesta sündmus</h2>
<form method="POST" >
	<label>Linn</label><br>
	<input name="City" type="text" value="<?=$City;?>"><?php echo $CityError;?>
	<br><br>
	<label>Kino</label><br>
	<input name="Cinema" type="text" value="<?=$Cinema;?>"><?php echo $CinemaError;?>
	<br><br>
	<label>Film</label><br>
	<input name="Movie" type="text" value="<?=$Movie;?>"><?php echo $MovieError;?>
	<br><br>
	<label>Žanr</label><br>
	<input name="Genre" type="text" value="<?=$Genre;?>"><?php echo $GenreError;?>
	<br><br>
	<label>Kommentaar</label><br>
	<input name="Comment" type="text" value="<?=$Comment;?>"><?php echo $CommentError;?>
	<br><br>
	<label>Hinne</label><br>
	<input name="Rating" type="float" value="<?=$Rating;?>"><?php echo $RatingError;?>
	<br><br>
	<input type="submit" value="Salvesta">
</form>

<h2>Arhiiv</h2>
<?php 
	$html="<table>";
		$html .="<tr>";
			$html .="<th>ID</th>";
			$html .="<th>Linn</th>";
			$html .="<th>Kino</th>";
			$html .="<th>Film</th>";
			$html .="<th>Žanr</th>";
			$html .="<th>Kommentaar</th>";
			$html .="<th>Hinne</th>";
	$html .="</tr>";
	//iga liikmekohta masssiiivis
	foreach($people as $p){
		$html .="<tr>";
			$html .="<td>".$p->id."</td>";
			$html .="<td>".$p->City."</td>";
			$html .="<td>".$p->Cinema."</td>";
			$html .="<td>".$p->Movie."</td>";
			$html .="<td>".$p->Genre."</td>";
			$html .="<td>".$p->Comment."</td>";
			$html .="<td>".$p->Rating."</td>";
			$html .= "<td><a href='edit.php?id=".$p->id."'>edit.php</a></td>";
	$html .="</tr>";	
	}
	$html .="</table>";
	echo $html;
	
	
?>