<?php include ("includes/header.php")?>
    <title>Sign up</title>
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
			<h1 class="header">Sign up</h1>
		    <form class="text-box" action="create.php" id="create_form" method="post">
		        Your login: <input type="text" name="login" placeholder="login" required><br>
		        Your email: <input type="text" name="email" placeholder="email" required><br>
		        Your password: <input type="password" name="password" placeholder="password" minlength="6" maxlength="9" required><br>
		        <input class="button" type="submit" name="submit" value="OK">
		    </form>
		</div>
	</div>
	<?php include("includes/footer.php"); ?>
</body>
</html>