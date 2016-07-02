<?php

class Users extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_users');


    }

    function index(){
        $this->load->library('user_agent'); 
        $data['module']="users";
        $data['view_file']="login_form";
        $data['main_title'] = $this->get_title();
        
        if(!isset($this->session->userdata['logged_in'])){
          echo Modules::run('template/home', $data);
        }else{
            // user is authenticated, lets see if there is a redirect:
            if( $this->session->userdata('redirect_back') ) {
                $redirect_url = $this->session->userdata('redirect_back');  // grab value and put into a temp variable so we unset the session value
                $this->session->unset_userdata('redirect_back');
                redirect( $redirect_url );
            }else{
                redirect('dashboard');
            }
            
        }

    }

    function list_users()
    {

        Modules::run('secure_tings/ni_admin');
        
        //$this->load->view('display', $data);
        $data['module'] = "users";
        $data['view_file'] = "list_user_view";
        $data['section'] = "Configuration";
        $data['subtitle'] = "List Users";
        $data['page_title'] = "Users";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Configurations', '', 0);
        $this->make_bread->add('Users', 'users/list_users', 1);

        $data['breadcrumb'] = $this->make_bread->output();
        //
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);


    }

    function profile()
    {

        Modules::run('secure_tings/is_logged_in');
        $data['section'] = "NVIP Chanjo";
        $data['subtitle'] = "Profile";
        $data['page_title'] = "Profile Page";
        $data['module'] = "users";
        $user_id = $this->session->userdata['logged_in']['user_id'];
        $data['profile'] = $this->get_profile_data_from_db($user_id);
        $data['view_file'] = "profile_view";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        $this->load->library('form_validation');
        $this->load->library('make_bread');
        $this->make_bread->add('Users', '', 0);
        $this->make_bread->add('Profile', '', 0);

        $data['breadcrumb'] = $this->make_bread->output();

        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
//        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_error_delimiters('<p class="red_text semi-bold">' . '*', '</p>');
        if ($this->form_validation->run() === FALSE) {

        } else {

            $new_data = array(
                'f_name' => $this->input->post('first_name'),
                'l_name' => $this->input->post('last_name'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email')
            );

            $this->_update($user_id, $new_data);

            
            $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">Profile Updated Successfully. Changes will be appear on start of new session</div>');
            redirect('users/profile', 'refresh');
        }
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);
    }

    function change_pass()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'Password', 'required|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirm', 'required|matches[password]');
        $this->form_validation->set_error_delimiters('<p class="red_text semi-bold">' . '*', '</p>');
        if ($this->form_validation->run() === FALSE) {
            redirect('users/profile');
        } else {
            $password = $this->input->post('password', TRUE);
            if (strlen($password) >= 6) $new_data['password'] = Modules::run('secure_tings/hash_it', $password);
            $user_id = $this->session->userdata['logged_in']['user_id'];
            $this->_update($user_id, $new_data);

            $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">Password Changed Successfully.</div>');
            redirect('users/profile', 'refresh');
        }
    }

    function create_user()
    {

        Modules::run('secure_tings/ni_admin');
        $update_id = $this->uri->segment(3);

        if (!isset($update_id)) {
            $update_id = $this->input->post('update_id');
        }

        if (is_numeric($update_id)) {
            $data = $this->get_data_from_db($update_id);
            $data['update_id'] = $update_id;

        } else {
            $data = $this->get_register_data_from_post();
        }
        $data['magroups'] = $this->mdl_users->get_user_groups();
        $data['malevels'] = $this->mdl_users->get_user_levels();
        $data['macounties'] = $this->mdl_users->get_counties();
        $data['masubcounty'] = $this->mdl_users->get_subcounty();
        $data['mafacilities'] = $this->mdl_users->get_facilities();
        $data['maregion'] = $this->mdl_users->getRegion();
        $data['section'] = "NVIP Chanjo";
        $data['subtitle'] = "Users";
        $data['page_title'] = "Add New Users";
        $data['module'] = "users";
        $data['view_file'] = "create_form";
        $data['user_object'] = $this->get_user_object();
        $data['main_title'] = $this->get_title();
        //breadcrumbs
        $this->load->library('make_bread');
        $this->make_bread->add('Configurations', '', 0);
        $this->make_bread->add('Users', 'users/list_users', 1);
        $this->make_bread->add('Add Users', '', 0);
        $data['breadcrumb'] = $this->make_bread->output();
        //
        echo Modules::run('template/' . $this->redirect($this->session->userdata['logged_in']['user_group']), $data);
    }

    function get_data_from_db($update_id)
    {
        $query = $this->get_where($update_id);
        foreach ($query->result() as $row) {
            $data['f_name'] = $row->f_name;
            $data['l_name'] = $row->l_name;
            $data['phone'] = $row->phone;
            $data['email'] = $row->email;
            $data['username'] = $row->username;
            $data['user_group'] = $row->user_group;
            $data['user_level'] = $row->user_level;

        }
        return $data;
    }

    function get_profile_data_from_db()
    {
        $user_id = $this->session->userdata['logged_in']['user_id'];
        $query = $this->get_where($user_id);

        foreach ($query->result() as $row) {
            $data['first_name'] = $row->f_name;
            $data['last_name'] = $row->l_name;
            $data['phone'] = $row->phone;
            $data['email'] = $row->email;
            $data['username'] = $row->username;
         


        }
        return $data;
    }

    function get_profile_data_from_post()
    {
        $data['f_name'] = $this->input->post('f_name', TRUE);
        $data['l_name'] = $this->input->post('l_name', TRUE);
        $data['username'] = $this->input->post('username', TRUE);
        $data['phone'] = $this->input->post('phone', TRUE);
        $data['email'] = $this->input->post('email', TRUE);

        return $data;
    }

    function get_register_data_from_post()
    {
        $data['f_name'] = $this->input->post('f_name', TRUE);
        $data['l_name'] = $this->input->post('l_name', TRUE);
        $data['username'] = $this->input->post('username', TRUE);
        $data['phone'] = $this->input->post('phone', TRUE);
        $data['email'] = $this->input->post('email', TRUE);
        $data['user_level'] = $this->input->post('user_level', TRUE);
        $data['user_group'] = $this->input->post('user_group', TRUE);
        return $data;
    }


    function register()
    {
        Modules::run('secure_tings/is_logged_in');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_name', 'First Name', 'required');
        $this->form_validation->set_rules('l_name', 'Last Name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('user_group', 'User Group', 'required');
        $this->form_validation->set_rules('user_level', 'Access Level', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|matches[passwordc]');
        $this->form_validation->set_rules('passwordc', 'Password Confirm', 'required|matches[password]');
        $this->form_validation->set_error_delimiters('<p class="red_text semi-bold">' . '*', '</p>');
        if ($this->form_validation->run() == FALSE) {

            redirect('users/create_user');

        } else {

        	$data = $this->get_register_data_from_post();

            $password = $this->input->post('password', TRUE);
            $data_base['national'] = $this->input->post('national', TRUE);
            $data_base['region'] = $this->input->post('regional', TRUE);
            $data_base['county'] = $this->input->post('countyuser', TRUE);
            $data_base['subcounty'] = $this->input->post('subcountyuser', TRUE);
            $data_base['facility'] = $this->input->post('facilityuser', TRUE);
            $data['password'] = Modules::run('secure_tings/hash_it', $password);

            $update_id = $this->input->post('update_id');
	        if (isset($update_id)) {
	            
	       
		        if (is_numeric($update_id)) {
		        	$result = $this->mdl_users->_update($update_id, $data, $data_base);  
		        	if ($result == TRUE) {
		                $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">User Updated Successfuly</div>');
		                redirect('users/list_users');
		            } else {
		                $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-danger text-center">An error has occured! Please contact the system administrator</div>');
		                redirect('users/create_user');
		            } 
		        }
            }else{

            	$result = $this->mdl_users->_insert($data, $data_base);
	            if ($result == TRUE) {
	                $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">User Added Successfuly</div>');
	                redirect('users/list_users');
	            } else {
	                $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-danger text-center">Username already in use. Try a different one!</div>');
	                redirect('users/create_user');
	            }
            }

            

        }
    }

    function login_process()
    {
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            if (isset($this->session->userdata['logged_in'])) {
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-danger text-center">Both Username and Password Required</div>');
                redirect('users');
            }
        } else {
            $session_id = $this->session->session_id;
            $data['username'] = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);
            $data['password'] = Modules::run('secure_tings/hash_it', $password);

            $result = $this->mdl_users->login($data);

            if ($result == TRUE) {



                $username = $this->input->post('username');
                $result = $this->mdl_users->fetch_user_information($username);


                if ($result != false) {
                $now = strtotime(date('Y-m-d H:i:s'));    
                 //store session to users table
                $this->mdl_users->update_last_activity($username,$now);   

                //store session to users table
                $this->mdl_users->store_session($username,$session_id);
                //create custom session data
                $this->session->set_userdata(array('username' => $username));

                    $userdata = array(
                        'user_id' => $result[0]->id,
                        'user_fname' => $result[0]->f_name,
                        'user_lname' => $result[0]->l_name,
                        'user_email' => $result[0]->email,
                        'user_group' => $result[0]->user_group,
                        'user_level' => $result[0]->user_level,
                        'last_activity' => $now,
                        'logged_in' => TRUE
                    );


                    // Add user data in session
                    $this->session->set_userdata('logged_in', $userdata);
                    // save the redirect_back data from referral url (where user first was prior to login)
                    $this->session->set_userdata('redirect_back', $this->agent->referrer() );  

                     if(!empty($this->session->has_userdata('logged_in'))){
                        // user is authenticated, lets see if there is a redirect:
                        if( $this->session->userdata('redirect_back') ) {
                            $redirect_url = $this->session->userdata('redirect_back');  // grab value and put into a temp variable so we unset the session value
                            $this->session->unset_userdata('redirect_back');
                            redirect( $redirect_url );
                        }else{
                            redirect('dashboard');
                        }
                        

                     }else{
                        show_error('Please contact your system administrator.');

                     }


                }
            } else {
                $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-danger text-center">Wrong username or password, Please try again!</div>');
                redirect('users');
            }
        }
    }


    function logout()
    {

        // Removing session data
        $sess_array = array(
            'user_id' => ''
        );
        $this->session->unset_userdata('logged_in', $sess_array);
        $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-danger text-center">Successfully Logout</div>');
        // $this->session->sess_destroy();
        redirect('users');
    }


    function get($order_by)
    {
        $this->load->model('mdl_users');
        $query = $this->mdl_users->get($order_by);
        return $query;
    }

    function get_with_limit($limit, $offset, $order_by)
    {
        $this->load->model('mdl_users');
        $query = $this->mdl_users->get_with_limit($limit, $offset, $order_by);
        return $query;
    }

    function get_userRegion($user_id)
    {
        $this->load->model('mdl_users');
        $data['regions'] = $this->mdl_users->get_userRegion($user_id);
        return $data;
        //echo var_dump($data);
    }


    function getCountyByRegion()
    {
        $id = $this->uri->segment(3);
        if (!isset($id)) {
            $data['error'] = "Region ID not received";
            echo json_encode($data);
        } else {
            $this->load->model('mdl_users');
            $query = $this->mdl_users->getCountyByRegion($id);
            foreach ($query as $row) {
                $array = array(
                    'county_id' => $row->id,
                    'county_name' => $row->county_name,
                );
                $data[] = $array;
            }
            echo json_encode($data);
        }
    }

    function getSubcountyByCounty()
    {
        $id = $this->uri->segment(3);
        if (!isset($id)) {
            $data['error'] = "County ID not received";
            echo json_encode($data);
        } else {
            $this->load->model('mdl_users');
            $query = $this->mdl_users->getSubcountyByCounty($id);
            foreach ($query as $row) {
                $array = array(
                    'subcounty_id' => $row->id,
                    'subcounty_name' => $row->subcounty_name,
                );
                $data[] = $array;
            }
            echo json_encode($data);
        }
    }

    function getFacilityBySubcounty()
    {
        $id = $this->uri->segment(3);
        if (!isset($id)) {
            $data['error'] = "Subcounty ID not received";
            echo json_encode($data);
        } else {
            $this->load->model('mdl_users');
            $query = $this->mdl_users->getFacilityBySubcounty($id);
            foreach ($query as $row) {
                $array = array(
                    'facility_id' => $row->id,
                    'facility_name' => $row->facility_name,
                );
                $data[] = $array;
            }
            echo json_encode($data);
        }
    }

    function delete($id)
    {
        $this->_delete($id);
        $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-success text-center">User deleted successfully!</div>');
        redirect('users/list_users');
    }

    function get_where($id)
    {
        $this->load->model('mdl_users');
        $query = $this->mdl_users->get_where($id);
        return $query;
    }

    function get_where_custom($col, $value)
    {
        $this->load->model('mdl_users');
        $query = $this->mdl_users->get_where_custom($col, $value);
        return $query;
    }

    // function _insert($data,$data_base){
    //     $this->load->model('mdl_users');

    // }

    function _update($id, $data)
    {
        $this->load->model('mdl_users');
        $this->mdl_users->_update($id, $data);
    }

    function _delete($id)
    {
        $this->load->model('mdl_users');
        $this->mdl_users->_delete($id);
    }

    function count_where($column, $value)
    {
        $this->load->model('mdl_users');
        $count = $this->mdl_users->count_where($column, $value);
        return $count;
    }

    function get_max()
    {
        $this->load->model('mdl_users');
        $max_id = $this->mdl_users->get_max();
        return $max_id;
    }

    function _custom_query($mysql_query)
    {
        $this->load->model('mdl_users');
        $query = $this->mdl_users->_custom_query($mysql_query);
        return $query;
    }

     public function action_list() {
        $this->load->model('mdl_users');

        $list = $this->mdl_users->get_users();
        $data = array();
        $no = $_POST['start'];
        foreach($list as $user) {
            $no++;
            $row = array();
            $row[] = $user->f_name."  ".$user->l_name ;
            $row[] = $user->phone;
            $row[] = $user->email;
            $row[] = $user->user_group;
            $row[] = $user->user_level;

            //add html for action
            $row[] = '  <a class="btn btn-sm btn-primary" href="'.base_url('users/create_user/'.$user->id).'" title="Edit"><i class="fa fa-edit"></i> Edit</a>';
            $row[] = '  <a class="btn btn-sm btn-info"  href="'.base_url('users/delete/'.$user->id).'" title="Delete"><i class="fa fa-trash-o"></i> Delete</a>';
            $data[] = $row;
        }

        $output = array("draw" => $_POST['draw'], "recordsTotal" => $this->mdl_users->count_filtered(), "recordsFiltered" => $this->mdl_users->count_filtered(), "data" => $data, );

        echo json_encode($output);
    }


}
