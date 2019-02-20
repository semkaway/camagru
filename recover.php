<?php
require_once('config/database.php');
$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['email']) && isset($_GET['key'])) {
    $email = $_GET['email'];
    $key = $_GET['key'];
}

$check = $db->prepare("SELECT recovery FROM users WHERE email = :email");
$check->execute(['email' => $email]);
$check_key = $check->fetchColumn();
if ($check_key == $key) {
    ?>
    <script type="text/javascript">
        setTimeout("location.href = 'confirm.php';",0);
    </script>
    <?php
}
else {
    ?><p>Ooops, something went wrong. Please, try again later</p>
    <?php
}
?>