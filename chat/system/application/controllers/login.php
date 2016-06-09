<?php

class Login extends Controller {

    function Login() {
        parent::Controller();
        $this->load->model('mod_login');
    }

    //check username and password on database
    function authenticate() {
        $this->load->library('session');
        $session_id = $this->session->userdata('session_id');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        //authenticate users to db
        $result = $this->mod_login->authenticate(
                        $username,
                        $password
        );
        //check if results have been found
        if (count($result) > 0) {
            //store session to users table
            $this->mod_login->store_session(
                    $username,
                    $session_id
            );
            //create custom session data
            $this->session->set_userdata(array('username' => $username));
        }
        //return if login was successful
        echo count($result);
    }

    //attempt to login was successful
    function successful() {
        //sentry to check if user has access
        header('Location: ' . base_url() . 'index.php/home');
    }

}