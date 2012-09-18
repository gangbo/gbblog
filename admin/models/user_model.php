<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends Ci_Model {
    var $user_id;
    var $user_name;
    var $user_password;
    var $user_email;
    function __construct(){
        parent::__construct();
    }
    function check_pwd ($user_name,$user_pwd){
        $sql = "SELECT * FROM gb_users 
            WHERE user_name = ? AND user_password = ?";
        $query = $this->db->query($sql,array($user_name,$user_pwd));
        var_dump($query->result());
    }
}
