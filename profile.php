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

		$allPics = $db->prepare("SELECT final_img FROM pictures WHERE user_id = :user_id LIMIT 6");
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
	                <form class="hidden" method="post" accept-charset="utf-8" name="delete-form">
		            	<input name="pic-to-delete" id='pic-to-delete' type="hidden"/>
		        	</form>
                    <div class="comments">
                        <div>
                            <form class="hidden" method="post" accept-charset="utf-8" name="form1">
                                <input name="photo_id" id='photo_id' type="hidden"/>
                            </form>
                            <div id="like">
	                            <div id="amount_of_likes">
	                                <?php

	                                $log_check = $db->prepare("SELECT id FROM users WHERE login = :login");
	                                $log_check->execute(['login' => $_SESSION['user']]);
	                                $user_id = $log_check->fetchColumn();

	                                $pic_id = $db->prepare("SELECT id FROM pictures WHERE final_img = :final_img");
	                                $pic_id->execute(['final_img' => $pic[0]]);
	                                $picture_id = $pic_id->fetchColumn();

	                                $status_check = $db->prepare("SELECT id FROM likes WHERE user_id_liked = :user_id_liked AND picture_id = :picture_id");
	                                $status_check->execute(['user_id_liked' => $user_id, 'picture_id' => $picture_id]);
	                                $status = $status_check->rowCount();
	                                if ($status == 0) {
	                                    ?><div><img src="img/grey-heart.png"></div><?php
	                                }
	                                else {
	                                    ?><div><img src="img/red-heart.png"></div><?php
	                                }
	                                ?>
	                                <div>
	                                    <?php
	                                    $value_like = $db->prepare("SELECT picture_id FROM likes WHERE picture_id = :picture_id");
	                                    $value_like->execute(['picture_id' => $picture_id]);
	                                    $num_likes = $value_like->rowCount();
										echo $num_likes;?>
	                                </div>
	                            </div>
	                        </div>
                        </div>
                            <form class="new_comment" name="comments_form">
	                            <input name="pic_id" id='pic_id' type="hidden"/>
	                        </form>
	                        <div id="picture-by">Picture by <?php echo "<strong>".$_SESSION['user']."</strong>"?></div>
                            <div id="comments_texts">
                            <?php
                            
                            $allComments = $db->prepare("SELECT comment FROM comments WHERE picture_id = :picture_id");
                            $allComments->execute(['picture_id' => $picture_id]);
                            $comments = $allComments->fetchAll(PDO::FETCH_COLUMN, 0);

                            foreach ($comments as $comment) {
                                ?><div><?php 
                                $user = $db->prepare("SELECT user_id_comment FROM comments WHERE comment= :comment");
                                $user->execute(['comment' => $comment]);
                                $id_user = $user->fetchColumn();

                                $user = $db->prepare("SELECT login FROM users WHERE id = :id");
                                $user->execute(['id' => $id_user]);
                                $login = $user->fetchColumn();

                                echo "<strong>".$login."</strong>"." ".$comment; ?></div><?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div id="images">
                    <?php
                    foreach ($pic as $picture) {
                        ?><img src="<?php echo $picture; ?>"><?php
                    }
                    ?>
                </div>
                <div class="button" id="load">Load more</div>
                <form class="hidden" method="post" accept-charset="utf-8" name="load-form">
                    <input name="newnumber" id='newnumber' type="hidden" value="6"/>
                </form>
        	</div>
        </div>
        <script type="text/javascript">
	        const likeButton = document.querySelector('#like');
	        const loadButton = document.querySelector('#load');
	        const deleteButton = document.querySelector('#delete');

	        likeButton.addEventListener('click', () => {
	            document.getElementById('photo_id').value = current.src;
	            var fd = new FormData(document.forms["form1"]);

	            var xhr = new XMLHttpRequest();
	            xhr.open('POST', 'likes.php', true);
	            xhr.send(fd);
	        });

	    	loadButton.addEventListener('click', () => {
			    var fd = new FormData(document.forms['load-form']);
			    if (window.XMLHttpRequest)
			            httpRequest = new XMLHttpRequest();
			    if (!httpRequest) {
			            alert('Giving up :( Cannot create an XMLHTTP instance');
			            return false;
			        }
			        httpRequest.onreadystatechange = function() { 
			            alertContent(httpRequest, 'images');
			        };
			        httpRequest.open('POST', 'load.php', true);
			        httpRequest.send(fd);
			       	setTimeout( function() { reset(); }, 70); 
			});

			function alertContent(httpRequest, divID) {
				    if (httpRequest.readyState == 4) {
				        if (httpRequest.status == 200) {
				            document.getElementById(divID).innerHTML += httpRequest.responseText;
				        } else {
				            alert('There was a problem with the request. '+ httpRequest.status);
				        }
				    }
				}

			function reset () {
				const images = document.querySelectorAll('#images img');
				setTimeout( function() { images.forEach(func); }, 70);
				document.getElementById('newnumber').value = parseInt(document.getElementById('newnumber').value) + 3;
			}

        	deleteButton.addEventListener('click', () => {

		    var answer = confirm("Are you sure you want to delete this picture?");
		    if (answer == true) {
		        document.getElementById('pic-to-delete').value = document.querySelector('#current').src;                
		        var fd = new FormData(document.forms["delete-form"]);

		        var xhr = new XMLHttpRequest();
		        xhr.open('POST', 'delete_pic.php', true);
		        xhr.send(fd);
		        setTimeout("location.href = 'profile.php';", 0);
		    }
		});
        </script>
	    <script type="text/javascript" src="functions/js_functions.js"></script>
	</body>