<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Mdl_vaccines extends CI_Model {

function __construct() {
parent::__construct();
}

function get_table() {
    $table = "tbl_vaccines";
    return $table;
}
function get_all_vaccines(){
$table = $this->get_table();
$query=$this->db->get($table);
return $query->result();
}

function getVaccine(){

        $call_procedure="call get_vaccines()";
        $query=$this->db->query($call_procedure);
        $query->next_result();
        return $query->result_array();
    }
    function get_vaccine_details(){
        $this->db->select('id,vaccine_name, vaccine_formulation,mode_administration');
        $this->db->order_by('vaccine_name','asc');
        $query = $this->db->get('tbl_vaccines');
        return $query->result_array();
    }


function get($order_by){
$table = $this->get_table();
$this->db->order_by($order_by);
$query=$this->db->get($table);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$table = $this->get_table();
$this->db->limit($limit, $offset);
$this->db->order_by($order_by);
$query=$this->db->get($table);
return $query;
}

function get_all($id){
$table = $this->get_table();
$this->db->where('id', $id);
$query=$this->db->get($table);
return $query;
}

function get_where($id){
$table = $this->get_table();
$this->db->select('vaccine_name');
$this->db->where('id', $id);
$query=$this->db->get($table);
return $query;
}

function get_where_custom($col, $value) {
$table = $this->get_table();
$this->db->where($col, $value);
$query=$this->db->get($table);
return $query;
}

function _insert($data){
$table = $this->get_table();
$this->db->insert($table, $data);
}

function _update($id, $data){
$table = $this->get_table();
$this->db->where('id', $id);
$this->db->update($table, $data);
}

function _delete($id){
$table = $this->get_table();
$this->db->where('id', $id);
$this->db->delete($table);
}

function count_where($column, $value) {
$table = $this->get_table();
$this->db->where($column, $value);
$query=$this->db->get($table);
$num_rows = $query->num_rows();
return $num_rows;
}

function count_all() {
$table = $this->get_table();
$query=$this->db->get($table);
$num_rows = $query->num_rows();
return $num_rows;
}

function get_max() {
$table = $this->get_table();
$this->db->select_max('id');
$query = $this->db->get($table);
$row=$query->row();
$id=$row->id;
return $id;
}

function _custom_query($mysql_query) {
$query = $this->db->query($mysql_query);
return $query;
}

}
