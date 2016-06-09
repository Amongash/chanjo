<?php

class Logout extends Controller {

    function Logout() {
        parent::Controller();
    }

    function index() {
        $this->load->library('session');
        $this->session->sess_destroy();
        header('Location: ' . base_url(), true);
    }

}