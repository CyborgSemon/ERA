<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../');
$dotenv->load();

require 'includes/dbc.php';
require 'includes/statement.php';

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
					<input type="text" id="username" name="username" value="<?php echo $_SESSION['temp_username']; ?>" autocomplete="off" placeholder="Username">
					<label for="username">Username</label>
					<div class="inputBorder"></div>
				</div>
				<div class="inputField">
					<input type="password" id="password" name="password" autocomplete="off" placeholder="Password">
					<label for="username">Password</label>
					<div class="inputBorder"></div>
				</div>
				<button type="submit" name="button">Login</button>
			</form>
		</div>
		<script src="js/main.min.js"></script>
	</body>
</html>
