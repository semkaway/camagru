<?php
session_start();
include ("config/database.php");

if ($_POST["email"] == "" || $_POST["submit"] != "OK") {
	?>
	<script type="text/javascript">
		alert("All fields must be filled!");
		window.location.href = 'edit_profile.php';
	</script>
	<?php
}
else
{
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $email_check = $db->prepare("SELECT email FROM users WHERE login = :login");
	$email_check->execute(['login' => $_SESSION['user']]);
	$id = $email_check->fetchColumn();
	$stmt = $db->prepare("UPDATE users SET email = :email WHERE login = :login");
    $stmt->execute(['email' => $_POST['email'], 'login' => $_SESSION['user']]);
    ?>
    <p>Your email was successfully changed.</p>
    <script type="text/javascript">
		setTimeout("location.href = 'profile.php';",2000);
	</script>
	<?php
}
?>