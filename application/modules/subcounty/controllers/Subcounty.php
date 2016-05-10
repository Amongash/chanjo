<?php 
class Subcounty extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        Modules::run('secure_tings/ni_admin');
        $data['section'] = "Configuration";
        $data['subtitle'] = "Sub County";
        $data['page_title'] = "List Sub Counties";
        $data['module'] = "subcounty";
        $data['view_file'] = "list_subcounty_view";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        $this->load->library('make_bread');
        $this->make_bread->add('Configurations', '', 0);
        $this->make_bread->add('List Sub-counties', '', 0);
        $data['breadcrumb'] = $this->make_bread->output();
        echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);
    }

    function action_list() {
        $this->load->model('mdl_subcounty');

        $list = $this->mdl_subcounty->get_subcounties();
        $data = array();
        $no = $_POST['start'];
        foreach($list as $subcounty) {
            $no++;
            $row = array();
            $row[] = $subcounty->subcounty_name;
            $row[] = $subcounty->total_population;
            $row[] = $subcounty->under_one_population;
            $row[] = $subcounty->women_population;

            //add html for action
            $edit_url = base_url('subcounty/create/'.$subcounty->id);
            $row[] = '  <a class="btn btn-sm btn-info" href="'.$edit_url.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

            $data[] = $row;
        }

        $output = array("draw" => $_POST['draw'], "recordsTotal" => $this->mdl_subcounty->count_filtered(), "recordsFiltered" => $this->mdl_subcounty->count_filtered(), "data" => $data, );

        echo json_encode($output);
    }



    function create() {
        Modules::run('secure_tings/ni_admin');
        $update_id = $this->uri->segment(3);

        if (!isset($update_id)) {
            $update_id = $this->input->post('update_id');
            $data['counties'] = $this->mdl_subcounty->get_counties();
        }

        if (is_numeric($update_id)) {
            $data = $this->get_data_from_db($update_id);
            $data['update_id'] = $update_id;


        } else {
            $data = $this->get_data_from_post();
        }
        $data['counties'] = $this->mdl_subcounty->get_counties();
        $data['section'] = "Configuration";
        $data['subtitle'] = "Sub County";
        $data['page_title'] = "Add Sub County";
        $data['module'] = "subcounty";
        $data['view_file'] = "create_subcounty_form";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        $this->load->library('make_bread');
        $this->make_bread->add('Configurations', '', 0);
        $this->make_bread->add('List Sub-counties', 'subcounty/', 1);
        $this->make_bread->add('Edit Sub-county', '', 0);
        $data['breadcrumb'] = $this->make_bread->output();
        echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);
    }

    function get_data_from_post() {
        $data['subcounty']['subcounty_name'] = $this->input->post('subcounty_name', TRUE);
        $data['subcounty']['county_id'] = $this->input->post('county_id', TRUE);
        $data['subcounty']['total_population'] = $this->input->post('total_population', TRUE);
        $data['subcounty']['under_one_population'] = $this->input->post('under_one_population', TRUE);
        $data['subcounty']['women_population'] = $this->input->post('women_population', TRUE);
        // $data['details']['no_facilities'] = $this->input->post('no_facilities', TRUE);
        return $data;
    }

    function get_data_from_db($update_id) {
        $query = $this->get_where($update_id);
        foreach($query->result() as $row) {
            $data['subcounty']['subcounty_name'] = $row->subcounty_name;
            $data['subcounty']['county_id'] = $row->county_id;
            $data['subcounty']['total_population'] = $row->total_population;
            $data['subcounty']['under_one_population'] = $row->under_one_population;
            $data['subcounty']['women_population'] = $row->women_population;
            // $data['details']['no_facilities'] = $row->no_facilities;
        }
        return $data;
    }

    function submit() {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('subcounty_name', 'Sub County Name', 'required');
        $this->form_validation->set_rules('county_id', 'County Name', 'required');
        // $this->form_validation->set_rules('population', 'Estimated Total Population', 'required');
        // $this->form_validation->set_rules('population_one', 'Estimated Population Under One', 'required');
        // $this->form_validation->set_rules('population_women', 'Estimated Population of Women', 'required');
        // $this->form_validation->set_rules('no_facilities', 'Number of Health Facilities', 'required');
        $this->form_validation->set_error_delimiters('<p class="red_text semi-bold">'.'*', '</p>');
        $update_id = $this->input->post('update_id', TRUE);
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = $this->get_data_from_post();

            if (is_numeric($update_id)) {
                $this->_update($update_id, $data['subcounty']);
                //$this->_update_details($update_id, $data['details']);
                $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">Sub-county details updated successfully!</div>');

            } else {
                $this->_insert($data['subcounty']);
                //$this->_insert_details($data['details']);
                $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">New Sub-county added successfully!</div>');
            }

            redirect('subcounty');
        }
    }

    function delete($id) {
        $this->_delete($id);
        $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">Sub County details deleted successfully!</div>');
        redirect('subcounty');
    }

    function get($order_by) {
        $this->load->model('mdl_subcounty');
        $query = $this->mdl_subcounty->get($order_by);
        return $query;
    }

    function get_with_limit($limit, $offset, $order_by) {
        $this->load->model('mdl_subcounty');
        $query = $this->mdl_subcounty->get_with_limit($limit, $offset, $order_by);
        return $query;
    }

    function get_where($id) {
        $this->load->model('mdl_subcounty');
        $query = $this->mdl_subcounty->get_where($id);
        return $query;
    }

    function get_where_custom($col, $value) {
        $this->load->model('mdl_subcounty');
        $query = $this->mdl_subcounty->get_where_custom($col, $value);
        return $query;
    }

    function _insert($data) {
        $this->load->model('mdl_subcounty');
        $this->mdl_subcounty->_insert($data);
    }

    function _insert_details($data) {
        $this->load->model('mdl_subcounty');
        $this->mdl_subcounty->_insert_details($data);
    }

    function _update($id, $data) {
        $this->load->model('mdl_subcounty');
        $this->mdl_subcounty->_update($id, $data);
    }

    function _update_details($id, $data) {
        $this->load->model('mdl_subcounty');
        $this->mdl_subcounty->_update_details($id, $data);
    }

    function _delete($id) {
        $this->load->model('mdl_subcounty');
        $this->mdl_subcounty->_delete($id);
    }

    function count_where($column, $value) {
        $this->load->model('mdl_subcounty');
        $count = $this->mdl_subcounty->count_where($column, $value);
        return $count;
    }

    function get_max() {
        $this->load->model('mdl_subcounty');
        $max_id = $this->mdl_subcounty->get_max();
        return $max_id;
    }

    function _custom_query($mysql_query) {
        $this->load->model('mdl_subcounty');
        $query = $this->mdl_subcounty->_custom_query($mysql_query);
        return $query;
    }

}