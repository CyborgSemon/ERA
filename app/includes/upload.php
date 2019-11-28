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

ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '52M');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$sql = 'SELECT MAX(id) AS id FROM uploads';

	$result = prep_stmt($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$maxId = $row['id']+1;
	$newFileName = $maxId;

	if (isset($_POST['imageBlob'])) {
		$imageData = $_POST['imageBlob'];
		$pos = strpos($imageData, ';');
		$imageType = explode(':', substr($imageData, 0, $pos))[1];

		$extentions = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
		if ($extentions[$imageType]) {
			$newFileName .= '.' . $extentions[$imageType];
		} else {
			echo 'That is not a supported file type';
			exit();
		}
	} else {
		$filePath = pathinfo($_FILES['image']['name']);
		$uploadedFileName = $filePath['filename'];
		$uploadedFileExt = $filePath['extension'];

		$newFileName .= '.' . $uploadedFileExt;
	}

	if (isset($_SERVER['HTTPS'])) {
		$type = 'https://';
	} else  {
		$type = 'http://';
	}

	$fileUrl = $type.$_SERVER['HTTP_HOST'].dirname(dirname($_SERVER['REQUEST_URI'])).'/uploadsLink/'.$newFileName;;

	if (isset($_POST['imageBlob'])) {
		if (file_put_contents('../../uploads/'.$newFileName, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData)))) {
			$sql = "UPDATE users SET profileImage = ? WHERE id = ?";
			prep_stmt($conn, $sql, "si", [$fileUrl, $_SESSION['id']]);
			$_SESSION['profileImage'] = $fileUrl;
			echo $fileUrl;
		} else {
			echo 'failed';
		}
	} else if (move_uploaded_file($_FILES['image']['tmp_name'], '../../uploads/'.$newFileName)) {
		if (isset($_POST['profileImageSet']) && isset($_POST['urlOnly'])) {
			$sql = "UPDATE users SET profileImage = ? WHERE id = ?";
			prep_stmt($conn, $sql, "si", [$fileUrl, $_SESSION['id']]);
			$_SESSION['profileImage'] = $fileUrl;
			echo $fileUrl;
		} else {
			$sql = 'INSERT INTO uploads(id, userId, fileName, fileExt, url) VALUES (?, ?, ?, ?, ?)';
			prep_stmt($conn, $sql, 'iisss', [$maxId, $_SESSION['id'], $uploadedFileName, $uploadedFileExt, $fileUrl]);

			if (isset($_POST['urlOnly'])) {
				echo $fileUrl;
			} else {
				$result->success = 1;
				$result->file->url = $fileUrl;
				echo json_encode($result);
			}
		}
	} else {
		if (isset($_POST['urlOnly'])) {
			echo 'failed';
		} else {
			$result->success = 0;
			echo json_encode($result);
		}
	}
} else {
	echo 'You dont have permission to access this page';
}

?>