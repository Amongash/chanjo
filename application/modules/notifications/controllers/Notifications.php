<?php
class Notifications extends MY_Controller 
{

function __construct() {
parent::__construct();


}
function get_notification_count(){
   
    $data['user_object'] = $this->get_user_object();
    $station_id = $data['user_object']['user_statiton'];
    $this->load->model('notifications/mdl_notifications');
    $result = $this->mdl_notifications->get_notification_count();
    if(empty($result)){
        echo 0;
    }else {
       echo $result;
         
    }

  }



  function task_count(){
   
    $data['user_object'] = $this->get_user_object();
    $station_id = $data['user_object']['user_statiton'];
    $this->load->model('notifications/mdl_notifications');
    $query = $this->mdl_notifications->get_task();
    if(!empty($query)){
        foreach ($query as $val) {
                          
            $html = '
                      
                      <li><a href="#" class="task">
                        <div class="green_status task_height" style="width:100%;"></div>
                        <div class="task_head"><span class="pull-left">Task 1</span> <span class="pull-right green_label"></span></div>
                        <div class="task_detail">Task '.$val->status.'</div>
                      </a></li>';
            echo($html);
        }
       
    }else {
       //echo $result;
         
    }

  }

}

