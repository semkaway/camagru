<?php
require_once('config/database.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Validation</title>
</head>
<body>
    <h1>Hello</h1>
    <?php
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $login = $_GET['login'];
    $key = $_GET['key'];

    $check = $db->prepare("SELECT validation FROM users WHERE login = :login");
    $check->execute(['login' => $login]);
    $check_key = $check->fetchColumn();
    if ($check_key == $key) {
        echo "Validation successful, you can now log in";?><br><?php
        $stmt = $db->prepare("UPDATE users SET validation = 'OK' WHERE login = :login");
        $stmt->execute(['login' => $login]);
    }
    ?>
    <a href="http://localhost:8100/camagru/index.php">Main page</a>
    <?php
    if ($check_key != $key) {
        echo "Oops, something went wrong. Please, try again later";
        $stmt = $db->prepare("DELETE FROM users WHERE login = :login");
        $stmt->execute(['login' => $login]);
    }
    ?>
</body>
</html>