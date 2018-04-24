<?php
include('database.php');

try {
	$db = new PDO($DB_DSN_SHORT, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $sql = "CREATE DATABASE IF NOT EXISTS`".$DB_NAME."`";
    $db->exec($sql);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$table = 'users';

	$sql ="CREATE TABLE IF NOT EXISTS $table(
	ID INT(11) AUTO_INCREMENT PRIMARY KEY,
	login VARCHAR(255) NOT NULL, 
	email VARCHAR(255) NOT NULL,
	password VARCHAR(150) NOT NULL);";
	$db->exec($sql);

	} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>