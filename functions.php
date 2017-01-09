<?php 

	require("/home/joosjuha/config.php");
	
	// see fail peab olema siis seotud kõigiga kusb
	// tahame sessiooni kasutada
	// saab kasutada nüüd $_SESSION muutujat
	session_start();
	
	$database = "if16_jsander";
    $mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);

?>