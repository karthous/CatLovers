<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function index()
	{
		$data['error']= "";
		$this->load->view('template/header');
		$this->load->model('user_model_mongodb');
		if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model_mongodb->login($username, $password) )//check username and password correct
				{
					$time = time();
					$user_data = array(
						'username' => $username,
						'logged_in' => true,
						'time' => $time
					);
					$this->session->set_userdata($user_data); //set user status to login in session
					redirect('main');  //if user already logined show main page
				}
			}else{
				$this->load->view('login', $data);
			}
		}else{
			redirect('main'); ; //if user already logined show main page
		}
		$this->load->view('template/footer');
	}

	public function check_login()
	{	
		$this->load->model('user_model_mongodb');
		$data['error']= "<div class=\"alert alert-danger\" role=\"alert\"> Incorrect username or password!! </div> ";
		$this->load->view('template/header');
		$username = $this->input->post('username'); 
		$password = $this->input->post('password');
		$remember = $this->input->post('remember'); 
		$time = time();
		if(!$this->session->userdata('logged_in')){	
			if ( $this->user_model_mongodb->login($username, $password) )
			{
				$user_data = array(
					'username' => $username,
					'logged_in' => true,
					'time' => $time	
				);
				if($remember) { 
					set_cookie("username", $username, '300'); 
					set_cookie("password", $password, '300'); 
					set_cookie("remember", $remember, '300'); 
				}	
				$this->session->set_userdata($user_data); 
				redirect('login'); 
			} else {
				$this->load->view('login', $data);
			}
		}else{
			{
				redirect('login');
			}
		$this->load->view('template/footer');
		}
	}
}
?>