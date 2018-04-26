<?php
	include_once ("functions/functions.php");
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles/styles.css">
	<?php if (isloggedin() == false) : ?>
		<a href="login_form.php">Log in</a>
		<a href="signup_form.php">Sign up</a>
		<a href="index.php">Home</a>
	<?php endif ?>
	<?php if (isloggedin() == true) : ?>
		<a href="index.php">Home</a>
		<a href="take_picture.php">Take picture</a>
		<a href="profile.php">My profile</a>
		<a href="logout.php">Log out</a>
	<?php endif ?>