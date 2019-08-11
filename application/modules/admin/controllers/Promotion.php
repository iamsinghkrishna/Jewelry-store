<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Promotion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        $data = $this->common_model->commonFunction();
        $this->load->database();
        $this->load->library(array('ion_auth'));
        $this->load->model(array('users'));
        $this->load->helper(array('url', 'language'));
        // $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->language(array('product_lang'));
        /* Load Backend model */
        $this->load->model(array('users', 'backend/group_model', 'backend/pattribute', 'backend/pattribute_sub'));
        $this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category'));
        $this->load->model(array('Common_model_marketing'));


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

    public function lists() {
        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        $this->data['title'] = "Manage Promotions";
        /* getting all testimonail with descending order */
        
        if (count($_POST) > 0) {
            if (isset($_POST['btn_delete_all'])) {
                $arr_banner_ids = $this->input->post('checkbox');
                //echo '<pre>';print_r($arr_products_ids);die;
                if (count($arr_banner_ids) > 0) {
                    foreach ($arr_banner_ids as $ids) {
                        if($ids != ''){
                            $id = array($ids);
                            $this->common_model->deleteRows($id, "tbl_promotion_banners", "id");
                           
                        }
                    }
                }
                $this->session->set_userdata("msg", "Promotion banners deleted successfully!"); 
                redirect('admin/promotion/lists');
            }
        }
        

        $this->data['promotions'] = $this->common_model->getRecords('tbl_promotion_banners', '*','','id DESC');

        //$this->load->view('testimonial/list', $data);
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['page_title'] = 'Administrator Dashboard';

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'promotion/list', $this->data);
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

    public function add_banner($edit_id = "") {


        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="validationError">', '</p>');
        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('discount_in', 'name', 'required');

        if ($this->form_validation->run() == true) {
            if ($edit_id != '') {

                $id = intval(base64_decode($this->input->post('edit_id')));

                if ($_FILES['banner_image']['name']) {
//                    die;
                    $arr_file = $this->findExtension($_FILES['banner_image']['name']);
                    $image_name = time() . '.' . $arr_file['ext'];
                    $upload_dir = 'backend/uploads/promotional_banners';
                    $old_name = $upload_dir . $this->input->post('old_banner_image');
                    unlink($old_name);
                    $config['upload_path'] = $upload_dir;
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|ico|bmp';
                    $config['max_width'] = '102400';
                    $config['max_height'] = '76800';
                    $config['file_name'] = $image_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $this->upload->do_upload('banner_image');
                    if (!$this->upload->do_upload('banner_image')) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_userdata('msg', $error['error']);
                        redirect(base_url() . 'admin/testimonial/edit');
                    } else {
                        $data_img = $this->upload->data();
                        $image_name = $data_img['file_name'];
                    }
                } else {
                    echo $image_name = $this->input->post('old_banner_image');
                    // exit;
                }

                $arr_to_update = array(
                    "type" => $this->input->post('type'),
                    "discount_in" => $this->input->post('discount_in'),
                    "content" => $this->input->post('content'),
                    "display_after" => ($this->input->post('display_after') * 1000),
                    "discount" => $this->input->post('discount'),
                    "banner_image" => $image_name,
                    "from_date" => date("Y-m-d", strtotime($this->input->post('from_date'))),
                    "to_date" => date("Y-m-d", strtotime($this->input->post('to_date'))),
                    "created_time" => date("Y-m-d H:i:s"),
                    "created_by" => $this->session->userdata('user_id'),
                    "status" => $this->input->post('status'),
                );
                $this->common_model->updateRow('tbl_promotion_banners', $arr_to_update, array('id' => $edit_id));
                $this->session->set_userdata('msg', '<span class="success">Promotion updated successfully!</span>');
            } else {

                if ($_FILES['banner_image']['name'] != '') {

                    $arr_file = $this->findExtension($_FILES['banner_image']['name']);
                    $image_name = time() . '.' . $arr_file['ext'];
                    $upload_dir = 'backend/uploads/promotional_banners';
                    $config['upload_path'] = $upload_dir;
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|ico|bmp';
                    $config['max_width'] = '102400';
                    $config['max_height'] = '76800';
                    $config['file_name'] = $image_name;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('banner_image')) {
                        $error = array('error' => $this->upload->display_errors());
//                        print_r($error);die;
                        $this->session->set_userdata('msg', $error['error']);
                        redirect(base_url() . 'admin/promotion/add_banner');
                    } else {
                        $data = array('upload_data' => $this->upload->data());
                        // $absolute_path = $this->common_model->absolutePath();
                        $image_path = base_url() . $upload_dir;
                        // exit();
                        $image_main = $image_path . "/" . $image_name;
                    }
                }


                $arr_to_insert = array(
                    "type" => $this->input->post('type'),
                    "discount_in" => $this->input->post('discount_in'),
                    "content" => $this->input->post('content'),
                    "display_after" => ($this->input->post('display_after') * 1000),
                    "discount" => $this->input->post('discount'),
                    "banner_image" => $image_name,
                    "from_date" => date("Y-m-d", strtotime($this->input->post('from_date'))),
                    "to_date" => date("Y-m-d", strtotime($this->input->post('to_date'))),
                    "created_time" => date("Y-m-d H:i:s"),
                    "created_by" => $this->session->userdata('user_id'),
                    "status" => $this->input->post('status'),
                );
                
                
                $from_date = trim($this->input->post('from_date'));
            
                $arr_from_date = explode('/',$from_date);
                $from_date_new = $arr_from_date[2].'-'.$arr_from_date[0].'-'.$arr_from_date[1];

                $to_code = trim($this->input->post('to_date'));
                $arr_to_date = explode('/',$to_code);
                $to_date_new = $arr_to_date[2].'-'.$arr_to_date[0].'-'.$arr_to_date[1];

               $conditions = "from_date >= '$from_date_new' AND to_date <='$to_date_new'";

                $arr_code_check = $this->Common_model_marketing->getRecords('tbl_promotion_banners', 'id',$conditions);
                
                if(count($arr_code_check) < 1){
                    $this->common_model->insertRow($arr_to_insert, "tbl_promotion_banners");
                    $this->session->set_userdata('msg', '<span class="success">Promotion added successfully!</span>');
                }else{
                     $this->session->set_userdata('msg', '<span class="success">Promotion already available!</span>');
                }
            }
            redirect(base_url() . "admin/promotion/lists");
//            exit;
        }

        if ($edit_id != '') {

            $this->data['title'] = "Update Testimonial";
            $this->data['edit_id'] = $edit_id;
            $this->data['id'] = intval(base64_decode($edit_id));
            $this->data['promotion'] = $this->common_model->getRecords('tbl_promotion_banners', '*', array('id' => base64_decode($edit_id)));
//            echo base64_encode($edit_id);
//            print_r($this->data['promotion']);die;
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
            $this->template->write_view('content', 'promotion/edit', $this->data);
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
            $this->template->write_view('content', 'promotion/add', NULL);
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
