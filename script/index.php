<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include('config.php');
include('saetv2.ex.class.php');
$DIR = 'picture';
$json = array();
$big_image = array(
    0 => 'liuyan.jpg',
    1 => 'aisi.jpg'
);
@$image_id = $_GET['image_id'] ? $_GET['image_id'] : 0;
$thumb_images = array_map(function($v) use ($DIR){
                   return "$DIR/thumb_s_$v";
                },$big_image);

$img_arr = array();

for($i=0;$i<8;$i++){
   $img_arr[] = "picture/part-$i-".$big_image[$image_id];
}
//从POST过来的signed_request中提取oauth2信息
function is_auth(){
    if(!empty($_REQUEST["signed_request"])){
        $o = new SaeTOAuthV2( WB_AKEY , WB_SKEY  );
        $data=$o->parseSignedRequest($_REQUEST["signed_request"]);
        if($data=='-2'){
             die('签名错误!');
        }else{
            $_SESSION['oauth2']=$data;
        }
    }
    //判断用户是否授权
    if (empty($_SESSION['oauth2']["user_id"])) {//若没有获取到access token，则发起授权请求
        include "auth.php";
        exit;
    } else {//若已获取到access token，则加载应用信息
        $c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$_SESSION['oauth2']['oauth_token'] ,'' );
        //$c->update('test');
        //var_dump($c->user_timeline_by_id( $_SESSION['oauth2']["user_id"] , 1 , 50 , 0, 0, 0, 0, 1));
    }
}
$json['is_auth'] = is_auth();
//shuffle($img_arr);
array_push($img_arr,'xxx.gif');
include ('aiping.html');
?>
