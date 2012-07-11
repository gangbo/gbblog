<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'Base_Controller.php';

class Login extends Base_Controller{

    public function index()
    {
        $this->load->view('content');
        echo 'hello world';
    }
}
