<?php
session_start();
include_once('config/setup.php');
include ("includes/header.php");
$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
    <title>Camagru</title>
</head>
<body>
	<script type="text/javascript">
	</script>
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
                        <div class="button">
                            <a href="login_form.php">Log in</a>
                        </div>
                        <div class="button">
                            <a href="signup_form.php">Sign up</a>
                        </div>
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
            <?php
                    $allPics = $db->prepare("SELECT final_img FROM pictures");
                    $allPics->execute();
                    $id = $allPics->fetchAll(PDO::FETCH_COLUMN, 0);
                ?>
                <div class="main-img">
                    <div class="picture-like">
                        <img id="current" src="<?php echo $id[0]; ?>">
                            <div class="button" id="like" onclick="setTimeout(function() { makeRequest('amount_of_likes', 'update_likes.php', 'form1'); }, 100);">
                                    <form class="hidden" method="post" accept-charset="utf-8" name="form1">
                                        <input name="photo_id" id='photo_id' type="hidden"/>
                                    </form>
                                    <div id="amount_of_likes">
                                        <?php

                                        $log_check = $db->prepare("SELECT id FROM users WHERE login = :login");
                                        $log_check->execute(['login' => $_SESSION['user']]);
                                        $user_id = $log_check->fetchColumn();

                                        $pic_id = $db->prepare("SELECT id FROM pictures WHERE final_img = :final_img");
                                        $pic_id->execute(['final_img' => $id[0]]);
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
                    <div class="comments">
                        <form class="new_comment" name="comments_form">
                            <input type="text" name="comment_text" id="comment_text" placeholder="Your comment...">
                            <input name="pic_id" id='pic_id' type="hidden"/>
                        </form>
                        <div class="button" value="Comment" id="comment" onclick="setTimeout(function() { makeRequest('comments_texts', 'update_comments.php', 'comments_form'); }, 100);">Comment</div>
                        <div id="comments_texts">
                            <?php
                            $allComments = $db->prepare("SELECT comment FROM comments WHERE picture_id = :picture_id");
                            $allComments->execute(['picture_id' => $picture_id]);
                            $comments = $allComments->fetchAll(PDO::FETCH_COLUMN, 0);
                            foreach ($comments as $comment) {
                                ?><div><?php echo $comment; ?></div><?php
                            }
                            ?>
                        </div>
                        <div class="button" value="Load more comments">Load more comments</div>
                    </div>
                </div>
                <div class="images">
                    <?php
                    foreach ($id as $picture) {
                        ?><img src="<?php echo $picture; ?>"><?php
                    }
                    ?>
                </div>
        </div>
    </div>
    <script type="text/javascript">
        const likeButton = document.querySelector('#like');
        const commentButton = document.querySelector('#comment');
        const comment = document.querySelector('#comment_text');
        const current = document.querySelector('#current');
        const images = document.querySelectorAll('.images img');
        const opacity = 0.4;

        images.forEach(func);

        function func (image) {
            image.addEventListener('click', imageClick)
        }

        function imageClick(next) {
            images.forEach(img => img.style.opacity = 1);
            current.src = next.target.src;
            next.target.style.opacity = opacity;

            makeRequest('amount_of_likes', 'update_likes.php', 'form1');
            //makeRequest('comments_texts', 'update_comments.php', 'comments_form');
            // makeRequestComments('comments_texts');
        }

        function makeRequest(divID, script, form) {
        	document.getElementById('photo_id').value = current.src; 
        	var fd = new FormData(document.forms[form]);
                if (window.XMLHttpRequest)
                    httpRequest = new XMLHttpRequest();
                if (!httpRequest) {
                    alert('Giving up :( Cannot create an XMLHTTP instance');
                    return false;
                }
                httpRequest.onreadystatechange = function() { 
                    alertContents(httpRequest, divID);
                };
                httpRequest.open('POST', script, true);
                httpRequest.send(fd);
            }

        function alertContents(httpRequest, divID) {
            if (httpRequest.readyState == 4) {
                if (httpRequest.status == 200) {
                    document.getElementById(divID).innerHTML = httpRequest.responseText;
                } else {
                    alert('There was a problem with the request. '+ httpRequest.status);

                }
            }
        }

        likeButton.addEventListener('click', () => {
            document.getElementById('photo_id').value = current.src;
            var fd = new FormData(document.forms["form1"]);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'likes.php', true);
            xhr.send(fd);
        });

        commentButton.addEventListener('click', () => {
            document.getElementById('pic_id').value = current.src;

            var fd = new FormData(document.forms["comments_form"]);

            for (var value of fd.values()) {
               console.log(value); 
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'comments.php', true);
            xhr.send(fd);
        });
    </script>
</body>
</html>