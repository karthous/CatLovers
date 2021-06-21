<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    //put your code here
    class User_model_mongodb extends CI_Model{
        public function __construct() {
            $this->load->database();
        }

        public function login($username, $password) {
            $this->db->select('password');
            $this->db->from('users');
		    $this->db->where('username', $username);
            $query = $this->db->get();
            $array = $query->result_array();
            $epassword = substr(strstr(json_encode($array),':"', false), 2, -3);
            $len = intval(substr($epassword, 0, 1));
            $dpassword = substr($epassword, 1, $len);
            if($dpassword == $password) {
                return true;
            }
            return false;
        }

        public function register($username, $password1, $password2, $email, $tel) {
            $this->db->where('username', $username);
            $result = $this->db->get('users');
            if($result->num_rows() >= 1){
                return false;
            }

            $this->db->where('email', $email);
            $result = $this->db->get('users');
            if($result->num_rows() >= 1){
                return false;
            }

            if(strlen($password1)<4) {
                return false;
            }

            if($password1!=$password2){
                return false;
            }
        
        return true;
        }

        public function insert($username, $password, $email, $tel) {
            $len = strlen($password);
            $epassword = $len.$password.rand(0,9999);
            $data = array(
                'username' => $username,
                'password' => $epassword,
                'email' => $email,
                'tel' => $tel
            );
            $this->db->insert('users', $data);
        }

        public function getEmail($username) {
            $this->db->select('email');
            $this->db->from('users');
            $this->db->where('username', $username);
            $query = $this->db->get();
            $array = $query->result_array();
            $str = substr(strstr(json_encode($array),':"', false), 2, -3);
            return $str;
        }

        public function getTel($username) {
            $this->db->select('tel');
            $this->db->from('users');
            $this->db->where('username', $username);
            $query = $this->db->get();
            $array = $query->result_array();
            $str = substr(strstr(json_encode($array),':"', false), 2, -3);
            return $str;
        }

        public function getStatus($username) {
            $this->db->select('status');
            $this->db->from('users');
            $this->db->where('username', $username);
            $query = $this->db->get();
            $array = $query->result_array();
            $str = substr(strstr(json_encode($array),':"', false), 2, -3);
            return $str;
        }

        public function getUsername($email) {
            $this->db->select('username');
            $this->db->from('users');
            $this->db->where('email', $email);
            $query = $this->db->get();
            if($query->num_rows() == 0){
                return "";
            }
            $array = $query->result_array();
            $str = substr(strstr(json_encode($array),':"', false), 2, -3);
            return $str;
        }

        public function update($username, $email, $tel) {
            $data = array(
                'email' => $email,
                'tel' => $tel,
                'status' => 0
            );
            $this->db->where('username', $username);
            $this->db->update('users', $data);
        }

        public function getFavorite($username) {
            $this->db->select("V.id, V.title, V.videopath");
            $this->db->from("videos V");
            $this->db->join('favorites F', 'V.title = F.title');
            $this->db->where('F.username', $username);
            $query = $this->db->get();
            if ($query->num_rows() == 0) {
                return "";
            }
            return $query->result_array();
        }

        public function isFavorite($username, $title) {
            $where = array(
                'username' => $username,
                'title' => $title
            );
            $this->db->select('title');
            $this->db->from('favorites');
            $this->db->where($where);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return true;
            }
            return false;
        }

        public function addFavorite($username, $title) {
            $data = array(
                'username' => $username,
                'title' => $title
            );
            $this->db->insert('favorites', $data);
        }

        public function removeFavorite($username, $title) {
            $where = array(
                'username' => $username,
                'title' => $title
            );
            $this->db->where($where);  
            $this->db->delete('favorites');
        }

        public function verifyCheck($username, $code) {
            $this->db->select('tel');
            $this->db->from('users');
		    $this->db->where('username', $username);
            $query = $this->db->get();
            $array = $query->result_array();
            $tel = substr(strstr(json_encode($array),':"', false), 2, -3);
            if($tel == $code) {
                $data = array(
                    'status' => 1
                );
                $this->db->where('username', $username);
                $this->db->update('users', $data);
                return true;
            } else {
                return false;
            }
        }

        public function setPassword($username, $password) {
            $len = strlen($password);
            $epassword = $len.$password.rand(0,9999);
            $data = array(
                'password' => $epassword
            );
            $this->db->where('username', $username);
            $this->db->update('users', $data);
        }

        public function exists($username) {
            $this->db->select("username");
            $this->db->from("users");
            $this->db->where('username', $username);
            $query = $this->db->get();
            if ($query->num_rows() == 0) {
                return false;
            } else {
                return true;
            }
        }
    }
?>