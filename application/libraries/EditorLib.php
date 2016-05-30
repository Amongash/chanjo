<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EditorLib {
    
    private $CI = null;
    private $mod = null;
    private $str = null;


    function __construct()
    {
        $this->CI = &get_instance();
    }   

    public function obj($mod)
    {
        $this->CI->mod = $mod;
        
    }

	public function process($post, $model)
	{	
	    // DataTables PHP library
		require_once($_SERVER['DOCUMENT_ROOT'].'/assets/plugins/datatables/Editor/php/DataTables.php');
		
		//Load the model which will give us our data
		
		$this->CI->load->model($model);

		if (($pos = strpos($model, "/")) !== FALSE) { 
		    $str = substr($model, $pos+1);

		    //Pass the database object to the model
		    echo($this->obj($str));
			//$this->obj($str)->init($db);
			 
			//Let the model produce the data
			$this->CI->str->getData($post);


		}else{
			
			//Let the model produce the data
			$this->obj($model)->getData($post);

		}

	}
}

