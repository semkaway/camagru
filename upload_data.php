<?php
	session_start();
	require_once('config/database.php');
	include('functions/functions.php');
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (!file_exists("img/upload")) {
    	mkdir("img/upload");
	}

	$upload_dir = "img/upload/";
	$rawData = $_POST['hidden_data'];
	$elem = $_POST['selected_elem'];
	$img = explode(',', $rawData);
	$unencoded = base64_decode($img[1]);
	$file = $upload_dir . mktime() . ".png";
	file_put_contents($file, $unencoded);

	$log_check = $db->prepare("SELECT id FROM users WHERE login = :login");
	$log_check->execute(['login' => $_SESSION['user']]);
	$id = $log_check->fetchColumn();

	$stmt = $db->prepare("INSERT INTO pictures(user_id, photo, element) VALUES (:user_id, :photo, :element)");
	$stmt->execute(['user_id' => $id, 'photo' => $file, 'element' => $elem]);
	combine_imgs($file, $elem);
?>