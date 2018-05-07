<?php
	session_start();
	include_once('config/setup.php');
	include ("includes/header.php");
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	?>
		<title>Profile</title>
	</head>
	<a href="edit_profile.php">Edit data</a>
	<h1 class="header">Your pics</h1>
	<?php

	$log_check = $db->prepare("SELECT id FROM users WHERE login = :login");
	$log_check->execute(['login' => $_SESSION['user']]);
	$id = $log_check->fetchColumn();

	$allPics = $db->prepare("SELECT final_img FROM pictures WHERE user_id = :user_id");
	$allPics->execute(['user_id' => $id]);
    $pic = $allPics->fetchAll(PDO::FETCH_COLUMN, 0);
    foreach ($pic as $picture) {
        ?><img class="gallery_img" src="<?php echo $picture; ?>"><br><?php
    }
?>