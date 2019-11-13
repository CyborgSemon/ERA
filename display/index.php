<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../');
$dotenv->load();

require 'includes/dbc.php';
require 'includes/statement.php';

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
	<link href="css/main.min.css" rel="stylesheet">
</head>
<body>

	<div class="container-fluid">

		<div class="studentHero col-12 colsml-21 colmd-12 collrg-12 colxlrg-12">

		<div class="justify-content">
			<img class="portrait" src="img/vin.jpg">
		</div>

		<div class="content">
			<h3>Vin Diesel</h3>
			<p><i>You know this ain't no 10-second race</i></p>
		</div>


		</div>


		<div class="container-row">
			<div class="colmd-1 collrg-1 colxlrg-2"></div>
			<div class="landing col-12 colmd-10 collrg-10 colxlrg-8">
				<h1 id="E" class="era">E</h1>
				<h1 id="R" class="era">R</h1>
				<h1 id="A" class="era">A</h1>
			</div>
			<div class="colmd-1 collrg-1 colxlrg-2"></div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="container-row">
			<div class="justify-content col-12 colsml-6 colmd-3 collrg-3 colxlrg-3">
				<div class="graphic card container-row">
					<div class="col-4">
						<img class="card-img" src="img/vin.jpg">
					</div>
					<div class="col-8">
						<div class="card-content">
							<h2>Vin Diesel</h2>
							<p><i>Web & UX</i></p>
							<p>maybe an extract here from the students bio?</p>
						</div>
					</div>
				</div>
			</div>
			<div class="justify-content col-12 colsml-6 colmd-3 collrg-3 colxlrg-3">
				<div class="web card container-row">
					<div class="col-4">
						<img class="card-img" src="img/vin.jpg">
					</div>
					<div class="col-8">
						<div class="card-content">
							<h2>Vin Diesel</h2>
							<p><i>Web & UX</i></p>
							<p>maybe an extract here from the students bio?</p>
						</div>
					</div>
				</div>
			</div>
			<div class="justify-content col-12 colsml-6 colmd-3 collrg-3 colxlrg-3">
				<div class="gameArt card container-row">
					<div class="col-4">
						<img class="card-img" src="img/vin.jpg">
					</div>
					<div class="col-8">
						<div class="card-content">
							<h2>Vin Diesel</h2>
							<p><i>Web & UX</i></p>
							<p>maybe an extract here from the students bio?</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="studentPage">
		<div class="container-row">
			<div class="portraitLrg col-4 colsml-4 colmd-4 collrg-4 colxlrg-4">
				<img src="img/vin.jpg">
			</div>
			<div class="bioLrg col-8 colsml-8 colmd-8 collrg-8 colxlrg-8">
				<h2> Big Daddy Diesel </h2>
				<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
			</div>
		</div>
	</div>

	<script src="node_modules/jquery/dist/jquery.js"></script>
	<script src="js/main.min.js"></script>
</body>
</html>
