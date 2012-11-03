<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'Base_Controller.php';

class Home extends Base_Controller{


    public function index() {
        $this->load->view('login',$_POST);
    }

}
