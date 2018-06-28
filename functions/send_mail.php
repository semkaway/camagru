<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
<?php
function send_mail($login, $email, $validate) {
    ?><h1 class="header">Welcome, <?php echo $login?>!</h1>
    <p>Thank you for registration. To complete the process, please check your email.</p><?php
    $from_name = "Camagru";
    $from_mail = "kvilna@student.unit.ua";
    $mail_subject = "Complete your registration to Camagru";
    $mail_message = "<strong>Hello, ".$login."!</strong><br>
                        Thank you for registration in our application. There is just one more step left for you to fully experience the app.<br>
                        Please, click on the link below:<br>
                        <a href='http://localhost:8080/camagru/validate.php?login=".$login."&key=".$validate."'>Verify my email</a><br>
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
</body>
</html>