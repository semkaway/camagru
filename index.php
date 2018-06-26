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
                        <div class="likes">
                            <div class="button" id="like">
                                <div class="num_of_likes">
                                    <?php
                                        $value_like = $db->prepare("SELECT value FROM likes WHERE value LIKE '%like%'");
                                        $value_like->execute(['value' => 'like']);;
                                        $num_likes = $value_like->rowCount();

                                        $value_dislike = $db->prepare("SELECT value FROM likes WHERE value LIKE '%dislike%'");
                                        $value_dislike->execute(['value' => 'like']);;
                                        $num_dislikes = $value_dislike->rowCount();
                                    echo $num_likes - $num_dislikes; ?>
                                </div>
                                <form method="post" accept-charset="utf-8" name="form1">
                                    <input name="photo_id" id='photo_id' type="hidden"/>
                                    <input name="user_id_liked" id='user_id_liked' type="hidden"/>
                                </form>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f1/Heart_coraz%C3%B3n.svg/1200px-Heart_coraz%C3%B3n.svg.png">
                            </div>
                        </div>
                    </div>
                    <div class="comments">
                        Box for comments
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
        }
    </script>
</body>
</html>