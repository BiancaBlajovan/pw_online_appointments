<?php
	/* Database credentials. Assuming you are running MySQL
	server with default setting (user 'root' with no password) */
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_NAME', 'oftadb');

	function connectToDB() {
		/* Incerc conectare la server MySQL, baza de date oftadb */
		$linktemp = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
		 
		// Verificare succes conectare
		if($linktemp === false){
			die("Conectare server MySQL eronata. " . mysqli_connect_error());
		}
		
		return $linktemp;
	}
?>