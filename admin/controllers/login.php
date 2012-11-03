<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'Base_Controller.php';

class Login extends Base_Controller{

    public function index() {
        var_dump($_POST);
        $this->load->view('login',$_POST);
    }
    public function checkLogin(){
        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $login_name = $this->input->post('login_name');
        $login_pwd_encrypt = do_hash($this->input->post('login_password'),'md5');
        $this->load->model('User_model');
        $user_info = $this->User_model->check_pwd($login_name, $login_pwd_encrypt);
        if(!$user_info){
            $_POST['error_info'] = '用户名或密码错误';
            $this->index();
            return;
        }
        var_dump($user_info);
        $this->session->set_userdata( array( 'user_id' => $user_info->user_id ) );
        $this->load->helper('url');

        redirect('home');
    }
}
