<?php
session_start();
require_once('config/database.php');
$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pic_address = $_POST['photo_id'];
$proper_pic_add = substr($pic_address, strpos($pic_address, "u") + 2);

$pic_id = $db->prepare("SELECT id FROM pictures WHERE final_img = :final_img");
$pic_id->execute(['final_img' => $proper_pic_add]);
$picture_id = $pic_id->fetchColumn();

$u_id = $db->prepare("SELECT user_id FROM pictures WHERE id = :id");
$u_id->execute(['id' => $picture_id]);
$user_pic_id = $u_id->fetchColumn();

$user = $db->prepare("SELECT login FROM users WHERE id = :id");
$user->execute(['id' => $user_pic_id]);
$login = $user->fetchColumn();

echo "Picture by <strong>$login</strong>";
?>