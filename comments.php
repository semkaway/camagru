<?php
	session_start();
	require_once('config/database.php');
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$comment = $_POST['comment_text'];

	$pic_address = $_POST['pic_id'];
	$proper_pic_add = substr($pic_address, strpos($pic_address, "u") + 2);

	$pic_id = $db->prepare("SELECT id FROM pictures WHERE final_img = :final_img");
	$pic_id->execute(['final_img' => $proper_pic_add]);
	$picture_id = $pic_id->fetchColumn();

	$log_check = $db->prepare("SELECT id FROM users WHERE login = :login");
	$log_check->execute(['login' => $_SESSION['user']]);
	$id = $log_check->fetchColumn();

	$u_id = $db->prepare("SELECT user_id FROM pictures WHERE final_img = :final_img");
	$u_id->execute(['final_img' => $proper_pic_add]);
	$user_id_photo = $u_id->fetchColumn();

	$stmt = $db->prepare("INSERT INTO comments(picture_id, user_id_comment, user_id_photo, comment) VALUES (:picture_id, :user_id_comment, :user_id_photo, :comment)");
	$stmt->execute(['picture_id' => $picture_id, 'user_id_comment' => $id, 'user_id_photo' => $user_id_photo, 'comment' => $comment]);

?>