<?php
			
function CREATE_KARTU_PASIEN_IMAGES($text="x",$id="0"){

$im = imagecreatefromjpeg(c_TAMPILANDIR."global/images/kartupasien.jpg");
$black = imagecolorallocate($im, 0, 0, 0);

$font = c_TAMPILANDIR.'font/trebuc.ttf';
$x=130;
$y=94;

$font_size=8;
$angle=0;
$total_width=0;
$counter=0;

imagettftext($im, $font_size, $angle, $x, $y, $black, $font, $text);

$text_barcode = "UP4-".$id;
$font_barcode = c_TAMPILANDIR.'font/BarcodeFont.ttf';
$x_barcode=320;
$y_barcode=210;
$font_size_barcode=40;
imagettftext($im, $font_size_barcode, $angle, $x_barcode, $y_barcode, $black, $font_barcode, $text_barcode);

imagepng($im,c_UPLOADDIR."kartupasien/UP4-{$id}.png");
imagedestroy($im);
}
?>