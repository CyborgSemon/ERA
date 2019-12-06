<?php

require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../../../');
$dotenv->load();

require_once 'dbc.php';
require_once 'statement.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_SESSION['id']) && !isset($_SESSION['type'])) {
		if ($_POST['password'] == $_POST['passwordRepeat']) {
			$sql = "UPDATE users SET password = ? WHERE id = ?";
			prep_stmt($conn, $sql, "si", [password_hash($_POST['password'], PASSWORD_DEFAULT), $_SESSION['id']]);

			$sql2 = "SELECT * FROM users WHERE id = ?";
			$result = prep_stmt($conn, $sql2, "i", [$_SESSION['id']]);

			if ($row = mysqli_fetch_assoc($result)) {
				$_SESSION['email'] = $row['email'];
				$_SESSION['class'] = $row['class'];
				$_SESSION['profileImage'] = $row['profileImage'];
				$_SESSION['type'] = $row['type'];

				if ($row['type'] == 'student') {
					header('Location: ../home.php');
				} else if ($row['type'] == 'member') {
					header('Location: ../dash.php');
				} else {
					header('Location: logout.php');
				}
			} else {
				echo 'There was an issue';
				exit();
			}
		} else {
			$_SESSION['message'] = 'Your passwords do not match';
			header('Location: ../newLogin.php');
			exit();
		}
	} else {
		$_SESSION['message'] = 'Permission denied';
		header('Location: ../index.php');
		exit();
	}
} else {
	echo 'You dont have permission to access this page';
	exit();
}

?>