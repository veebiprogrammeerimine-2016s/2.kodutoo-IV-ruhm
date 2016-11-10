<?php

class data{
	
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;}
		
		
		
		function dataentry ($location, $upload, $download, $ping , $device, $name) {
		
		
			$stmt = $this->connection->prepare("
		
				INSERT INTO internet_data(location, upload, download, ping, device, name) VALUE (?, ?, ?, ?, ?, ?)
			
				");
			echo $this->connection->error;
		
			$stmt->bind_param("siiiss", $location, $upload, $download, $ping, $device, $name);
		
				if ($stmt->execute()){
				echo "Success";
				} else {
				echo "ERROR";
				};

				
		
				
		
				
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

























}
?>