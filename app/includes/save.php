<?php

require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../../');
$dotenv->load();

require_once 'dbc.php';
require_once 'statement.php';

if (!$_SESSION['id']) {
	echo 'You dont have permission to access this page';
	exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$sql = "SELECT * FROM portfolio WHERE userId = ?";
	$result = prep_stmt($conn, $sql, "i", [$_SESSION['id']]);

	if ($row = mysqli_fetch_assoc($result)) {
		if ($row['active'] == 'failed') {
			$sql = "UPDATE portfolio SET dataJSON = ?, active = ? WHERE id = ?";
			$valueString = 'ssi';
			$values = [$_POST['data'], 'pending', $row['id']];
		} else if ($row['active'] == 'pending' || $row['active'] == 'pass') {
			$sql = "UPDATE portfolio SET dataJSON = ? WHERE id = ?";
			$valueString = 'si';
			$values = [$_POST['data'], $row['id']];
		}

		prep_stmt($conn, $sql, $valueString, $values);

		echo 'updated';
	} else {
		$sql = "INSERT INTO portfolio (id, userId, dataJSON, active, feedback) VALUES (NULL, ?, ?, ?, ?)";
		prep_stmt($conn, $sql, 'isss', [$_SESSION['id'], $_POST['data'], 'pending', '']);

		echo 'done';
	}
} else {
	echo 'You dont have permission to access this page';
}

?>