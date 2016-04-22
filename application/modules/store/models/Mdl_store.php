<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Mdl_Store extends CI_Model {
    var $order = array('id' => 'desc');
    var $column = array('id', 'location','officer','officer_phone', 'station'); 
    var $fridge_columns = array('tbl_store_fridges.id', 'Model', 'Manufacturer', 'temperature_monitor_no', 'main_power_source');
    var $store_fridges = array('tbl_store_fridges.id','tbl_store_fridges.fridge_id', 'tbl_fridges.Model', 'tbl_fridges.Manufacturer', 'temperature_monitor_no', 'main_power_source', 'age', 'refrigerator_status');

    function __construct() {
        parent::__construct();
    }



    function get_table() {
        $table = "tbl_stores";
        return $table;
    }
    function get_stores($station,$option) {
        $this->_get_datatables_query($station,$option);
        if ($_POST['length'] != -1) $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_datatables_query($station,$option) {

        if($option==1){
            $this->db->select($this->column);
            $this->db->from($this->get_table());
            $this->db->where('station', $station);
        }elseif($option==2){
            $this->db->select($this->column);
            $this->db->from($this->get_table());
            $this->db->where('station !=', $station);
        }

        $i = 0;

        foreach($this->column as $item) {
           if ($_POST['search']['value'])
            //($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
            if ($i === 0) {
                $this->db->like($item, $_POST['search']['value']) && $this->db->or_like($item, $_POST['search']['value']);
                $this->db->where('station', $station);
            }
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


    function get_fridges_by_id($store_id) {
        $this->_get_fridges_query($store_id);
        if ($_POST['length'] != -1) $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($station,$option) {
        $this->_get_datatables_query($station,$option);
        $query = $this->db->get();
        return $query->num_rows();
    }

    private function _get_fridges_query($store_id) {
        $this->db->select($this->store_fridges);
        $this->db->from('tbl_stores');
        $this->db->join('tbl_store_fridges', 'tbl_store_fridges.store_id = tbl_stores.id');
        $this->db->join('tbl_fridges', 'tbl_store_fridges.fridge_id = tbl_fridges.id');
        $this->db->where('tbl_stores.id', $store_id);

        $i = 0;

        foreach($this->store_fridges as $item) {
            if ($_POST['search']['value'])
            ($i === 0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
            $store_fridges[$i] = $item;
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($store_fridges[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_fridges($id) {
        $this->db->from('tbl_store_fridges');
        $this->db->where('tbl_store_fridges.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_fridge_model() {
        $this->db->select('id, Model, Manufacturer');
        $this->db->from('tbl_fridges');
        $query = $this->db->get();
        return $query->result();
    }


    function count_fridges_filtered($store_id) {
        $this->_get_fridges_query($store_id);
        $query = $this->db->get();
        return $query->num_rows();
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
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_store_fridges');
        return $query->result();
    }
    function get_store($id){
        $table = $this->get_table();
        $this->db->where('id', $id);
        $query=$this->db->get($table);
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

    function _delete($id) {
        $table = $this->get_table();
        $this->db->where('id', $id);
        $this->db->delete($table);
    }

    function _insert_fridge($data) {
        $table = 'tbl_store_fridges';
        $this->db->insert($table, $data);
    }

    function _update_fridge($id, $data) {
        $table = 'tbl_store_fridges';
        $this->db->where('id', $id);
        $this->db->update($table, $data);
    }

    function _delete_fridge($id) {
        $table = 'tbl_store_fridges';
        $this->db->where('id', $id);
        $this->db->delete($table);
    }

    function count_where($column, $value) {
        $table = $this->get_table();
        $this->db->where($column, $value);
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function count_all($station) {
        $table = $this->get_table();
        $this->db->where('station', $station);
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function count_fridges($store_id) {
        $table = "tbl_store_fridges";
        $this->db->where('store_id', $store_id);
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