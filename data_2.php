<?php 

require ("functions_2.php");
	

	// kui ei ole sisse loginud, suunan login lehele
	if (!isset($_SESSION["userid"])) {
		header("Location: login_2.php");
	}

if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: login_2.php");
		exit();
}

 ?>

 <h1>Data</h1>
 <p>
 		Tere tulemast, <?=$_SESSION["userEmail"];?>!
 		<a href="?logout=1">logi valja</a>
 </p>