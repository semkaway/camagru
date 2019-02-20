<?php
session_start();
include_once('config/setup.php');
include ("includes/header.php");

$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$current = $_POST['hidden_data'];

$status = $db->prepare('SELECT notifications FROM users WHERE login = :login');
$status->execute(['login' => $_SESSION['user']]);
$value = $status->fetchColumn();

if ($value != $current)
{
	$status = $db->prepare('UPDATE users SET notifications = :notifications WHERE login = :login');
	$status->execute(['notifications' => $current, 'login' => $_SESSION['user']]);
}
?>
