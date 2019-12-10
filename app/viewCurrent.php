<?php

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../../');
$dotenv->load();

require_once 'includes/dbc.php';
require_once 'includes/statement.php';

if (!isset($_SESSION['id'])) header('Location: index.php');

if ($_SESSION['type'] == 'member') {
	if ($_GET['student']) {
		$sql = "SELECT profileImage, firstName, lastName, class FROM users WHERE id = ?";
		$result = prep_stmt($conn, $sql, "i", [$_GET['student']]);
		if ($row = mysqli_fetch_assoc($result)) {
			$userId = $_GET['student'];
			if ($row['profileImage'] == NULL) {
				$profile = 'images/default-profile.png';
			} else {
				$profile = $row['profileImage'];
			}
			$firstName = $row['firstName'];
			$lastName = $row['lastName'];
			$class = $row['class'];
			if ($class == 'web') {
				$classType = 'Web & UX Design';
			} else if ($class == 'game') {
				$classType = 'Game Art & Development';
			} else if ($class == 'graphic') {
				$classType = 'Creative Digital Design';
			}
		} else {
			echo 'Failed accessing the students work. Try again in a fiew minutes';
			exit();
		}
	} else {
		echo 'Can not access student. Try the link from the dashboard';
		exit();
	}
} else {
	$userId = $_SESSION['id'];
	if ($_SESSION['profileImage'] == NULL) {
		$profile = 'images/default-profile.png';
	} else {
		$profile = $_SESSION['profileImage'];
	}
	$firstName = $_SESSION['firstName'];
	$lastName = $_SESSION['lastName'];
	$class = $_SESSION['class'];
	if ($class == 'web') {
		$classType = 'Web & UX Design';
	} else if ($class == 'game') {
		$classType = 'Game Art & Development';
	} else if ($class == 'graphic') {
		$classType = 'Creative Digital Design';
	}
}

if ($_GET['type']) {
	if ($_GET['type'] == 'draft') {
		$type = 'dataJSONdraft';
		$sql = "SELECT dataJSONdraft FROM portfolio WHERE userId = ?";
		$errorString = "There seems to be an issue getting your portfolio. Have you pressed the save button?";
	} else if ($_GET['type'] == 'live') {
		$type = 'dataJSON';
		$sql = "SELECT dataJSON FROM portfolio WHERE userId = ?";
		$errorString = "Your portfolio is currently under review. It will be visable here once it has passed.";
	}
} else {
	echo 'There seems to be an issue viewing the page. Try again from your dashboard';
}

$result = prep_stmt($conn, $sql, "i", [$userId]);

if ($row = mysqli_fetch_assoc($result)) {
	if ($row[$type]) {
		$data = $row[$type];
	} else {
		echo $errorString;
		exit();
	}
} else {
	echo $errorString;
	exit();
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
		<link href="css/main.min.css" rel="stylesheet">
		<title>Viewing <?php echo $_GET['type']; ?> portfolio</title>
	</head>
	<body class="view">
		<div class="header">
			<div class="profile">
				<img src="<?php echo $profile; ?>" alt="Image of <?php echo $firstName . ' ' . $lastName; ?>">
				<h2><?php echo $firstName . ' ' . $lastName; ?></h2>
				<p class="<?php echo $class; ?>"><?php echo $classType; ?></p>
			</div>
		</div>
		<div class="section">
			<div id="content"></div>
		</div>
		<script>let data = <?php echo $data; ?></script>
		<script src="js/render.min.js"></script>
	</body>
</html>