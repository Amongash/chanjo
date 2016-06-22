<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Mdl_region extends CI_Model {

    var $order = array('region_name' => 'desc');
    var $column = array('id', 'region_name', 'manager', 'manager_phone', 'manager_email',);

    function __construct() {
        parent::__construct();
    }

    function get_table() {
	    $table = "tbl_regions";
	    return $table;
	}
  function get_all(){
  $table = $this->get_table();
  $query=$this->db->get($table);
  return $query->result();
  }

    function get_regions() {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_datatables_query() {

        $this->db->from('tbl_regions');
        $this->db->join('tbl_region_details', 'tbl_region_details.region_id = tbl_regions.id', 'left');
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

    function count_filtered() {
        $this->_get_datatables_query();
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
        $table = $this->get_table();
        $this->db->join('tbl_region_details', 'tbl_region_details.region_id = tbl_regions.id', 'left');
        $this->db->where('id', $id);
        $query = $this->db->get($table);
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

    function _insert_details($data) {
        $table = "tbl_region_details";
        $this->db->insert($table, $data);
    }

    function _update($id, $data) {
        $table = $this->get_table();
        $this->db->where('id', $id);
        $this->db->update($table, $data);
    }

    function _update_details($id, $data) {
        $table = "tbl_region_details";
        $this->db->where('region_id', $id);
        $this->db->update($table, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            $region_id = $id;
            $data['region_id'] = $region_id;
            $this->db->insert($table, $data);
        }
    }

    function _delete($id) {
        $table = $this->get_table();
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

    function count_all() {
        $table = $this->get_table();
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
