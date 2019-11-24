<?php

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../');
$dotenv->load();

require_once 'includes/dbc.php';
require_once 'includes/statement.php';

if (!isset($_SESSION['id'])) header('Location: index.php');
if ($_SESSION['type'] != 'member') header('Location: home.php');

$sql = "SELECT users.firstName, users.lastName, users.class, users.profileImage, portfolio.* FROM (portfolio INNER JOIN users ON portfolio.userId = users.id) WHERE portfolio.active = 'pending' OR portfolio.active = 'passedDraftPending'";
$result = prep_stmt($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
	$data = [];
	do {
		array_push($data, $row);
	} while ($row = mysqli_fetch_assoc($result));
} else {
	echo 'Nothing to review';
	exit();
}

// print_r($data);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
		<link href="css/main.min.css" rel="stylesheet">
	</head>
	<body>
		<?php

		for ($i=0; $i < count($data); $i++) {
			echo $data[$i]['firstName'].'\'s portfolio needs to be reviewed. View it <a href="viewCurrent.php?type=draft&student='.$data[$i]['userId'].'" target="_blank">here</a><br><br>';
		}

		?>

		<br>
		<br>
		<a href="includes/logout.php">Logout</a>
	</body>
</html>