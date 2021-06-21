<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	public function index() {
		$data['error']= "";
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
					$this->load->view('profile');
				}
			}else{
				redirect('login');
			}
		}else{
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
            $data['username'] = $this->session->userdata('username');
            $data['email'] = $this->user_model_mongodb->getEmail($data['username']);
            $data['tel'] = $this->user_model_mongodb->getTel($data['username']);
			$data['status'] = $this->user_model_mongodb->getStatus($data['username']);
			$this->load->view('template/header');
			$this->load->view('profile', $data);
			$this->load->view('template/footer');
		}
	}

	public function verify() {
		$data['error']= "";
		$this->load->model('user_model_mongodb');
		if (!$this->session->userdata('logged_in')) {	
			if (get_cookie('remember')) { 
				$username = get_cookie('username'); 
				$password = get_cookie('password'); 
				if ( $this->user_model_mongodb->login($username, $password) )
				{
					$time = time();
					$user_data = array(
						'username' => $username,
						'logged_in' => true,
						'time' => $time
					);
					$this->session->set_userdata($user_data);
					redirect('profile/verify');
				}
			}else{
				redirect('login');
			}
		}else{
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
            $data['username']  = $this->session->userdata('username');
            $data['email'] = $this->user_model_mongodb->getEmail($data['username']);
            $data['status'] = $this->user_model_mongodb->getStatus($data['username']);
            $data['tel'] = $this->user_model_mongodb->getTel($data['username']);
            if ($data['status'] == 0) {
                if (empty($data['email'])) {
                    $data['error'] = "Email error";
                }
                $msg = "Dear User,please click on below URL or paste into your browser to verify your email address ".base_url()."profile/check/".$data['tel']." Thanks CatLovers";
				$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => 'mailhub.eait.uq.edu.au',
					'smtp_port' => 25,
					'mailtype' => 'html',
					'charset' => 'iso-8859-1',
					'wordwrap' => TRUE ,
					'mailtype' => 'html',
					'starttls' => true,
					'newline' => "\r\n"
					);
	
				$this->email->initialize($config);
				$this->email->from(get_current_user().'@student.uq.edu.au',get_current_user());
				$this->email->to($data['email']);
				$this->email->cc("s4553030@student.uq.edu.au");
				$this->email->subject("[CatLovers] Verify Email");
				$this->email->message($msg);
				$this->email->send();
				$data['error'] = "Email has been sent.";
            } else if ($data['status'] == 1) {
                $data['error'] = "Your email has been verified.";
            }
			$this->load->view('template/header');
            $this->load->view('profile', $data);
			$this->load->view('template/footer');
		}
    }

	public function check($code) {
		$data['error']= "";
		$this->load->model('user_model_mongodb');
		if (!$this->session->userdata('logged_in')) {	
			if (get_cookie('remember')) { 
				$username = get_cookie('username'); 
				$password = get_cookie('password'); 
				if ( $this->user_model_mongodb->login($username, $password) )
				{
					$time = time();
					$user_data = array(
						'username' => $username,
						'logged_in' => true,
						'time' => $time
					);
					$this->session->set_userdata($user_data);
					redirect('profile/verify');
				}
			}else{
				redirect('login');
			}
		}else{
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
			$username = $this->session->userdata('username');
			if ($this->user_model_mongodb->verifyCheck($username, $code)) {
				$data['error'] = "Your email has been verified.";
			} else {
				$data['error'] = "Token Error.";
			}
			$data['username']  = $this->session->userdata('username');
            $data['email'] = $this->user_model_mongodb->getEmail($data['username']);
            $data['status'] = $this->user_model_mongodb->getStatus($data['username']);
            $data['tel'] = $this->user_model_mongodb->getTel($data['username']);
			$this->load->view('template/header');
			$this->load->view('profile', $data);
			$this->load->view('template/footer');
		}
	}
}
?>