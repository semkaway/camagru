<?php
session_start();

function isloggedin() {
    if ($_SESSION['user'] != '') {
        return true;
    }
    else {
        return false;
    }
}

function combine_imgs($file, $elem) {
	$width = 600;
	$height = 500;

	list($width_orig, $height_orig) = getimagesize($file);
	list($width_elem, $height_elem) = getimagesize($elem);

	$ratio_orig = $width_orig/$height_orig;

	if ($width/$height > $ratio_orig) {
	   $width = $height*$ratio_orig;
	} else {
	   $height = $width/$ratio_orig;
	}

	$ratio_elem = $width_elem/$height_elem;

	if ($width_orig/$height_orig > $ratio_elem) {
	   $width_orig = $height_orig*$ratio_elem;
	} else {
	   $height_orig = $width_orig/$ratio_elem;
	}

	$combined_img = imagecreatetruecolor($width, $height) or die("Can't create an image");

	$image_a = imagecreatefrompng($file);
	$image_b = imagecreatefrompng($elem);

	imagealphablending($image_a, false);
	imagesavealpha($image_a, true);

	imagecopyresampled($combined_img, $image_a, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	imagecopyresampled($combined_img, $image_b, 0, 0, 0, 0, $width_orig, $height_orig, $width_elem, $height_elem);

	if (!file_exists("img/result")) {
    	mkdir("img/result");
	}

	$filename = "combined".mktime(); 
	$directory = "img/result/".$filename.".png";

	imagepng($combined_img, $directory, 0, NULL);
}
?>