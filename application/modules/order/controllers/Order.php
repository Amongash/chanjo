<?php

class Order extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

    }

    function get($order_by)
    {
        Modules::run('secure_tings/is_logged_in');
        $this->load->model('mdl_vaccines');
        $query = $this->mdl_vaccines->get($order_by);
        return $query;
    }

// Get information on the selected vaccines from orders
    public function get_order_values()
    {
        Modules::run('secure_tings/is_logged_in');
        $data2['user_object2'] = $this->get_user_object();
        $station = $data2['user_object2']['user_level'];
        $data3['user_object3'] = $this->get_user_object();
        $station_id = $data3['user_object3']['user_statiton'];
        $selected_vaccine = $this->input->post('selected_vaccine');
        $this->load->model('mdl_order');
        $data = $this->mdl_order->get_order_values($station, $selected_vaccine, $station_id);
        echo json_encode($data);
    }

// Function to create order. Fetches the list of vaccines and calculations of max stock, minstock
    public function create_order()
    {
        Modules::run('secure_tings/is_logged_in');
        $this->load->model('vaccines/mdl_vaccines');
        $this->load->model('order/mdl_order');
        $data['vaccines'] = $this->mdl_vaccines->getVaccine();
        $info['user_object'] = $this->get_user_object();
        $station_level = $info['user_object']['user_level'];
        $station_id = $info['user_object']['user_statiton'];
        $data['section'] = "Vaccines";
        $data['subtitle'] = "Request Stock";
        $data['page_title'] = "Manage Stock";
        $data['module'] = "order";
        $data['view_file'] = "create_request";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Manage Stock', '', 0);
        $this->make_bread->add('Request Stocks', 'order/list_orders', 0);
        $this->make_bread->add('Create Request', '', 0);

        $data['breadcrumb'] = $this->make_bread->output();
        //
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);

    }

// Function lists the orders placed or submitted
    public function list_orders()
    {
        Modules::run('secure_tings/is_logged_in');
        $data['user_object'] = $this->get_user_object();
        $station = $data['user_object']['user_statiton'];
        $level = $data['user_object']['user_level'];
        $this->load->model('order/mdl_order');
        $this->load->library('pagination');
        $this->load->library('table');
        $config['base_url'] = base_url().'/order/list_orders';
        $config['total_rows'] =$this->mdl_order->count_placed_orders($station, $level);
        $config['per_page'] = 10;
        $config['num_links'] = 4;
        $config["uri_segment"] = 3;
        $config['full_tag_open'] = '<div><ul class="pagination pagination-small pagination-centered">';
        $config['full_tag_close'] = '</ul></div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['orders'] = $this->mdl_order->get_placed_orders($station, $level);
        
        $data['all_orders'] = $this->mdl_order->get_all_placed_orders($station, $level);
        $this->pagination->initialize($config);
    

        $data['submitted_orders'] = $this->mdl_order->get_submitted_orders($station, $level);
        $data['section'] = "Manage Stock";
        $data['subtitle'] = "Request Stocks";
        $data['page_title'] = "Request Stocks";
        $data['module'] = "order";
        if ($level == '1') {
            $data['view_file'] = "adm_list_order_view";
        } else {
            $data['view_file'] = "list_order_view";
        }
        $data['main_title'] = $this->get_title();

        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Manage Stock', '', 0);
        $this->make_bread->add('Request Stocks', '', 0);

        $data['breadcrumb'] = $this->make_bread->output();
        //
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);


    }
// The function accepts two arguments, order_by and date when order was created,
//  to list the order items on viewing an order
    public function view_orders($order_by, $date_created, $option, $order_id, $status_name)
    {
        Modules::run('secure_tings/is_logged_in');
        $this->load->model('order/mdl_order');
        $data['section'] = "Manage Stock";
        $data['subtitle'] = "View Request";
        $data['page_title'] = " Orders";
        $data['orderitems'] = $this->mdl_order->get_order_items($order_id, $order_by, $date_created);
        $data['option'] = $option;
        $data['status_name'] = $status_name;
        $data['order_id'] = $order_id;
        $data['module'] = "order";
        $data['view_file'] = "order_view";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Manage Stock', '', 0);
        $this->make_bread->add('Request Stocks', 'order/list_orders', 0);
        $this->make_bread->add('View Request', '', 0);

        $data['breadcrumb'] = $this->make_bread->output();
        // $this->output->enable_profiler();
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);

    }

    public function prepare_orders($content_array = array())
    {
        Modules::run('secure_tings/is_logged_in');

        $this->load->model('vaccines/mdl_vaccines');
        $data['vaccines'] = $this->mdl_vaccines->getVaccine();

        if (!empty($content_array)) {
            $orderitems = $content_array;
            $data['orderitems'] = $orderitems['orderitems'];
        }
        $data['section'] = "Manage Stock";
        $data['subtitle'] = "Requests";
        $data['page_title'] = " Requests";
        $data['module'] = "order";
        $data['options'] = "view";
        $data['view_file'] = "create_order_form";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);
    }
// Function to save the orders. Order items are posted to this function,
// where they are stored in an array to be stored in the database
    
    function save_forwarded_order($order_id)
    {
        Modules::run('secure_tings/is_logged_in');
        $this->load->model('order/mdl_order');
        $data['user_object'] = $this->get_user_object();
        $statiton_above = $data['user_object']['statiton_above'];
        $level = $data['user_object']['user_level'];
        $station_level = $level++;
        $this->mdl_order->forward_orders($station_level, $order_id);
        $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">Order forwarded successfully to <strong>' . $statiton_above . '</strong>!</div>');

        redirect('order/list_orders');
    }

    function populate_request(){
    	$vaccine_id = NULL;
    	if(is_null($vaccine_id)){
    		$vaccine_id = $this->input->post('selected_vaccine');
    		if(is_numeric($vaccine_id)){
	    		$this->load->model('order/mdl_order');
		    	$info['user_object'] = $this->get_user_object();
		    	$station = $info['user_object']['user_statiton'];
		        $level = $info['user_object']['user_level'];
		    	$query = $this->mdl_order->calculate_request($station,$level,$vaccine_id);
		    	echo json_encode($query);
		    }
    	}else{
    		echo json_encode(0);
    	}	
    }

    function save_request(){
    	Modules::run('secure_tings/is_logged_in');
        $info['user_object'] = $this->get_user_object();

       	
        $transaction_date = $this->input->post('transaction_date');
        $to_from = $this->input->post('to_from');
        
        $user_id  = $info['user_object']['user_id'];
        $station = $info['user_object']['user_statiton'];
        $level = $info['user_object']['user_level'];
       
        $request_array['user_id'] = $user_id;
        $request_array['transaction_date'] = $transaction_date;
        $request_array['timestamp'] = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
        $request_array['to_from'] = $to_from;
        $request_array['station'] = $station;
        $request_array['level'] = $level;

        $this->db->insert('tbl_request', $request_array);
        $request_id = $this->db->insert_id();

        $batch = stripcslashes($_POST['batch']);
        $batch = json_decode($batch, TRUE);

        $request_array = array();
        $request_counter = 0;

        foreach ($batch as $item) {
            $request_array[$request_counter]['vaccine_id'] = $item['vaccine_id'];
            $request_array[$request_counter]['transaction_quantity'] = $item['quantity'];
            $request_array[$request_counter]['current_quantity'] = $item['current'];
            $request_array[$request_counter]['max_quantity'] = $item['max_stock'];
            $request_array[$request_counter]['min_quantity'] = $item['min_stock'];
            $request_array[$request_counter]['expiry_date'] = $item['expiry'];
          
            $request_array[$request_counter]['request_id'] = $request_id[$request_counter];

            $request_counter++;
        }

        $main_array['requests'] = $request_array;
        // Add assigned issue id to issue items
        foreach ($main_array as $key => $value) {
            foreach ($value as $keyvac => $valuevac) {
                foreach ($valuevac as $keys => $values) {
                    if ($keys == "request_id") {
                       $temp[$keyvac]['request_id'] = $request_id;
                    } else {
                        $temp[$keyvac][$keys] = $values;
                    }


                }

            }
             

            $this->db->insert_batch('tbl_request_items', $temp);
           
        }
        $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">Request submitted Successfully</div>');

    }


    function get_with_limit($limit, $offset, $order_by)
    {
        $this->load->model('mdl_vaccines');
        $query = $this->mdl_vaccines->get_with_limit($limit, $offset, $order_by);
        return $query;
    }

    function get_where($id)
    {
        $this->load->model('mdl_vaccines');
        $query = $this->mdl_vaccines->get_where($id);
        return $query;
    }

    function get_where_custom($col, $value)
    {
        $this->load->model('mdl_vaccines');
        $query = $this->mdl_vaccines->get_where_custom($col, $value);
        return $query;
    }

    function _insert($data)
    {
        $this->load->model('mdl_vaccines');
        $this->mdl_vaccines->_insert($data);
    }

    function _update($id, $data)
    {
        $this->load->model('mdl_vaccines');
        $this->mdl_vaccines->_update($id, $data);
    }

    function _delete($id)
    {
        $this->load->model('mdl_vaccines');
        $this->mdl_vaccines->_delete($id);
    }

    function count_where($column, $value)
    {
        $this->load->model('mdl_vaccines');
        $count = $this->mdl_vaccines->count_where($column, $value);
        return $count;
    }

    function get_max()
    {
        $this->load->model('mdl_vaccines');
        $max_id = $this->mdl_vaccines->get_max();
        return $max_id;
    }

    function _custom_query($mysql_query)
    {
        $this->load->model('mdl_vaccines');
        $query = $this->mdl_vaccines->_custom_query($mysql_query);
        return $query;
    }

}