<?php

require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../../../');
$dotenv->load();

require_once 'dbc.php';
require_once 'statement.php';

if (!$_SESSION['id']) {
	echo 'You dont have permission to access this page';
	exit();
}

if ($_SESSION['type'] != 'member') {
	echo 'You dont have permission to access this page';
	exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $csv = array_map('str_getcsv', file($_FILES['file']['tmp_name']));
    array_shift($csv); # remove column header
	$failedStudents = [];
    foreach ($csv as $user){
        $sql = "SELECT * FROM users WHERE BINARY username = ?";
        $result = prep_stmt($conn, $sql, "s", [$user[0]]);
        if (!$row = mysqli_fetch_assoc($result)) {
            $sql = "INSERT INTO users (id, username, password, email, firstName, lastName, class, profileImage, type) VALUES (NULL, ?, ?, ?, ?, ?, ?, NULL, 'student')";
			if ($user[0] != '' && $user[1] != '' && $user[2] != '' && $user[3] != '' && $user[4]) {
				$result = prep_stmt($conn, $sql, "ssssss", [$user[0], password_hash($user[0], PASSWORD_DEFAULT), $user[1], $user[2], $user[3], $user[4]]);
			} else {
				array_push($failedStudents, $user[2]);
			}
        }
    }
    if (count($failedStudents) == 0) {
    	echo 'done';
    } else {
		$finalString = 'done-';
		for ($i=0; $i < count($failedStudents); $i++) {
			$finalString += $failedStudents[$i].', ';
		}
		echo $finalString;
	}
} else {
	echo 'You dont have permission to access this page';
}

?>
