<?php
session_start();
include ("config/database.php");
$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$log_check = $db->prepare("SELECT id FROM users WHERE login = :login");
$log_check->execute(['login' => $_SESSION['user']]);
$id = $log_check->fetchColumn();
$stmt = $db->prepare("UPDATE users SET login = :login WHERE id = :id");
$stmt->execute(['login' => htmlspecialchars($_POST["login"], ENT_QUOTES, 'UTF-8'), 'id' => $id]);
?>
<p>Your login was successfully changed. You can use your new login to log in.</p>
<?php session_destroy();?>
<script type="text/javascript">
	setTimeout("location.href = 'index.php';",2000);
</script>