<!DOCTYPE html>
<html>
<head>
	<title>Edit profile</title>
</head>
<body>
	<a href="logout.php">Log out</a>
	<p>Change password</p>
	<form action="edit_pass.php" name="edit" method="post">
		Old password: <input type="password" name="old" value="">
		<br />
		New password: <input type="password" name="password" value="">
		<br />
		<input id="button" type="submit" name="submit" value="OK">
	</form>
	<p>Change login</p>
	<form action="edit_login.php" name="edit" method="post">
		New login: <input type="text" name="login" value="">
		<br />
		<input id="button" type="submit" name="submit" value="OK">
	</form>
	<p>Change email</p>
	<form action="edit_email.php" name="edit" method="post">
		New email: <input type="text" name="email" value="">
		<br />
		<input id="button" type="submit" name="submit" value="OK">
	</form>
</body>
</html>