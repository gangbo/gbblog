<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        echo 'base c';
        var_dump($this->session->userdata);
        $this->output->enable_profiler(TRUE);
    }
    public function base_fun()
    {
        echo 'base fun :w
        hello world';
    }
}
