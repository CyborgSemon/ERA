<?php

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'../../../');
$dotenv->load();

require_once 'includes/dbc.php';
require_once 'includes/statement.php';

if (!isset($_SESSION['id'])) header('Location: index.php');
if ($_SESSION['type'] != 'member') header('Location: home.php');

$sql = "SELECT users.firstName, users.lastName, users.class, users.profileImage, portfolio.* FROM (portfolio INNER JOIN users ON portfolio.userId = users.id) WHERE portfolio.active = 'pending' OR portfolio.active = 'passedDraftPending'";
$result = prep_stmt($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
	$data = [];
	do {
		array_push($data, $row);
	} while ($row = mysqli_fetch_assoc($result));
} else {
	$msg = 'Nothing to review';
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
		<div id="snackbar">
			<span id="snackbarMsg"></span>
		</div>
		<div id="dialogMultiple" class="dialog">
			<div class="dialogContainer">
				<h3>Add a Multiple students via CSV:</h3>
				<div class="inputs">
					<div class="inputField">
						<input type="file" accept=".csv" id="multipleUpload" name="multipleCsvUpload" autocomplete="off">
						<div class="inputBorder"></div>
					</div>
				</div>
				<div class="dialogButtons">
					<button class="cancel" id="cancelMultiple" type="button" name="button">Cancel</button>
					<button class="accept" id="acceptMultiple" type="button" name="button">Add</button>
				</div>
			</div>
			<div class="dialogBackground"></div>
		</div>
		<div id="dialogNew" class="dialog">
			<div class="dialogContainer">
				<h3>Add a new student:</h3>
				<div class="inputs">
					<div class="inputField">
						<input type="text" id="usernameNew" name="username" autocomplete="off" placeholder="Student Login Number">
						<label for="usernameNew">Student Login Number</label>
						<div class="inputBorder"></div>
					</div>
					<div class="inputField">
						<input type="text" id="firstNameNew" name="firstName" autocomplete="off" placeholder="Student First Name">
						<label for="firstNameNew">Student First Name</label>
						<div class="inputBorder"></div>
					</div>
					<div class="inputField">
						<input type="text" id="lastNameNew" name="lastName" autocomplete="off" placeholder="Student Last Name">
						<label for="lastNameNew">Student Last Name</label>
						<div class="inputBorder"></div>
					</div>
					<div class="inputField">
						<input type="email" id="emailNew" name="email" autocomplete="off" placeholder="Student Email">
						<label for="emailNew">Student Email</label>
						<div class="inputBorder"></div>
					</div>
					<div class="inputField">
						<input type="file" accept="image/*" id="profileNew" name="profileName" autocomplete="off">
						<div class="inputBorder"></div>
					</div>
					<div class="caption">Max image size: 50 MB</div>
					<div id="radioField">
						<p>Student Class</p>
						<div class="radioButton">
							<input type="radio" id="r1" name="class" value="web">
							Web
						</div>
						<div class="radioButton">
							<input type="radio" id="r2" name="class" value="graphic">
							Graphic
						</div>
						<div class="radioButton">
							<input type="radio" id="r3" name="class" value="game">
							Game
						</div>
					</div>
				</div>
				<div class="dialogButtons">
					<button class="cancel" id="cancelNew" type="button" name="button">Cancel</button>
					<button class="accept" id="acceptNew" type="button" name="button">Add</button>
				</div>
			</div>
			<div class="dialogBackground"></div>
		</div>
		<div id="dialog" class="dialog" data-student="">
			<div class="dialogContainer">
				<div id="txt"></div>
				<div class="dialogButtons">
					<button class="cancel" id="cancel" type="button" name="button">Cancel</button>
					<button class="accept" id="accept" type="button" name="button">Yes</button>
				</div>
			</div>
			<div class="dialogBackground"></div>
		</div>
		<div class="admin">
			<h2>Hey there <?php echo $_SESSION['firstName']; ?>!</h2>
			<div class="adminButtons">
				<button id="newUser">Add New Student</button>
				<button id="addMultiple">Add Multiple Students</button>
				<a href="includes/logout.php">Logout</a>
			</div>
		</div>
		<div class="admin">
			<h2>Pending Portfolios:</h2>
		</div>
		<div class="memberContainer">
			<?php
			if ($msg) {
				echo "<h3>$msg</h3>";
			} else {
				for ($i=0; $i < count($data); $i++) {

					echo '<div class="memberCard" data-id="'.$data[$i]['userId'].'" data-name="'.$data[$i]['firstName'].' '.$data[$i]['lastName'].'">
						<div class="top">
							<div class="profile">
								<img src="'.$data[$i]['profileImage'].'">
							</div>
							<div class="text">
								<div class="name">
									'.$data[$i]['firstName'].' '.$data[$i]['lastName'].'
								</div>
								<div class="class">
									'.ucfirst($data[$i]['class']).'
								</div>
							</div>
							<div class="buttons">
								<a class="view" href="viewCurrent.php?type=draft&student='.$data[$i]['userId'].'" target="_blank">View</a>
								<div class="accept" id="accept'.$data[$i]['userId'].'">Approve</div>
								<div class="decline" id="fail'.$data[$i]['userId'].'">Decline</div>
							</div>
						</div>
						<div class="feedback">
							<textarea id="feedback'.$data[$i]['userId'].'" placeholder="Give some feedback"></textarea>
						</div>
					</div>';
				}
			}

			?>
		</div>
		<script src="js/ajax.min.js"></script>
		<script src="js/member.min.js"></script>
	</body>
</html>
