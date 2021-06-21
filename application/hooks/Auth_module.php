<?php

class Auth_module {
    private $CI;

    public function __construct() {

        $this->CI = &get_instance();
    }

    function check_user_login() {

        if (!$this->CI->session->is_logged_in) {
            redirect(site_url('login'));
        }
    }
}