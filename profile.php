<?php
	session_start();
	include_once('config/setup.php');
	include ("includes/header.php");
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	?>
		<title>Profile</title>
	</head>
	<body>
		<h1 class="header">Your pics</h1>
		<div id="overlay" onclick="off()"></div>
    	<div style="padding:20px">
		<?php

		$log_check = $db->prepare("SELECT id FROM users WHERE login = :login");
		$log_check->execute(['login' => $_SESSION['user']]);
		$id = $log_check->fetchColumn();

		$valid_email_check = $db->prepare("SELECT validation FROM users WHERE id = :id");
		$valid_email_check->execute(['id' => $id]);
		$valid_email = $valid_email_check->fetchColumn();

		if ($valid_email != 'OK') {
			?>
			<div class="text-box">
				<p>Please, validate your email</p>
			</div>
			<?php
		}

		$allPics = $db->prepare("SELECT final_img FROM pictures WHERE user_id = :user_id");
		$allPics->execute(['user_id' => $id]);
	    $pic = $allPics->fetchAll(PDO::FETCH_COLUMN, 0);
	    ?>
	    <div class="wrapper">
            <div class="sidebar">
                <div>
                    <?php if (isloggedin() == false) : ?>
                        <div class="button">
                            <a href="login_form.php">Log in</a>
                        </div>
                        <div class="button">
                            <a href="signup_form.php">Sign up</a>
                        </div>
                        <div class="button">
                            <a href="index.php">Home</a>
                        </div>
                    <?php endif ?>
                    <?php if (isloggedin() == true) : ?>
                        <div class="button">
                            <a href="index.php">Home</a>
                        </div>
                        <div class="button">
                            <a href="take_picture.php">Take picture</a>
                        </div>
                        <div class="button">
                            <a href="profile.php">My profile</a>
                        </div>
                        <div class="button">
                            <a href="logout.php">Log out</a>
                        </div>
                        <div class="button">
                        	<a href="edit_profile.php">Edit data</a>
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="gallery">
                <?php
                if (count($pic) == 0) {
                	?>
                	<div class="text-box">
						<p>It seems like you don't have any pictures yet :( <br> Go on and take some!</p><br>
						<div class="button">
                            <a href="take_picture.php">Take picture</a>
                        </div>
					</div>
                	<?php
                }
                foreach ($pic as $picture) {
	        		?><img class="profile_gallery_img" src="<?php echo $picture; ?>"><?php
	    		}
                ?>
            </div>
        </div>
	</body>