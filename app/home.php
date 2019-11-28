<?php

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../../');
$dotenv->load();

require_once 'includes/dbc.php';
require_once 'includes/statement.php';

if (!isset($_SESSION['id'])) header('Location: index.php');
if (!isset($_SESSION['type'])) header('Location: newLogin.php');

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
		<link href="css/imageCrop.min.css" rel="stylesheet">
		<link href="css/main.min.css" rel="stylesheet">
	</head>
	<body class="homeDash">
		<div id="snackbar">
			<span id="snackbarMsg"></span>
		</div>
		<div id="uplaodImageDialog" class="dialog">
			<div class="dialogContainer">
				<h3>Add a profile picture:</h3>
				<div class="inputs" id="inputImage">
					<div class="inputField">
						<input type="file" accept="image/*" id="newProfile" name="profileName" autocomplete="off">
						<div class="inputBorder"></div>
					</div>
					<div class="caption">Max image size: 50 MB</div>
					<span id="loading">Loading</span>
					<div id="imageCropContainer">
						<img id="cropper">
					</div>
				</div>
				<div class="dialogButtons">
					<button class="cancel" id="cancelImage" type="button" name="button">Cancel</button>
					<button class="accept" id="acceptImage" type="button" name="button">Add</button>
				</div>
			</div>
			<div class="dialogBackground"></div>
		</div>
		<div class="container">
			<div class="actions">
				<div class="card">
					<h2>Hey there <?php echo $_SESSION['firstName'] ?>!</h2>
					<img id="profileImage" class="profileImage" src="<?php echo ($_SESSION['profileImage'] == NULL) ? '' : $_SESSION['profileImage']; ?>">
					<div class="buttons">
						<?php if (isset($subSpan)) echo '<span>Live portfolio status: '.$subSpan.'</span><br>'; ?>
						<span id="draftStatus">Draft portfolio status: <?php echo (isset($mainSpan) ? $mainSpan : 'empty'); ?></span>
						<br>
						<button class="accountButton" id="uplaodImage">Uplaod Profile Picture</button>
						<br>
						<?php if (isset($subSpan)) echo '<a class="accountButton" href="viewCurrent.php?type=live" target="_blank">View Live</a><br>'; ?>
						<a class="accountButton" href="viewCurrent.php?type=draft" target="_blank">View Draft</a>
						<br>
						<button class="accountButton" id="save" type="button" name="button">Save</button>
						<br>
						<a class="accountButton" href="includes/logout.php">Logout</a>
					</div>
				</div>
			</div>
			<div class="instructions">
				<div class="card">
					<h2>Instructions:</h2>
					<p>Welcome to your profile page!</p>
					<p>This is where you can customize your portfolio that will be displayed on the exhibition website.</p>
					<p>This editor is just like any word document. Press Enter to make a new line and you can type away.</p>
					<p>This editor also has a few extra features. You also have simple text editor tool by highlighting some text. These include, Bold text, Italic text and making a link</p>
					<p>You can also add a heading or an image by using the + button whenever you make a new line.</p>
					<p>It also supports youtube videos! Just paste in the URL of the youtube video you want to use and it will appear.</p>
					<p>You then have more options on line positioning, image width and heading type by clicking the 3 dots to the right of a selected line. This is also where you can delete a line if you dont want it anymore.</p>
					<p><b>Remember to save your portfolio using the save button!</b></p>
				</div>
			</div>
			<div class="content">
				<?php if ($feedback) echo '<div class="feedback card"><h2>Feedback:</h2>'.$feedback.'</div>'; ?>
				<div class="editor card" id="editor"></div>
			</div>
		</div>
		<?php
		if ($data) echo '<script>let data = '.$data.';</script>';
		?>
		<script src="js/editor.js"></script>
		<script src="js/ajax.min.js"></script>
		<script src="js/imageCrop.min.js"></script>
		<script src="js/home.min.js"></script>
	</body>
</html>
