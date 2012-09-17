<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'Base_Controller.php';

class Login extends Base_Controller{

    public function index()
    {
        $this->load->view('content');
        $query = $this->db->query('show tables');
        var_dump($query->result());
        echo 'hello world';
    }
    public function checkLogin(){
        var_dump($_POST);
        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $login_pwd_encrypt = do_hash('111111','md5');
        $sql = "SELECT * FROM gb_users WHERE user_name = ? AND user_password = ?"; 
        $query = $this->db->query($sql,array('gangbo',$login_pwd_encrypt));
        var_dump($query->result());
    }
}
