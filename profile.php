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
		<!-- <h1 class="header">Your pics</h1> -->
		<!-- <div id="overlay" onclick="off()"></div>
    	<div style="padding:20px"> -->
		<?php

		$log_check = $db->prepare("SELECT id FROM users WHERE login = :login");
		$log_check->execute(['login' => $_SESSION['user']]);
		$id = $log_check->fetchColumn();

		$valid_email_check = $db->prepare("SELECT validation FROM users WHERE id = :id");
		$valid_email_check->execute(['id' => $id]);
		$valid_email = $valid_email_check->fetchColumn();

		if ($valid_email != 'OK') {
			?>
			<div>
				<marquee>Please, validate your email</marquee>
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
                   	<a href="index.php"><img class="logo" src="img/logo.png"></a>
               	<!-- </div> -->
                <div>
                    <a href="index.php">
                        <div class="button">
                            Home
                        </div>
                    </a>
                    <a href="take_picture.php">
                        <div class="button">
                            Take picture
                        </div>
                    </a>
                    <a href="profile.php">
                        <div class="button">
                            My profile
                        </div>
                    </a>
                    <a href="logout.php">
                        <div class="button">
                            Log out
                        </div>
                    </a>
                    <a href="edit_profile.php">
                        <div class="button">
                        	Edit data
                        </div>
                    </a>
                </div>
            </div>
            </div>
            <div class="gallery">
            	<div class="header" id="grid-header">Your pics</div>
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
	        		?><div><a href="<?php echo $picture; ?>"><img class="profile-img" src="<?php echo $picture; ?>"></a></div><?php
	    		}
                ?>
            </div>
        </div>
	</body>