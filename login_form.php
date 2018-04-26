<?php include ("includes/header.php")?>

    <title>Log in</title>
</head>
<body>
<h1 class="header">Log in</h1>
    <form action="login.php" id="login_form" method="post">
        <input type="text" name="login" placeholder="login">
        <input type="password" name="password" placeholder="password">
        <input type="submit" class="button" name="submit" value="OK">
    </form>
    <a href="forgot.php">Forgot password</a>
</body>
</html>