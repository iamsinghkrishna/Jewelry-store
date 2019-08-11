<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class testimonial extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        $data = $this->common_model->commonFunction();
         $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->model(array('users'));
        $this->load->helper(array('url', 'language'));
         // $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->language(array('product_lang'));
    /* Load Backend model */
        $this->load->model(array('users', 'backend/group_model', 'backend/pattribute', 'backend/pattribute_sub'));
        $this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category'));

        /* Load Master model */
        $this->load->model(array('master/mst_make', 'master/mst_model', 'master/mst_year'));

        /* Load Product model */
        $this->load->model(array('backend/product_attribute', 'backend/product', 'backend/product_images'));

        $this->load->helper(array('url', 'language'));
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
    }

    public function listTestimonial() {
        /* checking admin is logged in or not */
//        if (!$this->ion_auth->logged_in()) {
//            redirect('auth/login', 'refresh');
//            exit;
//        }

        $this->load->model('testimonials_model');
        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        //checking for admin privilages
//        if ($data['user_account']['role_id'] != 1) {
//            $arr_privileges = $this->common_model->getRecords('trans_role_privileges', 'privilege_id', array("role_id" => $data['user_account']['role_id']));
//            if (count($arr_privileges) > 0) {
//                foreach ($arr_privileges as $privilege) {
//                    $user_privileges[] = $privilege['privilege_id'];
//                }
//            }
//            $arr_login_admin_privileges = $user_privileges;
//            if (in_array('6', $arr_login_admin_privileges) == FALSE) {
//                /* an admin which is not super admin not privileges to access Manage Role
//                 * setting session for displaying notiication message. */
//                $this->session->set_userdata("permission_msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
//                redirect(base_url() . "backend/home");
//                exit();
//            }
//        }
//        if ($this->input->post() != '') {
//            if (count($this->input->post('checkbox')) > 0) {
//                /* getting all ids selected */
//                $arr_tetstimonal_ids = $this->input->post('checkbox');
//                if (count($arr_tetstimonal_ids) > 0) {
//                    /* deleting the testimonial from the backend */
//                    $this->common_model->deleteRows($arr_tetstimonal_ids, "mst_testimonial", "testimonial_id");
//                    $this->session->set_userdata("msg", "<span class='success'>Testimonial deleted successfully!</span>");
//                }
//            }
//        }
        $this->data['title'] = "Manage Testimonials";
        /* getting all testimonail with descending order */

        $this->data['arr_tetimonials'] = $this->testimonials_model->getTestimonials();

        //$this->load->view('testimonial/list', $data);
             $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
         $this->data['page_title'] = 'Administrator Dashboard';

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'testimonial/list', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function changeStatus() {
        if (count($this->input->post('testimonial_id')) > 0) {
            /* changing status of testimonial */
            $arr_to_update = array("status" => $this->input->post('status'));
            $this->common_model->updateRow('mst_testimonial', $arr_to_update, array('testimonial_id' => intval($this->input->post('testimonial_id'))));
            echo json_encode(array("error" => "0", "error_message" => ""));
        } else {
            /* if something going wrong providing error message */
            echo json_encode(array("error" => "1", "error_message" => "Sorry, your request can not be fulfilled this time. Please try again later"));
        }
    }

    public function addTestimonial($edit_id = '') {
       

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="validationError">', '</p>');
        $this->form_validation->set_rules('inputTestimonial', 'testimonial', 'required');
        $this->form_validation->set_rules('inputName', 'name', 'required');
        $this->form_validation->set_rules('lang_id', 'language', 'required');
        
        if ($this->form_validation->run() == true) {
            if ($this->input->post('edit_id') != '') {

   $id=intval(base64_decode($this->input->post('edit_id')));
            $this->data['arr_testimonial'] = $this->common_model->get_details($id);  

                if ($_FILES['testi_image']['name']!= '') {
                    $arr_file = $this->findExtension($_FILES['testi_image']['name']);
                    $image_name = time() . '.' . $arr_file['ext'];
                    $upload_dir ='media/backend/img/testimenial_img/';
                    $old_name = $upload_dir . $this->input->post('old_testi_image');
                    unlink($old_name);
                    $config['upload_path'] = $upload_dir;
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|ico|bmp';
                    $config['max_width'] = '102400';
                    $config['max_height'] = '76800';
                    $config['file_name'] = $image_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $this->upload->do_upload('school_logo');
                    if (!$this->upload->do_upload('testi_image')) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_userdata('msg', $error['error']);
                        redirect(base_url() . 'admin/testimonial/add');
                    } else {
                        $data_img = $this->upload->data();
                        $image_main = $data_img['file_name'];
                    }
                }else{
                    echo $image_main= $this->data['arr_testimonial'][0]['image'];
                   // exit;
                }
                
                $arr_to_update = array(
                    "testimonial" => stripslashes($this->input->post('inputTestimonial')),
                    "name" => stripslashes($this->input->post('inputName')),
                    "suburb" => stripslashes($this->input->post('suburb')),
                    "image" => $image_main,
                    "updated_date" => date("Y-m-d H:i:s")
                );
                $this->common_model->updateRow('mst_testimonial', $arr_to_update, array('testimonial_id' => intval(base64_decode($this->input->post('edit_id')))));
                $this->session->set_userdata('msg', '<span class="success">Testimonial updated successfully!</span>');
            } else {
                
                if ($_FILES['testi_image']['name']!= '') {
                    $arr_file = $this->findExtension($_FILES['testi_image']['name']);
                    $image_name = time() . '.' . $arr_file['ext'];
                    $upload_dir = 'media/backend/img/testimonial_img/';
                    $config['upload_path'] = $upload_dir;
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|ico|bmp';
                    $config['max_width'] = '102400';
                    $config['max_height'] = '76800';
                    $config['file_name'] = $image_name;
                    
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('testi_image')) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_userdata('msg', $error['error']);
                        redirect(base_url() . 'admin/testimonial/list');
                    } else {
                        $data = array('upload_data' => $this->upload->data());
                       // $absolute_path = $this->common_model->absolutePath();
                        $image_path = base_url() . $upload_dir;
                      // exit();
                        $image_main = $image_path . "/" . $image_name;
                    }
                }

                
                $arr_to_insert = array(
                    "added_by" =>'test',
                    "user_id" => $this->session->userdata('user_id'),
                    "status" => 'Active',
                    "testimonial" => stripslashes($this->input->post('inputTestimonial')),
                    "name" => stripslashes($this->input->post('inputName')),
                    "suburb" => stripslashes($this->input->post('suburb')),
                    "image" => $image_name,
                    "added_date" => date("Y-m-d H:i:s"),
                    "updated_date" => date("Y-m-d H:i:s")
                );
                $this->common_model->insertRow($arr_to_insert, "mst_testimonial");
                $this->session->set_userdata('msg', '<span class="success">Testimonial added successfully!</span>');
            }
            redirect(base_url() . "admin/testimonial/list");
            exit;
        }

        if ($edit_id!= '') {

                  $this->data['title'] = "Update Testimonial";
            $this->data['edit_id'] = $edit_id;
            $id=intval(base64_decode($edit_id));
            $this->data['arr_testimonial'] = $this->common_model->get_details($id);
            /* single row fix */
           // print_r( $this->data['arr_testimonial']);
            //exit;
          //  $this->data['arr_testimonial'] = end($data['arr_testimonial']);
                       $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
         $this->data['page_title'] = 'Administrator Dashboard';

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'testimonial/add', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
        //}
            //redirect(base_url() . "admin/testimonial/add/" . $this->input->post('edit_id'));
        } else {
           // $this->load->view('admin/testimonial/add');
                 $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
         $this->data['page_title'] = 'Administrator Dashboard';

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'testimonial/add', NULL);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
        }
    }
    
    public function findExtension($file_name) {

        $file_name = explode(".", $file_name);
        $file['name'] = $file_name[0];
        $file['ext'] = $file_name[1];
        return $file;
    }
    
    function getSuburbsAutocomplete() {
        $suburb = $this->input->post('suburb');
        $action = $this->input->post("action");
        if ($action == 'cross') {

            if (!isset($_SERVER['HTTP_ORIGIN'])) {
                // This is not cross-domain request
                exit;
            }
            $wildcard = TRUE; // Set $wildcard to TRUE if you do not plan to check or limit the domains
            $credentials = TRUE; // Set $credentials to TRUE if expects credential requests (Cookies, Authentication, SSL certificates)
            $origin = $wildcard && !$credentials ? '*' : $_SERVER['HTTP_ORIGIN'];
            header("Access-Control-Allow-Origin: " . $origin);
            if ($credentials) {
                header("Access-Control-Allow-Credentials: true");
            }
            header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
            header("Access-Control-Allow-Headers: Origin");
            header('P3P: CP="CAO PSA OUR"'); // Makes IE to support cookies
// Handling the Preflight
            if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
                exit;
            }
// Response
            header("Content-Type: application/json; charset=utf-8");
        }
        $suburbs = $this->common_model->getRecords('mst_suburbs', 'suburb_name', "suburb_name like '%" . $suburb . "%'");
        foreach ($suburbs as $key => $value) {
            $arr_suburb[] = $value['suburb_name'];
        }
        echo json_encode($arr_suburb);
    }

    public function addUserTestimonial() {
        $data = $this->common_model->commonFunction();
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "signin");
            exit;
        }
        $data['arr_user_data'] = array();
        $user_id = $data['user_account']['user_id'];

        if ($user_id != "") {
            $this->load->model("user_model");
            $arr_user_data = $this->common_model->getRecords('mst_users', 'user_id,first_name,last_name', array('user_id' => $user_id));
            $data['arr_user_data'] = $arr_user_data[0];
        }

        if ($this->input->post('inputTestimonial') != '') {

            $arr_to_insert = array(
                "added_by" => 'user',
                "user_id" => $user_id,
                "status" => 'inactive',
                "testimonial" => mysqli_real_escape_string($this->db->conn_id, $this->input->post('inputTestimonial')),
                "name" => ($this->input->post('inputName')),
                "added_date" => date("Y-m-d H:i:s")
            );

            $this->common_model->insertRow($arr_to_insert, "mst_testimonial");

            $this->session->set_userdata('testimonial_success', 'Your testimonial has been submitted successfully, will display on website after admin approval.');
            redirect(base_url() . 'testimonial');
            exit;
        }

        $data['site_title'] = 'Add testimonial';
        $this->load->view('front/includes/header', $data);
        $this->load->view('front/testimonials/add-testimonial');
        $this->load->view('front/includes/footer', $data);
    }

    public function changeHomePageTestimonialStatus() {

        if ($this->input->post('testimonial_id') != "") {
            $arr_to_update = array(
                "is_featured" => '0'
            );
            $this->common_model->updateRow('mst_testimonial', $arr_to_update, $condition = '');
            $arr_to_updates = array(
                "is_featured" => $this->input->post('is_featured')
            );
            /* condition to update record for the featured status */
            $condition_array = array('testimonial_id' => intval($this->input->post('testimonial_id')));
            $this->common_model->updateRow('mst_testimonial', $arr_to_updates, $condition_array);
            echo json_encode(array("error" => "0", "error_message" => "Status has changed successflly."));
        } else {
            echo json_encode(array("error" => "1", "error_message" => "Sorry, your request can not be fulfilled this time. Please try again later"));
        }
    }

    public function viewTestimonial($pg = 0) {

        $data = $this->common_model->commonFunction();
        //checking for admin privilages
        /** Pagination start here  * */
        $data['arr_testimonials_one'] = $this->common_model->getTestimonial();
        $this->load->library('pagination');
        $data['count'] = count($data['arr_testimonials_one']);
        $config['base_url'] = base_url() . 'testimonial/';
        $config['total_rows'] = count($data['arr_testimonials_one']);
        $config['per_page'] = 10;
        $config['cur_page'] = $pg;
        $data['cur_page'] = $pg;
        $config['num_links'] = 4;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $this->pagination->initialize($config);
        $data['create_links'] = $this->pagination->create_links();
        $data['arr_testimonials'] = $this->common_model->getTestimonial($config['per_page'], $pg);

        $data['page'] = $pg; //$pg is used to pass limit
        /** Pagination end here * */
        $data['site_title'] = "Testimonials";
        $this->load->view('front/includes/header', $data);
        $this->load->view('front/testimonials/view-testimonial', $data);
        $this->load->view('front/includes/footer', $data);
    }

}
