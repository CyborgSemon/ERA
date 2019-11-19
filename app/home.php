<?php

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../');
$dotenv->load();

require_once 'includes/dbc.php';
require_once 'includes/statement.php';

if (!isset($_SESSION['id'])) header('Location: index.php');

$sql = "SELECT * FROM portfolio WHERE userId = ?";
$result = prep_stmt($conn, $sql, "i", [$_SESSION['id']]);

if ($row = mysqli_fetch_assoc($result)) {
	$data = $row['dataJSON'];
	$status = $row['active'];
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
		<div id="snackbar">
			<span id="snackbarMsg"></span>
		</div>
		<div class="container">
			<div class="actions">
				<div class="card">
					<img class="profileImage" src="<?php echo $_SESSION['profileImage']; ?>">
					<div class="buttons">
						<span>Portfolio status: <?php echo (isset($status) ? $status : 'empty'); ?></span>
						<br>
						<a class="accountButton" href="viewCurrent.php" target="_blank">View Portfolio</a>
						<br>
						<button class="accountButton" id="save" type="button" name="button">Save</button>
						<br>
						<a class="accountButton" href="includes/logout.php">Logout</a>
					</div>
				</div>
			</div>
			<div class="instructions">
				<div class="card">
					<h2>Instructions</h2>
					<p>Welcome to your profile page!</p>
					<p>This is where you can customize your portfolio that will be displayed on the exhibition website.</p>
					<p></p>
				</div>
			</div>
			<div class="content">
				<div class="editor card" id="editor">
				</div>
			</div>
		</div>
		<?php
		if ($data) echo '<script>let data = '.$data.';</script>';
		?>
		<script src="js/editor.js"></script>
		<script src="js/modules.js"></script>
		<script src="js/ajax.min.js"></script>
		<script src="js/home.min.js"></script>
	</body>
</html>
