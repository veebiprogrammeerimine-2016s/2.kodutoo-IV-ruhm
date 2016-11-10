<?php
class User{
	
	private $connection;
	
	function __construct($mysqli){
		//this viitab sellele klassile ja selle klassi muutujale
		$this->connection = $mysqli;
		
	}
	
	
	function login($email, $password) {
		
		$notice = "";
		
		
		$stmt = $this->connection->prepare("
			SELECT id, email, password
			FROM user_info
			WHERE email = ?
		");
		
		echo $this->connection->error;
		
		//asendan k�sim�rgi
		$stmt->bind_param("s", $email);
		
		//rea kohta tulba v��rtus
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb);
		
		$stmt->execute();
		
		//ainult SELECT'i puhul
		if($stmt->fetch()) {
			// oli olemas, rida k�es
			//kasutaja sisestas sisselogimiseks
			$hash = hash("sha512", $password);
			
			if ($hash == $passwordFromDb) {
				echo "User $id logged in";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				//echo "ERROR";
				
				header("Location: data.php");
				exit();
				
			} else {
				$notice = "parool vale";
			}
			
			
		} else {
			
			//ei olnud �htegi rida
			$notice = "Wrong Email ".$email." Does not exist";
		}
		
		
		$stmt->close();
		
		return $notice;
		
		
		
		
		
	}

	function signup($email, $password, $age, $name, $lname, $dname) {
		
		
		$stmt = $this->connection->prepare("INSERT INTO user_info (email, password, age, fname, lname, dname) VALUE (?, ?, ?, ?, ?, ?)");
		echo $this->connection->error;
		
		$stmt->bind_param("ssisss", $email, $password, $age, $name, $lname, $dname);
		
		if ( $stmt->execute() ) {
			echo "�nnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
	}
	
}	
?>