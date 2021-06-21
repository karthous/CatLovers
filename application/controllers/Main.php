<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Main extends CI_Controller {
    public function index() {
		$data['error']= "";
        $this->load->model('file_model');
        $video_list = $this->file_model->push();
        $data['video_list'] = $video_list;
		$this->load->view('template/header');
        $this->load->view('main', $data);
        $this->load->view('template/footer');
    }
    
}
?>