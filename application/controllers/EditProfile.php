<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EditProfile extends CI_Controller {
	public function index()
	{
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$this->load->model('user_model_mongodb');
        $data['username'] = $this->session->userdata('username');
		if($this->session->userdata('time') + 300 > time()){
			$time = time();
			$user_data = array(
				'time' => $time
			);
			$this->session->set_userdata($user_data);
		}
		$this->load->view('editProfile', $data);
		$this->load->view('template/footer');
	}
    public function update_profile()
	{
		$this->load->model('user_model_mongodb');
		$this->load->helper('form');
		$this->load->helper('url');
        $this->load->view('template/header');
        
        $username = $this->session->userdata('username');
        $email = $this->input->post('email');
        $tel = $this->input->post('tel');

		$this->user_model_mongodb->update($username, $email, $tel);
		if($this->session->userdata('time') + 300 > time()){
			$time = time();
			$user_data = array(
				'time' => $time
			);
			$this->session->set_userdata($user_data);
		}
        redirect('profile');

        $this->load->view('template/footer');
	}
}
?>