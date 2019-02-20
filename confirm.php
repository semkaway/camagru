<?php include ("includes/header.php")?>
    <title>Password recovery</title>
</head>
<body>
    <h1 class="header">reset password</h1>
    <form class="text-box" action="reset_pass.php" id="recover_form" method="post">
        Enter your login: <input type="text" name="login" placeholder="login" required><br>
        Be careful or you will have to start the procedure from the beginning!<br>
        Enter new password: <input type="password" name="password" placeholder="password" minlength="6" maxlength="9" required><br>
        <input class="button" type="submit" name="submit" value="OK">
    </form>
</body>
</html>