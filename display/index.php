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

		<div class="container">
			<div class="container-row">
				<div class="col-12 colmd-4 collrg-4 colxlrg-4">
					<div class="card">
						<h2>A student here</h2>
						<p><i>Web & UX</i></p>
					</div>
				</div>
				<div class="col-12 colmd-4 collrg-4 colxlrg-4">
					<div class="card">
						<h2>A student here</h2>
						<p><i>Web & UX</i></p>
					</div>
				</div>
				<div class="col-12 colmd-4 collrg-4 colxlrg-4">
					<div class="card">
								<div class="card-img">
									<img src="img/vin.jpg"/>
								</div>
								<div class="card-content">
									<h2>A student here</h2>
									<p><i>Web & UX</i></p>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<script src="js/main.min.js"></script>
	</body>
</html>
