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
<!-- 	<h1 class="header">GALLERY</h1>
 -->        
        <div class="wrapper">
            <div class="sidebar">
                <div>
                    <?php if (isloggedin() == false) : ?>
                        <div class="button">
                            <a href="index.php">Home</a>
                        </div>
                        <div class="button">
                            <a href="login_form.php">Log in</a>
                        </div>
                        <div class="button">
                            <a href="signup_form.php">Sign up</a>
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
                    <?php endif ?>
                </div>
            </div>
            <div class="gallery">
                <?php
                    $allPics = $db->prepare("SELECT final_img FROM pictures");
                    $allPics->execute();
                    $id = $allPics->fetchAll(PDO::FETCH_COLUMN, 0);
                    foreach ($id as $picture) {
                        ?><div> <img src="<?php echo $picture; ?>"></div><?php
                    }
                ?>
            </div>
        </div>
</body>
</html><br>
<?php
    var_dump($_SESSION);
?>