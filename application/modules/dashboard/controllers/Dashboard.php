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


             $user_level = $info['user_object']['user_level'];
             $station_id = $info['user_object']['user_statiton'];



          if ($user_level == '1') {
            $option = '1';
            $data['best'] = $this->best_dpt3cov($station_id, $option);
            $data['worst'] = $this->worst_dpt3cov($station_id, $option);

          } elseif ($user_level == '2') {
            $option = '2';
            $data['best'] = $this->best_dpt3cov($station_id, $option);
            $data['worst'] = $this->worst_dpt3cov($station_id, $option);
          } elseif ($user_level == '3') {
            $option = '3';
            $data['best'] = $this->best_dpt3cov($station_id, $option);
            $data['worst'] = $this->worst_dpt3cov($station_id, $option);
          } else {
            $option = '4';
            $data['best'] = $this->best_dpt3cov($station_id, $option);
            $data['worst'] = $this->worst_dpt3cov($station_id, $option);
          }
          //echo '<pre>',print_r($data),'</pre>';exit;

          $this->load->model('vaccines/mdl_vaccines');
          $this->load->model('users/mdl_user_levels');
          $this->load->model('region/mdl_region');


          //echo '<pre>',print_r($this->mdl_group->get_all()),'</pre>';exit;
          $data['user_levels'] = json_decode(json_encode($this->mdl_user_levels->get_all()),true);
          $data['regions'] = json_decode(json_encode($this->mdl_region->get_all()),true);
          //$data['vaccines'] = json_decode(json_encode($this->mdl_vaccines->get_all()),true);


          $data['vaccines'] = $this->mdl_vaccines->get_vaccine_details();
        $data['section'] = "NVIP-Chanjo";
        $data['view_file'] = "dashboard_new";
        $data['module'] = "dashboard";
        $data['loc'] = $user_level;

        $data['user_level'] = $user_level;
        $data['page_header'] = $station_id;
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        $data['breadcrumb'] = '';
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);

    }

    function best_dpt3cov($station_id, $option){
        $option = $option;
        $station_id = $station_id;

        $this->load->model('mdl_dashboard');

        if ($option == '1') {
           $query = $this->mdl_dashboard->best_region_dpt3();
           //echo '<pre>',print_r($query),'</pre>';exit;
        } elseif ($option == '2') {
            $query = $this->mdl_dashboard->best_county_dpt3($station_id);

        } elseif ($option == '3') {
             $query = $this->mdl_dashboard->best_subcounty_dpt3($station_id);
        } elseif ($option == '4') {
             $query = $this->mdl_dashboard->best_facility_dpt3($station_id);
             //echo '<pre>',print_r(json_encode($station_id),true),'</pre>';exit;
        }
        //echo '<pre>',print_r($query->result()),'</pre>';exit;


        $json_array = array();
        foreach ($query->result() as $row) {
            $data['name'] = $row->name;
            $data['totaldpt3'] = (float)($row->dpt3)*1200;
            $data['totaldpt1'] = (float)($row->dpt1)*1200;
            $data['population'] = (int)$row->population;

            array_push($json_array, $data);

        } // echo '<pre>',print_r($json_array),'</pre>';exit;
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
          $data['totaldpt3'] = (float)($row->dpt3)*1200;
          $data['totaldpt1'] = (float)($row->dpt1)*1200;
          $data['population'] = (int)$row->population;
            array_push($json_array, $data);

        }
        //echo json_encode($json_array);
        return $json_array;

    }


  protected function _station($var){
     $station = str_replace('%20', ' ', $var);
     return $station;
   }


   function vaccineBalance($station='NULL'){
     $info['user_object'] = $this->get_user_object();
     $user_level = $info['user_object']['user_level'];
     if ($station=='NULL') {
       $station = $info['user_object']['user_statiton'];
     }
     $station=str_replace('%20',' ',$station);
     //echo '<pre>',print_r($station),'</pre>';exit;


     $this->load->model('mdl_dashboard');
     $query = $this->mdl_dashboard->get_stock_balance($station);
     $new=json_decode(json_encode($query),true);
     $category_data=[];
     $series_data=[];
     //echo '<pre>',print_r($new),'</pre>';exit;
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
     if (count($series_data)==0) {
       //echo "No data at this time";
     }else {
       $this -> load -> view("dashboard",$data);
     }
     $this -> load -> view("dashboard",$data);


   }

   function vaccineBalancemos($level='NULL' ,$station='NULL'){
     $info['user_object'] = $this->get_user_object();
     $user_level = $info['user_object']['user_level'];

     if ($station=='NULL') {
       $station = $info['user_object']['user_statiton'];
     }
     if ($level=='NULL') {
       $level= $info['user_object']['user_level'];
     }
     $station=str_replace('%20',' ',$station);

     $this->load->model('mdl_dashboard');



     if ($level == 1) {
       $query_population = $this->mdl_dashboard->get_population_national();
       $population=$query_population[0]->population;

     }elseif ($level == 2) {
       $query_population = $this->mdl_dashboard->get_population_region($station);
       $population=$query_population[0]->population;

     }elseif ($level == 3) {
       $query_population  = $this->mdl_dashboard->get_population_county($station);
       $population=$query_population[0]->population;
     }elseif ($level == 4) {
      $query_population = $this->mdl_dashboard->get_population_subcounty($station);
      $population=$query_population[0]->population;
    }else {
      $query_population = $this->mdl_dashboard->get_facility_population($station);
      $population=$query_population[0]->population;

    }
    if ($population==0) {
      echo '<div style="margin:5%;font-size:3em;font-weight:400;"> Error! Please make sure Population for this station is not zero.</div>';exit;
    }


     $query = $this->mdl_dashboard->get_stock_balance($station);


     $new=json_decode(json_encode($query),true);
     $category_data=[];
     $series_data=[];

     foreach ($new as $key =>$value ) {

       $category_data[]=$value['vaccine_name'];
       $series_data[]=(int)$value['balance']/($population/12);

     }


     $data['graph_type'] = 'bar';
     $data['graph_title'] = "Stock Balance (MOS)";
     $data['graph_yaxis_title'] = "Months of Stock";
     $data['graph_id'] = "mos";
     $data['legend'] = "MOS";
     $data['colors'] = "['#008080','#6AF9C4']";
     $data['series_data'] = json_encode($series_data);
     $data['category_data'] =  json_encode($category_data);

     $size=count($series_data);
     for ($i=0; $i <=$size ; $i++) {
       # code...
     }

     if (count($series_data)==0) {
       //echo "No data at this time";
     }else {
       $this -> load -> view("dashboard",$data);
     }
     $this -> load -> view("dashboard",$data);
   }

   function positivecoldchain($level='NULL',$station='NULL'){


     $station=str_replace('%20',' ',$station);

     $info['user_object'] = $this->get_user_object();

     if ($level =='NULL' && $station =='NULL') {
       $data['user_level']  = $info['user_object']['user_level'];
       $station = $info['user_object']['user_statiton'];
       $level= $info['user_object']['user_level'];
     }else {

       $data['user_level']  = $level;
       $station = $station;
     }

     $this->load->model('mdl_dashboard');

     if ($level=='1') {

       $query_total = $this->mdl_dashboard->get_vaccine_volume($station);
       $query_opv = $this->mdl_dashboard->get_opv_vaccine_volume($station);
       $total_capacity = $this->mdl_dashboard->get_fridge_cold_chain_capacity($station);

     }elseif ($level == '2') {

       $query_total = $this->mdl_dashboard->get_vaccine_volume($station);
       $query_opv = $this->mdl_dashboard->get_opv_vaccine_volume($station);
       $total_capacity = $this->mdl_dashboard->get_fridge_cold_chain_capacity($station);

     }elseif ($level == '3') {

       $query_total = $this->mdl_dashboard->get_vaccine_volume($station);
       $query_opv = $this->mdl_dashboard->get_opv_vaccine_volume($station);
       $total_capacity = $this->mdl_dashboard->get_fridge_cold_chain_capacity($station);
     }elseif ($level == '4') {

       $query_total = $this->mdl_dashboard->get_vaccine_volume($station);
       $query_opv = $this->mdl_dashboard->get_opv_vaccine_volume($station);
       $total_capacity = $this->mdl_dashboard->get_fridge_cold_chain_capacity($station);
    }else {
      echo '<div style="margin:5%;font-size:3em;font-weight:400;"> </div>';exit;

    }
  //  echo '<pre>',print_r($query_total),'</pre>';
  //  echo '<pre>',print_r($query_opv),'</pre>';
  //  echo '<pre>',print_r($total_capacity),'</pre>';exit;


     $query_total=json_decode(json_encode($query_total),true);
     $query_opv=json_decode(json_encode($query_opv),true);
     $total_capacity=json_decode(json_encode($total_capacity),true);
     $positivecoldchain=$query_total[0]['volume']-$query_opv[0]['volume'];
     $opv_volume=$query_opv[0]['volume'];
     $unusedcapacity=$total_capacity[0]['total_volume']-$positivecoldchain;

     $data['graph_title'] = "+ve Cold Chain Capacity";
     $data['graph_id'] = "positive";
     $data['legend'] = "Litres";
     $data['colors'] = "['#008080','#6AF9C4']";
     $data['piedata'] = json_encode((float)$positivecoldchain);
     $data['remaining_volume'] = json_encode((float)$unusedcapacity);
     $this -> load -> view("pie_template",$data);
   }

   function negativecoldchain($level='NULL',$station='NULL'){

     $station=str_replace('%20',' ',$station);

     $info['user_object'] = $this->get_user_object();

     if ($level =='NULL' && $station =='NULL') {
       $data['user_level']  = $info['user_object']['user_level'];
       $station = $info['user_object']['user_statiton'];
       $level= $info['user_object']['user_level'];
     }else {

       $data['user_level']  = $escalate;
       $station = $station;
     }


     $this->load->model('mdl_dashboard');
     $query_opv = $this->mdl_dashboard->get_opv_vaccine_volume($station);
     $total_capacity = $this->mdl_dashboard->get_freezer_cold_chain_capacity($station);
     $total_capacity=json_decode(json_encode($total_capacity),true);
     $query_opv=json_decode(json_encode($query_opv),true);
     $negativecoldchain=$query_opv[0]['volume'];
     $unusedcapacity=$total_capacity[0]['total_volume']-$query_opv[0]['volume'];

     $data['graph_title'] = "-ve Cold Chain Capacity 2016 to May";
     $data['graph_id'] = "negative";
     $data['legend'] = "Litres";
     $data['colors'] = "['#008080','#6AF9C4']";
     $data['remaining_volume'] = json_encode((float)$unusedcapacity);
     $data['piedata'] = json_encode((float)$negativecoldchain);
     $this -> load -> view("pie_template",$data);
   }

   function coverage($level='NULL',$station='NULL'){

     $info['user_object'] = $this->get_user_object();
     $user_level = $info['user_object']['user_level'];
     $this->load->model('mdl_dashboard');
     $maxdate=date('Y-m-d');
     $mindate=new DateTime(date('Y-m-d'));
     $interval = new DateInterval('P12M');
     $mindate=$mindate->sub($interval)->format('Y-m-d');

     if ($level =='NULL' && $station =='NULL') {
       $data['user_level']  = $info['user_object']['user_level'];
       $station = $info['user_object']['user_statiton'];
       $level= $info['user_object']['user_level'];
     }else {

       $data['user_level']  = $level;
       $station_id = $station;
     }


     $station=str_replace('%20',' ',$station);

     $this->load->model('mdl_dashboard');


     if ($level == 1) {

       $query = $this->mdl_dashboard->get_national_coverage($maxdate,$mindate);

     }elseif ($level == 2) {

       $query = $this->mdl_dashboard->get_region_coverage($maxdate,$mindate,$station);

     }elseif ($level == 3) {

       $query = $this->mdl_dashboard->get_county_coverage($maxdate,$mindate,$station);

     }elseif ($level == 4) {

      $query = $this->mdl_dashboard->get_subcounty_coverage($maxdate,$mindate,$station);

    }else {

      return $this->coverageFacility($station);

    }



      $query=json_decode(json_encode($query),true);



     //echo '<pre>',print_r($query),'</pre>';exit;

     $category_data=[];
     $bcg=[]; $dpt1=[]; $dpt2=[];  $dpt3=[];  $measles1=[]; $measles2=[]; $measles3=[]; $opv1=[];  $opv2=[]; $opv3=[];
     $pvc1=[];  $pvc2=[]; $pvc3=[]; $rota1=[]; $rota2=[];

     foreach ($query as $key =>$value ) {
       $time_data[]=date('M-Y',strtotime($value['months']));
       $bcg[]=(float)$value['bcg']*1200;
       $dpt1[]=(float)$value['dpt1']*1200;
       $dpt2[]=(float)$value['dpt2']*1200;
       $dpt3[]=(float)$value['dpt3']*1200;
       $measles1[]=(float)$value['measles1']*1200;
       $measles2[]=(float)$value['measles2']*1200;
       $measles3[]=(float)$value['measles3']*1200;
       $opv1[]=(float)$value['opv1']*1200;
       $opv2[]=(float)$value['opv2']*1200;
       $opv3[]=(float)$value['opv3']*1200;
       $pvc1[]=(float)$value['pcv1']*1200;
       $pvc2[]=(float)$value['pcv2']*1200;
       $pvc3[]=(float)$value['pcv3']*1200;
       $rota1[]=(float)$value['rota1']*1200;
       $rota2[]=(float)$value['rota2']*1200;

     }
     //echo '<pre>',print_r($time_data),'</pre>';exit;
     $data['graph_title'] = "Coverage";
     $data['graph_id'] = "mycoverage";
     $data['legend'] = "units here";
     $data['colors'] = "['#008080','#6AF9C4']";


     $data['bcg'] = json_encode($bcg);
     $data['dpt1'] = json_encode($dpt1);
     $data['dpt2'] = json_encode($dpt2);
     $data['dpt3'] = json_encode($dpt3);
     $data['measles1'] = json_encode($measles1);
     $data['measles2'] = json_encode($measles2);
     $data['measles3'] = json_encode($measles3);
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

   function coverageFacility($station='NULL'){
     $info['user_object'] = $this->get_user_object();
     if ($station =='NULL' ) {
       $user_level = $info['user_object']['user_level'];
       $station = $info['user_object']['user_statiton'];

         }
     $this->load->model('mdl_dashboard');
     $maxdate=date('Y-m-d');
     $mindate=new DateTime(date('Y-m-d'));
     $interval = new DateInterval('P12M');
     $mindate=$mindate->sub($interval)->format('Y-m-d');
    //echo '<pre>',print_r($maxdate),'</pre>';exit;
     $query = $this->mdl_dashboard->get_facility_coverage($station,$mindate,$maxdate);
     $query=json_decode(json_encode($query),true);
     //

     if ($query[0]['population']==0 || $query[0]['population']=='') {
       $population = $this->mdl_dashboard->get_facility_population($station);
       $pop=json_decode(json_encode($population),true);
       $population=(int)$pop[0]['population'];
     }else {
       $population=(int)$query[0]['population'];
     }

     $target=[];
     $noMonths=12;
     for ($i=0; $i <$noMonths ; $i++) {
       $target[]=ceil($population/$noMonths);
     }
    // $cumulative=[];
    // $runningSum = 0;

    //  foreach ($target as $number) {
        //  $runningSum += $number;
      //    $cumulative[] = $runningSum;
    //  }

      for ($i = 1; $i <= 12; $i++) {
    $months[] = date("M Y", strtotime( date( 'Y-m-01' )." -$i months"));
  }//echo '<pre>',print_r(array_reverse($months)),'</pre>';exit;


     $bcg=[]; $dpt1=[]; $dpt2=[];  $dpt3=[];  $measles1=[]; $measles2=[]; $measles3=[]; $opv1=[];  $opv2=[]; $opv3=[];
     $pvc1=[];  $pvc2=[]; $pvc3=[]; $rota1=[]; $rota2=[];

     foreach ($query as $key =>$value ) {
       $time_data[]=$value['months'];
       $bcg[]=(int)$value['bcg'];
       $dpt1[]=(int)$value['dpt1'];
       $dpt2[]=(int)$value['dpt2'];
       $dpt3[]=(int)$value['dpt3'];
       $measles1[]=(int)$value['measles1'];
       $measles2[]=(int)$value['measles2'];
       $measles3[]=(int)$value['measles3'];
       $opv1[]=(int)$value['opv1'];
       $opv2[]=(int)$value['opv2'];
       $opv3[]=(int)$value['opv3'];
       $pvc1[]=(int)$value['pcv1'];
       $pvc2[]=(int)$value['pcv2'];
       $pvc3[]=(int)$value['pcv3'];
       $rota1[]=(int)$value['rota1'];
       $rota2[]=(int)$value['rota2'];

     }

     $data['graph_title'] = "Facility Coverage";
     $data['graph_id'] = "coverage";
     $data['legend'] = "units here";
     $data['colors'] = "['#008080','#6AF9C4']";


     $data['bcg'] = json_encode($bcg);
     $data['dpt1'] = json_encode($dpt1);
     $data['dpt2'] = json_encode($dpt2);
     $data['dpt3'] = json_encode($dpt3);
     $data['measles1'] = json_encode($measles1);
     $data['measles2'] = json_encode($measles2);
     $data['measles3'] = json_encode($measles3);
     $data['opv1'] = json_encode($opv1);
     $data['opv2'] = json_encode($opv2);
     $data['opv3'] = json_encode($opv3);
     $data['pvc1'] = json_encode($pvc1);
     $data['pvc2'] = json_encode($pvc2);
     $data['pvc3'] = json_encode($pvc3);
     $data['rota1'] = json_encode($rota1);
     $data['rota2'] = json_encode($rota2);
     $data['cumulative'] = json_encode($target);

     $data['time_data'] = json_encode(array_reverse($months));

     //echo '<pre>',print_r($data),'</pre>';exit;

      $this -> load -> view("facility_coverage",$data);

    }

     function best($escalate,$name){
       $name=str_replace('%20',' ',$name);

       $info['user_object'] = $this->get_user_object();

       if ($escalate =='NULL' && $name =='NULL') {
         $data['user_level']  = $info['user_object']['user_level'];
         $station_id = $info['user_object']['user_statiton'];
         $escalate= $info['user_object']['user_level'];
       }else {

         $data['user_level']  = $escalate;
         $station_id = $name;
       }

      // echo '<pre>',print_r($station_id),'</pre>';exit;


       if ($escalate == '1') {
         $option = '1';
         $data['best'] = $this->best_dpt3cov($station_id, $option);

       } elseif ($escalate == '2') {
         $option = '2';
         $data['best'] = $this->best_dpt3cov($station_id, $option);
       } elseif ($escalate == '3') {
         $option = '3';
         $data['best'] = $this->best_dpt3cov($station_id, $option);
       } else {
         $option = '4';
         $data['best'] = $this->best_dpt3cov($station_id, $option);
       }


       $this -> load -> view("coverage_performance",$data);


     }

     function worst($escalate,$name){

       $name=str_replace('%20',' ',$name);

       $info['user_object'] = $this->get_user_object();

       if ($escalate =='NULL' && $name =='NULL') {
         $data['user_level']  = $info['user_object']['user_level'];
         $station_id = $info['user_object']['user_statiton'];
         $escalate= $info['user_object']['user_level'];
       }else {

         $data['user_level']  = $escalate;
         $station_id = $name;
       }


       if ($escalate == '1') {
         $option = '1';
         $data['worst'] = $this->worst_dpt3cov($station_id, $option);

       } elseif ($escalate == '2') {
         $option = '2';
         $data['worst'] = $this->worst_dpt3cov($station_id, $option);
       } elseif ($escalate == '3') {
         $option = '3';
         $data['worst'] = $this->worst_dpt3cov($station_id, $option);
       } else {
         $option = '4';
         $data['worst'] = $this->worst_dpt3cov($station_id, $option);
       }


       $this -> load -> view("coverage_worst",$data);


     }

     function cumulative_coverage($level='NULL',$station='NULL',$vaccine='NULL',$region_id='NULL',$county_id='NULL',$subcounty_id='NULL'){
       $info['user_object'] = $this->get_user_object();
       $user_level = $info['user_object']['user_level'];
       $this->load->model('mdl_dashboard');
       $maxdate=date('Y-m-d');
       $mindate=new DateTime(date('Y-m-d'));
       $interval = new DateInterval('P12M');
       $mindate=$mindate->sub($interval)->format('Y-m-d');

       if ($level =='NULL' || $level =='undefined') {

         $data['user_level']  = $info['user_object']['user_level'];
         $level= $info['user_object']['user_level'];
       }else {

         $data['user_level']  = $level;
       }

       if ($vaccine =='NULL') {
         $vaccine = 'bcg';
       }

       if ($station =='NULL') {
         $station = $info['user_object']['user_statiton'];
       }



       $station=str_replace('%20',' ',$station);
       $vaccine=str_replace('%20',' ',$vaccine);
       $vaccine=str_replace('%60','`',$vaccine);

       $this->load->model('mdl_dashboard');


       if ($level==1) {

         $query = $this->mdl_dashboard->cumulative_coverage_national($maxdate,$mindate,$vaccine);
         $query_population = $this->mdl_dashboard->get_population_national();
         $population=$query_population[0]->population;



       }elseif ($level == 2) {
         $column_id='region_id';

         $query = $this->mdl_dashboard->cumulative_coverage($maxdate,$mindate,$vaccine,$region_id,$column_id);
         $query_population = $this->mdl_dashboard->get_population_region($station);
         $population=$query_population[0]->population;
         //echo '<pre>',print_r($query_population),'</pre>';exit;

       }elseif ($level == 3) {
         $column_id='county_id';

         $query = $this->mdl_dashboard->cumulative_coverage($maxdate,$mindate,$vaccine,$county_id,$column_id);
         $query_population = $this->mdl_dashboard->get_population_county($station);
         $population=$query_population[0]->population;

       }elseif ($level == 4) {
         $column_id='subcounty_id';

         $query = $this->mdl_dashboard->cumulative_coverage($maxdate,$mindate,$vaccine,$subcounty_id,$column_id);
         $query_population = $this->mdl_dashboard->get_population_subcounty($station);
         $population=$query_population[0]->population;

      }else {
        $column_id='facility_name';

        $query = $this->mdl_dashboard->cumulative_coverage($maxdate,$mindate,$vaccine,$station,$column_id);
        $query_population = $this->mdl_dashboard->get_facility_population($station);

        $population=$query_population[0]->population;
        //echo '<pre>',print_r(($population)),'</pre>';exit;

      }



      $cumulative_antigen_administered=[];
      $cumulative_population=[];

      $runningSum = 0;
      $runningpop = 0;

         foreach ($query as $number => $key) {
             $runningSum += $key->antigen;
             $time_data[]=date('M-Y',strtotime($key->months));
             $cumulative_antigen_administered[] = $runningSum;
             $runningpop += ceil($population/12);
             $cumulative_population[] = $runningpop;
         }

         $data['cumulative_antigen_administered'] = json_encode($cumulative_antigen_administered);
         $data['cumulative_population'] = json_encode($cumulative_population);
         $data['colors'] = "['#008080','#6AF9C4']";
         //$data['graph_title'] = "Stock Balance";
         //$data['graph_yaxis_title'] = "Stock Balance";
         $data['graph_id'] = "coverage_cumulative";
         $data['vaccine'] = json_encode($vaccine.' doses Administered');
         $data['station'] = json_encode($vaccine.' Cumulative Coverage for '.$station);



         $data['time_data'] = json_encode($time_data);


      //echo '<pre>',print_r(json_encode($vaccine)),'</pre>';exit;

       $this -> load -> view("dashboard/cumulative_line",$data);

       //echo '<pre>',print_r(json_encode($measles),true),'</pre>';

     }



}
