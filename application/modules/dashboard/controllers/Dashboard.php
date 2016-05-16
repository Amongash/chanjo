<?php
class Dashboard extends MY_Controller
{

function __construct() {
parent::__construct();
Modules::run('secure_tings/is_logged_in');
// $this->output->enable_profiler(true);

}


    function index()
    {

        $info['user_object'] = $this->get_user_object();



        if (isset($_GET['name']) ) {
          if (!empty($_GET['name'])) {
            $station_id = $this->_station($_GET['name']);
            $data['station'] = $station_id;
            $data['subtitle'] = $station_id." Dashboard";
          }
        }else{
          $station_id = $info['user_object']['user_statiton'];
          $data['station'] = $station_id;
          $data['subtitle'] = "Dashboard";

        }

        if (isset($_GET['loc']) ) {
          if (!empty($_GET['loc'])) {
            $user_level = (int)$_GET['loc']+1;
            }
          }else{
             $user_level = $info['user_object']['user_level'];

          }



          if ($user_level == '1') {
            $option = '1';
            //$data['best'] = $this->best_dpt3cov($station_id, $option);
            //$data['worst'] = $this->worst_dpt3cov($station_id, $option);
            //echo '<pre>',print_r($this->best_dpt3cov($station_id, $option)),'</pre>';exit;
          } elseif ($user_level == '2') {
            $option = '2';
            //$data['best'] = $this->best_dpt3cov($station_id, $option);
            //$data['worst'] = $this->worst_dpt3cov($station_id, $option);
          } elseif ($user_level == '3') {
            $option = '3';
            $data['best'] = $this->best_dpt3cov($station_id, $option);
            $data['worst'] = $this->worst_dpt3cov($station_id, $option);
          } else {
            $option = '4';
            $data['best'] = $this->best_dpt3cov($station_id, $option);
            $data['worst'] = $this->worst_dpt3cov($station_id, $option);
          }


        $data['section'] = "NVIP-Chanjo";
        $data['view_file'] = "dashboard_view";
        $data['module'] = "dashboard";
        $data['loc'] = $user_level;

        $data['user_level'] = $user_level;
        $data['page_header'] = $station_id;
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        $data['breadcrumb'] = '';
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);

    }


    protected function _station($var){
      $station = str_replace('%20', ' ', $var);
      return $station;
    }

   function get_stock_balance()
   {
       $station_id = $this->_station($this->uri->segment(3));
       $this->load->model('mdl_dashboard');
       $query = $this->mdl_dashboard->get_stock_balance($station_id);
       $json_array = array();
       foreach ($query->result() as $row) {
           $data['name'] = $row->vaccine_name;
           $data['y'] = (float)$row->stock_balance;

           array_push($json_array, $data);
       }
       echo json_encode($json_array);

   }


   function get_coverage()
   {
      $this->load->model('mdl_dashboard');
      $info['user_object'] = $this->get_user_object();

      if (isset($_GET['name']) ) {
        if (!empty($_GET['name'])) {
          $station_id = $this->_station($_GET['name']);
        }
      }else{
        $station_id = $info['user_object']['user_statiton'];
      }


      if (isset($_GET['loc']) ) {
          if (!empty($_GET['loc'])) {
            $user_level = (int)$_GET['loc'];
            }
          }else{
             $user_level = $info['user_object']['user_level'];
          }


      if ($user_level == '1') {
         $query = $this->mdl_dashboard->get_national_coverage();
      } else if ($user_level == '2') {
         $query = $this->mdl_dashboard->get_region_coverage($station_id);
      } else if ($user_level == '3') {
         $query = $this->mdl_dashboard->get_county_coverage($station_id);
      } else if ($user_level == '4') {
         $query = $this->mdl_dashboard->get_subcounty_coverage($station_id);
      }
      $json_array = array();
      foreach ($query->result() as $row) {
        $data['name'] = $row->months;
        $data['y'] = (int)$row->bcg;
        $data['z'] = (int)$row->dpt1;
         array_push($json_array, $data);

      }
      echo json_encode($json_array);

   }

    function best_dpt3cov($station_id, $option){
        $option = $option;
        $station_id = $station_id;
        $this->load->model('mdl_dashboard');

        if ($option == '1') {
           $query = $this->mdl_dashboard->best_region_dpt3();
        } elseif ($option == '2') {
            $query = $this->mdl_dashboard->best_county_dpt3($station_id);
        } elseif ($option == '3') {
             $query = $this->mdl_dashboard->best_subcounty_dpt3($station_id);
        } elseif ($option == '4') {
             $query = $this->mdl_dashboard->best_facility_dpt3($station_id);
        }


        $json_array = array();
        foreach ($query->result() as $row) {
            $data['name'] = $row->name;
            $data['totaldpt3'] = (int)$row->dpt3;
            $data['totaldpt1'] = (int)$row->dpt1;

            array_push($json_array, $data);

        }
        //echo json_encode($json_array);
        return $json_array;
    }


    function worst_dpt3cov($station_id, $option)
    {
        $option = $option;
        $station_id = $station_id;
        $this->load->model('mdl_dashboard');

        if ($option == '1') {
           $query = $this->mdl_dashboard->worst_region_dpt3();
        } elseif ($option == '2') {
            $query = $this->mdl_dashboard->worst_county_dpt3($station_id);
        } elseif ($option == '3') {
             $query = $this->mdl_dashboard->worst_subcounty_dpt3($station_id);
        } elseif ($option == '4') {
             $query = $this->mdl_dashboard->worst_facility_dpt3($station_id);
        }


      $json_array = array();
        foreach ($query->result() as $row) {
            $data['name'] = $row->name;
            $data['totaldpt3'] = (int)$row->dpt3;
            $data['totaldpt1'] = (int)$row->dpt1;
            array_push($json_array, $data);

        }
        //echo json_encode($json_array);
        return $json_array;

    }


   function months_of_stock()
   {
       $info['user_object'] = $this->get_user_object();
       $user_level = $info['user_object']['user_level'];
       $station_id = $this->_station($this->uri->segment(3));
       $this->load->model('mdl_dashboard');
       $query = $this->mdl_dashboard->vaccine();
       $json_array = array();
       foreach ($query as $row) {
           $vaccine[] = $row->Vaccine_name;
       }
       $size = sizeof($vaccine);
       for ($i = 0; $i < $size; $i++) {
           $bal_query = $this->mdl_dashboard->get_stock_balance_where($station_id, $vaccine[$i]);

           foreach ($bal_query as $row) {
               $vaccines[] = $row->vaccine_name;
               $balance[] = $row->stock_balance;

               $doses_query = $this->mdl_dashboard->get_doses_administered_where($user_level, $station_id, $vaccines[$i]);
               foreach ($doses_query as $r) {
                   $data['name'] = $vaccines[$i];
                   $data['y'] = (int)($balance[$i] / $r->{$vaccines[$i]});
                   $json_array[] = $data;

               }

           }

       }
       echo json_encode($json_array);

   }

   function vaccineBalance(){

     $info['user_object'] = $this->get_user_object();
     $user_level = $info['user_object']['user_level'];
     $user_station = $info['user_object']['user_statiton'];

     if ($user_level == '1') {
       return $this->balanceNational();
     }elseif ($user_level == '2') {
       return $this->balanceRegion();
     }elseif ($user_level == '3') {
       # code...
     }
     elseif ($user_level == '4') {
       # code...
     }else {
       return 'Error';
     }


   }

   function vaccineBalancemos(){

     $info['user_object'] = $this->get_user_object();
     $user_level = $info['user_object']['user_level'];
     $user_station = $info['user_object']['user_statiton'];

     if ($user_level == '1') {
       return $this->balanceMosnational();
     }elseif ($user_level == '2') {
       return $this->balanceMosregion();
     }elseif ($user_level == '3') {
       # code...
     }
     elseif ($user_level == '4') {
       # code...
     }else {
       return 'Error';
     }


   }

   function positiveColdchain(){

     $info['user_object'] = $this->get_user_object();
     $user_level = $info['user_object']['user_level'];
     $user_station = $info['user_object']['user_statiton'];

     if ($user_level == '1') {
       return $this->positivecoldchainNational();
     }elseif ($user_level == '2') {
       return $this->positivecoldchainRegion();
     }elseif ($user_level == '3') {
       # code...
     }
     elseif ($user_level == '4') {
       # code...
     }else {
       return 'Error';
     }


   }

   function negativeColdchain(){

     $info['user_object'] = $this->get_user_object();
     $user_level = $info['user_object']['user_level'];
     $user_station = $info['user_object']['user_statiton'];

     if ($user_level == '1') {
       return $this->negativecoldchainNational();
     }elseif ($user_level == '2') {
       return $this->negativecoldchainRegion();
     }elseif ($user_level == '3') {
       # code...
     }
     elseif ($user_level == '4') {
       # code...
     }else {
       return 'Error';
     }

   }
   function coverage(){

     $info['user_object'] = $this->get_user_object();
     $user_level = $info['user_object']['user_level'];
     $user_station = $info['user_object']['user_statiton'];

     if ($user_level == '1') {
       return $this->coverageNational();
     }elseif ($user_level == '2') {
       return $this->coverageRegion();
     }elseif ($user_level == '3') {
       # code...
     }
     elseif ($user_level == '4') {
       # code...
     }else {
       return 'Error';
     }


   }


   function balanceNational(){
     $info['user_object'] = $this->get_user_object();
     $user_level = $info['user_object']['user_level'];
     $station = $info['user_object']['user_statiton'];
     $this->load->model('mdl_dashboard');
     $query = $this->mdl_dashboard->get_stock_balance($station);
     $new=json_decode(json_encode($query),true);
     $category_data=[];
     $series_data=[];
     foreach ($new as $key =>$value ) {

       $category_data[]=$value['vaccine_name'];
       $series_data[]=(int)$value['balance'];

     }
     //echo '<pre>',print_r(json_encode($new),true),'</pre>';
     $data['graph_type'] = 'bar';
     $data['graph_title'] = "Stock Balance";
     $data['graph_yaxis_title'] = "Stock Balance";
     $data['graph_id'] = "Stock";
     $data['legend'] = "Doses";
     $data['colors'] = "['#008080','#6AF9C4']";
     $data['series_data'] = json_encode($series_data);
     $data['category_data'] =  json_encode($category_data);
     $this -> load -> view("dashboard",$data);

   }
   function balanceRegion(){
     $info['user_object'] = $this->get_user_object();
     $user_level = $info['user_object']['user_level'];
     $station = $info['user_object']['user_statiton'];
     $this->load->model('mdl_dashboard');
     $query = $this->mdl_dashboard->get_stock_balance_region($station);
     $new=json_decode(json_encode($query),true);
     $category_data=[];
     $series_data=[];
     foreach ($new as $key =>$value ) {

       $category_data[]=$value['vaccine_name'];
       $series_data[]=(int)$value['balance'];

     }
     $data['graph_type'] = 'bar';
     $data['graph_title'] = "Stock Balance (Units)";
     $data['graph_yaxis_title'] = "Doses";
     $data['graph_id'] = "Stock";
     $data['legend'] = "Doses";
     $data['colors'] = "['#008080','#6AF9C4']";
     $data['series_data'] = json_encode($series_data);
     $data['category_data'] =  json_encode($category_data);
     $this -> load -> view("dashboard",$data);
   }
   function balanceCounty(){
     $info['user_object'] = $this->get_user_object();
     $user_level = $info['user_object']['user_level'];
     $this->load->model('mdl_dashboard');
     $query = $this->mdl_dashboard->get_stock_balance_county();
     echo json_encode($query);
   }

   function balanceSubcounty(){
     $info['user_object'] = $this->get_user_object();
     $user_level = $info['user_object']['user_level'];
     $this->load->model('mdl_dashboard');
     $query = $this->mdl_dashboard->get_stock_balance_subcounty();
     echo json_encode($query);
   }

   function balanceFacility(){
     $info['user_object'] = $this->get_user_object();
     $user_level = $info['user_object']['user_level'];
     $this->load->model('mdl_dashboard');
     $query = $this->mdl_dashboard->get_stock_facility();
     echo json_encode($query);
   }

   function balanceMosnational(){
     $info['user_object'] = $this->get_user_object();
     $user_level = $info['user_object']['user_level'];
     $station = $info['user_object']['user_statiton'];
     $this->load->model('mdl_dashboard');
     $query = $this->mdl_dashboard->get_stock_balance($station);
     $population = $this->mdl_dashboard->get_population_national();
     $pop=json_decode(json_encode($population),true);
     $population=(int)$pop[0]['population'];
     $new=json_decode(json_encode($query),true);
     $category_data=[];
     $series_data=[];
     foreach ($new as $key =>$value ) {

       $category_data[]=$value['vaccine_name'];
       $series_data[]=(int)$value['balance']/($population/12);

     }
     //echo '<pre>',print_r(json_encode($series_data),true),'</pre>';
     $data['graph_type'] = 'bar';
     $data['graph_title'] = "Stock Balance (MOS)";
     $data['graph_yaxis_title'] = "Months of Stock";
     $data['graph_id'] = "mos";
     $data['legend'] = "MOS";
     $data['colors'] = "['#008080','#6AF9C4']";
     $data['series_data'] = json_encode($series_data);
     $data['category_data'] =  json_encode($category_data);
     $this -> load -> view("dashboard",$data);
   }

   function balanceMosregion(){
     $info['user_object'] = $this->get_user_object();
     $user_level = $info['user_object']['user_level'];
     $station = $info['user_object']['user_statiton'];
     $this->load->model('mdl_dashboard');
     $query = $this->mdl_dashboard->get_stock_mos_region($station);
     $new=json_decode(json_encode($query),true);
     $category_data=[];
     $series_data=[];
     foreach ($new as $key =>$value ) {

       $category_data[]=$value['vaccine_name'];
       $series_data[]=(int)$value['mos'];

     }
     //echo '<pre>',print_r(json_encode($series_data),true),'</pre>';
     $data['graph_type'] = 'bar';
     $data['graph_title'] = "Stock Balance (MOS)";
     $data['graph_yaxis_title'] = "Months of Stock";
     $data['graph_id'] = "mos";
     $data['legend'] = "MOS";
     $data['colors'] = "['#008080','#6AF9C4']";
     $data['series_data'] = json_encode($series_data);
     $data['category_data'] =  json_encode($category_data);
     $this -> load -> view("dashboard",$data);
   }

   function positivecoldchainNational(){
     $info['user_object'] = $this->get_user_object();
     $user_level = $info['user_object']['user_level'];
     $this->load->model('mdl_dashboard');
     $query_total = $this->mdl_dashboard->get_vaccine_volume_national();
     $query_opv = $this->mdl_dashboard->get_opv_vaccine_volume_national();
     $total_capacity = $this->mdl_dashboard->get_fridge_cold_chain_capacity_national();
     $query_total=json_decode(json_encode($query_total),true);
     $query_opv=json_decode(json_encode($query_opv),true);
     $total_capacity=json_decode(json_encode($total_capacity),true);
     $positivecoldchain=$query_total[0]['volume']-$query_opv[0]['volume'];
     $opv_volume=$query_opv[0]['volume'];
     $unusedcapacity=$total_capacity[0]['total_volume']-$positivecoldchain;

     $data['graph_title'] = "+ve Cold Chain Capacity, 2016 to May";
     $data['graph_id'] = "positive";
     $data['legend'] = "Litres";
     $data['colors'] = "['#008080','#6AF9C4']";
     $data['piedata'] = json_encode((int)$positivecoldchain);
     $data['remaining_volume'] = json_encode((int)$unusedcapacity);
     $this -> load -> view("pie_template",$data);
   }

   function negativecoldchainNational(){
     $info['user_object'] = $this->get_user_object();
     $user_level = $info['user_object']['user_level'];
     $this->load->model('mdl_dashboard');
     $query_opv = $this->mdl_dashboard->get_opv_vaccine_volume_national();
     $total_capacity = $this->mdl_dashboard->get_freezer_cold_chain_capacity_national();
     $total_capacity=json_decode(json_encode($total_capacity),true);
     $query_opv=json_decode(json_encode($query_opv),true);
     $negativecoldchain=$query_opv[0]['volume'];
     $unusedcapacity=$total_capacity[0]['total_volume']-$query_opv[0]['volume'];

     $data['graph_title'] = "-ve Cold Chain Capacity 2016 to May";
     $data['graph_id'] = "negative";
     $data['legend'] = "Litres";
     $data['colors'] = "['#008080','#6AF9C4']";
     $data['remaining_volume'] = json_encode((int)$unusedcapacity);
     $data['piedata'] = json_encode((int)$opv_volume);
     $this -> load -> view("pie_template",$data);
   }

   function coverageNational(){
     $info['user_object'] = $this->get_user_object();
     $user_level = $info['user_object']['user_level'];
     $this->load->model('mdl_dashboard');
     $query = $this->mdl_dashboard->get_national_coverage();
     $population = $this->mdl_dashboard->get_population_national();
     $pop=json_decode(json_encode($population),true);
     $population=(int)$pop[0]['population'];

     $query=json_decode(json_encode($query),true);
     //echo '<pre>',print_r($population),'</pre>';exit;

     $category_data=[];
     $bcg=[]; $dpt1=[]; $dpt2=[];  $dpt3=[];  $measles=[];  $opv1=[];  $opv2=[]; $opv3=[];
     $pvc1=[];  $pvc2=[]; $pvc3=[]; $rota1=[]; $rota2=[];

     foreach ($query as $key =>$value ) {
       $time_data[]=$value['periodname'];
       $bcg[]=(int)$value['bcg']*1200/$population;
       $dpt1[]=(int)$value['dpt1']*1200/$population;
       $dpt2[]=(int)$value['dpt2']*1200/$population;
       $dpt3[]=(int)$value['dpt3']*1200/$population;
       $measles[]=(int)$value['measles']*1200/$population;
       $opv1[]=(int)$value['opv1']*1200/$population;
       $opv2[]=(int)$value['opv2']*1200/$population;
       $opv3[]=(int)$value['opv3']*1200/$population;
       $pvc1[]=(int)$value['pvc1']*1200/$population;
       $pvc2[]=(int)$value['pvc2']*1200/$population;
       $pvc3[]=(int)$value['pvc3']*1200/$population;
       $rota1[]=(int)$value['rota1']*1200/$population;
       $rota2[]=(int)$value['rota2']*1200/$population;

     }
     $data['graph_title'] = "Coverage";
     $data['graph_id'] = "coverage";
     $data['legend'] = "units here";
     $data['colors'] = "['#008080','#6AF9C4']";


     $data['bcg'] = json_encode($bcg);
     $data['dpt1'] = json_encode($dpt1);
     $data['dpt2'] = json_encode($dpt2);
     $data['dpt3'] = json_encode($dpt3);
     $data['measles'] = json_encode($measles);
     $data['opv1'] = json_encode($opv1);
     $data['opv2'] = json_encode($opv2);
     $data['opv3'] = json_encode($opv3);
     $data['pvc1'] = json_encode($pvc1);
     $data['pvc2'] = json_encode($pvc2);
     $data['pvc3'] = json_encode($pvc3);
     $data['rota1'] = json_encode($rota1);
     $data['rota2'] = json_encode($rota2);

     $data['time_data'] = json_encode($time_data);

     //echo '<pre>',print_r($data),'</pre>';exit;

     $this -> load -> view("line_template",$data);

     //echo '<pre>',print_r(json_encode($measles),true),'</pre>';

   }



}
