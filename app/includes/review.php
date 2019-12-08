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
				$emailMsg = '';
			}
			prep_stmt($conn, $sql, $valueString, $values);

			$sql = "SELECT firstName, lastName, email FROM users WHERE id = ?";

			$result = prep_stmt($conn, $sql, "i", [$_POST['userId']]);

			$row = mysqli_fetch_assoc($result);

			$emailMsg = "Hey there" . $row['firstName'] . " " . $row['lastName'] . "!\nThis email is to let you know that your ERA online portfolio has been reviewed and ";

			if ($msg == 'Portfolio passed') {
				$emailMsg .= "has passed! You can now view it at <a href\"https://era.yoobee.net.nz/\">https://era.yoobee.net.nz/</a>\n See you at the exhibition!";
			} else if ($msg == 'Review sent') {
				$emailMsg .= "unfortunately it has not passed. You can checkout the feedback given to your portfolio by logging back into the customiser page.\n(Here is the link just in case you forgot -> <a href=\"https://app.era.yoobee.net.nz/\">https://app.era.yoobee.net.nz/</a>)\nRemember any changes you make will have to go under review again to make sure to change anything you need fast so we have time review it before the exhibition!";
			}

			$emailMsg .= "\n\nThis email was auto generated opon review of your portfolio. Do not reply to this message as no one will see it if you do.";

			if (!mail($row['email'], 'ERA Portfolio Review', $emailMsg, 'From: noreply@era.yoobee.net.nz')) {
				$msg .= '. Email notification failed';
			}

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