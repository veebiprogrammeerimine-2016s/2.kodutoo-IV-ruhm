<?php

class Helper {
    
    function cleanInput($input) {
		
		// input = "  romil  ";
		$input = trim($input);
		// input = "romil";
		
		// v�tab v�lja \
		$input = stripslashes($input);
		
		// html asendab, nt "<" saab "&lt;"
		$input = htmlspecialchars($input);
		
		return $input;
		
	}
}
?>


