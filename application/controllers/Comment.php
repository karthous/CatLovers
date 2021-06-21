<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Comment extends CI_Controller {
    public function index() {
        show_404();
    }

    public function read($id) {
		$data['error'] = "";
        $data['title'] = "";
        $this->load->model('file_model');
        $info = $this->file_model->comment($id);
        $data['info_list'] = $info;
        if (is_array($info)) {
            $title = $info[0]['title'];
            $data['title'] = $title;
        }
        $data['id'] = $id;
        if ($this->session->userdata('logged_in')) {
            if($this->session->userdata('time') + 300 > time()){
				$time = time();
				$user_data = array(
					'time' => $time
				);
				$this->session->set_userdata($user_data);
			}
        }
		$this->load->view('template/header');
        $this->load->view('comment', $data);
        $this->load->view('template/footer');
    }

    public function write() {
        $this->load->model('file_model');
        if ($this->session->userdata('logged_in')) {
            $username = $this->session->userdata('username');
        } else {
            $username = $this->input->ip_address();
        }
        $video_id = $this->input->post('video_id');
        $content = $this->input->post('content');
        $this->file_model->addComment($username, $video_id, $content);
        $data['error'] = "";
        $data['title'] = "";
        $info = $this->file_model->comment($video_id);
        $data['info_list'] = $info;
        if (is_array($info)) {
            $title = $info[0]['title'];
            $data['title'] = $title;
        }
        $data['id'] = $video_id;
        $this->load->view('template/header');
        $this->load->view('comment', $data);
        $this->load->view('template/footer');
    }
}
?>