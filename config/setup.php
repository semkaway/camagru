<?php
include('database.php');

try {
	$db = new PDO($DB_DSN_SHORT, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS`".$DB_NAME."`";
    $db->exec($sql);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$table = 'users';

	$sql ="CREATE TABLE IF NOT EXISTS $table(
	ID INT(11) AUTO_INCREMENT PRIMARY KEY,
	login VARCHAR(255) NOT NULL, 
	email VARCHAR(255) NOT NULL,
	password VARCHAR(150) NOT NULL,
	validation VARCHAR(255) NOT NULL,
	recovery VARCHAR(255) DEFAULT 'ALL OK' NOT NULL,
	notifications VARCHAR(255) DEFAULT 'YES' NOT NULL)";
	$db->exec($sql);
	} catch (PDOException $e) {
    	echo 'Connection failed: ' . $e->getMessage();
	}

try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$table = 'pictures';

	$sql ="CREATE TABLE IF NOT EXISTS $table(
	ID INT(11) AUTO_INCREMENT PRIMARY KEY,
	user_id INT(11),
	photo VARCHAR(255) NOT NULL, 
	element VARCHAR(255) NOT NULL,
	final_img VARCHAR(255))";
	$db->exec($sql);
	} catch (PDOException $e) {
    	echo 'Connection failed: ' . $e->getMessage();
	}

try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$table = 'comments';

	$sql ="CREATE TABLE IF NOT EXISTS $table(
	ID INT(11) AUTO_INCREMENT PRIMARY KEY,
	picture_id INT(11),
	user_id_comment INT(11) DEFAULT 0, 
	user_id_photo INT(11) DEFAULT 0, 
	comment text NOT NULL)";
	$db->exec($sql);
	} catch (PDOException $e) {
    	echo 'Connection failed: ' . $e->getMessage();
	}

try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$table = 'likes';

	$sql ="CREATE TABLE IF NOT EXISTS $table(
	ID INT(11) AUTO_INCREMENT PRIMARY KEY,
	picture_id INT(11),
	user_id_liked INT(11) DEFAULT 0, 
	user_id_photo INT(11) DEFAULT 0)";
	$db->exec($sql);
	} catch (PDOException $e) {
    	echo 'Connection failed: ' . $e->getMessage();
	}
?>