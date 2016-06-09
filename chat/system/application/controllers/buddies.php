<?php

class Buddies extends Controller {

    function Buddies() {
        parent::Controller();
        $this->load->database();
        $this->load->model('mod_buddies');
        $this->load->library(array('session', 'authentication'));
    }

    function index() {
        //outsiders keep out
        $this->authentication->sentry();
        //get online users
        $buddies = $this->mod_buddies->check_buddies($this->session->userdata('username'));
        $data['buddies'] = '';
        $ctr = 0;
        $offline = '';
        if (count($buddies) > 0) {
            foreach ($buddies as $rows) {
                //get timestamp 2 hours ago
                $previous_time = time() - 7200;
                $session_id = $rows->session_id;
                //let's check again who really are online
                $online_buddies = $this->mod_buddies->check_active_buddies($session_id, $previous_time);
                if (count($online_buddies) > 0) {
                    //check db if new message is found for particular buddy
                    $new_message = $this->mod_buddies->alert_new_message($this->session->userdata('username'), $rows->username);
                    $data['new_message'][$ctr] = $new_message;
                    $data['buddies'][$ctr] = $rows->username;
                    ++$ctr;
                }
            }
            if ($ctr == 0) {
                $offline = 'No contacts found.';
            }
        } else {
            $offline = 'No contacts found.';
        }
        echo $offline;
        $this->load->view('view_buddies', $data);
    }

}