<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Mdl_contacts extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * check_buddies
     *
     * check if the user has a session hanging in the system(logged in)
     *
     * @param string $username
     * @return object
     */

    function check_buddies($username) {

        $this->db->order_by('username');
        $this->db->where('session_id !=', '');
        $this->db->where('username !=', $username);
        $query = $this->db->get('tbl_users');
        return $query->result();
    }

    /*
     * check_active_buddies
     *
     * check who really are online, disregard inactive users for the past
     * no. of hours as defined in previous_time
     *
     * @param string $session_id
     * @param timestamp $previous_time
     * @return object
     */

    function check_active_buddies($session_id, $previous_time) {
        $this->db->where('session_id', $session_id);
        $this->db->where('last_activity >', $previous_time);
        $query = $this->db->get('tbl_users');
        return $query->result();
    }

    /*
     * alert_new_message
     *
     * show icon if new message is found from buddy list
     *
     * @param string $username
     * @param string $sender
     * @return object
     */

    function alert_new_message($username, $sender) {
        $this->db->where('username', $sender);
        $this->db->where('recipient', $username);
        $this->db->where('read', '0');
        $this->db->from('tbl_chat');
        $count = $this->db->count_all_results();
        return $count;
    }

    
}