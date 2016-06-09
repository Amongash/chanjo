<?php

class Chat extends Controller {
    function Chat() {
        parent::Controller();
        $this->load->database();
        $this->load->model('mod_chat');
        $this->load->library(array('session', 'authentication'));

    }

    function index() {
        //outsiders keep out
        $this->authentication->sentry();
        $ctr = 0;
        //get all chat messages from buddy
        $username = $this->session->userdata('username');
        $recipient = $this->session->userdata('recipient');
        $fetchchat = $this->mod_chat->fetchchat($username, $recipient);
        $chatreverse = '';
        //reverse results of chat, bottom message is latest
        foreach ($fetchchat as $chatorig) {
            $chatreverse[$ctr]['username'] = $chatorig->username;
            $chatreverse[$ctr]['message'] = $chatorig->message;
            $time = explode(' ', $chatorig->time);
            $reformat_time = date("g:i a", strtotime($time[1]));
            $chatreverse[$ctr]['time'] = $reformat_time;
            ++$ctr;
        }
        $data['chat'] = '';
        $data['buddy'] = $this->session->userdata('recipient');
        $buddyimage = $this->mod_chat->get_buddy_image($this->session->userdata('recipient'));
        $data['buddyimage'] = $buddyimage[0]->image;
        //throw messages to view
        if (is_array($chatreverse)) {
            $users['username'] = $username;
            $users['recipient'] = $recipient;
            $this->mod_chat->message_read($users);
            $data['chat'] = array_reverse($chatreverse);
        }
        $this->load->view('view_chat', $data);
    }

    /*
     * get_new_messages
     *
     * show notification if buddy have new messages for you
     */

    function get_new_messages() {
        //outsiders keep out
        $this->authentication->sentry();
        //get unread messages
        $result = $this->mod_chat->get_new_messages($this->session->userdata('username'));
        $ctr = 0;
        $users = array();
        foreach ($result as $online) {
            $users[$ctr] = $online->username;
            ++$ctr;
        }
        //filter dupes
        $users = array_values(array_unique($users));
        $ctr = 0;
        foreach ($users as $online_users) {
            //session check, indicate new message only if sender is online
            $check_if_online = $this->mod_chat->check_if_online($online_users);
            if (count($check_if_online) > 0) {
                ++$ctr;
            }
        }

        if ($ctr > 0) {
            //show image indicator for new message
            $this->load->view('view_new_message');
        } else {
            //no new messages found
            $this->load->view('view_no_message');
        }
    }

    /*
     * sendmessage
     *
     * sends a message to your buddy
     */

    function sendmessage() {
        //outsiders keep out
        $this->authentication->sentry();
        $data['username'] = $this->session->userdata('username');
        $data['recipient'] = $this->session->userdata('recipient');
        $data['message'] = $this->input->post('message');
        $this->mod_chat->sendmessage($data);
    }

    /*
     * chatbuddy
     *
     * store chatmate to session and mark all messages to buddy as read
     */

    function chatbuddy() {
        //outsiders keep out
        $this->authentication->sentry();
        $this->session->set_userdata('recipient', $this->input->post('username'));
        $data['username'] = $this->session->userdata('username');
        $data['recipient'] = $this->session->userdata('recipient');
        $this->mod_chat->message_read($data);
    }
/*
 * close_buddy
 *
 * ends chat session with a buddy
 */
    function close_buddy() {
        //outsiders keep out
        $this->authentication->sentry();
        $this->session->unset_userdata('recipient');
    }

}