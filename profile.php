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
            <div class="container">
            	<div class="header" id="grid-header">Your pics</div>
                <div class="main-img">
                	<div class="picture-delete">
	                    <img id="current" src="<?php echo $pic[0]; ?>">
                        <div class="button" id="delete">
                        	delete photo
                        </div>
	                </div>
	                <form method="post" accept-charset="utf-8" name="form1">
		            	<input name="pic-to-delete" id='pic-to-delete' type="hidden"/>
		        	</form>
                    <div class="comments">
                        Box for comments
                    </div>
                </div>
                <div class="images">
                    <?php
                    foreach ($pic as $picture) {
                        ?><img src="<?php echo $picture; ?>"><?php
                    }
                    ?>
                </div>
        	</div>
        </div>
        <script type="text/javascript">
	        const current = document.querySelector('#current');
	        const images = document.querySelectorAll('.images img');
	        const opacity = 0.4;
	        const deleteButton = document.getElementById('delete');

	        images.forEach(func);

	        function func (image) {
	            image.addEventListener('click', imageClick)
	        }

	        function imageClick(next) {
	            images.forEach(img => img.style.opacity = 1);
	            current.src = next.target.src;
	            next.target.style.opacity = opacity;
	        }

	        deleteButton.addEventListener('click', () => {

	        	var answer = confirm("Are you sure you want to delete this picture?");
				if (answer == true) {
		        	document.getElementById('pic-to-delete').value = document.querySelector('#current').src;                
		        	var form = document.querySelector('form');
	                var fd = new FormData(form);

	                var xhr = new XMLHttpRequest();
	                xhr.open('POST', 'delete_pic.php', true);
	                xhr.send(fd);
	                setTimeout("location.href = 'profile.php';", 0);
            	}
			});
	    </script>
	</body>