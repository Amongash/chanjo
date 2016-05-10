<?php 
class County extends MY_Controller {

    function __construct() {
        parent::__construct();

    }

    public function index() {
        Modules::run('secure_tings/ni_admin');

        $data['section'] = "Configuration";
        $data['subtitle'] = "County";
        $data['page_title'] = "List Counties";
        $data['module'] = "county";
        $data['view_file'] = "list_county_view";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        $this->load->library('make_bread');
        $this->make_bread->add('Configurations', '', 0);
        $this->make_bread->add('List Counties', '', 0);
        $data['breadcrumb'] = $this->make_bread->output();
        echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);
    }



    function create() {
        Modules::run('secure_tings/ni_admin');
        $update_id = $this->uri->segment(3);
        $data = array();
        $this->load->model('mdl_county');

        if (!isset($update_id)) {
            $update_id = $this->input->post('update_id');
            $data['regions'] = $this->mdl_county->get_regions();
        }

        if (is_numeric($update_id)) {
            $data = $this->get_data_from_db($update_id);
            $data['update_id'] = $update_id;
            $data['regions'] = $this->mdl_county->get_regions();

        } else {
            $data = $this->get_data_from_post();
            $data['regions'] = $this->mdl_county->get_regions();
        }

        $data['section'] = "Configuration";
        $data['subtitle'] = "County";
        $data['page_title'] = "Add County";
        $data['module'] = "county";
        $data['view_file'] = "create_county_form";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        $this->load->library('make_bread');
        $this->make_bread->add('Configurations', '', 0);
        $this->make_bread->add('List Counties', 'county/', 1);
        $this->make_bread->add('Edit County', '', 0);
        $data['breadcrumb'] = $this->make_bread->output();
        echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);
    }

    function action_list() {
        $this->load->model('mdl_county');

        $list = $this->mdl_county->get_counties();
        $data = array();
        $no = $_POST['start'];
        foreach($list as $county) {
            $no++;
            $row = array();
            $row[] = $county->county_name;
            $row[] = $county->total_population;
            $row[] = $county->under_one_population;
            $row[] = $county->women_population;

            //add html for action
            $edit_url = base_url('county/create/'.$county->id);
            $row[] = '  <a class="btn btn-sm btn-info" href="'.$edit_url.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

            $data[] = $row;
        }

        $output = array("draw" => $_POST['draw'], "recordsTotal" => $this->mdl_county->count_filtered(), "recordsFiltered" => $this->mdl_county->count_filtered(), "data" => $data, );

        echo json_encode($output);
    }

    function get_data_from_post() {
        $data['county']['county_name'] = $this->input->post('county_name', TRUE);
        $data['details']['county_headquarter'] = $this->input->post('county_headquarter', TRUE);
        $data['details']['region_id'] = $this->input->post('region_id', TRUE);
        $data['county']['total_population'] = $this->input->post('total_population', TRUE);
        $data['county']['under_one_population'] = $this->input->post('under_one_population', TRUE);
        $data['county']['women_population'] = $this->input->post('women_population', TRUE);
        $data['details']['county_logistician'] = $this->input->post('county_logistician', TRUE);
        $data['details']['county_logistician_phone'] = $this->input->post('county_logistician_phone', TRUE);
        $data['details']['county_logistician_email'] = $this->input->post('county_logistician_email', TRUE);
        $data['details']['county_nurse'] = $this->input->post('county_nurse', TRUE);
        $data['details']['county_nurse_phone'] = $this->input->post('county_nurse_phone', TRUE);
        $data['details']['county_nurse_email'] = $this->input->post('county_nurse_email', TRUE);
        $data['details']['medical_technician'] = $this->input->post('medical_technician', TRUE);
        $data['details']['medical_technician_phone'] = $this->input->post('medical_technician_phone', TRUE);
        $data['details']['medical_technician_email'] = $this->input->post('medical_technician_email', TRUE);
        $data['details']['county_medical_officer'] = $this->input->post('county_medical_officer', TRUE);
        $data['details']['county_medical_officer_phone'] = $this->input->post('county_medical_officer_phone', TRUE);
        $data['details']['county_medical_officer_email'] = $this->input->post('county_medical_officer_email', TRUE);

        return $data;
    }

    function get_data_from_db($update_id) {
        $query = $this->get_where($update_id);
        foreach($query->result() as $row) {
            $data['county']['county_name'] = $row->county_name;
            $data['details']['county_headquarter'] = $row->county_headquarter;
            $data['details']['region_id'] = $row->region_id;
            $data['county']['total_population'] = $row->total_population;
            $data['county']['under_one_population'] = $row->under_one_population;
            $data['county']['women_population'] = $row->women_population;
            $data['details']['county_logistician'] = $row->county_logistician;
            $data['details']['county_logistician_phone'] = $row->county_logistician_phone;
            $data['details']['county_logistician_email'] = $row->county_logistician_email;
            $data['details']['county_nurse'] = $row->county_nurse;
            $data['details']['county_nurse_phone'] = $row->county_nurse_phone;
            $data['details']['county_nurse_email'] = $row->county_nurse_email;
            $data['details']['medical_technician'] = $row->medical_technician;
            $data['details']['medical_technician_phone'] = $row->medical_technician_phone;
            $data['details']['medical_technician_email'] = $row->medical_technician_email;
            $data['details']['county_medical_officer'] = $row->county_medical_officer;
            $data['details']['county_medical_officer_phone'] = $row->county_medical_officer_phone;
            $data['details']['county_medical_officer_email'] = $row->county_medical_officer_email;

        }
        return $data;
    }

    function submit() {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('county_name', 'County Name', 'required');
        $this->form_validation->set_rules('region_id', 'Region', 'required');
        $this->form_validation->set_error_delimiters('<p class="red_text semi-bold">'.'*', '</p>');

        $update_id = $this->input->post('update_id', TRUE);
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = $this->get_data_from_post();

            if (is_numeric($update_id)) {
                $this->_update($update_id, $data['county']);
                $this->_update_details($update_id, $data['details']);
                $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">County details updated successfully!</div>');

            } else {
                $this->_insert($data['county']);
                $this->_insert_details($data['details']);
                $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">New County added successfully!</div>');
            }

            //$this->session->set_flashdata('success', 'County added successfully.');
            redirect('county');
        }
    }

    function delete($id) {
        $this->_delete($id);
        $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">County details deleted successfully!</div>');
        redirect('county');
    }


    function get($order_by) {
        $this->load->model('mdl_county');
        $query = $this->mdl_county->get($order_by);
        return $query;
    }

    function get_with_limit($limit, $offset, $order_by) {
        $this->load->model('mdl_county');
        $query = $this->mdl_county->get_with_limit($limit, $offset, $order_by);
        return $query;
    }

    function get_where($id) {
        $this->load->model('mdl_county');
        $query = $this->mdl_county->get_where($id);
        return $query;
    }

    function get_where_custom($col, $value) {
        $this->load->model('mdl_county');
        $query = $this->mdl_county->get_where_custom($col, $value);
        return $query;
    }

    function _insert_details($data) {
        $this->load->model('mdl_county');
        $this->mdl_county->_insert_details($data);
    }

    function _update($id, $data) {
        $this->load->model('mdl_county');
        $this->mdl_county->_update($id, $data);
    }

    function _update_details($id, $data) {
        $this->load->model('mdl_county');
        $this->mdl_county->_update_details($id, $data);
    }

    function _delete($id) {
        $this->load->model('mdl_county');
        $this->mdl_county->_delete($id);
    }

    function count_where($column, $value) {
        $this->load->model('mdl_county');
        $count = $this->mdl_county->count_where($column, $value);
        return $count;
    }

    function get_max() {
        $this->load->model('mdl_county');
        $max_id = $this->mdl_county->get_max();
        return $max_id;
    }

    function _custom_query($mysql_query) {
        $this->load->model('mdl_county');
        $query = $this->mdl_county->_custom_query($mysql_query);
        return $query;
    }

}