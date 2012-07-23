<?php
require_once('./ThumbGen.class.php');
$DIR_BIG = 'picture';
$DIR_S = 'picture/s';
$big_images = array('liuyan.jpg','aisi.jpg','b.jpg');
$x = 3;
$y = 3;
foreach ( $big_images as $big_image){
    list($width, $height, $type, $attr) = getimagesize("$DIR_BIG/$big_image");
    $thumbGen = new ThumbGen(false);
    if( $width<=500 ){
        copy("$DIR_BIG/$big_image", "$DIR_S/$big_image");
    }else{
        $height = $height*500/$width;

        /*先将大图缩小为宽度500-的*/
        $thumbGen->getThumbnail("$DIR_BIG/$big_image", 500, $height, 'jpg');
        $thumbGen->saveThumbnail("$DIR_S/$big_image");
    }
    //缩略图
    $thumbGen->getThumbnail("$DIR_BIG/$big_image", 120, 120, 'jpg');
    $thumbGen->saveThumbnail("$DIR_S/thumb_s_$big_image");
}
//图片切分
foreach ( $big_images as $big_image){

    $im = imagecreatefromjpeg("$DIR_S/$big_image");
    list($width, $height, $type, $attr) = getimagesize("$DIR_S/$big_image");

    $thumbGen = new ThumbGen(false);

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
            imagejpeg($img,"$DIR_S/part-$img_index-$big_image");
            imagedestroy($img);
        }
    }
    imagedestroy($im);
}
