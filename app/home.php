<?php

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../');
$dotenv->load();

require_once 'includes/dbc.php';
require_once 'includes/statement.php';

if (!isset($_SESSION['id'])) header('Location: index.php');

$sql = "SELECT * FROM portfolio WHERE userId = ?";
$result = prep_stmt($conn, $sql, "i", [$_SESSION['id']]);

// $rows = mysqli_fetch_assoc($result);
// print_r($rows);

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
			<div class="actions">
				<div class="card">
					<a href="includes/logout.php">Logout</a>
					<br>
					<button id="save" type="button" name="button">Save</button>
				</div>
			</div>
			<div class="content">
				<div class="accountBox card">
					Im an account box. This is where all of my header information will be stored. Some of theinformation in here will be used in the preview card on the display site. so stuff like profile image, header image etc
				</div>
				<div class="editor card" id="editor">
				</div>
			</div>
			<div class="instructions">
				<div class="card">
					<h2>Instructions</h2>
					<p>Welcome to your profile page!</p>
					<p>This is where you can customize your portfolio that will be displayed on the exhibition website.</p>
				</div>
			</div>
		</div>
		<script src="js/editor.js"></script>
		<script src="js/modules.js"></script>
		<script src="js/home.min.js"></script>
	</body>
</html>
