<?php

require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../../../');
$dotenv->load();

require_once 'dbc.php';
require_once 'statement.php';

if (!$_SESSION['id']) {
	echo 'You dont have permission to access this page';
	exit();
}

if ($_SESSION['type'] != 'member') {
	echo 'You dont have permission to access this page';
	exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$sql = "SELECT * FROM users WHERE BINARY username = ?";
	$result = prep_stmt($conn, $sql, "s", [$_POST['username']]);
	if ($row = mysqli_fetch_assoc($result)) {
		echo 'There is already a student with that number';
	} else {
		$sql = "INSERT INTO users (id, username, password, email, firstName, lastName, class, profileImage, type) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, 'student')";
		$result = prep_stmt($conn, $sql, "sssssss", [$_POST['username'], password_hash($_POST['username'], PASSWORD_DEFAULT), $_POST['email'], $_POST['firstName'], $_POST['lastName'], $_POST['class'], $_POST['profile']]);
		if ($result) {
			echo 'done';
		} else {
			echo 'There was an issue';
		}
	}
} else {
	echo 'You dont have permission to access this page';
}

?>