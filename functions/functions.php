<?php
session_start();
require_once('config/database.php');
$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function isloggedin() {
    if (isset($_SESSION['user'])) {
        if ($_SESSION['user'] != '')
            return true;
    }
    else {
        return false;
    }
}

function combine_imgs($file, $elem) {
	list($width, $height) = getimagesize($file);
	list($width_elem, $height_elem) = getimagesize($elem);

	$ext = pathinfo($file, PATHINFO_EXTENSION);

	$combined_img = imagecreatetruecolor($width, $height) or die("Can't create an image");

	if ($ext == "png") {
		$image_a = imagecreatefrompng($file);
	}
	if ($ext == "jpeg") {
		$image_a = imagecreatefromjpeg($file);
	}
	if ($ext == "gif") {
		$image_a = imagecreatefromgif($file);
	}

	$image_b = imagecreatefrompng($elem);

	if(!$image_a)
    {
        $image_a  = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($image_a, 255, 255, 255);
        $tc  = imagecolorallocate($image_a, 0, 0, 0);

        imagefilledrectangle($image_a, 0, 0, 150, 30, $bgc);

        imagestring($image_a, 1, 5, 5, 'Error loading ' . $imgname, $tc);
    }

	imagealphablending($image_a, false);
	imagesavealpha($image_a, true);

	imagecopyresampled($combined_img, $image_a, 0, 0, 0, 0, $width, $height, $width, $height);
	imagecopyresampled($combined_img, $image_b, 300, 0, 0, 0, $width/3, $height/2, $width_elem, $height_elem);

	if (!file_exists("img/result")) {
    	mkdir("img/result");
	}

	$filename = "combined".mktime(); 
	$directory = "img/result/".$filename.".png";

	imagepng($combined_img, $directory, 0, NULL);
	imagedestroy($combined_img);
	return $directory;
}

function send_mail($email, $mail_subject, $message) {
    $from_name = "Camagru";
    $from_mail = "kvilna@student.unit.ua";
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

    $mail = mail($email, $mail_subject, $message, $header);
}
?>