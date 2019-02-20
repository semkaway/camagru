<?php
include_once('config/setup.php');
include("includes/header.php");
$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$allPics = $db->prepare("SELECT final_img FROM pictures LIMIT 6");
$allPics->execute();
$id = $allPics->fetchAll(PDO::FETCH_COLUMN, 0);

$allPics = $db->prepare("SELECT final_img FROM pictures LIMIT 6");
$allPics->execute();
$num_pics = $allPics->rowCount();

if ($num_pics != 0) {
	$pic_id = $db->prepare("SELECT id FROM pictures WHERE final_img = :final_img");
	$pic_id->execute(['final_img' => $id[0]]);
	$picture_id = $pic_id->fetchColumn();

	$u_id = $db->prepare("SELECT user_id FROM pictures WHERE final_img = :final_img");
	$u_id->execute(['final_img' => $id[0]]);
	$user_pic_id = $u_id->fetchColumn();

	$user = $db->prepare("SELECT login FROM users WHERE id = :id");
	$user->execute(['id' => $user_pic_id]);
	$login = $user->fetchColumn();

	$value_like = $db->prepare("SELECT picture_id FROM likes WHERE picture_id = :picture_id");
	$value_like->execute(['picture_id' => $picture_id]);
	$num_likes = $value_like->rowCount();

	$allComments = $db->prepare("SELECT comment FROM comments WHERE picture_id = :picture_id");
	$allComments->execute(['picture_id' => $picture_id]);
	$comments = $allComments->fetchAll(PDO::FETCH_COLUMN, 0);
}

if (isloggedin() == true) {
	$log_check = $db->prepare("SELECT id FROM users WHERE login = :login");
	$log_check->execute(['login' => $_SESSION['user']]);
	$user_id = $log_check->fetchColumn();

	$status_check = $db->prepare("SELECT id FROM likes WHERE user_id_liked = :user_id_liked AND picture_id = :picture_id");
	$status_check->execute(['user_id_liked' => $user_id, 'picture_id' => $picture_id]);
	$status = $status_check->rowCount();
}
?>
	<title>Camagru</title>
</head>
<body>
	<div class="header-page"></div>
	<div class="wrapper">
		<div class="sidebar">
			<div>
				<a href="index.php"><img class="logo" src="img/logo.png"></a>
				<div>
					<?php if (isloggedin() == false) : ?>
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
					<?php endif ?>
					<?php if (isloggedin() == true) : ?>
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
					<?php endif ?>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="main-img">
				<div class="picture-like">
					<?php if ($num_pics != 0) : ?>
						<img id="current" src="<?php echo $id[0]; ?>">
					<?php endif ?>
					<?php if ($num_pics == 0) : ?>
						<img id="current" src="https://images.pexels.com/photos/205321/pexels-photo-205321.png?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260>">
					<?php endif ?>
					<?php if (isloggedin() == true && $num_pics != 0) : ?>
						<div class="button" id="like" onclick="setTimeout(function() { makeRequest('amount_of_likes', 'update_likes.php', 'form1'); }, 300);">
							<form class="hidden" method="post" accept-charset="utf-8" name="form1">
								<input name="photo_id" id='photo_id' type="hidden"/>
							</form>
							<div id="like">
								<div id="amount_of_likes">
									<?php
									if ($status == 0) {
										?><div><img src="img/grey-heart.png"></div><?php
									}
									else {
										?><div><img src="img/red-heart.png"></div><?php
									}
									?>
									<div>
										<?php echo $num_likes;?>
									</div>
								</div>
							</div>
						</div>
					<?php endif ?>
				</div>
				<div class="comments">
					<?php if (isloggedin() == true && $num_pics != 0) : ?>
					<div id="picture-by">Picture by <?php echo "<strong>".$login."</strong>"?></div>
					<form class="new_comment" name="comments_form">
						<textarea name="comment_text" id="comment_text" placeholder="Your comment..."></textarea>
						<input name="pic_id" id='pic_id' type="hidden"/>
						<div class="button" value="Comment" id="comment" onclick="setTimeout(function() { makeRequest('comments_texts', 'update_comments.php', 'comments_form'); }, 100);">Comment</div>
					</form>
					<div id="comments_texts">
					<?php
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
					<?php endif ?>
					<?php if (isloggedin() == false) : ?>
					<div class="message-logged-out">
						welcome!
						<a href="login_form.php">
							<div class="button">
								Log in
							</div>
						</a>OR
						<a href="signup_form.php">
							<div class="button">
								Sign up
							</div>
						</a>
						to like and comment
					</div>
					<?php endif ?>
				</div>
			</div>
			<div id="images">
				<?php
				foreach ($id as $picture) {
					?><img src="<?php echo $picture; ?>"><?php
				}
				?>
			</div>
			<form class="hidden" method="post" accept-charset="utf-8" name="load-form">
				<input name="newnumber" id='newnumber' type="hidden" value="6"/>
			</form>
			<?php if ($num_pics >= 6) : ?>
				<div class="button" id="load">Load more</div>
			<?php endif?>
		</div>
	</div>
	<?php include("includes/footer.php"); ?>
	<script type="text/javascript">
		const loadButton = document.querySelector('#load');

		if (loadButton != null) {
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
		}

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
    </script>
    <?php if (isloggedin() == true) : ?>
    <script type="text/javascript">
        const likeButton = document.querySelector('#like');
        const commentButton = document.querySelector('#comment');

        if (likeButton != null) {
	        likeButton.addEventListener('click', () => {
	            document.getElementById('photo_id').value = current.src;
	            var fd = new FormData(document.forms["form1"]);

	            var xhr = new XMLHttpRequest();
	            xhr.open('POST', 'likes.php', true);
	            xhr.send(fd);
	        });
	    }

        if (commentButton != null) {
	        commentButton.addEventListener('click', () => {
	            document.getElementById('pic_id').value = current.src;

	            var fd = new FormData(document.forms["comments_form"]);

	            var xhr = new XMLHttpRequest();
	            xhr.open('POST', 'comments.php', true);
	            xhr.send(fd);
	            document.getElementById('comment_text').value = '';
	        });
	    }
    </script>
    <script type="text/javascript" src="functions/js_functions.js"></script>
    <?php endif ?>
    <?php if (isloggedin() == false) : ?>
    <script type="text/javascript">
    	const current = document.querySelector('#current');
		const images = document.querySelectorAll('#images img');
		const opacity = 0.4;

		images.forEach(func);

		function func (image) {
		    image.addEventListener('click', imageClick)
		}

		function imageClick(next) {
			const current = document.querySelector('#current');
    		const images = document.querySelectorAll('#images img');
		    images.forEach(img => img.style.opacity = 1);
		    current.src = next.target.src;
		    next.target.style.opacity = opacity;
		}
	</script>
	<?php endif ?>
</body>
</html>