<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template extends MX_Controller {


    function home($data) {

        $this->load->view('home_view', $data);
    }

    function admin($data) {

        $this->load->view('admin_view', $data);
    }

    function ps($data) {
        
        $this->load->view('ps_view', $data);
    }

    function epi($data) {
        
        $this->load->view('epi_view', $data);
    }

    function met($data) {
        
        $this->load->view('met_view', $data);
    }

    function phn($data) {
        
        $this->load->view('phn_view', $data);
    }

    function hrio($data) {
        
        $this->load->view('hrio_view', $data);
    }

    function member($data) {
        
        $this->load->view('member_view', $data);
    }

    function moh($data) {
        
        $this->load->view('moh_view', $data);
    }
}