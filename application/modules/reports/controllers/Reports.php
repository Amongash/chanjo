<?php

class Reports extends MY_Controller {

    function __construct() {
        parent::__construct();
        Modules::run('secure_tings/is_logged_in');

    }


    function counties() {
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

    function county_list() {

        $list = $this->getCounty();
        $data = array();
        $no = $_POST['start'];
        foreach($list as $county) {
            $no++;
            $row = array();
            $row[] = '  <a onclick="county('.$county->id.
            ')">'.$county->county_name.
            '</a>';

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

    function get_location() {

        $return_arr = array();
        $row_array = array();

        $this->load->model('mdl_reports');
        $condition = NULL;


        if ((isset($_GET['term']) && strlen($_GET['term']) > 0)) {

            if (isset($_GET['term'])) {
                $getVar = $_GET['term'];
                $condition = array("location" => $getVar);
                $result = $this->mdl_reports->get_location($condition);
                //var_dump($result);

                /* limit with page_limit get */

                //$limit = intval($_GET['page_limit']);



                foreach($result as $row) {
                    $row_array['location'] = utf8_encode($row->location);
                    $return_arr[] = $row_array;
                }
            }

        } else {
            $result = $this->mdl_reports->get_location($condition);
            foreach($result as $row) {

                $row_array['location'] = utf8_encode($row->location);
                $return_arr[] = $row_array;
            }

        }

        $ret = array();
        /* this is the return for a single result needed by select2 for initSelection */
        if (isset($_GET['term'])) {
            $ret = $return_arr;
        }
        /* this is the return for a multiple results needed by select2
         * Your results in select2 options needs to be data.result
         */
        else {
            $ret = $return_arr;
        }
        echo json_encode($ret);

        // $this->output->enable_profiler(TRUE);
    }

    function get_transactions() {
        $this->load->model('users/mdl_users');
        $query = $this->mdl_users->getRegion();
        return ($query);
    }

    function count_filtered() {
        $this->load->model('mdl_reports');
        $query = $this->mdl_reports->count_filtered();
        return $query;
    }


    function stock_movement() {
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


    function stock_transactions() {
        Modules::run('secure_tings/is_logged_in');
        $this->load->model('vaccines/mdl_vaccines');
        $this->load->model('users/mdl_user_levels');
        $this->load->model('region/mdl_region');


        //echo '<pre>',print_r($this->mdl_group->get_all()),'</pre>';exit;
        $data['user_levels'] = json_decode(json_encode($this->mdl_user_levels->get_all()), true);
        $data['regions'] = json_decode(json_encode($this->mdl_region->get_all()), true);
        //$data['vaccines'] = json_decode(json_encode($this->mdl_vaccines->get_all()),true);


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
        echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);

    }

    protected
    function _station($var) {
        $station = str_replace('%20', ' ', $var);
        return $station;
    }

    function ledger() {

        Modules::run('secure_tings/is_logged_in');
        if (isset($_GET['name'])) {
            if (!empty($_GET['name'])) {
                $station = $this->_station($_GET['name']);
                $data['station'] = $station;

            }
        } else {
            $info['user_object'] = $this->get_user_object();
            $station = $info['user_object']['user_statiton'];
            $data['station'] = $station;
        }

        if (isset($_GET['vac'])) {
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
        $data['subtitle'] = $this->vaccine_name($selected_vaccine).
        " Stocks Ledger";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Reports', '', 0);
        $this->make_bread->add('Stock Transactions', 'reports/stock_transactions', 1);

        $data['breadcrumb'] = $this->make_bread->output();

        // $this->output->enable_profiler(TRUE);

        echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);
    }

    function vaccine_name($id) {
        $this->load->model('vaccines/mdl_vaccines');
        $query = $this->mdl_vaccines->get_where($id)->result();
        return ($query[0]->vaccine_name);
    }

    function stock_data($id, $station) {
        $this->load->model('mdl_reports');
        $station = $this->_station($station);
        $transaction = $this->mdl_reports->get_transactions($station, $id);
        $data = array();
        $no = $_POST['start'];
        foreach($transaction as $val) {
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

    function getCountiesjson($id) {
        $col = 'region_id';
        $this->load->model('county/mdl_county');
        echo json_encode($this->mdl_county->get_where_custom($col, $id)->result(), true);
    }

    function getallCountiesjson() {

        $this->load->model('county/mdl_county');
        echo json_encode($this->mdl_county->get_all(), true);
    }

    function getSubcountiesjson($id) {
        $col = 'county_id';
        $this->load->model('subcounty/mdl_subcounty');
        echo json_encode($this->mdl_subcounty->get_where_custom($col, $id)->result(), true);
    }

    function getallSubcountiesjson() {

        $this->load->model('subcounty/mdl_subcounty');
        echo json_encode($this->mdl_subcounty->get_all(), true);
    }

    function getallFacilitiesjson() {

        $this->load->model('facility/mdl_facility');
        echo json_encode($this->mdl_facility->get_all(), true);
    }

    function stock_levels($level = 'NULL', $region_name = 'NULL', $region_id = 'NULL', $county_id = 'NULL') {

        $user_object = $this->get_user_object();
        $user_level = $user_object['user_level'];
        //echo '<pre>',print_r($level),'</pre>';exit;
        $this->load->model('dashboard/mdl_dashboard');
        $region_name = str_replace('%20', ' ', $region_name);

        $query_population = [];

        if ($level == 1 && $region_id == 'NULL' && $county_id == 'NULL') {

            $query_population = $this->mdl_dashboard->get_population_national();
            $query['KENYA'] = $this->mdl_dashboard->get_stock_balance('KENYA');
            $population = [];
            foreach($query_population as $key => $value) {

                $population['KENYA'] = $value->population;

            }

        }

        elseif($level == 2 && $region_id == 'NULL' && $county_id == 'NULL') {

            $this->load->model('region/mdl_region');
            $level = 'National';
            $region_column = 'region_name';

            $query_regions = $this->mdl_region->get_all();

            $query = [];
            foreach($query_regions as $key => $value) {
                $regions[] = $value->region_name;
                $query[$value->region_name] = $this->mdl_dashboard->get_stock_balance($value->region_name);
            }

            foreach($query as $key => $value) {

                if (sizeof($value) != 0) {
                    $query_population[] = $this->mdl_region->get_where_custom($region_column, $key)->result();
                } else {
                    unset($query[$key]);
                }

            }

            $population = [];
            foreach($query_population as $key => $value) {

                $population[$value[0]->region_name] = $value[0]->under_one_population;

            }

            //echo '<pre>',print_r($population),'</pre>';exit;


        }
        elseif($level == 2 && $region_id != 'NULL' && $county_id == 'NULL') {

            $this->load->model('region/mdl_region');
            $this->load->model('county/mdl_county');
            $col = 'region_name';
            //$value=$station;
            //get population of station
            //  $query_population = $this->mdl_region->get_where_custom($col, $value)->result();

            //get counties in region
            $county_column = 'region_id';
            $query_counties = $this->mdl_county->get_where_custom($county_column, $region_id)->result();

            $query = [];
            foreach($query_counties as $key => $value) {
                    $counties[] = $value->county_name;
                    //$station=str_replace('%20',' ',$value->county_name);
                    $query[$value->county_name] = $this->mdl_dashboard->get_stock_balance($value->county_name);
                } //echo '<pre>',print_r($query),'</pre>';exit;

            foreach($query as $key => $value) {

                    if (sizeof($value) != 0) {
                        $query_population[] = $this->mdl_county->get_where_custom($county_column, $key)->result();
                    } else {
                        unset($query[$key]);
                    }

                }
                //echo '<pre>',print_r($counties),'</pre>';exit;
            $population = [];
            foreach($query_population as $key => $value) {

                $population[$value[0]->county_name] = $value[0]->under_one_population;

            }

            //get counties in region


        }
        elseif($county_id != 'NULL') {
            $this->load->model('county/mdl_county');
            $this->load->model('subcounty/mdl_subcounty');
            $col = 'subcounty_name';
            $subcounty_column = 'county_id';
            //$value=$station;

            //get sub counties in region
            $query_subcounties = $this->mdl_subcounty->get_where_custom($subcounty_column, $county_id)->result();
            //  $query=[];
            foreach($query_subcounties as $key => $value) {
                $subcounties[] = $value->subcounty_name;

                $query[$value->subcounty_name] = $this->mdl_dashboard->get_stock_balance($value->subcounty_name);

            }

            foreach($query as $key => $value) {

                if (sizeof($value) != 0) {
                    $query_population[] = $this->mdl_subcounty->get_where_custom($col, $key)->result();
                } else {
                    unset($query[$key]);
                }

            }

            $population = [];
            foreach($query_population as $key => $value) {

                    $population[$value[0]->subcounty_name] = $value[0]->under_one_population;

                }
                //  echo '<pre>',print_r($query_population),'</pre>';exit;


        }
        elseif($level == 4) {
          #code
        }

        if (count($query) == 0) {
            echo '<div style="margin:5%;font-size:3em;font-weight:400;"> No data at this time.</div>';
            exit;
        }


        $data['query'] = $query;
        $data['population'] = $population;

        $this->load->view("reports/stock_levels", $data);

        //echo '<pre>',print_r($subcounties,true),'</pre>';exit;
    }

    function coverage($level = 'NULL', $region_id = 'NULL', $county_id = 'NULL', $vaccineA = 'NULL', $vaccineB = 'NULL', $maxdate = 'NULL', $mindate = 'NULL') {
        $user_object = $this->get_user_object();
        $user_level = $user_object['user_level'];
        $this->load->model('dashboard/mdl_dashboard');
        //$station=str_replace('%20',' ',$station);

        if ($maxdate == 'NULL' || $mindate == 'NULL') {
            $maxdate = date('Y-m-d');
            $mindate = new DateTime(date('Y-m-d'));
            $interval = new DateInterval('P12M');
            $mindate = $mindate->sub($interval)->format('Y-m-d');
        }
        $maxdate = date('Y-m-d', strtotime($maxdate));
        $mindate = date('Y-m-d', strtotime($mindate));
        //echo '<pre>',print_r($maxdate),'</pre>';exit;




        if ($level != 'NULL' && $region_id == 'NULL' && $county_id == 'NULL') {


            $query = $this->mdl_dashboard->all_region_coverage($maxdate, $mindate);
            //echo '<pre>',print_r($query),'</pre>';exit;


        }
        elseif($level != 'NULL' && $region_id != 'NULL' && $county_id == 'NULL') {

            $query = $this->mdl_dashboard->all_counties_coverage($maxdate, $mindate, $region_id);
            //echo '<pre>',print_r($query),'</pre>';exit;



        }
        elseif($county_id != 'NULL') {

            $query = $this->mdl_dashboard->all_subcounties_coverage($maxdate, $mindate, $county_id);
            //echo '<pre>',print_r($query),'</pre>';exit;


        }
        elseif($subcounty_id != 'NULL') {
            $query = $this->mdl_dashboard->all_subcounties_coverage($maxdate, $mindate, $county_id);
            //echo '<pre>',print_r($query),'</pre>';exit;
        }

        if (count($query) == 0) {
            echo '<div style="margin:5%;font-size:3em;font-weight:400;"> No data at this time.</div>';
            exit;
        }


        $data['query'] = $query;
        $data['A'] = $vaccineA;
        $data['B'] = $vaccineB;


        $this->load->view("reports/coverage", $data);
    }

    function stock_summary($level = 'NULL', $region_id = 'NULL', $county_id = 'NULL') {
        $user_object = $this->get_user_object();
        $user_level = $user_object['user_level'];
        $this->load->model('dashboard/mdl_dashboard');
        $this->load->model('vaccines/mdl_vaccines');



        if ($level != 'NULL' && $region_id == 'NULL' && $county_id == 'NULL') {



        }
        elseif($level != 'NULL' && $region_id != 'NULL' && $county_id == 'NULL') {



        }
        elseif($county_id != 'NULL') {




        }
        elseif($subcounty_id != 'NULL') {

        }

        if (count($query) == 0) {
            echo '<div style="margin:5%;font-size:3em;font-weight:400;"> No data at this time.</div>';
            exit;
        }


        $data['query'] = $query;

        $this->load->view("reports/stock_summary", $data);
    }

    function system_usage() {
        echo "You are here";
    }

    function coverage_comparison() {
        echo "You are here";
    }

    function stock_allocation() {
        $this->load->model('vaccines/mdl_vaccines');
        $info['user_object'] = $this->get_user_object();
        $station = $info['user_object']['user_statiton'];
        $data['module'] = "reports";
        $data['view_file'] = "list_allocation";
        $data['page_header'] = $station;
        $data['section'] = "Stock Allocation";
        $data['subtitle'] = "Allocations";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Reports', '', 0);
        $this->make_bread->add('Stock Allocations', 'reports/stock_allocation', 1);

        $data['breadcrumb'] = $this->make_bread->output();

        // $this->output->enable_profiler(TRUE);

        echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);
    }

    function new_allocation() {
        $this->load->model('vaccines/mdl_vaccines');
        $info['user_object'] = $this->get_user_object();
        $station = $info['user_object']['user_statiton'];
        $data['module'] = "reports";
        $data['view_file'] = "allocation";
        $data['page_header'] = $station;
        $data['section'] = "Stock Allocation";
        $data['subtitle'] = "Allocations";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        $data['vaccines'] = $this->mdl_vaccines->getVaccine();
        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Reports', '', 0);
        $this->make_bread->add('Stock Allocations', 'reports/stock_allocation', 1);

        $data['breadcrumb'] = $this->make_bread->output();

        // $this->output->enable_profiler(TRUE);

        echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);
    }

    function target_population($vaccine = null, $quantity= null) {
        $this->load->model('mdl_reports');
        $info['user_object'] = $this->get_user_object();
        $level = $info['user_object']['user_level'];
        $station = $info['user_object']['user_statiton'];
        if ($vaccine == null || $quantity == null) {
           $data['data'] = array(
                      'name' => '',
                      'population' => '',
                      'balance' => '',
                      'mos' => ''
                  );
        } else if (is_numeric($vaccine)==true && is_numeric($quantity)){
          $population = $this->mdl_reports->get_total_population($station, $level);
       
          foreach($population as $key => $value) {
              $loc= $this->mdl_reports->get_vaccine_balance($value['name'], $vaccine);
              
              $location[] = array(
                      'name' => $value['name'],
                      'population' => $value['population'],
                      'balance' => 0,
                      'mos' => 0,
                      'quantity' => 0
                  );
              foreach($loc as $key => $val) {
                  if ($val==0 || $val==''){
                    $location[] = array(
                      'name' => $value['name'],
                      'population' => $value['population'],
                      'balance' =>  $val['stock_balance'],
                      'mos' => 'Missing data',
                      'quantity' => $quantity
                    );  
                    
                    
                  }else if ($val>0 ){
                    if($value['population'] == 0){
                      $location[] = array(
                      'name' => $value['name'],
                      'population' => 0,
                      'balance' => $val['stock_balance'],
                      'mos' => 'N/A',
                      'quantity' => $quantity
                    );  
                    }else{
                      $location[] = array(
                      'name' => $value['name'],
                      'population' => $value['population'],
                      'balance' => $val['stock_balance'],
                      'mos' => (float)$val['stock_balance']/($value['population']/12),
                      'quantity' => $quantity
                    );  
                    }
                    
                  }

                  
              }


          }
          $data['data'] = $location;
        }
        
        
       
         echo json_encode($data);

    }


}