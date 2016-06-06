<?php

/**
 *
 */
class Stock extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }


    function receive_stock()
    {
        Modules::run('secure_tings/is_logged_in');
        $this->load->model('vaccines/mdl_vaccines');
        $data['vaccines'] = $this->mdl_vaccines->getVaccine();
        $this->load->model('stock/mdl_vvmstatus');
        $data['vvm_status'] = $this->mdl_vvmstatus->get_vvm();
        $this->load->model('stock/mdl_stock');
        $info['user_object'] = $this->get_user_object();
        $user_level = $info['user_object']['user_level'];
        $user_id = $this->session->userdata['logged_in']['user_id'];
        $info['user_object'] = $this->get_user_object();
        $station_id = $info['user_object']['statiton_above'];
        if ($user_level == 1) {
            /*
            user_level = national
            retrieve all regions
            */
            $data['location'] = "National Arrival";
        } else {
            $data['location'] = $station_id;
        }
        $data['module'] = "stock";
        $data['view_file'] = "receive_stock";
        $data['section'] = "manage stock";
        $data['subtitle'] = "Receive Stock";
        $data['page_title'] = "Receive Stock";
        $data['orders'] = $this->get_orders();
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Manage Stock', '', 0);
        $this->make_bread->add('Receive Stocks', 'stock/list_receive_stock', 0);
        $this->make_bread->add('Receive Stocks Directly', '', 0);
        $data['breadcrumb'] = $this->make_bread->output();
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);
    }

    public function list_issue_stock()
    {
        Modules::run('secure_tings/is_logged_in');
        $this->load->model('order/mdl_order');
        $this->load->model('vaccines/mdl_vaccines');
        $this->load->model('stock/mdl_stock');
        $this->load->library('pagination');
        $this->load->library('table');
        $data['vaccines'] = $this->mdl_vaccines->getVaccine();
        $info['user_object'] = $this->get_user_object();
        $level = $info['user_object']['user_level'];
        $station = $info['user_object']['user_statiton'];
        
        $config['base_url'] = base_url().'/stock/list_issue_stock';
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
        
        $data['orders'] = $this->mdl_order->get_placed_orders($station,$level);
        
        $data['all_orders'] = $this->mdl_order->get_all_placed_orders($station,$level);
        $this->pagination->initialize($config);

        $data['submitted_orders'] = $this->mdl_order->get_submitted_orders($station,$level);
        $data['section'] = "Manage Stock";
        $data['subtitle'] = "Issue Stocks";
        $data['page_title'] = "Issue Stocks";
        $data['module'] = "stock";
        $info['user_object'] = $this->get_user_object();
        $user_level = $info['user_object']['user_level'];
        $user_id = $this->session->userdata['logged_in']['user_id'];
        if ($user_level == 1) {
            /*
            user_level = national
            retrieve all regions
            */
            $data['locations'] = $this->mdl_stock->get_region_base();
        } elseif ($user_level == 2) {
            /*
            user_level = regional
            retrieve all counties
            */
            $data['locations'] = $this->mdl_stock->get_county_base($user_id);
        } elseif ($user_level == 3) {
            /*
            user_level = county
            retrieve all subcounties
            */
            $data['locations'] = $this->mdl_stock->get_subcounty_base($user_id);
        } elseif ($user_level == 4) {
            /*
            user_level = subounty
            retrieve all facilities
            */
            $data['locations'] = $this->mdl_stock->get_facility_base($user_id);
        }
        if ($station == '1') {
            $data['view_file'] = "list_issue_stock";
        } else {
            $data['view_file'] = "list_issue_stock";
        }
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Manage Stock', '', 0);
        $this->make_bread->add('Issue Stocks', '', 0);
        $data['breadcrumb'] = $this->make_bread->output();
        //

        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);


    }

    public function list_receive_stock()
    {
        Modules::run('secure_tings/is_logged_in');
        $this->load->model('order/mdl_order');
        $this->load->model('vaccines/mdl_vaccines');
        $this->load->library('pagination');
        $this->load->library('table');
        $data['user_object'] = $this->get_user_object();
        $station = $data['user_object']['user_statiton'];
        $level = $data['user_object']['user_level'];
        
        $station_above = $data['user_object']['statiton_above'];
        if ($level == 1) {
            /*
            user_level = national
            retrieve all regions
            */
            $data['location'] = "National Arrival";
        } else {
            $data['location'] = $station_above;
        }
        $data['vaccines'] = $this->mdl_vaccines->getVaccine();
        
        $config['base_url'] = base_url().'/stock/list_receive_stock';
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
        
        $data['orders'] =  $this->mdl_order->get_placed_orders($station, $level);
        
        $data['all_orders'] = $this->mdl_order->get_all_placed_orders($station, $level);
        $this->pagination->initialize($config);

        $data['submitted_orders'] = $this->mdl_order->get_submitted_orders($station, $level);
        $data['section'] = "Manage Stock";
        $data['subtitle'] = "Receive Stocks";
        $data['page_title'] = "Receive Stocks";
        $data['module'] = "stock";
        if ($level == '1') {
            $data['view_file'] = "receive_stock";
        } else {
            $data['view_file'] = "list_receive_stock";
        }
        $data['main_title'] = $this->get_title();
        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Manage Stock', '', 0);
        $this->make_bread->add('Receive Stocks', '', 0);
        $data['breadcrumb'] = $this->make_bread->output();
        //
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);


    }

    function save_received_stock()
    {
        Modules::run('secure_tings/is_logged_in');
        $data2['user_object2'] = $this->get_user_object();
        $data3['user_object3'] = $this->get_user_object();
        $data4['user_object4'] = $this->get_user_object();
        $station_level = $data2['user_object2']['user_level'];
        $station_id = $data3['user_object3']['user_statiton'];
        $operator_id = $data4['user_object4']['user_id'];

        $data = array(
            'transaction_type' => $this->input->post('transaction_type'),
            'transaction_date' => $this->input->post('date_received'),
            'destination' => $station_id,
            'source' => $this->input->post('received_from'),
            'vaccine_id' => $this->input->post('vaccine'),
            's11' => $this->input->post('s11'),
            'batch_number' => strtoupper($this->input->post('batch_no')),
            'expiry_date' => $this->input->post('expiry_date'),
            'quantity_in' => $this->input->post('quantity_received'),
            'VVM_status' => $this->input->post('vvm_status'),
            'user_id' => $operator_id,
            'station_level' => $station_level,
            'station_id' => $station_id
        );
        // echo json_encode($data);
        $this->db->insert('m_receive_stock', $data);
        $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">Stock successfully received from <strong>' . $data['source'] . '</strong>!</div>');
    }

    function issue_stock()
    {
        Modules::run('secure_tings/is_logged_in');
        $this->load->model('vaccines/mdl_vaccines');
        $this->load->model('stock/mdl_stock');
        $this->load->model('stock/mdl_vvmstatus');
        // $data['vvm'] = $this->mdl_vvmstatus->get_vvm();
        $data['vaccines'] = $this->mdl_vaccines->getVaccine();
        $info['user_object'] = $this->get_user_object();
        $user_level = $info['user_object']['user_level'];
        $user_id = $this->session->userdata['logged_in']['user_id'];
        if ($user_level == 1) {
            /* 
            user_level = national
            retrieve all regions 
            */
            $data['locations'] = $this->mdl_stock->get_region_base();
        } elseif ($user_level == 2) {
            /* 
            user_level = regional
            retrieve all counties 
            */
            $data['locations'] = $this->mdl_stock->get_subcounty($user_id);
        } elseif ($user_level == 3) {
            /* 
            user_level = county
            retrieve all subcounties 
            */
            $data['locations'] = $this->mdl_stock->get_subcounty_base($user_id);
        } elseif ($user_level == 4) {
            /* 
            user_level = subounty
            retrieve all facilities 
            */
            $data['locations'] = $this->mdl_stock->get_facility_base($user_id);
        }
        $data['module'] = "stock";
        $data['view_file'] = "issue_stock";
        $data['section'] = "manage stock";
        $data['subtitle'] = "Issue Stock";
        $data['orders'] = $this->get_orders();
        $data['page_title'] = "Issue Stock";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Manage Stock', '', 0);
        $this->make_bread->add('Issue Stocks', 'stock/list_issue_stock', 0);
        $this->make_bread->add('Issue Stocks Directly', '', 0);
        $data['breadcrumb'] = $this->make_bread->output();
//        $this->output->enable_profiler(TRUE);
        //
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);

    }

    function issue_many()
    {
        Modules::run('secure_tings/is_logged_in');
        $this->load->model('vaccines/mdl_vaccines');
        $this->load->model('stock/mdl_stock');
        $this->load->model('stock/mdl_vvmstatus');
        // $data['vvm'] = $this->mdl_vvmstatus->get_vvm();
        $data['vaccines'] = $this->mdl_vaccines->getVaccine();
        $info['user_object'] = $this->get_user_object();
        $user_level = $info['user_object']['user_level'];
        $user_id = $this->session->userdata['logged_in']['user_id'];
        if ($user_level == 1) {
            /* 
            user_level = national
            retrieve all regions 
            */
            $data['locations'] = $this->mdl_stock->get_region_base();
        } elseif ($user_level == 2) {
            /* 
            user_level = regional
            retrieve all counties 
            */
            $data['locations'] = $this->mdl_stock->get_subcounty($user_id);
        } elseif ($user_level == 3) {
            /* 
            user_level = county
            retrieve all subcounties 
            */
            $data['locations'] = $this->mdl_stock->get_subcounty_base($user_id);
        } elseif ($user_level == 4) {
            /* 
            user_level = subounty
            retrieve all facilities 
            */
            $data['locations'] = $this->mdl_stock->get_facility_base($user_id);
        }
        $data['module'] = "stock";
        $data['view_file'] = "issue_many";
        $data['section'] = "manage stock";
        $data['subtitle'] = "Issue Stock";
        $data['orders'] = $this->get_orders();
        $data['page_title'] = "Issue Stock";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Manage Stock', '', 0);
        $this->make_bread->add('Issue Stocks', 'stock/list_issue_stock', 0);
        $this->make_bread->add('Issue Stocks Directly', '', 0);
        $data['breadcrumb'] = $this->make_bread->output();
//        $this->output->enable_profiler(TRUE);
        //
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);

    }

    function list_inventory()
    {
        Modules::run('secure_tings/is_logged_in');
        $this->load->model('vaccines/mdl_vaccines');
        $data['vaccines'] = $this->mdl_vaccines->get_vaccine_details();
        $data['module'] = "stock";
        $data['view_file'] = "inventory";
        $data['section'] = "manage stock";
        $data['subtitle'] = "Stocks Legder";
        $data['page_title'] = "Stocks Legder";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Manage Stock', '', 0);
        $this->make_bread->add('Stocks Ledger', '', 0);
        $data['breadcrumb'] = $this->make_bread->output();
        //$this->output->enable_profiler(TRUE);
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);

    }

    function get_vaccine_ledger($selected_vaccine)
    {
        // This function gets the ledger of the selected vaccine
        /*alert ($selected_vaccine); */
        Modules::run('secure_tings/is_logged_in');
        $id = $this->uri->segment(3);
        $data['id'] = $id;
        $this->load->model('vaccines/mdl_vaccines');
        $data['vaccine'] = $this->mdl_vaccines->get_where($selected_vaccine)->result_array();
        $data['module'] = "stock";
        $data['view_file'] = "vaccine_ledger";
        $data['section'] = "manage stock";
        $data['subtitle'] = $this->vaccine_name($selected_vaccine)." Stocks Ledger";
        // $data['page_title'] = "Stocks Ledger";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Manage Stock', '', 0);
        $this->make_bread->add('Stocks Ledger', 'stock/list_inventory', 1);

        $data['breadcrumb'] = $this->make_bread->output();
        //
         // $this->output->enable_profiler(TRUE);

        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);
        //echo Modules::run('template/admin', $data);

    }

    public function process($post, $id)
    {   
        // DataTables PHP library
        require $_SERVER['DOCUMENT_ROOT'].'/assets/plugins/datatables/Editor/php/DataTables.php';
        
        //Load the model which will give us our data
        $this->load->model('mdl_stock');
        $info['user_object'] = $this->get_user_object();
        $station = $info['user_object']['user_statiton'];
        
        //Pass the database object to the model
        $this->mdl_stock->init($db);
        
        //Let the model produce the data
        $this->mdl_stock->getData($post, $station, $id);
    }

    public function stock_data($id)
    {   
        if($id != false)
        {
            $this->process($_POST, $id);
        }
          return false;
        

    }

  //   function stock_data($id){
  //     	$this->load->model('reports/mdl_reports');
  //     	$info['user_object'] = $this->get_user_object();
  //       $station = $info['user_object']['user_statiton'];
		// $transaction = $this->mdl_reports->get_transactions($station,$id);
		// $data = array();
		// $no = $_POST['start'];
		// foreach ($transaction as $val) {
		//       $no++;
		//       $row = array();    
		//       $row[] = $val->transaction_date;
  //             $row[] = $val->type;
		//       $row[] = $val->to_from;
  //             $row[] = $val->quantity;
		     
		//       $row[] = $val->batch;
  //             $row[] = $val->expiry;
		      
		//       $row[] = $val->balance;

		//       $data[] = $row;
		// }

		// $output = array(
		//   "draw" => $_POST['draw'],
		//   "recordsTotal" => $this->mdl_reports->count_transactions_filtered($station,$id),
  //         "recordsFiltered" => $this->mdl_reports->count_transactions_filtered($station,$id),
		//   "data" => $data,
		// );

		// echo json_encode($output);
  //     }

    function get_stock_balance($selected_vaccine)
    {
        $data['user_object'] = $this->get_user_object();
        $station_id = $data['user_object']['user_statiton'];
        $this->load->model('stock/mdl_stock');
        if(!empty($selected_vaccine)){
            $query = $this->mdl_stock->get_stock_balance($selected_vaccine, $station_id);
            if(empty($query)){

                echo (0);
            }else {
                foreach ($query as $val) {
                    echo $val['stock_balance'];
                }
                 
            }
        }
        
        

    }

    function transfer_stock()
    {
        $data['module'] = "stock";
        $data['view_file'] = "transfer_stock";
        $data['section'] = "manage stock";
        $data['subtitle'] = "Transfer Stock";
        $data['page_title'] = "Transfer Stock";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);
        //echo Modules::run('template/admin', $data);
    }

    function get_batches()
    {
        Modules::run('secure_tings/is_logged_in');
        $data['user_object'] = $this->get_user_object();
        $station_id = $data['user_object']['user_statiton'];
        $selected_vaccine = $this->input->post('selected_vaccine');
        $this->load->model('stock/mdl_stock');
        $data = $this->mdl_stock->get_batches($selected_vaccine, $station_id);
        
        echo json_encode($data);

    }

    function get_batch_details()
    {
        // Gets moore details of the batch selected
        $data['user_object'] = $this->get_user_object();
        $station_id = $data['user_object']['user_statiton'];
        $selected_batch = $this->input->post('selected_batch');
        $this->load->model('stock/mdl_stock');
        $data = $this->mdl_stock->get_batch_details($selected_batch, $station_id);
        /* echo json_encode($selected_vaccine);*/
        echo json_encode($data);
    }

    function get_order_batch()
    {
        //Modules::run('secure_tings/is_logged_in');
        $info['user_object'] = $this->get_user_object();
        $station_id = $info['user_object']['user_statiton'];
        $this->load->model('mdl_stock');
        $order_id = $this->input->post('order_id');
        $selected_batch = $this->input->post('selected_batch');

        $data_array = array();
        if (!empty($selected_batch)){
            foreach ($selected_batch as $item) {
                $query = $this->mdl_stock->get_order_batch($order_id, $item['selected_batch'], $station_id);

                foreach ($query as $row) {
                    //var_dump($query);
                    $data['vaccine_id'] = $row['vaccine_id'];
                    $data['batch_no'] = $row['batch'];
                    // $data['expiry_date'] = $row->expiry_date;
                    // $data['vvm_status'] = $row->name;
                    $data_array['issue_row' . $row['vaccine_id']][] = $data;

                }

            }
            echo json_encode($data_array);
        } else{
            echo json_encode($data_array);
        }
         // $this->output->enable_profiler(TRUE);
    }


    function get_order_batch_details()
    {
        // Gets more details of the batch selected
        $data['user_object'] = $this->get_user_object();
        $station_id = $data['user_object']['user_statiton'];
        $order_id = $this->input->post('order_id');
        $selected_batch = $this->input->post('selected_batch');
        $this->load->model('stock/mdl_stock');
        $data = $this->mdl_stock->get_order_batch_details($selected_batch, $order_id, $station_id);
        echo json_encode($data);
    }

    function get_orders()
    {
        $data['user_object'] = $this->get_user_object();
        $station_id = $data['user_object']['user_statiton'];
        $this->load->model('stock/mdl_stock');
        $query = $this->mdl_stock->get_orders($station_id);
        return $query;
    }


    function count_all()
    {
        $this->load->model('stock/mdl_stock');
        $query = $this->mdl_stock->count_all();
        return $query;
    }

    function count_filtered($id, $user_id)
    {
        $this->load->model('stock/mdl_stock');
        $query = $this->mdl_stock->count_filtered($id, $user_id);
        return $query;
    }

    function physical_count()
    {
        Modules::run('secure_tings/is_logged_in');
        $this->load->model('vaccines/mdl_vaccines');
        $data['vaccines'] = $this->mdl_vaccines->getVaccine();
        $data['module'] = "stock";
        $data['view_file'] = "physical_stock";
        $data['section'] = "manage stock";
        $data['subtitle'] = "Stock Count";
        $data['page_title'] = "Stock Count";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();

        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Manage Stock', '', 0);
        $this->make_bread->add('Stock Count', '', 0);
        $data['breadcrumb'] = $this->make_bread->output();
        //
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);
    }

    function adjust_stock()
    {
        Modules::run('secure_tings/is_logged_in');
        $this->load->model('vaccines/mdl_vaccines');
        $data['vaccines'] = $this->mdl_vaccines->getVaccine();
        $data['module'] = "stock";
        $data['view_file'] = "adjust_stock";
        $data['section'] = "manage stock";
        $data['subtitle'] = "Stock Adjustment";
        $data['page_title'] = "Stock Adjustment";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();

        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Manage Stock', '', 0);
        $this->make_bread->add('Stock Adjustment', '', 0);
        $data['breadcrumb'] = $this->make_bread->output();
        //
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);
    }

    function save_adjust_stock()
    {
        Modules::run('secure_tings/is_logged_in');
        $info['user_object'] = $this->get_user_object();

        $adjustment = $this->input->post('adjustment');
        $user_id = $info['user_object']['user_id'];
        $level = $info['user_object']['user_level'];
        $station= $info['user_object']['user_statiton'];
        $type= 4;
        $batch = stripcslashes($_POST['batch']);
        $batch = json_decode($batch, TRUE);

        $array = array();
        $data_array = array();
        foreach ($batch as $item ) {
            $array['transaction_date'] = $item['date'];
            $array['type'] = $type;
            $array['timestamp'] = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
            $array['user_id'] = $user_id;
            $array['level'] = $level;
            $array['station'] = $station;
            

            $this->db->insert('tbl_transaction', $array);
            $request_id = $this->db->insert_id();
            
            $data_array['expiry_date'] = $item['expiry_date'];
            $data_array['vaccine_id'] = $item['vaccine_id'];
            $data_array['batch'] = $item['batch'];
            $data_array['vvm'] = filter_var($item['vvm'], FILTER_SANITIZE_NUMBER_INT);
            $data_array['current_quantity'] = $item['quantity'];
            $data_array['transaction_quantity'] = $item['change'];
            $data_array['transaction_id'] = $request_id;

            $this->db->insert('tbl_transaction_items', $data_array);
            
            }
            
            
        $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">Stock Adjustment updated successfully!</div>');
        redirect('stock/list_inventory', 'refresh');

    }

    function save_physical_count()
    {
        Modules::run('secure_tings/is_logged_in');
        $info['user_object'] = $this->get_user_object();


        $date_recorded = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
        $user_id = $info['user_object']['user_id'];
        $level = $info['user_object']['user_level'];
        $station= $info['user_object']['user_statiton'];
        $type = "3";

        $batch = stripcslashes($_POST['batch']);
        $batch = json_decode($batch, TRUE);

        $array = array();
        $data_array = array();
       
        foreach ($batch as $item) {

            $array['transaction_date'] = $item['date_of_count'];
            $array['type'] = $type;
            $array['timestamp'] = $date_recorded;
            $array['user_id'] = $user_id;
            $array['level'] = $level;
            $array['station'] = $station;

            $this->db->insert('tbl_transaction', $array);
            $request_id = $this->db->insert_id();
            
           
            $data_array['vaccine_id'] = $item['vaccine_id'];
            $data_array['batch'] = $item['batch_no'];
            $data_array['transaction_quantity'] = $item['physical_count'];
            $data_array['current_quantity'] = $item['available_quantity'];
            $data_array['expiry_date'] = $item['expiry_date'];
            $data_array['vvm'] = filter_var($item['vvm'], FILTER_SANITIZE_NUMBER_INT);
            $data_array['transaction_id'] = $request_id;

            $this->db->insert('tbl_transaction_items', $data_array);
            echo json_encode($data_array);
            }
            
        $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">Stock physical count updated successfully!</div>');
        redirect('stock/list_inventory', 'refresh');

    }

    function issue_stocks()
    {

        Modules::run('secure_tings/is_logged_in');
        $order_id = $this->uri->segment(3);
        $data['order_id'] = $order_id;
        $data2['user_object2'] = $this->get_user_object();
        $station_name = $data2['user_object2']['user_statiton'];
        $this->load->model('vaccines/mdl_vaccines');
        $data['vaccines'] = $this->mdl_vaccines->getVaccine();
        $this->load->model('mdl_stock');
        $data['issues'] = $this->mdl_stock->get_order_to_issue($order_id);
        $data['order_infor'] = $this->mdl_stock->get_order_infor($order_id);
        $data['module'] = "stock";
        $data['view_file'] = "new_issue_stock";
        $data['section'] = "manage stock";
        $data['subtitle'] = "Issue Stock";
        $data['page_title'] = "Issue Stock";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Issue Stocks', 'stock/list_issue_stock', 1);
        $this->make_bread->add('Issue', '', 0);


        $data['breadcrumb'] = $this->make_bread->output();
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);

    }

    function new_save_issued_stock()
    {
        //Modules::run('secure_tings/is_logged_in');
        //Issue Stock Information
        $data['user_object'] = $this->get_user_object();


        $order_id = $this->input->post('order');
        $S11 = $this->input->post('s11');
        $date_issued = $this->input->post('date_issued');
        $issued_to = $this->input->post('issued_to');
        $date_recorded = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
        $user_id = $data['user_object']['user_id'];
        $user_level = $data['user_object']['user_level'];
        $station_name = $data['user_object']['user_statiton'];
        $type = "2";
        $status = "issued";

        $issue_array['request_id'] = $order_id;
        $issue_array['transaction_voucher'] = $S11;
        $issue_array['transaction_date'] = $date_issued;
        $issue_array['to_from'] = $issued_to;
        $issue_array['type'] = $type;
        $issue_array['status'] = $status;
        $issue_array['timestamp'] = $date_recorded;
        $issue_array['user_id'] = $user_id;
        $issue_array['level'] = $user_level;
        $issue_array['station'] = $station_name;

        $this->db->insert('tbl_transaction', $issue_array);

        $issue_id = $this->db->insert_id();
        $this->db->query("call set_issued_status('$order_id')");

        // Issue Stock Item Information
        $vaccine = $this->input->post('vaccine');
        $batch_no = $this->input->post('batch_no');
        $expiry_date = $this->input->post('expiry_date');
        $amount_ordered = $this->input->post('amt_ordered');
        $stock_quantity = $this->input->post('available_quantity');
        $amount_issued = $this->input->post('amt_issued');
        $vvm_status = $this->input->post('vvm_status');
        $comment = $this->input->post('comment');

        $issue_array = array();
        $issue_counter = 0;

        foreach ($vaccine as $vaccines) {
            $issue_array[$issue_counter]['vaccine_id'] = $vaccine[$issue_counter];
            $issue_array[$issue_counter]['batch'] = $batch_no[$issue_counter];
            $issue_array[$issue_counter]['expiry_date'] = $expiry_date[$issue_counter];
            $issue_array[$issue_counter]['vvm'] = $vvm_status[$issue_counter];
            $issue_array[$issue_counter]['current_quantity'] = $stock_quantity[$issue_counter];
            $issue_array[$issue_counter]['transaction_quantity'] = $amount_issued[$issue_counter];
            $issue_array[$issue_counter]['comment'] = $comment[$issue_counter];
            $issue_array[$issue_counter]['transaction_id'] = $issue_id[$issue_counter];

            $issue_counter++;
        }

        $main_array['own_issues'] = $issue_array;
        // Add assigned issue id to issue items
        foreach ($main_array as $key => $value) {
            foreach ($value as $keyvac => $valuevac) {
                foreach ($valuevac as $keys => $values) {
                    if ($keys == "transaction_id") {
                        // $temp[$keyvac]['order_id'] = $order_id;
                        $temp[$keyvac]['transaction_id'] = $issue_id;
                    } else {
                        $temp[$keyvac][$keys] = $values;
                    }


                }

            }

        }
        echo json_encode($temp);

        $this->db->insert_batch('tbl_transaction_items', $temp);

        $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">Stocks have been issued successfully</div>');
        redirect('order/list_orders');
    }

    function save_issued_stock()
    {
        Modules::run('secure_tings/is_logged_in');
        $info['user_object'] = $this->get_user_object();


        $issued_to = $this->input->post('issued_to');
        $S11 = $this->input->post('s11');
        $date_issued = $this->input->post('date_issued');
        $date_recorded = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
        $user_id = $info['user_object']['user_id'];
        $level = $info['user_object']['user_level'];
        $station= $info['user_object']['user_statiton'];
        $type = "2";
        $status = "issued";

        $issue_array['transaction_date'] = $date_issued;
        $issue_array['transaction_voucher'] = $S11;
        $issue_array['to_from'] = $issued_to;
        $issue_array['type'] = $type;
        $issue_array['timestamp'] = $date_recorded;
        $issue_array['user_id'] = $user_id;
        $issue_array['level'] = $level;
        $issue_array['station'] = $station;

        $this->db->insert('tbl_transaction', $issue_array);

        $request_id = $this->db->insert_id();

        $batch = stripcslashes($_POST['batch']);
        $batch = json_decode($batch, TRUE);

        $issue_array = array();
        $issue_counter = 0;

        foreach ($batch as $item) {
            $issue_array[$issue_counter]['vaccine_id'] = $item['vaccine_id'];
            $issue_array[$issue_counter]['batch'] = $item['batch_no'];
            $issue_array[$issue_counter]['expiry_date'] = $item['expiry_date'];
            $issue_array[$issue_counter]['vvm'] = $item['vvm_status'];
            $issue_array[$issue_counter]['current_quantity'] = $item['quantity'];
            $issue_array[$issue_counter]['transaction_quantity'] = $item['amount_issued'];
            $issue_array[$issue_counter]['transaction_id'] = $request_id[$issue_counter];

            $issue_counter++;
        }

        $main_array['own_issues'] = $issue_array;
        // Add assigned issue id to issue items
        foreach ($main_array as $key => $value) {
            foreach ($value as $keyvac => $valuevac) {
                foreach ($valuevac as $keys => $values) {
                    if ($keys == "transaction_id") {
                       $temp[$keyvac]['transaction_id'] = $request_id;
                    } else {
                        $temp[$keyvac][$keys] = $values;
                    }


                }

            }
            // echo json_encode($temp);

            $this->db->insert_batch('tbl_transaction_items', $temp);

        }


        $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">Stocks have been issued successfully</div>');
        redirect('stock/list_issue_stock' , 'refresh');

    }

    function save_issued_many()
    {
        Modules::run('secure_tings/is_logged_in');
        $info['user_object'] = $this->get_user_object();

        $date_recorded = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
        $user_id = $info['user_object']['user_id'];
        $level = $info['user_object']['user_level'];
        $station= $info['user_object']['user_statiton'];
        $type = "2";
        $status = "issued";
        $batch = stripcslashes($_POST['batch']);
        $batch = json_decode($batch, TRUE);

        echo json_encode($batch);

        
        // $issue_array = array();
        // $issue_counter = 0;

        // $save_id= array();


        // foreach ($batch as $item) {

            
        //     $issue_array['to_from'] = $item['issued_to'];
        //     $issue_array['transaction_date'] = $item['date_issued'];
        //     $issue_array['transaction_voucher'] = $item['s11'];
        //     $issue_array['type'] = $type;
        //     $issue_array['timestamp'] = $date_recorded;
        //     $issue_array['user_id'] = $user_id;
        //     $issue_array['level'] = $level;
        //     $issue_array['station'] = $station;

        //     $this->db->insert('tbl_transaction', $issue_array);
        //     $transaction_id = $this->db->insert_id();

        //     $item_array['vaccine_id'] = $item['vaccine'];
        //     $item_array['batch'] = $item['batch_no'];
        //     $item_array['expiry_date'] = $item['expiry_date'];
        //     $item_array['vvm'] = $item['vvm_status'];
        //     $item_array['current_quantity'] = $item['quantity'];
        //     $item_array['transaction_quantity'] = $item['amount_issued'];
        //     $item_array['transaction_id'] =  $transaction_id;

        //     $this->db->insert('tbl_transaction_items', $item_array);
        // }
           
        // $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">Stocks have been issued successfully</div>');
        // redirect('stock/list_issue_stock' , 'refresh');

    }


    function receive_stocks($order_id)
    {
        Modules::run('secure_tings/is_logged_in');
        $this->load->model('vaccines/mdl_vaccines');
        $data['vaccines'] = $this->mdl_vaccines->getVaccine();
        $this->load->model('mdl_stock');
        $data['receipts'] = $this->mdl_stock->get_order_to_receive($order_id);
        $data['module'] = "stock";
        $data['view_file'] = "new_receive_stock";
        $data['section'] = "manage stock";
        $data['subtitle'] = "Receive Stock";
        $data['page_title'] = "Receive Stock";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();

        $this->load->library('make_bread');
        $this->make_bread->add('Manage Stocks', '', 0);
        $this->make_bread->add('Receive Stocks', 'stock/list_receive_stock', 1);
        $this->make_bread->add('Receive', '', 0);


        $data['breadcrumb'] = $this->make_bread->output();
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);
    }


    function new_save_received_stock()
    {
        Modules::run('secure_tings/is_logged_in');
        //Receive Stock Information
        $data['user_object'] = $this->get_user_object();

        $order_id = $this->input->post('order_id');
        $S11 = $this->input->post('s11');
        $date_received = $this->input->post('date_received');
        $date_recorded = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
        $user_id = $data['user_object']['user_id'];
        $level = $data['user_object']['user_level'];
        $station = $data['user_object']['user_statiton'];
        $type = "1";
        $status = "received";

        $receive_array['transaction_voucher'] = $S11;
        $receive_array['request_id'] = $order_id;
        $receive_array['transaction_date'] = $date_received;
        $receive_array['timestamp'] = $date_recorded;
        $receive_array['type'] = $type;
        $receive_array['status'] = $status;
        $receive_array['user_id'] = $user_id;
        $receive_array['level'] = $level;
        $receive_array['station'] = $station;

        $this->db->insert('tbl_transaction', $receive_array);
        $receive_id = $this->db->insert_id();

        $this->db->query("call set_received_status('$order_id')");
        // Receive Stock Item Information
        $vaccine = $this->input->post('vaccine');
        $batch_no = $this->input->post('batch_no');
        $expiry_date = $this->input->post('expiry_date');
        $amount_received = $this->input->post('quantity_received');
        $vvm_status = $this->input->post('vvm_status');
        $comment = $this->input->post('comment');

        $receive_array = array();
        $receive_counter = 0;

        foreach ($vaccine as $vaccines) {
            $receive_array[$receive_counter]['vaccine_id'] = $vaccine[$receive_counter];
            $receive_array[$receive_counter]['batch'] = $batch_no[$receive_counter];
            $receive_array[$receive_counter]['expiry_date'] = $expiry_date[$receive_counter];
            $receive_array[$receive_counter]['vvm'] = $vvm_status[$receive_counter];
            $receive_array[$receive_counter]['transaction_quantity'] = $amount_received[$receive_counter];
            //$receive_array[$receive_counter]['comment'] = $comment[$receive_counter];
            $receive_array[$receive_counter]['transaction_id'] = $receive_id[$receive_counter];

            $receive_counter++;
        }

        $main_array['own_receipts'] = $receive_array;
        // Add assigned receive id to received items
        foreach ($main_array as $key => $value) {
            foreach ($value as $keyvac => $valuevac) {
                foreach ($valuevac as $keys => $values) {
                    if ($keys == "transaction_id") {
                        $temp[$keyvac]['transaction_id'] = $receive_id;
                    } else {
                        $temp[$keyvac][$keys] = $values;
                    }

                }

            }

        }

        $this->db->insert_batch('tbl_transaction_items', $temp);

        $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">Received stocks have been saved successfully</div>');
        redirect('order/list_orders', 'refresh');
    }

    function save_received_stocks()
    {
        Modules::run('secure_tings/is_logged_in');

        $data['user_object'] = $this->get_user_object();

        $S11 = $this->input->post('s11');
        $date_received = $this->input->post('date_received');
        $date_recorded = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
        $received_from = $this->input->post('received_from');
        $type = "1";
        $status = "received";
        $user_id = $data['user_object']['user_id'];
        $level = $data['user_object']['user_level'];
        $station = $data['user_object']['user_statiton'];

        $receive_array['transaction_voucher'] = $S11;
        $receive_array['transaction_date'] = $date_received;
        $receive_array['timestamp'] = $date_recorded;
        $receive_array['type'] = $type;
        $receive_array['status'] = $status;
        $receive_array['to_from'] = $received_from;
        $receive_array['user_id'] = $user_id;
        $receive_array['level'] = $level;
        $receive_array['station'] = $station;

        $this->db->insert('tbl_transaction', $receive_array);

        $receive_id = $this->db->insert_id();

        $batch = stripcslashes($_POST['batch']);
        $batch = json_decode($batch, TRUE);

        $receive_array = array();
        $receive_counter = 0;

        foreach ($batch as $item) {
            $receive_array[$receive_counter]['vaccine_id'] = $item['vaccine_id'];
            $receive_array[$receive_counter]['batch'] = $item['batch_no'];
            $receive_array[$receive_counter]['expiry_date'] = $item['expiry_date'];
            $receive_array[$receive_counter]['vvm'] = $item['vvm_status'];
            $receive_array[$receive_counter]['comment'] = $item['comment'];
            $receive_array[$receive_counter]['transaction_quantity'] = $item['amount_received'];
            $receive_array[$receive_counter]['transaction_id'] = $receive_id[$receive_counter];

            $receive_counter++;
        }

        $main_array[] = $receive_array;
        // Add assigned receive id to received items
        foreach ($main_array as $key => $value) {
            foreach ($value as $keyvac => $valuevac) {
                foreach ($valuevac as $keys => $values) {
                    if ($keys == "transaction_id") {
                        $temp[$keyvac]['transaction_id'] = $receive_id;
                    } else {
                        $temp[$keyvac][$keys] = $values;
                    }
                }

            }
            $this->db->insert_batch('tbl_transaction_items', $temp);

        }

        $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">Received stocks have been saved successfully</div>');
        redirect('order/list_orders' , 'refresh');
    }

    function remove_duplicate($id){
        $this->load->model('mdl_stock');
        $data = array("hidden"=>"1");
        $query = $this->mdl_stock->_remove_duplicate($id, $data);
        echo json_encode($query);
    }


    function vaccine_name($id){
        $this->load->model('vaccines/mdl_vaccines');
        $query= $this->mdl_vaccines->get_where($id)->result();
        return ($query[0]->vaccine_name);
    }

}
