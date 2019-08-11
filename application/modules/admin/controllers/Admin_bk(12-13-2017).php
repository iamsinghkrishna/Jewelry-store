<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//ini_set('display_startup_errors',1);
//ini_set('display_errors',1);
//error_reporting(-1);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST,REQUEST');

class Admin extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
//ini_set('max_input_vars', 10000);
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation', 'clover'));
        $this->load->language(array('product_lang'));

        /* Load Backend model */
        $this->load->model(array('users', 'backend/group_model', 'backend/pattribute',
            'backend/pattribute_sub'));
        $this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category'));

        /* Load Master model */
        $this->load->model(array('master/mst_make', 'master/mst_model', 'master/mst_year',
            'backend/coupon_category', 'backend/coupon_method', 'backend/coupon_method_tax',
            'backend/coupon_group', 'common_model', 'Common_model_marketing'));
        $this->flexi = new stdClass;

        $this->load->library('flexi_cart');

        /* PHPExcel Library */
        $this->load->library('excel');

        /* Load Product model */
        $this->load->model(array('backend/product_attribute', 'backend/product',
            'backend/product_images'));

        $this->load->model(array('users', 'backend/orders_summary', 'backend/orders_details',
            'demo_cart_admin_model'));

        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter',
                'ion_auth'),
            $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
    }

// redirect if needed, otherwise display the user list
    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title']       = 'Administrator Dashboard';
        $this->data['total_users']      = count($this->users->get_all());
        $con                            = "MONTH(`ord_date`)=".date('m')." and ord_status=4";
        $this->data['total_sell']       = $this->common_model->getRecords('order_summary',
            'sum(ord_total) as total_sell', $con);
        $this->data['completed_orders'] = $this->common_model->getRecords('order_summary',
            'count(*) as completed_orders', $con);
        $con2                           = "MONTH(`ord_date`)=".date('m')." and (ord_status=1 or ord_status=2)";
        $this->data['pending_orders']   = $this->common_model->getRecords('order_summary',
            'count(*) as pending_orders', $con2);

        $con1                       = "MONTH(`ord_date`)=".date('m');
        $this->data['total_orders'] = $this->common_model->getRecords('order_summary',
            'count(*) as total_orders', $con1);

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'simple_page', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function product_category($action = null, $pId = null)
    {
        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "add") {

//            echo '<pre>', print_r($_POST);
//            die;
            $cat_img    = array();
            $targetURL  = 'media/backend/img/category_img/'; // Relative to the root
            $targetPath = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'category_img'.DIRECTORY_SEPARATOR.$slug;

            if (!file_exists($targetPath)) {
                mkdir($targetPath, 0777, true);
            }
            $config['upload_path']   = $targetURL;
            $config['allowed_types'] = 'png|jpg|gpeg';
            $config['max_size']      = 1000;
            $config['max_width']     = 1024;
            $config['max_height']    = 768;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('product_cat_image')) {
//array_push($modal_img, $this->input->post('logo_edit'));
            } else {
                $data      = array('upload_data' => $this->upload->data());
//print_r($data);
                $file_path = $targetURL.$data['upload_data']['file_name'];
                array_push($cat_img, $file_path);
            }
//                print_r($cat_img);
//                die();
            $dataProductCategory = array(
                'name' => $this->input->post('category_name'),
                'description' => $this->input->post('category_description'),
                'is_subcategory' => ($this->input->post('is_subcategory') != '')
                    ? $this->input->post('is_subcategory') : '0',
                'createdby' => $user_id,
//                'img_url' => $cat_img[0],
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

            $img_url = array();

            $config['upload_path']   = 'media/backend/img/category_img/';
            $config['allowed_types'] = 'jpg|png';
            $config['max_size']      = 1000;
            $config['max_width']     = 1024;
            $config['max_height']    = 768;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('product_cat_image')) {
                array_push($img_url, $this->input->post('img_url'));
            } else {
                $data = array('upload_data' => $this->upload->data());

                if ($data['upload_data']['file_name'] == '') {
                    array_push($img_url, $this->input->post('img_url'));
                } else {

                    $file_path = 'media/backend/img/category_img/'.$data['upload_data']['file_name'];
                    array_push($img_url, $file_path);
                }
            }
// print_r($img_url);die();

            $dataProductCategoryUpdate = array(
                'name' => $this->input->post('category_name'),
                'description' => $this->input->post('category_description_'.$pId),
//                'is_wheel' => $this->input->post('product_is_wheel_' . $pId),
                'modifiedby' => $user_id,
//                'img_url' => $img_url[0],
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

        $this->data['page_title']   = 'Manage Products Category';
        $this->data['total_users']  = count($this->users->get_all());
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
        $this->template->write_view('content', 'mng_product/_view_p_category',
            $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function product($action = null, $productId = null)
    {
        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $this->data['excel_row']      = null;
        $this->data['excel_row_data'] = null;
        $user_id                      = $this->session->userdata('user_id');
        $this->data['dataHeader']     = $this->users->get_allData($user_id);


        $this->data['total_users']  = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->data['product_category']     = $this->product_category->dropdown('name');
//        $this->data['product_csv_category'] = array('' => 'Select Category', 'all' => 'All') + $this->product_category->dropdown('name');
        $this->data['product_csv_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
//$this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
//$this->data['product_year'] = array('' => 'Select Year') + $this->mst_year->dropdown('name');
        $this->data['product_model']        = array('' => 'Select Model') + $this->mst_model->dropdown('name');

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);

        $this->data['product_details'] = $this->product->as_array()->get_all();

        if (count($this->data['product_details']) > 0) {
            foreach ($this->data['product_details'] as $key => $value) {
                $category_ids     = $value['category_id'];
                $arr_category_ids = explode(',', $category_ids);
                if (count($arr_category_ids) > 0) {
                    $arr_category = array();
//echo '<pre>';print_r($arr_category_ids);die;
                    foreach ($arr_category_ids as $k => $category) {
                        $arr_category[] = $this->common_model->getRecords('it_product_category',
                            'name', array("id" => $category));
                    }

                    $this->data['product_details'][$key]['arr_category'] = $arr_category;
                }
            }
        }

        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);


        if ($_SERVER['REQUEST_METHOD'] == 'GET' && $action === 'add') {

//$this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute_all();
            $conditions                      = "parent_id > 0 AND isactive='0'";
            $this->data['arr_sub_attribute'] = $this->common_model->getRecords('p_attributes',
                'id,parent_id,attrubute_value', $conditions, 'id desc');

//echo '<pre>';print_R($this->data['arr_sub_attribute']);
            $this->data['page_title'] = 'Add Products';
            $this->template->write_view('content', 'mng_product/_add_product',
                $this->data);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET' && $action === 'addcsv') {
            $this->data['page_title'] = 'Add Products';
//            $this->session->set_flashdata("msg", "Product CSV Added successfully!");
            $this->template->write_view('content',
                'mng_product/_add_product_csv', $this->data);
        }
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && $action === 'exportcsv') {


            $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
//        $this->data['product_csv_category'] = array('' => 'Select Category', 'all' => 'All') + $this->product_category->dropdown('name');
            $this->data['product_make']     = array('' => 'Select Make') + $this->mst_make->dropdown('name');
            $this->data['product_year']     = array('' => 'Select Year'); // + $this->mst_year->dropdown('name');
            $this->data['product_model']    = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');

            $this->data['product_details'] = $this->product->get_products();
            foreach ($this->data['product_details'] as $key => $productData) {
                $this->data['product_details'][$key]['product_attr_details']   = $this->product_attribute->as_array()->get_by_id($productData['id']);
                $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($productData['id']);
            }

            $tireData  = array();
            $wheelData = array();
            $partsData = array();
            foreach ($this->data['product_details'] as $key => $productData) {
                $this->data['product_details'][$productData['category_id']]['prodcut_cat_edit_detail']
                    = $this->product_attribute->get_by_id($productData['id']);
            }
//            echo '<pre>', print_r($this->data['product_details']);
//            die;

            foreach ($this->data['product_details'] as $key => $productData) {
//                if ($productData['category_id'] == 1) {
                $make         = '';
                $product_year = '';
                $model_id     = '';
                if (isset($this->data['product_make'][$productData['make_id']]))
                        $make         = $this->data['product_make'][$productData['make_id']];
                if (isset($this->data['product_year'][$productData['year_id']]))
                        $product_year = $this->data['product_year'][$productData['year_id']];
                if (isset($this->data['product_model'][$productData['model_id']]))
                        $model_id     = $this->data['product_model'][$productData['model_id']];

                $tireData[$key] = array(
                    'product_sku' => $productData['product_sku'],
                    'product_name' => $productData['product_name'],
                    'category' => $this->data['product_category'][$productData['category_id']],
                    'make' => $make,
                    'year' => $product_year,
                    'model' => $model_id,
                    'brand' => '1',
                    'description' => $productData['description'],
                    'qty' => $productData['quantity'],
                );

                foreach ($productData['product_attr_details'] as $j => $attrDetail) {
                    $tireData[$key][$j] = $attrDetail['sub_attribute_value'];
                }
//                }
//                foreach ($productData['product_images_details'] as $l => $attrImgDetail) {
//                    $tireData[$l][$key] = $attrImgDetail['url'];
//                }
            }
//            echo '<pre>', print_r($tireData);die;



            $spreadsheet = new PHPExcel();

            $filename = 'itireonline_products_'.date('d-F-Y_h:i:s').'.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');

            $spreadsheet->setActiveSheetIndex(0);

            $worksheetAss = $spreadsheet->getActiveSheet();

            $CommonSheetTitles = array(
                'ITEM_NUMBER', 'ITEM_NAME', 'CATEGORY',
                'MAKE', 'YEAR', 'MODEL',
                'BRAND', 'DESCRIPTION', 'PRICE', 'QTY AVAILABLE', 'ATTR_1', 'ATTR_2',
                'ATTR_3', 'ATTR_4', 'ATTR_5', 'ATTR_6',
                'ATTR_7', 'ATTR_8', 'ATTR_9', 'ATTR_10', 'ATTR_11',);

            $colTitle = 0;

            foreach ($CommonSheetTitles as $sheetData) {
                $worksheetAss->SetCellValueByColumnAndRow($colTitle, 1,
                    strtoupper($sheetData));
                $colTitle++;
            }

            $colCnt = 0;
            $rowCnt = 2;
//        var_dump($leaveReportDataArray);die;
//                unset($assRowData['user_id']);
            foreach ($CommonSheetTitles as $productTitle) {
                foreach ($tireData as $productData) {
                    foreach ($productData as $value) {
                        $worksheetAss->SetCellValueByColumnAndRow($colCnt,
                            $rowCnt, $value);
                        $colCnt++;
                    }
                    $colCnt = 0;
                    $rowCnt++;
                }
            }


            $writer = PHPExcel_IOFactory::createWriter($spreadsheet, 'Excel2007');

// This line will force the file to download
            ob_end_clean();
            $writer->save('php://output');
            exit();

            $this->data['page_title'] = 'Add Products';
            $this->template->write_view('content',
                'mng_product/_add_product_csv', $this->data);
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action === 'addcsv') {
            if (($_FILES["userfile"])) {
                $filename  = $_FILES["userfile"]["tmp_name"];
                $fileTypes = array('xlsx', 'xls', 'csv'); // File extensions
                $fileParts = pathinfo($_FILES['userfile']['name']);

                if (!in_array(strtolower($fileParts['extension']), $fileTypes)) {
                    $this->session->set_flashdata('msg',
                        'File type not supported.');
                    redirect('admin/product/addcsv');
                }
                $objPHPExcel     = PHPExcel_IOFactory::load($filename);
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

                foreach ($cell_collection as $cell) {
                    $column     = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row        = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

//header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1) {
                        $header[$row][$column] = $data_value;
                    } else {
                        $arr_data[$row][$column] = $data_value;
                    }
                }
                $excel_row_data = $arr_data;
                if (!empty($excel_row_data)) {
                    foreach ($excel_row_data as $rowData) {
                        if ($rowData['B'] != '') {
                            $arr_product_details                      = $this->common_model->getRecords('it_products',
                                'id',
                                array("product_name" => trim($rowData['B'])));
//                        if(count($arr_product_details) < 1){
                            $dataProductArray['category_id']          = trim($rowData['G']);
                            $dataProductArray['sub_category_id']      = trim($rowData['H']);
                            $dataProductArray['product_sku']          = trim($rowData['A']);
                            $dataProductArray['product_name']         = trim($rowData['B']);
                            $dataProductArray['description']          = trim($rowData['C']);
                            $dataProductArray['quantity']             = trim($rowData['E']);
                            $dataProductArray['price']                = trim($rowData['D']);
                            $dataProductArray['shipping_region']      = trim($rowData['F']);
                            $dataProductArray['sub_attribute_id_new'] = trim($rowData['O']);
                            $dataProductArray['back_order_flag']      = trim($rowData['P']);
                            $dataProductArray['variant_color']        = trim($rowData['Q']);
                            $dataProductArray['variant_size']         = trim($rowData['R']);
                            $dataProductArray['createdby']            = $user_id;
                            $dataProductArray['createddate']          = date('Y-m-d H:m:s');

//echo '<pre>';print_r($dataProductArray);die;
                            $productId = $this->product->insert($dataProductArray);

                            if (trim($rowData['J']) != '') {
                                $dataProductImagesArray1 = array(
                                    'product_id' => $productId,
                                    'uploded_by' => $user_id,
                                    'url' => 'backend/uploads/product/bulkImages/'.$rowData['J'],
                                    'hover_img_url' => 'backend/uploads/product/bulkImages/'.$rowData['I'],
                                    'type' => 'png',
                                    'createdby' => $user_id,
                                    'createddate' => date('Y-m-d H:m:s'),
                                );
                                $this->product_images->insert($dataProductImagesArray1);
                            }

                            if (trim($rowData['K']) != '') {
                                $dataProductImagesArray2 = array(
                                    'product_id' => $productId,
                                    'uploded_by' => $user_id,
                                    'url' => 'backend/uploads/product/bulkImages/'.$rowData['K'],
                                    'hover_img_url' => 'backend/uploads/product/bulkImages/'.$rowData['I'],
                                    'type' => 'png',
                                    'createdby' => $user_id,
                                    'createddate' => date('Y-m-d H:m:s'),
                                );
                                $this->product_images->insert($dataProductImagesArray2);
                            }

                            if (trim($rowData['L']) != '') {
                                $dataProductImagesArray3 = array(
                                    'product_id' => $productId,
                                    'uploded_by' => $user_id,
                                    'url' => 'backend/uploads/product/bulkImages/'.$rowData['L'],
                                    'hover_img_url' => 'backend/uploads/product/bulkImages/'.$rowData['I'],
                                    'type' => 'png',
                                    'createdby' => $user_id,
                                    'createddate' => date('Y-m-d H:m:s'),
                                );

                                $this->product_images->insert($dataProductImagesArray3);
                            }
                            if (trim($rowData['M']) != '') {
                                $dataProductImagesArray5 = array(
                                    'product_id' => $productId,
                                    'uploded_by' => $user_id,
                                    'url' => 'backend/uploads/product/bulkImages/'.$rowData['M'],
                                    'hover_img_url' => 'backend/uploads/product/bulkImages/'.$rowData['I'],
                                    'type' => 'png',
                                    'createdby' => $user_id,
                                    'createddate' => date('Y-m-d H:m:s'),
                                );
                                $this->product_images->insert($dataProductImagesArray5);
                            }

                            if (trim($rowData['N']) != '') {
                                $dataProductImagesArray6 = array(
                                    'product_id' => $productId,
                                    'uploded_by' => $user_id,
                                    'url' => 'backend/uploads/product/bulkImages/'.$rowData['N'],
                                    'hover_img_url' => 'backend/uploads/product/bulkImages/'.$rowData['I'],
                                    'type' => 'png',
                                    'createdby' => $user_id,
                                    'createddate' => date('Y-m-d H:m:s'),
                                );
                                $this->product_images->insert($dataProductImagesArray6);
                            }
//                        }
//                        else{
//                            if(count($arr_product_details) == '1'){
//                                $update_data = array(
//                                    "category_id" =>trim($rowData['G']),
//                                    "sub_category_id" =>trim($rowData['H']),
//                                    "product_sku" =>trim($rowData['A']),
//                                    "description" =>trim($rowData['C']),
//                                    "quantity" =>trim($rowData['E']),
//                                    "price" =>trim($rowData['D']),
//                                    "shipping_region" =>trim($rowData['F']),
//                                    "sub_attribute_id_new" =>$rowData['O'],
//                                );
//                                $condition_to_pass = array("id" => $arr_product_details[0]['id']);
//                                $last_product_update_id = $this->Common_model_marketing->updateRow('it_products', $update_data, $condition_to_pass);
//
//                                $product_id_fk = array($arr_product_details[0]['id']);
//                                $this->common_model->deleteRows($product_id_fk, "it_products_image", "product_id");
//
//
//                                 if(trim($rowData['J']) != ''){
//                                    $dataProductImagesArray1 = array(
//                                        'product_id' => $arr_product_details[0]['id'],
//                                        'uploded_by' => $user_id,
//                                        'url' => 'backend/uploads/product/bulkImages/'.$rowData['J'],
//                                        'hover_img_url' => 'backend/uploads/product/bulkImages/'.$rowData['I'],
//                                        'type' => 'png',
//                                        'createdby' => $user_id,
//                                        'createddate' => date('Y-m-d H:m:s'),
//                                    );
//                                      $id =  $this->product_images->insert($dataProductImagesArray1);
//                                    }
//
//                                    if(trim($rowData['K']) != ''){
//                                    $dataProductImagesArray2 = array(
//                                        'product_id' => $arr_product_details[0]['id'],
//                                        'uploded_by' => $user_id,
//                                        'url' => 'backend/uploads/product/bulkImages/'.$rowData['K'],
//                                        'hover_img_url' => 'backend/uploads/product/bulkImages/'.$rowData['I'],
//                                        'type' => 'png',
//                                        'createdby' => $user_id,
//                                        'createddate' => date('Y-m-d H:m:s'),
//                                    );
//                                    $this->product_images->insert($dataProductImagesArray2);
//                                    }
//
//                                    if(trim($rowData['L']) != ''){
//                                        $dataProductImagesArray3 = array(
//                                            'product_id' => $arr_product_details[0]['id'],
//                                            'uploded_by' => $user_id,
//                                            'url' => 'backend/uploads/product/bulkImages/'.$rowData['L'],
//                                            'hover_img_url' => 'backend/uploads/product/bulkImages/'.$rowData['I'],
//                                            'type' => 'png',
//                                            'createdby' => $user_id,
//                                            'createddate' => date('Y-m-d H:m:s'),
//                                        );
//
//                                    $this->product_images->insert($dataProductImagesArray3);
//                                    }
//                                     if(trim($rowData['M']) != ''){
//                                    $dataProductImagesArray5 = array(
//                                        'product_id' => $arr_product_details[0]['id'],
//                                        'uploded_by' => $user_id,
//                                        'url' => 'backend/uploads/product/bulkImages/'.$rowData['M'],
//                                        'hover_img_url' => 'backend/uploads/product/bulkImages/'.$rowData['I'],
//                                        'type' => 'png',
//                                        'createdby' => $user_id,
//                                        'createddate' => date('Y-m-d H:m:s'),
//                                    );
//                                        $this->product_images->insert($dataProductImagesArray5);
//                                    }
//
//                                    if(trim($rowData['N']) != ''){
//                                    $dataProductImagesArray6 = array(
//                                        'product_id' => $arr_product_details[0]['id'],
//                                        'uploded_by' => $user_id,
//                                        'url' => 'backend/uploads/product/bulkImages/'.$rowData['N'],
//                                        'hover_img_url' => 'backend/uploads/product/bulkImages/'.$rowData['I'],
//                                        'type' => 'png',
//                                        'createdby' => $user_id,
//                                        'createddate' => date('Y-m-d H:m:s'),
//                                    );
//                                    $this->product_images->insert($dataProductImagesArray6);
//                                    }
//
//                            }
//                        }
                        }
                    }
                }
            }
            $this->session->set_userdata("msg",
                "All CSV products added successfully.");
            redirect('admin/product');
        }


        if ($_SERVER['REQUEST_METHOD'] == 'GET' && $action === 'edit') {

            $this->data['page_title']  = 'Edit Products';
            $arr_sub_attribute_details = $this->common_model->getRecords('mst_sub_attributes',
                '*',
                array("id" => $this->data['product_details']['sub_attribute_id_new']));

            if (count($arr_sub_attribute_details) > 0) {
                $arr_sub_attribute_name         = $this->common_model->getRecords('p_attributes',
                    'attrubute_value',
                    array("id" => $arr_sub_attribute_details[0]['attribute_id']));
                $this->data['sub_attribute_id'] = $arr_sub_attribute_name[0]['attrubute_value'];
            } else {
                $this->data['sub_attribute_id'] = '';
            }

            $this->data['product_details'] = $this->product->as_array()->get($productId);

            $this->data['arr_product_variants']                      = $this->common_model->getRecords('product_variants',
                '*', array("product_id_fk" => $productId));
//echo '<pre>';print_r($this->data['product_details']);die;
// $this->data['product_details']['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($this->data['product_details']['id']);
            $this->data['product_details']['product_images_details'] = $this->product_images->as_array()->get_by_id($this->data['product_details']['id']);
//$this->data['tags'] = $this->product->get_product_tags($this->data['product_details']['id']);
//            $array = array_column($this->data['tags'], 'tag_name'); //Get an array of just the app_subject_id column
//            $this->data['tags'] = implode(',', $array);

            $conditions                      = "parent_id > 0 AND isactive='0'";
            $this->data['arr_sub_attribute'] = $this->common_model->getRecords('p_attributes',
                'id,parent_id,attrubute_value', $conditions, 'id desc');



            $data      = file_get_contents("https://api.instagram.com/v1/users/self/media/recent/?access_token=1286777132.527d0ef.53dfb3c625d94880af7cdfc113a3b17a&count=50");
            $result    = json_decode($data);
//            echo "<pre>";
//            print_r($result);
//            die;
            $insta_img = array();
            if (isset($result->data) && !empty($result->data)) {
                foreach ($result->data as $img) {
                    if (isset($img->images) && !empty($img->images) && $img->images
                        != null) {
                        $insta_img[] = $img->images->standard_resolution->url;
                    }
                }
            }
            $this->data['insta_feeds'] = $insta_img;


            $this->data['isactive'] = array('' => 'Select Status', '0' => 'Active',
                '1' => 'In-Active');
            $this->template->write_view('content', 'mng_product/_edit_product',
                $this->data);
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "delete") {



// $this->pattribute_sub->delete($attrId);
//echo json_encode(array('content' => 'success'));
//die;
        }


        if (count($_POST) > 0) {
            if (isset($_POST['btn_delete_all'])) {
                $arr_products_ids = $this->input->post('checkbox');
//echo '<pre>';print_r($arr_products_ids);die;
                if (count($arr_products_ids) > 0) {
                    foreach ($arr_products_ids as $product_id) {
                        if ($product_id != '') {
                            $id = array($product_id);
                            $this->common_model->deleteRows($id, "it_products",
                                "id");
                            $this->common_model->deleteRows($id,
                                "it_products_image", "product_id");
                            $this->common_model->deleteRows($id,
                                "product_variants", "product_id_fk");
                        }
                    }
                }
                $this->session->set_userdata("msg",
                    "Product deleted successfully!");
                redirect('admin/product');
            }
        }
        if ($action == '') {
            $this->data['page_title'] = 'Manage Products';
            $this->template->write_view('content', 'mng_product/_view_product',
                $this->data);
        }
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function product_history($action = null, $productId = null)
    {


        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $this->data['excel_row']      = null;
        $this->data['excel_row_data'] = null;
        $user_id                      = $this->session->userdata('user_id');
        $this->data['dataHeader']     = $this->users->get_allData($user_id);


        $this->data['total_users']  = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->data['product_category']     = array('' => 'Select Category') + $this->product_category->dropdown('name');
//        $this->data['product_csv_category'] = array('' => 'Select Category', 'all' => 'All') + $this->product_category->dropdown('name');
        $this->data['product_csv_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
        $this->data['product_make']         = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year']         = array('' => 'Select Year') + $this->mst_year->dropdown('name');
        $this->data['product_model']        = array('' => 'Select Model') + $this->mst_model->dropdown('name');

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
//$isactive=array('isactive'=>1);
        $this->data['product_details']                               = $this->product->get_all_inactive_product();
//        print_r($this->data['product_details']);        die();
        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);

        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);

        $this->data['size1'] = array(
            "255" => "255",
            "225" => "225",
            "235" => "235",
            "P235" => "P235",
            "275" => "275",
            "P275" => "P275",
            "265" => "265",
            "P265" => "P265",
            "175" => "175",
        );
        $this->data['size2'] = array(
            "30" => "30",
            "35" => "35",
            "45" => "45",
            "50" => "50",
            "55" => "55",
            "60" => "60",
            "65" => "65",
            "70" => "70",
            "75" => "75",
            "80" => "80",
            "85" => "85",
            "90" => "90",
            "95" => "95",
        );
        $this->data['size3'] = array(
            "10" => "10",
            "12" => "12",
            "13" => "13",
            "14" => "14",
            "15" => "15",
            "16" => "16",
            "15" => "15",
            "16.5" => "16.5",
            "17" => "17",
            "17.5" => "17.5",
            "18" => "18",
            "19" => "19",
            "19.5" => "19.5",
            "20" => "20",
        );



        if ($action == '') {
            $this->data['page_title'] = 'Manage History';
            $this->template->write_view('content', 'mng_product/_soft_product',
                $this->data);
        }
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function product_delete_soft($productId)
    {
// echo $productId;die();
        if ($this->product->delete($productId)) {
            redirect('admin/product');
        }
    }

    public function product_delete_hard($productId)
    {
// echo $productId;die();
        if ($this->product->delete_product($productId)) {
            redirect('admin/product_history');
        }
    }

    public function attirbutes($action = null, $attrId = null)
    {

        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        if ($this->session->userdata('user_id'))
                $user_id = $this->session->userdata('user_id');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "add") {

            $dataAttributeArray = array(
                'parent_id' => $this->input->post('parent_id'),
                'attrubute_value' => $this->input->post('attribute_value'),
                'attribute_type' => $this->input->post('attribute_type'),
//                'is_brand' => $this->input->post('product_is_brand'),
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );
            $insertAttrId       = $this->pattribute->insert($dataAttributeArray);

            if ($this->input->post('add_to_clover') && $this->input->post('add_to_clover')
                == '1') {
                $postdata = array('sortOrder' => '1', 'id' => '', 'name' => $this->input->post('attribute_value'));
                $this->load->library('clover');
                $items    = $this->clover->createProductCategory($postdata);
                $items    = (array) $items;

// if(empty($items)){
//     echo "Product deleted successfully";
// }else{
//     echo $items['details'];
// }
            }
//echo $this->db->last_query();die;
            $dataSubAttributeArray = array(
                'attribute_id' => $insertAttrId,
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );

            $subAttributeName  = $this->input->post('sub_attribute_name');
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
//                'is_brand' => $this->input->post('product_is_brand'),
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );
            $this->pattribute->update($attrId, $dataAttributeUpdateArray);

            $dataSubAttributeArray = array(
                'attribute_id' => $attrId,
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            $subAttributeName  = $this->input->post('sub_attribute_name');
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
        $this->data['attt_category']     = array('' => 'Select Parent') + $this->pattribute->dropdown('attrubute_value');
//echo '<pre>', print_r($this->data['attribute_details']);;die;
        foreach ($this->data['attribute_details'] as $key => $dataAtt) {
            $this->data['attribute_details'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['id']);
        }

//        echo '<pre>', print_r($this->data['attribute_details']);;die;
//        $this->data['attribute_details'] = $this->pattribute->get_attributes_dt();

        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title']   = 'Manage Attributes';
        $this->data['total_users']  = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'mng_product/_view_attributes',
            $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function ajax_product_category()
    {

        $options                     = array();
        $this->data['attt_category'] = array('' => 'Select Attribute') + $this->pattribute->dropdown('attrubute_value');
        $select                      = '<div class="form-group"><select class="form-control" name="parent_id[]">';
        foreach ($this->data['attt_category'] as $key => $val)
            $select                      .= '<option value="'.$key.'">'.$val.'</option>';
        $select                      .= '</select></div>';

        echo json_encode(array('content' => $select));
        die;
    }

    public function get_attributes($method = null)
    {
//        echo $_SERVER['REQUEST_METHOD'];die;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product_id          = $this->input->post('product_id');
            $product_category_id = $this->input->post('product_category_id');

            if ($method == 'edit') {
                $this->data['prodcut_cat_edit_detail'] = $this->product_attribute->get_by_id($product_id);


                $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);
//echo '<pre>';print_r($this->data['prodcut_cat_detail']);die;
                foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                    $this->data['prodcut_cat_detail'][$key]['sub_attribute_details']
                        = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
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
                                if ($this->data['prodcut_cat_detail'][$key]['attribute_type']
                                    == '0' && isset($this->data['prodcut_cat_edit_detail'][$k]['sub_attribute_value'])) {
                                    if ($catEdit['sub_attribute_id'] == $subAttrData['id']) {
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_value']
                                            = $this->data['prodcut_cat_edit_detail'][$k]['sub_attribute_value'];
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_update_id']
                                            = $this->data['prodcut_cat_edit_detail'][$k]['id'];
                                    }
                                }

//                            if($this->data['prodcut_cat_edit_detail'][$k]['id'] == $subAttrData['id'])
                                if ($this->data['prodcut_cat_detail'][$key]['attribute_type']
                                    == '1') {
                                    if ($catEdit['sub_attribute_id'] == $subAttrData['id']) {
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_attribute_dp_id']
                                            = $catEdit['sub_attribute_dp_id'];
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_update_id']
                                            = $catEdit['id'];
                                    }
                                }
                            }
                        }
                    if ($this->data['prodcut_cat_detail'][$key]['attribute_type']
                        == '2') {
                        if ($catEdit['sub_attribute_id'] == $subAttrData['id']) {
                            $this->data['prodcut_cat_detail'][$key]['update_id']
                                = $catEdit['id'];
                            $this->data['prodcut_cat_detail'][$key]['plugin_url']
                                = $catEdit['sub_attribute_value'];
                            $this->data['prodcut_cat_detail'][$key]['plugin_id']
                                = $catEdit['sub_attribute_id'];
                            $this->data['prodcut_cat_detail'][$key]['attribute_id']
                                = $catEdit['attribute_id'];
                        }
                    }
                }
//                echo '<pre>aa', print_r($this->data['prodcut_cat_detail']);die;

                $attribute_edit_view = $this->load->view('mng_product/_div_edit_attributes',
                    $this->data, TRUE);
                echo json_encode(array('content' => $attribute_edit_view));
                die;
            } if ($method == 'add') {

                $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);
//echo '<pre>';print_r($this->data['prodcut_cat_detail']);die;
                if (count($this->data['prodcut_cat_detail']) > 0) {
                    foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details']
                            = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
                    }
                    $this->data['prodcut_cat_detail'];
                    $attribute_view = $this->load->view('mng_product/_div_attributes',
                        $this->data, TRUE);

                    echo json_encode(array('content' => $attribute_view));
                } else {
                    echo json_encode(array('content' => ''));
                }
                die;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product_id            = $this->input->post('product_id');
            $product_category_id   = $this->input->post('product_category_id');
            $product_category_name = $this->input->post('product_category_name');
//            get_sub_attributes_at_id($product_category_id);
//            Tire Brand


            if ($method == 'edit') {

                $this->data['prodcut_cat_edit_detail'] = $this->product_attribute->get_by_id($product_id);

// echo '<pre>';
// print_r($this->data['prodcut_cat_edit_detail']);
//die;
                $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);

                foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                    $this->data['prodcut_cat_detail'][$key]['sub_attribute_details']
                        = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
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
                                if ($this->data['prodcut_cat_detail'][$key]['attribute_type']
                                    == '0' && isset($this->data['prodcut_cat_edit_detail'][$k]['sub_attribute_value'])) {
                                    if ($catEdit['sub_attribute_id'] == $subAttrData['id']) {
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_value']
                                            = $this->data['prodcut_cat_edit_detail'][$k]['sub_attribute_value'];
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_update_id']
                                            = $this->data['prodcut_cat_edit_detail'][$k]['id'];
                                    }
                                }

//                            if($this->data['prodcut_cat_edit_detail'][$k]['id'] == $subAttrData['id'])
                                if ($this->data['prodcut_cat_detail'][$key]['attribute_type']
                                    == '1') {
                                    if ($catEdit['sub_attribute_id'] == $subAttrData['id']) {
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_attribute_dp_id']
                                            = $catEdit['sub_attribute_dp_id'];
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_update_id']
                                            = $catEdit['id'];
                                    }
                                }
                            }
                        }
                }
//                echo '<pre>aa', print_r($this->data['prodcut_cat_detail']);die;

                $attribute_edit_view = $this->load->view('mng_product/_div_edit_attributes',
                    $this->data, TRUE);
                echo json_encode(array('content' => $attribute_edit_view));
                die;
            }
            if ($method == 'add') {

                $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);

                foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                    $this->data['prodcut_cat_detail'][$key]['sub_attribute_details']
                        = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
                }
                $this->data['prodcut_cat_detail'];
                $attribute_view = $this->load->view('mng_product/_div_attributes',
                    $this->data, TRUE);

                echo json_encode(array('content' => $attribute_view));
                die;
                die;
            }
            if ($method = 'add_cvs') {

                $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);

                foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                    $this->data['prodcut_cat_detail'][$key]['sub_attribute_details']
                        = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
                }
                $this->data['prodcut_cat_detail'];
                $attribute_view = $this->load->view('mng_product/_div_attributes',
                    $this->data, TRUE);

                echo json_encode(array('content' => $attribute_view));
                die;
                die;
            }
        }
    }

    public function dpFilter($dpType = null)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $dpType === 'make') {

            $make_id                     = $this->input->post('product_make_id');
            $this->data['year_category'] = $this->mst_year->get_all_year_by_make_id($make_id);


            $st = '<option value="">Select Year</option>';
            foreach ($this->data['year_category'] as $key => $val)
                $st .= ' <option value="'.$val['id'].'">'.$val['name'].'</option>';
            echo json_encode(array('content' => $st));
            die;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $dpType === 'year') {

            $year_id                      = $this->input->post('product_year_id');
            $make_id                      = $this->input->post('product_make_id');
            $this->data['model_category'] = $this->mst_model->get_all_model_by_id($year_id,
                $make_id);

            $st = '<option value="">Select Model</option>';
            foreach ($this->data['model_category'] as $key => $val)
                $st .= ' <option value="'.$val['id'].'">'.$val['name'].'</option>';
            echo json_encode(array('content' => $st));
            die;
        }
    }

    public function manage_product($method, $productId = null)
    {

        if ($this->session->userdata('user_id'))
                $user_id = $this->session->userdata('user_id');

        $flag = '0';
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method === 'add') {

            $from_date = $this->input->post('from_date');
            $from_date = str_replace('-', '', $from_date);
            $from_date = date('Y-m-d', strtotime($from_date));

            $to_date = $this->input->post('to_date');
            $to_date = str_replace('-', '', $to_date);
            $to_date = date('Y-m-d', strtotime($to_date));

            $arr_product_category = $this->input->post('product_category');
            $arr_sub_category     = $this->input->post('sub_category');
            $sub_attribute_id     = $this->input->post('sub_attribute_id');
            if (count($sub_attribute_id) > 0) {
                $sub_attribute_id_new = implode(',', $sub_attribute_id);
            } else {
                $sub_attribute_id_new = '';
            }

            $product_category = implode(',', $arr_product_category);
            $sub_category     = implode(',', $arr_sub_category);
//echo '<pre>';print_r($product_category);die;
            $dataProductArray = array(
                'product_name' => $this->input->post('product_name'),
                'product_is_feature' => $this->input->post('product_is_feature'),
                'discounted_price' => $this->input->post('discounted_price'),
                'publish_from' => $from_date,
                'publish_to' => $to_date,
                'is_offer_publish' => $this->input->post('is_offer_product'),
                'category_id' => $product_category,
                'sub_category_id' => $sub_category,
                'quantity' => $this->input->post('product_quantity'),
                'price' => $this->input->post('product_price'),
                'product_sku' => $this->input->post('product_sku'),
                'shipping_region' => $this->input->post('product_shipping_region'),
                'description' => $this->input->post('product_desc'),
                'sheeping_fees' => $this->input->post('product_shipping_fees'),
                'warrenty' => $this->input->post('product_warr'),
                'sub_attribute_id_new' => $sub_attribute_id_new,
                'createdby' => $user_id,
                'back_order_flag' => $this->input->post('back_order_flag'),
                'variant_color' => ($this->input->post('variant_color')) ? strtolower($this->input->post('variant_color'))
                    : NULL,
                'variant_size' => ($this->input->post('variant_size')) ? $this->input->post('variant_size')
                    : NULL,
                'createddate' => date('Y-m-d H:m:s'),
            );
//echo '<pre>';print_R($dataProductArray);die;
            $productId        = $this->product->insert($dataProductArray);

            if ($this->input->post('add_to_clover') && $this->input->post('add_to_clover')) {
                $clvoer_data = array(
                    'modifiedTime' => round(microtime(true) * 1000),
                    'code' => $this->input->post('product_code'),
                    'cost' => $this->input->post('product_cost') * 100,
                    'hidden' => false,
                    'unitName' => $this->input->post('product_name'),
                    'priceType' => $this->input->post('price_type'),
                    'alternateName' => $this->input->post('product_name'),
                    'isRevenue' => false,
                    'price' => $this->input->post('product_price') * 100,
                    'name' => $this->input->post('product_name'),
                    'id' => '',
                    'sku' => $this->input->post('product_sku'),
                );
                $items       = $this->clover->createProduct($clvoer_data);
            }

            /* Insert all product variants */
            if ($productId != '') {
                $total_variants = $this->input->post('total_variants');
                $size           = $this->input->post('varient_name');
                $length         = $this->input->post('varient_value');
                $carat          = $this->input->post('price');
                for ($i = 0; $i <= $total_variants; $i++) {
                    if ($size[$i] != '' || $length[$i] != '' || $carat[$i] != '') {
                        $arr_to_insert          = array(
                            "product_id_fk" => $productId,
                            "varient_name" => $size[$i],
                            "varient_value" => $length[$i],
                            "price" => $carat[$i],
                            "created" => date('Y-m-d H:i:s'),
                        );
                        $last_insert_variant_id = $this->common_model->insertRow($arr_to_insert,
                            "product_variants");
                    }
                }
            }

            if (isset($_FILES['hover_images']['name']) && !empty($_FILES['hover_images']['name'])) {
                $productSlug             = $productId;
                $targetDir               = "backend/uploads/";
                $fileName                = $_FILES['hover_images']['name'];
                $targetFile              = $targetDir.$fileName;
                $uploded_file_path_hover = $this->handleUpload($productSlug,
                    $_FILES['hover_images']['name'],
                    $_FILES['hover_images']['tmp_name']);
            }

            $productSlug = $productId;
            if (isset($_FILES['product_images']['name']) && !empty($_FILES['product_images']['name'])) {

                $totalImageUploadCnt = count($_FILES['product_images']['name']);

                $targetDir = "backend/uploads/";
                for ($i = 0; $i < $totalImageUploadCnt; $i++) {
                    $fileName   = $_FILES['product_images']['name'][$i];
                    $targetFile = $targetDir.$fileName;

                    $uploded_file_path = $this->handleUpload($productSlug,
                        $_FILES['product_images']['name'][$i],
                        $_FILES['product_images']['tmp_name'][$i]);
                    if ($uploded_file_path != '') {
                        $dataProductImagesArray = array(
                            'product_id' => $productId,
                            'uploded_by' => $user_id,
                            'url' => $uploded_file_path,
                            'type' => $_FILES['product_images']['type'][$i],
                            'hover_img_url' => $uploded_file_path_hover,
                            'createdby' => $user_id,
                            'createddate' => date('Y-m-d H:m:s'),
                        );
                        $this->product_images->insert($dataProductImagesArray);
                    }
                }
            }

            /* End of file upload */



            /* Prodcut Attributes & Sub Attributes */

//            $product_category_id = $this->input->post('product_category');
//            $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);
//            foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
//                $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
//            }
//
//            if (isset($this->data['prodcut_cat_detail'])) {
//                foreach ($this->data['prodcut_cat_detail'] as $key => $attr_data) {
//                    //upload png plugin image
//                    if ($attr_data['attribute_type'] == '2') {
////                        echo $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name'];
////                        die;
//                        if(isset($_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name']) && !empty($_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name'])) {
//                            $targetDir = "backend/uploads/";
//
//                            $fileName = $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name'];
//                            $targetFile = $targetDir . $fileName;
//
//                            $uploded_file_path = $this->handleUpload($productSlug, $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name'], $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['tmp_name']);
//
//                            $dataProductAttributeArray = array(
//                                'product_id' => $productId,
//                                'attribute_id' => $attr_sub_data['attribute_id'],
//                                'attribute_type' => '2',
//                                'attribute_value' => $attr_data['attrubute_value'],
//                                'sub_attribute_id' => $attr_sub_data['id'],
//                                'sub_attribute_value' => $uploded_file_path,
//                                'createdby' => $user_id,
//                                'createddate' => date('Y-m-d H:m:s'),
//                            );
//
//                            if ($uploded_file_path != '') {
//                                $dataProductImagesArray = array(
//                                    'product_id' => $productId,
//                                    'uploded_by' => $user_id,
//                                    'url' => $uploded_file_path,
//                                    'type' => $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['type'],
////                                    'is_wheel_plugin' => 1,
//                                    'createdby' => $user_id,
//                                    'createddate' => date('Y-m-d H:m:s'),
//                                );
//                                $this->product_images->insert($dataProductImagesArray);
//                            }
//                        }
//                        $this->product_attribute->insert($dataProductAttributeArray);
//                    }
//                    //end upload png plugin image
//
//                    if (isset($attr_data['sub_attribute_details']))
//                        foreach ($attr_data['sub_attribute_details'] as $attr_sub_data) {
//                            if ($this->input->post('attr_input_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']) || $this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'])) {
//
//                                if ($attr_data['attribute_type'] == '0') {
//                                    $dataProductAttributeArray = array(
//                                        'product_id' => $productId,
//                                        'attribute_id' => $attr_sub_data['attribute_id'],
//                                        'attribute_type' => '0',
//                                        'attribute_value' => $attr_data['attrubute_value'],
//                                        'sub_attribute_id' => $attr_sub_data['id'],
//                                        'sub_attribute_value' => $this->input->post('attr_input_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']),
//                                        'createdby' => $user_id,
//                                        'createddate' => date('Y-m-d H:m:s'),
//                                    );
//                                    $this->product_attribute->insert($dataProductAttributeArray);
//                                } else if ($this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'])) {
//                                    $dataProductAttributeArray = array(
//                                        'product_id' => $productId,
//                                        'attribute_id' => $attr_sub_data['attribute_id'],
//                                        'attribute_type' => '1',
//                                        'attribute_value' => $attr_data['attrubute_value'],
//                                        'sub_attribute_id' => $attr_sub_data['id'],
//                                        'sub_attribute_value' => $this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']),
//                                        'sub_attribute_dp_id' => $this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']),
//                                        'createdby' => $user_id,
//                                        'createddate' => date('Y-m-d H:m:s'),
//                                    );
//                                    $this->product_attribute->insert($dataProductAttributeArray);
//                                }
//                            }
//                        }
//                }
//            }
//            die;
            /* Prodcut Attributes & Sub Attributes */
        }



        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method === 'addcsvdata') {

            $csv_data_count = $this->input->post('csv_data_count');
            if ($csv_data_count < 1) {
                redirect('admin/product/addcsv');
            }
            $dataProductArray = array(
                'category_id' => $this->input->post('product_categoty_id'),
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );
            for ($i = 0; $i < $csv_data_count; $i++) {
                $arr_product_details = $this->common_model->getRecords('it_products',
                    'id',
                    array("product_name" => trim($this->input->post('product_name')[$i])));
                if (count($arr_product_details) < 1) {
                    $sub_attribute_id = trim($this->input->post('product_sub_attribute_new')[$i]);

                    $dataProductArray['category_id']          = trim($this->input->post('product_category')[$i]);
                    $dataProductArray['sub_category_id']      = trim($this->input->post('id_select_sub_part')[$i]);
                    $dataProductArray['product_sku']          = trim($this->input->post('product_sku')[$i]);
                    $dataProductArray['product_name']         = trim($this->input->post('product_name')[$i]);
                    $dataProductArray['description']          = trim($this->input->post('product_description')[$i]);
                    $dataProductArray['quantity']             = trim($this->input->post('product_quantity')[$i]);
                    $dataProductArray['price']                = trim($this->input->post('product_price')[$i]);
                    $dataProductArray['shipping_region']      = trim($this->input->post('product_shipping_region')[$i]);
                    $dataProductArray['sub_attribute_id_new'] = $sub_attribute_id;
                    $dataProductArray['createdby']            = $user_id;
                    $dataProductArray['createddate']          = date('Y-m-d H:m:s');
// echo '<pre>';print_r($dataProductArray);
                    $productId                                = $this->product->insert($dataProductArray);
					$product_sku_old = trim($rowData['A']);
                            if($product_sku_old != ''){
                                $arr_product_details = end($this->common_model->getRecords('it_products_bk', 'clover_id', array('product_sku' => $product_sku_old)));   
                                if(count($arr_product_details) > 0){
                                    $arr_to_update = array("clover_id" => $arr_product_details['clover_id']);
                                    $condition_array = array('product_sku' => $product_sku_old);
                                    $this->common_model->updateRow('it_products', $arr_to_update, $condition_array);
                                }
                            }

                    $productSlug = $productId; //. '_' . $this->input->post('product_category');

                    if (trim($this->input->post('image2')[$i]) != '') {
                        $dataProductImagesArray1 = array(
                            'product_id' => $productId,
                            'uploded_by' => $user_id,
                            'url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image2')[$i],
                            'hover_img_url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image1')[$i],
                            'type' => 'png',
                            'createdby' => $user_id,
                            'createddate' => date('Y-m-d H:m:s'),
                        );
                        $this->product_images->insert($dataProductImagesArray1);
                    }

                    if (trim($this->input->post('image3')[$i]) != '') {
                        $dataProductImagesArray2 = array(
                            'product_id' => $productId,
                            'uploded_by' => $user_id,
                            'url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image3')[$i],
                            'hover_img_url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image1')[$i],
                            'type' => 'png',
                            'createdby' => $user_id,
                            'createddate' => date('Y-m-d H:m:s'),
                        );
                        $this->product_images->insert($dataProductImagesArray2);
                    }

                    if (trim($this->input->post('image4')[$i]) != '') {
                        $dataProductImagesArray3 = array(
                            'product_id' => $productId,
                            'uploded_by' => $user_id,
                            'url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image4')[$i],
                            'hover_img_url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image1')[$i],
                            'type' => 'png',
                            'createdby' => $user_id,
                            'createddate' => date('Y-m-d H:m:s'),
                        );

                        $this->product_images->insert($dataProductImagesArray3);
                    }
                    if (trim($this->input->post('image5')[$i]) != '') {
                        $dataProductImagesArray5 = array(
                            'product_id' => $productId,
                            'uploded_by' => $user_id,
                            'url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image5')[$i],
                            'hover_img_url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image1')[$i],
                            'type' => 'png',
                            'createdby' => $user_id,
                            'createddate' => date('Y-m-d H:m:s'),
                        );
                        $this->product_images->insert($dataProductImagesArray5);
                    }

                    if (trim($this->input->post('image6')[$i]) != '') {
                        $dataProductImagesArray6 = array(
                            'product_id' => $productId,
                            'uploded_by' => $user_id,
                            'url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image6')[$i],
                            'hover_img_url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image1')[$i],
                            'type' => 'png',
                            'createdby' => $user_id,
                            'createddate' => date('Y-m-d H:m:s'),
                        );
                        $this->product_images->insert($dataProductImagesArray6);
                    }

                    if (trim($this->input->post('image7')[$i]) != '') {
                        $dataProductImagesArray7 = array(
                            'product_id' => $productId,
                            'uploded_by' => $user_id,
                            'url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image7')[$i],
                            'hover_img_url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image1')[$i],
                            'type' => 'png',
                            'createdby' => $user_id,
                            'createddate' => date('Y-m-d H:m:s'),
                        );
                        $this->product_images->insert($dataProductImagesArray7);
                    }
                } else {
                    if (count($arr_product_details) == '1') {
                        $sub_attribute_id       = trim($this->input->post('product_sub_attribute_new')[$i]);
                        $update_data            = array(
                            "category_id" => trim($this->input->post('product_category')[$i]),
                            "sub_category_id" => trim($this->input->post('id_select_sub_part')[$i]),
                            "product_sku" => trim($this->input->post('product_sku')[$i]),
                            "description" => trim($this->input->post('product_description')[$i]),
                            "quantity" => trim($this->input->post('product_quantity')[$i]),
                            "price" => trim($this->input->post('product_price')[$i]),
                            "shipping_region" => trim($this->input->post('product_shipping_region')[$i]),
                            "sub_attribute_id_new" => $sub_attribute_id,
                        );
                        $condition_to_pass      = array("id" => $arr_product_details[0]['id']);
                        $last_product_update_id = $this->Common_model_marketing->updateRow('it_products',
                            $update_data, $condition_to_pass);

                        $product_id_fk = array($arr_product_details[0]['id']);
                        $this->common_model->deleteRows($product_id_fk,
                            "it_products_image", "product_id");


                        if (trim($this->input->post('image2')[$i]) != '') {
                            $dataProductImagesArray1 = array(
                                'product_id' => $arr_product_details[0]['id'],
                                'uploded_by' => $user_id,
                                'url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image2')[$i],
                                'hover_img_url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image1')[$i],
                                'type' => 'png',
                                'createdby' => $user_id,
                                'createddate' => date('Y-m-d H:m:s'),
                            );
//echo '<pre>';print_r($dataProductImagesArray1);die;
                            $id                      = $this->product_images->insert($dataProductImagesArray1);
// echo $this->db->last_query();die;
                        }

                        if (trim($this->input->post('image3')[$i]) != '') {
                            $dataProductImagesArray2 = array(
                                'product_id' => $arr_product_details[0]['id'],
                                'uploded_by' => $user_id,
                                'url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image3')[$i],
                                'hover_img_url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image1')[$i],
                                'type' => 'png',
                                'createdby' => $user_id,
                                'createddate' => date('Y-m-d H:m:s'),
                            );
                            $this->product_images->insert($dataProductImagesArray2);
                        }

                        if (trim($this->input->post('image4')[$i]) != '') {
                            $dataProductImagesArray3 = array(
                                'product_id' => $arr_product_details[0]['id'],
                                'uploded_by' => $user_id,
                                'url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image4')[$i],
                                'hover_img_url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image1')[$i],
                                'type' => 'png',
                                'createdby' => $user_id,
                                'createddate' => date('Y-m-d H:m:s'),
                            );

                            $this->product_images->insert($dataProductImagesArray3);
                        }
                        if (trim($this->input->post('image5')[$i]) != '') {
                            $dataProductImagesArray5 = array(
                                'product_id' => $arr_product_details[0]['id'],
                                'uploded_by' => $user_id,
                                'url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image5')[$i],
                                'hover_img_url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image1')[$i],
                                'type' => 'png',
                                'createdby' => $user_id,
                                'createddate' => date('Y-m-d H:m:s'),
                            );
                            $this->product_images->insert($dataProductImagesArray5);
                        }

                        if (trim($this->input->post('image6')[$i]) != '') {
                            $dataProductImagesArray6 = array(
                                'product_id' => $arr_product_details[0]['id'],
                                'uploded_by' => $user_id,
                                'url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image6')[$i],
                                'hover_img_url' => 'backend/uploads/product/bulkImages/'.$this->input->post('image1')[$i],
                                'type' => 'png',
                                'createdby' => $user_id,
                                'createddate' => date('Y-m-d H:m:s'),
                            );
                            $this->product_images->insert($dataProductImagesArray6);
                        }
                    }
                }
            }
            $this->session->set_userdata('msg', 'Product added successfully.');
            redirect('admin/product');
            /* Prodcut Attributes & Sub Attributes */
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method === 'edit') {
            $from_date = $this->input->post('from_date');
            $from_date = str_replace('-', '', $from_date);
            $from_date = date('Y-m-d', strtotime($from_date));

            $to_date = $this->input->post('to_date');
            $to_date = str_replace('-', '', $to_date);
            $to_date = date('Y-m-d', strtotime($to_date));


            if ($this->input->post('is_applicable') == 0) {
                $make_id  = $this->input->post('product_make');
                $year_id  = $this->input->post('product_year');
                $model_id = $this->input->post('product_model');
            } else {
                $make_id  = 0;
                $year_id  = 0;
                $model_id = 0;
            }

            $is_instagram_product_image = $this->input->post('is_instagram_product');


            if ($is_instagram_product_image != '') {
                $is_instagram_product = '1';
            } else {
                $is_instagram_product = '0';
            }


            $arr_product_category = $this->input->post('product_category');
            $arr_sub_category     = $this->input->post('sub_category');
            $sub_attribute_id     = $this->input->post('sub_attribute_id');

            $product_category = implode(',', $arr_product_category);
            $sub_category     = implode(',', $arr_sub_category);

            if (count($sub_attribute_id) > 0) {
                $sub_attribute_id_new = implode(',', $sub_attribute_id);
            } else {
                $sub_attribute_id_new = '';
            }
            $dataProductUpdateArray = array(
                'product_name' => $this->input->post('product_name'),
                'product_is_feature' => $this->input->post('product_is_feature'),
                'discounted_price' => $this->input->post('discounted_price'),
                'publish_from' => $from_date,
                'publish_to' => $to_date,
                'is_offer_publish' => $this->input->post('is_offer_product'),
                'category_id' => $product_category,
                'sub_category_id' => $sub_category,
                'quantity' => $this->input->post('product_quantity'),
                'price' => $this->input->post('product_price'),
                'product_sku' => $this->input->post('product_sku'),
                'shipping_region' => $this->input->post('product_shipping_region'),
                'description' => $this->input->post('product_desc'),
                'sheeping_fees' => $this->input->post('product_shipping_fees'),
                'warrenty' => $this->input->post('product_warr'),
                'isactive' => $this->input->post('isactive'),
                'back_order_flag' => $this->input->post('back_order_flag'),
                'modifiedby' => $user_id,
                'variant_color' => ($this->input->post('variant_color')) ? strtolower($this->input->post('variant_color'))
                    : NULL,
                'variant_size' => ($this->input->post('variant_size')) ? $this->input->post('variant_size')
                    : NULL,
                'modifieddate' => date('Y-m-d H:m:s'),
                'instagram_image' => $this->input->post('is_instagram_product'),
                'is_instagram_product' => $is_instagram_product,
                'sub_attribute_id_new' => $sub_attribute_id_new,
            );
//echo '<pre>';print_r($dataProductUpdateArray);die;

            $this->product->update($productId, $dataProductUpdateArray);

            /* Insert all product variants */
            if ($productId != '') {
                $total_variants = $this->input->post('total_variants');
                $size           = $this->input->post('varient_name');
                $length         = $this->input->post('varient_value');
                $carat          = $this->input->post('price');
                $m              = 0;
                for ($i = 0; $i <= $total_variants; $i++) {
                    if ($size[$i] != '' || $length[$i] != '' || $carat[$i] != '') {
                        if ($m == 0) {
                            $product_id_fk = array($productId);
                            $this->common_model->deleteRows($product_id_fk,
                                "product_variants", "product_id_fk");
                            $m             = 1;
                        }
                        $arr_to_insert          = array(
                            "product_id_fk" => $productId,
                            "varient_name" => $size[$i],
                            "varient_value" => $length[$i],
                            "price" => $carat[$i],
                            "created" => date('Y-m-d H:i:s'),
                        );
                        $last_insert_variant_id = $this->common_model->insertRow($arr_to_insert,
                            "product_variants");
                    }
                }
            }

            $productSlug = $productId; //. '_' . $this->input->post('product_category');
            /* file upload */
            if (isset($_FILES['hover_images']['name']) && !empty($_FILES['hover_images']['name'])) {
//                $productSlug = $productId;
                $targetDir               = "backend/uploads/";
                $fileName                = $_FILES['hover_images']['name'];
                $targetFile              = $targetDir.$fileName;
                $uploded_file_path_hover = $this->handleUpload($productSlug,
                    $_FILES['hover_images']['name'],
                    $_FILES['hover_images']['tmp_name']);
                $dataProductImagesArray  = array(
                    'hover_img_url' => $uploded_file_path_hover,
                    'createdby' => $user_id,
                    'createddate' => date('Y-m-d H:m:s'),
                );
                $this->product_images->update($productId,
                    $dataProductImagesArray);
            }
            if (!empty($_FILES['product_images']['name'][0]))
                    if (isset($_FILES['product_images']['name']) && !empty($_FILES['product_images']['name'])) {

                    $totalImageUploadCnt = count($_FILES['product_images']['name'][0]);
                    echo $totalImageUploadCnt;
                    $targetDir           = "backend/uploads/";
                    for ($i = 0; $i < $totalImageUploadCnt; $i++) {
                        $fileName   = $_FILES['product_images']['name'][$i];
                        $targetFile = $targetDir.$fileName;

                        $uploded_file_path = $this->handleUpload($productSlug,
                            $_FILES['product_images']['name'][$i],
                            $_FILES['product_images']['tmp_name'][$i]);
                        if ($uploded_file_path != '') {
                            $dataProductImagesArray = array(
                                'product_id' => $productId,
                                'uploded_by' => $user_id,
                                'url' => $uploded_file_path,
                                'type' => $_FILES['product_images']['type'][$i],
                                'hover_img_url' => $this->input->post('hurl'),
                                'createdby' => $user_id,
                                'createddate' => date('Y-m-d H:m:s'),
                            );
                            $this->product_images->insert($dataProductImagesArray);
                        }
                    }
                }

            /* End of file upload */


            /* Prodcut Attributes & Sub Attributes */

//
//            $product_category_id = $this->input->post('product_category');
//            $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);
//
//            foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
//                $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
//            }
//            if (isset($this->data['prodcut_cat_detail'])) {
//                foreach ($this->data['prodcut_cat_detail'] as $key => $attr_data) {
//                    if ($attr_data['attribute_type'] == '2') {
//
//                        if (isset($_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name']) && !empty($_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name'])) {
//                            $targetDir = "backend/uploads/";
//
//                            $fileName = $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name'];
//                            $targetFile = $targetDir . $fileName;
//
//                            $uploded_file_path = $this->handleUpload($productSlug, $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name'], $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['tmp_name']);
//
//                            $dataProductAttributeArray = array(
//                                'product_id' => $productId,
//                                'attribute_id' => $attr_sub_data['attribute_id'],
//                                'attribute_type' => '2d',
//                                'attribute_value' => $attr_data['attrubute_value'],
//                                'sub_attribute_id' => $attr_sub_data['id'],
//                                'sub_attribute_value' => $uploded_file_path,
//                                'createdby' => $user_id,
//                                'createddate' => date('Y-m-d H:m:s'),
//                            );
//
//
//                        }
//
//                        $updateId = $this->input->post('attr_file_' . $attr_data['p_sub_category_id'] . '_' . $attr_data['p_category_id'] . '_file');
////                        echo $updateId;die;
//                        if ($updateId != null && $uploded_file_path != null)
//                            $this->product_attribute->update_attr($updateId, $dataProductAttributeArray);
//                        else if ($uploded_file_path != null)
//                            $this->product_attribute->insert($dataProductAttributeArray);
//                    }
//
//                    if (isset($attr_data['sub_attribute_details']))
//                        foreach ($attr_data['sub_attribute_details'] as $attr_sub_data) {
//                            if ($this->input->post('attr_input_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id']) || $this->input->post('attr_dropdown_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id'])) {
//                                if ($attr_data['attribute_type'] == '0' && $attr_data['attribute_type'] != '2') {
//                                    $dataProductAttributeArray = array(
//                                        'product_id' => $productId,
//                                        'attribute_id' => $attr_sub_data['attribute_id'],
//                                        'attribute_type' => '0',
//                                        'attribute_value' => $attr_data['attrubute_value'],
//                                        'sub_attribute_id' => $attr_sub_data['id'],
//                                        'sub_attribute_value' => $this->input->post('attr_input_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id']),
//                                        'createdby' => $user_id,
//                                        'createddate' => date('Y-m-d H:m:s'),
//                                    );
////                                    echo '<pre>', print_r($dataProductAttributeArray);
//
//                                    $updateId = $this->input->post('attr_input_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id'] . '_input');
//                                    $this->product_attribute->update_attr($updateId, $dataProductAttributeArray);
////                                     echo $this->db->last_query();
////                                     echo '<br>';
//                                } else if ($this->input->post('attr_dropdown_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id'])) {
//
//                                    $dataProductAttributeArray = array(
//                                        'product_id' => $productId,
//                                        'attribute_id' => $attr_sub_data['attribute_id'],
//                                        'attribute_type' => '1',
//                                        'attribute_value' => $attr_data['attrubute_value'],
//                                        'sub_attribute_id' => $attr_sub_data['id'],
//                                        'sub_attribute_value' => $this->input->post('attr_dropdown_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id']),
//                                        'sub_attribute_dp_id' => $this->input->post('attr_dropdown_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id']),
//                                        'createdby' => $user_id,
//                                        'createddate' => date('Y-m-d H:m:s'),
//                                    );
////                                    echo '<pre>', print_r($dataProductAttributeArray);
////                                    echo '<pre>', 'attr_dropdown_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id'];
//                                    $updateId = $this->input->post('attr_dropdown_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id'] . '_input');
//
//                                    $this->product_attribute->update_attr($updateId, $dataProductAttributeArray);
////                                    echo $this->db->last_query();
////                                    echo '<br>';
//                                }
//                            }
//                        }
//                }
//            }
//            die;
            /* Prodcut Attributes & Sub Attributes */
            $this->session->set_userdata('msg', 'Product updated successfully.');
            redirect('admin/product');
        }

        redirect('admin/product');
    }

    function handleUpload($slug, $upFileName, $upFileTmpName)
    {

        $fileTypes = array('jpeg', 'png', 'jpg'); // File extensions
        $fileParts = pathinfo($upFileName);

        if (!in_array(strtolower($fileParts['extension']), $fileTypes)) {
            $this->session->set_flashdata('msg', 'File type not supported.');
            return false;
        }

        $ext        = pathinfo($upFileName, PATHINFO_EXTENSION);
        $targetURL  = 'backend/uploads/product/'; // Relative to the root
//        $targetPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'product' . DIRECTORY_SEPARATOR . $slug;
        $targetPath = $targetURL.DIRECTORY_SEPARATOR.$slug;

        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        $tempFile = $upFileTmpName;
        $fileName = $upFileName;
        $fileName = $slug.'_'.$fileName;
        $path     = $targetURL.$slug.'/'.$fileName;

        $targetPath                 .= DIRECTORY_SEPARATOR.$fileName;
        $upload_status              = move_uploaded_file($tempFile, $targetPath);
        $dataDocumentDetail['type'] = $fileParts['extension'];
        if (isset($upload_status)) return $path;
    }

    public function delete($attr = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $attr === 'images') {
            $imgId = $this->input->post('imageId');
            $this->product_images->delet_img($imgId);
            return true;
        }
    }

    public function deleteHoverImage()
    {
        $product_id = trim($this->input->post('product_id'));
        if ($product_id != '') {
            $update_data       = array(
                "hover_img_url" => '',
            );
            $condition_to_pass = array("product_id" => $product_id);
            $last_update_id    = $this->Common_model_marketing->updateRow('it_products_image',
                $update_data, $condition_to_pass);
            echo 1;
        } else {
            echo 2;
        }
    }

    public function offer($method = null)
    {

        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method === 'modify') {

            $discpunt_data = $this->input->post('discount');
            foreach ($discpunt_data as $key => $val) {
                if (isset($key)) {
                    $product_details   = $this->product->as_array()->get_by(array(
                        'id' => $key));
                    if ($val <= 0) $disc_val          = NULL;
                    else $disc_val          = $val;
                    $updateProductData = array(
                        'discounted_price' => $disc_val,
                        'is_offer_publish' => '1'
                    );
                    $this->product->update($product_details['id'],
                        $updateProductData);
                }
            }
            $this->session->set_userdata("msg",
                "<span class='success'> Offers published successfully.</span>");
            redirect('admin/offer', 'refresh');
        }

        $this->data['product_category']                              = array('' => 'Select Category')
            + $this->product_category->dropdown('name');
        $this->data['product_make']                                  = array('' => 'Select Make')
            + $this->mst_make->dropdown('name');
        $this->data['product_year']                                  = array('' => 'Select Year')
            + $this->mst_year->dropdown('name');
        $this->data['product_model']                                 = array('' => 'Select Model')
            + $this->mst_model->dropdown('name');
        $this->data['product_details']                               = $this->product->as_array()->get_all();
        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);

        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);

        $pageTitle = "Manage Offer";
        $renderTo  = "mng_product/_offer";
        $viewData  = $this->data;
        $this->_render_view($pageTitle, $renderTo, $viewData);
    }

    public function _render_view($pageTitle, $renderTo, $viewData)
    {
        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title']   = $pageTitle;
        $this->data['total_users']  = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', $renderTo, $viewData);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function orders()
    {
        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title']   = 'Orders';
        $this->data['total_users']  = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());
        $this->data['all_orders']   = $this->orders_summary->get_all_orders();

        $this->data['product_make']  = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year']  = array('' => 'Select Year') + $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model') + $this->mst_model->dropdown('name');
//echo '<pre>', print_r($this->data['all_orders']);die;

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content',
            'mng_product/_all_orders_summary', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function order_details($orderId)
    {
        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title']   = 'Orders';
        $this->data['total_users']  = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());
        $this->data['all_orders']   = $this->admin_library->demo_update_order_details($orderId);


        $this->data['product_make']  = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year']  = array('' => 'Select Year') + $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model') + $this->mst_model->dropdown('name');
//        echo '<pre>', print_r($this->data['all_orders']);die;

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'mng_product/_all_orders',
            $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function coupon($method = null)
    {
        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title']   = 'Administrator Dashboard';
        $this->data['total_users']  = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'coupon/_view_coupon',
            $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function add_coupon($method = null)
    {
        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title']        = 'Administrator Dashboard';
        $this->data['total_users']       = count($this->users->get_all());
        $this->data['total_groups']      = count($this->group_model->get_all());
        $this->data['coupon_type']       = array('' => 'Select Type') + $this->coupon_category->dropdown('disc_type');
        $this->data['coupon_method']     = array('' => 'Select method') + $this->coupon_method->dropdown('disc_method');
        $this->data['coupon_method_tax'] = array('' => 'Select method tax') + $this->coupon_method_tax->dropdown('disc_tax_method');
        $this->data['coupon_group']      = array('' => 'Select group') + $this->coupon_group->dropdown('disc_group');
//$this->data['product'] = array('' => 'Select product') + $this->product->dropdown('product_name');
        $this->data['product_category']  = array('' => 'Select Category') + $this->product_category->dropdown('name');
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'coupon/_add_coupon', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function couponFilter($dpType = null)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $dpType === 'type') {

            $type_id = $this->input->post('type_id');

            $this->data['coupon_method'] = $this->coupon_method->get_all_method_by_type_id($type_id);


            $st = '<option value="">Select Method</option>';
            foreach ($this->data['coupon_method'] as $key => $val)
                $st .= ' <option value="'.$val['disc_method_id'].'">'.$val['disc_method'].'</option>';
            echo json_encode(array('content' => $st));
            die;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $dpType === 'product') {

//$year_id = $this->input->post('product_year_id');
            $p_id                       = $this->input->post('p_id');
            $this->data['product_name'] = $this->product->get_product_by_cat_id($p_id);

            $st = '';
            foreach ($this->data['product_name'] as $key => $val)
                $st .= ' <option value="'.$val['id'].'">'.$val['product_name'].'</option>';
            echo json_encode(array('content' => $st));
            die;
        }
    }

    public function featured_category($method = null)
    {

        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        if ($method == 'add') {

            $i     = 0;
            $added = 0;
            if (count($this->input->post('product_category')) > 0) {
                $arr_featured_Categoryss = $this->common_model->getRecords("tbl_home_featured_category",
                    "id", '');
                if (count($arr_featured_Categoryss) > 0) {
                    foreach ($arr_featured_Categoryss as $user_id) {
                        $user = array($user_id['id']);
//echo '<pre>';print_r($user);die;
                        $this->common_model->deleteRows($user,
                            "tbl_home_featured_category", "id");
                    }
                }
            }


            foreach ($this->input->post('product_category') as $pcat) {
                if ($pcat != '' && $_POST['p_sub_category_id'][$i] != '') {
                    $arr_featured_Category = ($this->common_model->getRecords("tbl_home_featured_category",
                            "id",
                            array("category_id" => $pcat, "subcategory_id" => $_POST['p_sub_category_id'][$i])));
//if(count($arr_featured_Category) < 1){
                    $data                  = array('category_id' => $pcat, 'subcategory_id' => $_POST['p_sub_category_id'][$i],
                        'level' => '', 'created_time' => date('Y-m-d H:i:s'), 'products' => serialize($this->input->post('product_ids_'.$i)));
                    $insert                = $this->common_model->insertRow($data,
                        'tbl_home_featured_category');
                    $added                 = 1;
                    $this->session->set_userdata("msg",
                        "<span class='success'> Featured Category added successfully.</span>");
//}
                    $i++;
                }
            }
            if ($added == 1) {
                $this->session->unset_userdata('msg');
                $this->session->set_userdata("msg",
                    "<span class='success'> Featured Category added successfully.</span>");
            } else {
                $this->session->unset_userdata('msg');
                $this->session->set_userdata("msg",
                    "<span class='success'> Featured Category already available.</span>");
            }
            redirect('admin/featured_category');
        }
        $this->data['curr_data'] = $this->common_model->getRecords('tbl_home_featured_category',
            '*');

        $this->data['prodcut_cat_detailup1'] = $this->product_sub_category->get_product_sub_attribute($this->data['curr_data'][0]['category_id']);

        foreach ($this->data['prodcut_cat_detailup1'] as $key => $dataAtt) {
            $this->data['prodcut_cat_detailup1'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
            $prarr1                                                             = array();
            foreach (unserialize($this->data['curr_data'][0]['products']) as $keys => $pr) {
                array_push($prarr1, $pr);
            }
        }
        $this->data['prarr1']             = $prarr1;
        $this->data['curr_cat_products1'] = $this->product->get_product_by_category_id($this->data['curr_data'][0]['category_id'],
            $this->data['curr_data'][0]['subcategory_id'], 0, '', '', '');


//                echo '<pre>aa', print_r($this->data['prodcut_cat_detailup1'] );die;
//                echo '/********************************************************************************/';
//                die;
        if (count($this->data['prodcut_cat_detailup1']) > 0 && count($this->data['prodcut_cat_detailup1'][0]['sub_attribute_details'])
            > 0) {
            foreach ($this->data['prodcut_cat_detailup1'] as $key => $dataAtt) {


                if ($this->data['prodcut_cat_detailup1'][$key]['attribute_type']
                    == '2') {
                    if ($catEdit['sub_attribute_id'] == $subAttrData['id']) {
                        $this->data['prodcut_cat_detailup1'][$key]['update_id']    = $catEdit['id'];
                        $this->data['prodcut_cat_detailup1'][$key]['plugin_url']
                            = $catEdit['sub_attribute_value'];
                        $this->data['prodcut_cat_detailup1'][$key]['plugin_id']    = $catEdit['sub_attribute_id'];
                        $this->data['prodcut_cat_detailup1'][$key]['attribute_id']
                            = $catEdit['attribute_id'];
                    }
                }
            }
        }
        $this->data['prodcut_cat_detailup2'] = $this->product_sub_category->get_product_sub_attribute($this->data['curr_data'][1]['category_id']);

        foreach ($this->data['prodcut_cat_detailup2'] as $key => $dataAtt) {
            $this->data['prodcut_cat_detailup2'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
            $prarr2                                                             = array();
            foreach (unserialize($this->data['curr_data'][1]['products']) as $keys => $pr) {
                array_push($prarr2, $pr);
            }
        }
        $this->data['prarr2']             = $prarr2;
        $this->data['curr_cat_products2'] = $this->product->get_product_by_category_id($this->data['curr_data'][1]['category_id'],
            $this->data['curr_data'][1]['subcategory_id'], 0, '', '', '');
//                echo '<pre>aa', print_r($this->data['prodcut_cat_detail'][0]['sub_attribute_details'] );die;
//                echo '/********************************************************************************/';
//                die;
        if (count($this->data['prodcut_cat_detailup2']) > 0 && count($this->data['prodcut_cat_detailup2'][0]['sub_attribute_details'])
            > 0) {
            foreach ($this->data['prodcut_cat_detailup2'] as $key => $dataAtt) {


                if ($this->data['prodcut_cat_detailup2'][$key]['attribute_type']
                    == '2') {
                    if ($catEdit['sub_attribute_id'] == $subAttrData['id']) {
                        $this->data['prodcut_cat_detailup2'][$key]['update_id']    = $catEdit['id'];
                        $this->data['prodcut_cat_detailup2'][$key]['plugin_url']
                            = $catEdit['sub_attribute_value'];
                        $this->data['prodcut_cat_detailup2'][$key]['plugin_id']    = $catEdit['sub_attribute_id'];
                        $this->data['prodcut_cat_detailup2'][$key]['attribute_id']
                            = $catEdit['attribute_id'];
                    }
                }
            }
        }

        $this->data['prodcut_cat_detailup3'] = $this->product_sub_category->get_product_sub_attribute($this->data['curr_data'][2]['category_id']);

        foreach ($this->data['prodcut_cat_detailup3'] as $key => $dataAtt) {
            $this->data['prodcut_cat_detailup3'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
            $prarr3                                                             = array();
            foreach (unserialize($this->data['curr_data'][2]['products']) as $keys => $pr) {
                array_push($prarr3, $pr);
            }
        }
        $this->data['prarr3']             = $prarr3;
        $this->data['curr_cat_products3'] = $this->product->get_product_by_category_id($this->data['curr_data'][2]['category_id'],
            $this->data['curr_data'][2]['subcategory_id'], 0, '', '', '');
//                echo '<pre>', print_r($this->data['prodcut_cat_detail'][0]['sub_attribute_details'] );die;
//                echo '/********************************************************************************/';
//                die;
        if (count($this->data['prodcut_cat_detailup3']) > 0 && count($this->data['prodcut_cat_detailup3'][2]['sub_attribute_details'])
            > 0) {
            foreach ($this->data['prodcut_cat_detailup3'] as $key => $dataAtt) {


                if ($this->data['prodcut_cat_detailup3'][$key]['attribute_type']
                    == '2') {
                    if ($catEdit['sub_attribute_id'] == $subAttrData['id']) {
                        $this->data['prodcut_cat_detailup3'][$key]['update_id']    = $catEdit['id'];
                        $this->data['prodcut_cat_detailup3'][$key]['plugin_url']
                            = $catEdit['sub_attribute_value'];
                        $this->data['prodcut_cat_detailup3'][$key]['plugin_id']    = $catEdit['sub_attribute_id'];
                        $this->data['prodcut_cat_detailup3'][$key]['attribute_id']
                            = $catEdit['attribute_id'];
                    }
                }
            }
        }


        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title']       = 'Administrator Dashboard';
        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content',
            'mng_product/home_featured_categories', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function getProductBySubCategory()
    {
        $product_details = $this->product->get_product_by_category_id($this->input->post('product_category_id'),
            $this->input->post('product_sub_category_id'), 0, '', '', '');
        $output          = "";
        foreach ($product_details as $pd) {
            $output .= "<option value='".$pd['id']."'>".$pd['product_name']."</option>";
        }

        echo json_encode(array('status' => 200, 'data' => $output));
    }

    public function getSubCategory()
    {
        $product_category_id              = $this->input->post('product_category_id');
        $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);

//        foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
//            $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
//        }
//                echo '<pre>aa', print_r($this->data['prodcut_cat_detail'][0]['sub_attribute_details'] );die;
//                echo '/********************************************************************************/';
//                die;
        if (count($this->data['prodcut_cat_detail']) > 0) {
            foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {


                if ($this->data['prodcut_cat_detail'][$key]['attribute_type'] == '2') {
                    if ($catEdit['sub_attribute_id'] == $subAttrData['id']) {
                        $this->data['prodcut_cat_detail'][$key]['update_id']    = $catEdit['id'];
                        $this->data['prodcut_cat_detail'][$key]['plugin_url']   = $catEdit['sub_attribute_value'];
                        $this->data['prodcut_cat_detail'][$key]['plugin_id']    = $catEdit['sub_attribute_id'];
                        $this->data['prodcut_cat_detail'][$key]['attribute_id'] = $catEdit['attribute_id'];
                    }
                }
            }
            $this->data['id']    = $this->input->post('id');
            $attribute_edit_view = $this->load->view('mng_product/_div_sub_category',
                $this->data, TRUE);
            echo json_encode(array('content' => $attribute_edit_view));
            die;
        } else {
            echo json_encode(array('content' => ''));
            die;
        }
    }

    public function changeStatus()
    {
        if ($this->input->post('id') != "") {
            /* updating the user status. */
            $arr_to_update   = array("isactive" => $this->input->post('isactive'));
            /* condition to update record	for the admin status */
            $condition_array = array('id' => intval($this->input->post('id')));
            /* updating the global setttings parameter value into database */
            $this->common_model->updateRow('it_products', $arr_to_update,
                $condition_array);
            /* Addmin the user in bloked list into file */
//$this->load->model('admin_model');
// $this->admin_model->updateBlockedUserFile($this->common_model->absolutePath(), $this->input->post('user_status'), intval($this->input->post('id')));
            echo json_encode(array("error" => "0", "error_message" => "Your Account has been deleted successfully"));
        } else {
            /* if something going wrong providing error message.  */
            echo json_encode(array("error" => "1", "error_message" => "Sorry, your request can not be fulfilled this time. Please try again later"));
        }
    }

    public function changeStatusPromotions()
    {
        if ($this->input->post('id') != "") {
            /* updating the user status. */
            $arr_to_update   = array("status" => $this->input->post('status'));
            /* condition to update record	for the admin status */
            $condition_array = array('id' => intval($this->input->post('id')));
            /* updating the global setttings parameter value into database */
            $this->common_model->updateRow('tbl_promotion_banners',
                $arr_to_update, $condition_array);
            /* Addmin the user in bloked list into file */
//$this->load->model('admin_model');
// $this->admin_model->updateBlockedUserFile($this->common_model->absolutePath(), $this->input->post('user_status'), intval($this->input->post('id')));
            echo json_encode(array("error" => "0", "error_message" => "Your Account has been deleted successfully"));
        } else {
            /* if something going wrong providing error message.  */
            echo json_encode(array("error" => "1", "error_message" => "Sorry, your request can not be fulfilled this time. Please try again later"));
        }
    }

    public function chkCouponName()
    {
        if (trim($this->input->post('coupon_code')) != '') {
            $arr_code_check = $this->Common_model_marketing->getRecords('discounts',
                'disc_code',
                array('disc_code' => trim($this->input->post('coupon_code'))));
            if (count($arr_code_check) == 0) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    public function chkCouponNameEdit()
    {
        if (trim($this->input->post('coupon_code')) != '' && trim($this->input->post('disc_id'))
            != '') {
            $disc_id        = trim($this->input->post('disc_id'));
            $disc_code      = trim($this->input->post('coupon_code'));
            $conditions     = "disc_id != '$disc_id' AND disc_code = '$disc_code'";
            $arr_code_check = $this->Common_model_marketing->getRecords('discounts',
                'disc_code', $conditions);
            if (count($arr_code_check) == 0) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    public function chkPromotionAvailable()
    {
        if (trim($this->input->post('from_date')) != '' && trim($this->input->post('to_date'))
            != '') {
            $from_date = trim($this->input->post('from_date'));

            $arr_from_date = explode('/', $from_date);
            $from_date_new = $arr_from_date[2].'-'.$arr_from_date[0].'-'.$arr_from_date[1];

            $to_code     = trim($this->input->post('to_date'));
            $arr_to_date = explode('/', $to_code);
            $to_date_new = $arr_to_date[2].'-'.$arr_to_date[0].'-'.$arr_to_date[1];

            $conditions = "from_date >= '$from_date_new' AND to_date <='$to_date_new'";

            $arr_code_check = $this->Common_model_marketing->getRecords('tbl_promotion_banners',
                'id', $conditions);
//echo '<pre>';print_r($arr_code_check);die;
            if (count($arr_code_check) < 1) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    public function chkPromotionAvailableEdit()
    {
        if (trim($this->input->post('from_date')) != '' && trim($this->input->post('to_date'))
            != '' && trim($this->input->post('promotion_id')) != '') {
            $from_date    = trim($this->input->post('from_date'));
            $promotion_id = trim($this->input->post('promotion_id'));

            $arr_from_date = explode('/', $from_date);
            $from_date_new = $arr_from_date[2].'-'.$arr_from_date[0].'-'.$arr_from_date[1];

            $to_code     = trim($this->input->post('to_date'));
            $arr_to_date = explode('/', $to_code);
            $to_date_new = $arr_to_date[2].'-'.$arr_to_date[0].'-'.$arr_to_date[1];

            $conditions = "from_date >= '$from_date_new' AND to_date <='$to_date_new' AND id != '$promotion_id'";

            $arr_code_check = $this->Common_model_marketing->getRecords('tbl_promotion_banners',
                'id', $conditions);
//echo '<pre>';print_r($arr_code_check);die;
            if (count($arr_code_check) == 0) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    public function subAttributesList()
    {
        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        if (count($_POST) > 0) {
            if (isset($_POST['btn_delete_all'])) {
                $arr_subAttributes_ids = $this->input->post('checkbox');
//echo '<pre>';print_r($arr_products_ids);die;
                if (count($arr_subAttributes_ids) > 0) {
                    foreach ($arr_subAttributes_ids as $subAttribute_id) {
                        if ($subAttribute_id != '') {
                            $id = array($subAttribute_id);
                            $this->common_model->deleteRows($id,
                                "mst_sub_attributes", "id");
                        }
                    }
                }
                $this->session->set_userdata("msg",
                    "Sub-Attributes deleted successfully!");
                redirect('admin/subAttributesList');
            }
        }

        $this->data['arr_sub_attributes'] = $this->product_sub_category->getSubAttributesList();
//echo $this->db->last_query();
//echo '<pre>';print_r($this->data['arr_sub_attributes']);die;

        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->data['page_title'] = 'Manage Sub Attributes';
        $this->template->write_view('content',
            'mng_subattributes/_view_attributes', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function subAttributesAdd()
    {
        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        if (count($_POST) > 0) {

            if (trim($this->input->post('attribute_name')) != '' && trim($this->input->post('subattribute_name'))
                != '') {

                $attribute_name    = trim($this->input->post('attribute_name'));
                $subattribute_name = trim($this->input->post('subattribute_name'));
                $conditions        = "name = '$subattribute_name' AND attribute_id = '$attribute_name'";
                $arr_code_check    = $this->Common_model_marketing->getRecords('mst_sub_attributes',
                    'id', $conditions);
                $conditions        = "attrubute_value = '$attribute_name'";
                $arr_attributes    = $this->Common_model_marketing->getRecords('p_attributes',
                    'attrubute_value,id', $conditions);
                if (count($arr_code_check) < 1 && count($arr_attributes) > 0) {
                    $arr_to_insert  = array(
                        "attribute_id" => $arr_attributes[0]['id'],
                        "name" => $subattribute_name,
                        "status" => '1',
                        "category_id" => trim($this->input->post('product_category')),
                        "created" => date('Y-m-d H:i:s'),
                    );
                    $last_insert_id = $this->Common_model_marketing->insertRow($arr_to_insert,
                        "mst_sub_attributes");
                }
                $this->session->set_userdata("msg",
                    "Sub attribute  submitted successfully.");
                redirect('admin/subAttributesList');
            } else {
                $this->session->set_userdata("msg",
                    "Please select attribute name and also enter subattribute name");
                redirect('admin/subAttributesAdd');
            }
        }
        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
//$this->data['prodcut_cat_detail'] = $this->common_model->getRecords('p_attributes', 'id,attrubute_value','','id DESC');
//echo '<pre>';print_r($this->data['product_category']);die;

        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->data['page_title'] = 'Manage Sub Attributes';
        $this->template->write_view('content',
            'mng_subattributes/add_attributes', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function subAttributesEdit($edit_id = '')
    {
        $conditions              = "id = '$edit_id'";
        $arr_attribute_available = $this->Common_model_marketing->getRecords('mst_sub_attributes',
            '*', $conditions);
        if ($edit_id != '' && count($arr_attribute_available) > 0) {
            if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
                redirect('auth/login', 'refresh');
            }
            if (!$this->ion_auth->is_admin()) {
                redirect('/home', 'refresh');
            }
            $this->data['arr_edit_data'] = $arr_attribute_available;
            if (count($_POST) > 0) {
                if (trim($this->input->post('attribute_name')) != '' && trim($this->input->post('subattribute_name'))
                    != '' && trim($this->input->post('edit_id')) != '') {
                    $edit_id           = trim($this->input->post('edit_id'));
                    $attribute_name    = trim($this->input->post('attribute_name'));
                    $subattribute_name = trim($this->input->post('subattribute_name'));
                    $conditions        = "name = '$subattribute_name' AND attribute_id = '$attribute_name' AND id != '$edit_id'";
                    $arr_code_check    = $this->Common_model_marketing->getRecords('mst_sub_attributes',
                        'id', $conditions);


                    if (count($arr_code_check) < 1) {
                        $update_data     = array(
                            "attribute_id" => $attribute_name,
                            "name" => $subattribute_name,
                            "status" => '1',
                            "category_id" => trim($this->input->post('product_category')),
                            "created" => date('Y-m-d H:i:s'),
                        );
                        $condition_array = array('id' => intval(trim($this->input->post('edit_id'))));
                        $last_update_id  = $this->Common_model_marketing->updateRow('mst_sub_attributes',
                            $update_data, $condition_array);
                    }
                    $this->session->set_userdata("msg",
                        "Sub attribute updated successfully.");
                    redirect('admin/subAttributesList');
                } else {
                    $this->session->set_userdata("msg",
                        "Please select attribute name and also enter subattribute name");
                    redirect('admin/subAttributesEdit');
                }
            }

            $this->data['product_category'] = $this->common_model->getRecords("it_product_category",
                "id,name", '', 'id DESC');

            $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($arr_attribute_available[0]['category_id']);
            foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                $this->data['prodcut_cat_detail'][$key]['sub_attribute_details']
                    = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
            }

//echo '<pre>';print_r($this->data['product_category']);die;

            $user_id                  = $this->session->userdata('user_id');
            $this->data['dataHeader'] = $this->users->get_allData($user_id);
            $this->template->set_master_template('template.php');
            $this->template->write_view('header', 'backend/header', $this->data);
            $this->template->write_view('sidebar', 'backend/sidebar', NULL);
            $this->data['page_title'] = 'Manage Sub Attributes';
            $this->template->write_view('content',
                'mng_subattributes/edit_attributes', $this->data);
            $this->template->write_view('footer', 'backend/footer', '', TRUE);
            $this->template->render();
        } else {
            redirect('admin/subAttributesList');
        }
    }

    public function chkSubattributesAvailableAdd()
    {
        if (trim($this->input->post('attribute_name')) != '' && trim($this->input->post('subattribute_name'))
            != '') {
            $attribute_name    = trim($this->input->post('attribute_name'));
            $subattribute_name = trim($this->input->post('subattribute_name'));

            $conditions     = "attrubute_value = '$attribute_name'";
            $arr_attributes = $this->Common_model_marketing->getRecords('p_attributes',
                'attrubute_value,id', $conditions);
            $attribute_ids  = $arr_attributes[0]['id'];

            $conditions     = "name = '$subattribute_name' AND attribute_id = '$attribute_ids'";
            $arr_code_check = $this->Common_model_marketing->getRecords('mst_sub_attributes',
                'id', $conditions);
            if (count($arr_code_check) == 0) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    public function chkSubattributesAvailableEdit()
    {
        if (trim($this->input->post('attribute_name')) != '' && trim($this->input->post('subattribute_name'))
            != '' && trim($this->input->post('edit_id')) != '') {
            $edit_id           = trim($this->input->post('edit_id'));
            $attribute_name    = trim($this->input->post('attribute_name'));
            $subattribute_name = trim($this->input->post('subattribute_name'));
            $conditions        = "name = '$subattribute_name' AND attribute_id = '$attribute_name' && id != '$edit_id'";
            $arr_code_check    = $this->Common_model_marketing->getRecords('mst_sub_attributes',
                'id', $conditions);
            if (count($arr_code_check) == 0) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    public function get_attributesForSubattributes($method = null)
    {
        if (trim($this->input->post('product_category_id')) != '') {
            $product_category_id              = trim($this->input->post('product_category_id'));
            $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);
            foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                $this->data['prodcut_cat_detail'][$key]['sub_attribute_details']
                    = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
            }
            $this->data['prodcut_cat_detail'];
            $attribute_view = $this->load->view('mng_subattributes/_div_attributes',
                $this->data, TRUE);

            echo json_encode(array('content' => $attribute_view));
            die;
        }
    }

    public function getSubAttributeByName()
    {
        if (trim($this->input->post('attribute_name')) != '') {
            $attribute_name = trim($this->input->post('attribute_name'));
            $addEdit        = trim($this->input->post('addEdit'));
            $conditions     = "attrubute_value = '$attribute_name'";
            $arr_attributes = $this->Common_model_marketing->getRecords('p_attributes',
                'attrubute_value,id', $conditions);
            if (count($arr_attributes) > 0) {
                $attribute_ids  = $arr_attributes[0]['id'];
                $conditions     = "attribute_id = '$attribute_ids'";
                $arr_code_check = $this->Common_model_marketing->getRecords('mst_sub_attributes',
                    'id,name', $conditions);
                if (count($arr_code_check) > 0) {
                    ?>
                    <select id="sub_attribute_id" name="sub_attribute_id" class="form-control">
                        <option value="">Select Product Sub Attribute</option>
                        <?php foreach ($arr_code_check as $key => $sub_attributes) { ?>
                            <option value="<?php echo $sub_attributes['id']; ?>" <?php
                                    if ($sub_attributes['id'] == $addEdit) {
                                        ?> selected="selected" <?php } ?>><?php echo $sub_attributes['name']; ?></option>
                    <?php } ?>
                    </select>
                    <br/>
                    <?php
                } else {
                    echo 'Sub attribute not available.';
                }
            } else {
                // echo 0;
            }
        }
    }

    public function getSubAttributeById()
    {
        if (trim($this->input->post('attribute_name')) != '') {
            $attribute_name = trim($this->input->post('attribute_name'));
            $addEdit        = trim($this->input->post('addEdit'));
            if ($attribute_name != '') {
                $attribute_ids  = $attribute_name;
                $conditions     = "attribute_id = '$attribute_ids'";
                $arr_code_check = $this->Common_model_marketing->getRecords('mst_sub_attributes',
                    'id,name', $conditions);
                if (count($arr_code_check) > 0) {
                    ?>
                    <select id="sub_attribute_id" name="sub_attribute_id" class="form-control">
                        <option value="">Select Product Sub Attribute</option>
                        <?php foreach ($arr_code_check as $key => $sub_attributes) { ?>
                            <option value="<?php echo $sub_attributes['id']; ?>" <?php
                                    if ($sub_attributes['id'] == $addEdit) {
                                        ?> selected="selected" <?php } ?>><?php echo $sub_attributes['name']; ?></option>
                    <?php } ?>
                    </select>
                    <br/>
                    <?php
                } else {
                    echo 'Sub attribute not available.';
                }
            } else {
// echo 0;
            }
        }
    }

    public function productVariantsUpload()
    {

        if (($_FILES["userfile"])) {
            $filename  = $_FILES["userfile"]["tmp_name"];
            $fileTypes = array('xlsx', 'xls', 'csv'); // File extensions
            $fileParts = pathinfo($_FILES['userfile']['name']);
            if (!in_array(strtolower($fileParts['extension']), $fileTypes)) {
                $this->session->set_flashdata('msg', 'File type not supported.');
                redirect('admin/productVariantsUpload');
            }
            $objPHPExcel     = PHPExcel_IOFactory::load($filename);
            $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
            foreach ($cell_collection as $cell) {
                $column     = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                $row        = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                if ($row == 1) {
                    $header[$row][$column] = $data_value;
                } else {
                    $arr_data[$row][$column] = $data_value;
                }
            }
            $excel_row_data = $arr_data;
            if (count($excel_row_data) > 0) {
                foreach ($excel_row_data as $rowData) {
                    if (trim($rowData['A']) != '') {
                        $arr_product_details = $this->common_model->getRecords('it_products',
                            'id', array("product_name" => trim($rowData['A'])));
                        if (count($arr_product_details) > 0) {
                            $productId = $arr_product_details[0]['id'];
                            $size      = trim($rowData['B']);
                            $length    = trim($rowData['C']);
                            $carat     = trim($rowData['D']);
                            if ($size != '' || $length != '' || $carat != '') {
                                $conditions                   = "product_id_fk='$productId' and size='$size' AND length='$length' AND carat = '$carat'";
                                $arr_product_variants_details = $this->common_model->getRecords('product_variants',
                                    'variant_id', $conditions);
//echo '<pre>';print_r($arr_product_variants_details);die;
                                if (count($arr_product_variants_details) < 1 && $productId
                                    != '') {
                                    $arr_to_insert          = array(
                                        "product_id_fk" => $productId,
                                        "size" => $size,
                                        "length" => $length,
                                        "carat" => $carat,
                                        "created" => date('Y-m-d H:i:s'),
                                    );
                                    $last_insert_variant_id = $this->common_model->insertRow($arr_to_insert,
                                        "product_variants");
                                }
                            }
                        }
                    }
                }
                $this->session->set_userdata("msg",
                    "Product variants added successfully!");
                redirect('admin/product');
            }
        }

        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->data['page_title'] = 'Import Product Variants';
        $this->template->write_view('content',
            'mng_product/_add_product_variant_csv', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function addProductVariants()
    {
        $csv_data_count = $this->input->post('csv_data_count');
        if ($csv_data_count < 1) {
            redirect('admin/productVariantsUpload');
        }
        for ($i = 0; $i < $csv_data_count; $i++) {
            if (trim($this->input->post('product_name')[$i]) != '') {
                $arr_product_details = $this->common_model->getRecords('it_products',
                    'id',
                    array("product_name" => trim($this->input->post('product_name')[$i])));
                if (count($arr_product_details) > 0) {
                    $productId = $arr_product_details[0]['id'];
                    $size      = trim($this->input->post('size')[$i]);
                    $length    = trim($this->input->post('length')[$i]);
                    $carat     = trim($this->input->post('carat')[$i]);
                    if ($size != '' || $length != '' || $carat != '') {
                        $conditions                   = "product_id_fk='$productId' and size='$size' AND length='$length' AND carat = '$carat'";
                        $arr_product_variants_details = $this->common_model->getRecords('product_variants',
                            'variant_id', $conditions);
//echo '<pre>';print_r($arr_product_variants_details);die;
                        if (count($arr_product_variants_details) < 1 && $productId
                            != '') {
                            $arr_to_insert          = array(
                                "product_id_fk" => $productId,
                                "size" => $size,
                                "length" => $length,
                                "carat" => $carat,
                                "created" => date('Y-m-d H:i:s'),
                            );
                            $last_insert_variant_id = $this->common_model->insertRow($arr_to_insert,
                                "product_variants");
                        }
                    }
                }
            }
        }
        $this->session->set_userdata("msg",
            "Product variants added successfully!");
        redirect('admin/product');
    }

    public function getThirdLevelSubCategory()
    {
        $sub_category = $this->input->post('sub_category');
//echo '<pre>';print_r($sub_category);
        if (count($sub_category) > 0) {
            foreach ($sub_category as $key => $category) {
                $attribute_ids            = $category;
                $conditions               = "id = '$attribute_ids'"; //get subcategory
                $arr_sub_category_details = $this->Common_model_marketing->getRecords('p_attributes',
                    'attrubute_value,id', $conditions);

                $conditions     = "attribute_id = '$attribute_ids'";
                $arr_code_check = $this->Common_model_marketing->getRecords('mst_sub_attributes',
                    'id,name', $conditions);
//echo '<pre>';print_r($arr_code_check);
                if (count($arr_code_check) > 0) {
                    ?>

                    <?php foreach ($arr_code_check as $key => $sub_attributes) { ?>
                        <div>
                            <input type="checkbox" name="sub_attribute_id[]" id="sub_attribute_id" value="<?php echo $sub_attributes['id']; ?>" /> <?php echo $sub_attributes['name'].'('.$arr_sub_category_details[0]['attrubute_value'].')'; ?>
                        </div>
                    <?php } ?>
                    <?php
                }
            }
        } else {
            echo 'Sub attribute not available.';
        }
    }

    public function getThirdLevelSubCategoryEdit()
    {
        $sub_category               = $this->input->post('sub_category');
        $sub_attribute_id_new       = $this->input->post('product_sub_attribute_id');
        $arr_already_third_category = explode(',', $sub_attribute_id_new);
//echo '<pre>';print_r($arr_already_third_category);
        if (count($sub_category) > 0) {
            foreach ($sub_category as $key => $category) {
                $attribute_ids            = $category;
                $conditions               = "id = '$attribute_ids'"; //get subcategory
                $arr_sub_category_details = $this->Common_model_marketing->getRecords('p_attributes',
                    'attrubute_value,id', $conditions);

                $conditions     = "attribute_id = '$attribute_ids'";
                $arr_code_check = $this->Common_model_marketing->getRecords('mst_sub_attributes',
                    'id,name', $conditions);
//echo '<pre>';print_r($arr_code_check);
                if (count($arr_code_check) > 0) {
                    ?>
                    <?php foreach ($arr_code_check as $key => $sub_attributes) { ?>
                        <div>
                            <input type="checkbox" name="sub_attribute_id[]" id="sub_attribute_id" value="<?php echo $sub_attributes['id']; ?>" <?php
                                   if (in_array($sub_attributes['id'],
                                           $arr_already_third_category)) {
                                       ?>checked="checked" <?php } ?>/> <?php echo $sub_attributes['name'].'('.$arr_sub_category_details[0]['attrubute_value'].')'; ?>
                        </div>
                    <?php } ?>
                    <?php
                }
            }
        } else {
            echo 'Sub attribute not available.';
        }
    }

    public function sendContactUsMessage()
    {
        $name    = trim($this->input->post('name'));
        $email   = trim($this->input->post('email'));
        $message = trim($this->input->post('message'));
        if ($name != '' && $email != '') {
            $arr_to_insert   = array(
                "name" => $name,
                "email" => $email,
                "message" => $message,
                "created" => date("Y-m-d H:i:s"),
            );
            $last_message_id = $this->common_model->insertRow($arr_to_insert,
                "mst_contact_us");

// $subject2 = "You Got A New Message";
//$message2 = "You recently got a message from a user through your website. The details are given below: <br/>";
// //$message2 .= "Name:  $name <br/>";
// $message2 .= "Email Id:  $email <br/>";
// $message2 .= "Message :-  $message <br/>";
//$mail = $this->common_model->sendEmail(array($email), array("email" => 'webmaster@rebelutedigital.com', "name" => config_item('website_name')),$subject2,$message2);
            $edata['name']    = $name;
            $edata['email']   = $email;
            $edata['message'] = $message;

            $html = $this->load->view('email_templates/contact-message', $edata,
                true);
            $mail = $this->common_model->sendEmail(config_item('admin_email'),
                array("email" => config_item('site_email'), "name" => config_item('website_name')),
                'You Got A New Message', $html);

            echo json_encode(array('status' => '1', 'msg' => 'Message successfully sent.we will get back to you within 24 hours.'));
        } else {
            echo json_encode(array('status' => '0', 'msg' => 'Please enter name and email'));
        }
    }

    public function contactMessageList()
    {
        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        if (count($_POST) > 0) {
            if (isset($_POST['btn_delete_all'])) {
                $arr_messages_ids = $this->input->post('checkbox');
                if (count($arr_messages_ids) > 0) {
                    foreach ($arr_messages_ids as $message_id) {
                        if ($message_id != '') {
                            $id = array($message_id);
                            $this->common_model->deleteRows($id,
                                "mst_contact_us", "id");
                        }
                    }
                }
                $this->session->set_userdata("msg",
                    "Messages deleted successfully!");
                redirect('admin/contactMessageList');
            }
        }
        $this->data['arr_message_details'] = $this->Common_model_marketing->getRecords('mst_contact_us',
            '*', '', 'id DESC');
//echo '<pre>';print_r($this->data['arr_message_details'] );die;

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->data['page_title'] = 'Contact Message List';
        $this->template->write_view('content', 'messages/_view_messages',
            $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function contactMessageView($edit_id = '')
    {
        $contact_id = $edit_id;
        if ($contact_id == '') {
            redirect('admin/contactMessageList');
        }
        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['arr_message_details'] = $this->Common_model_marketing->getRecords('mst_contact_us',
            '*', array("id" => $contact_id), 'id DESC');
//echo '<pre>';print_r($this->data['arr_message_details'] );die;
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->data['page_title']          = 'Contact Message List';
        $this->template->write_view('content', 'messages/_views_main_message',
            $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function changeOrderStatus()
    {
        if ($this->input->post('order_id')) {
            $email_data   = $this->common_model->getRecords('order_summary',
                '*', array('ord_order_number' => $this->input->post('order_id')));
            $update       = $this->common_model->updateRow('order_summary',
                array('ord_status' => $this->input->post('ord_status')),
                array('ord_order_number' => $this->input->post('order_id')));
            $data['data'] = $email_data[0];
            if ($this->input->post('ord_status') == 3) {
                $ordesr_status = '<button type="button" class="btn btn-warning btn-xs">In Progress</button>';
                $html          = $this->load->view('email_templates/order_processed',
                    $data, TRUE);
                $subject       = "Order Processed";
            } elseif ($this->input->post('ord_status') == 4) {
                $ordesr_status = '<button type="button" class="btn btn-danger btn-xs">Completed</button>';
                $html          = $this->load->view('email_templates/order_completed',
                    $data, TRUE);
                $subject       = "Order Completed";
            } elseif ($this->input->post('ord_status') == 5) {
                $ordesr_status = '<button type="button" class="btn btn-danger btn-xs">Cancelled</button>';
                $html          = $this->load->view('email_templates/order_cancel',
                    $data, TRUE);
                $subject       = "Order Cancelled";
            }
            $mail = $this->common_model->sendEmail($email_data[0]['ord_demo_email'],
                array("email" => config_item('site_email'), "name" => config_item('website_name')),
                $subject, $html);
            echo json_encode(array("status" => "1", "order_status" => $ordesr_status));
            exit;
        }
    }

    public function getInstaToken()
    {
        $url = "https://api.instagram.com/v1/users/19151466/media/recent?access_token=1286777132.527d0ef.53dfb3c625d94880af7cdfc113a3b17a";
        $ch  = curl_init($url);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $json = curl_exec($ch);
        curl_close($ch);
        var_dump($json);
    }

    public function updateStockFromCloverWebhook()
    {
        $output = file_get_contents("php://input");
        $insert = $this->common_model->insertRow(array('data' => $output),
            'webhook');
//        $output1 = json_decode($output, true);
//        $itemid  = explode(":",
//            $output1['merchants']['3TSHR2HWTKWY6'][0]['objectId']);
//        if ($output1['merchants']['3TSHR2HWTKWY6'][0]['type'] == 'UPDATE') {
//
//        }
        echo 200;
    }
}