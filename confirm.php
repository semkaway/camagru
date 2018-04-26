<?php
require_once('config/database.php');
$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_POST["password"] == "" || $_POST["login"] == "" || $_POST["submit"] != "OK") {
    ?>
    <script type="text/javascript">
        alert("All fields must be filled!");
        window.location.href = 'confirm.php';
    </script>
    <?php
}
else
{
    $result = $db->prepare("SELECT COUNT(login) FROM users WHERE login = :login");
    $result->execute(['login' => $_POST["login"]]);
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
        $check->execute(['login' => $_POST["login"]]);
        $check_key = $check->fetchColumn();
        if (preg_match("/[1-9]/", $_POST["password"]) == 0 || preg_match("/[A-Z]/", $_POST["password"]) == 0 || strlen($_POST["password"]) < 6) {
            ?>
            <script type="text/javascript">
                alert("Your password must have at least one digit, one uppercase letter, and be at least 6 characters long!");
                window.location.href = "forgot.php";
            </script>
            <?php
        }
        else {
            $stmt = $db->prepare("UPDATE users SET password = :password WHERE login = :login");
            $stmt->execute(['password' => hash("whirlpool", $_POST["password"]), 'login' => $_POST["login"]]);
            $stmt = $db->prepare("UPDATE users SET recovery = 'ALL OK' WHERE login = :login");
            $stmt->execute(['login' => $_POST["login"]]);
            ?>
            <p>Your password was successfully changed, you can now log in.</p>
            <script type="text/javascript">
                setTimeout("location.href = 'index.php';",2000);
            </script>
            <?php
        }
    }
}
?>
</body>
</html>