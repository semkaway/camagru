<?php include ("includes/header.php")?>
    <title>Sign up</title>
</head>
<body>
	<h1 class="header">Sign up</h1>
    <form action="create.php" id="create_form" method="post">
        <input type="text" name="login" placeholder="login">
        <input type="text" name="email" placeholder="email">
        <input type="password" name="password" placeholder="password">
        <input class="button" type="submit" name="submit" value="OK">
    </form>
</body>
</html>