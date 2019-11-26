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
	$data = $row['dataJSONdraft'];
	$status = $row['active'];
	$feedback = $row['feedback'];
}

if ($status) {
	if ($status == 'pending' || $status == 'pass' || $status == 'failed') {
		$mainSpan = $status;
		if ($status == 'pass') {
			$mainSpan = 'passed';
			$subSpan = 'passed';
		}
	} else if ($status == 'passedDraftPending') {
		$mainSpan = 'pending';
		$subSpan = 'passed';
	} else if ($status == 'passedDraftFailed') {
		$mainSpan = 'failed';
		$subSpan = 'passed';
	}
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
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
						<?php if (isset($subSpan)) echo '<span>Live portfolio status: '.$subSpan.'</span><br>'; ?>
						<span>Draft portfolio status: <?php echo (isset($mainSpan) ? $mainSpan : 'empty'); ?></span>
						<br>
						<a class="accountButton" href="viewCurrent.php?type=draft" target="_blank">View Draft</a>
						<br>
						<?php if (isset($subSpan)) echo '<a class="accountButton" href="viewCurrent.php?type=live" target="_blank">View Live</a><br>'; ?>
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
				<?php if ($feedback) echo '<div class="feedback card">'.$feedback.'</div>'; ?>
				<div class="editor card" id="editor"></div>
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
