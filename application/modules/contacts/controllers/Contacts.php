<?php 
class Contacts extends MY_Controller {

    function __construct() {
        parent::__construct();

    }

 	function index() {
         $this->load->model('mdl_contacts');
        //get online users
        $buddies = $this->mdl_contacts->check_buddies($this->session->userdata('username'));

        $data['buddies'] = '';
        $ctr = 0;
        $offline = '';
        if (count($buddies) > 0) {
            foreach ($buddies as $rows) {
                //get timestamp 2 hours ago
                $previous_time = time() - 7200;
                $session_id = $rows->session_id;
                //let's check again who really are online
                $online_buddies = $this->mdl_contacts->check_active_buddies($session_id, $previous_time);
                if (count($online_buddies) > 0) {
                    //check db if new message is found for particular buddy
                    $new_message = $this->mdl_contacts->alert_new_message($this->session->userdata('username'), $rows->username);
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