<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Mdl_Order extends CI_Model {

function __construct() {
parent::__construct();
}

    
    function calculate_request($station,$level,$vaccine_id){
        $call_procedure="call calculate_request('$station',$level,$vaccine_id)";
        $query=$this->db->query($call_procedure);
        $query->next_result();
        return $query->result_array();
    }
    // Get a list of orders placed to your station

    function get_placed_orders($station,$level){
        $call_procedure="call get_pending_requests('$station',$level)";
        $query=$this->db->query($call_procedure);
        $query->next_result();
        return $query->result_array();
    }

    function count_placed_orders($station,$level){
        $call_procedure="call get_pending_requests('$station',$level)";
        $query=$this->db->query($call_procedure);
        $query->next_result();
        return $query->num_rows();
    }

    function get_last_order_details($station_id){
        $call_procedure="CALL last_order_details('$station_id')";
        $query=$this->db->query($call_procedure);
        $query->next_result();
        return $query->result_array();
    }

    // Get list of orders you have submitted
    function get_submitted_orders($station,$level){
        $call_procedure="call get_submitted_requests('$station',$level)";
        $query=$this->db->query($call_procedure);
        $query->next_result();
        return $query->result_array();
    }

        // Get list of all placed orders
    function get_all_placed_orders($station,$level){
       	$call_procedure="call get_requests('$station',$level)";
        $query=$this->db->query($call_procedure);
        $query->next_result();
        return $query->result_array();
    }



    function forward_orders($station_level,$order_id){
        $call_procedure="CALL forward_order('$station_level',$order_id)";
        $query=$this->db->query($call_procedure);
        return $query;
    }
// Get a list of items in an order 
    function get_order_items($order_id,$order_by,$date_created){
        $call_procedure="call get_request_items($order_id,$order_by,'$date_created')";
        $query=$this->db->query($call_procedure);
        $query->next_result();
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

function get_where($id){
$table = $this->get_table();
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