<?php
	//TODO: Update to match local environment
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'test');
	define('DB_PASSWORD', 'password');
	define('DB_NAME', 'test');


	$link =  mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	// for the purpose of debugging & testing enable more error reporting:
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	if($link === false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
?>