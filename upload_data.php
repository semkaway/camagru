<?php
	session_start();
	require_once('config/database.php');
	include('functions/functions.php');
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if ($_POST['hidden_data'] && $_POST['selected_elem']) {
			if (!file_exists("img/upload")) {
	    	mkdir("img/upload");
		}

		$upload_dir = "img/upload/";
		$rawData = $_POST['hidden_data'];
		$elem = $_POST['selected_elem'];

		$extension = substr(strtok(strchr($rawData, '/'), ';'), 1);

		$img = explode(',', $rawData);
		$unencoded = base64_decode($img[1]);
		$file = $upload_dir . mktime() . "." . $extension;
		file_put_contents($file, $unencoded);

		$log_check = $db->prepare("SELECT id FROM users WHERE login = :login");
		$log_check->execute(['login' => $_SESSION['user']]);
		$id = $log_check->fetchColumn();
		$final_img = combine_imgs($file, $elem);
		$stmt = $db->prepare("INSERT INTO pictures(user_id, photo, element, final_img) VALUES (:user_id, :photo, :element, :final_img)");
		$stmt->execute(['user_id' => $id, 'photo' => $file, 'element' => $elem, 'final_img' => $final_img]);
	}
	if ($_POST['pic-to-delete']) {
		var_dump($pic_address);
		// echo " lolkik";
		// $proper_pic_add = substr($pic_address, "camagru/");
		
		// echo $proper_pic_add;
		// var_dump($proper_pic_add);
		$pic_id = $db->prepare("DELETE FROM pictures WHERE final_img = :final_img");
		$pic_id->execute(['final_img' => $pic_address]);
		$id = $pic_id->fetchColumn();
	}
?>