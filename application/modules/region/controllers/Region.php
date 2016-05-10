<?php 
class Region extends MY_Controller {

    function __construct() {
        parent::__construct();
        Modules::run('secure_tings/is_logged_in');
    }


    public function index() {
        $this->load->model('mdl_region');
        $this->load->library('pagination');
        $this->load->library('table');
        $data['module'] = "region";
        $data['view_file'] = "list_region_view";
        $data['section'] = "Configuration";
        $data['subtitle'] = "List Regions";
        $data['page_title'] = "Regions";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        $this->load->library('make_bread');
        $this->make_bread->add('Configurations', '', 0);
        $this->make_bread->add('List Regions', '', 0);
        $data['breadcrumb'] = $this->make_bread->output();
        echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);
    }




    function create() {

        $update_id = $this->uri->segment(3);

        if (!isset($update_id)) {
            $update_id = $this->input->post('update_id');
        }

        if (is_numeric($update_id)) {
            $data = $this->get_data_from_db($update_id);
            $data['update_id'] = $update_id;

        } else {
            $data = $this->get_data_from_post();
        }


        $data['module'] = "region";
        $data['view_file'] = "create_region_form";
        $data['section'] = "Configuration";
        $data['subtitle'] = "Add Region";
        $data['page_title'] = "Regions";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        $this->load->library('make_bread');
        $this->make_bread->add('Configurations', '', 0);
        $this->make_bread->add('List Regions', 'region/', 1);
        $this->make_bread->add('Edit Region', '', 0);
        $data['breadcrumb'] = $this->make_bread->output();
        echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);
    }

    function get_data_from_post() {
        $data['region']['region_name'] = $this->input->post('region_name', TRUE);
        $data['region']['women_population'] = $this->input->post('women_population', TRUE);
        $data['region']['total_population'] = $this->input->post('total_population', TRUE);
        $data['region']['under_one_population'] = $this->input->post('under_one_population', TRUE);
        $data['details']['manager'] = $this->input->post('region_manager', TRUE);
        $data['details']['manager_phone'] = $this->input->post('region_manager_phone', TRUE);
        $data['details']['manager_email'] = $this->input->post('region_manager_email', TRUE);

        return $data;
    }

    function get_data_from_db($update_id) {
        $query = $this->get_where($update_id);
        foreach($query->result() as $row) {
            $data['region']['region_name'] = $row->region_name;
            $data['region']['women_population'] = $row->women_population;
            $data['region']['total_population'] = $row->total_population;
            $data['region']['under_one_population'] = $row->under_one_population;
            $data['details']['manager'] = $row->manager;
            $data['details']['manager_phone'] = $row->manager_phone;
            $data['details']['manager_email'] = $row->manager_email;


        }
        return $data;
    }

    function action_list() {
        $this->load->model('mdl_region');

        $list = $this->mdl_region->get_regions();
        $data = array();
        $no = $_POST['start'];
        foreach($list as $region) {
            $no++;
            $row = array();
            $row[] = $region->region_name;
            $row[] = $region->manager;
            $row[] = $region->manager_phone;
            $row[] = $region->manager_email;

            //add html for action
            $edit_url = base_url('region/create/'.$region->id);
            $delete_url = base_url('region/delete/'.$region->id);
            $row[] = '  <a class="btn btn-sm btn-info" href="'.$edit_url.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                              <a class="btn btn-sm btn-danger"  href="'.$delete_url.'" title="Delete"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

            $data[] = $row;
        }

        $output = array("draw" => $_POST['draw'], "recordsTotal" => $this->mdl_region->count_filtered(), "recordsFiltered" => $this->mdl_region->count_filtered(), "data" => $data, );

        echo json_encode($output);
    }


    function submit() {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('region_name', 'region Name', 'required');
        $this->form_validation->set_rules('region_manager', 'region manager', 'required');
        // $this->form_validation->set_rules('region_manager_phone', '', 'required');
        // $this->form_validation->set_rules('region_manager_email', '', 'required');
        $this->form_validation->set_error_delimiters('<p class="red_text semi-bold">'.'*', '</p>');
        $update_id = $this->input->post('update_id', TRUE);
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = $this->get_data_from_post();

            if (is_numeric($update_id)) {
                $this->_update($update_id, $data['region']);
                $this->_update_details($update_id, $data['details']);
                $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">Region details updated successfully!</div>');

            } else {
                $this->_insert($data['region']);
                $this->_insert_details($data['details']);
                $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">New Region added successfully!</div>');
            }

            redirect('region');
        }
    }

    function delete($id) {
        $this->_delete($id);
        $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">Region details deleted successfully!</div>');
        redirect('region');
    }


    function get($order_by) {
        $this->load->model('mdl_region');
        $query = $this->mdl_region->get($order_by);
        return $query;
    }

    function get_with_limit($limit, $offset, $order_by) {
        $this->load->model('mdl_region');
        $query = $this->mdl_region->get_with_limit($limit, $offset, $order_by);
        return $query;
    }

    function get_where($id) {
        $this->load->model('mdl_region');
        $query = $this->mdl_region->get_where($id);
        return $query;
    }

    function get_where_custom($col, $value) {
        $this->load->model('mdl_region');
        $query = $this->mdl_region->get_where_custom($col, $value);
        return $query;
    }

    function _insert($data) {
        $this->load->model('mdl_region');
        $this->mdl_region->_insert($data);
    }

    function _insert_details($data) {
        $this->load->model('mdl_region');
        $this->mdl_region->_insert_details($data);
    }

    function _update($id, $data) {
        $this->load->model('mdl_region');
        $this->mdl_region->_update($id, $data);
    }

    function _update_details($id, $data) {
        $this->load->model('mdl_region');
        $this->mdl_region->_update_details($id, $data);
    }

    function _delete($id) {
        $this->load->model('mdl_region');
        $this->mdl_region->_delete($id);
    }

    function count_where($column, $value) {
        $this->load->model('mdl_region');
        $count = $this->mdl_region->count_where($column, $value);
        return $count;
    }

    function get_max() {
        $this->load->model('mdl_region');
        $max_id = $this->mdl_region->get_max();
        return $max_id;
    }

    function _custom_query($mysql_query) {
        $this->load->model('mdl_region');
        $query = $this->mdl_region->_custom_query($mysql_query);
        return $query;
    }

}