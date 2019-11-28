<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'/../');
$dotenv->load();

require 'includes/dbc.php';
require 'includes/statement.php';


$dataReq = "SELECT users.id, users.firstName, users.lastName, users.class, users.profileImage, users.type, portfolio.active, portfolio.dataJSON FROM (users INNER JOIN portfolio ON users.id = portfolio.userId) WHERE users.type = 'student' AND portfolio.active = 'pass' OR portfolio.active = 'passedDraftPending' ORDER BY users.firstName";
$result = prep_stmt($conn, $dataReq);

if ($row = mysqli_fetch_assoc($result)) {
	$data = array();
	do {
		array_push($data, $row);
	} while ($row = mysqli_fetch_assoc($result));
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
		<link href="css/main.min.css" rel="stylesheet">
	</head>
	<body>
		<div id="header">
			<div id="exit">&times;</div>
			<div id="profile"></div>
		</div>
		<div id="footer">
			<div id="content"></div>
		</div>
		<div class="logo">

		</div>
		<div class="container">
			<div class="topArea">
				<div class="filter">
					<button id="graphicBtn" class="active">
						Creative Digital
						<div class="buttonBorder"></div>
					</button>
					<button id="gameBtn" class="active">
						Game Development
						<div class="buttonBorder"></div>
					</button>
					<button id="webBtn" class="active">
						Web & UX
						<div class="buttonBorder"></div>
					</button>
				</div>
			</div>
			<div id="students">
				<?php

					if ($data) {
						$card = '';

						for ($i=0; $i < count($data); $i++) {
							$name = $data[$i]['firstName'] . ' ' . $data[$i]['lastName'];
							$card .= '<div class="card '.$data[$i]['class'].'" data-id="'.$i.'">
								<div class="cardContent">
									<img src="'.$data[$i]['profileImage'].'" alt="Image of '.$name.'">
									<div class="cardText">
										<h2>'.$name.'</h2>
										<p>'.ucfirst($data[$i]['class']).'</p>
									</div>
								</div>
								<div class="cardBorder"></div>
							</div>';
						}
						$card .= '<h3 id="studentError"></h3>';
						echo $card;
					} else {
						echo '<h3 id="studentError">No students</h3>';
					}

				?>
			</div>
		</div>
		<?php
		if ($data) echo '<script>let data = '.json_encode($data).';</script>';
		?>
		<script src="js/main.min.js"></script>
	</body>
</html>
