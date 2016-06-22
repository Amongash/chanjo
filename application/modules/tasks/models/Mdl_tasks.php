<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Mdl_tasks extends CI_Model {

	function __construct() {
        parent::__construct();
    }


    function get_new_task($station) {
        $this->db->where('station', $station);
        $this->db->where('read', '0');
        $query = $this->db->get('tbl_tasks');
        return $query->result();
    }


    function fetchtask($sation, $recipient) {
        $this->db->order_by('time', 'desc');
        $this->db->where('username', $username);
        $this->db->where('recipient', $recipient);
        $this->db->or_where('username', $recipient);
        $this->db->where('recipient', $username);
        $query = $this->db->get('tbl_chat', 7);
        return $query->result();
    }


    function task_read($data) {
        $this->db->where('recipient', $data['username']);
        $this->db->where('username', $data['recipient']);
        $read = array(
            'read' => 1
        );
        $this->db->update('tbl_chat', $read);
    }

}    


