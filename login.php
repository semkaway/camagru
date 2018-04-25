<?php
	session_start();
	require_once('config/database.php');
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if ($_POST["login"] != "" && $_POST['password'] != "" && $_POST["submit"] == "OK") {
		$log_check = $db->prepare("SELECT COUNT(login) FROM users WHERE login = :login");
		$log_check->execute(['login' => $_POST["login"]]);
		$check_login = $log_check->fetchColumn();
		if ($check_login != 1) {
			?>
			<script type="text/javascript">
				alert("User with this login does not exist!");
				window.location.href = 'index.php';
			</script>
		<?php
		}
		$result = $db->prepare("SELECT password FROM users WHERE login = :login");
		$result->execute(['login' => $_POST["login"]]);
		$check_pass = $result->fetchColumn();
		if (hash('whirlpool', $_POST['password']) != $check_pass) {
			?>
			<script type="text/javascript">
				alert("User with this password does not exist!");
				window.location.href = 'index.php';
			</script>
		<?php
		} else {
			$email = $db->prepare("SELECT email FROM users WHERE login = :login");
			$email->execute(['login' => $_POST["login"]]);
			$check_mail = $email->fetchColumn();
			$_SESSION['user'] = $_POST["login"];
			?>
			<script type="text/javascript">
				window.location.href = 'profile.php';
			</script>
			<?php
		}
	}
	else if (($_POST["login"] == "" || $_POST['password'] == "") && $_POST["submit"] == "OK") {
	?>
	<script type="text/javascript">
		alert("All fields must be filled!");
		window.location.href = 'index.php';
	</script>
	<?php
	}
?>