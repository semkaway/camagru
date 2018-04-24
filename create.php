<?php
	require_once('config/database.php');
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

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

if (preg_match("/[1-9]/", $_POST["password"]) == 0 || preg_match("/[A-Z]/", $_POST["password"]) == 0 || strlen($_POST["password"]) < 5) {
	?>
	<script type="text/javascript">
		alert("Your email must have at least one digit, one uppercase letter, and be at least 6 characters long!");
		window.location.href = 'index.php';
	</script>
	<?php
	$valid = 1;
}

if ($_POST["submit"] == "OK") {
	$login = $_POST['login'];
	$email = $_POST['email'];
	$password = hash('whirlpool', $_POST['password']);

	if ($valid == 0) {
		$stmt = $db->prepare("INSERT INTO users(login, email, password) VALUES (:login, :email, :password)");
		$stmt->execute(['login' => $login, 'email' => $email, 'password' => $password]);
		?>
		<p>Thank you for registration! Check your email to confirm registration.</p>
		<?php
	}
}
else
	echo "ERROR";


?>