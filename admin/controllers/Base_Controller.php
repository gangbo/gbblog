<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }
    public function base_fun()
    {
        echo 'base fun :w
		hello world';
    }
}
