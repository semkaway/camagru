<?php
	//header("Content-Type: image/png");
function combine_imgs() {
	$width = 500;
	$height = 300;

	list($width_orig, $height_orig) = getimagesize("upload/1525090890.png");
	list($width_elem, $height_elem) = getimagesize("additions/sunrise.png");

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

	$image_a = imagecreatefrompng("upload/1525090890.png");
	$image_b = imagecreatefrompng("additions/sunrise.png");

	imagealphablending( $image_a, false );
	imagesavealpha( $image_a, true );

	imagecopyresampled($combined_img, $image_a, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	imagecopyresampled($combined_img, $image_b, 0, 0, 0, 0, $width_orig, $height_orig, $width_elem, $height_elem);

	$filename = "any_name"; 
	$directory = "upload/".$filename.".png";

	imagepng($combined_img, $directory, 0, NULL);
}
?>
