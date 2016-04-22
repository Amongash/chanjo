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

    function getRegion(){

		$return_arr = array();
		$row_array = array();

		$this->load->model('mdl_reports');
		$condition = NULL;
		

		if((isset($_GET['term']) && strlen($_GET['term']) > 0))
		{

		    if(isset($_GET['term']))
		    {
		        $getVar = $_GET['term'];
		       	$condition =  array("region_name"=> $getVar);
		        $result = $this->mdl_reports->getRegion($condition);
		    
		    
		    /* limit with page_limit get */

		    //$limit = intval($_GET['page_limit']);
		    
			

			    foreach ($result as $row) 
		        {
		            $row_array['id'] = $row->id;
		            $row_array['region_name'] = utf8_encode($row->region_name);
		            array_push($return_arr,$row_array);
		        }
			}

		}
		else
		{
			$result = $this->mdl_reports->getRegion($condition);
	        foreach ($result as $row) 
	        {
	            $row_array['id'] = $row->id;
	            $row_array['region_name'] = utf8_encode($row->region_name);
	            array_push($return_arr,$row_array);
	        }

		}

		$ret = array();
		/* this is the return for a single result needed by select2 for initSelection */
		if(isset($_GET['term']))
		{
		    $ret['results'] = $row_array;
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

      function stock_data(){
      	$this->load->model('mdl_reports');
      	$info['user_object'] = $this->get_user_object();
        $station = $info['user_object']['user_statiton'];
		$transaction = $this->mdl_reports->get_transactions($station);
		$data = array();
		$no = $_POST['start'];
		foreach ($transaction as $val) {
		      $no++;
		      $row = array();    
		      $row[] = $val->transaction_date;
		      $row[] = $val->station;
		      $row[] = $val->received;
		      $row[] = $val->issued;
		      $row[] = $val->count;
		      $row[] = $val->balance;

		      $data[] = $row;
		}

		$output = array(
		  "draw" => $_POST['draw'],
		  "recordsTotal" => $this->mdl_reports->count_transactions_filtered($station),
          "recordsFiltered" => $this->mdl_reports->count_transactions_filtered($station),
		  "data" => $data,
		);

		echo json_encode($output);
      }

}