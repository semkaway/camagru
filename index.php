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
	<h1 class="header">Hello</h1>
    <?php
        $allPics = $db->prepare("SELECT final_img FROM pictures");
        $allPics->execute();
        $id = $allPics->fetchAll(PDO::FETCH_COLUMN, 0);
        foreach ($id as $picture) {
            ?><img class="gallery_img" src="<?php echo $picture; ?>"><br><?php
        }
    ?>
</body>
</html><br>
<?php
    var_dump($_SESSION);
?>