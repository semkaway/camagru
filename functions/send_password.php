<?php
    require_once('../config/database.php');
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify</title>
</head>
<body>
<?php
function send_password($email, $validate) {
    ?><h1 class="header">One more step</h1>
    <p>You are one step away from recovering your password. To complete the process, please check your email.</p><?php
    $from_name = "Camagru";
    $from_mail = "kvilna@student.unit.ua";
    $mail_subject = "Recover your password to Camagru";
    $mail_message = "<strong>Hello!</strong><br>
                        Here is a link to recover your password:<br>
                        <a href='http://localhost:8100/camagru/recover.php?email=".$email."&key=".$validate."'>Recover my password</a><br>
                        If you got this letter by mistake, please, ignore it.<br>
                        Have a good day!";
    $encoding = "utf-8";
    $subject_preferences = array(
        "input-charset" => $encoding,
        "output-charset" => $encoding,
        "line-length" => 76,
        "line-break-chars" => "\r\n"
    );

    $header = "Content-type: text/html; charset=".$encoding." \r\n";
    $header .= "From: ".$from_name." <".$from_mail."> \r\n";
    $header .= "MIME-Version: 1.0 \r\n";
    $header .= "Content-Transfer-Encoding: 8bit \r\n";
    $header .= "Date: ".date("r (T)")." \r\n";
    $header .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);

    $mail = mail($email, $mail_subject, $mail_message, $header);
}
?>

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
            send_password($_POST["email"], $recover);
        }
    }
?>
</body>
</html>