<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inventory extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('clover');
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->model('common_model');
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter',
                'ion_auth'),
            $this->config->item('error_end_delimiter', 'ion_auth'));
        /* Load Backend model */
        $this->load->model(array('users', 'backend/group_model', 'backend/pattribute',
            'backend/pattribute_sub'));
        $this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category'));

        $this->lang->load('auth');
        $this->load->model(array('master/mst_make', 'master/mst_model', 'master/mst_year',
            'backend/coupon_category', 'backend/coupon_method', 'backend/coupon_method_tax',
            'backend/coupon_group', 'common_model', 'Common_model_marketing'));
        $this->flexi = new stdClass;
        $this->load->model(array('backend/product_attribute', 'backend/product',
            'backend/product_images'));
        $this->load->library('flexi_cart');
        $this->load->model(array('users', 'backend/orders_summary', 'backend/orders_details',
            'demo_cart_admin_model'));
    }

    public function storeList()
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

        $this->data['page_title']  = 'Administrator Dashboard';
        $this->data['total_users'] = count($this->users->get_all());
        //Getting Common data
        $data                      = $this->common_model->commonFunction();
        //checking for admin privilages
        //getting all ides selected
        $arr_newsletter_ids        = array();
        if ($this->input->post('checkbox') != '') {
            $arr_newsletter_ids = $this->input->post('checkbox');
            if (count($arr_newsletter_ids) > 0) {
                if (count($arr_newsletter_ids) > 0) {
                    //deleting the newsletter selected
                    $this->common_model->deleteRows($arr_newsletter_ids,
                        TABLES::$MST_NEWSLETTER, "newsletter_id");
                }
                $msg_data = array('msg_type' => 'success', 'newsletter_msg_val' => 'Records deleted successfully.');
                $this->session->set_flashdata('newsletter_msg', $msg_data);
                redirect(base_url()."admin/newsletter/list");
            }
        }

        $this->data['store_list'] = $this->common_model->getRecords(TABLES::$STORE,
            '*', array('is_active' => '1'));


        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'inventory/store_list',
            $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function addStore()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        $user_id = $this->session->userdata('user_id');
        if ($this->input->post()) {
            $insertdata = array("name" => $this->input->post('store_name'),
                "address" => $this->input->post('address'),
                "phone" => $this->input->post('phone'),
                "created_time" => date("Y-m-d H:i:s"),
                "is_active" => $this->input->post('status'),
                "created_by" => $user_id,
            );
            if ($this->common_model->insertRow($insertdata, TABLES::$STORE)) {
                redirect(base_url()."admin/inventory/store-list");
            }
        }

        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title']  = 'Administrator Dashboard';
        $this->data['total_users'] = count($this->users->get_all());
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'inventory/add_store',
            $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function editStore($id)
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        $user_id = $this->session->userdata('user_id');
        if ($this->input->post() && $id != '') {
            $insertdata = array("name" => $this->input->post('store_name'),
                "address" => $this->input->post('address'),
                "phone" => $this->input->post('phone'),
                "created_time" => date("Y-m-d H:i:s"),
                "is_active" => $this->input->post('status'),
                "created_by" => $user_id,
            );
            $this->common_model->updateRow(TABLES::$STORE, $insertdata,
                array('id' => base64_decode($id)));
            redirect(base_url()."admin/inventory/store-list");
        }
        $this->data['store_data'] = $this->common_model->getRecords(TABLES::$STORE,
            '*', array('id' => base64_decode($id)));

        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['id']          = $id;
        $this->data['page_title']  = 'Administrator Dashboard';
        $this->data['total_users'] = count($this->users->get_all());
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'inventory/edit_store',
            $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function changeStatus()
    {

        if ($this->input->post('id') != "") {
            //updating the newsletter status.
            $arr_to_update   = array(
                "is_active" => $this->input->post('status')
            );
            //condition to update record	for the newsletter status
            $condition_array = array('is_active' => ($this->input->post('id')));
            $this->common_model->updateRow(TABLES::$STORE, $arr_to_update,
                $condition_array);
            echo json_encode(array("error" => "0", "error_message" => "Status has been changed successflly."));
        } else {
            //if something going wrong providing error message. 
            echo json_encode(array("error" => "1", "error_message" => "Sorry, your request can not be fulfilled this time. Please try again later"));
        }
    }

    public function storeStock($action = null, $productId = null)
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
        $this->data['product_details']                               = $this->product->getProductStockByStore();
//        print_r($this->data['product_details']);        die();
        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);

        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);

        if ($action == '') {
            $this->data['page_title'] = 'Manage Store Stock';
            $this->template->write_view('content', 'inventory/store_stock_list',
                $this->data);
        }
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function product_stock_mapping()
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
        $this->data['product_details']                               = $this->product->as_array()->get_all();
//        print_r($this->data['product_details']);        die();
        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);

        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);


        $this->data['page_title'] = 'Manage Product Stock Mapping';
        $this->template->write_view('content',
            'inventory/product_stock_mapping', $this->data);

        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function updateStock($storeId = "", $method = null)
    {

        $user_id = $this->session->userdata('user_id');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method === 'modify') {
            $this->data['product_details'] = $this->product->as_array()->get_all();
            foreach ($this->data['product_details'] as $key => $pData) {
                echo $this->input->post('discount_'.$pData['id']);
//                die;
                if ($this->input->post('discount_'.$pData['id'])) {
                    if (count($this->common_model->getRecords('tbl_product_stock_mapping',
                                'id',
                                array('product_id' => $pData['id'], 'store_id' => $storeId)))
                        > 0) {
                        $updateProductData = array(
                            'quantity' => $this->input->post('discount_'.$pData['id']),
                            'updated_by' => $user_id,
                            'updated_time' => date('Y-m-d H:i:s')
                        );
                        $this->common_model->updateRow('tbl_product_stock_mapping',
                            $updateProductData,
                            array('store_id' => $storeId, 'product_id' => $pData['id']));
                        $this->common_model->updateRow('it_products',
                            array('quantity' => $pData['quantity'] - $this->input->post('discount_'.$pData['id'])),
                            array('id' => $pData['id']));
                        $this->common_model->insertRow(array('product_id' => $pData['id'],
                            'store_id' => $storeId, 'created_by' => $user_id, 'created_time' => date('Y-m-d H:i:s'),
                            'quantity' => $this->input->post('discount_'.$pData['id'])),
                            'tbl_stock_given_summary');
                        $this->session->set_flashdata('msg',
                            'Stock updated successfully');
                    } else {
                        $updateProductData1 = array('product_id' => $pData['id'],
                            'store_id' => $storeId, 'quantity' => $this->input->post('discount_'.$pData['id']),
                            'created_by' => $user_id, 'created_time' => date('Y-m-d H:i:s'));
                        $this->common_model->insertRow($updateProductData1,
                            'tbl_product_stock_mapping');
                        $this->common_model->insertRow($updateProductData1,
                            'tbl_stock_given_summary');
                        $this->common_model->updateRow('it_products',
                            array('quantity' => $pData['quantity'] - $this->input->post('discount_'.$pData['id'])),
                            array('id' => $pData['id']));
                        $this->session->set_flashdata('msg',
                            'Stock updated successfully');
                    }
                }
            }

            redirect(base_url()."admin/inventory/store-list");
        }

        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');

        $this->data['product_details']                               = $this->product->get_all_products();
        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);

        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);

        $pageTitle = "Update Stock";
        $renderTo  = "inventory/update_stock";
        $viewData  = $this->data;

        $this->_render_view($pageTitle, $renderTo, $viewData, $storeId);
    }

    public function _render_view($pageTitle, $renderTo, $viewData, $storeId)
    {

        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title']   = $pageTitle;
        $this->data['total_users']  = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());
        $this->data['store_id']     = $storeId;

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', $renderTo, $viewData);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function getAllProducts()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title']   = $pageTitle;
        $this->data['total_users']  = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());
        $this->data['store_id']     = $storeId;

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'inventory/clover_all_products',
            $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function getAllCustomers()
    {
        $this->load->library('clover');
        $items = $this->clover->getCustomers();

        foreach ($items['elements'] as $key) {
            foreach ($key as $k => $v) {
                echo $k." = ".$v."<br>";
            }
        }
    }

    public function getSingleCustomer()
    {
        $this->load->library('clover');
        $items = $this->clover->getSingleCustomer("177DD701JVJJM");

        print_r($items);
    }

    public function createCustomer()
    {
        $postdata = array(
            'customerSince' => '1507103657000',
            'firstName' => 'atul',
            'lastName' => 'suroshe',
            'emailAddresses' =>
            array(
                0 =>
                array(
                    'emailAddress' => 'atuls@rebelute.com',
                    'id' => '',
                    'verifiedTime' => '1507103657000',
                ),
            ),
        );
        $this->load->library('clover');
        $items    = $this->clover->createCustomers($postdata);
        echo "<pre>";
        print_r($items);
    }
    /*
     * Function to get items from clover
     * @return array
     */

    public function createProduct()
    {
        $postdata = array(
            'modifiedTime' => '1507103657000',
            'code' => 'TEST123',
            'cost' => '230',
            'hidden' => false,
            'unitName' => 'OZ',
            'priceType' => 'FIXED',
            'alternateName' => 'Test Product from api',
            'isRevenue' => false,
            'itemStock' =>
            array(
                'item' =>
                array(
                    'id' => '',
                ),
                'quantity' => 0,
                'stockCount' => '12',
            ),
            'price' => '230',
            'name' => 'Test Product',
            'id' => 'TEST12345',
            'sku' => 'PRDLKSDS',
            'defaultTaxRates' => false,
            'stockCount' => '15',
        );
        $this->load->library('clover');
        $items    = $this->clover->createProduct($postdata);
        echo "<pre>";
        print_r($items);
    }

    public function deleteProduct()
    {

        $this->load->library('clover');
        $items = $this->clover->deleteProduct("Z9XKMGQAMVZPT");
        $items = (array) $items;
        if (empty($items)) {
            echo "Product deleted successfully";
        } else {
            echo $items['details'];
        }
    }

    public function createProductCategory()
    {
        $postdata = array(
            'sortOrder' => '1',
            'name' => 'Featured Collection',
            'id' => '',
        );
        $this->load->library('clover');
        $items    = $this->clover->createProductCategory($postdata);
        $items    = (array) $items;
        if (empty($items)) {
            echo "Product deleted successfully";
        } else {
            echo $items['details'];
        }
    }

    public function getAllCategories()
    {
        $this->load->library('clover');
        $items = $this->clover->getAllCategories();

        foreach ($items['elements'] as $key) {
            foreach ($key as $k => $v) {
                echo $k." = ".$v."<br>";
            }
        }
    }

    public function cloverInventory()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        $this->data['dataHeader'] = $this->users->get_allData($user_id);


        $this->data['total_users']  = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->data['page_title']   = 'Manage Clover Inventory Stock';
        $this->template->write_view('content', 'inventory/clover_items',
            $this->data);

        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function loadCloverInventory($showlimit = "")
    {
        $items = $this->clover->getAllProducts($showlimit);

        $i = 0;
        foreach ($items['elements'] as $value) {
            // $item_stock = $this->clover->getItemStock($value['id']);     
            // echo "<pre>";
            // echo $item_stock['quantity'];     
            $data['data'][$i][] = $value['id'];
            $data['data'][$i][] = $value['name'];
            $data['data'][$i][] = $value['code'];
            $data['data'][$i][] = "$".number_format(($value['price'] / 100), 2);
            $data['data'][$i][] = "$".number_format(($value['cost'] / 100), 2);
            $data['data'][$i][] = "<input style='width:80px' type='number' value='".$value['itemStock']['quantity']."' id='qty_".$i."' min='1' name='updateStock'>&nbsp;&nbsp;&nbsp;<a onclick='updateQuantity(&#39;".$value["id"]."&#39;,".$i.")' id='save_".$i."' >Save</a>";
            $i++;
        }
        echo json_encode($data);
    }

    public function loadCloverProducts($showlimit = "")
    {
        $items = $this->clover->getAllProducts($showlimit);

        $i = 0;
        foreach ($items['elements'] as $value) {

            $data['data'][$i][] = $value['id'];
            $data['data'][$i][] = $value['name'];
            $data['data'][$i][] = $value['code'];
            $data['data'][$i][] = "$".number_format(($value['price'] / 100), 2);
            $data['data'][$i][] = "$".number_format(($value['cost'] / 100), 2);
            $data['data'][$i][] = $value['itemStock']['quantity'];
            $data['data'][$i][] = "<a class='btn btn-default btn-xs' href='".base_url()."admin/inventory/edit-clover-product/".$value['id']."'>Edit</a><a class='btn btn-default btn-xs' href='".base_url()."admin/inventory/delete-clover-product/".$value['id']."'>Delete</a>";
            $i++;
        }
        echo json_encode($data);
    }

    public function cloverProductDetails($product_id = "")
    {
        $this->data['result']     = $this->clover->getSingleProduct($product_id);
        $this->data['categories'] = $this->clover->getAllCategory();
        $this->data['product_id'] = $product_id;
        // echo "<pre>";
        // print_r($this->data['result']);
        // die;

        if (count($this->input->post()) > 0) {
            $cat = array();
            for ($i = 0; $i < count($this->input->post('category')); $i++) {
                $catid                    = explode("@",
                    $this->input->post('category')[$i]);
                $cat[$i]['sortOrder']     = '1';
                $cat[$i]['name']          = $catid[1];
                $cat[$i]['id']            = $catid[0];
                $cat[$i]['items'][]['id'] = $product_id;
//                $cat_data = array(
//                'sortOrder' => '1',
//                'name' => 'Test',
//                'id' => '',
//                'items' =>
//                array(
//                    0 =>
//                    array(
//                        'id' => $product_id,
//                    ),
//                ),
//            );
//            $this->clover->updateItemCategory($product_id, $cat_data);
            }
            $update_data = array(
                'modifiedTime' => round(microtime(true) * 1000),
                'code' => $this->input->post('product_code'),
                'cost' => $this->input->post('product_cost') * 100,
                'hidden' => false,
                'unitName' => $this->input->post('product_name'),
                'priceType' => $this->input->post('price_type'),
                'alternateName' => $this->input->post('product_name'),
                'isRevenue' => false,
                'itemStock' =>
                array(
                    'item' =>
                    array(
                        'id' => $product_id,
                    ),
                    'quantity' => $this->input->post('quantity'),
                    'stockCount' => $this->input->post('quantity'),
                ),
                'price' => $this->input->post('product_price') * 100,
                'name' => $this->input->post('product_name'),
                'id' => $product_id,
                'categories' => $cat,
                'sku' => $this->input->post('sku'),
                'stockCount' => $this->input->post('quantity'),
            );

            $update = $this->clover->updateProduct($product_id, $update_data);
            echo "<pre>";
            print_r($update);
            die;
            redirect(base_url()."admin/inventory/clover-products");
        }
        $user_id = $this->session->userdata('user_id');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        $this->data['dataHeader'] = $this->users->get_allData($user_id);


        $this->data['total_users']  = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->data['page_title']   = 'Product Details';
        $this->template->write_view('content', 'inventory/edit_clover_product',
            $this->data);

        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function deleteCloverProduct($product_id = '')
    {
        $delete = $this->clover->deleteProduct($product_id);
        redirect(base_url()."admin/inventory/clover-products");
    }

    public function cloverOrders()
    {


        $user_id = $this->session->userdata('user_id');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        $this->data['dataHeader']   = $this->users->get_allData($user_id);
        $this->data['total_users']  = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->data['page_title']   = 'Manage Orders';
        $this->template->write_view('content', 'inventory/clover_orders',
            $this->data);

        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function updateCloverInventoryStock()
    {
        $postdata = array('quantity' => $this->input->post('quantity'));
        $this->load->library('clover');
        $items    = $this->clover->updateStockCount($this->input->post('item_id'),
            $postdata);
        $items    = (array) $items;
        if (!empty($items)) {
            echo json_encode(array("status" => '1'));
        } else {
            echo json_encode(array("status" => '0'));
        }
    }

    public function getAllOrders($showlimit = "")
    {

        $items = $this->clover->getAllOrders($showlimit);

        $i = 0;
        foreach ($items['elements'] as $value) {
            $seconds = $value['clientCreatedTime'] / 1000;

            $data['data'][$i][] = $value['id'];
            $data['data'][$i][] = $value['customers']['elements'][0]['firstName']." ".$value['customers']['elements'][0]['lastName'];
            $data['data'][$i][] = "$".number_format(($value['total'] / 100), 2);
            $data['data'][$i][] = $value['payType'];
            $data['data'][$i][] = date("d-M-Y h:i a", $seconds);
            $data['data'][$i][] = '<a href="'.base_url().'admin/inventory/cloverOrderDetails/'.$value['id'].'" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> Details</a>';
            $i++;
        }

        echo json_encode($data);
    }

    public function cloverOrderDetails($order_id = "")
    {
        $data = $this->clover->getOrderDetails($order_id);

        $i                           = 0;
        $result['id']                = $data['id'];
        $result['currency']          = $data['currency'];
        $result['total']             = $data['total'];
        $result['state']             = $data['state'];
        $result['payType']           = $data['payType'];
        $result['clientCreatedTime'] = $data['clientCreatedTime'];



        $discount                       = $this->clover->getDiscountOfOrder($order_id);
        // echo "<pre>";
        // print_r($discount);
        // die;
        $this->data['order_details']    = array($data);
//            echo "<pre>";
//        print_r($this->data['order_details']);
//        die;
        $this->data['discount_details'] = $discount;

        $user_id = $this->session->userdata('user_id');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        $this->data['dataHeader'] = $this->users->get_allData($user_id);


        $this->data['total_users']  = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->data['page_title']   = 'Order Details';
        $this->template->write_view('content', 'inventory/clover_order_details',
            $this->data);

        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function updatecloverId()
    {
        $products = $this->clover->getAllProducts();
        echo "<pre>";
        print_r($products);
        foreach ($products['elements'] as $pr) {
            echo $pr['code']."<br>";
            if (isset($pr['code']) && $pr['code']!='') {
                $update = $this->common_model->updateRow('it_products',
                    array('clover_id' => $pr['id']),
                    array('product_sku' => $pr['code']));
            }
        }
    }

    public function weekly_inventory(){
        $this->load->model('report_model');
        if($this->input->get()){
            $date_split = explode('-',$this->input->get('dateFilter'));
            $start_date = date("Y-m-d",strtotime($date_split[0]));
            $end_date = date("Y-m-d",strtotime($date_split[1]));
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->data['inventory_data'] = $this->report_model->getWeeklyInventoryReport($start_date,$end_date);

        }else{
            $this->data['inventory_data'] = $this->report_model->getWeeklyInventoryReport($start_date = "",$end_date="");
        }
        
         $user_id = $this->session->userdata('user_id');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }   
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        
        $this->data['total_users']  = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->data['page_title']   = 'Order Details';
        $this->template->write_view('content', 'inventory/weekly_report',
            $this->data);

        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }
}