<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
	public function index()
	{
		$this->session->unset_userdata('logged_in');
		set_cookie("username", 0, '-1'); 
		set_cookie("password", 0, '-1'); 
		set_cookie("remember", 0, '-1'); 
		redirect('login'); 
	}
}
?>