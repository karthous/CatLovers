<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload extends CI_Controller
{
    public function index()
    {	
		$this->load->model('user_model_mongodb');
		$this->load->view('template/header'); 
    	if (!$this->session->userdata('logged_in'))
		{	
			if (get_cookie('remember')) {  
				$username = get_cookie('username'); 
				$password = get_cookie('password'); 
				if ( $this->user_model_mongodb->login($username, $password) )
				{
					$user_data = array('username' => $username,'logged_in' => true );
					$this->session->set_userdata($user_data);
					$this->load->view('file',array('error' => ' '));
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
				$this->load->view('file',array('error' => ' '));
			} else {
				$this->session->unset_userdata('logged_in');
				redirect('login');
			}
		}
		$this->load->view('template/footer');
    }
    public function do_upload() {
		$this->load->model('file_model');
        $config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'jpg|png|mp4';
		$config['max_size'] = 100000;
		$config['max_width'] = 1024;
		$config['max_height'] = 768;
		$this->load->library('upload', $config);
		$success = 1;

		if ( ! $this->file_model->validateTitle($this->input->post('title'))) {
			$success = 0;
		}


		if ( ! $this->upload->do_upload('coverimage')) {
			$success = 0;
        }

		if ( ! $this->upload->do_upload('userfile')) {
			$success = 0;
		}

		if ($success == 1) {
			$this->upload->do_upload('coverimage');
			$this->file_model->uploadImage($this->upload->data('file_name'), $this->upload->data('full_path'),$this->session->userdata('username'), $this->input->post('title'));
			$path = strstr($this->upload->data('full_path'), '/uploads');
			$this->load->library('image_lib');
			$str = substr($path, 0, -4);
			$iconfig['source_image'] = '.'.$path;
			$iconfig['wm_text'] = 'CatLovers';
			$iconfig['wm_type'] = 'text';
			$iconfig['wm_font_path'] = './system/fonts/texb.ttf';
			$iconfig['wm_font_size'] = '16';
			$iconfig['wm_font_color'] = 'ffffff';
			$iconfig['wm_vrt_alignment'] = 'middle';
			$iconfig['wm_hor_alignment'] = 'center';
			$iconfig['new_image'] = '.'.$str."_w.jpg";
			$this->image_lib->initialize($iconfig);
			$this->image_lib->watermark();

			$this->upload->do_upload('userfile');
			$this->file_model->uploadVideo($this->upload->data('file_name'), $this->upload->data('full_path'),$this->session->userdata('username'), $this->input->post('title'));
            $this->load->view('template/header');
            $this->load->view('file', array('error' => 'Files upload success. <br/>'));
            $this->load->view('template/footer');
		} else {
			$this->load->view('template/header');
            $this->load->view('file', array('error' => 'Files upload fail. <br/>'));
            $this->load->view('template/footer');
		}
	}
}
?>
