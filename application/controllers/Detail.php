<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail extends CI_Controller {
    public function index() {
        show_404();
    }

    public function read($id) {
		$data['error'] = "";
        $data['title'] = "";
        $this->load->model('file_model');
        $info = $this->file_model->detail($id);
        $data['info_list'] = $info;
        if (is_array($info)) {
            $title = $info[0]['title'];
            $data['title'] = $title;
        }
        $data['id'] = $id;
        if($this->session->userdata('time') + 300 > time()){
            $time = time();
            $user_data = array(
                'time' => $time
            );
            $this->session->set_userdata($user_data);
        }
		$this->load->view('template/header');
        $this->load->view('detail', $data);
        $this->load->view('template/footer');
    }

    public function favorite() {
        $data['error']= "";
        $this->load->model('user_model_mongodb');
        $this->load->model('file_model');
        $title = $this->input->post('title');
        $id = $this->input->post('id');
        $username = $this->session->userdata('username');
        $info = $this->file_model->detail($id);
        $data['info_list'] = $info;
        if ($this->session->userdata('logged_in')) {
            if($this->session->userdata('time') + 300 > time()){
				$time = time();
				$user_data = array(
					'time' => $time
				);
				$this->session->set_userdata($user_data);
			}
        } else {
            redirect('login');
        }
        if (is_array($info)) {
            $title = $info[0]['title'];
            $data['title'] = $title;
        }
        $data['id'] = $id;
        if ($this->user_model_mongodb->isFavorite($username, $title)) {
            $this->user_model_mongodb->removeFavorite($username, $title);
            $data['error'] = "This video has been removed from your favorite folder.";
            $this->load->view('template/header');
            $this->load->view('detail', $data);
            $this->load->view('template/footer');
        } else {
            $this->user_model_mongodb->addFavorite($username, $title);
            $data['error'] = "This video has been added to your favorite folder.";
            $this->load->view('template/header');
            $this->load->view('detail', $data);
            $this->load->view('template/footer');
        }
        
    }
}
?>