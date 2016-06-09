<?php

class Main extends Controller {

    function Main() {
        parent::Controller();
    }

    function index() {
        $this->load->view('view_main.php');
    }

}