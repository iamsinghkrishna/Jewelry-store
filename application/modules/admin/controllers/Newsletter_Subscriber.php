<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//error_reporting(E_ALL);
class Newsletter_subscriber extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('subscriber_model');
        $this->load->model('common_model');
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->language(array('product_lang'));

        /* Load Backend model */
        $this->load->model(array('users', 'backend/group_model', 'backend/pattribute', 'backend/pattribute_sub'));
        $this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category'));

        /* Load Master model */
        $this->load->model(array('master/mst_make', 'master/mst_model', 'master/mst_year', 'backend/coupon_category', 'backend/coupon_method', 'backend/coupon_method_tax', 'backend/coupon_group'));
//        $this->flexi = new stdClass;
//        $this->load->library('flexi_cart');

        /* PHPExcel Library */
        $this->load->library('excel');

        /* Load Product model */
        $this->load->model(array('backend/product_attribute', 'backend/product', 'backend/product_images'));

        $this->load->model(array('users', 'backend/orders_summary', 'backend/orders_details', 'demo_cart_admin_model'));

        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
    }

    /** function to get all subscribed user start * */
    public function listSubscriberNewsletter() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        if ($_POST) {
            #getting all ides selected
            #getting all ides selected
            $arr_newsletter_ids = $this->input->post('checkbox');
            if (count($arr_newsletter_ids) > 0) {
                if (count($arr_newsletter_ids) > 0) {
                    #deleting the newsletter selected
                    $this->common_model->deleteRows($arr_newsletter_ids, TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION, "newsletter_subscription_id");
                }
                redirect(base_url() . 'admin/newsletter-subscriber/list');
                //$this->session->set_flashdata("msg", "Newsletter subscribed user deleted successfully!");
                $this->session->set_userdata("msg", "Newsletter subscribed user deleted successfully!");
            }
        }

        $this->data['title'] = "Manage Subscriber Newsletter";
        $this->data['arr_newsletter_list'] = $this->subscriber_model->getSubscriberNewsletterDetails();
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Administrator Dashboard';

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'subscriber-newsletter/list', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    /** function to status newsletter start * */
    public function changeSubscribedUserStatus() {
        if ($this->input->post('newsletter_subscription_id') != "") {
            #updating the newsletter status.
            $arr_to_update = array(
                "subscribe_status" => $this->input->post('subscribe_status')
            );
            #condition to update record	for the newsletter status
            $condition_array = array('newsletter_subscription_id' => intval($this->input->post('newsletter_subscription_id')));
            $this->common_model->updateRow(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION, $arr_to_update, $condition_array);
            echo json_encode(array("error" => "0", "error_message" => "Status has been changed successflly."));
        } else {
            #if something going wrong providing error message. 
            echo json_encode(array("error" => "1", "error_message" => "Sorry, your request can not be fulfilled this time. Please try again later"));
        }
    }

    /** function to status newsletter end * */

    /** Function to start check user already subscribed or not * */
    public function checkSubscribedUsersEmailExist() {
        $this->load->model('subscriber_model');
        $user_email = $this->input->post('user_email');
        $table_to_pass = TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION;
        $fields_to_pass = array('user_email');
        $condition_to_pass = array("user_email" => $user_email, "subscribe_status" => 'Active');
        $arr_login_data = $this->subscriber_model->getSubscriberUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        if (count($arr_login_data)) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    /* Function to add subscriber user details * */

    public function addNewsletterSubscriber() {
        /* Getting Common data */
//        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        /* checking user has privilige for the Manage Admin */
//        $data['global'] = $this->common_model->getGlobalSettings();

        $user_email = $this->input->post('user_email');
        $table_to_pass = TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION;
        $fields_to_pass = array('*');
        $condition_to_pass = array("user_email" => $user_email);
        $data['newsletetter_info'] = $this->subscriber_model->getSubscriberUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
//        print_r($data['newsletetter_info']);die;
        if (count($data['newsletetter_info']) > 0) {
            //die("sdf");
            $newsletter_code = $data['newsletetter_info'][0]['user_subscription_code'];
//            $this->common_model->updateRow(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION, array('subscribe_status' => 'Active'), array('user_email' => $data['newsletetter_info'][0]['user_email']));
            $this->newslettersubscribed($newsletter_code);
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
                $email_data['activation_link'] = base_url() . 'home/newsletterUnsuscriber/' . $user_subscription_code;
                /* setting reserved_words for email content */
//                $macros_array_details = array();
//                $macros_array_details = $this->common_model->getRecords(TABLES::$EMAIL_TEMPLATE_MACROS, $fields_to_pass = 'macros,value', $condition_to_pass = '', $order_by = '', $limit = '', $debug = 0);
//                $macros_array = array();
//                foreach ($macros_array_details as $row) {
//                    $macros_array[$row['macros']] = $row['value'];
//                }
//                $reserved_words = array(
//                    "||SITE_TITLE||" => config_item('website_name'),
//                    "||SITE_PATH||" => base_url(),
//                    "||USER_NAME||" => $this->input->post('user_email'),
//                    "||UNSUBSCRIBE_LINK||" => $activation_link,
//                    "||SITE_URL||" => '<a href="' . base_url() . '">' . base_url() . '</a>'
//                );
//
//                $reserved = array_replace_recursive($macros_array, $reserved_words);
//
//                /* getting mail subect and mail message using email template title and lang_id and reserved works */
//                $email_content = $this->common_model->getEmailTemplateInfo('newsletter-subscription', $reserved);
                $email_content = $this->load->view('email_templates/newsletter_subscribe', $email_data, TRUE);

                $mail = $this->common_model->sendEmail(array($this->input->post('user_email')), array("email" => config_item('site_email'), "name" => config_item('website_name')), 'You have subscribed to newsletter', $email_content);
                
                
                /*Mailchip code start here   */
                $email = $user_email;
                    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                // MailChimp API credentials
                $apiKey = '138bc8c3d1e964ea8f3876e4fb146bff-us13';
                $listID = '96751abec3'; //original
                //$listID = '77510fdf29'; //Rebelute Testing

                // MailChimp API URL
                $memberID   = md5(strtolower($email));
                $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
                $url        = 'https://'.$dataCenter.'.api.mailchimp.com/3.0/lists/'.$listID.'/members/'.$memberID;

                // member information
                $json = json_encode([
                    'email_address' => $email,
                    'status' => 'subscribed',
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
                
                
                $this->session->set_flashdata("msg", "You have successfully subscribed to our newsletter.");
                redirect(base_url() . "#footernews");
            }
        }
    }

    /* function to unsubscribe newsletter. */

    public function newsletterUnsubscribed($unsubscribe_code) {
        //Get global settings.
        $data['global'] = $this->common_model->getGlobalSettings();

        $fields_to_pass = array('newsletter_subscription_id', 'user_email', 'subscribe_status', 'is_subscribe_for_daily');
        /* get user details to verify the email address */
        $data['newsletetter_info'] = $this->common_model->getRecords(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION, $fields_to_pass, array("user_subscription_code" => $unsubscribe_code));

        if ($data['newsletetter_info'][0]['subscribe_status'] == 'Inactive') {
            $this->session->set_flashdata('error', 'You have already unsubscribed from our newsletter.');
            redirect(base_url());
        } else if ($data['newsletetter_info'][0]['subscribe_status'] == 'Active') {
            $update_data = array(
                'subscribe_status' => 'Inactive',
            );
            $this->common_model->updateRow(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION, $update_data, array("user_subscription_code" => $unsubscribe_code));
            /* Activation link  */
//            $activation_link = '<a href="' . base_url() . 'newsletter-subscribe/' . $unsubscribe_code . '">Subscribe Newsletter.</a>';
            $email_data['activation_link'] = base_url() . 'home/newsletterUnsuscriber/' . $user_subscription_code;
            $email_content = $this->load->view('email_templates/newsletter_subscribe', $email_data, TRUE);

            $mail = $this->common_model->sendEmail(array($data['newsletetter_info'][0]['user_email']), array("email" => config_item('site_email'), "name" => config_item('website_name')), 'You have subscribed to newsletter', $email_content);

            /* setting reserved_words for email content */
            if ($mail) {
                $this->session->set_flashdata("msg", "You have successfully unsubscribed from our newsletter.");
                redirect(base_url() . "#footernews");
            }
        } else {
            /* if any error invalid activation link found account */
            $_SESSION['msg'] = '<div class="alert alert-error">Invalid unsubscribe code.</div>';
        }
        redirect(base_url());
    }

    /*
     * FUnction to subscribe user's newsletter 
     */

    public function newsletterSubscribed($subscribed_code) {
        //Get global settings.
//        $data['global'] = $this->common_model->getGlobalSettings();

        $fields_to_pass = array('newsletter_subscription_id', 'user_email', 'subscribe_status', 'is_subscribe_for_daily');
        /* get user details to verify the email address */
        $arr_login_data = $this->common_model->getRecords(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION, $fields_to_pass, array("user_subscription_code" => $subscribed_code));
        if (count($arr_login_data)) {
            $user_unsubscription_code = rand(9999, 1000000000);
            /* if email already verified */
            if ($arr_login_data[0]['subscribe_status'] == "Active") {
                $this->session->set_flashdata('error', 'You have already subscribed to our newsletter.');
            } else {

                /* if email not verified. */
                $update_data = array('subscribe_status' => 'Active',
                );
                $this->common_model->updateRow(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION, $update_data, array("user_subscription_code" => $subscribed_code));
                /* Send newsletter subscription email */

                /* Activation link  */
                $email_data['activation_link'] = base_url() . 'home/newsletterUnsuscriber/' . $subscribed_code;
//                $email_data['activation_link'] = base_url() . 'home/newsletterUnsuscriber/' . $user_subscription_code;
                $email_content = $this->load->view('email_templates/newsletter_subscribe', $email_data, TRUE);

//                $mail = $this->common_model->sendEmail(array($arr_login_data[0]['user_email']), array("email" => $data['global']['site_email'], "name" => stripslashes($data['global']['site_title'])), $email_content['subject'], htmlspecialchars_decode($email_content['content']), $email_content['USER'], $email_content['unsubscribe_linK']);
                $mail = $this->common_model->sendEmail(array($arr_login_data[0]['user_email']), array("email" => config_item('site_email'), "name" => config_item('website_name')), 'You have subscribed to newsletter', $email_content);
                if ($mail) {
                    $this->session->set_flashdata("msg", "You have subscribed our newsletter successfully.");
                    redirect(base_url() . "#footernews");
                }
            }
        } else {
            /* if any error invalid activation link found account */
            $_SESSION['msg'] = '<div class="alert alert-error">Invalid unsubscribe code.</div>';
        }
        redirect(base_url() . "#footernews");
    }

    public function changeStatus() {
        if ($this->input->post('newsletter_subscription_id') != "") {
            /* updating the article status. */
            $arr_to_update = array("subscribe_status" => $this->input->post('subscribe_status'));
            /* condition to update record for the article status */
            $condition_array = array('newsletter_subscription_id' => intval($this->input->post('newsletter_subscription_id')));
            $this->common_model->updateRow(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION, $arr_to_update, $condition_array);

            $arr_newsletter_list = $this->subscriber_model->getSubcriberNewsletterDetailsById($this->input->post('newsletter_subscription_id'));

            // $table_to_pass = 'mst_users';
            //$fields_to_pass = '*';
            //$condition_to_pass = array("user_email" => $arr_newsletter_list[0]['user_email']);
            //$arr_user_data = $this->user_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);

            echo json_encode(array("error" => "0", "error_message" => ""));
        } else {
            /* if something going wrong providing error message.  */
            echo json_encode(array("error" => "1", "error_message" => "Sorry, your request can not be fulfilled this time. Please try again later"));
        }
    }
    
    
    public function newsletterSubscribtionchk(){
       $user_email= $this->input->post('user_email_newsletter');
       if($user_email != ''){
           $table_to_pass = TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION;
            $fields_to_pass = array('*');
            $condition_to_pass = array("user_email" => $user_email,"subscribe_status" => 'Active');
            $data['newsletetter_info'] = $this->subscriber_model->getSubscriberUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
            //echo '<pre>';print_r($data['newsletetter_info'] );die;
            if (count($data['newsletetter_info']) > 0) {
               echo'false';
           }else{
              echo'true' ;
           }
       }else{
           echo'false';
       }
    }
    
    
    public function addNewsletterSubscriberPromo() {
        /* Getting Common data */
//        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        /* checking user has privilige for the Manage Admin */
//        $data['global'] = $this->common_model->getGlobalSettings();

        $user_email = $this->input->post('user_email_newsletter');
        $table_to_pass = TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION;
        $fields_to_pass = array('*');
        $condition_to_pass = array("user_email" => $user_email);
        $data['newsletetter_info'] = $this->subscriber_model->getSubscriberUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        //print_r($data['newsletetter_info']);die;
        if (count($data['newsletetter_info']) > 0) {
            //die("sdf");
            $newsletter_code = $data['newsletetter_info'][0]['user_subscription_code'];
            $this->common_model->updateRow(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION, array('subscribe_status' => 'Active'), array('user_email' => $data['newsletetter_info'][0]['user_email']));
            //$this->newslettersubscribed($newsletter_code);
             /* Activation link  */
                $email_data['activation_link'] = base_url() . 'home/newsletterUnsuscriber/' . $newsletter_code;
                /* setting reserved_words for email content */
//                $macros_array_details = array();
//                $macros_array_details = $this->common_model->getRecords(TABLES::$EMAIL_TEMPLATE_MACROS, $fields_to_pass = 'macros,value', $condition_to_pass = '', $order_by = '', $limit = '', $debug = 0);
//                $macros_array = array();
//                foreach ($macros_array_details as $row) {
//                    $macros_array[$row['macros']] = $row['value'];
//                }
//                $reserved_words = array(
//                    "||SITE_TITLE||" => config_item('website_name'),
//                    "||SITE_PATH||" => base_url(),
//                    "||USER_NAME||" => $this->input->post('user_email'),
//                    "||UNSUBSCRIBE_LINK||" => $activation_link,
//                    "||SITE_URL||" => '<a href="' . base_url() . '">' . base_url() . '</a>'
//                );
//
//                $reserved = array_replace_recursive($macros_array, $reserved_words);
//
//                /* getting mail subect and mail message using email template title and lang_id and reserved works */
//                $email_content = $this->common_model->getEmailTemplateInfo('newsletter-subscription', $reserved);
                $email_content = $this->load->view('email_templates/newsletter_subscribe', $email_data, TRUE);
                
                $mail_send = $this->common_model->sendEmail(array($this->input->post('user_email_newsletter')), array("email" => config_item('site_email'), "name" => config_item('website_name')), 'You have subscribed to newsletter', $email_content);
                
                
                /*Mailchip code start here   */
                $email = $user_email;
                    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                // MailChimp API credentials
                $apiKey = '138bc8c3d1e964ea8f3876e4fb146bff-us13';
               // $listID = '96751abec3'; //original
                $listID = '77510fdf29'; //Rebelute Testing

                // MailChimp API URL
                $memberID   = md5(strtolower($email));
                $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
                $url        = 'https://'.$dataCenter.'.api.mailchimp.com/3.0/lists/'.$listID.'/members/'.$memberID;

                // member information
                $json = json_encode([
                    'email_address' => $email,
                    'status' => 'subscribed',
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
                
                /* Mailchip code end here   */
                
                
                
                
                echo 1;
        } else {
            /* insert subscriber user details */
            $user_subscription_code = rand(9999, 1000000000);
            $arr_fields = array(
                "user_email" => $this->input->post('user_email_newsletter'),
                "subscribe_status" => 'Active',
                "user_subscription_code" => $user_subscription_code,
                "is_subscribe_for_daily" => '0',
            );

            $last_insert_id = $this->subscriber_model->insertNewsletterSubscriber($arr_fields);
            if ($this->input->post('user_email_newsletter') != '') {

                /* Activation link  */
                $email_data['activation_link'] = base_url() . 'home/newsletterUnsuscriber/' . $user_subscription_code;
                /* setting reserved_words for email content */
//                $macros_array_details = array();
//                $macros_array_details = $this->common_model->getRecords(TABLES::$EMAIL_TEMPLATE_MACROS, $fields_to_pass = 'macros,value', $condition_to_pass = '', $order_by = '', $limit = '', $debug = 0);
//                $macros_array = array();
//                foreach ($macros_array_details as $row) {
//                    $macros_array[$row['macros']] = $row['value'];
//                }
//                $reserved_words = array(
//                    "||SITE_TITLE||" => config_item('website_name'),
//                    "||SITE_PATH||" => base_url(),
//                    "||USER_NAME||" => $this->input->post('user_email'),
//                    "||UNSUBSCRIBE_LINK||" => $activation_link,
//                    "||SITE_URL||" => '<a href="' . base_url() . '">' . base_url() . '</a>'
//                );
//
//                $reserved = array_replace_recursive($macros_array, $reserved_words);
//
//                /* getting mail subect and mail message using email template title and lang_id and reserved works */
//                $email_content = $this->common_model->getEmailTemplateInfo('newsletter-subscription', $reserved);
                $email_content = $this->load->view('email_templates/newsletter_subscribe', $email_data, TRUE);
                
                $mail_send = $this->common_model->sendEmail(array($this->input->post('user_email_newsletter')), array("email" => config_item('site_email'), "name" => config_item('website_name')), 'You have subscribed to newsletter', $email_content);
                
                
                /*Mailchip code start here   */
                $email = $user_email;
                    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                // MailChimp API credentials
                $apiKey = '138bc8c3d1e964ea8f3876e4fb146bff-us13';
                $listID = '96751abec3'; //original
                //$listID = '77510fdf29'; //Rebelute Testing

                // MailChimp API URL
                $memberID   = md5(strtolower($email));
                $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
                $url        = 'https://'.$dataCenter.'.api.mailchimp.com/3.0/lists/'.$listID.'/members/'.$memberID;

                // member information
                $json = json_encode([
                    'email_address' => $email,
                    'status' => 'subscribed',
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
                
                /* Mailchip code end here   */
                
                
                
                
                echo 1;
//                $this->session->set_flashdata("msg", "You have successfully subscribed to our newsletter.");
//                redirect(base_url() . "#footernews");
            }
        }
    }
    
    
    
    

}
