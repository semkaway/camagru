<?php
session_start();
include_once('config/setup.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>welcome</title>
</head>
<body>
	<h1 class="header">Welcome, <?php echo $_SESSION['user']?>!</h1>
    <p>Your login: <?php echo $_SESSION['user']?></p><br>
    <p>Your email: <?php echo $_SESSION['email']?></p><br>
    <p>Your pass: <?php echo $_SESSION['password']?></p><br>
    <?php
    $encoding = "utf-8";

        // Set preferences for Subject field
        $subject_preferences = array(
            "input-charset" => $encoding,
            "output-charset" => $encoding,
            "line-length" => 76,
            "line-break-chars" => "\r\n"
        );

        // Set mail header
        $header = "Content-type: text/html; charset=".$encoding." \r\n";
        $header .= "From: ".$from_name." <MAAAAAAIL> \r\n";
        $header .= "MIME-Version: 1.0 \r\n";
        $header .= "Content-Transfer-Encoding: 8bit \r\n";
        $header .= "Date: ".date("r (T)")." \r\n";
        $header .= iconv_mime_encode("Subject", "Prüfung Prüfung", $subject_preferences);

        // Send mail
        mail($_SESSION['email'], "Prüfung Prüfung", "Yo Yo Yo", $header);
    ?>
</body>
</html>