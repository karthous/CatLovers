<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here
 class User_model extends CI_Model{

    // Log in
    public function login($username, $password){
        // Validate
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $result = $this->db->get('users');

        if($result->num_rows() == 1){
            return true;
        } else {
            return false;
        }
    }

    public function register($username, $password1, $password2, $email, $tel) {
        // Validate
        if($username==""){
            return false;
        }
        if($password1==""){
            return false;
        }
        if($password2==""){
            return false;
        }
        if($email==""){
            return false;
        }
        if($tel==""){
            return false;
        }

        $this->db->where('username', $username);
        $result = $this->db->get('users');
        if($result->num_rows() >= 1){
            return false;
        }

        if($password1!=$password2){
            return false;
        }
        
        return true;

    }

}
?>
