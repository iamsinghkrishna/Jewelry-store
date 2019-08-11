<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'libraries/Stripe/lib/Stripe.php');

//ini_set('display_startup_errors',1);
//ini_set('display_errors',1);
//error_reporting(-1);
class Home extends MY_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->library('facebook');

        $this->load->model('user');

        $this->load->database();

        $this->load->library(array('ion_auth', 'form_validation'));

        $this->load->library('pagination');

        $this->load->model('common_model');

        $this->load->library('paypal_lib');

        $this->flexi = new stdClass;



        $this->load->library('flexi_cart');

        $this->load->model(array('users', 'slider_home', 'wishlist_model', 'backend/review_model'));

        $this->load->helper(array('url', 'language'));

        $this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category', 'backend/product', 'testimonial'));



        /* Load Product model */

        $this->load->model(array('backend/product_attribute', 'backend/product', 'backend/product_images'));

        $this->load->model(array('users', 'backend/group_model', 'backend/pattribute', 'backend/pattribute_sub'));

        $this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category'));

        $this->load->model(array('backend/Payment', 'payment'));

        $this->load->model(array('users', 'backend/orders_summary', 'backend/orders_details'));

        $this->load->model(array('users', 'backend/pages_model', 'enquiry_model'));

        /* Load Master model */

        $this->load->model(array('master/mst_make', 'master/mst_model', 'master/mst_year'));

        $this->load->model(array('country', 'state', 'city'));

        $this->data['cart_items'] = $this->flexi_cart->cart_items();



        /* Cart Library */

        $this->load->model('demo_cart_model');



//        $this->load->model(array('flexi_cart_admin'));



        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));



        $this->lang->load('auth');

        $this->data = $this->_get_all_data();





        $data = file_get_contents("https://www.instagram.com/vaskiajewelry/media/");

        $result = json_decode($data);

        //echo '<pre>';print_R($result);die;

        $insta_img = array();



        if (isset($result->items) && !empty($result->items)) {

            foreach ($result->items as $img) {

                if (isset($img->images) && !empty($img->images) && $img->images != null) {

                    $insta_img[] = $img->images->standard_resolution->url;
                }
            }
        }



        $this->data['insta_feeds'] = $insta_img;
    }

// redirect if needed, otherwise display the user list

    public function index() {

//$this->_render_page('login', $this->data);

        $categoryOptions = '';

        $todaysDate = date('Y-m-d');
        $promotion_conditions = "status='1' AND '{$todaysDate}' between from_date and to_date";
        $this->data['promotions'] = $this->common_model->getRecords('tbl_promotion_banners', '*', $promotion_conditions);
//        echo '<pre>';print_R($this->data['promotions']);
//        die;
//        $this->data = $this->_get_all_data();
// $data = file_get_contents("https://www.instagram.com/vaskiajewelry/media/");
//
//        $result = json_decode($data);
//
        //$this->data['result'] = json_decode($result);


        $this->data['slide'] = $this->slider_home->get_slider();

        //echo '<pre>';print_R($this->data['prodcut_cat_detail']);die;
        $this->data['prodcut_cat_detail_original'] = $this->data['prodcut_cat_detail'];

        $conditions = '';
        $featuredcat = $this->common_model->getRecords('tbl_home_featured_category', '*', '');
        //echo '<pre>';print_R($featuredcat);die;
        //$this->data['prodcut_cat_detail']  = array();
        if (count($featuredcat) > 0) {
            foreach ($featuredcat as $keyss => $fcat) {
                if ($fcat['category_id'] != '' && $fcat['subcategory_id'] != '') {
                    $this->data['prodcut_cat_detail_new'][$keyss] = $this->product_sub_category->get_product_sub_attribute_featured($fcat['category_id'], $fcat['subcategory_id']);
//                   echo '<pre>';print_r($this->data['prodcut_cat_detail_new']);die;
                    if (count($this->data['prodcut_cat_detail_new']) > 0) {
                        foreach ($this->data['prodcut_cat_detail_new'] as $key => $dd) {
                            //echo '<pre>';print_R($dd[0]['p_category_id']);die;
                            $arr_product_details = $this->product->get_product_by_category_id($dd['p_category_id'], $dd['p_sub_category_id'], 0, 3);
                            $this->data['prodcut_cat_detail_new'][$keyss]['product_details'] = $arr_product_details;
                        }
                    }
                }
            }
        }
//        if(count($this->data['prodcut_cat_detail_new']) > 0){
//            foreach($this->data['prodcut_cat_detail_new'] as $kesy => $data){
//                $prodcut_cat_detail_new = 
//            }
//        }
//         echo "<pre>";
//            print_r($this->data['prodcut_cat_detail_new']);
//            die;

        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header_home', $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'home/main_content', $this->data, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function login() {
//google authentication
        
        $userData = array();

        if ($this->facebook->is_authenticated()) {
            // Get user facebook profile details
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 10; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
            $password = $randomString;
            $userData['oauth_provider'] = 'facebook';
            $userData['oauth_uid'] = $userProfile['id'];
            $userData['first_name'] = $userProfile['first_name'];
            $userData['last_name'] = $userProfile['last_name'];
            $userData['email'] = $userProfile['email'];
            $userData['gender'] = $userProfile['gender'];
            $userData['locale'] = $userProfile['locale'];
            $userData['profile_url'] = 'https://www.facebook.com/' . $userProfile['id'];
            $userData['picture_url'] = $userProfile['picture']['data']['url'];
            $userData['password'] = $this->ion_auth->hash_password($password);
            $userData['active'] = 1;
            $userData['active'] = $this->input->ip_address();

//            print_r($password);
//            die();
            $userID = $this->user->checkUser($userData);

            if (!empty($userID)) {
                $data = $this->users->as_array()->get($userID);
//                print_r($data);die();

                $remember = NULL;
                if ($this->ion_auth->login($userData['email'], $password, FALSE)) {
                    $this->data['userData'] = $userData;
                    $this->session->set_userdata('userData', $userData);
                    //if the login is successful
                    //redirect them back to the home page
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    if ($this->ion_auth->is_admin()) {
                        $message = 'Hi,<br><br>';
                        $message .= 'Name :-' . $userData['first_name'] . '<br><br>';
                        $message .= 'userName:- ' . $userData['email'] . '<br><br>';
                        $message .= 'pasword :- ' . $password . '<br><br>';
                        $message .= 'link-: <a href=' . base_url("home/login") . '>Click Here</a><br><br><br>';
                        $message .= 'Thank You';
                        $email = $userData['email'];
                        $subject = 'Registration Facebook';

                        $this->email($email, $message, $subject);
                        if (strpos($_SERVER['HTTP_REFERER'], "cart"))
                            redirect('/home/cart', 'refresh');
                        else
                            redirect('/admin', 'refresh');
                    } else {
                        if (strpos($_SERVER['HTTP_REFERER'], "cart")) {
                            redirect('/home/cart', 'refresh');
                        } else {
                            $this->demo_cart_model->retainCart();
                            redirect('/home', 'refresh');
                        }
                    }
                }
//               die();
            } else {
//                  echo'noe'. $userID;
                $this->data['userData'] = array();
            }
//die();
            // Get logout URL
            $this->data['logoutUrl'] = $this->facebook->logout_url();
//            echo 'ok';
        } else {
            $fbuser = '';

            // Get login URL
            $this->data['authUrl'] = $this->facebook->login_url();
        }
        include_once APPPATH . "libraries/google-api-php-client/Google_Client.php";
        include_once APPPATH . "libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $userData_google = array();
        // Google Project API Credentials
        $clientId = '298669613263-nnqvg9m2c2dh4c26kmn2l432cndcpl7h.apps.googleusercontent.com';
        $clientSecret = '6KNLzHYdRA7c7rVXVq6GsPb5';
        $redirectUrl = base_url() . 'home/login/';

        // Google Client Configuration
        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to codexworld.com');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectUrl);
        $google_oauthV2 = new Google_Oauth2Service($gClient);
//        print_r($_REQUEST['code']);die;
        if (isset($_GET['code'])) {
            $gClient->authenticate();
            $this->session->set_userdata('token', $gClient->getAccessToken());
            redirect($redirectUrl);
        }

        $token = $this->session->userdata('token');
        if (!empty($token)) {
            $gClient->setAccessToken($token);
        }

        if ($gClient->getAccessToken()) {
            $userProfile = $google_oauthV2->userinfo->get();

            // Preparing data for database insertion
            $password = $randomString;
            $userData_google['oauth_provider'] = 'google';
            $userData_google['oauth_uid'] = $userProfile['id'];
            $userData_google['first_name'] = $userProfile['given_name'];
            $userData_google['last_name'] = $userProfile['family_name'];
            $userData_google['email'] = $userProfile['email'];
            $userData_google['gender'] = $userProfile['gender'];
            $userData_google['locale'] = $userProfile['locale'];
            $userData_google['profile_url'] = $userProfile['link'];
            $userData_google['picture_url'] = $userProfile['picture'];
            $userData_google['password'] = $this->ion_auth->hash_password($password);
            $userData_google['active'] = 1;
            $userData_google['ip_address'] = $this->input->ip_address();
            // Insert or update user data
            $userID_g = $this->user->checkUser($userData_google);
            if (!empty($userID_g)) {
//                $this->data['userData'] = $userData_google;
//                $this->session->set_userdata('userData', $userData_google);
//                   $data = $this->users->as_array()->get($userID);
//                print_r($data);die();

                $remember = NULL;
                if ($this->ion_auth->login($userData_google['email'], $password, FALSE)) {

                    $message = 'Hi,<br><br>';
                    $message .= 'Name :-' . $userData_google['first_name'] . '<br><br>';
                    $message .= 'userName:- ' . $userData_google['email'] . '<br><br>';
                    $message .= 'pasword :- ' . $password . '<br><br>';
                    $message .= 'link-: <a href=' . base_url("home/login") . '>Click Here</a><br><br><br>';
                    $message .= 'Thank You';
                    $email = $userData_google['email'];
                    $subject = 'Registration google';

                    $this->email($email, $message, $subject);
                    $this->data['userData'] = $userData_google;
                    $this->session->set_userdata('userData', $userData_google);
                    //if the login is successful
                    //redirect them back to the home page
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    if ($this->ion_auth->is_admin()) {

                        if (strpos($_SERVER['HTTP_REFERER'], "cart"))
                            redirect('/home/cart', 'refresh');
                        else
                            redirect('/admin', 'refresh');
                    } else {
                        if (strpos($_SERVER['HTTP_REFERER'], "cart")) {
                            redirect('/home/cart', 'refresh');
                        } else {
                            $this->demo_cart_model->retainCart();
                            redirect('/home', 'refresh');
                        }
                    }
                }
            } else {
                $this->data['userData'] = array();
            }
        } else {
            $this->data['authUrl_g'] = $gClient->createAuthUrl();
        }
        //end auth

        


        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data = $this->_get_all_data();

        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('content', 'home/_login', $this->data, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function email($email, $message, $subject) {

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com'; //smtp host name
        $config['smtp_port'] = '465'; //smtp port number
        $config['smtp_user'] = 'ttire688';
        $config['smtp_pass'] = 'email1234'; //$from_email password
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['newline'] = "\r\n"; //use double quotes
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->set_crlf("\r\n");
        $this->email->from('ttire688'); // change it to yours
        $this->email->to($email); // change it to yours
        $this->email->subject($subject);
        $this->email->message($message);
        return $this->email->send();
    }

    public function logout() {
        // Remove local Facebook session
        $this->facebook->destroy_session();
        $this->session->unset_userdata('token');
        $this->session->unset_userdata('userData');
        $this->session->sess_destroy();
        // Remove user data from session
        $this->session->unset_userdata('userData');

        // Redirect to login page
        redirect('home');
    }

    public function register() {

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);



        $this->data = $this->_get_all_data();



        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

        $this->template->write_view('content', 'home/_register', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function forgotPassword() {

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data = $this->_get_all_data();
        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

        $this->template->write_view('content', 'home/_forgot_password', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function about_us() {

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);



        $this->data = $this->_get_all_data();



        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

        $this->template->write_view('content', 'home/about_us', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function faq() {

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);



        $this->data = $this->_get_all_data();



        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

        $this->template->write_view('content', 'home/faq', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function shipping() {

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);



        $this->data = $this->_get_all_data();



        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

        $this->template->write_view('content', 'home/shipping', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function return_and_exchange() {

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);



        $this->data = $this->_get_all_data();



        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

        $this->template->write_view('content', 'home/return', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function contact_us() {



        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        //echo '<pre>';print_r($this->data['dataHeader']);die;

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();

        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {

            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }





        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'home/contact_us', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function review_rating($method = null) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == "review") {
            $user_id = $this->session->userdata('user_id');
            $rate = trim($this->input->post('points'));
            $product_id = trim($this->input->post('product_id'));
            $dis = trim($this->input->post('dis'));
            $id = trim($this->input->post('editid'));
            $che = $this->review_model->check_review_product($product_id, $user_id);
            //echo '<pre>';print_r($che);die;
            if ($che == '1' && $product_id != '') {
                $arr = array(
//                    'product_id' => $product_id,
                    'discription' => $dis,
                    'review_total' => $rate,
//                    'user_id' => $user_id
                );

//           echo $id;           die()
                $this->review_model->update($id, $arr);
                echo json_encode(array('status' => '200'));
            } else {
                if ($product_id != '' && $user_id != '') {
                    $arr = array(
                        'product_id' => $product_id,
                        'discription' => $dis,
                        'review_total' => $rate,
                        'user_id' => $user_id
                    );
                    //echo '<pre>';print_r($arr);die;
                    $this->review_model->insert($arr);
                    echo json_encode(array('status' => '100'));
                } else {
                    echo json_encode(array('status' => '300'));
                }
            }

            //die();
            //redirect('')
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == "edit" || $this->input->post('editid') != '') {

            $pid = $this->input->post('pid');
            $uid = $this->input->post('uid');

            $result = $this->review_model->get_review_edit($uid, $pid);
            if ($result) {
                echo json_encode($result);
            }
        }
//        echo json_encode(TRUE);
//        die();
    }

    public function shop() {



        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['essential'] = $this->product->get_product_by_category_id('4', '', 0, 10);

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();



        $this->data['product_details'] = $this->product->get_products_by_limit('all', 4);

        foreach ($this->data['product_details'] as $key => $value) {

            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);

//            $this->data['product_details'][$key]['product_attr_details'] = $prodcut_cat_detail;
//            $this->data['product_details'][$key]['prodcut_cat_edit_detail'] = $this->product_attribute->get_details_by_id($produictId);
        }

//        echo "<pre>";
//        print_r($this->data['product_details']);
//        die;



        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'shop', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function category($category = null, $subcat = null, $subcatThird = null) {
        //echo 'hi'.$subcatThird;die;

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['essential'] = $this->product->get_product_by_category_id('4', '', 0, 10);

//        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();

        $this->data['catid'] = $category;

        $this->data['product_details'] = $this->product->get_product_by_category_id($category, $subcat, 0, 10, '', $subcatThird);
        $this->data['total_product_details'] = $this->product->get_product_by_category_id($category, $subcat, 0, 300000, '', $subcatThird);
        //echo '<pre>';print_r($this->data['product_details']);die;
        foreach ($this->data['product_details'] as $key => $value) {
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);
        }


        if ($category != '') {
            $details = $this->product_category->get_category_name_by_id($category);
            //
            $this->data['category_name'] = $details['name'];
            $this->data['category_ids'] = $category;
        } else {
            $this->data['category_name'] = '';
            $this->data['category_ids'] = '';
        }
        $this->data['subcatThird'] = $subcatThird;

        if ($subcat != '') {
            $detailss = $this->product_sub_category->get_sub_category_name_by_id($subcat);
            //echo '<pre>';print_r($details);die;
            $this->data['sub_category_name'] = $detailss['name'];
            $this->data['sub_category_ids'] = $subcat;
        } else {
            $this->data['sub_category_name'] = '';
            $this->data['sub_category_ids'] = '';
        }
        $this->data['page_limit'] = 10;
//        echo "<pre>";
//        print_r($this->data['prodcut_cat_detail']);
//        die;



        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'category', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function sell_car() {



        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);





        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header_t', $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'home/sell_car', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function single_post() {





        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);







        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header_t', $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'home/single_post', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function news_review() {



        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);





        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header_t', NULL);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'home/news_review', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function search_car() {



        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);





        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header_t', $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'home/search_car', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

//    public function shop($categoryId = NULL, $subCategoryId = NULL) {
//        $this->data = '';
//        $this->data['testi_monial'] = $this->testimonial->get_testimonial();
//
//        $user_id = $this->session->userdata('user_id');
//
//        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
//        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
//            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
//        }
//        if (isset($categoryId)) {
//            $details = $this->product_category->get_category_name_by_id($categoryId);
//            $this->data['category_title'] = $details['name'];
//            $this->data['category_description'] = $details['description'];
//        } else {
//            $this->data['category_title'] = "Shop";
//            $this->data['category_description'] = "It all begins right here at Tire Rack. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
//        }
//
//
//        $this->data['testi_monial'] = $this->testimonial->get_testimonial();
//
//
//        $this->data['dataHeader'] = $this->users->get_allData($user_id);
//        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
//        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
//        $this->data['product_year'] = array('' => 'Select Year') + $this->mst_year->dropdown('name');
//        $this->data['product_model'] = array('' => 'Select Model') + $this->mst_model->dropdown('name');
//
//
//        $this->data['product_details'] = $this->product->get_product_by_category_id($categoryId, $subCategoryId);
//        $config['base_url'] = base_url() . 'shop/' . $categoryId . '/' . $subCategoryId . '/';
//        $config['total_rows'] = 5;
//        $config['per_page'] = 1;
//
//        $this->pagination->initialize($config);
//
//        /* Product Filter category */
//        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
//            foreach ($categoryDp['sub_attibutes'] as $subAttr)
//                if ($subAttr['parent_id'] > 0) {
//                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
//                }
//        }
//        $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;
//        /* Product Filter category */
//
////        echo '<pre>', print_r($this->data['product_details']);die;
//
//        $this->template->set_master_template('landing_template.php');
//        $this->template->write_view('header', 'snippets/header', $this->data);
//        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
//        $this->template->write_view('content', 'shop', NULL, TRUE);
//        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);
//        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);
//        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
//        $this->template->render();
//    }



    public function shop_product($produictId = NULL, $productCategoryId = null) {
        //echo $produictId;
        if ($productCategoryId != '') {
            $productCategoryId = base64_decode($productCategoryId);
        }
        $user_id = $this->session->userdata('user_id');



//        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
//        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
//        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
//            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
//        }

        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['essential'] = $this->product->get_product_by_category_id('4', '', 0, 10);

//        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
//        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
//            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
//        }
//        $this->data['testi_monial'] = $this->testimonial->get_testimonial();
//        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
//        $this->data['review'] = $this->review_model->get_review($user_id, $produictId);
//        $this->data['all_review'] = $this->review_model->get_all_reiview_products($produictId);
////        echo '<pre>', print_r( $this->data['all_review']);die;
//        $average_rating = null;
//        foreach ($this->data['all_review'] as $rData) {
//            $average_rating += $rData['review_total'];
//        }
////        echo $average_rating;
//        $cnt = count($this->data['all_review']);
//        if ($cnt != 0) {
//            $average_rating = $average_rating / ($cnt * 5) * 5;
//            $this->data['average_rating'] = $average_rating;
//        } else {
//            $this->data['average_rating'] = 0;
//        }
////        echo $user_id;
//        $this->data['check'] = $this->review_model->check_review_product($produictId, $user_id);


        $this->data['product_details'] = $this->product->get_product_by_product_id($produictId);
        //echo $this->db->last_query();die;
        //echo '<pre>', print_r($this->data['product_details']);die;
//        $prodcut_cat_detail = $this->product_sub_category->get_product_sub_attribute($productCategoryId);
//
//
//
////        $this->data['related_product_details'] = $this->product->get_product_by_category_id($productCategoryId);
//
//
//
//        foreach ($prodcut_cat_detail as $key => $dataAtt) {
//
//            $prodcut_cat_detail[$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
//        }
        //echo '<pre>';print_R($this->data['product_details']);die;

        foreach ($this->data['product_details'] as $key => $value) {

            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($produictId);

//            $this->data['product_details'][$key]['product_attr_details'] = $prodcut_cat_detail;
//            $this->data['product_details'][$key]['prodcut_cat_edit_detail'] = $this->product_attribute->get_details_by_id($produictId);
        }



//        echo '<pre>', print_r($this->data['product_details'][$key]['prodcut_cat_edit_detail']);die;



        /* Product Filter category */

//        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
//            foreach ($categoryDp['sub_attibutes'] as $subAttr)
//                if ($subAttr['parent_id'] > 0) {
//                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
//                }
//        }
//        $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;

        /* Product Filter category */

//        echo "<pre>";
//        print_r($this->data);
//        die;

        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'home/shop_product', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function element() {



        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);





        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header_t', $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'home/element', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function home_search() {



        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);





        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header_t', $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'home_search', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function home_shop() {



        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);





        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header_t', $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'home/home_shop', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function filters() {



        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);



        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header_t', $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'home/filter', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function cart() {
        $categoryOptions = array();
//        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        $this->data['cart_items'] = $this->flexi_cart->cart_items();

//        echo '<pre>', print_r($this->data['cart_items']);die;

        if (isset($this->session->userdata('flexi_cart')['summary']))
            $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
        $this->data['custom_option']['tax_total'] = $_SESSION['custom_option']['tax_total'];
        $this->data['custom_option']['shipping_total'] = $_SESSION['custom_option']['shipping_total'];

//        echo '<pre>', print_r($this->data['cart_items']);die;

        $this->data['discounts'] = $this->flexi_cart->summary_discount_data();
        //echo '<pre>';print_r($this->data['discounts']);die;
//        $this->data['home_section'] = $this->site_section->home_page_sction();

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        //echo '<pre>';print_r($this->data['dataHeader']);die;
        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');



//        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
//
//        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
//
//            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
//        }



        /* Product Filter category */

//        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
//
//            foreach ($categoryDp['sub_attibutes'] as $subAttr)
//                if ($subAttr['parent_id'] > 0) {
//
//                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
//                }
//        }
        // echo '<pre>';print_r($this->data['prodcut_cat_detail']);die;
        //echo $this->session->userdata('message');die;

        $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;

        /* Product Filter category */

        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'cart', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function checkout() {



        $this->load->model('demo_cart_model');



// Check whether the cart is empty using the 'cart_status()' function and redirect the user away if necessary.

        if (!$this->flexi_cart->cart_status()) {

            $this->flexi_cart->set_error_message('You must add an item to the cart before you can checkout.', 'public');



// Set a message to the CI flashdata so that it is available after the page redirect.

            $this->session->set_flashdata('message', $this->flexi_cart->get_messages());



            redirect('standard_library/view_cart');
        }



// Check whether the user has submitted their details and that the information is valid.
// The custom demo function 'demo_save_order()' validates the data using CI's validation library and then saves the cart to the database using the 'save_order()' function.
// If the data is saved successfully, the user is redirected to the 'Checkout Complete' page.

        if ($this->input->post('checkout')) {





            $config = array(
                array(
                    'field' => 'checkout[billing][name]',
                    'label' => 'Name',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'checkout[billing][add_01]',
                    'label' => 'Billing Address line 1',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => 'You must provide a %s.',
                    ),
                ),
                array(
                    'field' => 'checkout[billing][city]',
                    'label' => 'Billing City',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'checkout[billing][state]',
                    'label' => 'Billing State',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'checkout[billing][post_code]',
                    'label' => 'Zip Code',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'checkout[shipping][name]',
                    'label' => 'Shipping Name',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'checkout[shipping][add_01]',
                    'label' => 'Shipping Address line 1',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'checkout[shipping][city]',
                    'label' => 'Shipping Address line 1',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'checkout[shipping][post_code]',
                    'label' => 'Shipping postal code',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'checkout[email]',
                    'label' => 'Email',
                    'rules' => 'required|valid_email'
                ),
                array(
                    'field' => 'checkout[phone]',
                    'label' => 'Phone NUmber',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'payment_method',
                    'label' => 'Payment method',
                    'rules' => 'required'
                )
            );



            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == TRUE) {

                $response = $this->demo_cart_model->demo_save_order($_POST);

// Set a message to the CI flashdata so that it is available after the page redirect.

                $this->session->set_flashdata('message', $this->flexi_cart->get_messages());
                $current_discounts = $this->flexi_cart->summary_discount_data();

                $applied_coupons = $this->session->userdata('coupons_use_limit');
                if (count($current_discounts) > 0 && $applied_coupons == '') {
                    $disc_code = $current_discounts['total']['code'];
                    $arr_coupon_code_details = $this->common_model->getRecords('discounts', 'disc_usage_limit', array("disc_code" => $disc_code));
                    $disc_usage_limit = $arr_coupon_code_details[0]['disc_usage_limit'];
                    $update_data = array(
                        "disc_usage_limit" => $disc_usage_limit + 1,
                    );
                    $condition_to_pass = array("disc_code" => $disc_code);
                    $last_update_id = $this->common_model->updateRow('discounts', $update_data, $condition_to_pass);
                    $this->session->set_userdata('coupons_use_limit', '1');
                }
                if ($this->input->post('payment_method') == '1') {
                    redirect('home/payment');
                } else {
                    redirect('home/buy');
                }

// Check that the order saved correctly.

                if ($response) {

// Attach the saved order number to the redirect url.

                    redirect('admin_library/order_details/' . $this->flexi_cart->order_number());
                }
            }
        }

        $categoryOptions = array();

//         $this->data['pages'] = $this->pages_model->as_array()->get_all();



        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        if (isset($this->session->userdata('flexi_cart')['summary']))
            $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
        $this->data['custom_option']['tax_total'] = $_SESSION['custom_option']['tax_total'];
        $this->data['custom_option']['shipping_total'] = $_SESSION['custom_option']['shipping_total'];

//        echo '<pre>', print_r($this->data['cart_items']);die;

        $this->data['discounts'] = $this->flexi_cart->summary_discount_data();


//        $this->data['home_section'] = $this->site_section->home_page_sction();

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');



        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();

        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {

            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }



        /* Product Filter category */

        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {

            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {

                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                }
        }

        $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $sql_select = array($this->flexi_cart->db_column('locations', 'id'), $this->flexi_cart->db_column('locations', 'name'));

        $this->data['countries'] = $this->flexi_cart->get_shipping_location_array($sql_select, 0);

        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

//        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'checkout', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

//        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function blogs() {

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();

        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {

            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }

        $this->data['testi_monial'] = $this->testimonial->get_testimonial();



        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['blog_count'] = $this->testimonial->get_blog();

        $this->data['blog_d'] = $this->testimonial->get_blog_d();

        $config = array();

        $config["base_url"] = base_url() . "home/blogs/";

        $total_row = $this->testimonial->get_blog();



        $config["total_rows"] = $total_row;

        $config["per_page"] = 10;

        $config['use_page_numbers'] = TRUE;

        $config['num_links'] = $total_row;



        $config['cur_tag_open'] = '&nbsp;<a class="current">';

        $config['cur_tag_close'] = '</a>&nbsp;';

        $config['next_link'] = '&nbsp;<i class="last page-numbers fa fa-angle-double-right"></i>';

        $config['prev_link'] = '<i class="last page-numbers fa fa-angle-double-left"></i>&nbsp;';



        $this->pagination->initialize($config);

        if ($this->uri->segment(3)) {

            $page = ($this->uri->segment(3));
        } else {

            $page = 1;
        }

        $this->data['blog'] = $this->testimonial->blog_details($config["per_page"], $page);

        $str_links = $this->pagination->create_links();

        $this->data["links"] = explode('&nbsp;', $str_links);



        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header_t', $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', '_blogs', $this->data, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function single_blog() {



        $blog_id = $this->uri->segment(3);



        $this->data['single_post'] = $this->testimonial->get_single_post($blog_id);

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();

        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {

            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }

        $cid = array();

        foreach ($this->data['single_post'] as $category) {

            $cid[] = $category['category_id'];
        }



        $this->data['related_blog'] = $this->testimonial->get_relative_blog($cid[0]);

//        print_r( $this->data['related_blog']);
//        exit;

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['testi_monial'] = $this->testimonial->get_testimonial();



        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header_t', $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', '_blogs_single', $this->data, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function productFilter() {



        if ($_SERVER['REQUEST_METHOD'] == 'POST') {



//            echo '<pre>', print_r($_POST);die;

            $user_id = $this->session->userdata('user_id');





            $session_data = array(
                'product_year' => $this->input->post('product_year'),
                'product_model' => $this->input->post('product_model'),
                'product_category' => $this->input->post('product_category'),
            );

            if ($this->input->post('product_make'))
                $session_data['product_make'] = $this->input->post('product_make');
            else
                $session_data['product_make'] = $this->input->post('product_make_recent');



            $this->session->set_userdata('recent_product', $session_data);



            $make_id = $session_data['product_make'];

            $year_id = $this->input->post('product_year');

            $model_id = $this->input->post('product_model');



            $product_category_id = $this->input->post('product_category');

            $product_sub_category = $this->input->post('product_sub_category');

            if (strstr($product_category_id, '_')) {

                $id = explode('_', $product_category_id);

                $product_category_id = $id[0];

                $product_sub_category = $id[1];
            } else {

                $product_category_id = $product_category_id;

                $product_sub_category = null;
            }

//            echo $product_category_id;
//            echo $product_sub_category;die;
//            if(isset($product_sub_category))



            $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();

            foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {

                $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
            }

            if (isset($product_category_id) && $product_category_id != '') {



                $details = $this->product_category->get_category_name_by_id($product_category_id);

                $this->data['category_title'] = $details['name'];

                $this->data['category_description'] = $details['description'];

                if (isset($product_sub_category) && $product_sub_category != '') {

                    $details = $this->product_sub_category->get_sub_category_name_by_id($product_sub_category);

                    $this->data['category_title'] = $details['name'];
                }
            } else {

                $this->data['category_title'] = "Shop";

                $this->data['category_description'] = "It all begins right here at Tire Rack. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
            }



            $this->data['testi_monial'] = $this->testimonial->get_testimonial();





            $this->data['dataHeader'] = $this->users->get_allData($user_id);

            $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');

            $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');

            $this->data['product_year'] = array('' => 'Select Year') + $this->mst_year->dropdown('name');

            $this->data['product_model'] = array('' => 'Select Model') + $this->mst_model->dropdown('name');





            $this->data['product_details'] = $this->product->get_filter_product($make_id, $year_id, $model_id, $product_category_id, $product_sub_category);

            /* Product Filter category */

            foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {

                foreach ($categoryDp['sub_attibutes'] as $subAttr)
                    if ($subAttr['parent_id'] > 0) {

                        $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                    }
            }

            $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;

            /* Product Filter category */

//            echo '<pre>', print_r($this->data['product_details'] );die;

            $this->template->set_master_template('landing_template.php');

            $this->template->write_view('header', 'snippets/header', $this->data);

            $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

            $this->template->write_view('content', 'shop', NULL, TRUE);

            $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

            $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

            $this->template->write_view('footer', 'snippets/footer', '', TRUE);

            $this->template->render();
        } else {

            redirect('home');
        }
    }

    function clear_cart() {



// The 'empty_cart()' function allows an argument to be submitted that will also reset all shipping data if 'TRUE'.

        $this->flexi_cart->empty_cart(TRUE);



// Set a message to the CI flashdata so that it is available after the page redirect.

        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

        return true;



//        redirect('standard_library/view_cart');
    }

    function delete_item($row_id = FALSE) {

// The 'delete_items()' function can accept an array of row_ids to delete more than one row at a time.
// However, this example only uses the 1 row_id that was supplied via the url link.

        $this->flexi_cart->delete_items($row_id);



// Set a message to the CI flashdata so that it is available after the page redirect.

        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());



//        redirect('standard_library/view_cart');
    }

    function _get_all_data() {

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);



        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();

        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {

            $arr_product_sub_attributes = $this->product_sub_category->get_product_sub_attribute($pData['id']);

            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $arr_product_sub_attributes;

            if (count($arr_product_sub_attributes) > 0) {
                foreach ($arr_product_sub_attributes as $keyss => $sub_attributes_new) {
                    $attribute_name = $sub_attributes_new['attrubute_value'];
                    $arr_attribute_details = $this->common_model->getRecords('p_attributes', 'attrubute_value,id', array("attrubute_value" => $attribute_name));
                    if (count($arr_attribute_details) > 0) {
                        $arr_sub_attribute_details = $this->common_model->getRecords('mst_sub_attributes', '*', array("attribute_id" => $arr_attribute_details[0]['id']), 'id DESC');
                        //echo '<pre>';print_r($arr_sub_attribute_details);die;
                        $this->data['prodcut_cat_detail'][$k]['sub_attibutes'][$keyss]['third_level_sub_attributes'] = $arr_sub_attribute_details;
                    }
                }
            }
        }

        $this->data['slider'] = $this->slider_home->get_slider();

        $this->data['product_feature_details'] = $this->product->get_feature_product();

        //echo '<pre>';print_R($this->data['prodcut_cat_detail']);die;

        /**/

        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');





        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {

            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {

                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                }
        }



//        $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;



        $this->data['product_details'] = $this->product->as_array()->get_all();

        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);



        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);


//        $this->data['product_details_instagram'] = $this->product->get_product_by_category_id(null,null,null,null,1);
//        
//        foreach ($this->data['product_details_instagram'] as $key => $value)
//            $this->data['product_details_instagram'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
//
//
//
//        foreach ($this->data['product_details_instagram'] as $key => $value)
//            $this->data['product_details_instagram'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);
//       
        $this->data['product_details_instagram'] = $this->common_model->getRecords('it_products', 'sheeping_fees,instagram_image,id,product_name,discounted_price,price,description', array("is_instagram_product" => '1', 'id DESC'));
        //echo '<pre>';print_r($this->data['product_details_instagram']);die;

       



        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];



//        $this->data['product_offer_details'] = $this->product->get_offer_product();

        return $this->data;
    }

    public function add_wishlist($method = null) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == 'add') {



            $id = $this->input->post('product_id');

            $user_id = $this->input->post('user_id');



            $check = $this->wishlist_model->check_review_product($id, $user_id);
            //echo '<pre>';print_R($check);die;
            if ($check == TRUE) {

                echo json_encode(array('status' => '400'));
            } else if ($check == FALSE) {

                $arr = Array(
                    'product_id' => $this->input->post('product_id'),
                    'user_id' => $this->input->post('user_id')
                );

                $this->wishlist_model->insert($arr);



                echo json_encode(array('status' => '200'));
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == 'delete') {

            $id = $this->input->post('wishlist_id');

            if ($this->wishlist_model->delete_re($id)) {

                echo json_encode(true);
            }
        }
    }

    function clear_cart_all() {

        $this->flexi_cart->empty_cart(TRUE);

        $user_id = $this->session->userdata('user_id');
        $this->db->where('user_id', $user_id);
        $this->db->delete('users_cart_items');
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

        redirect('/home/cart');

        return true;
    }

    public function payment() {

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $sql_select = array($this->flexi_cart->db_column('locations', 'id'), $this->flexi_cart->db_column('locations', 'name'));

        $this->data['countries'] = $this->flexi_cart->get_shipping_location_array($sql_select, 0);

        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

//        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'stripe_form', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

//        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    function update_cart() {



        $this->data['cart_items'] = $this->flexi_cart->cart_items();





// Load custom demo function to retrieve data from the submitted POST data and update the cart.

        $this->demo_cart_model->demo_update_cart();



// If the cart update was posted by an ajax request, do not perform a redirect.

        if (!$this->input->is_ajax_request()) {



// Set a message to the CI flashdata so that it is available after the page redirect.

            $this->session->set_flashdata('message', $this->flexi_cart->get_messages());



            redirect('home/cart');
        }
    }

    public function buy() {

        $productname = '';

        $tax_total = $_SESSION['custom_option']['tax_total'];
        $shipping_total = $_SESSION['custom_option']['shipping_total'];
        $total_amount = ($this->data['cart_summary']['item_summary_total'] - $this->session->userdata('coupon_code_price')) + $tax_total + $shipping_total;

        $user_id = $this->session->userdata('user_id');

        $returnURL = base_url() . 'home/success'; //payment success url

        $cancelURL = base_url() . 'home/cancel'; //payment cancel url

        $notifyURL = base_url() . 'paypal/ipn'; //ipn url



        $logo = base_url() . 'assets/images/codexworld-logo.png';



        $this->paypal_lib->add_field('return', $returnURL);

        $this->paypal_lib->add_field('cancel_return', $cancelURL);

        $this->paypal_lib->add_field('notify_url', $notifyURL);

        $this->paypal_lib->add_field('custom', $user_id);



        foreach ($this->data['cart_items'] as $key => $cartData) {

            $productname .= $cartData['name'] . ',';
        }

        $this->paypal_lib->add_field('item_number', $this->data['cart_summary']['total_items']);

        $this->paypal_lib->add_field('item_name', $productname);

        //$this->paypal_lib->add_field('amount', $this->data['cart_summary']['item_summary_total']);
        $this->paypal_lib->add_field('amount', $total_amount);

        $this->paypal_lib->image($logo);



        $this->paypal_lib->paypal_auto_form();
    }

    public function success() {
        $user_id = $this->session->userdata('user_id');
        //echo '<pre>', print_r($_POST);die;

        $dataPayment = array(
            'user_id' => $user_id,
            'txn_id' => $this->input->post('txn_id'),
            'payment_gross' => $this->input->post('payment_gross'),
            'currency_code' => $this->input->post('mc_currency'),
            'payer_email' => $this->input->post('payer_email'),
            'payment_status' => $this->input->post('payment_status'),
        );

        foreach ($this->data['cart_items'] as $key => $cartData) {
            $dataPayment['row_id'] = $cartData['row_id'];

            $dataPayment['product_id'] = $cartData['id'];

//            $dataPayment['payment_gross'] = $cartData['internal_price'];

            $dataPayment['payment_via'] = 'paypal';
            $this->payment->insert($dataPayment);
        }

        $order_no = $this->flexi_cart->order_number();

        /* Email to admin for order confirmatin */
        $edata['item_data'] = $this->common_model->getRecords('order_details', '*', array('ord_det_order_number_fk' => $order_no));
        $edata['summary_data'] = $this->common_model->getRecords('order_summary', '*', array('ord_order_number' => $order_no));

        $edata['order_no'] = $order_no;
        $html = $this->load->view('email_templates/order_confirmation_admin', $edata, true);
        $html1 = $this->load->view('email_templates/order_confirmation_admin', $edata, true);
        $mail = $this->common_model->sendEmail(config_item('admin_email'), array("email" => config_item('site_email'), "name" => 'Vaskia'), 'New order placed', $html);
        $mail1 = $this->common_model->sendEmail($edata['summary_data'][0]['ord_demo_email'], array("email" => config_item('site_email'), "name" => 'Vaskia'), 'Order Confirmed', $html1);


        /* Update coupon applied code status and amount start here   */
        $coupon_code_price = $this->session->userdata('coupon_code_price');
        $coupon_name = $this->session->userdata('coupon_name');
        $arr_coupon_details = $this->common_model->getRecords('discounts', 'disc_code,disc_id', array("disc_code" => $coupon_name));
        if ($coupon_code_price > 0 && $user_id != '' && $coupon_name != '' && count($arr_coupon_details) > 0) {

            $arr_to_insert = array(
                "coupon_name" => $coupon_name,
                "disc_id_fk" => $arr_coupon_details[0]['disc_id'],
                "user_id_fk" => $user_id,
                "coupon_amount" => $coupon_code_price,
                "created" => date("Y-m-d H:i:s"),
            );
            //echo '<pre>';print_r($arr_to_insert);die;
            $last_coupon_applied_id = $this->common_model->insertRow($arr_to_insert, "coupon_applied_details");
        }

        $coupon_code_use_limit = $this->session->userdata('coupon_code_use_limit');
        $coupon_code_use_limit_name = $this->session->userdata('coupon_code_use_limit_name');
        $coupon_name = $this->session->userdata('coupon_name');
        if ($coupon_name != '') {
            $arr_coupon_details_use_limit = $this->common_model->getRecords('discounts', 'disc_code,disc_id,disc_usage_limit', array("disc_code" => $coupon_name));
            if (count($arr_coupon_details_use_limit) > 0) {
                $limit = $arr_coupon_details_use_limit[0]['disc_usage_limit'] - 1;
                $update_data = array(
                    "disc_usage_limit" => $limit,
                );

                $condition_to_pass = array("disc_code" => $coupon_name);
                //echo '<pre>';print_r($condition_to_pass);die;
                $last_update_id = $this->common_model->updateRow('discounts', $update_data, $condition_to_pass);
            }
        }
        $this->session->unset_userdata('coupon_code_use_limit');
        $this->session->unset_userdata('coupon_code_use_limit_name');



        $this->session->unset_userdata('coupon_code_price');
        $this->session->unset_userdata('coupon_name');
        $this->session->unset_userdata('coupons_use_limit');

        $this->flexi_cart->unset_discount();
        /* Update coupon applied code status and amount end here   */

        $this->clear_cart();
        $dataPayment['order_no'] = $this->flexi_cart->order_number();


        redirect('home/checkout/success');

//        echo json_encode(array('content' => $_POST));
//        die;
    }

    public function cancel() {

        redirect('home/checkout/cancel');
    }

    function stripePaySubmit() {

        $discounts = $this->flexi_cart->summary_discount_data();
        $tax_total = $_SESSION['custom_option']['tax_total'];
        $shipping_total = $_SESSION['custom_option']['shipping_total'];

        if (!empty($discounts['total']['value'])) {

            $total = ($this->data['cart_summary']['item_summary_total'] + $shipping_total + $tax_total) - str_replace('US $', ' ', $discounts['total']['value']);
        } else {

            $total = $this->data['cart_summary']['item_summary_total'] + $shipping_total + $tax_total;
        }
        $total_new = round($total);
        //echo $total_new;die;
        try {
            Stripe::setApiKey('sk_test_TSinCwEc7vZNsRCqozPQ5DmE');

            $charge = Stripe_Charge::create(array(
                        "amount" => $total_new * 100,
                        "currency" => "USD",
                        "card" => $this->input->post('access_token'),
                        "description" => "Stripe Payment"
            ));




// this line will be reached if no error was thrown above

            $user_id = $this->session->userdata('user_id');



            $dataPayment = array(
                'user_id' => $user_id,
                'txn_id' => $charge->id,
                'payment_gross' => $charge->amount / 100,
                'currency_code' => $charge->currency,
                'payment_status' => 'Completed',
            );

            $dataPayment['order_no'] = $this->flexi_cart->order_number();
            $order_no = $this->flexi_cart->order_number();

            $this->payment->insert($dataPayment);
            /* Email to admin for order confirmatin */
            $edata['item_data'] = $this->common_model->getRecords('order_details', '*', array('ord_det_order_number_fk' => $order_no));
            $edata['summary_data'] = $this->common_model->getRecords('order_summary', '*', array('ord_order_number' => $order_no));

            $edata['order_no'] = $order_no;
            $html = $this->load->view('email_templates/order_confirmation_admin', $edata, true);
            $html1 = $this->load->view('email_templates/order_confirmation_customer', $edata, true);
            $mail = $this->common_model->sendEmail(config_item('admin_email'), array("email" => config_item('site_email'), "name" => 'Vaskia'), 'New order placed', $html);
            $mail1 = $this->common_model->sendEmail($edata['summary_data'][0]['ord_demo_email'], array("email" => config_item('site_email'), "name" => 'Vaskia'), 'Order confirmed', $html1);

            /* */
            $this->flexi_cart->destroy_cart();

//            }
//$this->clear_cart();
//$response = $this->payment->insert($data);

            if ($dataPayment) {
                /* Update coupon applied code status and amount start here   */
                $coupon_code_price = $this->session->userdata('coupon_code_price');
                $coupon_name = $this->session->userdata('coupon_name');
                $arr_coupon_details = $this->common_model->getRecords('discounts', 'disc_code,disc_id', array("disc_code" => $coupon_name));
                if ($coupon_code_price > 0 && $user_id != '' && $coupon_name != '' && count($arr_coupon_details) > 0) {

                    $arr_to_insert = array(
                        "coupon_name" => $coupon_name,
                        "disc_id_fk" => $arr_coupon_details[0]['disc_id'],
                        "user_id_fk" => $user_id,
                        "coupon_amount" => $coupon_code_price,
                        "created" => date("Y-m-d H:i:s"),
                    );
                    //echo '<pre>';print_r($arr_to_insert);die;
                    $last_coupon_applied_id = $this->common_model->insertRow($arr_to_insert, "coupon_applied_details");
                }
                $coupon_name = $this->session->userdata('coupon_name');
                $coupon_code_use_limit_name = $this->session->userdata('coupon_code_use_limit_name');
                if ($coupon_name != '') {
                    $arr_coupon_details_use_limit = $this->common_model->getRecords('discounts', 'disc_code,disc_id,disc_usage_limit', array("disc_code" => $coupon_name));
                    if (count($arr_coupon_details_use_limit) > 0) {
                        $limit = $arr_coupon_details_use_limit[0]['disc_usage_limit'] - 1;
                        $update_data = array(
                            "disc_usage_limit" => $limit,
                        );

                        $condition_to_pass = array("disc_code" => $coupon_name);
                        //echo '<pre>';print_r($condition_to_pass);die;
                        $last_update_id = $this->common_model->updateRow('discounts', $update_data, $condition_to_pass);
                    }
                }
                $this->session->unset_userdata('coupon_code_use_limit');
                $this->session->unset_userdata('coupon_code_use_limit_name');

                $this->session->unset_userdata('coupon_code_price');
                $this->session->unset_userdata('coupon_name');
                $this->session->unset_userdata('coupons_use_limit');
                $this->flexi_cart->unset_discount();
                /* Update coupon applied code status and amount end here   */




                echo json_encode(array('status' => 200, 'success' => 'Payment successfully completed.'));

                exit();
            } else {

                echo json_encode(array('status' => 500, 'error' => 'Something went wrong. Try after some time.'));

                exit();
            }
        } catch (Stripe_CardError $e) {

            echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));

            exit();
        } catch (Stripe_InvalidRequestError $e) {

// Invalid parameters were supplied to Stripe's API

            echo json_encode(array('status' => 500, 'error' => $e->getMessage()));

            exit();
        } catch (Stripe_AuthenticationError $e) {

// Authentication with Stripe's API failed

            echo json_encode(array('status' => 500, 'error' => AUTHENTICATION_STRIPE_FAILED));

            exit();
        } catch (Stripe_ApiConnectionError $e) {

// Network communication with Stripe failed

            echo json_encode(array('status' => 500, 'error' => NETWORK_STRIPE_FAILED));

            exit();
        } catch (Stripe_Error $e) {

// Display a very generic error to the user, and maybe send

            echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));

            exit();
        } catch (Exception $e) {

// Something else happened, completely unrelated to Stripe

            echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));

            exit();
        }
    }

    public function orders() {



        if (!$this->ion_auth->logged_in()) {

// redirect them to the login page

            redirect('auth/login', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['cart_items'] = $this->flexi_cart->cart_items();



        $this->data['country_list'] = (array('' => 'Select Country')) + $this->country->dropdown('countryname');

        $this->data['state_list'] = (array('' => 'Select State')) + $this->state->dropdown('statename');

        $this->data['my_orders'] = $this->orders_summary->get_by_id($user_id);



//        echo '<pre>', print_r($this->data['my_orders']);die;

        $this->data = $this->_get_all_data();

        $this->data['pages'] = $this->pages_model->as_array()->get_all();



        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'orders', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function wishlist() {



        if (!$this->ion_auth->logged_in()) {

// redirect them to the login page

            redirect('auth/login', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);



        $list = $this->wishlist_model->get_list($user_id);

        $this->data['product_details'] = $list;

        $id = null;

        foreach ($list as $key => $pid) {

            $this->data['product_details'][$key]['product_name'] = $this->product->as_array()->get($pid['product_id']);

            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($pid['product_id']);

            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($pid['product_id']);
        }



        $this->data['product_details_tes'] = $this->data['product_details'];

        $this->data['pages'] = $this->pages_model->as_array()->get_all();



        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', '_wish_list', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function getProducts() {

        $product_details = $this->product->get_products_by_limit($this->input->post('cat_id'), '4');

        if (!empty($product_details)) {

            $out = '';

            $out1 = '';

            foreach ($product_details as $key => $value) {

                $product_images_details = $this->product_images->as_array()->get_by_id($value['id']);



                $out .= '<li class="product-item style3 mobile-slide-item col-sm-4 col-md-3">

                    <div class="product-inner">

                        <div class="product-thumb has-back-image">

                            <a href="' . base_url() . 'home/shop_product/' . $value['id'] . '/' . $value['category_id'] . '"><img src="' . base_url($product_images_details[0]['url']) . '" alt=""></a>

                            <a class="back-image" href="' . base_url() . 'home/shop_product/' . $value['id'] . '/' . $value['category_id'] . '"><img src="' . base_url($product_images_details[0]['hover_img_url']) . '" alt=""></a>



                            <div class="col-md-8">

                                <div class="product-info">

                                    <div class="">

                                        <h2 class="product-name"><a href="' . base_url() . 'home/shop_product/' . $value['id'] . '/' . $value['category_id'] . '">' . $value['product_name'] . '</a></h2>

                                    </div>

                                </div>

                            </div>





                            <div class="col-md-4">

                                <div class="clearfix"></div>

                                <div class="pricing_grid">

                                    <h5 class="item-price">$' . $value['price'] . '</h5>

                                </div>

                            </div>

                        </div>



                    </div>

                </li>';
            }
        } else {

            echo "<h4>No products fround in the category</h4>";
        }

        $out1 = '<div style="text-align: center;"><a class="button-loadmore loadmore" id="loadmore"  data-service="' . $this->input->post('cat_id') . '" data-page="' . ($this->input->post('page') + 1 ) . '">Load more</a></div>';

        echo json_encode(array('out' => $out, "out1" => $out1));
    }

    public function loadMoreProducts() {

        if (isset($_POST['page'])):

// print_r($_POST);

            $paged = $_POST['page'];
            $total_page = $_POST['total_page'];
            $resultsPerPage = 4;

            if ($_POST['cat_id'] == 'all') {

                $sql = "SELECT * FROM it_products where isactive='0' ORDER BY `id` DESC";
            } else if ($_POST['cat_id'] != '' && $_POST['sub_cat_id'] != '' && $_POST['subcatThird'] != '') {
                $category_id = $_POST['cat_id'];
                $sub_category_id = $_POST['sub_cat_id'];
                $third_sub_category = $_POST['subcatThird'];

                $sql = "SELECT * FROM it_products as ip left JOIN  it_product_attributes   ipa  ON  ipa.product_id  = ip.id  where isactive='0' and FIND_IN_SET('$category_id',ip.category_id) AND FIND_IN_SET('$sub_category_id',ip.sub_category_id) and FIND_IN_SET('$third_sub_category',ip.sub_attribute_id_new)   group by ip.id  ORDER BY ip.id DESC ";
            } else if ($_POST['cat_id'] != '' && $_POST['sub_cat_id'] != '') {
                $category_id = $_POST['cat_id'];
                $sub_category_id = $_POST['sub_cat_id'];
                $sql = "SELECT * FROM it_products as ip left JOIN  it_product_attributes   ipa  ON  ipa.product_id  = ip.id  where isactive='0'  and FIND_IN_SET('$category_id',ip.category_id) AND FIND_IN_SET('$sub_category_id',ip.sub_category_id)  group by ip.id  ORDER BY ip.id DESC ";
            } else {
                $category_id = $_POST['cat_id'];
                $sql = "SELECT * FROM it_products as ip left JOIN  it_product_attributes   ipa  ON  ipa.product_id  = ip.id  where isactive='0' and FIND_IN_SET('$category_id',ip.category_id) group by ip.id  ORDER BY ip.id DESC ";
            }

            //echo $sql;die;
            //if ($paged > 0) {
            //$page_limit = $resultsPerPage * ($paged);
            $page_limit = $_POST['page_limit'];

            $pagination_sql = " LIMIT  $page_limit,$total_page";

            $pagination_sql = " LIMIT  $page_limit,$total_page";

            $new_limit = $total_page + $page_limit;
            $page_limit_new = $page_limit + $page_limit;
            $pagination_sql_new = " LIMIT  $page_limit_new,$new_limit";

            $query = $this->db->query($sql . $pagination_sql);
            $query2 = $this->db->query($sql . $pagination_sql_new);
            $total_available = $query2->num_rows();
            if ($query->num_rows() > 0) {
                //echo '<pre>';print_R($query->result_array());die;
                foreach ($query->result_array() as $value) {

                    $product_images_details = $this->product_images->as_array()->get_by_id($value['id']);
                    ?>

                    <li class="product-item style3 mobile-slide-item col-sm-4 col-md-3">

                        <div class="product-inner">

                            <div class="product-thumb has-back-image">

                                <a href="<?php echo base_url() ?>home/shop_product/<?php echo $value['id'] ?>/<?php echo $value['category_id'] ?>"><img src="<?php echo base_url($product_images_details[0]['url']) ?>" alt=""></a>

                                <a class="back-image" href="<?php echo base_url() ?>home/shop_product/<?php echo $value['id'] ?>/<?php echo base64_encode($value['category_id']); ?>"><img src="<?php echo base_url($product_images_details[0]['hover_img_url']) ?>" alt=""></a>



                                <div class="col-md-8">

                                    <div class="product-info">

                                        <div class="">

                                            <h2 class="product-name"><a href="<?php echo base_url() ?>home/shop_product/<?php echo $value['id'] ?>/<?php echo base64_encode($value['category_id']); ?>"><?php echo $value['product_name'] ?></a></h2>

                                        </div>

                                    </div>

                                </div>





                                <div class="col-md-4">

                                    <div class="clearfix"></div>

                                    <div class="pricing_grid">

                                        <h5 class="item-price">$<?php echo $value['price'] ?></h5>

                                    </div>

                                </div>

                            </div>



                        </div>

                    </li>



                    <?php
                }
            }

            if ($total_available > 0) {
                ?>


                <div style="text-align: center;"><a class="button-loadmore loadmore" id="loadmore"  data-service="<?php echo $_POST['cat_id'] ?>" data-page="<?php echo $paged + 1; ?>">Load more</a></div>

                <?php
            } else {

                echo "<div style='clear:both;margin:20px'></div> <div  class='loadbutton'><h3 style='text-align: center;margin-top: 40px;'>No More Products</h3></li>";
            }

        endif;
    }

    public function shareWishList() {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="label-error">', '</span>');


        $this->form_validation->set_rules('email[]', 'Email', 'trim|required|valid_email');
        if ($this->form_validation->run() == TRUE) {
            foreach ($this->input->post('email') as $key => $email) {
                $user['email'] = $email;
                $user['user_id'] = $user_id;
                $user['created_time'] = date("Y-m-d H:i:s");

                $this->common_model->insertRow($user, 'tbl_share_wishlist');

                $link = base_url() . "home/refWishList/" . $user_id;
                $msg = "Dear Customer, <br> " . $this->data['dataHeader']['first_name'] . " " . $this->data['dataHeader']['last_name'] . " has shared his wishlist with you. Click on below link to shop with us.<br><br>" . $link . "<br><br>Thanks Team,<br>Vaskia";
                $mail = $this->common_model->sendEmail($email, array("email" => config_item('site_email'), "name" => 'Vaskia'), $this->data['dataHeader']['first_name'] . " " . $this->data['dataHeader']['last_name'] . ' has shared his wishlist with you', $msg);
            }
            $response['status'] = '1';
            $response['msg'] = 'Record saved successfully';
            echo json_encode($response);
        } else {
            $errors = array();
            // Loop through $_POST and get the keys
            foreach ($this->input->post('email') as $key => $value) {
                // Add the error message for this field
                $errors[$key] = form_error($key);
            }
            $response['errors'] = array_filter($errors); // Some might be empty
            $response['status'] = '0';
            echo json_encode($response);
        }
    }

    public function refWishList($id) {
        $products = $this->common_model->getRecords('product_wish_list', '*', array('user_id' => $id));
        $this->load->model('demo_cart_model');

        foreach ($products as $product) {
            $product_detail = end($this->common_model->getRecords('it_products', '*', array('id' => $product['product_id'])));
            if (isset($_SESSION['flexi_cart']))
                $this->data = $_SESSION['flexi_cart'];


            $this->load->library('flexi_cart');


            ###+++++++++++++++++++++++++++++++++###

            $cart_data = array(
                'id' => $product_detail['id'],
                'name' => $product_detail['product_name'],
                'quantity' => 1,
                'stock_quantity' => $product_detail['quantity'],
                'price' => $product_detail['price'],
                'item_url' => $product_detail['url']);

            // Insert collected data to cart.
            if ($cart_data) {
                $this->flexi_cart->insert_items($cart_data);
            }
        }
        redirect(base_url() . 'home/cart');
    }

    public function instagramImage() {
        $image = trim($this->input->post('image'));
        $arr_image = explode('//', $image);
        $arr_products = $this->common_model->getRecords('it_products', 'id', array('is_instagram_product' => '1', 'instagram_image' => $arr_image[1]));
        if ($image != '' && count($arr_products) > 0) {

            $user_id = $this->session->userdata('user_id');
            $produictId = $arr_products[0]['id'];
//        $review = $this->review_model->get_review($user_id, $produictId);
//        $all_review = $this->review_model->get_all_reiview_products($produictId);
//        $average_rating = null;
//        foreach ($all_review as $rData) {
//            $average_rating += $rData['review_total'];
//        }
////        echo $average_rating;
//        $cnt = count($all_review);
//        if ($cnt != 0) {
//            $average_rating = $average_rating / ($cnt * 5) * 5;
//            $average_rating = $average_rating;
//        } else {
//            $average_rating = 0;
//        }
            $check = $this->review_model->check_review_product($produictId, $user_id);
            $product_details = $this->product->get_product_by_product_id($produictId);
            ?>
            <form class="cart" id='cart_instagram' name='cart_instagram' enctype="multipart/form-data" method="post">

                <input type="hidden" id="user_id_insta" name="user_id_insta" value="<?php echo $user_id = $this->session->userdata('user_id'); ?>"/>

                <input type="hidden" id="item_id_insta_<?php echo $product_details[0]['id'] ?>" name="item_id_insta" value="<?php echo $product_details[0]['id'] ?>"/>

                <input type="hidden" id="name_insta_<?php echo $product_details[0]['id'] ?>" name="name_insta" value="<?php echo $product_details[0]['product_name'] ?>"/>

                <?php if (isset($product_details[0]['discounted_price']) && !empty($product_details[0]['discounted_price'])) { ?>

                    <input type="hidden" id="price_insta_<?php echo $product_details[0]['id'] ?>" name="price_insta" value="<?php echo floatval($product_details[0]['price']) - floatval($product_details[0]['discounted_price']) ?>"/>    



                <?php } else { ?>

                    <input type="hidden" id="price_insta_<?php echo $product_details[0]['id'] ?>" name="price_insta" value="<?php echo $product_details[0]['price'] ?>"/>

                <?php } ?>

                <input type="hidden" id="img_url_insta_<?php echo $product_details[0]['id'] ?>" name="img_url_insta" value="<?php echo $product_details[0]['url'] ?>"/>

                <input type="hidden" id="stock_insta_<?php echo $product_details[0]['id'] ?>" name="stock_insta" value="<?php echo $product_details[0]['quantity'] ?>"/>





                <div class="col-md-6 product_img">
                    <img src="<?php echo $image; ?>" class="img-responsive">
                </div>
                <div class="col-md-6 product_content">
                    <h4>Product Name: <span><?php echo $product_details[0]['product_name']; ?></span></h4>
                    <div class="rating">

                                                                                                            <!--                        <p class="meta-info clearfix">
                                                                                                                                    <span class="kopa-rating">
                        <?php for ($i = 0; $i < 5; $i++) { ?>
                            <?php if ($i < $average_rating) { ?>
                                                                                                                                                                                                                        <span class="fa fa-star"></span>                                   
                            <?php } else { ?>
                                                                                                                                                                                                                        <span class="fa fa-star-o"></span>
                            <?php } ?>
                        <?php } ?>


                                                                                                                                    </span>
                                                                                                                                    <span class="review"><?php echo count($all_review) ?> Review</span>
                        <?php if ($this->ion_auth->logged_in()) { ?>
                            <?php
                            echo $check;
                            if (isset($check))
                                
                                ?> 
                            <?php
                            if ($check == true) {
                                $user_id = $this->session->userdata('user_id');
                                foreach ($product_details as $d) {
                                    ?> 
                                                                                                                                                                                                                                                            <a href="#" class="add-review" onclick="editReviewInsta(<?php echo $d['id']; ?>,<?php echo $user_id; ?>)" data-toggle="modal" data-target="#reviewModalInsta">Edit Review</a>
                                    <?php
                                }
                            }
                            ?> 
                            <?php if ($check == false) { ?> 

                                                                                                                                                                                                                        <a href="#" class="add-review" data-toggle="modal" data-target="#reviewModalInsta"> <label id="add_your_review">Add your review </label></a>
                            <?php } ?> 
                        <?php } ?>
                                                                                                                                </p>
                        -->
                    </div>
                    <p><?php echo $product_details[0]['description']; ?></p>

                    <h3 class="cost"><span class="glyphicon glyphicon-usd"></span> <?php echo $product_details[0]['price']; ?> <small class="pre-cost"><span class="glyphicon glyphicon-usd"></span> <?php echo $product_details[0]['price']; ?></small></h3>

                    <div class="quantity" style='margin-bottom: 5px;'>
                        <span>Quantity</span>
                        <input type="number" size="4" class="input-text qty text" width="50" title="Qty" value="1" id="quantity_insta_<?php echo $product_details[0]['id'] ?>" name="quantity_insta" min="1" step="1">
                    </div>

                    <div class="space-ten"></div>
                    <div class="btn-ground">
                        <button type="button" class="my-theme-btn cart-dis-insta" onclick="funAddToCartInsta(<?php echo $product_details[0]['id'] ?>)"><span class="glyphicon glyphicon-shopping-cart"></span> Add To Cart</button>
                        <?php if ($user_id != '') { ?>
                            <button type="button" class="my-theme-btn cart-wish-insta" onclick="funAddTwishlistInsta(<?php echo $product_details[0]['id'] ?>)"><span class="glyphicon glyphicon-heart"></span> Add To Wishlist</button>
                        <?php } else { ?>
                            <button type="button" class="my-theme-btn cart-wish-insta" onclick="funAddTwishlist_login_insta(<?php echo $product_details[0]['id'] ?>)"><span class="glyphicon glyphicon-heart"></span> Add To Wishlist</button>
                        <?php } ?>
                    </div>
                </div>
            </form>
            +++
            <?php echo $produictId; ?>
            <?php
        }
    }

    public function vaskiaClover() {

        $url = 'https://apisandbox.dev.clover.com/v3/merchants/C2GX08K9T3BF0/orders';

        $arr_curlPost = array("note" => 'first product', "state" => "open");


        $curlPost = json_encode($arr_curlPost);
        $curkPost = '{
                     "note" : "first product",
                     "state" : "open",
                     "price" : "200",
                    "item": {
                      "id": "123456"
                    }
                  }';

        $access_token = 'f5dc0484-f50f-688f-dc38-5933f8de0a3f';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr_curlPost);
        $data = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        echo '<pre>';
        print_R($data);


        $url_clover = 'https://apisandbox.dev.clover.com/v3/merchants/C2GX08K9T3BF0/items?access_token=f5dc0484-f50f-688f-dc38-5933f8de0a3f';
        $access_token = 'f5dc0484-f50f-688f-dc38-5933f8de0a3f';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_clover);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $datass = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo '<pre>';
        print_r($datass);


        $url_clover = 'https://apisandbox.dev.clover.com/v3/merchants/C2GX08K9T3BF0/orders/SR1RPN0RZ1W0R/payments';
        $access_token = 'f5dc0484-f50f-688f-dc38-5933f8de0a3f';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_clover);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $arr_orders = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo '<pre>';
        print_r($arr_orders);




        $url_clover = 'https://apisandbox.dev.clover.com/v3/merchants/C2GX08K9T3BF0/authorizations';
        $access_token = 'f5dc0484-f50f-688f-dc38-5933f8de0a3f';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_clover);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $arr_authoriazation = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo '<pre>';
        print_r($arr_authoriazation);





        $url = 'https://apisandbox.dev.clover.com/v3/merchants/C2GX08K9T3BF0/orders/SR1RPN0RZ1W0R/payments';
        $curlPost = array(
            "amount" => 20000,
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }

    public function newsletterUnsuscriber($unsubscribe_code = '') {
        //$this->load->model('subscriber_model');
        $data['user_session'] = $this->session->userdata('user_account');
        /* checking user has privilige for the Manage Admin */
//        $data['global'] = $this->common_model->getGlobalSettings();

        $user_email = $this->input->post('user_email');
        $table_to_pass = TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION;
        $fields_to_pass = array('*');
        $condition_to_pass = array("user_subscription_code" => $unsubscribe_code);
        $data['newsletetter_info'] = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        // print_r($data['newsletetter_info']);die;
        if (count($data['newsletetter_info']) > 0) {
            //die("sdf");
            $newsletter_code = $data['newsletetter_info'][0]['user_subscription_code'];
            $this->common_model->updateRow(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION, array('subscribe_status' => 'Active'), array('user_email' => $data['newsletetter_info'][0]['user_email']));
            //$this->newslettersubscribed($newsletter_code);

            if ($data['newsletetter_info'][0]['subscribe_status'] == "Inactive") {
                $this->session->set_userdata('contact_fail', 'You have already unsubscribed from our newsletter.');
                $msg = 'You have already unsubscribed from our newsletter.';
            } else {
                $msg = 'You have successfully subscribed to our newsletter.';
            }

            $update_data = array('subscribe_status' => 'Inactive',
            );
            $this->common_model->updateRow(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION, $update_data, array("user_subscription_code" => $unsubscribe_code));

            echo $msg;
            redirect(base_url() . "#footernews");
        } else {
            /* insert subscriber user details */
            $user_subscription_code = rand(9999, 1000000000);
            $arr_fields = array(
                "user_email" => $this->input->post('user_email'),
                "subscribe_status" => 'Active',
                "user_subscription_code" => $user_subscription_code,
                "is_subscribe_for_daily" => '0',
            );

            $last_insert_id = $this->subscriber_model->insertNewsletterSubscriber($arr_fields);
            if ($this->input->post('user_email') != '') {

                /* Activation link  */
                $activation_link = '<a href="' . base_url() . 'home/newsletterUnsuscriber/' . $user_subscription_code . '">Unsubscribe</a>';
                /* setting reserved_words for email content */
                $macros_array_details = array();
                $macros_array_details = $this->common_model->getRecords(TABLES::$EMAIL_TEMPLATE_MACROS, $fields_to_pass = 'macros,value', $condition_to_pass = '', $order_by = '', $limit = '', $debug = 0);
                $macros_array = array();
                foreach ($macros_array_details as $row) {
                    $macros_array[$row['macros']] = $row['value'];
                }
                $reserved_words = array(
                    "||SITE_TITLE||" => config_item('website_name'),
                    "||SITE_PATH||" => base_url(),
                    "||USER_NAME||" => $this->input->post('user_email'),
                    "||UNSUBSCRIBE_LINK||" => $activation_link,
                    "||SITE_URL||" => '<a href="' . base_url() . '">' . base_url() . '</a>'
                );

                $reserved = array_replace_recursive($macros_array, $reserved_words);

                /* getting mail subect and mail message using email template title and lang_id and reserved works */
                $email_content = $this->common_model->getEmailTemplateInfo('newsletter-subscription', $reserved);

                $mail = $this->common_model->sendEmail(array($this->input->post('user_email')), array("email" => 'webmaster@rebelutedigital.com', "name" => config_item('website_name')), $email_content['subject'], htmlspecialchars_decode($email_content['content']));

                $this->session->set_flashdata("msg", "You have successfully subscribed to our newsletter.");
                redirect(base_url() . "#footernews");
            }
        }
    }

    function checkProductQuantityAvailable() {
        $product_id = $this->input->post('id');
        $total_quantity = $this->input->post('total_quantity');
        if ($product_id != '' && $total_quantity > 0) {
            $product_details = $this->common_model->getRecords('it_products', 'id,quantity', array("id" => $product_id), 'id DESC');
            //echo '<pre>';print_r($product_details);die;
            if (count($product_details) > 0 && $product_details[0]['quantity'] >= $total_quantity) {
                echo json_encode(array('status' => '1', 'msg' => ''));
            } else {
                echo json_encode(array('status' => '0', 'msg' => ''));
            }
        } else {
            echo json_encode(array('status' => '2', 'msg' => 'Product is not available.'));
        }
    }

    public function sendUsernamePassword() {
        $email = trim($this->input->post('username'));
        if ($email != '') {
            $arr_user_details = $this->common_model->getRecords('users', 'first_name,last_name,username,id,email,password', array("email" => $email));
            ;
            //echo '<pre>';print_r($arr_user_details);die;
            if (count($arr_user_details) > 0) {
                $base_url = base_url();
                $password_new = rand();
                $password = $this->ion_auth->hash_password($password_new);
                $name = $arr_user_details[0]['first_name'] . ' ' . $arr_user_details[0]['last_name'];
                $subject2 = "Username And Password";
                $message2 = "Dear $name. <br/><br/>";
                $message2 .= "Your login details are given below:<br/><br/>";
                $message2 .= "Username:  $email <br/><br/>";
                $message2 .= "Password:  $password_new <br/><br/>";
                $message2 .= "Site Url:  $base_url <br/>";
                $mail = $this->common_model->sendEmail(array($email), array("email" => 'webmaster@rebelutedigital.com', "name" => config_item('website_name')), $subject2, $message2);

                $update_data = array(
                    "password" => $password,
                );
                $condition_to_pass = array("email" => $email);
                $last_update_id = $this->common_model->updateRow('users', $update_data, $condition_to_pass);


                echo json_encode(array('status' => '1', 'msg' => 'Username and password successfully sent on your email id so please check it,Thank you.'));
            } else {
                echo json_encode(array('status' => '2', 'msg' => 'Incorrect email address please check once again,Thank you.'));
            }
        } else {
            echo json_encode(array('status' => '0', 'msg' => 'Please enter name and email'));
        }
    }

}
