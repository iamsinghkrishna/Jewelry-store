<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->language(array('product_lang'));

        /* Load Backend model */
        $this->load->model(array('users', 'backend/group_model', 'backend/pattribute', 'backend/pattribute_sub'));
        $this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category'));

        /* Load Master model */
        $this->load->model(array('master/mst_make', 'master/mst_model', 'master/mst_year'));

        /* Load Product model */
        $this->load->model(array('backend/product_attribute', 'backend/product', 'backend/product_images'));

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

    public function product_category($action = null, $pId = null) {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "add") {

//            echo '<pre>', print_r($_POST);
//            die;

            $dataProductCategory = array(
                'name' => $this->input->post('category_name'),
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );

            $insertedPID = $this->product_category->insert($dataProductCategory);

            $productSubCatArray = array(
                'p_category_id' => $insertedPID,
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );

            $productSubCat = $this->input->post('parent_id');


            foreach ($productSubCat as $key => $subData) {
                if ($productSubCat[$key] != 0) {
                    $productSubCatArray['p_sub_category_id'] = $productSubCat[$key];
                    $this->product_sub_category->insert($productSubCatArray);
                }
            }

            redirect('admin/product_category');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "edit") {

            $dataProductCategoryUpdate = array(
                'name' => $this->input->post('category_name'),
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            $this->product_category->update($pId, $dataProductCategoryUpdate);

            $this->product_sub_category->delete_sub_cat($pId);

            $productSubCat = $this->input->post('parent_id');
            $productSubCat = array_unique($productSubCat);

            $productSubCatEditArray = array(
                'p_category_id' => $pId,
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            foreach ($productSubCat as $key => $subData) {
                if ($productSubCat[$key] != 0) {
                    $productSubCatEditArray['p_sub_category_id'] = $productSubCat[$key];
                    $this->product_sub_category->insert($productSubCatEditArray);
                }
            }

            redirect('admin/product_category');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "delete") {

            $this->product_category->delete_cat($pId);
            $this->product_sub_category->delete_sub_cat($pId);
            echo json_encode(array('content' => 'success'));
            die;
        }

        $this->data['page_title'] = 'Manage Products Category';
        $this->data['total_users'] = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
//        echo '<pre>', print_r($this->data['prodcut_cat_detail']);;die;

        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {

            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
//        echo '<pre>', print_r($this->data['prodcut_cat_detail']);;die;
//        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all_details();
        $this->data['attt_category'] = array('' => 'Select Attribute') + $this->pattribute->dropdown('attrubute_value');

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'mng_product/_view_p_category', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function product($action = null, $productId = null) {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);


        $this->data['total_users'] = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year') + $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model') + $this->mst_model->dropdown('name');

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);

        $this->data['product_details'] = $this->product->as_array()->get_all();
        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);

        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);



        if ($_SERVER['REQUEST_METHOD'] == 'GET' && $action === 'add') {
            $this->data['page_title'] = 'Add Products';
            $this->template->write_view('content', 'mng_product/_add_product', $this->data);
        } if ($_SERVER['REQUEST_METHOD'] == 'GET' && $action === 'edit') {

            $this->data['page_title'] = 'Edit Products';
            $this->data['product_details'] = $this->product->as_array()->get($productId);
            $this->data['product_details']['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($this->data['product_details']['id']);
            $this->data['product_details']['product_images_details'] = $this->product_images->as_array()->get_by_id($this->data['product_details']['id']);
            $this->data['isactive'] = array('' => 'Select Status', '0' => 'Active', '1' => 'In-Active');
            $this->template->write_view('content', 'mng_product/_edit_product', $this->data);
        } else {
            $this->data['page_title'] = 'Manage Products';
            $this->template->write_view('content', 'mng_product/_view_product', $this->data);
        }
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function attirbutes($action = null, $attrId = null) {

        if ($this->session->userdata('user_id'))
            $user_id = $this->session->userdata('user_id');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "add") {

            $dataAttributeArray = array(
                'parent_id' => $this->input->post('parent_id'),
                'attrubute_value' => $this->input->post('attribute_value'),
                'attribute_type' => $this->input->post('attribute_type'),
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );
            $insertAttrId = $this->pattribute->insert($dataAttributeArray);

            $dataSubAttributeArray = array(
                'attribute_id' => $insertAttrId,
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );

            $subAttributeName = $this->input->post('sub_attribute_name');
            $subAttributeVales = $this->input->post('tags');

            $subCount = count($subAttributeName);
            if ($subCount > 0)
                for ($i = 0; $i < $subCount; $i++) {
                    if ($subAttributeName[$i] != NULL) {
                        foreach ($subAttributeName as $key => $val)
                            $dataSubAttributeArray['sub_name'] = $subAttributeName[$i];

                        foreach ($subAttributeVales as $keySub => $valSub)
                            $dataSubAttributeArray['sub_value'] = $subAttributeVales[$i];
                        $this->pattribute_sub->insert($dataSubAttributeArray);
                    }
                }

            redirect('admin/attirbutes');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "edit") {

//            echo '<pre>', print_r($_POST);
//            die;
            $dataAttributeUpdateArray = array(
                'parent_id' => $this->input->post('parent_id'),
                'attrubute_value' => $this->input->post('attribute_value'),
                'attribute_type' => $this->input->post('attribute_type'),
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );
            $this->pattribute->update($attrId, $dataAttributeUpdateArray);

            $dataSubAttributeArray = array(
                'attribute_id' => $attrId,
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            $subAttributeName = $this->input->post('sub_attribute_name');
            $subAttributeVales = $this->input->post('tags');

            $this->pattribute_sub->delet_attr($attrId, $dataSubAttributeArray);

            $subCount = count($subAttributeName);
            if ($subCount > 0)
                for ($i = 0; $i < $subCount; $i++) {
                    if ($subAttributeName[$i] != NULL) {
                        foreach ($subAttributeName as $key => $val)
                            $dataSubAttributeArray['sub_name'] = $subAttributeName[$i];

                        foreach ($subAttributeVales as $keySub => $valSub)
                            $dataSubAttributeArray['sub_value'] = $subAttributeVales[$i];
                        $this->pattribute_sub->insert($dataSubAttributeArray);
                    }
                }

            redirect('admin/attirbutes');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "delete") {

            $this->pattribute->delete($attrId);
            $this->pattribute_sub->delete($attrId);
            echo json_encode(array('content' => 'success'));
            die;
        }


        $this->data['attribute_details'] = $this->pattribute->as_array()->get_all();
        $this->data['attt_category'] = array('' => 'Select Parent') + $this->pattribute->dropdown('attrubute_value');

        foreach ($this->data['attribute_details'] as $key => $dataAtt) {
            $this->data['attribute_details'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['id']);
        }

//        echo '<pre>', print_r($this->data['attribute_details']);;die;
//        $this->data['attribute_details'] = $this->pattribute->get_attributes_dt();

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Manage Attributes';
        $this->data['total_users'] = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'mng_product/_view_attributes', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function ajax_product_category() {

        $options = array();
        $this->data['attt_category'] = array('' => 'Select Attribute') + $this->pattribute->dropdown('attrubute_value');
        $select = '<div class="form-group"><select class="form-control" name="parent_id[]">';
        foreach ($this->data['attt_category'] as $key => $val)
            $select .= '<option value="' . $key . '">' . $val . '</option>';
        $select .= '</select></div>';

        echo json_encode(array('content' => $select));
        die;
    }

    public function get_attributes($method = null) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product_id = $this->input->post('product_id');
            $product_category_id = $this->input->post('product_category_id');

            if ($method == 'edit') {
                $this->data['prodcut_cat_edit_detail'] = $this->product_attribute->get_by_id($product_id);

//                echo '<pre>';print_r($this->data['prodcut_cat_edit_detail']);die;
                $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);

                foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                    $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
                }
//                echo '<pre>aa', print_r($this->data['prodcut_cat_detail'] );
//                echo '/********************************************************************************/';
//                echo '<pre>aa', print_r($this->data['prodcut_cat_edit_detail']);die;
//                die;
                foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {

                    if (isset($this->data['prodcut_cat_detail'][$key]['sub_attribute_details']))
                        foreach ($this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] as $k => $subAttrData) {
//                            if($this->data['prodcut_cat_edit_detail'][$k]['id'] == $subAttrData['id'])
                            foreach ($this->data['prodcut_cat_edit_detail'] as $catEdit) {
                                if ($this->data['prodcut_cat_detail'][$key]['attribute_type'] == '0' && isset($this->data['prodcut_cat_edit_detail'][$k]['sub_attribute_value'])) {
                                    if ($catEdit['sub_attribute_id'] == $subAttrData['id']) {
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_value'] = $this->data['prodcut_cat_edit_detail'][$k]['sub_attribute_value'];
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_update_id'] = $this->data['prodcut_cat_edit_detail'][$k]['id'];
                                    }
                                }

//                            if($this->data['prodcut_cat_edit_detail'][$k]['id'] == $subAttrData['id'])
                                if ($this->data['prodcut_cat_detail'][$key]['attribute_type'] == '1') {
                                    if ($catEdit['sub_attribute_id'] == $subAttrData['id']) {
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_attribute_dp_id'] = $catEdit['sub_attribute_dp_id'];
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_update_id'] = $catEdit['id'];
                                    }
                                }
                            }
                        }
                }
//                echo '<pre>aa', print_r($this->data['prodcut_cat_detail']);die;

                $attribute_edit_view = $this->load->view('mng_product/_div_edit_attributes', $this->data, TRUE);
                echo json_encode(array('content' => $attribute_edit_view));
                die;
            } if ($method == 'add') {

                $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);

                foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                    $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
                }
                $this->data['prodcut_cat_detail'];
                $attribute_view = $this->load->view('mng_product/_div_attributes', $this->data, TRUE);

                echo json_encode(array('content' => $attribute_view));
                die;
                die;
            }
        }
    }

    public function dpFilter($dpType = null) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $dpType === 'make') {

            $make_id = $this->input->post('product_make_id');
            $this->data['year_category'] = $this->mst_year->get_all_year_by_make_id($make_id);

            $st = '<option value="">Select Year</option>';
            foreach ($this->data['year_category'] as $key => $val)
                $st .= ' <option value="' . $val['id'] . '">' . $val['name'] . '</option>';
            echo json_encode(array('content' => $st));
            die;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $dpType === 'year') {

            $year_id = $this->input->post('product_year_id');
            $make_id = $this->input->post('product_make_id');
            $this->data['model_category'] = $this->mst_model->get_all_model_by_id($year_id, $make_id);

            $st = '<option value="">Select Model</option>';
            foreach ($this->data['model_category'] as $key => $val)
                $st .= ' <option value="' . $val['id'] . '">' . $val['name'] . '</option>';
            echo json_encode(array('content' => $st));
            die;
        }
    }

    public function manage_product($method, $productId = null) {

        if ($this->session->userdata('user_id'))
            $user_id = $this->session->userdata('user_id');

        $flag = '0';

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method === 'add') {
//            echo "<pre>";print_r($_POST);die;
            /* End of file upload */

            $dataProductArray = array(
                'product_name' => $this->input->post('product_name'),
                'product_is_feature' => $this->input->post('product_is_feature'),
                'category_id' => $this->input->post('product_category'),
                'make_id' => $this->input->post('product_make'),
                'year_id' => $this->input->post('product_year'),
                'model_id' => $this->input->post('product_model'),
                'quantity' => $this->input->post('product_quantity'),
                'price' => $this->input->post('product_price'),
                'product_sku' => $this->input->post('product_sku'),
                'shipping_region' => $this->input->post('product_shipping_region'),
                'description' => $this->input->post('product_desc'),
                'sheeping_fees' => $this->input->post('product_shipping_fees'),
                'warrenty' => $this->input->post('product_warr'),
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );

            $productId = $this->product->insert($dataProductArray);

            $productSlug = $productId; //. '_' . $this->input->post('product_category');
            /* file upload */
            if (isset($_FILES['product_images']) && !empty($_FILES['product_images'])) {

                $totalImageUploadCnt = count($_FILES['product_images']['name']);

                $targetDir = "backend/uploads/";
                for ($i = 0; $i < $totalImageUploadCnt; $i++) {
                    $fileName = $_FILES['product_images']['name'][$i];
                    $targetFile = $targetDir . $fileName;

                    $uploded_file_path = $this->handleUpload($productSlug, $_FILES['product_images']['name'][$i], $_FILES['product_images']['tmp_name'][$i]);
                    if ($uploded_file_path != '') {
                        $dataProductImagesArray = array(
                            'product_id' => $productId,
                            'uploded_by' => $user_id,
                            'url' => $uploded_file_path,
                            'type' => $_FILES['product_images']['type'][$i],
                            'createdby' => $user_id,
                            'createddate' => date('Y-m-d H:m:s'),
                        );
                        $this->product_images->insert($dataProductImagesArray);
                    }
                }
            }

            /* End of file upload */


            /* Prodcut Attributes & Sub Attributes */

            $product_category_id = $this->input->post('product_category');
            $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);
            foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
            }

            if (isset($this->data['prodcut_cat_detail'])) {
                foreach ($this->data['prodcut_cat_detail'] as $key => $attr_data) {

                    if (isset($attr_data['sub_attribute_details']))
                        foreach ($attr_data['sub_attribute_details'] as $attr_sub_data) {
                            if ($this->input->post('attr_input_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']) || $this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'])) {

                                if ($attr_data['attribute_type'] == '0') {
                                    $dataProductAttributeArray = array(
                                        'product_id' => $productId,
                                        'attribute_id' => $attr_sub_data['attribute_id'],
                                        'attribute_type' => '0',
                                        'attribute_value' => $attr_data['attrubute_value'],
                                        'sub_attribute_id' => $attr_sub_data['id'],
                                        'sub_attribute_value' => $this->input->post('attr_input_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']),
                                        'createdby' => $user_id,
                                        'createddate' => date('Y-m-d H:m:s'),
                                    );
                                    $this->product_attribute->insert($dataProductAttributeArray);
                                } else if ($this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'])) {

                                    $dataProductAttributeArray = array(
                                        'product_id' => $productId,
                                        'attribute_id' => $attr_sub_data['attribute_id'],
                                        'attribute_type' => '1',
                                        'attribute_value' => $attr_data['attrubute_value'],
                                        'sub_attribute_id' => $attr_sub_data['id'],
                                        'sub_attribute_value' => $this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']),
                                        'sub_attribute_dp_id' => $this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']),
                                        'createdby' => $user_id,
                                        'createddate' => date('Y-m-d H:m:s'),
                                    );
                                    $this->product_attribute->insert($dataProductAttributeArray);
                                }
                            }
                        }
                }
            }
            /* Prodcut Attributes & Sub Attributes */
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method === 'edit') {
//            echo '<pre>', print_r($_POST);
//            die;
            $dataProductUpdateArray = array(
                'product_name' => $this->input->post('product_name'),
                'product_is_feature' => $this->input->post('product_is_feature'),
                'category_id' => $this->input->post('product_category'),
                'make_id' => $this->input->post('product_make'),
                'year_id' => $this->input->post('product_year'),
                'model_id' => $this->input->post('product_model'),
                'quantity' => $this->input->post('product_quantity'),
                'price' => $this->input->post('product_price'),
                'product_sku' => $this->input->post('product_sku'),
                'shipping_region' => $this->input->post('product_shipping_region'),
                'description' => $this->input->post('product_desc'),
                'sheeping_fees' => $this->input->post('product_shipping_fees'),
                'warrenty' => $this->input->post('product_warr'),
                'isactive' => $this->input->post('isactive'),
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            $this->product->update($productId, $dataProductUpdateArray);

            $productSlug = $productId; //. '_' . $this->input->post('product_category');
            /* file upload */
            if (!empty($_FILES['product_images']['name'][0]))
                if (isset($_FILES['product_images']) && !empty($_FILES['product_images'])) {

                    $totalImageUploadCnt = count($_FILES['product_images']['name'][0]);
                    echo $totalImageUploadCnt;
                    $targetDir = "backend/uploads/";
                    for ($i = 0; $i < $totalImageUploadCnt; $i++) {
                        $fileName = $_FILES['product_images']['name'][$i];
                        $targetFile = $targetDir . $fileName;

                        $uploded_file_path = $this->handleUpload($productSlug, $_FILES['product_images']['name'][$i], $_FILES['product_images']['tmp_name'][$i]);
                        if ($uploded_file_path != '') {
                            $dataProductImagesArray = array(
                                'product_id' => $productId,
                                'uploded_by' => $user_id,
                                'url' => $uploded_file_path,
                                'type' => $_FILES['product_images']['type'][$i],
                                'createdby' => $user_id,
                                'createddate' => date('Y-m-d H:m:s'),
                            );
                            $this->product_images->insert($dataProductImagesArray);
                        }
                    }
                }

            /* End of file upload */


            /* Prodcut Attributes & Sub Attributes */


            $product_category_id = $this->input->post('product_category');
            $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);

            foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
            }
//            echo '<pre>', print_r($this->data['prodcut_cat_detail']);
//            die;

            if (isset($this->data['prodcut_cat_detail'])) {
                foreach ($this->data['prodcut_cat_detail'] as $key => $attr_data) {

                    if (isset($attr_data['sub_attribute_details']))
                        foreach ($attr_data['sub_attribute_details'] as $attr_sub_data) {
                            if ($this->input->post('attr_input_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id']) || $this->input->post('attr_dropdown_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id'])) {
                                if ($attr_data['attribute_type'] == '0') {
                                    $dataProductAttributeArray = array(
                                        'product_id' => $productId,
                                        'attribute_id' => $attr_sub_data['attribute_id'],
                                        'attribute_type' => '0',
                                        'attribute_value' => $attr_data['attrubute_value'],
                                        'sub_attribute_id' => $attr_sub_data['id'],
                                        'sub_attribute_value' => $this->input->post('attr_input_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id']),
                                        'createdby' => $user_id,
                                        'createddate' => date('Y-m-d H:m:s'),
                                    );
//                                    echo '<pre>', print_r($dataProductAttributeArray);

                                    $updateId = $this->input->post('attr_input_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id'] . '_input');
                                    $this->product_attribute->update_attr($updateId, $dataProductAttributeArray);
//                                     echo $this->db->last_query();
//                                     echo '<br>';
                                } else if ($this->input->post('attr_dropdown_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id'])) {

                                    $dataProductAttributeArray = array(
                                        'product_id' => $productId,
                                        'attribute_id' => $attr_sub_data['attribute_id'],
                                        'attribute_type' => '1',
                                        'attribute_value' => $attr_data['attrubute_value'],
                                        'sub_attribute_id' => $attr_sub_data['id'],
                                        'sub_attribute_value' => $this->input->post('attr_dropdown_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id']),
                                        'sub_attribute_dp_id' => $this->input->post('attr_dropdown_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id']),
                                        'createdby' => $user_id,
                                        'createddate' => date('Y-m-d H:m:s'),
                                    );
//                                    echo '<pre>', print_r($dataProductAttributeArray);
//                                    echo '<pre>', 'attr_dropdown_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id'];
                                    $updateId = $this->input->post('attr_dropdown_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id'] . '_input');

                                    $this->product_attribute->update_attr($updateId, $dataProductAttributeArray);
//                                    echo $this->db->last_query();
//                                    echo '<br>';
                                }
                            }
                        }
                }
            }
//            die;
            /* Prodcut Attributes & Sub Attributes */
        }

        redirect('admin/product');
    }

    function handleUpload($slug, $upFileName, $upFileTmpName) {

        $fileTypes = array('jpeg', 'png', 'jpg'); // File extensions
        $fileParts = pathinfo($upFileName);

        if (!in_array(strtolower($fileParts['extension']), $fileTypes)) {
            $this->session->set_flashdata('msg', 'File type not supported.');
            return false;
        }

        $ext = pathinfo($upFileName, PATHINFO_EXTENSION);
        $targetURL = '/backend/uploads/product/'; // Relative to the root
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'product' . DIRECTORY_SEPARATOR . $slug;

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

    public function delete($attr = null) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $attr === 'images') {
            $imgId = $this->input->post('imageId');
            $this->product_images->delet_img($imgId);
            return true;
        }
    }

    public function offer() {


        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year') + $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model') + $this->mst_model->dropdown('name');
        $this->data['product_details'] = $this->product->as_array()->get_all();
        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);

        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);

        $pageTitle = "Manage Offer";
        $renderTo = "mng_product/_offer";
        $viewData = $this->data;
        $this->_render_view($pageTitle, $renderTo, $viewData);
    }

    public function _render_view($pageTitle, $renderTo, $viewData) {
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = $pageTitle;
        $this->data['total_users'] = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', $renderTo, $viewData);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

}
