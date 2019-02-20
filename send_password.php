<?php
    require_once('config/database.php');
    include_once ("functions/functions.php");
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
    <title>Verify</title>
</head>
<body>
<h1 class="header">One more step</h1>
    <p>You are one step away from recovering your password. To complete the process, please check your email.</p>
    <?php
    if ($_POST['email'] != "" && $_POST['submit'] == 'OK') {
        $result = $db->prepare("SELECT COUNT(email) FROM users WHERE email = :email");
        $result->execute(['email' => $_POST["email"]]);
        $check_email = $result->fetchColumn();
        if ($check_email != 1) {
            ?>
            <script type="text/javascript">
                alert("User with this email does not exist!");
                window.location.href = 'forgot.php';
            </script>
        <?php
        }
        else {
            $recover = hash("md5", $_POST["email"].date('mYHis'));
            $stmt = $db->prepare("UPDATE users SET recovery = :recovery WHERE email = :email");
            $stmt->execute(['recovery' => $recover, 'email' => $_POST["email"]]);
            $mail_subject = "Recover your password to Camagru";
            $dir = basename(__DIR__);
            $message = "<strong>Hello!</strong><br>
                        Here is a link to recover your password:<br>
                        <a href='https://kvilnacamagru.000webhostapp.com/recover.php?email=".$_POST["email"]."&key=".$recover."'>Recover my password</a><br>
                        If you got this letter by mistake, please, ignore it.<br>
                        Have a good day!";
            send_mail($_POST["email"], $mail_subject, $message);
        }
    }
?>
<script type="text/javascript">
    setTimeout("location.href = 'index.php';",2000);
</script>
</body>
</html>