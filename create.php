<?php
	require_once('config/database.php');
	include ("functions/send_mail.php");
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$valid = 0;

if ($_POST["login"] == "" || $_POST["email"] == "" || $_POST["password"] == "")
	{
		?>
		<script type="text/javascript">
			alert("All fields must be filled!");
			window.location.href = 'index.php';
		</script>
		<?php
		$valid = 1;
		$valid = 1;
		$valid = 1;
	}


if ($_POST["login"] != "") {
	$result = $db->prepare("SELECT COUNT(login) FROM users WHERE login = :login");
	$result->execute(['login' => $_POST["login"]]);
	$number_of_rows = $result->fetchColumn(); 
	if ($number_of_rows > 0) {
		?>
		<script type="text/javascript">
			alert("User with this login already exists!");
			window.location.href = 'index.php';
		</script>
		<?php
		$valid = 1;
	}
}

if ($_POST["email"] != "") {
	$result = $db->prepare("SELECT COUNT(email) FROM users WHERE email = :email");
	$result->execute(['email' => $_POST["email"]]);
	$number_of_rows = $result->fetchColumn(); 
	if ($number_of_rows > 0) {
		?>
		<script type="text/javascript">
			alert("User with this email already exists!");
			window.location.href = 'index.php';
		</script>
		<?php
		$valid = 1;
	}
}

$rest_pass = strstr($_POST["email"], '@');

if (strpos($_POST["email"], "@") == false || strpos($rest_pass, ".") == false || strstr($rest_pass, '.') == ".") {
	?>
	<script type="text/javascript">
		alert("Your email has a wrong format!");
		window.location.href = 'index.php';
	</script>
	<?php
	$valid = 1;
}

if (preg_match("/[1-9]/", $_POST["password"]) == 0 || preg_match("/[A-Z]/", $_POST["password"]) == 0 || strlen($_POST["password"]) < 6) {
	?>
	<script type="text/javascript">
		alert("Your password must have at least one digit, one uppercase letter, and be at least 6 characters long!");
		window.location.href = 'index.php';
	</script>
	<?php
	$valid = 1;
}

if ($_POST["submit"] == "OK") {
	$login = $_POST['login'];
	$email = $_POST['email'];
	$password = hash('whirlpool', $_POST['password']);
	$validate = hash("md5", $login.$email.date('mY'));

	if ($valid == 0) {
		$stmt = $db->prepare("INSERT INTO users(login, email, password, validation) VALUES (:login, :email, :password, :validation)");
		$stmt->execute(['login' => $login, 'email' => $email, 'password' => $password, 'validation' => $validate]);
		send_mail($login, $email, $validate);
	}
}
else
	echo "ERROR";


?>