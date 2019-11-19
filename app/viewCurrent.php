<?php

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../');
$dotenv->load();

require_once 'includes/dbc.php';
require_once 'includes/statement.php';

if (!isset($_SESSION['id'])) header('Location: index.php');

$sql = "SELECT dataJSON FROM portfolio WHERE userId = ?";
$result = prep_stmt($conn, $sql, "i", [$_SESSION['id']]);

if ($row = mysqli_fetch_assoc($result)) {
	$data = $row['dataJSON'];
} else {
	echo 'You dont seem to have a portfolio. Have you remembered to save?';
	exit();
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
		<link href="css/main.min.css" rel="stylesheet">
	</head>
	<body class="view">
		<div class="header">
			<div class="profile">
				<img src="<?php echo $_SESSION['profileImage']; ?>" alt="Image of <?php echo $_SESSION['firstName'] . ' ' . $_SESSION['lastName']; ?>">
				<h2><?php echo $_SESSION['firstName'] . ' ' . $_SESSION['lastName']; ?></h2>
				<p class="<?php echo $_SESSION['class']; ?>"><?php echo $_SESSION['class']; ?></p>
			</div>
		</div>
		<div class="section">
			<div id="content"></div>
		</div>
		<script>let data = <?php echo $data; ?></script>
		<script src="js/render.min.js"></script>
	</body>
</html>