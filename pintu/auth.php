<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>未授权页面</title>
<style>
    body {
        background: url(http://www.cdtv.cn/uploadfile/2010/0904/20100904054227888.jpg);
    }
</style>
</head>

<script src="http://tjs.sjs.sinajs.cn/t35/apps/opent/js/frames/client.js" language="JavaScript"></script>
<script>
function authLoad(){
    App.AuthDialog.show({
        client_id : '<?php echo WB_AKEY;?>',    //必选，appkey
        redirect_uri : '<?php echo CANVAS_PAGE;?>',     //必选，授权后的回调地址
        height: 120    //可选，默认距顶端120px
    });
}
</script>
<body onload="authLoad();">
</body>
</html>

