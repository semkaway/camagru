<?php
	session_start();
	require_once('config/database.php');
	include ("functions/functions.php");
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$pic_address = $_POST['photo_id'];
	$proper_pic_add = strstr($pic_address, "img");

	$pic_id = $db->prepare("SELECT id FROM pictures WHERE final_img = :final_img");
	$pic_id->execute(['final_img' => $proper_pic_add]);
	$picture_id = $pic_id->fetchColumn();

	$log_check = $db->prepare("SELECT id FROM users WHERE login = :login");
	$log_check->execute(['login' => $_SESSION['user']]);
	$id = $log_check->fetchColumn();

	$u_id = $db->prepare("SELECT user_id FROM pictures WHERE final_img = :final_img");
	$u_id->execute(['final_img' => $proper_pic_add]);
	$user_id_photo = $u_id->fetchColumn();

	$status_check = $db->prepare("SELECT id FROM likes WHERE user_id_liked = :user_id_liked AND picture_id = :picture_id");
	$status_check->execute(['user_id_liked' => 	$id, 'picture_id' => $picture_id]);
	$status = $status_check->rowCount();

	$value_check = $db->prepare('SELECT notifications FROM users WHERE id = :id');
	$value_check->execute(['id' => $user_id_photo]);
	$value = $value_check->fetchColumn();

	if ($status == 0) {
		$stmt = $db->prepare("INSERT INTO likes(picture_id, user_id_liked, user_id_photo) VALUES (:picture_id, :user_id_liked, :user_id_photo)");
		$stmt->execute(['picture_id' => $picture_id, 'user_id_liked' => $id, 'user_id_photo' => $user_id_photo]);

		$status_check = $db->prepare("SELECT login FROM users WHERE id = :id");
		$status_check->execute(['id' => $user_id_photo]);
		$login_photo = $status_check->fetchColumn();

		$status_check = $db->prepare("SELECT email FROM users WHERE id = :id");
		$status_check->execute(['id' => 	$user_id_photo]);
		$email = $status_check->fetchColumn();
	    $mail_subject = "Someone liked your picture!";
	    $mail_message = "<strong>Hello, ".$login_photo."!</strong><br>".
	                        $_SESSION['user']." just liked one of your pictures!";


	    if ($value == "YES") {
	    	send_mail($email, $mail_subject, $mail_message);
	    }
	} else {
		$stmt = $db->prepare("DELETE FROM likes WHERE picture_id = :picture_id AND user_id_liked = :user_id_liked");
		$stmt->execute(['picture_id' => $picture_id, 'user_id_liked' => $id]);
	}

?>