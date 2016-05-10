<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Mdl_uploads extends CI_Model {

function __construct() {
parent::__construct();
}

function get_table() {
    $table = "tbl_uploads";
    return $table;
}

function add_uploads($data)
{
$table = $this->get_table();
$this->db->insert($table, $data);
}

public function get_files()
{
	$table = $this->get_table();
    return $this->db->select()
            ->from($table)
            ->get()
            ->result();
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

    function insert_notice($data){
        $this->db->insert('tbl_notices', $data);
        $id = $this->db->insert_id();
        return $id;

    }

    function get_all_notice_id($user_id){
        $this->db->select('notice');
        $this->db->from('tbl_users');
        $this->db->where('id',$user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->notice;
        }
        return false;

    }
    function get_all_notice($id){
        $this->db->select("id,notice_name,notice_description,user_id");
        $this->db->from('tbl_notices');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    function get_user_base($user_id){
        $this->db->select("id,national,region,county,subcounty,facility");
        $this->db->from('tbl_user_base');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result();

    }
    function update_users($national,$region,$county,$subcounty, $facility){

        $sql ="SELECT `user_id` FROM `user_base` WHERE national = $national";


        if(!$region == 0){
            $sql.=" AND region = $region";
        }


        if(!$county == 0){
            $sql.="and county = $county";
        }

        if(!$subcounty == 0){
            $sql.=" AND subcounty = $subcounty";
        }

        if(!$facility == 0){
            $sql.=" AND facility = $facility";
        }



        $query = $this->db->query($sql)->result();
        /*$query = $this->db->get($sql);*/
        return $query;


    }
    function update_notice($user_id,$data){

        $this->db->where('id', $user_id);
        $this->db->update('tbl_users', $data);
    }

}

