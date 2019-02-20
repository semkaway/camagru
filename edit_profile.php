<?php
session_start();
include ("config/database.php");
require ("includes/header.php");

$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$status = $db->prepare('SELECT notifications FROM users WHERE login = :login');
$status->execute(['login' => $_SESSION['user']]);
$value = $status->fetchColumn();

?>
	<title>Edit profile</title>
</head>
<body>
	<div class="header-page"></div>
	<div class="wrapper">
            <div class="sidebar">
            	<div>
                   	<a href="index.php"><img class="logo" src="img/logo.png"></a>
	                <div>
	                    <a href="index.php">
	                        <div class="button">
	                            Home
	                        </div>
	                    </a>
	                    <a href="take_picture.php">
	                        <div class="button">
	                            Take picture
	                        </div>
	                    </a>
	                    <a href="profile.php">
	                        <div class="button">
	                            My profile
	                        </div>
	                    </a>
	                    <a href="logout.php">
	                        <div class="button">
	                            Log out
	                        </div>
	                    </a>
	                </div>
            	</div>
            </div>
            <div class="edit-data">
				<p class="header">Change password</p>
				<form class="text-box" action="edit_pass.php" name="edit" method="post">
					<p>Your password must be between 6 and 9 characters long *</p>
					Old password: <input type="password" name="old" minlength="6" maxlength="9" required>
					<br />
					New password: <input type="password" name="password" value="" minlength="6" maxlength="9" required>
					<br />
					<input class="button" type="submit" name="submit" value="OK">
				</form>
				<p class="header">Change login</p>
				<form class="text-box" action="edit_login.php" name="edit" method="post">
					New login: <input type="text" name="login" required>
					<br />
					<input class="button" type="submit" name="submit" value="OK">
				</form>
				<p class="header">Change email</p>
				<form class="text-box" action="edit_email.php" name="edit" method="post">
					New email: <input type="text" name="email" required>
					<br />
					<input class="button" type="submit" name="submit" value="OK">
				</form>
				<p class="header">E-mail notifications</p>
				<form class="hidden" name="notifications" method="post">
						<input type="hidden_data" id="hidden_data" name="hidden_data" value="">
					</form>
				<form class="text-box" name="edit" method="post">
					<?php if ($value =='YES') : ?>
						<input id="recieve" type="checkbox" name="email" value="recieve" onclick="resetButtons('dont-receive')" checked>I want to recieve e-mails when someone leaves a like or comment for my picture (default)					<br />
						<input id="dont-receive" type="checkbox" name="email" value="dont-recieve" onclick="resetButtons('recieve')">I don't want any of this crap<br />
					<?php endif ?>
					<?php if ($value =='NO') : ?>
						<input id="recieve" type="checkbox" name="email" value="recieve" onclick="resetButtons('dont-receive')">I want to recieve e-mails when someone leaves a like or comment for my picture (default)					<br />
						<input id="dont-receive" type="checkbox" name="email" value="dont-recieve" onclick="resetButtons('recieve')" checked>I don't want any of this crap<br />
					<?php endif ?>
					<input id="notifications" class="button" type="submit" name="submit" value="OK">
				</form>
			</div>
		</div>
		<script type="text/javascript">
			const notificationsButton = document.getElementById('notifications');
			function resetButtons(id) {
				document.getElementById(id).checked = false;
			}

			notificationsButton.addEventListener('click', () => {
				if (document.getElementById('recieve').checked == true)
					document.getElementById('hidden_data').value = 'YES';
				else
					document.getElementById('hidden_data').value = 'NO';
				var fd = new FormData(document.forms["notifications"]);
				var xhr = new XMLHttpRequest();
				xhr.open('POST', 'notifications.php', true);
				xhr.send(fd);
			});
		</script>
		<?php include("includes/footer.php"); ?>
</body>
</html>