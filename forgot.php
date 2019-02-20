<?php include ("includes/header.php")?>
	<title>Password recovery</title>
</head>
<body>
	<h1 class="header">Password recovery</h1>
	<form class="text-box" action="send_password.php" id="recovery_form" method="post">
		Enter your email: <input type="text" name="email" placeholder="email" required>
	    <input class="button" type="submit" name="submit" value="OK">
	</form>
</body>
</html>