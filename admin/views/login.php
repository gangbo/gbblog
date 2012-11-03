<?php
$this->load->view('head');
?>
<div>
content....
<p><?php if(isset($error_info))
        echo $error_info
    ?></p>
<form action="/admin.php/login/checkLogin" method="post">
    <input type="text" name="login_name" value="<?php if(isset($login)){
        echo $login_name;}?>"/>
    <input type="password" name="login_password" />
    <input type="submit"/>
</form>
</div>
