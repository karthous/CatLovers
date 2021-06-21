<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('captcha');
	}

	public function index()
	{	
		$this->load->model('user_model_mongodb');
		$this->load->model('file_model');
		$captcha = rand(1000, 9999);
		$vals = array(
			'word' => $captcha,
			'img_path' => './assets/captcha/',
			'img_url' => base_url().'assets/captcha/',
			'expiration' => 600
		);
		$data = create_captcha($vals);
		$user_data = array(
			'captcha' => $captcha,
		);
		$this->session->set_userdata($user_data);
		$this->load->view('template/header');
		$this->load->view('register', $data);
		$this->load->view('template/footer');
	}
	
	public function check_register()
	{
		$this->load->model('user_model_mongodb');
        $this->load->view('template/header');
		$username = $this->input->post('username');
        $password1 = $this->input->post('password1'); 
        $password2 = $this->input->post('password2'); 
        $email = $this->input->post('email');
        $tel = $this->input->post('tel');
		$captcha = $this->input->post('captcha');
		
		if ($this->session->userdata('captcha') == $captcha) {
			if ($this->user_model_mongodb->register($username, $password1, $password2, $email, $tel)) {
				$this->user_model_mongodb->insert($username, $password1, $email, $tel);
    			redirect('login');
        	} else {
  				redirect('register');
			}
		} else {
			redirect('register');
		}
	
	}
}
?>