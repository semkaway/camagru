<?php
	require_once('config/database.php');
	include ("functions/functions.php");
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$valid = 0;

if ($_POST["login"] != "") {
	$result = $db->prepare("SELECT COUNT(login) FROM users WHERE login = :login");
	$result->execute(['login' => htmlspecialchars($_POST["login"], ENT_QUOTES, 'UTF-8')]);
	$number_of_rows = $result->fetchColumn(); 
	if ($number_of_rows > 0) {
		?>
		<script type="text/javascript">
			alert("User with this login already exists!");
			window.location.href = 'signup_form.php';
		</script>
		<?php
		$valid = 1;
	}
}

if ($_POST["email"] != "") {
	$result = $db->prepare("SELECT COUNT(email) FROM users WHERE email = :email");
	$result->execute(['email' => htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8')]);
	$number_of_rows = $result->fetchColumn(); 
	if ($number_of_rows > 0) {
		?>
		<script type="text/javascript">
			alert("User with this email already exists!");
			window.location.href = 'signup_form.php';
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
		window.location.href = 'signup_form.php';
	</script>
	<?php
	$valid = 1;
}

if ($_POST["submit"] == "OK") {
	$dir = basename(__DIR__);
	$login = htmlspecialchars($_POST["login"], ENT_QUOTES, 'UTF-8');
	$email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
	$password = hash('whirlpool', $_POST['password']);
	$validate = hash("md5", $login.$email.date('mY'));
	$mail_subject = "Complete your registration to Camagru";
	$message = "<strong>Hello, ".$login."!</strong><br>
                        Thank you for registration in our application. There is just one more step left for you to fully experience the app.<br>
                        Please, click on the link below:<br>
                        <a href='https://kvilnacamagru.000webhostapp.com/".$dir."/validate.php?login=".$login."&key=".$validate."'>Verify my email</a><br>
                        If you got this letter by mistake, please, ignore it.<br>
                        Have a good day!";

	if ($valid == 0) {
		$stmt = $db->prepare("INSERT INTO users(login, email, password, validation) VALUES (:login, :email, :password, :validation)");
		$stmt->execute(['login' => $login, 'email' => $email, 'password' => $password, 'validation' => $validate]);
		send_mail($email, $mail_subject, $message);
	}
}
else
	echo "ERROR";

?>
<p class="text-box">Check your email to complete registration.</p>
<script type="text/javascript">
	setTimeout("location.href = 'index.php';",2000);
</script>