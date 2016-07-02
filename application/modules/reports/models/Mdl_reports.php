<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Reports extends CI_Model {

var $order = array('order' => 'desc');
var $column = array('transaction_date','station','type','to_from','vaccine_name','batch','expiry','quantity','balance');


	function __construct() {
		parent::__construct();
	}

	function get_location($condition){
        if(!is_null($condition)){
            $this->db->select('location');
            $this->db->like($condition);
        }else{
            $this->db->select('location');
        }

        $query = $this->db->get('v_location');
        return $query->result();

    }

	 private function _get_datatables_query($station,$id)
    {

        $this->db->from('v_transactions_all');
        $this->db->where('station',$station);
        $this->db->where('vaccine_id',$id);
        $this->db->order_by('order','desc');
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

    function get_transactions($station,$id)
    {
        $this->_get_datatables_query($station,$id);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

	function count_transactions_filtered($station,$id){
		$this->_get_datatables_query($station,$id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function get_population($level) {
		$this->db->select('level,population');
		$query = $this->db->get('tbl_population');
		$this->db->where('level',$level);
		return $query->result();
	}

    function get_total_population($station,$level) {
        $call_procedure = "call get_total_population('$station',$level)";
        $query = $this->db->query($call_procedure);
        $query->next_result();
        return $query->result_array();
    }

    function get_vaccine_balance($station,$vaccine_id) {
        $call_procedure = 'call get_vaccine_balance("'.$station.'",'.$vaccine_id.')';
        $query = $this->db->query($call_procedure);
        $query->next_result();
        return $query->result_array();
    }


}
