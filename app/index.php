<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../');
$dotenv->load();

require 'includes/dbc.php';
require 'includes/statement.php';

if (isset($_SESSION['id'])) {
	header('Location: home.php');
} else {
	$name = $_SESSION['temp_username'];
	session_unset();
	session_destroy();
	session_start();
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
		<link href="css/main.min.css" rel="stylesheet">
	</head>
	<body>
		<div class="logo">

		</div>
		<div class="loginBox">
			<form action="includes/login.php" method="post">
				<div class="inputField">
					<input type="text" id="username" name="username" required value="<?php echo $name; ?>" autocomplete="off" placeholder="Username">
					<label for="username">Username</label>
					<div class="inputBorder"></div>
				</div>
				<div class="inputField">
					<input type="password" id="password" name="password" required autocomplete="off" placeholder="Password" <?php if($name) echo 'autofocus'; ?>>
					<label for="username">Password</label>
					<div class="inputBorder"></div>
				</div>
				<button type="submit" name="button">Login</button>
			</form>
		</div>
		<script src="js/main.min.js"></script>
	</body>
</html>
