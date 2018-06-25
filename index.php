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
<!-- 	<h1 class="header">GALLERY</h1> -->
        
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
            <div class="gallery">
                <?php
                    $allPics = $db->prepare("SELECT final_img FROM pictures");
                    $allPics->execute();
                    $id = $allPics->fetchAll(PDO::FETCH_COLUMN, 0);
                    foreach ($id as $picture) {
                        ?><div> <a href="<?php echo $picture; ?>"><img class="gallery-img" src="<?php echo $picture; ?>"></a></div><?php
                    }
                ?>
            </div>
        </div>
</body>
</html>