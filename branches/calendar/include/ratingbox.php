<?php
//this needs to reside in its own php page
//you can include that php page in your html as you would an image:
//<IMG SRC="ratingpng.php?rating=25.2" border="0">

function drawRating($rating, $border) {
	$image = @imagecreate(102,10);
	$back = ImageColorAllocate($image,255,255,255);
	$border = ImageColorAllocate($image,0,0,0);
	$red = ImageColorAllocate($image,255,60,75);
	$fill = ImageColorAllocate($image,44,81,150);
	imagefilledrectangle($image,0,0,101,9,$back);
	imagefilledrectangle($image,1,1,$rating,9,$fill);
	imagerectangle($image,0,0,101,9,$border);
	imagepng($image);
	imagedestroy($image);
}

if(isset($_REQUEST['rating'])) {
header("Content-Type: image/png");
drawRating($_REQUEST['rating'], 0);
}

?>
