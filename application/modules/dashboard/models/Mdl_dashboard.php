<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Mdl_dashboard extends CI_Model
{
    var $order = array('id' => 'desc');
    var $column = array('Months', 'Above2yrs', 'Above1yr');


    function __construct()
    {
        parent::__construct();
    }


    function vaccine(){
        $this->db->select('vaccine_name');
        $query = $this->db->get('tbl_vaccines');
        return $query->result();
    }

   function get_stock_balance_where($station_id, $vaccine)
    {
        $this->db->select('vaccine_name, stock_balance');
        $this->db->from('vaccine_stockbalance');
        $array = array('station_id' => $station_id, 'vaccine_name' => $vaccine);
        $this->db->where($array);
        $query = $this->db->get();
        return $query->result();
    }
    function get_stock_balance($station)
    {
        $this->db->select('vaccine_name, sum(balance) as balance');
        $this->db->from('v_vaccine_balance');
        $this->db->where('station',$station);
        $this->db->group_by('vaccine_name');
        $query = $this->db->get();
        return $query->result();
    }



    function get_stock_mos($station)
    {

      $this->db->select('vaccine_name, sum(balance) as balance');
      $this->db->from('v_vaccine_balance');
      $this->db->where('station',$station);
      $this->db->group_by('vaccine_name');
      $query = $this->db->get();
      return $query->result();

    }

    function get_doses_administered_where($user_level, $station_id, $vaccine)
    {
        $this->db->select(''.$vaccine.'');
        if ($user_level == 1) {
            $this->db->from('county_doses_administered');
        } elseif ($user_level == 2) {
            $this->db->from('county_doses_administered');
        } elseif($user_level == 3) {
            $this->db->from('county_doses_administered');
        } elseif ($user_level == 4) {
            $this->db->from('subcounty_doses_administered');
        }elseif ($user_level == 5) {
            $this->db->from('facility_doses_administered');
        }
        $array = array('station_id' => $station_id);
        $this->db->where($array);
        $query = $this->db->get();
        return $query->result();
    }

    function get_facility_coverage($facility_name,$mindate,$maxdate)
    {
        $this->db->select("date_format(`periodname`,'%M %Y') as months,(`measles 1`) as measles1,(`measles 2`) as measles2,(`measles 3`) as measles3, bcg,dpt1,dpt2,dpt3,opv,opv1,opv2,opv3,pcv1,pcv2,pcv3,rota1,rota2,population");
        $this->db->from('v_coverage_overview');
        $this->db->where('facility_name', $facility_name);
        $this->db->where('periodname >=', $mindate);
        $this->db->where('periodname <=', $maxdate);
        $this->db->order_by(`periodname`,'asc');
        $query = $this->db->get();

        return $query->result();
    }






    function get_subcounty_coverage($maxdate,$mindate,$station)
    {

        $this->db->select("date_format(`months`,'%M %Y') as months, bcg,dpt1,dpt2,dpt3,(`measles 1`) as measles1,(`measles 2`) as measles2,(`measles 3`) as measles3,opv,opv1,opv2,opv3,pcv1,pcv2,pcv3,rota1,rota2,subcounty_name");
        $this->db->from('v_subcounties_coverage');
        $this->db->where('subcounty_name', $station);
        $this->db->where('months >=', $mindate);
        $this->db->where('months <=', $maxdate);
        $this->db->order_by(`months`,'asc');
        $query = $this->db->get();

        return $query->result();
    }

    function get_county_coverage($maxdate,$mindate,$station)
    {
        $this->db->select("date_format(`months`,'%M %Y') as months, bcg,dpt1,dpt2,dpt3,(`measles 1`) as measles1,(`measles 2`) as measles2,(`measles 3`) as measles3,opv,opv1,opv2,opv3,pcv1,pcv2,pcv3,rota1,rota2,county_name");
        $this->db->from('v_counties_coverage');
        $this->db->where('county_name', $station);
        $this->db->where('months >=', $mindate);
        $this->db->where('months <=', $maxdate);
        $this->db->order_by(`months`,'asc');
        $query = $this->db->get();

          return $query->result();
    }

    function get_national_coverage($maxdate,$mindate)
    {

      $this->db->select("date_format(`periodname`,'%M %Y') as months,(`measles 1`) as measles1,(`measles 2`) as measles2,(`measles 3`) as measles3, bcg,dpt1,dpt2,dpt3,opv,opv1,opv2,opv3,pcv1,pcv2,pcv3,rota1,rota2,population");
      $this->db->from('v_coverage_national');
      $this->db->where('periodname >=', $mindate);
      $this->db->where('periodname <=', $maxdate);
      $this->db->order_by(`periodname`,'asc');
      $query = $this->db->get();
      return $query->result();

    }
    function get_region_coverage($maxdate,$mindate,$station)
    {

      $this->db->select("date_format(`months`,'%M %Y') as months,(`measles 1`) as measles1,(`measles 2`) as measles2,(`measles 3`) as measles3, bcg,dpt1,dpt2,dpt3,opv,opv1,opv2,opv3,pcv1,pcv2,pcv3,rota1,rota2,population");
      $this->db->from('v_regions_coverage');
      $this->db->where('months >=', $mindate);
      $this->db->where('months <=', $maxdate);
      $this->db->where('region_name', $station);
      $this->db->order_by(`months`,'asc');
      $query = $this->db->get();
      return $query->result();

    }

    function best_region_dpt3()
    {
        $this->db->select('region_name as name,population,dpt1,dpt3');
        $this->db->order_by('dpt3', 'desc');
        $this->db->limit(3);
        $query = $this->db->get('v_regions_coverage');

        return $query;
    }

    function worst_region_dpt3()
    {
        $this->db->select('region_name as name,population,dpt1,dpt3');
        $this->db->order_by('dpt3', 'asc');
        $this->db->limit(3);
        $query = $this->db->get('v_regions_coverage');

        return $query;
    }

    function best_county_dpt3($station_id)
    {
        $this->db->select('county_name as name,population,dpt1,dpt3');
        $this->db->where('region_name', $station_id);
        $this->db->order_by('dpt3', 'desc');
        $this->db->limit(3);
        $query = $this->db->get('v_counties_coverage');

        return $query;
    }

    function worst_county_dpt3($station_id)
    {
        $this->db->select('county_name as name,population,dpt1,dpt3');
        $this->db->where('region_name', $station_id);
        $this->db->order_by('dpt3', 'asc');
        $this->db->limit(3);
        $query = $this->db->get('v_counties_coverage');

        return $query;
    }

    function best_subcounty_dpt3($station_id)
    {
        $this->db->select('subcounty_name as name,population,dpt1,dpt3');
        $this->db->where('county_name', $station_id);
        $this->db->order_by('dpt3', 'desc');
        $this->db->limit(3);
        $query = $this->db->get('v_subcounties_coverage');

        return $query;
    }

    function worst_subcounty_dpt3($station_id)
    {
        $this->db->select('subcounty_name as name,population,dpt1,dpt3');
        $this->db->where('county_name', $station_id);
        $this->db->order_by('dpt3', 'asc');
        $this->db->limit(3);
        $query = $this->db->get('v_subcounties_coverage');

        return $query;
    }


    function best_facility_dpt3($station_id)
    {
        $this->db->select('facility_name as name,dpt1,dpt3');
        $this->db->where('subcounty_name', $station_id);
        $this->db->order_by('dpt3', 'desc');
        $this->db->limit(3);
        $query = $this->db->get('v_facilities_utilization');

        return $query;
    }

    function worst_facility_dpt3($station_id)
    {
        $this->db->select('facility_name as name,dpt1,dpt3');
        $this->db->where('subcounty_name', $station_id);
        $this->db->order_by('dpt3', 'asc');
        $this->db->limit(3);
        $query = $this->db->get('v_facilities_utilization');;

        return $query;
    }
    function get_vaccine_volume_national($station)
    {
      $this->db->select('sum(balance*vaccine_volume)/1000 as volume');
      $this->db->from('v_vaccine_balance');
      $this->db->where('station', $station);
      $query = $this->db->get();
      return $query->result();

    }
    function get_opv_vaccine_volume_national($station)
    {
      $this->db->select('sum(balance*vaccine_volume)/1000 as volume');
      $this->db->from('v_vaccine_balance');
      $this->db->where('vaccine_name', 'OPV');
      $this->db->where('station', $station);
      $query = $this->db->get();
      return $query->result();

    }
    function get_fridge_cold_chain_capacity_national($station)
    {
      $this->db->select('sum(vaccine_storage_volume) as total_volume');
      $this->db->from('v_fridges_overview');
      $this->db->where('refrigerator_status', 'Functional');
    //  $this->db->where('freezer_capacity' , 'No');
      $this->db->where('location', $station);
      $query = $this->db->get();
      return $query->result();

    }
    function get_freezer_cold_chain_capacity_national()
    {
      $this->db->select('sum(vaccine_storage_volume) as total_volume');
      $this->db->from('v_fridges_overview');
      $this->db->where('refrigerator_status', 'Functional');
      $this->db->where('freezer_capacity' , 'Yes');
      $query = $this->db->get();
      return $query->result();

    }

    function get_population_national()
    {
      $this->db->select('sum(under_one_population) as population');
      $this->db->from('tbl_regions');
      $query = $this->db->get();
      return $query->result();
    }

    function get_population_region($station)
    {
      $this->db->select('sum(under_one_population) as population');
      $this->db->from('tbl_regions');
      $this->db->where('region_name', $station);
      $query = $this->db->get();
      return $query->result();
    }
    function get_population_county($station)
    {
      $this->db->select('sum(under_one_population) as population');
      $this->db->from('tbl_counties');
      $this->db->where('county_name', $station);
      $query = $this->db->get();
      return $query->result();
    }
    function get_population_subcounty($station)
    {
      $this->db->select('sum(under_one_population) as population');
      $this->db->from('tbl_subcounties');
      $this->db->where('subcounty_name', $station);
      $query = $this->db->get();
      return $query->result();
    }


    function get_facility_population($station)
    {
        $this->db->select('under_one_population');
        $this->db->from('tbl_facilities');
        $this->db->where('facility_name', $station);
        $this->db->limit(1);
        $query = $this->db->get();

        return $query->result();
    }


}
