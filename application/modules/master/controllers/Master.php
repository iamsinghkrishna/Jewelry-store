<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));

        $this->load->model(array('users', 'backend/group_model'));
        /* Load Backend model */
        $this->load->model(array('master/mst_make', 'master/mst_model', 'master/mst_year'));


        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->language(array('master_lang'));

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
    }

    // redirect if needed, otherwise display the user list
    public function index() {
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Administrator Dashboard';
        $this->data['total_users'] = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'simple_page', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function make($action = NULL, $makeId = null) {

        if ($this->session->userdata('user_id'))
            $user_id = $this->session->userdata('user_id');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action === "add") {

            $dataMakeArray = array(
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );
            $makeName = $this->input->post('make_name');
            $makeDesc = $this->input->post('make_description');

            $makeCount = count($makeName);
            if ($makeCount > 0)
                for ($i = 0; $i < $makeCount; $i++) {

                    foreach ($makeName as $key => $val)
                        $dataMakeArray['name'] = $makeName[$i];

                    foreach ($makeDesc as $keySub => $valSub)
                        $dataMakeArray['description'] = $makeDesc[$i];

                    $this->mst_make->insert($dataMakeArray);
                }
            redirect('master/make');
        }
        //End of add make

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action === "edit") {


            $dataMakeArrayUpdate = array(
                'name' => $this->input->post('make_name'),
                'description' => $this->input->post('make_description'),
                'isactive' => $this->input->post('isactive'),
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            $this->mst_make->update($makeId, $dataMakeArrayUpdate);
            redirect('master/make');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action === "delete") {

            $this->mst_make->delete($makeId);
            $this->mst_model->delete($makeId);
            redirect('master/make');
        }


        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Manage Make';

        $this->data['isactive'] = array('' => 'Select Status', '0' => 'Active', '1' => 'In-Active');
        $this->data['make_detail'] = $this->mst_make->as_array()->get_all();



        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'master/_make', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function year($action = null, $yearId = null) {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "add") {

//            echo '<pre>', print_r($_POST);
//            die;

            $dataMakeArray = array(
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );

            $yr = $this->input->post('year');
            $yearData = explode(',', $yr);
            $yearCount = count($yearData);
            $dataYearArray['make_id'] = $this->input->post('make_id');
            foreach ($yearData as $key => $val) {

                $dataYearArray['name'] = $yearData[$key];
                $this->mst_year->insert($dataYearArray);
            }

            redirect('master/year');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "edit") {

            $make_id = $this->input->post('make_id');
//            $this->mst_year->delete_make($make_id);
            $existingYear = $this->mst_year->get_all_year_by_make_id($make_id);
            $yr = $this->input->post('year');

            $yearData = explode(',', $yr[0]);

            $existingArrayData = array();
            foreach ($existingYear as $key => $val) {
                $existingArrayData[$key] = $val['name'];
            }
            /* Delete years */

            $deleteData = array_diff($existingArrayData, $yearData);

            foreach ($deleteData as $key => $val)
                $this->mst_year->delete_year($make_id,$val);
            
            /* Delete years */

            $yearArrayDataToInsert = array_diff($yearData, $existingArrayData);
            $yearCount = count($yearArrayDataToInsert);

            $dataMakeArray = array(
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );

            $dataYearArray['make_id'] = $this->input->post('make_id');

            foreach ($yearArrayDataToInsert as $key => $val) {
                $dataYearArray['name'] = $val;
                $this->mst_year->insert($dataYearArray);
            }

            redirect('master/year');
        }

        $this->data['product_make'] = array('' => 'Select Category') + $this->mst_make->dropdown('name');
        $this->data['page_title'] = 'Manage Year';

        $this->data['years_detail'] = $this->mst_make->as_array()->get_all();
        foreach ($this->data['years_detail'] as $key => $mkData) {
            $this->data['years_detail'][$key]['make_year_details'] = $this->mst_year->get_all_year_by_make_id($mkData['id']);
        }
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'master/_year', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function model($action = null, $modelId = null) {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "add") {


            $dataModelArray = array(
                'make_id' => $this->input->post('make'),
                'year_id' => $this->input->post('year'),
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );
            $md = $this->input->post('model');
            $modelData = explode(',', $md);

            foreach ($modelData as $key => $val) {

                $dataModelArray['name'] = $modelData[$key];
                $this->mst_model->insert($dataModelArray);
            }


            redirect('master/model');
        }
        //End of add model

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "edit") {

//            echo '<pre>', print_r($_POST);die;

            $dataModelArrayUpdate = array(
                'make_id' => $this->input->post('make'),
                'year_id' => $this->input->post('year'),
                'name' => $this->input->post('model'),
                'isactive' => $this->input->post('isactive'),
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            $this->mst_model->update_model($modelId, $dataModelArrayUpdate);
            redirect('master/model');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "delete") {

            $this->mst_model->delete_model($modelId);
            redirect('master/model');
        }

        $this->data['page_title'] = 'Manage Model';

        $this->data['model_detail'] = $this->mst_model->get_make_detail();
        $this->data['make_dropdown'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['year_dropdown'] = array('' => 'Select Year') + $this->mst_year->dropdown('name');
        $this->data['isactive'] = array('' => 'Select Status', '0' => 'Active', '1' => 'In-Active');

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'master/_model', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }


}
