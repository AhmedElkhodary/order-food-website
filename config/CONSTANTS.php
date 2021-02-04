<?php

	//start session
	session_start();

	//Create CONSTANTS
	define('SITEURL', 'http://localhost/food-order/');


	//connecting to database
	$dsn = 'mysql:host=localhost;dbname=food-order';
	$user= 'root';
	$pass= '';
	$option =  array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	);

	try {
		$con = new PDO( $dsn, $user, $pass, $option);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Connected to Database <br>";
	}

	catch(PDOException $e) {
		echo "Failed to connect" . $e->getMessage();
	}

?>