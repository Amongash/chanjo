<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authentication{

    /**
     * sentry
     *
     * allows/disallows users from a certain page
     * management of user sessions
     */
    function sentry() {
        //new CI instance
        $CI =& get_instance();
        //disable caching
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        $CI->load->helper('url');
        $CI->load->library('session');
        $CI->load->model('mod_login');
        //get session data on db
        $result = $CI->mod_login->check_session(
                        $CI->session->userdata('session_id'),
                        $CI->session->userdata('username')
        );
        //don't do anything if record is found
        if (count($result) > 0) {
            
        } else {
            //logout expired session/intruders
            $CI->session->sess_destroy();
            header('Location:' . base_url() . 'index.php');
        }
    }
}

?>