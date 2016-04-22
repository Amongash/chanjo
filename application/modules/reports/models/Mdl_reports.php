<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_Reports extends CI_Model {
	
var $order = array('transaction_date' => 'desc');
var $column = array('id','transaction_date','station','level','received','issued','count','balance');

	function __construct() {
		parent::__construct();
	}


	function getRegion($condition){
        if(!is_null($condition)){
            $this->db->select('id,region_name');
            $this->db->like($condition); 
        }else{
            $this->db->select('id,region_name');
        }
        $query = $this->db->get("tbl_regions");      
        return $query->result();
    }

	 private function _get_datatables_query($station)
    {
        
        $this->db->from('v_transactions');
        $this->db->where('station',$station);
        $i = 0;
        foreach ($this->column as $item)
        {
            if($_POST['search']['value'])
                ($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
            $column[$i] = $item;
            $i++;
        }
 
        if(isset($_POST['order']))
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_transactions($station)
    {
        $this->_get_datatables_query($station);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

	function count_transactions_filtered($station){
		$this->_get_datatables_query($station);
		$query = $this->db->get();
		return $query->num_rows();
	}


}