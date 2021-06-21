<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Favorite extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
    public function index() {
        $data['error']= "";
        $this->load->model('user_model_mongodb');
        if (!$this->session->userdata('logged_in')) {	
			if (get_cookie('remember')) {  
				$username = get_cookie('username'); 
				$password = get_cookie('password'); 
				$time = time();
				if ( $this->user_model_mongodb->login($username, $password) )
				{
				    $user_data = array('username' => $username,'logged_in' => true, 'time' => $time );
					$this->session->set_userdata($user_data);
				}
			}else{
				redirect('login');
			}
		} else {
			if($this->session->userdata('time') + 300 > time()){
				$time = time();
				$user_data = array(
					'time' => $time
				);
				$this->session->set_userdata($user_data);
			} else {
				$this->session->unset_userdata('logged_in');
				redirect('login');
			}
		}
            $username = $this->session->userdata('username');
            $favorites = $this->user_model_mongodb->getFavorite($username);
            $data['favorites'] = $favorites;
            $this->load->view('template/header');
            $this->load->view('favorite', $data);
            $this->load->view('template/footer');
    }
	public function favorite() {
		$data['error']= "";
		$this->load->model('user_model_mongodb');
		$this->load->model('file_model');
		$title = $this->input->post('title');
		$username = $this->session->userdata('username');
		$favorites = $this->user_model_mongodb->getFavorite($username);
        $data['favorites'] = $favorites;
		if ($this->user_model_mongodb->isFavorite($username, $title)) {
			$this->user_model_mongodb->removeFavorite($username, $title);
			$data['error'] = "The selected video has been removed from your favorite folder.";
			$this->load->view('template/header');
			$this->load->view('favorite', $data);
			$this->load->view('template/footer');
		} else {
			$this->user_model_mongodb->addFavorite($username, $title);
			$data['error'] = "This selected video has been added to your favorite folder.";
			$this->load->view('template/header');
			$this->load->view('favorite', $data);
			$this->load->view('template/footer');
		}
			
	}
}
?>