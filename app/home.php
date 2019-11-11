<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../');
$dotenv->load();

require 'includes/dbc.php';
require 'includes/statement.php';

if (!isset($_SESSION['id'])) header('Location: index.php');

$sql = "SELECT * FROM portfolio WHERE userId = ?";
$result = prep_stmt($conn, $sql, "i", [$_SESSION['id']]);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
		<link href="css/main.min.css" rel="stylesheet">
	</head>
	<body>
		<div class="container">
			<div class="actions card">
				<a href="includes/logout.php">Logout</a>
			</div>
			<div class="content">
				<div class="accountBox card">
					Im an account box. This is where all of my header information will be stored. Some of theinformation in here will be used in the preview card on the display site. so stuff like profile image, header image etc
				</div>
				<div class="editor card">
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
					Im the editor
					<br>
					Just testing height here. dont mind me ;)
					<br>
				</div>
			</div>
		</div>
		<script src="js/main.min.js"></script>
	</body>
</html>
