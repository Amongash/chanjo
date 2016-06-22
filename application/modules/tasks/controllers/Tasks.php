<?php

class Tasks extends MY_Controller {

    function __construct() {
        parent::__construct();
        Modules::run('secure_tings/is_logged_in');
        $this->load->model('mdl_tasks');

    }



    function index() {

        $info['user_object'] = $this->get_user_object();
        $station = $info['user_object']['user_statiton'];
        $tasks = $this->mdl_tasks->get_new_task($station);

        $data['tasks'] = '';
        
        if (count($tasks) == 0) {
           
            $this->load->view('view_empty_taskbar');
        } else {
            $data['tasks'] = $tasks;
            $this->load->view('view_taskbar',$data);
        }

    }

    function get_count(){
        $info['user_object'] = $this->get_user_object();
        $station = $info['user_object']['user_statiton'];
        $tasks = $this->mdl_tasks->get_new_task($station);

        if (count($tasks) == 0) {
           
            echo count($tasks);
        } else {
           echo count($tasks);
        }

    }

    function all(){

        
        $data['module'] = "tasks";
        $data['view_file'] = "view_all_tasks";
        $data['section'] = "Tasks";
        $data['subtitle'] = "To Do";
        
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Tasks', '', 0);
        $this->make_bread->add('To Do', 'tasks/view_all', 1);

        $data['breadcrumb'] = $this->make_bread->output();
        
        

        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);
 
    }

    function to_do() {

        $info['user_object'] = $this->get_user_object();
        $station = $info['user_object']['user_statiton'];
        $tasks = $this->mdl_tasks->get_new_task($station);

        $data['tasks'] = '';
        
        if (count($tasks) == 0) {
           
            $this->load->view('view_completed');
        } else {
            $data['tasks'] = $tasks;
            $this->load->view('view_pending',$data);
        }

    }


}