<?php 

	require("../../config.php");
	
	session_start();
	
	$database = "if16_krisveen";
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	
	
	require("User.class.php");
	$User = new User($mysqli);
	require("data.class.php");
	$data = new data($mysqli);
	require("Event.class.php");
	$Event = new Event($mysqli);
	

?>