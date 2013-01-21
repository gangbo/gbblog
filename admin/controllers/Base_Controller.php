<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base_Controller extends CI_Controller {

    public $stash = Array();

    function __construct()
    {
        parent::__construct();
        var_dump($this->session->userdata);
        $this->output->enable_profiler(TRUE);
    }

    public function base_fun()
    {
        echo 'base fun hello world';
    }

    public function tpl($tplname){
        var_dump($this->stash);
        $this->load->view($tplname,$this->stash);
    }

    public function stash($array){
        foreach ($array as $key=>$value){
            echo $key;
            $this->stash[$key] = $value;
        }
    }
}
