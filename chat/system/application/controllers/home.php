<?php

class Home extends Controller {

    function Home() {
        parent::Controller();
        $this->load->library('authentication');
    }

    function index() {
        //outsiders keep out
        $this->authentication->sentry();
        $this->load->view('view_home.php');
    }

}