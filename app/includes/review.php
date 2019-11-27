<?php

require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../../../');
$dotenv->load();

require_once 'dbc.php';
require_once 'statement.php';

if (!$_SESSION['id'] || $_SESSION['type'] == 'student') {
	echo 'You dont have permission to access this page';
	exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['feedback'])) {
		$sql = "SELECT * FROM portfolio WHERE userId = ?";
		$result = prep_stmt($conn, $sql, 'i', [$_POST['userId']]);

		if ($row = mysqli_fetch_assoc($result)) {
			if ($_POST['active'] == 'fail') {
				if ($row['active'] == 'pending') {
					// Failed from pedning
					$sql = "UPDATE portfolio SET active = ?, feedback = ? WHERE userId = ?";
					$valueString = "ssi";
					$values = ['failed', $_POST['feedback'], $_POST['userId']];
				} else if ($row['active'] == 'passedDraftPending') {
					// Failed from passedDraftPending
					$sql = "UPDATE portfolio SET active = ?, feedback = ? WHERE userId = ?";
					$valueString = "ssi";
					$values = ['passedDraftFailed', $_POST['feedback'], $_POST['userId']];
				}
				$msg = 'Review sent';
			} else if ($_POST['active'] == 'pass') {
				// Passed from any stage
				$sql = "UPDATE portfolio SET active = ?, feedback = ?, dataJSON = dataJSONdraft WHERE userId = ?";
				$valueString = "ssi";
				$values = ['pass', $_POST['feedback'], $_POST['userId']];
				$msg = 'Portfolio passed';
			}
			prep_stmt($conn, $sql, $valueString, $values);
			echo $msg;
		} else {
			echo 'That student does not exist';
		}
	} else {
		echo 'Feedback must be given';
	}
} else {
	echo 'You dont have permission to access this page';
}

?>