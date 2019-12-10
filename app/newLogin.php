<?php

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../../');
$dotenv->load();

require_once 'includes/dbc.php';
require_once 'includes/statement.php';

if (isset($_SESSION['id']) && isset($_SESSION['type'])) {
	header('Location: home.php');
	exit();
} else if (!isset($_SESSION['id'])) {
	header('Location: index.php');
	exit();
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
		<link href="css/main.min.css" rel="stylesheet">
	</head>
	<body>
		<div id="snackbar">
			<span id="snackbarMsg"></span>
		</div>
		<div class="logo">

		</div>
		<div class="loginBox">
			<h2>Change Password</h2>
			<form action="includes/newPassword.php" method="post">
				<div class="inputField">
					<input type="password" id="password" name="password" required autocomplete="off" placeholder="Password">
					<label for="username">Password</label>
					<div class="inputBorder"></div>
				</div>
				<div class="inputField">
					<input type="password" id="passwordRepeat" name="passwordRepeat" required autocomplete="off" placeholder="Repeat Password">
					<label for="username">Repeat Password</label>
					<div class="inputBorder"></div>
				</div>
				<div class="loginButtonBox">
					<button class="submitButton" type="submit" name="button">Change Password</button>
				</div>
			</form>
		</div>
		<script src="js/main.min.js"></script>
		<?php

		if (isset($_SESSION['message'])) {
			echo "<script>window.onload = ()=> {snackbar('".$_SESSION['message']."');}</script>";
			unset($_SESSION['message']);
		}

		?>
	</body>
</html>
