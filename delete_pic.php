<?php
	session_start();
	require_once('config/database.php');
	include('functions/functions.php');
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$pic_address = $_POST['pic-to-delete'];
	$proper_pic_add = substr($pic_address, strpos($pic_address, "u") + 2);
	
	$pic_id = $db->prepare("SELECT id FROM pictures WHERE final_img = :final_img");
	$pic_id->execute(['final_img' => $proper_pic_add]);
	$id = $pic_id->fetchColumn();

	$pic_id = $db->prepare("DELETE FROM pictures WHERE id = :id");
	$pic_id->execute(['id' => $id]);
	unlink($proper_pic_add);
?>