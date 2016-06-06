<?php

class Reports extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        Modules::run('secure_tings/is_logged_in');

    }


    function counties(){
		$data['module'] = "reports";
		$data['view_file'] = "county_view";
		$data['section'] = "Immunization Performance";
		$data['subtitle'] = "Counties";
		$data['page_title'] = "Counties";
		$data['user_object'] = $this->get_user_object();
		$data['main_title'] = $this->get_title();
		$this->load->library('make_bread');
		$this->make_bread->add('Immunization Performance', '', 0);
		$this->make_bread->add('Counties', '', 0);
		$data['breadcrumb'] = $this->make_bread->output();
		echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);
      }

	function county_list(){

		$list = $this->getCounty();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $county) {
		      $no++;
		      $row = array();
		      $row[] = '  <a onclick="county('.$county->id.')">'.$county->county_name.'</a>';

		      $data[] = $row;
		}

		$output = array(
		  "draw" => $_POST['draw'],
		  "recordsTotal" => $this->count_filtered(),
		  "recordsFiltered" => $this->count_filtered(),
		  "data" => $data,
		);

		echo json_encode($output);
      }

    function get_location(){

		$return_arr = array();
		$row_array = array();

		$this->load->model('mdl_reports');
		$condition = NULL;


		if((isset($_GET['term']) && strlen($_GET['term']) > 0))
		{

		    if(isset($_GET['term']))
		    {
		        $getVar = $_GET['term'];
		       	$condition =  array("location"=> $getVar);
		        $result = $this->mdl_reports->get_location($condition);
		    	//var_dump($result);

		    /* limit with page_limit get */

		    //$limit = intval($_GET['page_limit']);



			    foreach ($result as $row)
		        {
		            $row_array['location'] = utf8_encode($row->location);
		            $return_arr[] = $row_array;
		        }
			}

		}
		else
		{
			$result = $this->mdl_reports->get_location($condition);
	        foreach ($result as $row)
	        {

	            $row_array['location'] = utf8_encode($row->location);
	            $return_arr[] = $row_array;
	        }

		}

		$ret = array();
		/* this is the return for a single result needed by select2 for initSelection */
		if(isset($_GET['term']))
		{
		    $ret = $return_arr;
		}
		/* this is the return for a multiple results needed by select2
		* Your results in select2 options needs to be data.result
		*/
		else
		{
		       $ret = $return_arr;
		}
		echo json_encode($ret);

		// $this->output->enable_profiler(TRUE);
    }

    function get_transactions(){
		$this->load->model('users/mdl_users');
		$query = $this->mdl_users->getRegion();
		return ($query);
    }

    function count_filtered() {
    	$this->load->model('mdl_reports');
		$query = $this->mdl_reports->count_filtered();
        return $query;
      }


      function stock_movement(){
		$data['module'] = "reports";
		$data['view_file'] = "stock_movement_view";
		$data['section'] = "Immunization Performance";
		$data['subtitle'] = "Counties";
		$data['page_title'] = "Counties";
		$data['user_object'] = $this->get_user_object();
		$data['main_title'] = $this->get_title();
		$this->load->library('make_bread');
		$this->make_bread->add('Immunization Performance', '', 0);
		$this->make_bread->add('Counties', '', 0);
		$data['breadcrumb'] = $this->make_bread->output();
		echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);
      }


      function stock_transactions()
    {
        Modules::run('secure_tings/is_logged_in');
        $this->load->model('vaccines/mdl_vaccines');
        $data['vaccines'] = $this->mdl_vaccines->get_vaccine_details();
        $data['module'] = "reports";
        $data['view_file'] = "stocks";
        $data['section'] = "Reports";
        $data['subtitle'] = "Stock Transactions";

        $data['page_title'] = "Stock Transactions";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Reports', '', 0);
        $this->make_bread->add('Stock Transactions', '', 0);
        $data['breadcrumb'] = $this->make_bread->output();
        //$this->output->enable_profiler(TRUE);
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);

    }

    protected function _station($var){
      $station = str_replace('%20', ' ', $var);
      return $station;
    }

    function ledger()
    {

    	Modules::run('secure_tings/is_logged_in');
    	if (isset($_GET['name']) ) {
          if (!empty($_GET['name'])) {
            $station = $this->_station($_GET['name']);
            $data['station'] = $station;

          }
        }else{
        	$info['user_object'] = $this->get_user_object();
        	$station = $info['user_object']['user_statiton'];
        	$data['station'] = $station;
        }

        if (isset($_GET['vac']) ) {
          if (!empty($_GET['vac'])) {
           		$selected_vaccine = $_GET['vac'];
           		$data['id'] = $selected_vaccine;
            }
        }


        $this->load->model('vaccines/mdl_vaccines');
        $data['vaccine'] = $this->mdl_vaccines->get_where($selected_vaccine)->result_array();
        $data['module'] = "reports";
        $data['view_file'] = "vaccine_ledger";
        $data['page_header'] = $station;
        $data['section'] = "Stock Transactions";
        $data['subtitle'] = $this->vaccine_name($selected_vaccine)." Stocks Ledger";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Reports', '', 0);
        $this->make_bread->add('Stock Transactions', 'reports/stock_transactions', 1);

        $data['breadcrumb'] = $this->make_bread->output();

        // $this->output->enable_profiler(TRUE);

        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);
    }

    function vaccine_name($id){
        $this->load->model('vaccines/mdl_vaccines');
        $query= $this->mdl_vaccines->get_where($id)->result();
        return ($query[0]->vaccine_name);
    }

    function stock_data($id, $station){
      	$this->load->model('mdl_reports');
      	$station = $this->_station($station);
		$transaction = $this->mdl_reports->get_transactions($station, $id);
		$data = array();
		$no = $_POST['start'];
		foreach ($transaction as $val) {
		      $no++;
		      $row = array();
		      $row[] = $val->transaction_date;
              $row[] = $val->type;
		      $row[] = $val->to_from;
              $row[] = $val->quantity;

		      $row[] = $val->batch;
              $row[] = $val->expiry;

		      $row[] = $val->balance;


		      $data[] = $row;
		}

		$output = array(
		  "draw" => $_POST['draw'],
		  "recordsTotal" => $this->mdl_reports->count_transactions_filtered($station, $id),
          "recordsFiltered" => $this->mdl_reports->count_transactions_filtered($station, $id),
		  "data" => $data,
		);

		echo json_encode($output);
      }

      function stock_levels(){
          echo "Display Report here";
      }

      function coverage(){
          echo "You are here";
      }

      function system_usage(){
          echo "You are here";
      }


}
