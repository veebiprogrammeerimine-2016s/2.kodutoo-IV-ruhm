<?php

class Event{
	
	
	private $connection;
	
	function __construct($mysqli){
		//this viitab sellele klassile ja selle klassi muutujale
		$this->connection = $mysqli;
		
	}
	
	
	

	
	function getAllData() {
		

		$stmt = $this->connection->prepare("
			SELECT location, upload, download, ping, device, name
			FROM internet_data
			
		");
		$stmt->bind_result($location, $upload, $download, $ping, $device, $name);
		$stmt->execute();
		
		$results = array();
		
		
		while ($stmt->fetch()) {
			
			$info = new StdClass();
			$info->location = $location;
			$info->upload = $upload;
			$info->download = $download;
			$info->ping = $ping;
			$info->device = $device;
			$info->name = $name;
			
			
			//echo $color."<br>";
			array_push($results, $info);
			
		}
		
		return $results;
		
	}
	
	
	
	
	
}	
?>
	
	
	
	
	
	
	
	
	
	
