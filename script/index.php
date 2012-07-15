<?php
$img_arr = array(
    'part-0-0.jpg',
    'part-0-1.jpg',
    'part-0-2.jpg',
    'part-1-0.jpg',
    'part-1-1.jpg',
    'part-1-2.jpg',
    'part-2-0.jpg',
    'part-2-1.jpg',
    );
$img_arr = array_map(function($v){
            return "picture/$v";
        },$img_arr);
//shuffle($img_arr);
array_push($img_arr,'xxx.gif');
include ('aiping.html');
?>
