<?php

class Mod_chat extends Model {

    function Mod_chat() {
        parent::Model();
    }

    /*
     * get_new_messages
     *
     * get all new messages sent from your buddies
     *
     * @param string $recipient
     * @return object
     */

    function get_new_messages($recipient) {
        $this->db->where('recipient', $recipient);
        $this->db->where('read', '0');
        $query = $this->db->get('chat');
        return $query->result();
    }

    /*
     * fetchchat
     *
     * fetch all conversations from a buddy
     *
     * @param string $username
     * @param string $recipient
     * @return object
     */

    function fetchchat($username, $recipient) {
        $this->db->order_by('time', 'desc');
        $this->db->where('username', $username);
        $this->db->where('recipient', $recipient);
        $this->db->or_where('username', $recipient);
        $this->db->where('recipient', $username);
        $query = $this->db->get('chat', 7);
        return $query->result();
    }

    /*
     * sendmessage
     *
     * insert sent message to db
     *
     * @param array $data
     */

    function sendmessage($data) {
        $chat = array(
            'username' => $data['username'],
            'recipient' => $data['recipient'],
            'message' => $data['message']
        );
        $this->db->insert('chat', $chat);
    }

    /*
     * message_read
     *
     * update received message as read
     *
     * @param array $data
     */

    function message_read($data) {
        $this->db->where('recipient', $data['username']);
        $this->db->where('username', $data['recipient']);
        $read = array(
            'read' => 1
        );
        $this->db->update('chat', $read);
    }

    /*
     * check_if_online
     *
     * check users who are online in db session
     *
     * @param string $username
     * @return object
     */

    function check_if_online($username) {
        $this->db->like('user_data', '"' . $username . '"');
        $query = $this->db->get('ci_sessions');
        return $query->result();
    }

    /**
     * get_buddy_image
     * 
     * get his picture
     *
     * @param string $username
     * @return object
     */
    
    function get_buddy_image($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->result();
    }

}