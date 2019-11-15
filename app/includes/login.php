<?php

require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../../');
$dotenv->load();

require_once 'dbc.php';
require_once 'statement.php';

if (!isset($_SESSION['id'])) {
	if ($_POST['username'] && $_POST['password']) {
		$sql = "SELECT * FROM users WHERE BINARY username = ?";
		$result = prep_stmt($conn, $sql, "s", [$_POST['username']]);
		if ($row = mysqli_fetch_assoc($result)) {
			$validPassword = password_verify($_POST['password'], $row['password']);
			if ($validPassword) {
				$_SESSION['id'] = $row['id'];
				$_SESSION['username'] = $row['username'];
				$_SESSION['firstName'] = $row['firstName'];
				$_SESSION['lastName'] = $row['lastName'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['class'] = $row['class'];
				$_SESSION['profileImage'] = $row['profileImage'];
				$_SESSION['type'] = $row['type'];
				header('Location: ../home.php');
			} else {
				$_SESSION['message'] = 'Invalid Username or Password';
				header('Location: ../index.php');
			}
		} else {
			$_SESSION['temp_username'] = $_POST['username'];
			$_SESSION['message'] = 'Invalid Username or Password';
			header('Location: ../index.php');
		}
	} else {
		header('Location: ../index.php');
	}
} else {
	header('Location: ../home.php');
}

?>