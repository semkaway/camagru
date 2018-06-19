<?php include ("includes/header.php");?>
	<title>Edit profile</title>
</head>
<body>
	<p class="title">Change password</p>
	<form class="text-box" action="edit_pass.php" name="edit" method="post">
		Old password: <input type="password" name="old" value="">
		<br />
		New password: <input type="password" name="password" value="">
		<br />
		<input id="button" type="submit" name="submit" value="OK">
	</form>
	<p class="title">Change login</p>
	<form class="text-box" action="edit_login.php" name="edit" method="post">
		New login: <input type="text" name="login" value="">
		<br />
		<input id="button" type="submit" name="submit" value="OK">
	</form>
	<p class="title">Change email</p>
	<form class="text-box" action="edit_email.php" name="edit" method="post">
		New email: <input type="text" name="email" value="">
		<br />
		<input class="button" type="submit" name="submit" value="OK">
	</form>
</body>
</html>