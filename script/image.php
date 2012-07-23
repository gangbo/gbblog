<?php
//header("Content-type: image/png");
//imagepng($im);
$DIR = 'picture';
$big_images = array('liuyan.jpg','aisi.jpg','b.jpg');
foreach ( $big_images as $big_image){
    $x = 3;
    $y = 3;

    $im = imagecreatefromjpeg("$DIR/$big_image");
    list($width, $height, $type, $attr) = getimagesize("$DIR/$big_image");

    require_once('./ThumbGen.class.php');
    $thumbGen = new ThumbGen(false);
    $thumbGen->setQuality(95);
    $thumbGen->getThumbnail("$DIR/$big_image", 120, 120, 'jpg');
    $thumbGen->saveThumbnail("$DIR/thumb_s_$big_image");

    $small_width = $width/$x;
    $small_height = $height/$y;
    var_dump($small_width);
    for($i=0;$i<$x;$i++){
        for($j=0;$j<$y;$j++){
            echo "$i==$j";
            echo "<br/>";
            $img = imagecreatetruecolor ($small_width, $small_height);
            imagecopy($img,$im,0,0,$small_width*$j,$small_height*$i,$small_width, $small_height);
            $img_index = $i*$x+$j;
            imagejpeg($img,"$DIR/part-$img_index-$big_image");
            imagedestroy($img);
        }
    }
    imagedestroy($im);
}
