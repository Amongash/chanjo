<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Mdl_Facility extends CI_Model {
    var $order = array('id' => 'desc');
    var $column = array('mf.id', 'facility_name', 'officer_incharge', 'vaccine_carrier', 'cold_box', 'subcounty_name', 'county_name', 'region_name');
    var $fridge_columns = array('tbl_facilities.facility_name', 'tbl_facility_fridges.refrigerator_id', 'Model', 'Manufacturer', 'temperature_monitor_no', 'main_power_source');
    var $facility_fridges = array('tbl_facility_fridges.refrigerator_id', 'tbl_fridges.Model', 'tbl_fridges.Manufacturer', 'temperature_monitor_no', 'main_power_source', 'refrigerator_age');

    function __construct() {
        parent::__construct();
    }



    function get_table() {
        $table = "tbl_facilities";
        return $table;
    }

    private function _get_datatables_query($station_id) {

        // $this->db->from($this->get_table());
        $this->search_order($station_id);
    }

    function search_order($station_id) {
        if ($station_id != 'KENYA') {
            $this->db->select($this->column);
            $this->db->from('tbl_facilities mf');
            $this->db->join('tbl_subcounties', 'tbl_subcounties.id = mf.subcounty_id');
            $this->db->join('tbl_counties', 'tbl_counties.id = mf.county_id');
            $this->db->join('tbl_regions', 'tbl_counties.region_id = tbl_regions.id');
            $this->db->join('tbl_facility_details', 'tbl_facility_details.facility_id = mf.id', 'left');
            $this->db->where('county_name', $station_id);
            $this->db->or_where('subcounty_name', $station_id);
            $this->db->or_where('region_name', $station_id);

        } elseif($station_id == 'KENYA') {
            $this->db->select($this->column);
            $this->db->from('tbl_facilities mf');
            $this->db->join('tbl_subcounties', 'tbl_subcounties.id = mf.subcounty_id');
            $this->db->join('tbl_counties', 'tbl_counties.id = mf.county_id');
            $this->db->join('tbl_regions', 'tbl_counties.region_id = tbl_regions.id');
            $this->db->join('tbl_facility_details', 'tbl_facility_details.facility_id = mf.id', 'left');
        }
        $i = 0;

        foreach($this->column as $item) {
            if ($_POST['search']['value'])
            ($i === 0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
            $column[$i] = $item;
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function getFacility($station_id) {

        $this->_get_datatables_query($station_id);
        if ($_POST['length'] != -1) $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function get_fridges_by_id($id) {
        $this->_get_fridges_query($id);
        if ($_POST['length'] != -1) $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($station_id) {
        $this->_get_datatables_query($station_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    private function _get_fridges_query($id) {
        $this->db->select($this->facility_fridges);
        $this->db->from('tbl_facilities');
        $this->db->join('tbl_facility_fridges', 'tbl_facilities.id = tbl_facility_fridges.facility_id');
        $this->db->join('tbl_fridges', 'tbl_facility_fridges.refrigerator_id = tbl_fridges.id');
        $this->db->where('tbl_facilities.id', $id);

        $i = 0;

        foreach($this->facility_fridges as $item) {
            if ($_POST['search']['value'])
            ($i === 0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
            $facility_fridges[$i] = $item;
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($facility_fridges[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }


    function get_fridges($id) {
        $this->db->select($this->fridge_columns);
        $this->db->from('tbl_facilities');
        $this->db->join('tbl_facility_fridges', 'tbl_facilities.id = tbl_facility_fridges.facility_id');
        $this->db->join('tbl_fridges', 'tbl_facility_fridges.refrigerator_id = tbl_fridges.id');
        $this->db->where('tbl_fridges.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_fridge_model() {
        $this->db->select('id, Model, Manufacturer');
        $this->db->from('tbl_fridges');
        $query = $this->db->get();
        return $query->result();
    }


    function count_fridges_filtered($id) {
        $this->_get_fridges_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function getRegion(){

        $this->db->select('id,region_name');
        $query = $this->db->get("tbl_regions");
        return $query->result();
    }

    function loadcountyfromregion($region_id) {

            $query = $this->db->query("SELECT county_name FROM `tbl_counties` WHERE region_id = '{$region_id}'"); 
            if ($query->num_rows > 0) {
                return $query->result();
            }
        }

    function loadsubcountyfromcounty($county_id) {

        $query = $this->db->query("SELECT subcounty_name FROM `tbl_subcounties` WHERE county_id = '{$county_id}'"); 
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }


    function loadfacilityfromsubcouty($subcounty_id) {

        $query = $this->db->query("SELECT facility_name FROM `tbl_facilities` WHERE `subcounty_id` = '{$subcounty_id}'"); 
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }



    function get($order_by) {
        $table = $this->get_table();
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

    function get_with_limit($limit, $offset, $order_by) {
        $table = $this->get_table();
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

    function get_where($id) {
        $this->db->from('tbl_facilities mf');
        $this->db->join('tbl_subcounties', 'tbl_subcounties.id = mf.subcounty_id');
        $this->db->join('tbl_counties', 'tbl_counties.id = mf.county_id');
        $this->db->join('tbl_regions', 'tbl_counties.region_id = tbl_regions.id');
        $this->db->join('tbl_facility_details', 'tbl_facility_details.facility_id = mf.id', 'left');
        $this->db->where('mf.id', $id);
        $query = $this->db->get();
        return $query;
    }

    function get_where_custom($col, $value) {
        $table = $this->get_table();
        $this->db->where($col, $value);
        $query = $this->db->get($table);
        return $query;
    }

    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
    }

    function _update($id, $data) {
        $table = $this->get_table();
        $this->db->where('id', $id);
        $this->db->update($table, $data);
    }

    function _update_details($id, $data) {
        $table = "tbl_facility_details";
        $this->db->where('facility_id', $id);
        $this->db->update($table, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            $query = $this->db->get($table);
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where('facility_id', $id);
            $this->db->limit(1);
            $query = $this->db->get();

            if ($query->num_rows() == 1) {
                return true;
            } else {
                $facility_id = $id;
                $data['facility_id'] = $facility_id;
                $this->db->insert($table, $data);
            }
            
        }

    }

    function _delete($id) {
        $table = $this->get_table();
        $this->db->where('id', $id);
        $this->db->delete($table);
    }

    function _insert_fridge($data) {
        $table = 'tbl_facility_fridges';
        $this->db->insert($table, $data);
    }

    function _update_fridge($id, $data) {
        $table = 'tbl_facility_fridges';
        $this->db->where('refrigerator_id', $id);
        $this->db->update($table, $data);
    }

    function _delete_fridge($id) {
        $table = 'tbl_facility_fridges';
        $this->db->where('refrigerator_id', $id);
        $this->db->delete($table);
    }

    function count_where($column, $value) {
        $table = $this->get_table();
        $this->db->where($column, $value);
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function count_all() {
        $table = $this->get_table();
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function count_fridges($column, $value) {
        $table = "tbl_facility_fridges";
        $this->db->where($column, $value);
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function get_max() {
        $table = $this->get_table();
        $this->db->select_max('id');
        $query = $this->db->get($table);
        $row = $query->row();
        $id = $row->id;
        return $id;
    }

    function _custom_query($mysql_query) {
        $query = $this->db->query($mysql_query);
        return $query;
    }

}