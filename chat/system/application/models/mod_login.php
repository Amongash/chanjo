<?php

class Mod_login extends Model {

    function Mod_login() {
        parent::Model();
        //load database class
    }

    /**
     * authenticate method
     *
     * pass username and password entered for authentication
     *
     * @param string $username
     * @param string $password
     * @return object
     */
    function authenticate($username, $password) {
        //get record and salted password
        $query = $this->db->get_where(
                        'users', array(
                    'username' => $username,
                    'password' => sha1($password . $username)));
        return $query->result();
    }

    /**
     * store_session
     *
     * store generated session to user's table
     *
     * @param string $username
     * @param string $session_id
     */
    function store_session($username, $session_id) {
        $data = array(
            'session_id' => $session_id
        );
        $this->db->where('username', $username);
        $this->db->update('users', $data);
    }

    /**
     * check_session
     *
     * compare the session_id and username from users
     *
     * @param <type> $session_id
     * @param <type> $username
     */
    function check_session($session_id, $username) {
        $query = $this->db->get_where(
                        'users', array(
                    'session_id' => $session_id,
                    'username' => $username));
        return $query->result();
    }

}