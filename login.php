<?php
	session_start();
	require_once('config/database.php');
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

	if ($_POST["login"] != "") {
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
	}else {
		?>
			<script type="text/javascript">
				window.location.href = 'welcome.php';
			</script>
		<?php
		$email = $db->prepare("SELECT email FROM users WHERE login = :login");
		$email->execute(['login' => $_POST["login"]]);
		$check_mail = $email->fetchColumn();
		$_SESSION['user'] = $_POST["login"];
		$_SESSION['email'] = $check_mail;
		$_SESSION['password'] = hash("whirlpool", $_POST["password"]);
		}
	}
?>