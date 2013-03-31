<?php
$str = 'ab_hello_world_Hello';
echo "\$str = $str \n";
function toUp($matches){
    if(ord($matches[2])>90){
        return chr(ord($matches[2])-32);
    }
    return $matches[2];
}
echo (preg_replace_callback('/(^|_)([a-zA-Z])/',
'toUp',
$str));

