<?php
//header("Content-type: image/png");
$string = $_GET['text'];
$im     = imagecreatefromjpeg("liuyan.jpg");
//imagepng($im);
$x = 3;
$y = 3;

list($width, $height, $type, $attr) = getimagesize("liuyan.jpg");
$small_width = $width/$x;
$small_height = $height/$y;
for($i=0;$i<$y;$i++){
    for($j=0;$j<$x;$j++){
        echo "$i==$j";
        echo "<br/>";
        $img = imagecreatetruecolor ($small_width, $small_height);
        imagecopy($img,$im,0,0,$small_width*$i,$small_height*$j,$small_width, $small_height);
        imagejpeg($img,"part-$i-$j.jpg");
        imagedestroy($img);
    }
}
imagedestroy($im);
