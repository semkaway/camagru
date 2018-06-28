<?php
session_start();
require_once('config/database.php');
$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pic_address = $_POST['photo_id'];
$proper_pic_add = substr($pic_address, strpos($pic_address, "u") + 2);

$log_check = $db->prepare("SELECT id FROM users WHERE login = :login");
$log_check->execute(['login' => $_SESSION['user']]);
$user_id = $log_check->fetchColumn();

$pic_id = $db->prepare("SELECT id FROM pictures WHERE final_img = :final_img");
$pic_id->execute(['final_img' => $proper_pic_add]);
$picture_id = $pic_id->fetchColumn();

$value_like = $db->prepare("SELECT picture_id FROM likes WHERE picture_id = :picture_id");
$value_like->execute(['picture_id' => $picture_id]);
$num_likes = $value_like->rowCount();

$status_check = $db->prepare("SELECT id FROM likes WHERE user_id_liked = :user_id_liked AND picture_id = :picture_id");
$status_check->execute(['user_id_liked' => $user_id, 'picture_id' => $picture_id]);
$status = $status_check->rowCount();

if ($status == 0) {
	$img = "img/grey-heart.png";
}
else {
	$img = "img/red-heart.png";
}

echo "<div><img src='$img'></div><div>$num_likes</div>";
?>