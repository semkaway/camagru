<?php
session_start();
include_once('config/setup.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Camagru</title>
</head>
<body>
	<h1 class="header">Sign up</h1>
    <form action="create.php" id="create_form" method="post">
        <input type="text" name="login" placeholder="login">
        <input type="text" name="email" placeholder="email">
        <input type="password" name="password" placeholder="password">
        <input type="submit" name="submit" value="OK">
    </form><h1 class="header">Log in</h1>
    <form action="login.php" id="create_form" method="post">
        <input type="text" name="login" placeholder="login">
        <input type="password" name="password" placeholder="password">
        <input type="submit" name="submit" value="OK">
    </form>
    <a href="forgot.php">Forgot password</a>
</body>
</html>
<?php
    var_dump($_SESSION);
?>