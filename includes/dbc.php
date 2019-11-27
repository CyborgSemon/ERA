<?php

session_start();

$conn = mysqli_connect(getenv('DATABASE_HOST'), getenv('DATABASE_USERNAME'), getenv('DATABASE_PASSWORD'), getenv('DATABASE_NAME'));

if (!$conn) {
	die("There was an issue connecting to the databse: ".mysqli_connect_error());
}

?>