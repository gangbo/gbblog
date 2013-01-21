<?php
$this->load->view('head');
?>
<div>
content....
<p><?=$error_info?></p>
<form action="/admin.php/login/checkLogin" method="post">
    <input type="text" name="login_name" value="<?=$login_name?>"/>
    <input type="password" name="login_password" />
    <input type="submit"/>
</form>
</div>
