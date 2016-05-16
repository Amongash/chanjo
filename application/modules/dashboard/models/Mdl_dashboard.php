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






    function get_subcounty_coverage($id)
    {

        $this->db->select('months, bcg,dpt1,dpt2,dpt3,measles,opv,opv1,opv2,opv3,pcv1,pcv2,pcv3,rota1,rota2,subcounty_name');
        $this->db->from('v_subcounties_coverage');
        $this->db->where('subcounty_name', $id);
        $this->db->order_by('months');
        $query = $this->db->get();

        return $query;
    }

    function get_county_coverage($id)
    {
        $this->db->select('months, bcg,dpt1,dpt2,dpt3,measles,opv,opv1,opv2,opv3,pcv1,pcv2,pcv3,rota1,rota2,county_name');
        $this->db->from('v_counties_coverage');
        $this->db->where('county_name', $id);
        $this->db->order_by('months');
        $query = $this->db->get();

        return $query;
    }

    function get_region_coverage($id)
    {
        $this->db->select('months, bcg,dpt1,dpt2,dpt3,measles,opv,opv1,opv2,opv3,pcv1,pcv2,pcv3,rota1,rota2,region_name');
        $this->db->from('v_regions_coverage');
        $this->db->where('region_name', $id);
        $this->db->order_by('months');
        $query = $this->db->get();

        return $query;
    }

    function get_national_coverage()
    {

      $this->db->select('*');
      $this->db->from('v_coverage_national');
      $query = $this->db->get();
      return $query->result();

    }

    function best_region_dpt3()
    {
        $this->db->select('region_name as name,dpt1,dpt3');
        $this->db->order_by('dpt3', 'desc');
        $this->db->limit(3);
        $query = $this->db->get('v_regions_coverage');

        return $query;
    }

    function worst_region_dpt3()
    {
        $this->db->select('region_name as name,dpt1,dpt3');
        $this->db->order_by('dpt3', 'asc');
        $this->db->limit(3);
        $query = $this->db->get('v_regions_coverage');

        return $query;
    }

    function best_county_dpt3($station_id)
    {
        $this->db->select('county_name as name,dpt1,dpt3');
        $this->db->where('region_name', $station_id);
        $this->db->order_by('dpt3', 'desc');
        $this->db->limit(3);
        $query = $this->db->get('v_counties_coverage');

        return $query;
    }

    function worst_county_dpt3($station_id)
    {
        $this->db->select('county_name as name,dpt1,dpt3');
        $this->db->where('region_name', $station_id);
        $this->db->order_by('dpt3', 'asc');
        $this->db->limit(3);
        $query = $this->db->get('v_counties_coverage');

        return $query;
    }

    function best_subcounty_dpt3($station_id)
    {
        $this->db->select('subcounty_name as name,dpt1,dpt3');
        $this->db->where('county_name', $station_id);
        $this->db->order_by('dpt3', 'desc');
        $this->db->limit(3);
        $query = $this->db->get('v_subcounties_coverage');

        return $query;
    }

    function worst_subcounty_dpt3($station_id)
    {
        $this->db->select('subcounty_name as name,dpt1,dpt3');
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
    function get_vaccine_volume_national()
    {
      $this->db->select('sum(balance*vaccine_volume)/1000 as volume');
      $this->db->from('v_vaccine_balance');
      $query = $this->db->get();
      return $query->result();

    }
    function get_opv_vaccine_volume_national()
    {
      $this->db->select('sum(balance*vaccine_volume)/1000 as volume');
      $this->db->from('v_vaccine_balance');
      $this->db->where('vaccine_name', 'OPV');
      $query = $this->db->get();
      return $query->result();

    }
    function get_fridge_cold_chain_capacity_national()
    {
      $this->db->select('sum(vaccine_storage_volume) as total_volume');
      $this->db->from('v_fridges_overview');
      $this->db->where('refrigerator_status', 'Functional');
      $this->db->where('freezer_capacity' , 'No');
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


}
