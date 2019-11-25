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
		<div id="<?php ?>" class="container-row justify-content">
			<img class="portrait col-3 colsml-6 colmd-1 collrg-1 colxlrg-1" src="img/vin.jpg">
		</div>

		<div class="container-row">
			<div class="content col-12 colsml-12 colmd-12 collrg-12 colxlrg-12">
				<h3>fdsd</h3>
				<p><i>You know this ain't no 10-second race</i></p>
			</div>
		</div>
	</div>

	<div id="sideNav" class="sideNav">
		<div id="sideClose" class="sideNavClose">&times;</div>
		<div class="container-row slider-row">
			<label class="switch web">
			  <input type="checkbox">
			  <span class="slider round"></span>
			</label>
			<p class="navSwitch">Graphic Design</p>
		</div>
		<div class="container-row slider-row">
			<label class="switch">
			  <input type="checkbox">
			  <span class="slider2 round"></span>
			</label>
			<p class="navSwitch">Web & UX</p>
		</div>
		<div class="container-row slider-row">
			<label class="switch">
			  <input type="checkbox">
			  <span class="slider3 round"></span>
			</label>
			<p class="navSwitch">Game Art</p>
		</div>
	</div>

	<div id="mobile" class="mobile">&#9776;</div>

	<div id="main">

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

	<div class="btnCon container-row">
			<button class="btn webBtn">
				Web & UX
			</button>
			<button class="btn graphicBtn">
				Graphic Design
			</button>
			<button class="btn gameBtn">
				Game Art
			</button>
	</div>

	<div class="cardHolder container-fluid">
		<div class="container-row justify-content">

			 <?php
				 $card = '';

				 if ($row = mysqli_fetch_assoc($result)) {
					 do {
						 $card .= '<div id="'. $row['class'] .'" class="' . $row['class'] .' justify-content col-12 colsml-6 colmd-4 collrg-4 colxlrg-4">';
						 $card .= '<div class="card btn container-row">';
						 $card .= '<div class="col-4">';
						 $card .= '<img class="card-img" src="img/vin.jpg">';
						 $card .= '</div>';
						 $card .= '<div class="col-8">';
						 $card .= '<div class="card-content">';
						 $card .= '<h2>' . $row['firstName'] . ' ' . $row['lastName'] .'</h2>';
						 $card .= '<p><i>' . $row['class'] . '</i></p>';
						 $card .= '<div class="border ' . $row['class'] .'"></div>';
						 $card .= '</div></div></div></div>';
					 } while ($row = mysqli_fetch_assoc($result));
				 } else {
					 echo 'No students';
				 }
			echo $card;
	 ?>



</div>

	<div id="footer">
		<div id="<?php ?>" class="container-row">
			<div class="col-12 colsml-12 colmd-12 collrg-12 colxlrg-12">
				<h4 id="exit">&times;</h4>
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

	<script src="js/main.js"></script>
</body>
</html>
