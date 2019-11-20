<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../');
$dotenv->load();

require 'includes/dbc.php';
require 'includes/statement.php';

$dataReq = "SELECT users.id, users.firstName, users.lastName, users.class, users.profileImage, users.type, portfolio.active FROM (users INNER JOIN portfolio ON users.id = portfolio.userId) WHERE users.type = 'student' AND portfolio.active = 'pass'";
$result = prep_stmt($conn, $dataReq);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
	<link href="css/main.min.css" rel="stylesheet">
</head>
<body>
	<script src="js/ajax.min.js"></script>

	<div id="header">
		<div class="container-row justify-content">
			<img class="portrait col-3 colsml-6 colmd-1 collrg-1 colxlrg-1" src="img/vin.jpg">
		</div>

		<div class="container-row">
			<div class="content col-12 colsml-12 colmd-12 collrg-12 colxlrg-12">
				<h3>Vin Diesel</h3>
				<p><i>You know this ain't no 10-second race</i></p>
			</div>
		</div>
	</div>

	<div class="logo container-fluid">

		<div class="container-row">
			<div class="colmd-1 collrg-1 colxlrg-2"></div>
			<div class="landing col-12 colmd-10 collrg-10 colxlrg-8">
				<img id="E" class="era" src="img/E.png"></h1>
				<img id="R" class="era" src="img/R.png"></h1>
				<img id="A" class="era" src="img/A.png"></h1>
			</div>
			<div class="colmd-1 collrg-1 colxlrg-2"></div>
		</div>
	</div>

	<div class="container-row justify-content">
			<button class="btn web">
				Web & UX
			</button>
			<button class="btn">
				Graphic Design
			</button>
			<button class="btn">
				Game Art
			</button>
	</div>

	<div class="cardHolder container-fluid">
		<div class="container-row">

			 <?php
				 $card = '';

				 if ($row = mysqli_fetch_assoc($result)) {
					 do {
						 $card .= '<div id="' . $row['id'] .'" class="col-12 colsml-6 colmd-4 collrg-4 colxlrg-4">';
						 $card .= '<div class="' . $row['class'] .' card btn container-row">';
						 $card .= '<div class="col-4">';
						 $card .= '<img class="card-img" src="img/vin.jpg">';
						 $card .= '</div>';
						 $card .= '<div class="col-8">';
						 $card .= '<div class="card-content">';
						 $card .= '<h2>' . $row['firstName'] . ' ' . $row['lastName'] .'</h2>';
						 $card .= '<p><i>' . $row['class'] . '</i></p>';
						 $card .= '<p>maybe an extract here from the students bio?</p>';
						 $card .= '</div></div></div></div>';
					 } while ($row = mysqli_fetch_assoc($result));
				 } else {
					 echo 'No students';
				 }
			echo $card;
	 ?>


<!--
			<div id ="graphic" class="col-12 colsml-6 colmd-4 collrg-4 colxlrg-4">
				<div class="graphic card container-row">
					<div class="col-4">
						<img class="card-img" src="img/vin.jpg">
					</div>
					<div class="col-8">
						<div class="card-content">
							<h2>Vin Diesel</h2>
							<p><i>graphic</i></p>
							<p>maybe an extract here from the students bio?</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 colsml-6 colmd-4 collrg-4 colxlrg-4">
				<div class="web card container-row">
					<div class="col-4">
						<img class="card-img" src="img/vin.jpg">
					</div>
					<div class="col-8">
						<div class="card-content">
							<h2>Vin Diesel</h2>
							<p><i>web</i></p>
							<p>maybe an extract here from the students bio?</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 colsml-6 colmd-4 collrg-4 colxlrg-4">
				<div class="gameArt card container-row">
					<div class="col-4">
						<img class="card-img" src="img/vin.jpg">
					</div>
					<div class="col-8">
						<div class="card-content">
							<h2>Vin Diesel</h2>
							<p><i>game art</i></p>
							<p>maybe an extract here from the students bio?</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> -->

	<div id="footer">
		<div class="container-row">
			<div class="col-12 colsml-12 colmd-12 collrg-12 colxlrg-12">
				<h4 id="exit">X</h4>
			</div>
		</div>
		<div class="container-row">
			<div class="portraitLrg col-12 colsml-12 colmd-4 collrg-4 colxlrg-4">
				<img class="graphic" src="img/vin.jpg">
			</div>
			<div class="bioLrg col-12 colsml-12 colmd-6 collrg-6 colxlrg-6">
				<h2> Big Daddy Diesel </h2>
				<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
			</div>
		</div>
	</div>

	<script src="js/main.min.js"></script>
</body>
</html>
