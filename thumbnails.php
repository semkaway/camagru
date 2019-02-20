<?php
require_once('config/database.php');
$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$log_check = $db->prepare("SELECT final_img FROM pictures ORDER BY id DESC LIMIT 1");
$log_check->execute();
$src = $log_check->fetchColumn();

echo "<div><img class='thumbnail-pics' src='$src'></div>";
?>