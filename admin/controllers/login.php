<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'Base_Controller.php';

class Login extends Base_Controller{

    public function index() {
        $this->load->view('content');
    }
    public function checkLogin(){
        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $login_name = $this->input->post('login_name');
        $login_pwd_encrypt = do_hash($this->input->post('login_password'),'md5');
        $this->load->model('User_model');
        $this->User_model->check_pwd($login_name,$login_pwd_encrypt);
    }
}
