<?php
session_start();
require_once('config/database.php');
$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// $comment = $_POST['comment_text'];

$pic_address = $_POST['pic_id'];
$proper_pic_add = substr($pic_address, strpos($pic_address, "u") + 2);

$pic_id = $db->prepare("SELECT id FROM pictures WHERE final_img = :final_img");
$pic_id->execute(['final_img' => $proper_pic_add]);
$picture_id = $pic_id->fetchColumn();

$allComments = $db->prepare("SELECT comment FROM comments WHERE picture_id = :picture_id");
$allComments->execute(['picture_id' => $picture_id]);
$comments = $allComments->fetchAll(PDO::FETCH_COLUMN, 0);

foreach ($comments as $comment) {
	?>
	<div><?php echo $comment; ?>
		
	</div><?php
} ?>";
?>