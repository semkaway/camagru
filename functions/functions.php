<?php
session_start();
require_once('config/database.php');
$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function isloggedin() {
    if ($_SESSION['user'] != '') {
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
        /* Create a blank image */
        $image_a  = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($image_a, 255, 255, 255);
        $tc  = imagecolorallocate($image_a, 0, 0, 0);

        imagefilledrectangle($image_a, 0, 0, 150, 30, $bgc);

        /* Output an error message */
        imagestring($image_a, 1, 5, 5, 'Error loading ' . $imgname, $tc);
    }

	imagealphablending($image_a, false);
	imagesavealpha($image_a, true);

	imagecopyresampled($combined_img, $image_a, 0, 0, 0, 0, $width, $height, $width, $height);
	imagecopyresampled($combined_img, $image_b, 0, $height/3, 0, 0, $width/2, $height/1.5, $width_elem, $height_elem);

	if (!file_exists("img/result")) {
    	mkdir("img/result");
	}

	$filename = "combined".mktime(); 
	$directory = "img/result/".$filename.".png";

	imagepng($combined_img, $directory, 0, NULL);
	imagedestroy($combined_img);
	return $directory;
}
?>