<?php
session_start();
require_once('config/database.php');
$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$limit_end = $_POST['newnumber'];

$allPics = $db->prepare("SELECT final_img FROM pictures LIMIT 3 OFFSET :limit_end");
$allPics->bindParam(':limit_end', $limit_end, PDO::PARAM_INT);
$allPics->execute();
$id = $allPics->fetchAll(PDO::FETCH_COLUMN, 0);

foreach ($id as $picture) { ?><img src="<?php echo $picture; ?>"><?php }            
?>