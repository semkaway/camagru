<?php
session_start();
include ("config/database.php");

$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$email_check = $db->prepare("SELECT email FROM users WHERE login = :login");
$email_check->execute(['login' => $_SESSION['user']]);
$id = $email_check->fetchColumn();

$rest_pass = strstr(htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8'), '@');

if (strpos(htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8'), "@") == false || strpos($rest_pass, ".") == false || strstr($rest_pass, '.') == ".") {
	?>
	<script type="text/javascript">
		alert("Your email has a wrong format!");
		window.location.href = 'edit_profile.php';
	</script>
	<?php
}

$stmt = $db->prepare("UPDATE users SET email = :email WHERE login = :login");
$stmt->execute(['email' => htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8'), 'login' => $_SESSION['user']]);
?>
<p>Your email was successfully changed.</p>
<script type="text/javascript">
	setTimeout("location.href = 'profile.php';",2000);
</script>
