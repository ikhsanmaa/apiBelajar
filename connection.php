<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "api";
	
	//create connection
	$conn = new mysqli($servername, $username, $password, $database);

	// Check Connection
	if ($conn->connect_error) {
		die("Connection failed :" . $conn->connect_error);
	}
	//echo "Connection succesfully";
?>
