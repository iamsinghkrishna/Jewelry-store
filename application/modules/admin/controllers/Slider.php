<?php

class Slider extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->language(array('product_lang'));

        /* Load Backend model */
        $this->load->model(array('users', 'backend/group_model', 'backend/pattribute', 'backend/pattribute_sub'));
        //$this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category'));

        /* Load Master model */
        // $this->load->model(array('master/mst_make', 'master/mst_model', 'master/mst_year'));

        /* Load Product model */
        // $this->load->model(array('backend/product_attribute', 'backend/product', 'backend/product_images'));
        $this->load->model('slider_home');

        $this->load->helper(array('url', 'language'));

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

    public function index($method = null) {
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Manage Slider';
        $this->data['slider'] = $this->slider_home->get_slider();
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'slider/_slider_view', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function edit($id = null) {
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Manage Slider';
        $this->data['slider'] = $this->slider_home->get_slider_edit($id);
//       echo '<pre>',print_r($this->data['slider'] );die();
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'slider/_edit_slider', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function add_slider($method) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method === 'add') {
            $productSlug = time() . rand(); //. '_' . $this->input->post('product_category');
            if (isset($_FILES['slider']) && !empty($_FILES['slider'])) {
//                $productSlug = $productId;
                $targetDir = "backend/uploads/";
                $fileName = $_FILES['slider']['name'];
                $targetFile = $targetDir . $fileName;
                $uploded_file_path_hover = $this->handleUpload($productSlug, $_FILES['slider']['name'], $_FILES['slider']['tmp_name']);
                $arr = array(
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'banner_image' => $uploded_file_path_hover,
                    'link' => $this->input->post('link'),
                    'style' => $this->input->post('style')
                );

                $result = $this->slider_home->add_slider_backend($arr);
                if ($result) {
                    redirect('admin/slider');
                }
            }
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method === 'edit') {
            $id = $this->input->post('sid');
            $productSlug = time() . rand();
            if ($_FILES['slider']['error'] == 0 && !empty($_FILES['slider']['name'])) {
                if (isset($_FILES['slider']) && !empty($_FILES['slider'])) {
                    $targetDir = "backend/uploads/";
                    $fileName = $_FILES['slider']['name'];
                    $targetFile = $targetDir . $fileName;
                    $uploded_file_path_hover = $this->handleUpload($productSlug, $_FILES['slider']['name'], $_FILES['slider']['tmp_name']);
                    $arr = array(
                        'title' => $this->input->post('title'),
                        'description' => $this->input->post('description'),
                        'call_to_action' => $this->input->post('call_to_action'),
                        'banner_image' => $uploded_file_path_hover,
                        'link' => $this->input->post('link'),
                        'style' => $this->input->post('style')
                    );

                    $result1 = $this->slider_home->update_slider_backend($arr, $id);
                    if ($result1) {
                        redirect('admin/slider');
                    }
                }
            } else {
                $arr = array(
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'call_to_action' => $this->input->post('call_to_action'),
                    'link' => $this->input->post('link'),
                    'style' => $this->input->post('style')
                );

                $result2 = $this->slider_home->update_slider_backend($arr, $id);
                if ($result2) {
                    redirect('admin/slider');
                }
            }

        }
    }

    function handleUpload($slug, $upFileName, $upFileTmpName) {

        $fileTypes = array('jpeg', 'png', 'jpg'); // File extensions
        $fileParts = pathinfo($upFileName);

        if (!in_array(strtolower($fileParts['extension']), $fileTypes)) {
            $this->session->set_flashdata('msg', 'File type not supported.');
            return false;
        }

        $ext = pathinfo($upFileName, PATHINFO_EXTENSION);
        $targetURL = 'backend/uploads/slider/'; // Relative to the root
//        $targetPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'product' . DIRECTORY_SEPARATOR . $slug;
        $targetPath = $targetURL . DIRECTORY_SEPARATOR . $slug;

        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        $tempFile = $upFileTmpName;
        $fileName = $upFileName;
        $fileName = $slug . '_' . $fileName;
        $path = $targetURL . $slug . '/' . $fileName;

        $targetPath .= DIRECTORY_SEPARATOR . $fileName;
        $upload_status = move_uploaded_file($tempFile, $targetPath);
        $dataDocumentDetail['type'] = $fileParts['extension'];
        if (isset($upload_status))
            return $path;
    }

    public function delete() {

        $id = $this->uri->segment(4);
        $result = $this->slider_home->delete_backend($id);
        echo json_encode(true);
    }

}
