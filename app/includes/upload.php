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
	$sql = 'SELECT MAX(id) AS id FROM uploads';

	$result = prep_stmt($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$maxId = $row['id']+1;
	$newFileName = $maxId;

	$filePath = pathinfo($_FILES['image']['name']);
	$uploadedFileName = $filePath['filename'];
	$uploadedFileExt = $filePath['extension'];

	$newFileName .= '.' . $uploadedFileExt;

	$fileUrl = 'http://'.$_SERVER['HTTP_HOST'].dirname(dirname($_SERVER['REQUEST_URI'])).'/uploadsLink/'.$newFileName;;

	if (move_uploaded_file($_FILES['image']['tmp_name'], '../../uploads/'.$newFileName)) {
		$sql = 'INSERT INTO uploads(id, userId, fileName, fileExt, url) VALUES (?, ?, ?, ?, ?)';
		prep_stmt($conn, $sql, 'iisss', [$maxId, $_SESSION['id'], $uploadedFileName, $uploadedFileExt, $fileUrl]);

		$result->success = 1;
		$result->file->url = $fileUrl;
		echo json_encode($result);
	} else {
		$result->success = 0;
		echo json_encode($result);
	}
} else {
	echo 'You dont have permission to access this page';
}

?>