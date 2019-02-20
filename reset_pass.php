<?php
require_once('config/database.php');
$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$result = $db->prepare("SELECT COUNT(login) FROM users WHERE login = :login");
$result->execute(['login' => htmlspecialchars($_POST["login"], ENT_QUOTES, 'UTF-8')]);
$check_email = $result->fetchColumn();
if ($check_email != 1) {
    ?>
    <script type="text/javascript">
        alert("User with this login does not exist!");
        window.location.href = 'forgot.php';
    </script>
<?php
}
else {
    $check = $db->prepare("SELECT recovery FROM users WHERE login = :login");
    $check->execute(['login' => htmlspecialchars($_POST["login"], ENT_QUOTES, 'UTF-8')]);
    $check_key = $check->fetchColumn();

    $stmt = $db->prepare("UPDATE users SET password = :password WHERE login = :login");
    $stmt->execute(['password' => hash("whirlpool", $_POST["password"]), 'login' => htmlspecialchars($_POST["login"], ENT_QUOTES, 'UTF-8')]);
    $stmt = $db->prepare("UPDATE users SET recovery = 'ALL OK' WHERE login = :login");
    $stmt->execute(['login' => htmlspecialchars($_POST["login"], ENT_QUOTES, 'UTF-8')]);
    ?>
    <p>Your password was successfully changed, you can now log in.</p>
    <script type="text/javascript">
        setTimeout("location.href = 'index.php';",2000);
    </script>
    <?php
}
?>
</body>
</html>