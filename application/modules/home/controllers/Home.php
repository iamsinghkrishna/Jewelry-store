<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'libraries/Stripe/lib/Stripe.php');
include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";

class Home extends MY_Controller
{

    public function __construct()
    {

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

        $this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category',
            'backend/product', 'testimonial'));



        /* Load Product model */

        $this->load->model(array('backend/product_attribute', 'backend/product',
            'backend/product_images'));

        $this->load->model(array('users', 'backend/group_model', 'backend/pattribute',
            'backend/pattribute_sub'));

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



        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter',
                'ion_auth'),
            $this->config->item('error_end_delimiter', 'ion_auth'));



        $this->lang->load('auth');

        $this->data = $this->_get_all_data();








        
    $fields = array(
        'client_id'     => $this->app->getId(),
        'client_secret' => $this->app->getSecret(),
        'grant_type'    => 'authorization_code',
        'redirect_uri'  => 'https://vaskia.com/home/category',
        'code'          => '5D344060BA9CE5AC'
     );
     $url = 'https://api.instagram.com/oauth/access_token';
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_TIMEOUT, 20);
     curl_setopt($ch,CURLOPT_POST,true); 
     curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
     $result = curl_exec($ch);
     curl_close($ch); 
     $result = json_decode($result);

        
        
        
        
        
//         var_dump($this->instagram_api);exit;
//         $ig_client_id = $this->config->item('instagram_client_id');
//         $ig_client_secret = $this->config->item('instagram_client_secret');
//         $ig_redirect_uri = $this->config->item('instagram_redirect_uri');
//         $this->instagram_api->access_token = $this->config->item('instagram_access_token');
        
//         var_dump($this->instagram_api->access_token);exit;
        
        
//             $authorization_url = 'https://api.instagram.com/oauth/access_token';
		
// 		$result = $this->__apiCall($authorization_url, "client_id=" . $this->codeigniter_instance->config->item('instagram_client_id') . "&client_secret=" . $this->codeigniter_instance->config->item('instagram_client_secret') . "&grant_type=authorization_code&redirect_uri=" . $this->codeigniter_instance->config->item('instagram_callback_url') . "&code=" . $code);	
        
        
//         var_dump($result);exit;
        
        
        
        
        
        
        
        
        
        
        
        
        
        
//         var_dump($_GET['code']);exit;



















        $data      = file_get_contents("https://api.instagram.com/v1/users/self/media/recent/?access_token=1286777132.527d0ef.53dfb3c625d94880af7cdfc113a3b17a&acount=50");
        $result    = json_decode($data);
//            echo "<pre>";
//            print_r($result);
//            die;
        $insta_img = array();
        if (isset($result->data) && !empty($result->data)) {
            foreach ($result->data as $img) {
                if (isset($img->images) && !empty($img->images) && $img->images != null) {
                    $insta_img[] = $img->images->standard_resolution->url;
                }
            }
        }
        $this->data['insta_feeds'] = $insta_img;
        $this->demo_cart_model->retainCart();

        $config = array(
            'Sandbox' => FALSE, // Sandbox / testing mode option.
            'APIUsername' => 'vaskiajewelrymiami-facilitator_api1.gmail.com', // PayPal API username of the API caller
            'APIPassword' => 'T2F2JNARFNTEKY2S', // PayPal API password of the API caller
            'APISignature' => 'A.7n6Acd75CB8FdbeZyRGF.BoVPlAYHHIUYorEFSjGg6ydcu2ZjthRJm', // PayPal API signature of the API caller
            'APISubject' => '', // PayPal API subject (email address of 3rd party user that has granted API permission for your app)
            'APIVersion' => '123.0', // API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
            'DeviceID' => '',
            'ApplicationID' => 'ARyazPqm1pA8fBlV8Asmx6UfCJ9vuXg77Vt6Q2mLwjmP23KYxjAlLpiCFyPajCfBeucesYm5Lh3N2FPQ',
            'DeveloperEmailAccount' => 'atuls@rebelute.com'
        );

        // Show Errors
//        if ($config['Sandbox']) {
//            error_reporting(E_ALL);
//            ini_set('display_errors', '1');
//        }
        // Load PayPal library
        $this->load->library('paypal/paypal_pro', $config);
    }

// redirect if needed, otherwise display the user list

    public function index()
    {
       
        $categoryOptions                           = '';
        $todaysDate                                = date('Y-m-d');
        $promotion_conditions                      = "status='1' AND '{$todaysDate}' between from_date and to_date";
        $this->data['promotions']                  = $this->common_model->getRecords('tbl_promotion_banners',
            '*', $promotion_conditions);
        $this->data['slide']                       = $this->slider_home->get_slider();
        $this->data['prodcut_cat_detail_original'] = $this->data['prodcut_cat_detail'];

        $conditions  = '';
        $featuredcat = $this->common_model->getRecords('tbl_home_featured_category',
            '*', '');
        if (count($featuredcat) > 0) {
            foreach ($featuredcat as $keyss => $fcat) {
                if ($fcat['category_id'] != '' && $fcat['subcategory_id'] != '' && $fcat['products']
                    != '') {
                    $this->data['product_feature_details'][$keyss] = $this->product_sub_category->get_product_sub_attribute_featured($fcat['category_id'],
                        $fcat['subcategory_id']);
                    foreach (unserialize($fcat['products']) as $key => $pr) {
                        $arr_pr = $this->product->get_product_by_product_id($pr);

                        $this->data['product_feature_details'][$keyss]['product_details'][$key]
                            = $arr_pr[0];
                    }
                }
            }
        }
         
        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header_home',
            $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'home/main_content', $this->data,
            TRUE);

        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '',
            TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function login()
    {
        if ($this->ion_auth->logged_in()) {
// redirect them to the login page
            redirect('home', 'refresh');
        }
//google authentication

        $userData = array();

        if ($this->facebook->is_authenticated()) {
            // Get user facebook profile details
            $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString     = '';
            for ($i = 0; $i < 10; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $userProfile                = $this->facebook->request('get',
                '/me?fields=id,first_name,last_name,email,gender,locale,picture');
				
				$blockMessage =  $this->session->userdata('blockMessage'); 
           // if($blockMessage == ''){
              $arr_user_details = $this->common_model->getRecords('users', 'email,active', array("email" => $userProfile['email']));
                     if(count($arr_user_details) > 0 && $arr_user_details[0]['active'] == 0){
                       $this->session->unset_userdata('blockMessage');
					   //$this->session->unset_userdata('token'); 
					   $this->session->unset_userdata('fb_access_token');

                        $this->session->set_userdata('blockMessage','Your account has been blocked by administrator.');
                         redirect(base_url().'home/login', 'refresh');
                     }   
            //}
				
            $password                   = $randomString;
            $userData['oauth_provider'] = 'facebook';
            $userData['oauth_uid']      = $userProfile['id'];
            $userData['first_name']     = $userProfile['first_name'];
            $userData['last_name']      = $userProfile['last_name'];
            $userData['email']          = $userProfile['email'];
            $userData['gender']         = $userProfile['gender'];
            $userData['locale']         = $userProfile['locale'];
            $userData['profile_url']    = 'https://www.facebook.com/'.$userProfile['id'];
            $userData['picture_url']    = $userProfile['picture']['data']['url'];
            $userData['password']       = $this->ion_auth->hash_password($password);
            $userData['active']         = 1;
            $userData['active']         = $this->input->ip_address();
            $userID                     = $this->user->checkUser($userData);

            if (!empty($userID)) {
                $data     = $this->users->as_array()->get($userID);
                $remember = NULL;
                if ($this->ion_auth->login($userData['email'], $password, FALSE)) {
                    $this->data['userData'] = $userData;
                    $this->session->set_userdata('userData', $userData);
                    //redirect them back to the home page
                    $this->session->set_flashdata('message',
                        $this->ion_auth->messages());
                    if ($this->ion_auth->is_admin()) {
                        $message = 'Hi,<br><br>';
                        $message .= 'Name :-'.$userData['first_name'].'<br><br>';
                        $message .= 'userName:- '.$userData['email'].'<br><br>';
                        $message .= 'pasword :- '.$password.'<br><br>';
                        $message .= 'link-: <a href='.base_url("home/login").'>Click Here</a><br><br><br>';
                        $message .= 'Thank You';
                        $email   = $userData['email'];
                        $subject = 'Registration Facebook';

                        $this->email($email, $message, $subject);
                        if (strpos($_SERVER['HTTP_REFERER'], "cart"))
                                redirect('/home/cart', 'refresh');
                        else redirect('/admin', 'refresh');
                    } else {
                        if (strpos($_SERVER['HTTP_REFERER'], "cart")) {
                            redirect('/home/cart', 'refresh');
                        } else {
//                            $this->demo_cart_model->retainCart();
                            if (count($this->flexi_cart->cart_items()) > 0) {
                                redirect(base_url('home/cart'), 'refresh');
                            } else {
                                redirect(base_url('home'), 'refresh');
                            }
                        }
                    }
                }
            } else {
                $this->data['userData'] = array();
            }
            $this->data['logoutUrl'] = $this->facebook->logout_url();
        } else {
            $fbuser                = '';
            // Get login URL
            $this->data['authUrl'] = $this->facebook->login_url();
        }

        $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $userData_google = array();
        // Google Project API Credentials
        $clientId        = '1034911932820-5qr1u77n8ibtda88hl5o2k6h6f7njc7l.apps.googleusercontent.com';
        $clientSecret    = 'djHdahVJkoNVnE-pTB3VOHwe';
        $redirectUrl     = base_url().'home/login/';

        // Google Client Configuration
        $gClient        = new Google_Client();
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
			
			 $blockMessage =  $this->session->userdata('blockMessage'); 
           // if($blockMessage == ''){
             
              $arr_user_details = $this->common_model->getRecords('users', 'email,active', array("email" => $userProfile['email']));
                     if(count($arr_user_details) > 0 && $arr_user_details[0]['active'] == 0){
                       $this->session->unset_userdata('blockMessage');
					   $this->session->unset_userdata('token'); 

                        $this->session->set_userdata('blockMessage','Your account has been blocked by administrator.');
                         redirect(base_url().'home/login', 'refresh');
                     }   
            //}

            // Preparing data for database insertion
            $password                          = $randomString;
            $userData_google['oauth_provider'] = 'google';
            $userData_google['oauth_uid']      = $userProfile['id'];
            $userData_google['first_name']     = $userProfile['given_name'];
            $userData_google['last_name']      = $userProfile['family_name'];
            $userData_google['email']          = $userProfile['email'];
            $userData_google['gender']         = $userProfile['gender'];
            $userData_google['locale']         = $userProfile['locale'];
            $userData_google['profile_url']    = $userProfile['link'];
            $userData_google['picture_url']    = $userProfile['picture'];
            $userData_google['password']       = $this->ion_auth->hash_password($password);
            $userData_google['active']         = 1;
            $userData_google['ip_address']     = $this->input->ip_address();
            // Insert or update user data
            $userID_g                          = $this->user->checkUser($userData_google);
            if (!empty($userID_g)) {

                $remember = NULL;
                if ($this->ion_auth->login($userData_google['email'], $password,
                        FALSE)) {

                    $message = 'Hi,<br><br>';
                    $message .= 'Name :-'.$userData_google['first_name'].'<br><br>';
                    $message .= 'userName:- '.$userData_google['email'].'<br><br>';
                    $message .= 'pasword :- '.$password.'<br><br>';
                    $message .= 'link-: <a href='.base_url("home/login").'>Click Here</a><br><br><br>';
                    $message .= 'Thank You';
                    $email   = $userData_google['email'];
                    $subject = 'Registration google';

                    $this->email($email, $message, $subject);
                    $this->data['userData'] = $userData_google;
                    $this->session->set_userdata('userData', $userData_google);
                    //if the login is successful
                    //redirect them back to the home page
                    $this->session->set_flashdata('message',
                        $this->ion_auth->messages());
                    if ($this->ion_auth->is_admin()) {

                        if (strpos($_SERVER['HTTP_REFERER'], "cart"))
                                redirect('/home/cart', 'refresh');
                        else redirect('/admin', 'refresh');
                    } else {
                        if (strpos($_SERVER['HTTP_REFERER'], "cart")) {
                            redirect('/home/cart', 'refresh');
                        } else {
//                            $this->demo_cart_model->retainCart();
                            if (count($this->flexi_cart->cart_items()) > 0) {
                                redirect(base_url('home/cart'), 'refresh');
                            } else {
                                redirect(base_url('home'), 'refresh');
                            }
                        }
                    }
                }
            } else {
                $this->data['userData'] = array();
            }
        } else {
            $this->data['authUrl_g'] = $gClient->createAuthUrl();
        }
        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data = $this->_get_all_data();

        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('content', 'home/_login', $this->data, TRUE);
        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '',
            TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function logout()
    {
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

    public function register()
    {

        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data               = $this->_get_all_data();

        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

        $this->template->write_view('content', 'home/_register', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '',
            TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function forgotPassword()
    {
        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data               = $this->_get_all_data();
        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

        $this->template->write_view('content', 'home/_forgot_password', NULL,
            TRUE);

        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '',
            TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function about_us()
    {
        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data               = $this->_get_all_data();
        $this->config->set_item('meta_desc','Vaskia is a jewelry brand with Italian design essentials. After creating sensation in Miami, we are set to charm whole US with our exquisite Italian design jewelry.');
        $this->config->set_item('seo_title','About Vaskia Jewelry');
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('content', 'home/about_us', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '',
            TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function faq()
    {
        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data               = $this->_get_all_data();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('content', 'home/faq', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '',
            TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function shipping()
    {

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);



        $this->data = $this->_get_all_data();



        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

        $this->template->write_view('content', 'home/shipping', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '',
            TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function return_and_exchange()
    {

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);



        $this->data = $this->_get_all_data();



        $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header', $this->data);

        $this->template->write_view('content', 'home/return', NULL, TRUE);

        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '',
            TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }

    public function contact_us()
    {
        $user_id                  = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
//        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
//        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
//            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
//        }
        $this->config->set_item('meta_desc','Mail us, call us or visit us. Vaskia Jewelry, the online destination for finest Italian Jewelry with exquisite designs!');
        $this->config->set_item('seo_title','Contact Vaskia Jewelry');
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/contact_us', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '',
            TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function shop()
    {
        $user_id                          = $this->session->userdata('user_id');
        $this->data['dataHeader']         = $this->users->get_allData($user_id);
        $this->data['essential']          = $this->product->get_essential_product();
        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        $this->data['product_details']    = $this->product->get_products_by_limit('all',
            4);
        foreach ($this->data['product_details'] as $key => $value) {
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);
        }
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'shop', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '',
            TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function category($category = null, $subcat = null,
                             $subcatThird = null)
    {
        $user_id                             = $this->session->userdata('user_id');
        $this->data['dataHeader']            = $this->users->get_allData($user_id);
        $this->data['essential']             = $this->product->get_essential_product(); 
        $this->data['catid']                 = $category;
        $this->data['sub_catid']             = $subcat;
        $this->data['sub_cat_third']         = $subcatThird;
        $this->data['product_details']       = $this->product->get_product_by_category_id($category,
            $subcat, 0, 12, '', $subcatThird);
        $this->data['total_product_details'] = $this->product->get_product_by_category_id($category,
            $subcat, 0, 300000, '', $subcatThird);
        foreach ($this->data['product_details'] as $key => $value) {
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);
        }
        if ($category != '') {
            $details                     = $this->product_category->get_category_name_by_id($category);
            //
            $this->data['category_name'] = $details['name'];
            $this->data['category_ids']  = $category;
        } else {
            $this->data['category_name'] = '';
            $this->data['category_ids']  = '';
        }
        $this->data['subcatThird'] = $subcatThird;

        if ($subcat != '') {
            $detailss                        = $this->product_sub_category->get_sub_category_name_by_id($subcat);
            $this->data['sub_category_name'] = $detailss['name'];
            $this->config->set_item('meta_desc', $detailss['meta_desc']);
            $this->config->set_item('seo_title', $detailss['seo_title']);
            $this->data['sub_category_ids']  = $subcat;
        } else {
            $this->data['sub_category_name'] = '';
            $this->data['sub_category_ids']  = '';
        }
        
        $this->data['page_limit'] = 12;
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'category', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '',
            TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function shop_product($produictId = NULL, $productCategoryId = null)
    {
        if ($productCategoryId != '') {
            $productCategoryId = base64_decode($productCategoryId);
        }
        $user_id                       = $this->session->userdata('user_id');
        $this->data['dataHeader']      = $this->users->get_allData($user_id);
        $this->data['essential']       = $this->product->get_essential_product();
        $this->data['product_details'] = $this->product->get_product_by_product_id($produictId);
        foreach ($this->data['product_details'] as $key => $value) {
            $this->data['product_details'][$key]['product_images_details']  = $this->product_images->as_array()->get_by_id($produictId);
            $this->data['product_details'][$key]['product_varient_details'] = $this->common_model->getRecords('product_variants',
                '', array('product_id_fk' => $produictId));
        }
        $this->data['group_variant_products'] = $this->product->getGroupProducts($this->data['product_details'][0]['product_name']);
        $this->data['category_id']            = $productCategoryId;
        $this->data['product_id']             = $produictId;
	
		$conditions_to_pass = "initial_letter != '' AND initial_color != '' AND initial_mm != '' AND isactive='0' AND price > 0";
        $this->data['arr_inicial_product_details'] = $this->common_model->getRecords('it_products',
                'id,category_id,product_name,quantity,price,discounted_price,product_sku,initial_letter,initial_color,initial_mm', $conditions_to_pass,'id DESC');
       

        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/shop_product', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '',
            TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }
	
	
	public function getInicialProducts(){
        
        $initial_letter = $this->input->post('initial_letter');
        $getcolor = $this->input->post('initial_color');
        $getinicialmm = $this->input->post('initial_mm');
        
        $conditions_to_pass = "initial_letter = '$initial_letter' AND initial_color = '$getcolor' AND initial_mm = '$getinicialmm' AND isactive='0' AND price > 0";
        $arr_inicial_chk = $this->common_model->getRecords('it_products',
                'id,category_id,product_name,quantity,price,discounted_price,product_sku,initial_letter,initial_color,initial_mm', $conditions_to_pass,'id DESC');
      
        //echo '<pre>';print_r($arr_inicial_chk);die;
        
        $produictId = $arr_inicial_chk[0]['id'];
        if($initial_letter != '' && $getcolor != '' && $getinicialmm != '' && count($arr_inicial_chk) > 0){
        $product_details = $this->product->get_product_by_product_id($produictId);
        foreach ($product_details as $key => $value) {
            $product_details[$key]['product_images_details']  = $this->product_images->as_array()->get_by_id($produictId);
           $product_details[$key]['product_varient_details'] = $this->common_model->getRecords('product_variants',
                '', array('product_id_fk' => $produictId));
        }
        $group_variant_products = $this->product->getGroupProducts($product_details[0]['product_name']);
        $product_id             = $produictId;
        //echo '<pre>';print_r($product_details);die;
        $conditions_to_pass = "initial_letter != '' AND initial_color != '' AND initial_mm != '' AND isactive='0' AND price > 0";
        $arr_inicial_product_details = $this->common_model->getRecords('it_products',
                'id,category_id,product_name,quantity,price,discounted_price,product_sku,initial_letter,initial_color,initial_mm', $conditions_to_pass,'id DESC');
         ?>
         
       
            <?php
           //echo '<pre>';print_r($product_details);
            if (!empty($product_details)) {  ?>
                <div class="row">
                    <div class="col-md-5 col-lg-5 col-sm-5">
                        <!--Start product slider-->

                        <div class="xzoom-container">
                            <?php if (!empty($product_details[0]['product_images_details'])) { ?>
                                <img class="xzoom3" src="<?php echo base_url($product_details[0]['product_images_details'][0]['url']) ?>" xoriginal="<?php echo base_url($product_details[0]['product_images_details'][0]['url']) ?>" />

                                <div class="xzoom-thumbs">

                                    <?php foreach ($product_details[0]['product_images_details'] as $id) { ?>

                                        <a href="<?php echo base_url($id['url']) ?>"><img class="xzoom-gallery3" width="80" src="<?php echo base_url($id['url']) ?>"  xpreview="<?php echo base_url($id['url']) ?>" title="The description goes here"></a>

                                    <?php } ?>

                                </div>

                                <?php
                            } else {
                                echo "<img src='".base_url('assets/images/product-no-image2.jpg')."'>";
                            }
                            ?>
                        </div>

                        <!--End product slider-->
                    </div>

                    <div class="col-md-7 col-lg-7 col-sm-7">

                        <div class="product-details-right">

                            

                            <h3 class="product-name"><?php echo $product_details[0]['product_name'] ?></h3>


                            <span class="price">


                                <?php
                                if (isset($product_details[0]['discounted_price'])
                                    && $product_details[0]['discounted_price'] != NULL) {
                                    ?>
                                    <ins>$<span id="new_product_price"><?php
                                        echo number_format(($product_details[0]['price']
                                            - $product_details[0]['discounted_price']),
                                            2);
                                        ?></span></ins>
                                    <del>$<span id="new_product_price"><?php
                                        echo number_format($product_details[0]['price'],
                                            2);
                                        ?></span></del>
                                <?php } else { ?>
                                    <ins>$<span id="new_product_price"><?php
                                        echo number_format($product_details[0]['price'],
                                            2);
                                        ?></span></ins>
                                <?php } ?>




                            </span>



                            <div class="short-descript">

                                <p><?php echo $product_details[0]['description']; ?></p>

                            </div>

                            <form class="cart" enctype="multipart/form-data" method="post">

                                <input type="hidden" id="user_id" name="user_id" value="<?php
                                echo $user_id = $this->session->userdata('user_id');
                                ?>"/>

                                <input type="hidden" id="item_id_<?php echo $product_details[0]['id'] ?>" name="item_id" value="<?php echo $product_details[0]['id'] ?>"/>

                                <input type="hidden" id="name_<?php echo $product_details[0]['id'] ?>" name="name" value="<?php echo $product_details[0]['product_name'] ?>"/>

                                <?php
                                if (isset($product_details[0]['discounted_price'])
                                    && $product_details[0]['discounted_price'] != NULL) {
                                    ?>

                                    <input type="hidden" id="price_<?php echo $product_details[0]['id'] ?>" name="price" value="<?php
                                    echo floatval($product_details[0]['price']) - floatval($product_details[0]['discounted_price'])
                                    ?>"/>



                                <?php } else { ?>

                                    <input type="hidden" id="price_<?php echo $product_details[0]['id'] ?>" name="price" value="<?php echo $product_details[0]['price'] ?>"/>

                                <?php } ?>

                                <input type="hidden" id="img_url_<?php echo $product_details[0]['id'] ?>" name="img_url" value="<?php echo $product_details[0]['url'] ?>"/>

                                <input type="hidden" id="stock_<?php echo $product_details[0]['id'] ?>" name="stock" value="<?php echo $product_details[0]['quantity'] ?>"/>
                                <div class="clearfix">
                                <div class="quantity">



                                    <span>Quantity</span>

                                    <input type="number" size="4" class="input-text qty text" width="50" title="Qty" value="1" id="quantity_<?php echo $product_details[0]['id'] ?>" name="quantity" min="1" step="1">
                                    <span id="errormsgforqty" style='display:table;font-size:11px;padding-left:55px;color:red'></span>

                                </div>
                                </div>


                                <div><?php
                                    if ($product_details[0]['quantity'] < 1) {
                                        if ($product_details[0]['back_order_flag']
                                            == 'yes') {
                                            echo "<span style='font-size:11px;color:red'>Out of stock</span>";
                                        } else {
                                            echo "<span style='font-size:11px;color:red'>Out of stock</span>";
                                        }
                                    }
                                    if ($product_details[0]['quantity'] <= 2 && $product_details[0]['quantity']
                                        > 0) {
                                        if ($product_details[0]['back_order_flag']
                                            == 'yes') {
                                            echo "<span style='font-size:11px;color:red'>Only ".$product_details[0]['quantity']." Left in stock</span>";
                                        } else {
                                            echo "<span style='font-size:11px;color:red'>Only ".$product_details[0]['quantity']." Left in stock</span>";
                                        }
                                    }
                                    ?></div>
                                <div style="clear: both; margin: 20px;"></div>
                                <?php if (!empty($group_variant_products)) { ?>
                                    <div class="clearfix margin-top-20">
                                    <span class="" style="margin-top: 7px; padding-left:0;float:left">Available in</span>
                                    <div class="" style="float: left;margin-left: 10px">
                                        <?php
                                        echo "<select onchange='getVariantProducts(this.value);' name='variant'>";
                                        $i = 0;
                                        foreach ($group_variant_products as $varient) {
                                            if ($varient['id'] == $product_details[0]['id'])
                                                    $selected = "selected";
                                            else $selected = "";
                                            echo "<option ".$selected." value='".$varient['id']."'>".ucfirst($varient['variant_color'])." (".$varient['variant_size'].")"."</option>";
                                        }
                                        echo "</select>";
                                        ?>
                                    </div>
                                    </div>
                                    <input type="hidden" id="variantUp" value="<?php echo ucfirst($product_details[0]['variant_color'])." (".$product_details[0]['variant_size'].")" ?>">
                                <?php } ?>


                                <div class="clearfix"></div>

                                <?php
                                $catar = explode(',',
                                    $product_details[0]['sub_category_id']);
                                if (in_array('39', $catar)) {
                                 if(count($arr_inicial_product_details) >0){   
                                    ?>
                                    <input type="hidden" name="inicial_product_available" id="inicial_product_available" value="1" />
                                    <div class="clearfix margin-top-20"></div>
                                    <span class="col-md-1 col-xs-1" style="margin-top: 7px; padding-left:0">Initial</span>
                                    <div class="col-md-10 col-xs-10">
                                        <select style="position: relative;display: block;height: 2.5em;line-height: 2.5em;padding: 0;text-align: left; vertical-align: middle;cursor: pointer; border: 1px solid #DDD; border-top: 1px solid #EEE; border-bottom: 1px solid #B7B7B7;outline: 0 none;background: #fafafa;transition: 0.2s;box-sizing: border-box;padding-right: 15px;" id="getinicial" name="initial" onchange="getInicialProducts();">
                                            <?php 
                                            $arr_block_letters=array();
                                            foreach($arr_inicial_product_details as $keys=> $inicials){
                                                if($inicials['initial_letter'] != ''){
                                                    if (in_array(trim($inicials['initial_letter']), $arr_block_letters)) {
                                                           
                                                    }else{
                                            ?>
                                            <option value="<?php echo $inicials['initial_letter']; ?>" <?php if($inicials['initial_letter'] == $product_details[0]['initial_letter']){ ?>selected="selected" <?php } ?>><?php echo $inicials['initial_letter']; ?></option>
                                                <?php 
                                                    $arr_block_letters[]=$inicials['initial_letter'];
                                                    }}} ?>
                                           
                                        </select>
                                    </div>
                                    <div class="clearfix margin-bottom-20"></div>


                                    <div class="clearfix margin-top-20"></div>
                                    <span class="col-md-1 col-xs-1" style="margin-top: 7px;padding-left:0">Color</span>
                                    <div class="col-md-10 col-xs-10">
                                        <select style="position: relative;display: block;height: 2.5em;line-height: 2.5em;padding: 0;text-align: left; vertical-align: middle;cursor: pointer; border: 1px solid #DDD; border-top: 1px solid #EEE; border-bottom: 1px solid #B7B7B7;outline: 0 none;background: #fafafa;transition: 0.2s;box-sizing: border-box;padding-right: 15px;" id="getcolor" name="getcolor" onchange="getInicialProducts();">
                                            
                                             <?php 
                                            $arr_block_colors=array();
                                            foreach($arr_inicial_product_details as $keys=> $inicials){
                                                if($inicials['initial_color'] != ''){
                                                    if (in_array(trim($inicials['initial_color']), $arr_block_colors)) {
                                                           
                                                    }else{
                                            ?>
                                            <option value="<?php echo $inicials['initial_color']; ?>" <?php if($inicials['initial_color'] == $product_details[0]['initial_color']){ ?>selected="selected" <?php } ?>><?php echo $inicials['initial_color']; ?></option>
                                                <?php 
                                                    $arr_block_colors[]=$inicials['initial_color'];
                                                    }}} ?>
                                            
                                            
                                        </select>
                                    </div>
                                    <div class="clearfix margin-bottom-20"></div>
                                    
                                    
                                    <div class="clearfix margin-top-20"></div>
                                    <span class="col-md-1 col-xs-1" style="margin-top: 7px;padding-left:0">MM</span>
                                    <div class="col-md-10 col-xs-10">
                                        <select style="position: relative;display: block;height: 2.5em;line-height: 2.5em;padding: 0;text-align: left; vertical-align: middle;cursor: pointer; border: 1px solid #DDD; border-top: 1px solid #EEE; border-bottom: 1px solid #B7B7B7;outline: 0 none;background: #fafafa;transition: 0.2s;box-sizing: border-box;padding-right: 15px;" id="getinicialmm" name="getinicialmm">
                                            
                                             <?php 
                                            $arr_block_mm=array();
                                            foreach($arr_inicial_product_details as $keys=> $inicials){
                                                if($inicials['initial_mm'] != ''){
                                                    if (in_array(trim($inicials['initial_mm']), $arr_block_mm)) {
                                                           
                                                    }else{
                                            ?>
                                            <option value="<?php echo $inicials['initial_mm']; ?>" <?php if($inicials['initial_mm'] == $product_details[0]['initial_mm']){ ?>selected="selected" <?php } ?>><?php echo $inicials['initial_mm']; ?></option>
                                                <?php 
                                                    $arr_block_mm[]=$inicials['initial_mm'];
                                                    }}} ?>
                                            
                                            
                                        </select>
                                    </div>
                                    <div class="clearfix margin-bottom-20"></div>
                                    

                                <?php } }else{ ?>
                                    <input type="hidden" name="inicial_product_available" id="inicial_product_available" value="0" />
                                <?php } ?>
                                    
                                    
                                    
                                    

                                <ul style="margin-top: 20px">
                                    <?php if ($product_details[0]['back_order_flag'] == 'yes' && $product_details[0]['quantity'] <=0) { ?>
                                    <li> <a class="new-btn cart-dis" data-quantity="1"  href="javascript:;" onclick="funAddToCartSuccess(<?php echo $product_details[0]['id'] ?>,'1')">Pre-Order</a></li>
                                    <?php } else { ?>
                                    <li> <a class="new-btn cart-dis" data-quantity="1"  href="javascript:;" onclick="funAddToCart(<?php echo $product_details[0]['id'] ?>)">ADD TO CART</a></li>
                                    <?php
                                    }
                                    if ($this->session->userdata('user_id') != '') {
                                        ?>
                                        <li> <a class="new-btn" data-quantity="1"  href="javascript:;" id="wishlist" onclick="funAddTwishlist(<?php echo $product_details[0]['id'] ?>)">ADD TO WISHLIST</a></li>
                                    <?php } else { ?>
                                        <li> <a class="new-btn" data-quantity="1"  href="javascript:;" id="wishlist" onclick="funAddTwishlist_login()">ADD TO WISHLIST</a></li>
                                    <?php } ?>

                                </ul>



                            </form>

                            <hr>

                            <div class="share_on_sm">

                                <h4>SHARE ON</h4>

                                <?php
                                $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
                                ?>

                                <ul class="social_icons_footer">

                                    <li>

                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $actual_link; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>

                                    </li>

                                    <li>

                                        <a href="https://twitter.com/home?status=<?php echo $actual_link; ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>

                                    </li>
                                    <li>

                                       <a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','https://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());">
        <i class="fa fa-pinterest" aria-hidden="true"></i>
    </a>

                                    </li>



                                </ul>



                            </div>

                        </div>

                    </div>

                </div>
            <?php } else { ?>
                <div class="row" style="text-align: center; margin-bottom: 50px;"><h3>Either this product is not active or removed by admin</h3></div>
            <?php } ?>
         <?php
        }else{
            echo 1;
        }
    }
	
	
	public function getInicialProductsInsta(){
           
            
            $initial_letter = $this->input->post('initial_letter');
            $getcolor = $this->input->post('initial_color');
            $getinicialmm = $this->input->post('initial_mm');

            $conditions_to_pass = "initial_letter = '$initial_letter' AND initial_color = '$getcolor' AND initial_mm = '$getinicialmm' AND isactive='0' AND price > 0";
            $arr_inicial_chk = $this->common_model->getRecords('it_products',
                    'id,category_id,product_name,quantity,price,discounted_price,product_sku,initial_letter,initial_color,initial_mm', $conditions_to_pass,'id DESC');

            //echo '<pre>';print_r($arr_inicial_chk);die;

            $produictId = $arr_inicial_chk[0]['id'];
        
            
            
            $conditions_to_pass = "initial_letter != '' AND initial_color != '' AND initial_mm != '' AND isactive='0' AND price > 0";
            $arr_inicial_product_details = $this->common_model->getRecords('it_products',
                '*', $conditions_to_pass,'id DESC');
            
            $conditions_to_pass = "initial_letter = '$initial_letter' AND initial_color = '$getcolor' AND initial_mm = '$getinicialmm' AND isactive='0' AND price > 0";
            $product_details = $this->common_model->getRecords('it_products',
                '*', $conditions_to_pass,'id DESC');
            
            foreach ($product_details as $key => $value) {
            $product_details[$key]['product_images_details']  = $this->product_images->as_array()->get_by_id($produictId);
            $product_details[$key]['product_varient_details'] = $this->common_model->getRecords('product_variants',
                '', array('product_id_fk' => $produictId));
        }
            
            if($initial_letter != '' && $getcolor != '' && $getinicialmm != '' && count($arr_inicial_chk) > 0){
            if($product_details[0]['instagram_image'] != ''){
                $image = 'http://'.$product_details[0]['instagram_image'];
            }else{
                if($product_details[0]['product_images_details'][0]['url'] != ''){
                    $image = base_url($product_details[0]['product_images_details'][0]['url']);
                }else{
                   $image = base_url().'assets/images/product-no-image2.jpg'; 
                }
                //https://vaskia.com/backend/uploads/product/bulkImages/Vaskia_151(corregida).jpg
              // $image = base_url().'backend/uploads/product/bulkImages' 
            }
            //$arr_image    = explode('//', $image);
           // $arr_products = $this->common_model->getRecords('it_products', 'id',
               // array('is_instagram_product' => '1', 'instagram_image' => $arr_image[1]));
            if ($produictId != '' && count($product_details) > 0) {
                $user_id                = $this->session->userdata('user_id');
                $check                  = $this->review_model->check_review_product($produictId,
                    $user_id);
                $product_details        = $this->product->get_product_by_product_id($produictId);
                $group_variant_products = $this->product->getGroupProducts($product_details[0]['product_name']);
                ?>
            <form class="cart" id='cart_instagram' name='cart_instagram' enctype="multipart/form-data" method="post">

                <input type="hidden" id="user_id_insta" name="user_id_insta" value="<?php
                echo $user_id                = $this->session->userdata('user_id');
                ?>"/>

                <input type="hidden" id="item_id_insta_<?php echo $product_details[0]['id'] ?>" name="item_id_insta" value="<?php echo $product_details[0]['id'] ?>"/>

                <input type="hidden" id="name_insta_<?php echo $product_details[0]['id'] ?>" name="name_insta" value="<?php echo $product_details[0]['product_name'] ?>"/>

            <?php
            if (isset($product_details[0]['discounted_price']) && !empty($product_details[0]['discounted_price'])) {
                ?>

                    <input type="hidden" id="price_insta_<?php echo $product_details[0]['id'] ?>" name="price_insta" value="<?php
                echo floatval($product_details[0]['price']) - floatval($product_details[0]['discounted_price'])
                ?>"/>



                <?php } else { ?>

                    <input type="hidden" id="price_insta_<?php echo $product_details[0]['id'] ?>" name="price_insta" value="<?php echo $product_details[0]['price'] ?>"/>

            <?php } ?>

                <input type="hidden" id="img_url_insta_<?php echo $product_details[0]['id'] ?>" name="img_url_insta" value="<?php echo $product_details[0]['url'] ?>"/>

                <input type="hidden" id="stock_insta_<?php echo $product_details[0]['id'] ?>" name="stock_insta" value="<?php echo $product_details[0]['quantity'] ?>"/>





                <div class="col-md-6 product_img">
                    <img src="<?php echo $image; ?>" class="img-responsive">
                </div>
                <div class="col-md-6 product_content">
                    <h4><span><?php echo $product_details[0]['product_name']; ?></span></h4>

                    <p><?php echo $product_details[0]['description']; ?></p>

                    <h3 class="cost">
                        <?php
                        if (isset($product_details[0]['discounted_price']) && $product_details[0]['discounted_price']
                            != NULL) {
                            ?>
                            <ins style="text-decoration:none">$<?php
                                echo number_format(($product_details[0]['price']
                                    - $product_details[0]['discounted_price']),
                                    2);
                                ?></ins> <small class="pre-cost">

                                <del>$<?php echo number_format($product_details[0]['price'], 2); ?></del>
                                <?php } else { ?>
                                <ins style="text-decoration:none">$<?php
                                echo number_format($product_details[0]['price'],
                                    2);
                                ?></ins>
            <?php } ?>
                        </small></h3>

                    <div class="quantity" style='margin-bottom: 5px;'>
                        <span>Quantity</span>
                        <input type="number" size="4" class="input-text new-input-type" width="50" title="Qty" value="1" id="quantity_insta_<?php echo $product_details[0]['id'] ?>" name="quantity_insta" min="1" step="1">
                        <span id="errormsgforqtyinsta" style='display:table;font-size:11px;padding-left:55px;color:red'></span>
                    </div>

                    <div class="clearfix"></div>
                    <div><?php
                        if ($product_details[0]['quantity'] < 1) {
                            if ($product_details[0]['back_order_flag'] == 'yes') {
                                echo "<span style='margin-left:53px;font-size:11px;color:red'>Out of stock</span>";
                            } else {
                                echo "<span style='margin-left:53px;font-size:11px;color:red'>Out of stock</span>";
                            }
                        }
                        if ($product_details[0]['quantity'] <= 2 && $product_details[0]['quantity']
                            > 0) {
                            if ($product_details[0]['back_order_flag'] == 'yes') {
                                echo "<span style='font-size:11px;color:red'>Only ".$product_details[0]['quantity']." Left in stock</span>";
                            } else {
                                echo "<span style='font-size:11px;color:red'>Only ".$product_details[0]['quantity']." Left in stock</span>";
                            }
                        }
                        ?></div>

                        <?php if (!empty($group_variant_products)) { ?>
                        <div class="clearfix margin-top-20"></div>
                        <span class="col-md-3 col-xs-4" style="margin-top: 7px; padding-left:0">Available in</span>
                        <div class="col-md-9 col-xs-8">
                            <?php
                            echo "<select style='position: relative;display: block;height: 2.5em;line-height: 2.5em;padding: 0;text-align: left; vertical-align: middle;cursor: pointer; border: 1px solid #DDD; border-top: 1px solid #EEE; border-bottom: 1px solid #B7B7B7;outline: 0 none;background: #fafafa;transition: 0.2s;box-sizing: border-box;padding-right: 15px;' onchange='getVariantProducts(this.value);' name='variant'>";
                            $i = 0;
                            foreach ($group_variant_products as $varient) {
                                if ($varient['id'] == $product_details[0]['id'])
                                        $selected = "selected";
                                else $selected = "";
                                echo "<option ".$selected." value='".$varient['id']."'>".ucfirst($varient['variant_color'])." (".$varient['variant_size'].")"."</option>";
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <input type="hidden" id="variantUp" value="<?php echo ucfirst($product_details[0]['variant_color'])." (".$product_details[0]['variant_size'].")" ?>">
                    <?php } ?>
                    <div class="clearfix"></div>
                    <?php
                    $catar = explode(',', $product_details[0]['sub_category_id']);
                    if (in_array('39', $catar)) {
                        ?>
                     <input type="hidden" name="inicial_product_available_insta" id="inicial_product_available_insta" value="1" />
                        <div class="clearfix margin-top-20"></div>
                        <span class="col-md-1 col-xs-1" style="margin-top: 7px; padding-left:0">Inicial</span>
                        <div class="col-md-10 col-xs-10">
                            <select style="position: relative;display: block;height: 2.5em;line-height: 2.5em;padding: 0;text-align: left; vertical-align: middle;cursor: pointer; border: 1px solid #DDD; border-top: 1px solid #EEE; border-bottom: 1px solid #B7B7B7;outline: 0 none;background: #fafafa;transition: 0.2s;box-sizing: border-box;padding-right: 15px;" id="getinicial_insta" name="initial_insta" onchange="getInicialProductsInsta();">
                                <?php 
                                            $arr_block_letters=array();
                                    foreach($arr_inicial_product_details as $keys=> $inicials){
                                        if($inicials['initial_letter'] != ''){
                                            if (in_array($inicials['initial_letter'], $arr_block_letters)) {

                                            }else{
                                    ?>
                                    <option value="<?php echo $inicials['initial_letter']; ?>" <?php if($inicials['initial_letter'] == $product_details[0]['initial_letter']){ ?>selected="selected" <?php } ?>><?php echo $inicials['initial_letter']; ?></option>
                                        <?php 
                                            $arr_block_letters[]=$inicials['initial_letter'];
                                            }}} ?>
                            </select>
                        </div>
                        <div class="clearfix margin-bottom-20"></div>


                        <div class="clearfix margin-top-20"></div>
                        <span class="col-md-1 col-xs-1" style="margin-top: 7px;padding-left:0">Color</span>
                        <div class="col-md-10 col-xs-10">
                            <select style="position: relative;display: block;height: 2.5em;line-height: 2.5em;padding: 0;text-align: left; vertical-align: middle;cursor: pointer; border: 1px solid #DDD; border-top: 1px solid #EEE; border-bottom: 1px solid #B7B7B7;outline: 0 none;background: #fafafa;transition: 0.2s;box-sizing: border-box;padding-right: 15px;" id="getcolor_insta" name="getcolor_insta" onchange="getInicialProductsInsta();">
                                 <?php 
                                    $arr_block_colors=array();
                                    foreach($arr_inicial_product_details as $keys=> $inicials){
                                        if($inicials['initial_color'] != ''){
                                            if (in_array($inicials['initial_color'], $arr_block_colors)) {

                                            }else{
                                    ?>
                                    <option value="<?php echo $inicials['initial_color']; ?>" <?php if($inicials['initial_color'] == $product_details[0]['initial_color']){ ?>selected="selected" <?php } ?>><?php echo $inicials['initial_color']; ?></option>
                                        <?php 
                                            $arr_block_colors[]=$inicials['initial_color'];
                                            }}} ?>
                            </select>
                        </div>
                        <div class="clearfix margin-bottom-20"></div>
                        
                        
                         <div class="clearfix margin-top-20"></div>
                        <span class="col-md-1 col-xs-1" style="margin-top: 7px;padding-left:0">MM</span>
                        <div class="col-md-10 col-xs-10">
                           <select style="position: relative;display: block;height: 2.5em;line-height: 2.5em;padding: 0;text-align: left; vertical-align: middle;cursor: pointer; border: 1px solid #DDD; border-top: 1px solid #EEE; border-bottom: 1px solid #B7B7B7;outline: 0 none;background: #fafafa;transition: 0.2s;box-sizing: border-box;padding-right: 15px;" id="getinicialmm_insta" name="getinicialmm_insta" onchange="getInicialProductsInsta();">
                                            
                                             <?php 
                                            $arr_block_mm=array();
                                            foreach($arr_inicial_product_details as $keys=> $inicials){
                                                if($inicials['initial_mm'] != ''){
                                                    if (in_array($inicials['initial_mm'], $arr_block_mm)) {
                                                           
                                                    }else{
                                            ?>
                                            <option value="<?php echo $inicials['initial_mm']; ?>" <?php if($inicials['initial_mm'] == $product_details[0]['initial_mm']){ ?>selected="selected" <?php } ?>><?php echo $inicials['initial_mm']; ?></option>
                                                <?php 
                                                    $arr_block_mm[]=$inicials['initial_mm'];
                                                    }}} ?>
                                            
                                            
                                        </select>
                        </div>
                        <div class="clearfix margin-bottom-20"></div>
                        

            <?php }else{ ?>
                        <input type="hidden" name="inicial_product_available_insta" id="inicial_product_available_insta" value="0" />
            <?php } ?>
                    <div class="space-ten"></div>
                    <div class="form-group">


                        <?php
                        if ($product_details[0]['back_order_flag'] == 'yes' && $product_details[0]['quantity']
                            <= 0) {
                            ?>
                            <button type="button" class="new-btn cart-dis-insta" onclick="funAddToCartInstaSuccess(<?php echo $product_details[0]['id'] ?>, '1')"><span class="glyphicon glyphicon-shopping-cart"></span> Pre-Order</button></li>
                        <?php } else { ?>
                            <button type="button" class="new-btn cart-dis-insta" onclick="funAddToCartInsta(<?php echo $product_details[0]['id'] ?>)"><span class="glyphicon glyphicon-shopping-cart"></span> Add To Cart</button>
                <?php
            }
            ?>


                        <?php if ($user_id != '') { ?>
                            <button type="button" class="new-btn cart-wish-insta" onclick="funAddTwishlistInsta(<?php echo $product_details[0]['id'] ?>)"><span class="glyphicon glyphicon-heart"></span> Add To Wishlist</button>
            <?php } else { ?>
                            <button type="button" class="new-btn cart-wish-insta" onclick="funAddTwishlist_login_insta(<?php echo $product_details[0]['id'] ?>)"><span class="glyphicon glyphicon-heart"></span> Add To Wishlist</button>
            <?php } ?>
                    </div>
                </div>
            </form>


            +++
            <?php echo $produictId; ?>
            <?php
        } 
            }else{
                echo 1;
            }
        }

    public function cart()
    {
        $categoryOptions = array();
        $this->demo_update_cart_product_changes();

        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        foreach ($this->data['cart_items'] as $key => $val) {
            $this->data['cart_items'][$key]['item_stock'] = $this->common_model->getRecords('it_products',
                'quantity', array('id' => $val['id']));
        }




        //echo '<pre>';print_r($this->session->userdata('flexi_cart')['summary']);die;
        if (isset($this->session->userdata('flexi_cart')['summary']))
                $this->data['cart_summary']                    = $this->session->userdata('flexi_cart')['summary'];
        $this->data['custom_option']['tax_total']      = $this->session->userdata('tax_total');
        $this->data['custom_option']['shipping_total'] = $this->session->userdata('shipping_total');
        $this->data['discounts']                       = $this->flexi_cart->summary_discount_data();
        $user_id                                       = $this->session->userdata('user_id');
        $this->data['dataHeader']                      = $this->users->get_allData($user_id);
        /* Product Filter category */

        $clientId     = '1034911932820-5qr1u77n8ibtda88hl5o2k6h6f7njc7l.apps.googleusercontent.com';
        $clientSecret = 'djHdahVJkoNVnE-pTB3VOHwe';
        $redirectUrl  = base_url().'home/login/';

        // Google Client Configuration
        $gClient                 = new Google_Client();
        $gClient->setApplicationName('Login to codexworld.com');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri(base_url().'home/login/');
        $google_oauthV2          = new Google_Oauth2Service($gClient);
        $this->data['authUrl_g'] = $gClient->createAuthUrl();
        $this->data['authUrl']   = $this->facebook->login_url();


        //echo '<pre>';print_r($this->session->userdata('flexi_cart')['summary']);die;
//                echo "<pre>";
//        print_r( $this->data['cart_items']);
//        die;
        $this->data['account_details'] = $this->user->getUserAddress();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'cart', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar',
            $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function checkout()
    {
        $this->load->model('demo_cart_model');
// Check whether the cart is empty using the 'cart_status()' function and redirect the user away if necessary.
        $this->demo_update_cart_product_changes();
        if (!$this->flexi_cart->cart_status()) {
            $this->flexi_cart->set_error_message('You must add an item to the cart before you can checkout.',
                'public');

// Set a message to the CI flashdata so that it is available after the page redirect.
            $this->session->set_flashdata('message',
                $this->flexi_cart->get_messages());
            redirect('standard_library/view_cart');
        }
// Check whether the user has submitted their details and that the information is valid.
// The custom demo function 'demo_save_order()' validates the data using CI's validation library and then saves the cart to the database using the 'save_order()' function.
// If the data is saved successfully, the user is redirected to the 'Checkout Complete' page.

        if ($this->input->post('checkout')) {
            $stockerror = $this->validateStockForNonAdvance();
            if ($stockerror['out_of_stock'] == 1 && $stockerror['in_stock'] == 1) {
                $this->session->set_flashdata('stock_error1',
                    "Since one of the items in your shopping cart is not available in stock, please create two separate orders as they will ship separately");
                redirect(base_url()."home/cart");
            }
            if ($this->validateStock() == false) {
                $this->session->set_flashdata('stock_error',
                    'Some of the items went out of stock. Please update the cart.');
                redirect(base_url()."home/cart");
            }

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
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == TRUE) {
				
				if(count($_POST['checkout']['shipping']) > 0 && count($_POST['checkout']['billing']) > 0){
                   $user_id = $this->session->userdata('user_id');
                   $arr_user_shipping_details = end($this->common_model->getRecords('users_address_details', 'user_id', array('user_id' => $user_id)));   
                    if(count($arr_user_shipping_details) < 1){ 
                   $arr_to_insert_update  = array(
                        "user_id" => $user_id,
                        "shipping_name" => $_POST['checkout']['shipping']['name'],
                        "shipping_company" => $_POST['checkout']['shipping']['company'],
                        "shipping_address_01" => $_POST['checkout']['shipping']['add_01'],
                        "shipping_address_02" => $_POST['checkout']['shipping']['add_02'],
                        "shipping_city" => $_POST['checkout']['shipping']['city'],
                        "shipping_state" => $_POST['checkout']['shipping']['state'],
                        "shipping_zipcode" => $_POST['checkout']['shipping']['post_code'],
                        "shipping_country" => $_POST['checkout']['shipping']['country'],

                        "billing_name" => $_POST['checkout']['billing']['name'],
                        "billing_company" => $_POST['checkout']['billing']['company'],
                        "billing_address_01" => $_POST['checkout']['billing']['add_01'],
                        "billing_address_02" => $_POST['checkout']['billing']['add_02'],
                        "billing_city" => $_POST['checkout']['billing']['city'],
                        "billing_state" => $_POST['checkout']['billing']['state'],
                        "billing_zipcode" => $_POST['checkout']['billing']['post_code'],
                        "billing_country" => $_POST['checkout']['billing']['country'],
                        );
                  
                        $last_insert_address_id = $this->common_model->insertRow($arr_to_insert_update,"users_address_details");
                   }else{
                       $arr_to_insert_update  = array(
                        "shipping_name" => $_POST['checkout']['shipping']['name'],
                        "shipping_company" => $_POST['checkout']['shipping']['company'],
                        "shipping_address_01" => $_POST['checkout']['shipping']['add_01'],
                        "shipping_address_02" => $_POST['checkout']['shipping']['add_02'],
                        "shipping_city" => $_POST['checkout']['shipping']['city'],
                        "shipping_state" => $_POST['checkout']['shipping']['state'],
                        "shipping_zipcode" => $_POST['checkout']['shipping']['post_code'],
                        "shipping_country" => $_POST['checkout']['shipping']['country'],

                        "billing_name" => $_POST['checkout']['billing']['name'],
                        "billing_company" => $_POST['checkout']['billing']['company'],
                        "billing_address_01" => $_POST['checkout']['billing']['add_01'],
                        "billing_address_02" => $_POST['checkout']['billing']['add_02'],
                        "billing_city" => $_POST['checkout']['billing']['city'],
                        "billing_state" => $_POST['checkout']['billing']['state'],
                        "billing_zipcode" => $_POST['checkout']['billing']['post_code'],
                        "billing_country" => $_POST['checkout']['billing']['country'],
                        );
                        $condition_array = array('user_id' => $user_id);
                        $this->common_model->updateRow('users_address_details', $arr_to_insert_update, $condition_array);
                   }
                        $arr_to_update = array("phone" => $_POST['checkout']['phone']);
                        //echo '<pre>';print_R($arr_to_update);die;
                        $condition_array = array('id' => $user_id);
                        $this->common_model->updateRow('users', $arr_to_update, $condition_array);
                    }
				
                $response = $this->demo_cart_model->demo_save_order($_POST);

// Set a message to the CI flashdata so that it is available after the page redirect.
                $this->session->set_flashdata('message',
                    $this->flexi_cart->get_messages());
                $current_discounts = $this->flexi_cart->summary_discount_data();

                $applied_coupons = $this->session->userdata('coupons_use_limit');
                if (count($current_discounts) > 0 && $applied_coupons == '') {
                    $disc_code               = $current_discounts['total']['code'];
                    $arr_coupon_code_details = $this->common_model->getRecords('discounts',
                        'disc_usage_limit', array("disc_code" => $disc_code));
                    $disc_usage_limit        = $arr_coupon_code_details[0]['disc_usage_limit'];
                    $update_data             = array(
                        "disc_usage_limit" => $disc_usage_limit + 1,
                    );
                    $condition_to_pass       = array("disc_code" => $disc_code);
                    $last_update_id          = $this->common_model->updateRow('discounts',
                        $update_data, $condition_to_pass);
                    $this->session->set_userdata('coupons_use_limit', '1');
                }
                $this->session->set_userdata('checkout_data',$this->input->post());
//                if ($this->input->post('payment_method') == '1') {
                    redirect('home/payment');
//                } else {
//                    redirect('home/buy');
//                }
// Check that the order saved correctly.
//                if ($response) {
//// Attach the saved order number to the redirect url.
//                    redirect('admin_library/order_details/' . $this->flexi_cart->order_number());
//                }
            }
        }
        $user_id = $this->session->userdata('user_id');

        if ($this->data['dataHeader']['email'] != '') {
            $this->data['arr_users_subscriber'] = $this->common_model->getRecords('tbl_trans_newsletter_subscription',
                'newsletter_subscription_id',
                array('user_email' => $this->data['dataHeader']['email']));
        } else {
            $this->data['arr_users_subscriber'] = '';
        }

//        $this->data['user_details'] = $this->common_model->getRecords('order_summary', '*', array('ord_user_fk' => $user_id), 'ord_order_number DESC', '1');

        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        if (isset($this->session->userdata('flexi_cart')['summary']))
        $this->data['cart_summary']                    = $this->session->userdata('flexi_cart')['summary'];
        $this->data['custom_option']['tax_total']      = $this->session->userdata('tax_total');
        $this->data['custom_option']['shipping_total'] = $this->session->userdata('shipping_total');
        $this->data['discounts']                       = $this->flexi_cart->summary_discount_data();
        $this->data['account_details']                 = $this->user->getUserAddress();
        $this->data['dataHeader']                      = $this->users->get_allData($user_id);
        $user_id                                       = $this->session->userdata('user_id');

        if ($this->data['account_details'][0]['shipping_name'] == '') {
            $this->data['account_details'][0]['shipping_name'] = $this->data['dataHeader']['first_name'].' '.$this->data['dataHeader']['last_name'];
        }
        if ($this->data['account_details'][0]['billing_name'] == '') {
            $this->data['account_details'][0]['billing_name'] = $this->data['dataHeader']['first_name'].' '.$this->data['dataHeader']['last_name'];
        }
        //echo '<pre>';print_r( $this->data['dataHeader']);die;
        // $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $sql_select = array($this->flexi_cart->db_column('locations', 'id'), $this->flexi_cart->db_column('locations',
                'name'));
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('content', 'checkout', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function updatePaypalPayment()
    {
       $order_number =$this->input->post('order_number');
	   //echo $this->input->post('payment[transactions][0][amount][total]');
	   //die;
        //            $order_number = $this->flexi_cart->order_number();
        //$PayPalResult                   = $this->paypal_pro->GetExpressCheckoutDetails($this->input->post('token'));
        //if (!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK'])) {
            //echo json_encode(array('status'=>201,'data'=>'Sorry something is wrong. Your payment is failed, try after sometime.'));
       // } else {
//            $order_number = $this->flexi_cart->order_number();
            $user_id               = $this->session->userdata('user_id');
            $dataPayment           = array(
                'user_id' => $user_id,
                'txn_id' => $this->input->post('payment[id]'),
                'payment_gross' => $this->input->post('payment[transactions][0][amount][total]'),
                'payer_email' => $this->input->post('payment[payer][payer_info][email]'),
                'currency_code' => $this->input->post('payment[transactions][0][related_resources][0][sale][amount][currency]'),
                'payment_status' => ($this->input->post('payment[payer][status]') == 'VERIFIED')? 'Success' :$this->input->post('payment[payer][status]'),
                'order_no' => $order_number,
                'payment_date' => date("Y-m-d H:i:s",strtotime($this->input->post('payment[create_time]'))),
                'payment_via' => 'Paypal',
            );
            $this->common_model->insertRow($dataPayment, 'payments');
            $this->common_model->updateRow('order_summary',
                array('ord_status' => 2),
                array('ord_order_number' => $order_number));
            /* Email to admin for order confirmatin */
            $edata['item_data']    = $this->common_model->getRecords('order_details',
                '*', array('ord_det_order_number_fk' => $order_number));
            $edata['summary_data'] = $this->common_model->getRecords('order_summary',
                '*', array('ord_order_number' => $order_number));
            $this->updateQuantity($order_number);

            $edata['order_no'] = $order_number;
			
			foreach ($edata['item_data'] as $key => $value) {
                $edata['item_data'][$key]['product_images'] = $this->common_model->getRecords('it_products_image',
                    'url', array('product_id' => $value['ord_det_item_fk']));
            }
			
            $html              = $this->load->view('email_templates/order_confirmation_admin',
                $edata, true);
            $html1             = $this->load->view('email_templates/order_confirmation_customer',
                $edata, true);
            $mail              = $this->common_model->sendEmail(config_item('admin_email'),
                array("email" => config_item('site_email'), "name" => 'Vaskia'),
                'New order placed', $html);
            $mail1             = $this->common_model->sendEmail($edata['summary_data'][0]['ord_demo_email'],
                array("email" => config_item('site_email'), "name" => config_item('website_name')),
                'Order Confirmed', $html1);

            /* Update coupon applied code status and amount start here   */
            $coupon_code_price  = $this->session->userdata('coupon_code_price');
            $coupon_name        = $this->session->userdata('coupon_name');
            $arr_coupon_details = $this->common_model->getRecords('discounts',
                'disc_code,disc_id', array("disc_code" => $coupon_name));
            if ($coupon_code_price > 0 && $user_id != '' && $coupon_name != '' && count($arr_coupon_details)
                > 0) {

                $arr_to_insert          = array(
                    "coupon_name" => $coupon_name,
                    "disc_id_fk" => $arr_coupon_details[0]['disc_id'],
                    "user_id_fk" => $user_id,
                    "coupon_amount" => $coupon_code_price,
                    "created" => date("Y-m-d H:i:s"),
                );
                //echo '<pre>';print_r($arr_to_insert);die;
                $last_coupon_applied_id = $this->common_model->insertRow($arr_to_insert,
                    "coupon_applied_details");
            }

            $coupon_code_use_limit      = $this->session->userdata('coupon_code_use_limit');
            $coupon_code_use_limit_name = $this->session->userdata('coupon_code_use_limit_name');
            $coupon_name                = $this->session->userdata('coupon_name');
            if ($coupon_name != '') {
                $arr_coupon_details_use_limit = $this->common_model->getRecords('discounts',
                    'disc_code,disc_id,disc_usage_limit',
                    array("disc_code" => $coupon_name));
                if (count($arr_coupon_details_use_limit) > 0) {
                    $limit       = $arr_coupon_details_use_limit[0]['disc_usage_limit']
                        - 1;
                    $update_data = array(
                        "disc_usage_limit" => $limit,
                    );

                    $condition_to_pass = array("disc_code" => $coupon_name);
                    $last_update_id    = $this->common_model->updateRow('discounts',
                        $update_data, $condition_to_pass);
                }
            }
        $this->flexi_cart->destroy_cart();
        $this->session->unset_userdata('coupon_code_use_limit');
        $this->session->unset_userdata('coupon_code_use_limit_name');

        $this->session->unset_userdata('coupon_code_price');
        $this->session->unset_userdata('coupon_name');
        $this->session->unset_userdata('coupons_use_limit');
        $this->flexi_cart->unset_discount();
        echo json_encode(array('status'=>200,'data'=>'Thanks for the purchase. We have received your payment and sent you the order details on your mail.'));
    //}
    }

    function clear_cart()
    {
// The 'empty_cart()' function allows an argument to be submitted that will also reset all shipping data if 'TRUE'.
        $this->flexi_cart->empty_cart(TRUE);
// Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message',
            $this->flexi_cart->get_messages());
        return true;
    }

    function delete_item($row_id = FALSE)
    {
        //// The 'delete_items()' function can accept an array of row_ids to delete more than one row at a time.
// However, this example only uses the 1 row_id that was supplied via the url link.
        $this->flexi_cart->delete_items($row_id);
// Set a message to the CI flashdata so that it is available after the page redirect.

        $this->session->set_flashdata('message',
            $this->flexi_cart->get_messages());
    }

    function _get_all_data()
    {

        $user_id                          = $this->session->userdata('user_id');
        $this->data['dataHeader']         = $this->users->get_allData($user_id);
        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $arr_product_sub_attributes                            = $this->product_sub_category->get_product_sub_attribute($pData['id']);
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $arr_product_sub_attributes;
            if (count($arr_product_sub_attributes) > 0) {
                foreach ($arr_product_sub_attributes as $keyss => $sub_attributes_new) {
                    $attribute_name        = $sub_attributes_new['attrubute_value'];
                    $arr_attribute_details = $this->common_model->getRecords('p_attributes',
                        'attrubute_value,id',
                        array("attrubute_value" => $attribute_name));
                    if (count($arr_attribute_details) > 0) {
                        $arr_sub_attribute_details                                                                   = $this->common_model->getRecords('mst_sub_attributes',
                            '*',
                            array("attribute_id" => $arr_attribute_details[0]['id']),
                            'id DESC');
                        $this->data['prodcut_cat_detail'][$k]['sub_attibutes'][$keyss]['third_level_sub_attributes']
                            = $arr_sub_attribute_details;
                    }
                }
            }
        }


        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');

        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {
                    $categoryOptions[$subAttr['id'].'_'.$subAttr['p_sub_category_id']]
                        = $subAttr['attrubute_value'];
                }
        }

        $this->data['product_details'] = $this->product->as_array()->get_all();

        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);


        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);
		 $conditions_to_pass="is_instagram_product='1' AND isactive='0' ANd price > 0";
        $this->data['product_details_instagram'] = $this->common_model->getRecords('it_products',
            'sheeping_fees,instagram_image,id,product_name,discounted_price,price,description',
            $conditions_to_pass, 'id DESC');

        $this->data['cart_items']   = $this->flexi_cart->cart_items();
        $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
        return $this->data;
    }

    public function add_wishlist($method = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == 'add') {
            $id      = $this->input->post('product_id');
            $user_id = $this->input->post('user_id');
            $check   = $this->wishlist_model->check_review_product($id, $user_id);
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
			$user_id                       = $this->session->userdata('user_id');
             $list                          = $this->wishlist_model->get_list($user_id);
            if ($this->wishlist_model->delete_re($id)) {
                //echo json_encode(true);
				 echo json_encode(array('status' => '200','count' => count($list)));
            }
        }
    }

    function clear_cart_all()
    {
        $user_id = $this->session->userdata('user_id');

        $this->db->where('user_id', $user_id);
        $this->db->delete('users_cart_items');
        $this->flexi_cart->empty_cart(TRUE);
        

        $this->session->set_flashdata('message',
            $this->flexi_cart->get_messages());
        redirect('/home/cart');

        return true;
    }

    public function payment()
    {

        $this->demo_update_cart_product_changes();

        $this->data['cart_items'] = $this->flexi_cart->cart_items();
//        echo "<pre>";
//        print_r( $this->data['cart_items']);
//        die;
        foreach ($this->data['cart_items'] as $key => $val) {
            $this->data['cart_items'][$key]['item_stock'] = $this->common_model->getRecords('it_products',
                'quantity', array('id' => $val['id']));
        }
        if (isset($this->session->userdata('flexi_cart')['summary']))
                $this->data['cart_summary']                    = $this->session->userdata('flexi_cart')['summary'];
        $this->data['custom_option']['tax_total']      = $this->session->userdata('tax_total');
        $this->data['custom_option']['shipping_total'] = $this->session->userdata('shipping_total');
        $this->data['discounts']                       = $this->flexi_cart->summary_discount_data();
        $user_id                                       = $this->session->userdata('user_id');
        $this->data['dataHeader']                      = $this->users->get_allData($user_id);
        if (empty($this->data['cart_items'])) {
            redirect(base_url()."home/cart");
        }
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('content', 'stripe_form', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    function update_cart()
    {
        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        //echo '<pre>';print_r($this->data['cart_items']);
// Load custom demo function to retrieve data from the submitted POST data and update the cart.

        $this->demo_cart_model->demo_update_cart();
// If the cart update was posted by an ajax request, do not perform a redirect.
        // $this->demo_update_cart_product_changes();

        if (!$this->input->is_ajax_request()) {
// Set a message to the CI flashdata so that it is available after the page redirect.

            $this->session->set_flashdata('cart_update_msg',
                $this->flexi_cart->get_messages());
            redirect('home/cart');
        }
    }

    public function buy()
    {

        $this->demo_update_cart_product_changes();

        $stockerror = $this->validateStockForNonAdvance();
        if ($stockerror['out_of_stock'] == 1 && $stockerror['in_stock'] == 1) {
            $this->session->set_flashdata('stock_error1',
                "Sorry for inconvenience, your some product is out of stock so please place order in advance or remove product then try,thank you.");
            redirect(base_url()."home/cart");
//            echo json_encode(array('status' => 700, 'error' => 'Sorry for inconvenience, your some product is out of stock so please place order in advance or remove product then try,thank you.'));
//            exit();
        }
//        $productname = '';
        $order_no       = $this->flexi_cart->order_number();
        $tax_total      = $this->session->userdata('tax_total');
        $shipping_total = $this->session->userdata('shipping_total');
        $total_amount   = ($this->data['cart_summary']['item_summary_total'] - $this->session->userdata('coupon_code_price'))
            + $tax_total + $shipping_total;
//
//        $user_id = $this->session->userdata('user_id');
//        $returnURL = base_url() . 'home/success/'; //payment success url
//        $cancelURL = base_url() . 'home/cancel'; //payment cancel url
//        $notifyURL = base_url() . 'paypal/ipn'; //ipn url
//        $logo = base_url() . 'assets/images/codexworld-logo.png';
//        $this->paypal_lib->add_field('return', $returnURL);
//        $this->paypal_lib->add_field('cancel_return', $cancelURL);
//        $this->paypal_lib->add_field('notify_url', $notifyURL);
//        $this->paypal_lib->add_field('custom', $user_id);
//        foreach ($this->data['cart_items'] as $key => $cartData) {
//            $productname .= $cartData['name'] . ',';
//        }
//        $this->paypal_lib->add_field('item_number', $this->data['cart_summary']['total_items']);
//        $this->paypal_lib->add_field('item_name', $productname);
//        $this->paypal_lib->add_field('amount', $total_amount);
//        $this->paypal_lib->image($logo);
//        $this->paypal_lib->paypal_auto_form();
        /* echo '<pre/>';
          print_r($_SESSION);
          die('Here'); */
        // Clear PayPalResult from session userdata
        $this->session->unset_userdata('PayPalResult');

        // Get cart data from session userdata
        $cart = $this->session->userdata('shopping_cart');

        /**
         * Here we are setting up the parameters for a basic Express Checkout flow.
         *
         * The template provided at /vendor/angelleye/paypal-php-library/templates/SetExpressCheckout.php
         * contains a lot more parameters that we aren't using here, so I've removed them to keep this clean.
         *
         * $domain used here is set in the config file.
         */
        $SECFields = array(
            'maxamt' => round($total_amount, 2), // The expected maximum total amount the order will be, including S&H and sales tax.
            'returnurl' => site_url('home/success/'.$order_no), // Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
            'cancelurl' => site_url('home/cancel'), // Required.  URL to which the customer will be returned if they cancel payment on PayPal's site.
            'hdrimg' => base_url('assets/images/Logo_Vaskia.png'), // URL for the image displayed as the header during checkout.  Max size of 750x90.  Should be stored on an https:// server or you'll get a warning message in the browser.
            'logoimg' => base_url('assets/images/Logo_Vaskia.png'), // A URL to your logo image.  Formats:  .gif, .jpg, .png.  190x60.  PayPal places your logo image at the top of the cart review area.  This logo needs to be stored on a https:// server.
            'brandname' => 'Vaskia Fine Italian Jewelry', // A label that overrides the business name in the PayPal account on the PayPal hosted checkout pages.  127 char max.
            'customerservicenumber' => '816-555-5555', // Merchant Customer Service number displayed on the PayPal Review page. 16 char max.
        );

        /**
         * Now we begin setting up our payment(s).
         *
         * Express Checkout includes the ability to setup parallel payments,
         * so we have to populate our $Payments array here accordingly.
         *
         * For this sample (and in most use cases) we only need a single payment,
         * but we still have to populate $Payments with a single $Payment array.
         *
         * Once again, the template file includes a lot more available parameters,
         * but for this basic sample we've removed everything that we're not using,
         * so all we have is an amount.
         */
        $Payments = array();
        $Payment  = array(
            'amt' => $total_amount, // Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
            'shiptoname' => '', // Required if shipping is included.  Person's name associated with this address.  32 char max.
            'shiptostreet' => '', // Required if shipping is included.  First street address.  100 char max.
            'shiptostreet2' => '', // Second street address.  100 char max.
            'shiptocity' => '', // Required if shipping is included.  Name of city.  40 char max.
            'shiptostate' => '', // Required if shipping is included.  Name of state or province.  40 char max.
            'shiptozip' => '', // Required if shipping is included.  Postal code of shipping address.  20 char max.
            'shiptophonenum' => ''      // Phone number for shipping address.  20 char max.
        );

        /**
         * Here we push our single $Payment into our $Payments array.
         */
        array_push($Payments, $Payment);

        /**
         * Now we gather all of the arrays above into a single array.
         */
        $PayPalRequestData = array(
            'SECFields' => $SECFields,
            'Payments' => $Payments,
        );

        /**
         * Here we are making the call to the SetExpressCheckout function in the library,
         * and we're passing in our $PayPalRequestData that we just set above.
         */
        $PayPalResult = $this->paypal_pro->SetExpressCheckout($PayPalRequestData);

        /**
         * Now we'll check for any errors returned by PayPal, and if we get an error,
         * we'll save the error details to a session and redirect the user to an
         * error page to display it accordingly.
         *
         * If all goes well, we save our token in a session variable so that it's
         * readily available for us later, and then redirect the user to PayPal
         * using the REDIRECTURL returned by the SetExpressCheckout() function.
         */
        if (!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK'])) {
            $errors = array('Errors' => $PayPalResult['ERRORS']);

            // Load errors to variable
            $this->load->vars('errors', $errors);

            $this->load->view('paypal/demos/express_checkout/paypal_error');
        } else {
            // Successful call.
            // Set PayPalResult into session userdata (so we can grab data from it later on a 'payment complete' page)
            $this->session->set_userdata('PayPalResult', $PayPalResult);

            // In most cases you would automatically redirect to the returned 'RedirectURL' by using: redirect($PayPalResult['REDIRECTURL'],'Location');
            // Move to PayPal checkout
            redirect($PayPalResult['REDIRECTURL'], 'Location');
        }
    }

    public function success($order_number)
    {
//        $PayPal_Token = $SetExpressCheckoutPayPalResult['TOKEN'];

        /**
         * Now we pass the PayPal token that we saved to a session variable
         * in the SetExpressCheckout.php file into the GetExpressCheckoutDetails
         * request.
         */
        $SetExpressCheckoutPayPalResult = $this->session->userdata('PayPalResult');
        $PayPal_Token                   = $SetExpressCheckoutPayPalResult['TOKEN'];
        $PayPalResult                   = $this->paypal_pro->GetExpressCheckoutDetails($PayPal_Token);
        if (!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK'])) {

        } else {
//            $order_number = $this->flexi_cart->order_number();
            $user_id               = $this->session->userdata('user_id');
            $dataPayment           = array(
                'user_id' => $user_id,
                'txn_id' => $PayPalResult['PAYERID'],
                'payment_gross' => $PayPalResult['AMT'],
                'currency_code' => $PayPalResult['CURRENCYCODE'],
                'payment_status' => $PayPalResult['ACK'],
                'order_no' => $order_number,
                'payment_via' => 'Paypal',
            );
            $this->common_model->insertRow($dataPayment, 'payments');
            $this->common_model->updateRow('order_summary',
                array('ord_status' => 2),
                array('ord_order_number' => $order_number));
            /* Email to admin for order confirmatin */
            $edata['item_data']    = $this->common_model->getRecords('order_details',
                '*', array('ord_det_order_number_fk' => $order_number));
            $edata['summary_data'] = $this->common_model->getRecords('order_summary',
                '*', array('ord_order_number' => $order_number));
            $this->updateQuantity($order_number);

            $edata['order_no'] = $order_number;
			
			foreach ($edata['item_data'] as $key => $value) {
                $edata['item_data'][$key]['product_images'] = $this->common_model->getRecords('it_products_image',
                    'url', array('product_id' => $value['ord_det_item_fk']));
            }
			
            $html              = $this->load->view('email_templates/order_confirmation_admin',
                $edata, true);
            $html1             = $this->load->view('email_templates/order_confirmation_customer',
                $edata, true);
            $mail              = $this->common_model->sendEmail(config_item('admin_email'),
                array("email" => config_item('site_email'), "name" => 'Vaskia'),
                'New order placed', $html);
            $mail1             = $this->common_model->sendEmail($edata['summary_data'][0]['ord_demo_email'],
                array("email" => config_item('site_email'), "name" => config_item('website_name')),
                'Order Confirmed', $html1);

            /* Update coupon applied code status and amount start here   */
            $coupon_code_price  = $this->session->userdata('coupon_code_price');
            $coupon_name        = $this->session->userdata('coupon_name');
            $arr_coupon_details = $this->common_model->getRecords('discounts',
                'disc_code,disc_id', array("disc_code" => $coupon_name));
            if ($coupon_code_price > 0 && $user_id != '' && $coupon_name != '' && count($arr_coupon_details)
                > 0) {

                $arr_to_insert          = array(
                    "coupon_name" => $coupon_name,
                    "disc_id_fk" => $arr_coupon_details[0]['disc_id'],
                    "user_id_fk" => $user_id,
                    "coupon_amount" => $coupon_code_price,
                    "created" => date("Y-m-d H:i:s"),
                );
                //echo '<pre>';print_r($arr_to_insert);die;
                $last_coupon_applied_id = $this->common_model->insertRow($arr_to_insert,
                    "coupon_applied_details");
            }

            $coupon_code_use_limit      = $this->session->userdata('coupon_code_use_limit');
            $coupon_code_use_limit_name = $this->session->userdata('coupon_code_use_limit_name');
            $coupon_name                = $this->session->userdata('coupon_name');
            if ($coupon_name != '') {
                $arr_coupon_details_use_limit = $this->common_model->getRecords('discounts',
                    'disc_code,disc_id,disc_usage_limit',
                    array("disc_code" => $coupon_name));
                if (count($arr_coupon_details_use_limit) > 0) {
                    $limit       = $arr_coupon_details_use_limit[0]['disc_usage_limit']
                        - 1;
                    $update_data = array(
                        "disc_usage_limit" => $limit,
                    );

                    $condition_to_pass = array("disc_code" => $coupon_name);
                    $last_update_id    = $this->common_model->updateRow('discounts',
                        $update_data, $condition_to_pass);
                }
            }
            $this->flexi_cart->destroy_cart();
            $this->session->unset_userdata('coupon_code_use_limit');
            $this->session->unset_userdata('coupon_code_use_limit_name');

            $this->session->unset_userdata('coupon_code_price');
            $this->session->unset_userdata('coupon_name');
            $this->session->unset_userdata('coupons_use_limit');
            $this->flexi_cart->unset_discount();
            /* Update coupon applied code status and amount end here   */

            redirect(base_url().'admin_library/order_details/'.$order_number);
        }
    }

    public function cancel()
    {

        redirect('home/checkout/cancel');
    }

    function stripePaySubmit()
{
    if (empty($this->flexi_cart->cart_items())) {
        echo json_encode(array('status' => 700, 'error' => 'Your cart is empty'));
        exit();
    }
    if (!$this->ion_auth->logged_in()) {
        echo json_encode(array('status' => 700, 'error' => 'You have been logged out.Please login to continue.'));
        exit();
    }
    $stockcheck = $this->validateStock();
    if ($stockcheck == false) {
        echo json_encode(array('status' => 700, 'error' => 'Sorry for inconvenience, your some product is out of stock so please place order in advance or remove product then try,thank you.'));
        exit();
    }
    $stockerror = $this->validateStockForNonAdvance();
    if ($stockerror['out_of_stock'] == 1 && $stockerror['in_stock'] == 1) {
//            $this->session->set_flashdata('stock_error1', $stockerror);
            // redirect(base_url() . "home/cart");
        echo json_encode(array('status' => 700, 'error' => 'Sorry for inconvenience, your some product is out of stock so please place order in advance or remove product then try,thank you.'));
        exit();
    }


    $discounts      = $this->flexi_cart->summary_discount_data();
    $tax_total      = $this->session->userdata('tax_total');
    $shipping_total = $this->session->userdata('shipping_total');

    if (!empty($discounts['total']['value'])) {

        $total = ($this->data['cart_summary']['item_summary_total'] + $shipping_total
            + $tax_total) - str_replace('US $', ' ',
            $discounts['total']['value']);
        } else {

            $total = $this->data['cart_summary']['item_summary_total'] + $shipping_total
            + $tax_total;
        }
        $total_new = round($total);
        
        $this->load->library('authorize_net');
        $checkout_data = $this->session->userdata('checkout_data');
        
        $auth_net = array(
            'x_card_num'            => $this->input->post('credit_number'),
            'x_exp_date'            => $this->input->post('exp_month')."/".$this->input->post('exp_year'),
            'x_card_code'           => $this->input->post('security_code'),
            'x_description'         => '',
            'x_company'             => $checkout_data['checkout']['billing']['company'],
            'x_amount'              => $total_new,
            'x_first_name'          => $checkout_data['checkout']['billing']['name'],
            'x_last_name'           => '',
            'x_address'             => $checkout_data['checkout']['billing']['add_01']." ".$checkout_data['checkout']['billing']['add_02'],
            'x_city'                => $checkout_data['checkout']['billing']['city'],
            'x_state'               => $checkout_data['checkout']['billing']['state'],
            'x_zip'                 => $checkout_data['checkout']['billing']['post_code'],
            'x_country'             => $checkout_data['checkout']['billing']['country'],
            'x_phone'               => $checkout_data['checkout']['phone'],
            'x_email'               => $checkout_data['checkout']['email'],
            'x_customer_ip'         => $this->input->ip_address(),
            'x_ship_to_first_name'         => $checkout_data['checkout']['shipping']['name'],
            'x_ship_to_last_name'         => '',
            'x_ship_to_company'         => $checkout_data['checkout']['shipping']['company'],
            'x_ship_to_address'         => $checkout_data['checkout']['shipping']['add_01']." ".$checkout_data['checkout']['shipping']['add_02'],
            'x_ship_to_zip'         => $checkout_data['checkout']['shipping']['post_code'],
            'x_ship_to_city'         => $checkout_data['checkout']['shipping']['city'],
            'x_ship_to_state'         => $checkout_data['checkout']['shipping']['state'],
            'x_ship_to_country'         => $checkout_data['checkout']['shipping']['country'],
            'x_invoice_num_val'         => $this->flexi_cart->order_number(),
            
        );
        $this->authorize_net->setData($auth_net);

        if($this->authorize_net->authorizeAndCapture())
        {
            // print_r($this->authorize_net->debug());
            // die;
            $user_id                 = $this->session->userdata('user_id');
            $dataPayment             = array(
                'user_id' => $user_id,
                'txn_id' => $this->authorize_net->getTransactionId(),
                'payment_gross' => $total_new,
                'currency_code' => 'USD',
                'payment_status' => 'Success',
                'payment_via' => 'Authorize',
                'payment_date' => date("Y-m-d h:i:s"),
            );
            $dataPayment['order_no'] = $this->flexi_cart->order_number();
            $order_no                = $this->flexi_cart->order_number();
            /* update quantity of the product */
            $this->common_model->updateRow('order_summary',
                array('ord_status' => 2), array('ord_order_number' => $order_no));
            $this->updateQuantity($order_no);
            $this->payment->insert($dataPayment);
            /* Email to admin for order confirmatin */
            $edata['item_data']      = $this->common_model->getRecords('order_details',
                '*', array('ord_det_order_number_fk' => $order_no));
            $edata['summary_data']   = $this->common_model->getRecords('order_summary',
                '*', array('ord_order_number' => $order_no));
            foreach ($edata['item_data'] as $key => $value) {
                $edata['item_data'][$key]['product_images'] = $this->common_model->getRecords('it_products_image',
                    'url', array('product_id' => $value['ord_det_item_fk']));
            }

            $edata['order_no'] = $order_no;
            $html              = $this->load->view('email_templates/order_confirmation_admin',
                $edata, TRUE);
            $html1             = $this->load->view('email_templates/order_confirmation_customer',
                $edata, TRUE);


            $mail  = $this->common_model->sendEmail(config_item('admin_email'),
                array("email" => config_item('site_email'), "name" => config_item('website_name')),
                'New order placed', $html);
            $mail1 = $this->common_model->sendEmail($edata['summary_data'][0]['ord_demo_email'],
                array("email" => config_item('site_email'), "name" => 'Vaskia'),
                'Order confirmed', $html1);

            /* */
            $this->flexi_cart->destroy_cart();

            if ($dataPayment) {
                /* Update coupon applied code status and amount start here   */
                $coupon_code_price  = $this->session->userdata('coupon_code_price');
                $coupon_name        = $this->session->userdata('coupon_name');
                $arr_coupon_details = $this->common_model->getRecords('discounts',
                    'disc_code,disc_id', array("disc_code" => $coupon_name));
                if ($coupon_code_price > 0 && $user_id != '' && $coupon_name != ''
                    && count($arr_coupon_details) > 0) {

                    $arr_to_insert          = array(
                        "coupon_name" => $coupon_name,
                        "disc_id_fk" => $arr_coupon_details[0]['disc_id'],
                        "user_id_fk" => $user_id,
                        "coupon_amount" => $coupon_code_price,
                        "created" => date("Y-m-d H:i:s"),
                    );
                $last_coupon_applied_id = $this->common_model->insertRow($arr_to_insert,
                    "coupon_applied_details");
            }
            $coupon_name                = $this->session->userdata('coupon_name');
            $coupon_code_use_limit_name = $this->session->userdata('coupon_code_use_limit_name');
            if ($coupon_name != '') {
                $arr_coupon_details_use_limit = $this->common_model->getRecords('discounts',
                    'disc_code,disc_id,disc_usage_limit',
                    array("disc_code" => $coupon_name));
                if (count($arr_coupon_details_use_limit) > 0) {
                    $limit             = $arr_coupon_details_use_limit[0]['disc_usage_limit']
                    - 1;
                    $update_data       = array(
                        "disc_usage_limit" => $limit,
                    );
                    $condition_to_pass = array("disc_code" => $coupon_name);
                    $last_update_id    = $this->common_model->updateRow('discounts',
                        $update_data, $condition_to_pass);
                }
            }
            $this->session->unset_userdata('coupon_code_use_limit');
            $this->session->unset_userdata('coupon_code_use_limit_name');

            $this->session->unset_userdata('coupon_code_price');
            $this->session->unset_userdata('coupon_name');
            $this->session->unset_userdata('coupons_use_limit');
            $this->session->unset_userdata('checkout_data');
            $this->flexi_cart->unset_discount();
            /* Update coupon applied code status and amount end here   */
            echo json_encode(array('status' => 200, 'success' => 'Payment successfull. We have recieved your order. Details are send to your email id.'));

            exit();
        }
    }else{
       echo json_encode(array('status' => 201, 'error' => $this->authorize_net->getError()));

       exit();
   }


}

    public function orders()
    {



        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page

            redirect('auth/login', 'refresh');
        }

        $user_id                    = $this->session->userdata('user_id');
        $this->data['dataHeader']   = $this->users->get_allData($user_id);
        $this->data['cart_items']   = $this->flexi_cart->cart_items();
        $this->data['country_list'] = (array('' => 'Select Country')) + $this->country->dropdown('countryname');
        $this->data['state_list']   = (array('' => 'Select State')) + $this->state->dropdown('statename');
        $this->data['my_orders']    = $this->orders_summary->get_by_id($user_id);
//        echo '<pre>', print_r($this->data['my_orders']);die;

        $this->data          = $this->_get_all_data();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'orders', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '',
            TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function wishlist()
    {
        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page

            redirect(base_url().'home/login', 'refresh');
        }

        $user_id                       = $this->session->userdata('user_id');
        $this->data['dataHeader']      = $this->users->get_allData($user_id);
        $list                          = $this->wishlist_model->get_list($user_id);
        $this->data['product_details'] = $list;
        $id                            = null;
        foreach ($list as $key => $pid) {
            $this->data['product_details'][$key]['product_name']           = $this->product->as_array()->get($pid['product_id']);
            $this->data['product_details'][$key]['product_attr_details']   = $this->product_attribute->as_array()->get_by_id($pid['product_id']);
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($pid['product_id']);
        }
        $this->data['product_details_tes'] = $this->data['product_details'];
        $this->data['pages']               = $this->pages_model->as_array()->get_all();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', '_wish_list', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '',
            TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function getProducts()
    {
        $product_details = $this->product->get_products_by_limit($this->input->post('cat_id'),
            '4');
        if (!empty($product_details)) {
            $out  = '';
            $out1 = '';
            foreach ($product_details as $key => $value) {
                $product_images_details = $this->product_images->as_array()->get_by_id($value['id']);
                $out                    .= '<li class="product-item style3 mobile-slide-item col-sm-4 col-md-3">
                    <div class="product-inner">
                        <div class="product-thumb has-back-image">
                            <a href="'.base_url().'home/shop_product/'.$value['id'].'/'.$value['category_id'].'"><img src="'.base_url($product_images_details[0]['url']).'" alt=""></a>
                            <a class="back-image" href="'.base_url().'home/shop_product/'.$value['id'].'/'.$value['category_id'].'"><img src="'.base_url($product_images_details[0]['hover_img_url']).'" alt=""></a>
                            <div class="col-md-8">
                                <div class="product-info"><div class="">
                                        <h2 class="product-name"><a href="'.base_url().'home/shop_product/'.$value['id'].'/'.$value['category_id'].'">'.$value['product_name'].'</a></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="clearfix"></div>
                                <div class="pricing_grid">
                                    <h5 class="item-price">$'.$value['price'].'</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>';
            }
        } else {
            echo "<h4>No products fround in the category</h4>";
        }
        $out1 = '<div style="text-align: center;"><a class="button-loadmore loadmore" id="loadmore"  data-service="'.$this->input->post('cat_id').'" data-page="'.($this->input->post('page')
            + 1 ).'">Load more</a></div>';
        echo json_encode(array('out' => $out, "out1" => $out1));
    }

    public function loadMoreProducts()
    {

        if (isset($_POST['page'])):
            $paged          = $_POST['page'];
            $total_page     = $_POST['total_page'];
            $resultsPerPage = 4;
             if($_POST['sub_cat_id'] == 39){
                 $order = "ORDER BY `initial_letter` ASC";
            }else{
                $order = "ORDER BY `id` DESC";

            }

            if ($_POST['cat_id'] == 'all') {

                $sql = "SELECT * FROM it_products where isactive='0' AND price > 0 group by product_name ".$order;
            } else if ($_POST['cat_id'] != '' && $_POST['sub_cat_id'] != '' && $_POST['subcatThird']
                != '') {
                $category_id        = $_POST['cat_id'];
                $sub_category_id    = $_POST['sub_cat_id'];
                $third_sub_category = $_POST['subcatThird'];

                $sql = "SELECT ip.* FROM it_products as ip left JOIN  it_product_attributes   ipa  ON  ipa.product_id  = ip.id  where isactive='0' AND ip.price > 0 and FIND_IN_SET('$category_id',ip.category_id) AND FIND_IN_SET('$sub_category_id',ip.sub_category_id) and FIND_IN_SET('$third_sub_category',ip.sub_attribute_id_new)   group by ip.product_name  ".$order;
            } else if ($_POST['cat_id'] != '' && $_POST['sub_cat_id'] != '') {
                $category_id     = $_POST['cat_id'];
                $sub_category_id = $_POST['sub_cat_id'];
                $sql             = "SELECT ip.* FROM it_products as ip left JOIN  it_product_attributes   ipa  ON  ipa.product_id  = ip.id  where isactive='0' AND ip.price > 0 and FIND_IN_SET('$category_id',ip.category_id) AND FIND_IN_SET('$sub_category_id',ip.sub_category_id)  group by ip.product_name  ".$order;
            } else {
                $category_id = $_POST['cat_id'];
                $sql         = "SELECT ip.* FROM it_products as ip left JOIN  it_product_attributes   ipa  ON  ipa.product_id  = ip.id  where isactive='0' AND ip.price > 0 and FIND_IN_SET('$category_id',ip.category_id) group by ip.product_name  ".$order;
            }
            $query3          = $this->db->query($sql);
            $total_available = $query3->num_rows();

            $total_available_main = $total_available - ($paged * 12);


            $page_limit         = $_POST['page_limit'];
            $pagination_sql     = " LIMIT  $page_limit,$total_page";
//            $pagination_sql     = " LIMIT  $page_limit,$total_page";
            $new_limit          = $total_page + $page_limit;
            $page_limit_new     = $page_limit + $page_limit;
            $pagination_sql_new = " LIMIT  $page_limit_new,$new_limit";

            $query           = $this->db->query($sql.$pagination_sql);
            $query2          = $this->db->query($sql.$pagination_sql_new);
            $total_available = $query2->num_rows();
            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $value) {
                    $product_images_details = $this->product_images->as_array()->get_by_id($value['id']);
                    ?>

                    <li class="product-item style3 mobile-slide-item col-sm-4 col-md-3">
                        <div class="product-inner">
                            <div class="product-thumb has-back-image">
                                <?php
                                if ($value['quantity'] <= 0) {
                                    ?>
                                    <div class="status">
                                        <span class="onsale">
                                            <?php if($value['back_order_flag']=='yes'){?>
                                            <span class="text">Out Of Stock!<br> Pre-Order Now</span>
                                            <?php }else{?>
                                            <span class="text">Out Of Stock!</span>
                                            <?php }?>
                                        </span>
                                    </div>
                                <?php } ?>
                                <?php
                                if ($value['quantity'] <= 5 && $value['quantity']
                                    > 0) {
                                    ?>
                                    <div class="status">
                                        <span class="onsale">
                                            <span class="text"><?php echo $value['quantity'] ?> Available</span>
                                        </span>
                                    </div>
                                    <?php } ?>
                                <a href="<?php echo base_url() ?>home/shop_product/<?php echo $value['id'] ?>/<?php echo base64_encode($value['category_id']) ?>">
                                    <img src="<?php
                                    echo ($product_images_details[0]['url'] == '')
                                            ? base_url('assets/images/product-no-image2.jpg')
                                            : base_url($product_images_details[0]['url'])
                                    ?>" alt="">
                                </a>
                                <a class="back-image" href="<?php echo base_url() ?>home/shop_product/<?php echo $value['id'] ?>/<?php echo base64_encode($value['category_id']); ?>"><img src="<?php echo base_url($product_images_details[0]['hover_img_url']) ?>" alt=""></a>
                                <div class="col-md-12 text-center no-padding">
                                    <div class="product-info">
                                        <div class="">
                                            <h2 class="product-name"><a href="<?php echo base_url() ?>home/shop_product/<?php echo $value['id'] ?>/<?php echo base64_encode($value['category_id']); ?>"><?php echo $value['product_name'] ?></a></h2>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12 text-center">
                                    <div class="clearfix"></div>
                                    <div class="pricing_grid">
                                        <h5 class="item-price">
                                            <?php
                                            if (isset($value['discounted_price'])
                                                && $value['discounted_price'] != NULL) {
                                                ?>
                                                $<?php
                                                echo number_format(floatval($value['price'])
                                                    - floatval($value['discounted_price']),
                                                    2);
                                                ?>
                                                <del>$<?php echo number_format($value['price'], 2); ?></del>

                                            <?php } else { ?>
                                                $<?php echo $value['price']; ?>
                    <?php } ?>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                }
            }
            if ($total_available_main > 0) {
                ?>
                <div style="text-align: center;"><a class="button-loadmore loadmore" id="loadmore"  data-service="<?php echo $_POST['cat_id'] ?>" data-page="<?php
                    echo $paged + 1;
                    ?>">Load more</a></div>
                    <?php
                } else {
                    echo "<div style='clear:both;margin:20px'></div> <div  class='loadbutton'><h3 style='text-align: center;margin-top: 40px;'>No More Products</h3></li>";
                }
            endif;
        }

        public function loadMoreProductsFilter()
        {

            if (isset($_POST['page'])):
                $paged          = $_POST['page'];
                $total_page     = $_POST['total_page'];
                $resultsPerPage = 12;
                $min_price      = $_POST['min_price'];
                $max_price      = $_POST['max_price'];
                $range          = $min_price.' AND '.$max_price;
                if ($_POST['order'] != '') {
                    $order = $_POST['order'];
                } else {
                    $order = 'DESC';
                }
                if ($_POST['cat_id'] == 'all') {
                    $sql = "SELECT * FROM it_products where isactive='0' AND price > 0 group by product_name ORDER BY `id` DESC";
                } else if ($_POST['cat_id'] != '' && $_POST['sub_cat_id'] != '' && $_POST['subcatThird']
                    != '') {
                    $category_id        = $_POST['cat_id'];
                    $sub_category_id    = $_POST['sub_cat_id'];
                    $third_sub_category = $_POST['subcatThird'];
                    $sql                = "SELECT ip.* FROM it_products as ip left JOIN  it_product_attributes   ipa  ON  ipa.product_id  = ip.id  where isactive='0' AND ip.price > 0 and FIND_IN_SET('$category_id',ip.category_id) AND FIND_IN_SET('$sub_category_id',ip.sub_category_id) and FIND_IN_SET('$third_sub_category',ip.sub_attribute_id_new) and ip.price BETWEEN $range  group by ip.product_name  ORDER BY ip.price $order ";
                } else if ($_POST['cat_id'] != '' && $_POST['sub_cat_id'] != '') {
                    $category_id     = $_POST['cat_id'];
                    $sub_category_id = $_POST['sub_cat_id'];
                    $sql             = "SELECT ip.* FROM it_products as ip left JOIN  it_product_attributes   ipa  ON  ipa.product_id  = ip.id  where isactive='0' AND ip.price > 0  and FIND_IN_SET('$category_id',ip.category_id) AND FIND_IN_SET('$sub_category_id',ip.sub_category_id) and ip.price BETWEEN $range  group by ip.product_name  ORDER BY ip.price $order ";
                } else {
                    $category_id = $_POST['cat_id'];
                    $sql         = "SELECT ip.* FROM it_products as ip left JOIN  it_product_attributes   ipa  ON  ipa.product_id  = ip.id  where isactive='0' AND ip.price > 0 and FIND_IN_SET('$category_id',ip.category_id) and ip.price BETWEEN $range group by ip.product_name  ORDER BY ip.price $order ";
                }
                $page_limit = $_POST['page_limit']; 
//            $pagination_sql = " LIMIT  $page_limit,$total_page";
//            $pagination_sql = " LIMIT  $page_limit,$total_page";
//            $new_limit = $total_page + $page_limit;
//            $page_limit_new = $page_limit + $page_limit;
//            $pagination_sql_new = " LIMIT  $page_limit_new,$new_limit";

                if ($paged > 0) {
                    $page_limit     = $resultsPerPage * ($paged);
                    $pagination_sql = " LIMIT  $page_limit,$resultsPerPage";
                } else {
                    $pagination_sql = " LIMIT 0 , $resultsPerPage";
                }

                $query           = $this->db->query($sql.$pagination_sql);
//            $query2 = $this->db->query($sql . $pagination_sql_new);
                $total_available = $query->num_rows();




                if ($query->num_rows() > 0) {
                    foreach ($query->result_array() as $key => $value) {
                        $product_images_details = $this->product_images->as_array()->get_by_id($value['id']);
                        ?>

                    <li class="product-item style3 mobile-slide-item col-sm-4 col-md-3">
                        <div class="product-inner">
                            <div class="product-thumb has-back-image">
                                <?php
                                if ($value['quantity'] <= 0) {
                                    ?>
                                    <div class="status">
                                        <span class="onsale">
                                            <?php if($value['back_order_flag']=='yes'){?>
                                            <span class="text">Out Of Stock!<br> Pre-Order Now</span>
                                            <?php }else{?>
                                            <span class="text">Out Of Stock!</span>
                                            <?php }?>
                                        </span>
                                    </div>
                                <?php } ?>
                                <?php
                                if ($value['quantity'] <= 5 && $value['quantity']
                                    > 0) {
                                    ?>
                                    <div class="status">
                                        <span class="onsale">
                                            <span class="text"><?php echo $value['quantity'] ?> Available</span>
                                        </span>
                                    </div>
                                    <?php } ?>
                                <a href="<?php echo base_url() ?>home/shop_product/<?php echo $value['id'] ?>/<?php echo base64_encode($value['category_id']) ?>">
                                    <img src="<?php
                                    echo ($product_images_details[0]['url'] == '')
                                            ? base_url('assets/images/product-no-image2.jpg')
                                            : base_url($product_images_details[0]['url'])
                                    ?>" alt="">
                                </a>
                                <a class="back-image" href="<?php echo base_url() ?>home/shop_product/<?php echo $value['id'] ?>/<?php echo base64_encode($value['category_id']); ?>"><img src="<?php echo base_url($product_images_details[0]['hover_img_url']) ?>" alt=""></a>
                                <div class="col-md-12 text-center no-padding">
                                    <div class="product-info">
                                        <div class="">
                                            <h2 class="product-name"><a href="<?php echo base_url() ?>home/shop_product/<?php echo $value['id'] ?>/<?php echo base64_encode($value['category_id']); ?>"><?php echo $value['product_name'] ?></a></h2>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12 text-center">
                                    <div class="clearfix"></div>
                                    <div class="pricing_grid">
                                        <h5 class="item-price">
                                            <?php
                                            if (isset($value['discounted_price'])
                                                && $value['discounted_price'] != NULL) {
                                                ?>
                                                $<?php
                                                echo number_format(floatval($value['price'])
                                                    - floatval($value['discounted_price']),
                                                    2);
                                                ?>
                                                <del>$<?php echo number_format($value['price'], 2); ?></del>

                                            <?php } else { ?>
                                                $<?php echo $value['price']; ?>
                    <?php } ?>
                                        </h5>
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
                <div style="text-align: center;"><a class="button-loadmore loadmore_filter" id="loadmore_filter"  data-service_filter="<?php echo $_POST['cat_id'] ?>" data-page="<?php
                    echo $paged + 1;
                    ?>">Load more</a></div>
                    <?php
                } else {
                    echo "<div style='clear:both;margin:20px'></div> <div  class='loadbutton'><h3 style='text-align: center;margin-top: 40px;'>No More Products</h3></li>";
                }
            endif;
        }

        public function filterProducts()
        {
            $min_price = $this->input->post('min_price');
            $max_price = $this->input->post('max_price');
            $category  = $this->input->post('category');
            $subcat    = $this->input->post('sub_category');

            $subcatThird                   = $this->input->post('sub_category_third');
            $order                         = $this->input->post('order');
            $range                         = $min_price.' AND '.$max_price;
            $data['catid']                 = $category;
            $data['sub_category_ids']      = $subcat;
            $data['page_limit']            = 12;
            $data['total_product_details'] = $this->product->get_product_by_category_id($category,
                $subcat, 0, 300000, '', $subcatThird);
            $data['product_details']       = $this->product->filter_products($category,
                $range, $subcat, 0, 12, $subcatThird, $order);

            $product_data = $this->load->view('_product_filter', $data, TRUE);
            echo json_encode(array('status' => 200, 'data' => $product_data));
        }

        public function email($email, $message, $subject)
        {

            $config['protocol']  = 'smtp';
            $config['smtp_host'] = 'ssl://smtp.googlemail.com'; //smtp host name
            $config['smtp_port'] = '465'; //smtp port number
            $config['smtp_user'] = 'ttire688';
            $config['smtp_pass'] = 'email1234'; //$from_email password
            $config['mailtype']  = 'html';
            $config['charset']   = 'iso-8859-1';
            $config['wordwrap']  = TRUE;
            $config['newline']   = "\r\n"; //use double quotes
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->set_crlf("\r\n");
            $this->email->from('ttire688'); // change it to yours
            $this->email->to($email); // change it to yours
            $this->email->subject($subject);
            $this->email->message($message);
            return $this->email->send();
        }

        public function shareWishList()
        {
            $user_id                  = $this->session->userdata('user_id');
            $this->data['dataHeader'] = $this->users->get_allData($user_id);
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="label-error">',
                '</span>');
            $this->form_validation->set_rules('email[]', 'Email',
                'trim|required|valid_email');
            if ($this->form_validation->run() == TRUE) {
                foreach ($this->input->post('email') as $key => $email) {
                    $user['email']        = $email;
                    $user['user_id']      = $user_id;
                    $user['created_time'] = date("Y-m-d H:i:s");

                    $this->common_model->insertRow($user, 'tbl_share_wishlist');

                    $link = base_url()."home/refWishList/".$user_id;
                    //$msg = "Dear Customer, <br> " . $this->data['dataHeader']['first_name'] . " " . $this->data['dataHeader']['last_name'] . " has shared his wishlist with you. Click on below link to shop with us.<br><br>" . $link . "<br><br>Thanks Team,<br>Vaskia";



                    $edata['link']       = $link;
                    $edata['dataHeader'] = $this->data['dataHeader'];
                    $html                = $this->load->view('email_templates/share-wishlist',
                        $edata, true);
                    $mail                = $this->common_model->sendEmail($email,
                        array("email" => config_item('site_email'), "name" => config_item('website_name')),
                        $this->data['dataHeader']['first_name']." ".$this->data['dataHeader']['last_name'].' has shared his wishlist with you',
                        $html);





                    //  $mail = $this->common_model->sendEmail($email, array("email" => config_item('site_email'), "name" => 'Vaskia'), $this->data['dataHeader']['first_name'] . " " . $this->data['dataHeader']['last_name'] . ' has shared his wishlist with you', $msg);
                }
                $response['status'] = '1';
                $response['msg']    = 'Wishlist shared successfully.';
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

        public function refWishList($id)
        {
            $this->load->library('flexi_cart');
            $products = $this->common_model->getRecords('product_wish_list',
                '*', array('user_id' => $id));

            $this->load->model('demo_cart_model');

            foreach ($products as $key => $product) {

                $product_detail = $this->common_model->getRecords('it_products',
                    '*', array('id' => $product['product_id']));

                $product_images_details = $this->product_images->as_array()->get_by_id($product[0]['id']);
                ###+++++++++++++++++++++++++++++++++###
                if (isset($_SESSION['flexi_cart'])) {
                    $this->data = $_SESSION['flexi_cart'];
                }
                if ($product_detail[0]['isactive'] == 0 && count($product_detail)
                    > 0) {
                    $cart_data = array(
                        'id' => $product_detail[0]['id'],
                        'name' => $product_detail[0]['product_name'],
                        'quantity' => 1,
                        'stock_quantity' => $product_detail[0]['quantity'],
                        'price' => $product_detail[0]['price'],
                        'item_url' => $product_images_details[0]['url'],
                        'options' => array(
                            'Prebook' => FALSE,
                            'Initial' => '',
                            'Color' => '',
                        ),
                    );
                    //echo '<pre>';print_R($cart_data);die;
                    // Insert collected data to cart.
                    if (!empty($cart_data)) {
                        $this->flexi_cart->insert_items($cart_data);
                    }
                }
            }
//        echo "<pre>";
//        print_r($this->flexi_cart->cart_items());
//        die;

            redirect(base_url().'home/cart');
        }

        public function instagramImage()
        {
            $conditions_to_pass = "initial_letter != '' AND initial_color != '' AND initial_mm != '' AND isactive='0' AND price > 0";
        $arr_inicial_product_details = $this->common_model->getRecords('it_products',
                'id,category_id,product_name,quantity,price,discounted_price,product_sku,initial_letter,initial_color,initial_mm', $conditions_to_pass,'id DESC');
       
            
            $image        = trim($this->input->post('image'));
            $arr_image    = explode('//', $image);
            $arr_products = $this->common_model->getRecords('it_products', 'id',
                array('is_instagram_product' => '1', 'instagram_image' => $arr_image[1]));
            if ($image != '' && count($arr_products) > 0) {
                $user_id                = $this->session->userdata('user_id');
                $produictId             = $arr_products[0]['id'];
                $check                  = $this->review_model->check_review_product($produictId,
                    $user_id);
                $product_details        = $this->product->get_product_by_product_id($produictId);
                $group_variant_products = $this->product->getGroupProducts($product_details[0]['product_name']);
                ?>
            <form class="cart" id='cart_instagram' name='cart_instagram' enctype="multipart/form-data" method="post">

                <input type="hidden" id="user_id_insta" name="user_id_insta" value="<?php
                echo $user_id                = $this->session->userdata('user_id');
                ?>"/>

                <input type="hidden" id="item_id_insta_<?php echo $product_details[0]['id'] ?>" name="item_id_insta" value="<?php echo $product_details[0]['id'] ?>"/>

                <input type="hidden" id="name_insta_<?php echo $product_details[0]['id'] ?>" name="name_insta" value="<?php echo $product_details[0]['product_name'] ?>"/>

            <?php
            if (isset($product_details[0]['discounted_price']) && !empty($product_details[0]['discounted_price'])) {
                ?>

                    <input type="hidden" id="price_insta_<?php echo $product_details[0]['id'] ?>" name="price_insta" value="<?php
                echo floatval($product_details[0]['price']) - floatval($product_details[0]['discounted_price'])
                ?>"/>



                <?php } else { ?>

                    <input type="hidden" id="price_insta_<?php echo $product_details[0]['id'] ?>" name="price_insta" value="<?php echo $product_details[0]['price'] ?>"/>

            <?php } ?>

                <input type="hidden" id="img_url_insta_<?php echo $product_details[0]['id'] ?>" name="img_url_insta" value="<?php echo $product_details[0]['url'] ?>"/>

                <input type="hidden" id="stock_insta_<?php echo $product_details[0]['id'] ?>" name="stock_insta" value="<?php echo $product_details[0]['quantity'] ?>"/>





                <div class="col-md-6 product_img">
                    <img src="<?php echo $image; ?>" class="img-responsive">
                </div>
                <div class="col-md-6 product_content">
                    <h4><span><?php echo $product_details[0]['product_name']; ?></span></h4>

                    <p><?php echo $product_details[0]['description']; ?></p>

                    <h3 class="cost">
                        <?php
                        if (isset($product_details[0]['discounted_price']) && $product_details[0]['discounted_price']
                            != NULL) {
                            ?>
                            <ins style="text-decoration:none">$<?php
                                echo number_format(($product_details[0]['price']
                                    - $product_details[0]['discounted_price']),
                                    2);
                                ?></ins> <small class="pre-cost">

                                <del>$<?php echo number_format($product_details[0]['price'], 2); ?></del>
                                <?php } else { ?>
                                <ins style="text-decoration:none">$<?php
                                echo number_format($product_details[0]['price'],
                                    2);
                                ?></ins>
            <?php } ?>
                        </small></h3>

                    <div class="quantity" style='margin-bottom: 5px;'>
                        <span style="display:block;">Quantity</span>
                        <input type="number" size="4" class="input-text new-input-type" width="50" title="Qty" value="1" id="quantity_insta_<?php echo $product_details[0]['id'] ?>" name="quantity_insta" min="1" step="1">
                        <span id="errormsgforqtyinsta" style='display:table;font-size:11px;padding-left:55px;color:red'></span>
                    </div>

                    <div class="clearfix"></div>
                    <div><?php
                        if ($product_details[0]['quantity'] < 1) {
                            if ($product_details[0]['back_order_flag'] == 'yes') {
                                echo "<span style='font-size:11px;color:red'>Out of stock</span>";
                            } else {
                                echo "<span style='font-size:11px;color:red'>Out of stock</span>";
                            }
                        }
                        if ($product_details[0]['quantity'] <= 2 && $product_details[0]['quantity']
                            > 0) {
							
							if($product_details[0]['quantity'] == 0){
                                                $msg = 'No';
                                         }else{
                                             $msg = 'Only '.$product_details[0]['quantity'];
                                         }
							
                            if ($product_details[0]['back_order_flag'] == 'yes') {
                                echo "<span style='font-size:11px;color:red'>".$msg." item left in stock</span>";
                            } else {
                                echo "<span style='font-size:11px;color:red'>".$msg." item left in stock</span>";
                            }
                        }
                        ?></div>

                        <?php if (!empty($group_variant_products)) { ?>
                        <div class="clearfix margin-top-20"></div>
                        <span class="col-md-3 col-xs-4" style="margin-top: 7px; padding-left:0">Available in</span>
                        <div class="col-md-9 col-xs-8">
                            <?php
                            echo "<select style='position: relative;display: block;height: 2.5em;line-height: 2.5em;padding: 0;text-align: left; vertical-align: middle;cursor: pointer; border: 1px solid #DDD; border-top: 1px solid #EEE; border-bottom: 1px solid #B7B7B7;outline: 0 none;background: #fafafa;transition: 0.2s;box-sizing: border-box;padding-right: 15px;' onchange='getVariantProducts(this.value);' name='variant'>";
                            $i = 0;
                            foreach ($group_variant_products as $varient) {
                                if ($varient['id'] == $product_details[0]['id'])
                                        $selected = "selected";
                                else $selected = "";
                                echo "<option ".$selected." value='".$varient['id']."'>".ucfirst($varient['variant_color'])." (".$varient['variant_size'].")"."</option>";
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <input type="hidden" id="variantUp" value="<?php echo ucfirst($product_details[0]['variant_color'])." (".$product_details[0]['variant_size'].")" ?>">
                    <?php } ?>
                    <div class="clearfix"></div>
                    <?php
                    $catar = explode(',', $product_details[0]['sub_category_id']);
                    if (in_array('39', $catar)) {
                        ?>
                     <input type="hidden" name="inicial_product_available_insta" id="inicial_product_available_insta" value="1" />
                        <div class="clearfix margin-top-20"></div>
                        <span class="col-md-1 col-xs-1" style="margin-top: 7px; padding-left:0">Inicial</span>
                        <div class="col-md-10 col-xs-10">
                            <select id="getinicial_insta" name="initial_insta" onchange="getInicialProductsInsta();">
                                <?php 
                                            $arr_block_letters=array();
                                    foreach($arr_inicial_product_details as $keys=> $inicials){
                                        if($inicials['initial_letter'] != ''){
                                            if (in_array($inicials['initial_letter'], $arr_block_letters)) {

                                            }else{
                                    ?>
                                    <option value="<?php echo $inicials['initial_letter']; ?>" <?php if($inicials['initial_letter'] == $product_details[0]['initial_letter']){ ?>selected="selected" <?php } ?>><?php echo $inicials['initial_letter']; ?></option>
                                        <?php 
                                            $arr_block_letters[]=$inicials['initial_letter'];
                                            }}} ?>
                            </select>
                        </div>
                        <div class="clearfix margin-bottom-20"></div>


                        <div class="clearfix margin-top-20"></div>
                        <span class="col-md-1 col-xs-1" style="margin-top: 7px;padding-left:0">Color</span>
                        <div class="col-md-10 col-xs-10">
                            <select id="getcolor_insta" name="getcolor_insta" onchange="getInicialProductsInsta();">
                                 <?php 
                                    $arr_block_colors=array();
                                    foreach($arr_inicial_product_details as $keys=> $inicials){
                                        if($inicials['initial_color'] != ''){
                                            if (in_array($inicials['initial_color'], $arr_block_colors)) {

                                            }else{
                                    ?>
                                    <option value="<?php echo $inicials['initial_color']; ?>" <?php if($inicials['initial_color'] == $product_details[0]['initial_color']){ ?>selected="selected" <?php } ?>><?php echo $inicials['initial_color']; ?></option>
                                        <?php 
                                            $arr_block_colors[]=$inicials['initial_color'];
                                            }}} ?>
                            </select>
                        </div>
                        <div class="clearfix margin-bottom-20"></div>
                        
                        
                         <div class="clearfix margin-top-20"></div>
                        <span class="col-md-1 col-xs-1" style="margin-top: 7px;padding-left:0">MM</span>
                        <div class="col-md-10 col-xs-10">
                           <select id="getinicialmm_insta" name="getinicialmm_insta" onchange="getInicialProductsInsta();">
                                            
                                             <?php 
                                            $arr_block_mm=array();
                                            foreach($arr_inicial_product_details as $keys=> $inicials){
                                                if($inicials['initial_mm'] != ''){
                                                    if (in_array($inicials['initial_mm'], $arr_block_mm)) {
                                                           
                                                    }else{
                                            ?>
                                            <option value="<?php echo $inicials['initial_mm']; ?>" <?php if($inicials['initial_mm'] == $product_details[0]['initial_mm']){ ?>selected="selected" <?php } ?>><?php echo $inicials['initial_mm']; ?></option>
                                                <?php 
                                                    $arr_block_mm[]=$inicials['initial_mm'];
                                                    }}} ?>
                                            
                                            
                                        </select>
                        </div>
                        <div class="clearfix margin-bottom-20"></div>
                        

            <?php }else{ ?>
                        <input type="hidden" name="inicial_product_available_insta" id="inicial_product_available_insta" value="0" />
            <?php } ?>
                    <div class="space-ten"></div>
                    <div class="form-group">


                        <?php
                        if ($product_details[0]['back_order_flag'] == 'yes' && $product_details[0]['quantity']
                            <= 0) {
                            ?>
                            <button type="button" class="new-btn cart-dis-insta" onclick="funAddToCartInstaSuccess(<?php echo $product_details[0]['id'] ?>, '1')"><span class="glyphicon glyphicon-shopping-cart"></span> Pre-Order</button></li>
                        <?php } else { ?>
                            <button type="button" class="new-btn cart-dis-insta" onclick="funAddToCartInsta(<?php echo $product_details[0]['id'] ?>)"><span class="glyphicon glyphicon-shopping-cart"></span> Add To Cart</button>
                <?php
            }
            ?>


                        <?php if ($user_id != '') { ?>
                            <button type="button" class="new-btn cart-wish-insta" onclick="funAddTwishlistInsta(<?php echo $product_details[0]['id'] ?>)"><span class="glyphicon glyphicon-heart"></span> Add To Wishlist</button>
            <?php } else { ?>
                            <button type="button" class="new-btn cart-wish-insta" onclick="funAddTwishlist_login_insta(<?php echo $product_details[0]['id'] ?>)"><span class="glyphicon glyphicon-heart"></span> Add To Wishlist</button>
            <?php } ?>
                    </div>
                </div>
            </form>


            +++
            <?php echo $produictId; ?>
            <?php
        }
    }

    public function newsletterUnsuscriber($unsubscribe_code = '')
    {
        $data['user_session']      = $this->session->userdata('user_account');
        $user_email                = $this->input->post('user_email');
        $table_to_pass             = TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION;
        $fields_to_pass            = array('*');
        $condition_to_pass         = array("user_subscription_code" => $unsubscribe_code);
        $data['newsletetter_info'] = $this->common_model->getRecords($table_to_pass,
            $fields_to_pass, $condition_to_pass, $order_by_to_pass          = '',
            $limit_to_pass             = '', $debug_to_pass             = 0);
        //echo '<pre>';print_r($data['newsletetter_info']);die;
        if (count($data['newsletetter_info']) > 0) {
            $newsletter_code = $data['newsletetter_info'][0]['user_subscription_code'];
            $this->common_model->updateRow(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION,
                array('subscribe_status' => 'Active'),
                array('user_email' => $data['newsletetter_info'][0]['user_email']));

            if ($data['newsletetter_info'][0]['subscribe_status'] == "Inactive") {
                $this->session->set_flashdata('msg',
                    'You have already unsubscribed from our newsletter.');
//                $msg = 'You have already unsubscribed from our newsletter.';
            } else {
                $this->session->set_flashdata('msg',
                    'You have successfully unsubscribed from our newsletter.');
            }
            $update_data = array('subscribe_status' => 'Inactive',);
            $this->common_model->updateRow(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION,
                $update_data,
                array("user_subscription_code" => $unsubscribe_code));
//            echo $msg;

			/*Mailchip code start here   */
                $email = $data['newsletetter_info'][0]['user_email'];
                    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                // MailChimp API credentials
                $apiKey = '138bc8c3d1e964ea8f3876e4fb146bff-us13';
                $listID = '96751abec3'; //original
               // $listID = '77510fdf29'; //Rebelute Testing

                // MailChimp API URL
                $memberID   = md5(strtolower($email));
                $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
                $url        = 'https://'.$dataCenter.'.api.mailchimp.com/3.0/lists/'.$listID.'/members/'.$memberID;

                // member information
                $json = json_encode([
                    'email_address' => $email,
                    'status' => 'unsubscribed',
                ]);

                // send a HTTP POST request with curl
                $ch       = curl_init($url);
                curl_setopt($ch, CURLOPT_USERPWD, 'user:'.$apiKey);
                curl_setopt($ch, CURLOPT_HTTPHEADER,
                    ['Content-Type: application/json']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                $result   = curl_exec($ch);
                //echo '<pre>';print_R($result);die;
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                // store the status message based on response code
//                if ($httpCode == 200) {
//                    echo json_encode(array('status' => 1, 'msg' => 'Successfully subscribed to Vaskia Jewelry newsletter.'));
//                } else {
//                    switch ($httpCode) {
//                        case 214:
//                            $msg = 'You are already subscribed.';
//                            break;
//                        default:
//                            $msg = 'Some problem occurred, please try again.';
//                            break;
//                    }
//                    echo json_encode(array('status' => 1, 'msg' => $msg));
//                }
                
                    }
			
            redirect(base_url()."user-newsletter-unsubscribe");
        } else {
            /* insert subscriber user details */
            $user_subscription_code = rand(9999, 1000000000);
            $arr_fields             = array(
                "user_email" => $this->input->post('user_email'),
                "subscribe_status" => 'Active',
                "user_subscription_code" => $user_subscription_code,
                "is_subscribe_for_daily" => '0',
            );
            $last_insert_id         = $this->subscriber_model->insertNewsletterSubscriber($arr_fields);
            if ($this->input->post('user_email') != '') {
                /* Activation link  */
                $activation_link      = '<a href="'.base_url().'home/newsletterUnsuscriber/'.$user_subscription_code.'">Unsubscribe</a>';
                /* setting reserved_words for email content */
                $macros_array_details = array();
                $macros_array_details = $this->common_model->getRecords(TABLES::$EMAIL_TEMPLATE_MACROS,
                    $fields_to_pass       = 'macros,value',
                    $condition_to_pass    = '', $order_by             = '',
                    $limit                = '', $debug                = 0);
                $macros_array         = array();
                foreach ($macros_array_details as $row) {
                    $macros_array[$row['macros']] = $row['value'];
                }
                $reserved_words = array(
                    "||SITE_TITLE||" => config_item('website_name'),
                    "||SITE_PATH||" => base_url(),
                    "||USER_NAME||" => $this->input->post('user_email'),
                    "||UNSUBSCRIBE_LINK||" => $activation_link,
                    "||SITE_URL||" => '<a href="'.base_url().'">'.base_url().'</a>'
                );
                $reserved       = array_replace_recursive($macros_array,
                    $reserved_words);
                /* getting mail subect and mail message using email template title and lang_id and reserved works */
                $email_content  = $this->common_model->getEmailTemplateInfo('newsletter-subscription',
                    $reserved);
                $mail           = $this->common_model->sendEmail(array($this->input->post('user_email')),
                    array("email" => 'webmaster@rebelutedigital.com', "name" => config_item('website_name')),
                    $email_content['subject'],
                    htmlspecialchars_decode($email_content['content']));
                $this->session->set_flashdata("msg",
                    "You have successfully subscribed to our newsletter.");
                redirect(base_url()."#footernews");
            }
        }
    }

    function checkProductQuantityAvailable()
    {
        $product_id     = $this->input->post('id');
        $total_quantity = $this->input->post('total_quantity');
        if ($product_id != '' && $total_quantity > 0) {
            $product_details = $this->common_model->getRecords('it_products',
                'id,quantity,back_order_flag', array("id" => $product_id),
                'id DESC');
            //echo '<pre>';print_r($product_details);die;
            if (count($product_details) > 0 && $product_details[0]['quantity'] < $total_quantity
                && $product_details[0]['back_order_flag'] == 'no') {
                echo json_encode(array('status' => '3', 'msg' => ''));
            } elseif (count($product_details) > 0 && $product_details[0]['quantity']
                >= $total_quantity) {
                echo json_encode(array('status' => '1', 'msg' => ''));
            } else {
                echo json_encode(array('status' => '0', 'msg' => ''));
            }
        } else {
            echo json_encode(array('status' => '2', 'msg' => 'Product is not available.'));
        }
    }
	
	function checkProductQuantityAvailableInicial()
    { //Only for inicials products
        
        
        $initial_letter     = $this->input->post('getinicial');
        $initial_color = $this->input->post('color');
        $initial_mm = $this->input->post('getinicialmm');
        $total_quantity = $this->input->post('total_quantity');
        if ($initial_letter != '' && $initial_color != '' && $initial_mm != '' && $total_quantity > 0) {
            $product_details = $this->common_model->getRecords('it_products',
                '*', array("initial_letter" => $initial_letter,"initial_color" => $initial_color,"initial_mm" => $initial_mm),
                'id DESC');
            //echo '<pre>';print_r($product_details);die;
            $main_price = floatval($product_details[0]['price']) - floatval($product_details[0]['discounted_price']);
            if (count($product_details) > 0 && $product_details[0]['quantity'] < $total_quantity
                && $product_details[0]['back_order_flag'] == 'no') {
                echo json_encode(array('status' => '3', 'msg' => '', 'new_item_id' => $product_details[0]['id'], 'new_stock' => $product_details[0]['quantity'],'new_price' => $main_price,'new_img_url' => $product_details[0]['url'],'new_name' => $product_details[0]['product_name'],'back_order_flag' => $product_details[0]['back_order_flag']));
            } elseif (count($product_details) > 0 && $product_details[0]['quantity']
                >= $total_quantity) {
                echo json_encode(array('status' => '1', 'msg' => '', 'new_item_id' => $product_details[0]['id'], 'new_stock' => $product_details[0]['quantity'],'new_price' => $main_price,'new_img_url' => $product_details[0]['url'],'new_name' => $product_details[0]['product_name'],'back_order_flag' => $product_details[0]['back_order_flag']));
            } else {
                echo json_encode(array('status' => '0', 'msg' => '', 'new_item_id' => $product_details[0]['id'], 'new_stock' => $product_details[0]['quantity'],'new_price' => $main_price,'new_img_url' => $product_details[0]['url'],'new_name' => $product_details[0]['product_name'],'back_order_flag' => $product_details[0]['back_order_flag']));
            }
        } else {
            echo json_encode(array('status' => '2', 'msg' => 'Product is not available.'));
        }
    }

    public function sendUsernamePassword()
    {
        $email = trim($this->input->post('username'));
        if ($email != '') {
            $arr_user_details = $this->common_model->getRecords('users',
                'first_name,last_name,username,id,email,password',
                array("email" => $email, 'active' => 1));
            if (count($arr_user_details) > 0) {
                $base_url     = base_url();
                $password_new = rand();
                $password     = $this->ion_auth->hash_password($password_new);
                $name         = $arr_user_details[0]['first_name'].' '.$arr_user_details[0]['last_name'];
//                $subject2 = "Username And Password";
//                $message2 = "Dear $name. <br/><br/>";
//                $message2 .= "Your login details are given below:<br/><br/>";
//                $message2 .= "Username:  $email <br/><br/>";
//                $message2 .= "Password:  $password_new <br/><br/>";
//                $message2 .= "Site Url:  $base_url <br/>";



                $edata['name']     = $name;
                $edata['email']    = $email;
                $edata['password'] = $password_new;
                $html              = $this->load->view('email_templates/forgot_password',
                    $edata, true);
                $mail              = $this->common_model->sendEmail(array($email),
                    array("email" => config_item('site_email'), "name" => config_item('website_name')),
                    'Login Credentials', $html);

                // echo '<pre>';print_r($mail);
                //$mail = $this->common_model->sendEmail(array($email), array("email" => 'webmaster@rebelutedigital.com', "name" => config_item('website_name')), $subject2, $message2);

                $update_data       = array(
                    "password" => $password,
                );
                $condition_to_pass = array("email" => $email);
                $last_update_id    = $this->common_model->updateRow('users',
                    $update_data, $condition_to_pass);


                echo json_encode(array('status' => '1', 'msg' => 'We have sent your login details on email.'));
            } else {
                echo json_encode(array('status' => '2', 'msg' => 'Incorrect email address  or account is not active.'));
            }
        } else {
            echo json_encode(array('status' => '0', 'msg' => 'Please enter name and email'));
        }
    }

    public function updateQuantity($order_no)
    {
        $this->load->library('clover');
        $edata['item_data'] = $this->common_model->getRecords('order_details as od',
            'od.*,(select clover_id from it_products where id=od.ord_det_item_fk) as clover_id',
            array('od.ord_det_order_number_fk' => $order_no));
        foreach ($edata['item_data'] as $res) {
            $matches = unserialize($res['ord_det_item_option']);

            if ($matches['Prebook'] == 'false') {
                $updata   = 'quantity - '.floor($res["ord_det_quantity"]);
                $this->db->where('id', $res['ord_det_item_fk'])
                    ->set('quantity',
                        'quantity-'.floor($res["ord_det_quantity"]), FALSE)
                    ->update('it_products');
                $quantity = $this->common_model->getRecords('it_products',
                    'quantity', array('id' => $res['ord_det_item_fk']));
                $this->clover->updateStockCount($res['clover_id'],
                    array('quantity' => $quantity[0]['quantity'])); 
            }
        }
        return true; 
    }

    public function validateStock()
    {
        /* check for stock availabel before checkout */
        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        $qarr                     = array();
        $i                        = 0;
        foreach ($this->data['cart_items'] as $item) {
            if ($item['options']['Prebook'] != 'true') {
                $stock = $this->common_model->getRecords('it_products', '*',
                    array('id' => $item['id']));
                if ($stock[0]['quantity'] == '0' || $stock[0]['quantity'] == '' || $item['quantity']
                    > $stock[0]['quantity']) {
                    $qarr[$i]['id']   = $stock[0]['id'];
                    $qarr[$i]['name'] = $stock[0]['product_name'];
                }
            }
            $i++;
        }
        if (!empty($qarr)) {
            return false;
        } else {
            return true;
        }
    }

    public function validateStockForNonAdvance()
    {
        /* check for stock availabel before checkout */
        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        $qarr                     = array();
        $i                        = 0;
        $qarr['out_of_stock']     = 0;
        $qarr['in_stock']         = 0;
        foreach ($this->data['cart_items'] as $item) {

            if ($item['options']['Prebook'] == 'true') {
                $stock = $this->common_model->getRecords('it_products', '*',
                    array('id' => $item['id']));
                if ($item['quantity'] > $stock[0]['quantity']) {
                    $qarr['out_of_stock'] = 1;
                }
            } else {
                $qarr['in_stock'] = 1;
            }
            $i++;
        }
        return $qarr;
    }

    public function my_profile()
    {
        $user_id = $this->session->userdata('user_id');
        if ($this->input->post()) {
            if ($_FILES['profile_image']['name'] != '') {
                $_FILES['profile_image']['name'];
                $_FILES['profile_image']['type'];
                $_FILES['profile_image']['tmp_name'];
                $_FILES['profile_image']['error'];
                $_FILES['profile_image']['size'];
                $config['file_name']     = time().rand();
                $config['upload_path']   = 'assets/uploads/users/profile/';
                $config['allowed_types'] = 'jpg|jpeg|gif|png';
                $config['max_size']      = '9000000';
                $this->load->library('upload');
                $this->upload->initialize($config);
                if ($this->upload->do_upload('profile_image')) {
                    $data['upload_data'] = $this->upload->data();
                    $ar                  = list($width, $height) = getimagesize($data['full_path']);
                    $upload_result       = $this->upload->data();
                    $image_config        = array(
                        'source_image' => $upload_result['full_path'],
                        'new_image' => "assets/uploads/users/profile/100x100/",
                        'maintain_ratio' => false,
                        'width' => 100,
                        'height' => 100
                    );
                    $this->load->library('image_lib');
                    $this->image_lib->initialize($image_config);
                    $resize_rc           = $this->image_lib->resize();
                    $img_path            = base_url()."assets/uploads/users/profile/100x100/".$upload_result['file_name'];

                    unlink('assets/uploads/users/profile/100x100/'.$this->input->post('old_press_image'));
                } else {
                    $error = array('error' => $this->upload->display_errors());
                }
            } else {
                $img_path = $this->input->post('old_profile_image');
            }
            $arr      = array('shipping_name' => $this->input->post('shipping_name'),
                'shipping_company' => $this->input->post('shipping_company'),
                'shipping_address_01' => $this->input->post('shipping_address_01'),
                'shipping_address_02' => $this->input->post('shipping_address_02'),
                'shipping_city' => $this->input->post('shipping_city'),
                'shipping_state' => $this->input->post('shipping_state'),
                'shipping_country' => $this->input->post('shipping_country'),
                'shipping_zipcode' => $this->input->post('shipping_zipcode'),
                'billing_name' => $this->input->post('billing_name'),
                'billing_company' => $this->input->post('billing_company'),
                'billing_address_01' => $this->input->post('billing_address_01'),
                'billing_address_02' => $this->input->post('billing_address_02'),
                'billing_city' => $this->input->post('billing_city'),
                'billing_state' => $this->input->post('billing_state'),
                'billing_country' => $this->input->post('billing_country'),
                'billing_zipcode' => $this->input->post('billing_zipcode'),
            );
            $arr_user = array('phone' => $this->input->post('phone'), 'picture_url' => $img_path);
            $this->common_model->updateRow('users_address_details', $arr,
                array('user_id' => $user_id));
            $this->common_model->updateRow('users', $arr_user,
                array('id' => $user_id));
            $this->session->set_flashdata('profile_msg',
                'Profile details updated successfully');
            redirect(base_url()."home/my_profile");
        }
        $this->data['dataHeader']      = $this->users->get_allData($user_id);
        $this->data['account_details'] = $this->user->getUserAddress();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/my_profile', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '',
            TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function updateNewsletterSubscriber()
    {
        $user_id   = $this->session->userdata('user_id');
        $id        = $this->input->post('id');
        $arr_users = $this->common_model->getRecords('users', 'id,email',
            array('id' => $user_id));
        if ($user_id != '' && $user_id > 0 && count($arr_users) > 0) {
            $update_data       = array(
                "newsletter_suscriber" => "$id",
            );
            $condition_to_pass = array("id" => $user_id);
            $last_update_id    = $this->common_model->updateRow('users',
                $update_data, $condition_to_pass);

            $arr_users_subscriber = $this->common_model->getRecords('tbl_trans_newsletter_subscription',
                'newsletter_subscription_id',
                array('user_email' => $arr_users[0]['email']));
            //echo '<pre>';print_R($arr_users);die;
            if ($id == '1') {
                $status = 'Active';
				$status_new = 'subscribed';
            } else {
                $status = 'Inactive';
				 $status_new = 'unsubscribed';
            }
			
			/*Mailchip code start here   */
                $email = $arr_users[0]['email'];
                    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                // MailChimp API credentials
                $apiKey = '138bc8c3d1e964ea8f3876e4fb146bff-us13';
                $listID = '96751abec3'; //original
               // $listID = '77510fdf29'; //Rebelute Testing

                // MailChimp API URL
                $memberID   = md5(strtolower($email));
                $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
                $url        = 'https://'.$dataCenter.'.api.mailchimp.com/3.0/lists/'.$listID.'/members/'.$memberID;

                // member information
                $json = json_encode([
                    'email_address' => $email,
                    'status' => $status_new,
                ]);

                // send a HTTP POST request with curl
                $ch       = curl_init($url);
                curl_setopt($ch, CURLOPT_USERPWD, 'user:'.$apiKey);
                curl_setopt($ch, CURLOPT_HTTPHEADER,
                    ['Content-Type: application/json']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                $result   = curl_exec($ch);
                //echo '<pre>';print_R($result);die;
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                // store the status message based on response code
//                if ($httpCode == 200) {
//                    echo json_encode(array('status' => 1, 'msg' => 'Successfully subscribed to Vaskia Jewelry newsletter.'));
//                } else {
//                    switch ($httpCode) {
//                        case 214:
//                            $msg = 'You are already subscribed.';
//                            break;
//                        default:
//                            $msg = 'Some problem occurred, please try again.';
//                            break;
//                    }
//                    echo json_encode(array('status' => 1, 'msg' => $msg));
//                }
                
                    }
			
			

            if (count($arr_users_subscriber) < 1) {
                $user_subscription_code = rand(9999, 1000000000);
                $arr_fields             = array(
                    "user_email" => $arr_users[0]['email'],
                    "subscribe_status" => $status,
                    "user_subscription_code" => $user_subscription_code,
                    "is_subscribe_for_daily" => '0',
                );
                $this->common_model->insertRow($arr_fields,
                    'tbl_trans_newsletter_subscription');


                $email_data['status']          = $status;
                $email_data['activation_link'] = base_url().'home/newsletterUnsuscriber/'.$user_subscription_code;
                $email_content                 = $this->load->view('email_templates/newsletter_subscribe',
                    $email_data, TRUE);

                $mail = $this->common_model->sendEmail(array($arr_users[0]['email']),
                    array("email" => config_item('site_email'), "name" => config_item('website_name')),
                    'You have subscribed to newsletter', $email_content);
            } else {
                $update_data       = array(
                    "subscribe_status" => $status,
                );
                $condition_to_pass = array("user_email" => $arr_users[0]['email']);
                $last_update_id    = $this->common_model->updateRow('tbl_trans_newsletter_subscription',
                    $update_data, $condition_to_pass);
            }
        }
    }

    function demo_update_cart_product_changes()
    {
//	                       echo "<pre>";
//       print_r($this->flexi_cart->cart_items());
//        die;
        $this->load->library('flexi_cart_lite');
        $this->data['cart_items'] = $this->flexi_cart->cart_items();
//        $this->session->unset_userdata('flexi_cart')['summary']['item_summary_total'];
        $user_id                  = $this->session->userdata('user_id');
//        $add = 0;
//        $minus = 0;
//        $item_summary_total = 0;
//        $item_summary_total_new = 0;
//        $total = 0;
//        $total_new = 0;
        if (count($this->data['cart_items']) > 0) {
            foreach ($this->data['cart_items'] as $k => $sData) {
                if (count($sData['options']) < 4) {
                    if ($sData['id'] != '') {
                        $product_cart_price          = 0;
                        $product_cart_discount       = 0;
                        $product_cart_internal_price = 0;
                        $product_price               = 0;
                        $product_discount            = 0;
                        $product_internal_price      = 0;
                        $product_increased_price     = 0;
                        $product_decreased_price     = 0;
                        $arr_product_details         = $this->common_model->getRecords('it_products',
                            'price,quantity,discounted_price,id,product_name',
                            array('id' => $sData['id'], 'isactive' => '0'));
                        if (count($arr_product_details) > 0) {
                            $produictId      = $sData['id'];
                            $product_details = $this->product->get_product_by_product_id($produictId);
                            foreach ($product_details as $key => $value) {
                                $product_details[$key]['product_images_details']
                                    = $this->product_images->as_array()->get_by_id($produictId);
                            }
                            $this->data['cart_items'][$k]['price']          = $arr_product_details[0]['price'];
                            $this->data['cart_items'][$k]['name']           = $arr_product_details[0]['product_name'];
                            $this->data['cart_items'][$k]['internal_price'] = $arr_product_details[0]['price']
                                - $arr_product_details[0]['discounted_price'];

                            $price_main = ($arr_product_details[0]['price'] - $arr_product_details[0]['discounted_price']);

                            $this->flexi_cart->delete_items($k);
                            $cart_data = array(
                                'id' => $product_details[0]['id'],
                                'name' => $product_details[0]['product_name'],
                                'quantity' => $sData['quantity'],
                                'stock_quantity' => $product_details[0]['quantity'],
                                'price' => $price_main,
                                'item_url' => $product_details[0]['url'],
                                'options' => array(
                                    'Prebook' => $sData['options']['Prebook'],
                                    'Initial' => $sData['options']['Initial'],
                                    'Color' => $sData['options']['Color'],
                                ),
                            );

                            if (isset($cart_data)) {
                                $this->flexi_cart->insert_items($cart_data);
                            }
                            $query  = $this->db->query("select * from users_cart_items where user_id='".$user_id."' and product_id='".$sData['id']."'");
                            $result = $query->result_array();
                            if ($user_id != '' && $query->num_rows() == 0) {
                                $db_data = array(
                                    'product_id' => $product_details[0]['id'],
                                    'product_name' => $product_details[0]['product_name'],
                                    'quantity' => $sData['quantity'],
                                    'price' => $price_main,
                                    'item_url' => $product_details[0]['url'],
                                    'created_time' => date("Y-m-d H:i:s"),
                                    'user_id' => $user_id);
                                $this->db->insert('users_cart_items', $db_data);
                            } else {
                                $db_data = array(
                                    'product_id' => $product_details[0]['id'],
                                    'product_name' => $product_details[0]['product_name'],
                                    'quantity' => $sData['quantity'],
                                    'price' => $price_main,
                                    'item_url' => $product_details[0]['url'],
                                    'created_time' => date("Y-m-d H:i:s"),
                                    'user_id' => $user_id);
                                //$this->db->where('user_id', $user_id);
                                $this->db->where('product_id',
                                    $product_details[0]['id']);
                                $this->db->update('users_cart_items', $db_data);
                            }
                        } else {
                            if ($sData['id'] != '' && $sData['id'] > 0) {
                                $this->flexi_cart->delete_items($k);
                                $user = array($sData['id']);
                                $this->common_model->deleteRows($user,
                                    "users_cart_items", "product_id");
                            }
                        }
                    }
                } else {
                    if ($sData['id'] != '') {
                        $product_cart_price          = 0;
                        $product_cart_discount       = 0;
                        $product_cart_internal_price = 0;
                        $product_price               = 0;
                        $product_discount            = 0;
                        $product_internal_price      = 0;
                        $product_increased_price     = 0;
                        $product_decreased_price     = 0;
                        $arr_product_details         = $this->common_model->getRecords('it_products',
                            'price,quantity,discounted_price,id,product_name',
                            array('id' => $sData['id'], 'isactive' => '0'));
                        if (count($arr_product_details) > 0) {
                            $produictId      = $sData['id'];
                            $product_details = $this->product->get_product_by_product_id($produictId);
                            foreach ($product_details as $key => $value) {
                                $product_details[$key]['product_images_details']
                                    = $this->product_images->as_array()->get_by_id($produictId);
                            }
                            $this->data['cart_items'][$k]['price']          = $arr_product_details[0]['price'];
                            $this->data['cart_items'][$k]['name']           = $arr_product_details[0]['product_name'];
                            $this->data['cart_items'][$k]['internal_price'] = $arr_product_details[0]['price']
                                - $arr_product_details[0]['discounted_price'];

                            $price_main = ($arr_product_details[0]['price'] - $arr_product_details[0]['discounted_price']);

                            $this->flexi_cart->delete_items($k);
                            $cart_data = array(
                                'id' => $product_details[0]['id'],
                                'name' => $product_details[0]['product_name'],
                                'quantity' => $sData['quantity'],
                                'stock_quantity' => $product_details[0]['quantity'],
                                'price' => $price_main,
                                'item_url' => $product_details[0]['url'],
                                'options' => array(
                                    'Prebook' => $sData['options']['Prebook'],
                                    'Initial' => $sData['options']['Initial'],
                                    'Color' => $sData['options']['Color'],
                                ),
                            );

                            if (isset($cart_data)) {
                                $this->flexi_cart->insert_items($cart_data);
                            }
                            $query  = $this->db->query("select * from users_cart_items where user_id='".$user_id."' and product_id='".$sData['id']."'");
                            $result = $query->result_array();
                            if ($user_id != '' && $query->num_rows() == 0) {
                                $db_data = array(
                                    'product_id' => $product_details[0]['id'],
                                    'product_name' => $product_details[0]['product_name'],
                                    'quantity' => $sData['quantity'],
                                    'price' => $price_main,
                                    'item_url' => $product_details[0]['url'],
                                    'created_time' => date("Y-m-d H:i:s"),
                                    'user_id' => $user_id);
                                $this->db->insert('users_cart_items', $db_data);
                            } else {
                                $db_data = array(
                                    'product_id' => $product_details[0]['id'],
                                    'product_name' => $product_details[0]['product_name'],
                                    'quantity' => $result[0]['quantity'] + $sData['quantity'],
                                    'price' => $price_main,
                                    'item_url' => $product_details[0]['url'],
                                    'created_time' => date("Y-m-d H:i:s"),
                                    'user_id' => $user_id);
                                //$this->db->where('user_id', $user_id);
                                $this->db->where('product_id',
                                    $product_details[0]['id']);
                                $this->db->update('users_cart_items', $db_data);
                            }
                        } else {
                            if ($sData['id'] != '' && $sData['id'] > 0) {
                                $this->flexi_cart->delete_items($k);
                                $user = array($sData['id']);
                                $this->common_model->deleteRows($user,
                                    "users_cart_items", "product_id");
                            }
                        }
                    }
                    $arr_product_details = $this->common_model->getRecords('it_products',
                        'price,quantity,discounted_price,id,product_name',
                        array('id' => $sData['id'], 'isactive' => 1));
//
                    if (count($arr_product_details) > 0) {
                        $this->flexi_cart->delete_items($k);
                        $user = array($sData['id']);
                        $this->common_model->deleteRows($user,
                            "users_cart_items", "product_id");
                    }
                }
            }


//        $item_summary_total = $this->data['cart_summary']['item_summary_total'];
//        $total = $this->data['cart_summary']['total'];
//        $item_summary_total_new = $item_summary_total + $add - $minus;
//        $total_new = $total + $add - $minus;
        }
    }

    public function getVarientDetails()
    {
        $data = $this->common_model->getRecords("product_variants", "",
            array("product_id_fk" => $this->input->post('product_id'), "varient_value" => $this->input->post('varient')));
        if (count($data) > 0 && !empty($data)) {
            echo json_encode(array("status" => "1", "price" => $data[0]['price'],
                "desc" => $data[0]['description']));
        } else {
            echo json_encode(array("status" => "0", "price" => "", "desc" => ""));
        }
    }

    public function getVarientProducts()
    {
        if ($this->input->post('category_id') != '') {
            $productCategoryId = base64_decode($this->input->post('category_id'));
        }
        $user_id                       = $this->session->userdata('user_id');
        $this->data['dataHeader']      = $this->users->get_allData($user_id);
        $this->data['essential']       = $this->product->get_essential_product();
        $this->data['product_details'] = $this->product->get_product_by_product_id($this->input->post('product_id'));
        foreach ($this->data['product_details'] as $key => $value) {
            $this->data['product_details'][$key]['product_images_details']  = $this->product_images->as_array()->get_by_id($this->input->post('product_id'));
            $this->data['product_details'][$key]['product_varient_details'] = $this->common_model->getRecords('product_variants',
                '', array('product_id_fk' => $this->input->post('product_id')));
        }
        $this->data['group_variant_products'] = $this->product->getGroupProducts($this->data['product_details'][0]['product_name']);

        $data = $this->load->view('_variant_product', $this->data, TRUE);
        if (count($data) > 0 && !empty($data)) {
            echo json_encode(array("status" => "1", "data" => $data));
        } else {
            echo json_encode(array("status" => "0", "data" => "No product available"));
        }
    }
    public function validatePaypalSession()
    {
	$stockcheck = $this->validateStock();
        if ($stockcheck == false){
            $this->session->set_flashdata('stock_error','Sorry for inconvenience, your some product is out of stock so please place order in advance or remove product then try,thank you.');
            echo json_encode(array('status' => 700,'data' => 'Sorry for inconvenience, your some product is out of stock so please place order in advance or remove product then try,thank you.'));
           exit;
        }
        $stockerror = $this->validateStockForNonAdvance();
        if ($stockerror['out_of_stock'] == 1 && $stockerror['in_stock'] == 1) {
            $this->session->set_flashdata('stock_error','Sorry for inconvenience, your some product is out of stock so please place order in advance or remove product then try,thank you.');
//            $this->session->set_flashdata('stock_error1', $stockerror);
            // redirect(base_url() . "home/cart");
          echo json_encode(array('status' => 700,'data' => 'Sorry for inconvenience, your some product is out of stock so please place order in advance or remove product then try,thank you.'));
           exit;
        }
        $this->load->library('flexi_cart_lite');

        if (empty($this->flexi_cart->cart_items())) {
            echo json_encode(array('status' => 202));
            exit;
        } elseif(!$this->ion_auth->logged_in()){
            echo json_encode(array('status' => 201));
            exit;
        }
        else{
            echo json_encode(array('status' => 200));
            exit;
        }
    }
     public function track_order($order_number)
    {
         
        $this->load->library('ups_lib');

        $this->data['item_data']    = $this->common_model->getRecords('order_details',
            '*', array('ord_det_order_number_fk' => $order_number));
         $this->data['summary_data'] = $this->common_model->getRecords('order_summary',
            '*', array('ord_order_number' => $order_number));

        $req['RequestOption']        = '15';
        $tref['CustomerContext']     = 'add';
        $req['TransactionReference'] = $tref;
        $request['Request']          = $req;
        $request['InquiryNumber']    = $this->data['summary_data'][0]['order_tracking_number'];
        $request['TrackingOption']   = '01';
        if($this->data['summary_data'][0]['order_tracking_number']!=''){
        (array) $tracking_response = $this->ups_lib->getTracking($request);
//        echo "<pre>";
//        print_r($tracking_response);
 
        if ( $this->data['summary_data'][0]['ord_status'] == 3 || $this->data['summary_data'][0]['ord_status'] == 7) {
            if ($tracking_response->Response->ResponseStatus->Description == 'Success') {
                if ($tracking_response->Shipment->Package->Activity->Status->Description
                    === 'DELIVERED') {
                    $this->data['order_status'] = 'DELIVERED';
                } else {

                    $this->data['order_status']      = 'IN PROCESS';
                    $this->data['estimated_arrival'] = (end($tracking_response->Shipment->CarrierActivityInformation)->Arrival->Date)
                            ? end($tracking_response->Shipment->CarrierActivityInformation)->Arrival->Date
                            : $tracking_response->Shipment->DeliveryDetail->Date;
                }
            }

        }
        }
        if($this->data['summary_data'][0]['ord_status'] == 3){
            $this->data['order_class'] = 'c1';
        }
        elseif( $this->data['summary_data'][0]['ord_status'] == 2){
            $this->data['order_class'] = 'c1';
        }elseif( $this->data['summary_data'][0]['ord_status'] == 4){
            $this->data['order_class'] = 'c4';
        }elseif( $this->data['summary_data'][0]['ord_status'] == 5){
            $this->data['order_class'] = 'c2';
        }elseif( $this->data['summary_data'][0]['ord_status'] == 7){
            $this->data['order_class'] = 'c2';
        }
         $this->template->set_master_template('landing_template.php');

        $this->template->write_view('header', 'snippets/header',
            $this->data);

        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

        $this->template->write_view('content', 'track_order', $this->data, TRUE);

        $this->template->write_view('ab_btm_sidebar',
            'snippets/above_btm_sidebar', '', TRUE);

        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '',
            TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);

        $this->template->render();
    }
}