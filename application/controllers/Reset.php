<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset extends CI_Controller {
	public function index()
	{  
        $data['error']= "";
        $this->load->view('template/header');
		$this->load->view('forget', $data);
		$this->load->view('template/footer');
    }

    public function send() {
        $this->load->model('user_model_mongodb');
        $email = $this->input->post('email');
        if (empty($email)) {
            $data['error'] = "Email error";
        } else {
            $username = $this->user_model_mongodb->getUsername($email);
            if ($username == "") {
                $data['error']= "No account linked to this email address.";
            } else {
                $tel = $this->user_model_mongodb->getTel($username);
                $token = strlen($username).$username.$tel;
                $msg = "Dear User,please click on below URL or paste into your browser to reset password. ".base_url()."reset/check/".$token." Thanks CatLovers";
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
				$this->email->to($email);
				$this->email->cc("s4553030@student.uq.edu.au");
				$this->email->subject("[CatLovers] Reset Password");
				$this->email->message($msg);
				$this->email->send();   

                $data['error']= "An email has been sent to you to reset your password.";
            }
        }
        $this->load->view('template/header');
		$this->load->view('forget', $data);
		$this->load->view('template/footer');
    }

    public function check($token) {
        $this->load->model('user_model_mongodb');
        if ($token == null) {
            $data['error'] = "Token Error1";
            $this->load->view('template/header');
		    $this->load->view('forget', $data);
		    $this->load->view('template/footer');
        } else if (strlen($token) < 3) {
            $data['error'] = "Token Error2";
            $this->load->view('template/header');
		    $this->load->view('forget', $data);
		    $this->load->view('template/footer');
        } else {
            $len = substr($token, 0, 1);
            if (strlen($token) < 1 + $len) {
                $data['error'] = "Token Error3";
                $this->load->view('template/header');
		        $this->load->view('forget', $data);
		        $this->load->view('template/footer');
            } else {
                $username = substr($token, 1, $len);
                $tel = substr($token, $len + 1);
                if (! ($this->user_model_mongodb->exists($username))) {
                    $data['error'] = "The user does not exists.";
                    $this->load->view('template/header');
		            $this->load->view('forget', $data);
		            $this->load->view('template/footer');
                } else {
                    $realTel = $this->user_model_mongodb->getTel($username);
                    if ($tel == $realTel) {
                        $data['username'] = $username;
                        $data['tel'] = $tel;
                        $data['error'] = "";
                        $this->load->view('template/header');
		                $this->load->view('reset', $data);
		                $this->load->view('template/footer');
                    } else {
                        $data['error'] = "Token Error4";
                        $this->load->view('template/header');
		                $this->load->view('forget', $data);
		                $this->load->view('template/footer');
                    }
                }
            }
        }
    }

    public function upt() {
        $this->load->model('user_model_mongodb');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $tel = $this->input->post('tel');
        $realTel = $this->user_model_mongodb->getTel($username);
        if ($tel == $realTel) {
            $this->user_model_mongodb->setPassword($username, $password);
            $data['error'] = "Your password has been reset.";
            $this->load->view('template/header');
		    $this->load->view('login', $data);
		    $this->load->view('template/footer');
        } else {
            $data['error'] = "Token Error";
            $this->load->view('template/header');
		    $this->load->view('forget', $data);
		    $this->load->view('template/footer');
        }
    }
}