<?php
    class Uploads extends MY_Controller 
  {

        function __construct() {
            parent::__construct();
        }


        function index () {
           $this->load->model('mdl_uploads');

           $data['section'] = "NVIP Chanjo";
           $data['subtitle'] = "Library";
           $data['page_title'] = "Files";
           $data['module'] = "uploads";
           $data['view_file'] = "file_view";
           $data['user_object'] = $this->get_user_object();
           $data['main_title'] = $this->get_title();
            //breadcrumbs
            $this->load->library('make_bread');
            $this->make_bread->add('Library', 'uploads/list_files', 1);
            $this->make_bread->add('Upload Documents', '', 0);
            $data['breadcrumb'] = $this->make_bread->output();
            //
           echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);
       }
        function notice(){
            $this->load->model('mdl_uploads');

            $data['section'] = "NVIP Chanjo";
            $data['subtitle'] = "Notice";
            $data['page_title'] = "Notice";
            $data['module'] = "uploads";
            $data['view_file'] = "notice_v";
            $data['user_object'] = $this->get_user_object();
            $data['main_title'] = $this->get_title();
            //breadcrumbs
            $this->load->library('make_bread');
            $this->make_bread->add('Notice', 0);
            $data['breadcrumb'] = $this->make_bread->output();
            //
            echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);

        }
        function view_all_notices(){
            $this->load->model('mdl_uploads');

            $data['section'] = "NVIP Chanjo";
            $data['subtitle'] = "Notice";
            $data['page_title'] = "Notice";
            $data['module'] = "uploads";
            $data['view_file'] = "viewall_notice_v";
            $data['user_object'] = $this->get_user_object();
            $data['main_title'] = $this->get_title();
            //breadcrumbs
            $this->load->library('make_bread');
            $this->make_bread->add('Notice', 0);
            $data['breadcrumb'] = $this->make_bread->output();

            $user_id = $this->session->userdata['logged_in']['user_id'] ;
            $this->load->model('mdl_uploads');
            $querys = $this->mdl_uploads->get_all_notice_id($user_id);

            $me = explode(',',$querys);
            $length = count($me);
            
            for ($x = 0; $x < $length; $x++) {
                $this->load->model('mdl_uploads');
                $notices[] = $this->mdl_uploads->get_all_notice($me[$x]);
            }


            $notices2 = json_decode(json_encode($notices), True);

            $data['notices'] = $notices2;



            echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);

        }
        function view_one_notice($id){
            $this->load->model('mdl_uploads');

            $data['section'] = "NVIP Chanjo";
            $data['subtitle'] = "Notice";
            $data['page_title'] = "Notice";
            $data['module'] = "uploads";
            $data['view_file'] = "view_notice_v";
            $data['user_object'] = $this->get_user_object();
            $data['main_title'] = $this->get_title();
            //breadcrumbs
            $this->load->library('make_bread');
            $this->make_bread->add('Notice', 0);
            $data['breadcrumb'] = $this->make_bread->output();

            $user_id = $this->session->userdata['logged_in']['user_id'] ;
            $this->load->model('mdl_uploads');
            $notice = $this->mdl_uploads->get_all_notice($id);
            $data['notice'] = json_decode(json_encode($notice), True);

           



            
            echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);

        }
        function mark_as_read($id){
            $user_id = $this->session->userdata['logged_in']['user_id'] ;
            $this->load->model('mdl_uploads');
            $query = $this->mdl_uploads->get_all_notice_id($user_id);

            $pieces = explode(",", $query);

            $arr = array_diff($pieces, array($id));

            $data = implode(",",$arr);

               $mydata = array(
                   'notice' => $data
               );

            $this->mdl_uploads->update_notice($user_id,$mydata);
            redirect('uploads/view_all_notices','refresh');

        }
        function upload_notice(){
            $notice_name = $this->input->post('notice_name', TRUE);
            $notice_description = $this->input->post('notice_description', TRUE) ;
            $user_id = $this->session->userdata['logged_in']['user_id'] ;
            $data = array(
                'notice_name' => $notice_name ,
                'notice_description' => $notice_description ,
                'user_id' => $user_id
            );
            $this->load->model('Mdl_uploads');
            $id = $this->Mdl_uploads->insert_notice($data);
            $query = $this->Mdl_uploads->get_user_base($user_id);
            $user_base = json_decode(json_encode($query), True);

            $national = $user_base[0]['national'];
            $region = $user_base[0]['region'];
            $county = $user_base[0]['county'];
            $subcounty = $user_base[0]['subcounty'];
            $facility = $user_base[0]['facility'];

            //var_dump($national,$region,$county,$subcounty, $facility);


            $me = $this->Mdl_uploads->update_users($national,$region,$county,$subcounty, $facility);
            $np = json_decode(json_encode($me), True);

            foreach ($np as $n){
                $query = $this->Mdl_uploads->get_all_notice_id($n['user_id']);
                if(!empty($query)){
                    $query = $query.','.$id;

                }else{
                    $query = $id;


                }

                $data = array(
                    'notice' => $query
                );
                $this->Mdl_uploads->update_notice($n['user_id'],$data);

            }
            redirect('uploads/notice');

        }




        function do_upload() {
            $config['upload_path']='./docs/';
            $config['allowed_types']='pdf|doc|jpg|png|gif|docx';
            $config['max_size']='2048';
            $config['remove_spaces']= TRUE;

            $this->load->library('upload', $config);
                //$this->upload->initialize($config);
                    if ( ! $this->upload->do_upload()) {
                      
                        $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-danger text-center">'.$this->upload->display_errors().'</div>');
                        redirect('uploads/index');
                    }
                    else
                    {


                        function get_data_from_post(){
                            $data['region_name']=$this->input->post('region_name', TRUE);
                            $data['region_headquater']=$this->input->post('region_headquater', TRUE);

                            return $data;
                        }

                            $data = $this->upload->data();
                            $mydata = array(
                               'file_name' => $this->input->post('file_name'),
                               'raw_name' => $data["file_name"],
                               'file_type' => $data["file_type"],
                               'full_path' => $data["full_path"], 
                               'published' => $this->input->post('published'),
                               'purpose' => $this->input->post('purpose'),
                               'owner' => ($this->session->userdata['logged_in']['user_fname']),
                               'upload_date' => date('Y-m-d')   
                               );
                            $this->load->model('mdl_uploads');
                            $this->mdl_uploads->add_uploads($mydata);
                            $data = array('upload_data' => $this->upload->data());
                            $this->session->set_flashdata('msg','<div id="alert-message" class="alert alert-success text-center">File uploaded successfully!</div> ');
                            redirect('uploads/list_files');
                }
        }


        function list_files() {


            $this->load->model('mdl_uploads');
            $this->load->library('pagination');
            $this->load->library('table');
            $config['base_url'] = base_url().'/uploads/index';
            //$config['total_rows'] = $this->mdl_uploads->get_files();
            $config['total_rows'] = $this->mdl_uploads->get('id')->num_rows;
            $config['per_page'] = 10;
            $config['num_links'] = 4;
            $config['full_tag_open'] = '<div><ul class="pagination pagination-small pagination-centered">';
            $config['full_tag_close'] = '</ul></div>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
            $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
            $config['next_tag_open'] = "<li>";
            $config['next_tagl_close'] = "</li>";
            $config['prev_tag_open'] = "<li>";
            $config['prev_tagl_close'] = "</li>";
            $config['first_tag_open'] = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open'] = "<li>";
            $config['last_tagl_close'] = "</li>";

            $this->pagination->initialize($config);
                  // $data['query'] = $this->mdl_county->get('id', $config['per_page'], $this->uri->segment(3));
            $data['files'] = $this->db->get('tbl_uploads', $config['per_page'], $this->uri->segment(3));
                   //$this->load->view('display', $data);
            $data['section'] = "NVIP Chanjo";
            $data['subtitle'] = "Library";
            $data['page_title'] = "Files";
            $data['module'] = "uploads";
            $data['view_file'] = "list_view";
            $data['user_object'] = $this->get_user_object();
            $data['main_title'] = $this->get_title();
            //breadcrumbs
            $this->load->library('make_bread');
            $this->make_bread->add('Library', '', 1);
            $data['breadcrumb'] = $this->make_bread->output();
            //
            echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);
        }


        function download_file($file_name){
           $this->load->helper('download');
            $data = file_get_contents('./docs/'.$file_name); // Read the file's contents
            $name = $file_name;
            force_download($name, $data);
        }

        function delete($id){
           $this->load->model('mdl_uploads');
           $this->mdl_uploads->_delete($id);
           $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-succes text-center">File deleted successfully</div>');
                        
           redirect('uploads/list_files', 'refresh');
        }

  }