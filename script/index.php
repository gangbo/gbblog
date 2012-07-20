<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include('config.php');
include('saetv2.ex.class.php');
$json = array();
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
    }
}
$json['is_auth'] = is_auth();
//shuffle($img_arr);
array_push($img_arr,'xxx.gif');
include ('aiping.html');
?>
