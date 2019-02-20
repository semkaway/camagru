<?php include ("includes/header.php")?>

    <title>Log in</title>
</head>
<body>
	<div class="header-page"></div>
	<div class="wrapper">
		<div class="sidebar">
			<div>
				<a href="index.php"><img class="logo" src="img/logo.png"></a>
				<div>
					<a href="index.php">
						<div class="button">
							Home
						</div>
					</a>
					<a href="login_form.php">
						<div class="button">
							Log in
						</div>
					</a>
					<a href="signup_form.php">
						<div class="button">
							Sign up
						</div>
					</a>
				</div>
			</div>
		</div>
		<div>
			<h1 class="header">Log in</h1>
		    <form class="text-box" action="login.php" id="login_form" method="post">
		        <input type="text" name="login" placeholder="login" required>
		        <input type="password" name="password" placeholder="password" minlength="6" maxlength="9" required>
		        <input type="submit" class="button" name="submit" value="OK">
		        <a href="forgot.php">Forgot password</a>
		    </form>
		</div>
	</div>
	<?php include("includes/footer.php"); ?>
</body>
</html>