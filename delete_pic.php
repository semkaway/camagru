<?php
	session_start();
	require_once('config/database.php');
	include('functions/functions.php');
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$pic_address = $_POST['pic-to-delete'];
	$proper_pic_add = strstr($pic_address, "img");
	
	$pic_id = $db->prepare("SELECT id FROM pictures WHERE final_img = :final_img");
	$pic_id->execute(['final_img' => $proper_pic_add]);
	$id = $pic_id->fetchColumn();

	$pic_id = $db->prepare("DELETE FROM pictures WHERE id = :id");
	$pic_id->execute(['id' => $id]);

	$delete_from_likes = $db->prepare("DELETE FROM likes WHERE picture_id = :id");
	$delete_from_likes->execute(['id' => $id]);

	$delete_from_comments = $db->prepare("DELETE FROM comments WHERE picture_id = :id");
	$delete_from_comments->execute(['id' => $id]);
	unlink($proper_pic_add);
?>