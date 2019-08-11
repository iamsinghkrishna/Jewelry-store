<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Newsletter extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('newsletter_model');
        $this->load->model('common_model');
        $this->load->model('subscriber_model');
        //checking admin is logged in or not
        $this->sesdata = $this->session->userdata('user_account');
        if ($this->sesdata['role_id'] == '1') {
            $this->sidebar = 'partials/admin_sidebar';
        } else if ($this->sesdata['role_id'] == '2') {
            $this->sidebar = 'partials/manager_sidebar';
        } else if ($this->sesdata['role_id'] == '3') {
            $this->sidebar = 'partials/agent_sidebar';
        } else {
            $this->sidebar = 'partials/user_sidebar';
        }
    }

    public function listNewsletter() { 
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        //Getting Common data
        $data = $this->common_model->commonFunction();
        //checking for admin privilages
        if ($data['user_account']['role_id'] != 1) {
            $arr_privileges = $this->common_model->getRecords('trans_role_privileges', 'privilege_id', array("role_id" => $data['user_account']['role_id']));
            if (count($arr_privileges) > 0) {
                foreach ($arr_privileges as $privilege) {
                    $user_privileges[] = $privilege['privilege_id'];
                }
            }

            if (in_array('23', $arr_login_admin_privileges) == FALSE) {
                /* an admin which is not super admin not privileges to access Manage Role
                 * setting session for displaying notiication message. */
                $this->session->set_userdata("permission_msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
                redirect(base_url() . "backend/home");
                exit();
            }
        }
        //getting all ides selected
        $arr_newsletter_ids = array();
        if ($this->input->post('checkbox') != '') {
            $arr_newsletter_ids = $this->input->post('checkbox');
            if (count($arr_newsletter_ids) > 0) {
                if (count($arr_newsletter_ids) > 0) {
                    //deleting the newsletter selected
                    $this->common_model->deleteRows($arr_newsletter_ids, TABLES::$MST_NEWSLETTER, "newsletter_id");
                }
                $msg_data = array('msg_type' => 'success', 'newsletter_msg_val' => 'Records deleted successfully.');
                $this->session->set_flashdata('newsletter_msg', $msg_data);
                redirect(base_url() . "admin/newsletter/list");
            }
        }

        $data['arr_newsletter_list'] = $this->newsletter_model->getNewsletterDetails();
//        print_r($data['arr_newsletter_list']);die;
        $this->template->set('arr_newsletter_list', $data['arr_newsletter_list']);
        $this->template->set('page', 'newsletter_subscriber');
        $this->template->set_theme('default_theme');
        $this->template->set_layout('backend')
                ->title('Manage Contact Us | ' . config_item('site_title'))
                ->set_partial('header', 'partials/header')
                ->set_partial('sidebar', $this->sidebar)
                ->set_partial('footer', 'partials/footer');
        $this->template->build('admin/newsletter/list');
    }

    public function changeStatus() {
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        if ($this->input->post('newsletter_id') != "") {
            //updating the newsletter status.
            $arr_to_update = array(
                "newsletter_status" => $this->input->post('status')
            );
            //condition to update record	for the newsletter status
            $condition_array = array('newsletter_id' => ($this->input->post('newsletter_id')));
            $this->common_model->updateRow('mst_newsletter', $arr_to_update, $condition_array);
            echo json_encode(array("error" => "0", "error_message" => "Status has been changed successflly."));
        } else {
            //if something going wrong providing error message. 
            echo json_encode(array("error" => "1", "error_message" => "Sorry, your request can not be fulfilled this time. Please try again later"));
        }
    }

    public function addNewsletter() {
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        //Getting Common data
        $data = $this->common_model->commonFunction();
        //checking for admin privilages
        if ($data['user_account']['role_id'] != 1) {
            $arr_privileges = $this->common_model->getRecords('trans_role_privileges', 'privilege_id', array("role_id" => $data['user_account']['role_id']));
            if (count($arr_privileges) > 0) {
                foreach ($arr_privileges as $privilege) {
                    $user_privileges[] = $privilege['privilege_id'];
                }
            }
            $arr_login_admin_privileges = $user_privileges;
            if (in_array('23', $arr_login_admin_privileges) == FALSE) {
                /* an admin which is not super admin not privileges to access Manage Role
                 * setting session for displaying notiication message. */
                $this->session->set_userdata("permission_msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
                redirect(base_url() . "backend/home");
                exit();
            }
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="validationError">', '</p>');
        $this->form_validation->set_rules('input_subject', 'newsletter subject', 'required');
        $this->form_validation->set_rules('input_content', 'newsletter content', 'required');

        if ($this->form_validation->run() == true) {
            $newsletter_details = array("newsletter_subject" => $this->input->post('input_subject'), "newsletter_content" => $this->input->post('input_content'), "add_date" => date('Y-m-d H:i:s'));
            $this->newsletter_model->addNewsletterDetails($newsletter_details);
            $msg_data = array('msg_type' => 'success', 'newsletter_msg_val' => 'Record added successfully.');
            $this->session->set_flashdata('newsletter_msg', $msg_data);
            redirect(base_url() . "admin/newsletter/list");
        }

        
        $this->template->set('page', 'newsletter_subscriber');
        $this->template->set_theme('default_theme');
        $this->template->set_layout('backend')
                ->title('Add Newsletter | ' . config_item('site_title'))
                ->set_partial('header', 'partials/header')
                ->set_partial('sidebar', $this->sidebar)
                ->set_partial('footer', 'partials/footer');
        $this->template->build('admin/newsletter/add');
    }

    public function uploadClEditorImage() {
        if ($_FILES["imageName"]['name'] != "") {
            $file_destination = "media/backend/userfiles/" . str_replace(" ", "_", microtime()) . "." . strtolower(end(explode(".", $_FILES["imageName"]['name'])));
            move_uploaded_file($_FILES['imageName']['tmp_name'], $file_destination);
            $image_main = $file_destination;
            $source_img = $_FILES['imageName']['tmp_name'];
            $image_main = $this->common_model->compress_image($source_img, $image_main, 80);
            ?>
            <div id="image"><?php echo base_url() . $file_destination; ?></div>
            <?php
        } else {
            echo "false";
        }
    }

    public function editNewsletter($newsletter_id) {
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        //Getting Common data
        $data = $this->common_model->commonFunction();
        //checking for admin privilages
        if ($data['user_account']['role_id'] != 1) {
            $arr_privileges = $this->common_model->getRecords('trans_role_privileges', 'privilege_id', array("role_id" => $data['user_account']['role_id']));
            if (count($arr_privileges) > 0) {
                foreach ($arr_privileges as $privilege) {
                    $user_privileges[] = $privilege['privilege_id'];
                }
            }
            $arr_login_admin_privileges = $user_privileges;
            if (in_array('23', $arr_login_admin_privileges) == FALSE) {
                /* an admin which is not super admin not privileges to access Manage Role
                 * setting session for displaying notiication message. */
                $this->session->set_userdata("permission_msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
                redirect(base_url() . "backend/home");
                exit();
            }
        }
        $arr_newsletter_data = array();
        /*
         * Get newsletter details by id
         */
        $arr_newsletter_data = $this->newsletter_model->getNewsletterDetailById($newsletter_id);
        /*
         * If invalid newsletter id the requiret to newsletter listing page
         */
        if (count($arr_newsletter_data) == 0) {
            $msg_data = array('msg_type' => 'error', 'newsletter_msg_val' => 'Invalid url.');
            $this->session->set_userdata('newsletter_msg', $msg_data);
            redirect(base_url() . "backend/newsletter/list");
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="validationError">', '</p>');
        $this->form_validation->set_rules('input_subject', 'newsletter subject', 'required');
        $this->form_validation->set_rules('input_content', 'newsletter content', 'required');

        if ($this->form_validation->run() == true) {
            $newsletter_details = array("newsletter_subject" => $this->input->post('input_subject'), "newsletter_content" => $this->input->post('input_content'), "update_date" => date('Y-m-d'));
            $condition = array('newsletter_id' => $newsletter_id);
            $this->newsletter_model->updateNewsletterDetails($newsletter_details, $condition);
            $msg_data = array('msg_type' => 'success', 'newsletter_msg_val' => 'Record updated successfully.');
            $this->session->set_userdata('newsletter_msg', $msg_data);
            redirect(base_url() . "backend/newsletter/list");
        }

        //using the newsletter model
        $data['title'] = "Edit Newsletter";
        $data['arr_newsletter_data'] = $arr_newsletter_data[0];
        $this->load->view('backend/newsletter/edit', $data);
    }

    /*
     * function to send newsletter 
     */

    function sendNewsletter($newsletter_id = '') {
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        $data = $this->common_model->commonFunction();
        $data['global'] = $this->common_model->getGlobalSettings();
        $attachement = "No";
        $attachement_path = "";
        $data['email_template'] = $this->newsletter_model->getNewsletterDetailsById($newsletter_id);
        if ($this->input->post('newsletter_id') != "") {
            if ($_FILES['attachement']['name'] == "") {
                $attachement = "No";
                $attachement_path = "";
                $attachment_here = "No attachemnt";
                $path_attachment = '#';
            } else {
                $attachement = "Yes";
                $config['upload_path'] = './media/backend/img/newsletter-img/';
                $config['allowed_types'] = '*';
                $config['max_size'] = '';
                $config['file_name'] = time();
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('attachement')) {
                    $attachment_here = "No attachemnt";
                    $path_attachment = '#';
                    $this->upload->display_errors();
                    $error = array('error' => $this->upload->display_errors());
                    //echo '<pre>';print_r($error);
                    $msg_data = array('msg_type' => 'error', 'newsletter_msg_val' => $this->upload->display_errors());
                    $this->session->set_userdata('newsletter_msg', $msg_data);
                    $this->session->set_userdata('image_not_uploaded', 'yes');
                } else {
                    $image_data = $this->upload->data();
                    $image_main = $data['absolute_path'] . 'media/backend/img/newsletter-img/' . $image_data['file_name'];
                    $source_img = $_FILES['attachement']['tmp_name'];
                    $image_main = $this->common_model->compress_image($source_img, $image_main, 80);

                    $attachment_here = "Click here to download attachemnt";
                    $path_attachment = base_url() . 'media/backend/img/newsletter-img/' . $image_data['file_name'];
                }
                $attachement_path = $image_data['file_name'];
            }
            $emails = $this->input->post("list_of_users");
            $email_for_newsletter = explode(",", $emails);

            foreach ($email_for_newsletter as $email) {
                $newsletter_content = $data['email_template'][0]["newsletter_content"];
                $var_array = array("%%user_email%%" => $email);
                $condition = array("user_email" => $email);
                $user_details = $this->common_model->getRecords("mst_users", $fields = '', $condition, $order_by = '', $limit = '', $debug = 0);
                $newsletter_details = array("user_email" => $email, "user_id" => $user_details[0]['user_id'], "newsletter_id" => $newsletter_id, "newsletter_subject" => $this->input->post('subject'), "newsletter_content" => $newsletter_content, "attachement" => $attachement, "attachement_path" => $attachement_path, "date_created" => date('Y-m-d H:i:s'));
                $this->newsletter_model->sendNewsletterDetails($newsletter_details);

                $macros_array_details = array();
                $macros_array_details = $this->common_model->getRecords(TABLES::$EMAIL_TEMPLATE_MACROS, $fields_to_pass = 'macros,value', $condition_to_pass = '', $order_by = '', $limit = '', $debug = 0);
                $macros_array = array();
                foreach ($macros_array_details as $row) {
                    $macros_array[$row['macros']] = $row['value'];
                }
                $reserved_words = array(
                    "||SITE_TITLE||" => stripslashes($data['global']['site_title']),
                    "||SITE_PATH||" => base_url(),
                    "||USER_NAME||" => $user_details[0]['first_name'] . '  ' . $user_details[0]['last_name'],
                    "||TITLE||" => $data['email_template'][0]['newsletter_subject'],
                    "||CONTENT||" => strip_tags($data['email_template'][0]['newsletter_subject']),
                    "||ATTACHMENT||" => '<a href="' . $path_attachment . '">' . $attachment_here . '</a>',
                    "||SITE_URL||" => '<a href="' . base_url() . '">' . base_url() . '</a>',
                );

                $reserved = array_replace_recursive($macros_array, $reserved_words);

                /* getting mail subect and mail message using email template title and lang_id and reserved works */
                $email_content = $this->common_model->getEmailTemplateInfo('send-newsletter', $reserved);
                //echo '<pre>';print_r($email_content);die;
                $subject = $email_content['subject'];
                $mail = $this->common_model->sendEmail(array($email), array("email" => $data['global']['site_email'], "name" => stripslashes($data['global']['site_title'])), $subject, $email_content['content']);

                //$result = $this->emailTemplates($data['email_template'], $var_array, $data, $email, $attachement, $attachement_path);
            }
            $msg_data = array('msg_type' => 'success', 'newsletter_msg_val' => 'Newsletter sent successfully.');
            $this->session->set_userdata('newsletter_msg', $msg_data);
            redirect("backend/newsletter/list");
        }

        $data['logged_username'] = $this->session->userdata('admin_name');
        $data['title'] = 'Send newsletter ';
        $data['newsletter_id'] = $newsletter_id;
        $this->load->view('backend/newsletter/send-newsletter', $data);
    }

    public function emailTemplates($templateDetails, $var_array, $global, $to_email, $attachement, $attachement_path) {

        $data['global'] = $this->common_model->getGlobalSettings();
        $config['protocol'] = 'mail';
        $config['wordwrap'] = true;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";

        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from($data['global']['site_email'], stripslashes($data['global']['site_title']));
        $this->email->to($to_email);


        $this->email->subject(($templateDetails[0]['newsletter_subject']));
        foreach ($var_array as $k => $v) {
            $templateDetails[0]['newsletter_content'] = str_replace($k, $v, $templateDetails[0]['newsletter_content']);
        }
        $this->email->message($templateDetails[0]['newsletter_subject']);
        $absolute_path = $this->common_model->absolutePath();

        if ($attachement == "1") {
            $this->email->attach($absolute_path . "/media/backend/img/newsletter_attachment/" . $attachement_path);
        }
        $result = $this->email->send();

        $this->email->clear(TRUE);
    }

    /*
     * function to get all users to send newsletter on selected conditions
     */

    public function gettingAllUsersByStatus() {
        $user_status = $this->input->post('user_status');
        $status_to_pass = "Inactive";
        if ($user_status == '1') {
            $status_to_pass = "Active";
            $users['user_list'] = $this->newsletter_model->getAllUsersByStatus($user_status);
            $i = 0;
            foreach ($users['user_list'] as $userEmail) {
                if ($i > 0)
                    echo ",";
                $userEmail['newsletter_subscription_id'];
                echo $userEmail['user_email'];
                $i++;
            }
        }elseif ($user_status == '0') {
            $status_to_pass = "Inactive";
            $users['user_list'] = $this->newsletter_model->getAllUsersByStatus($user_status);
            $i = 0;
            foreach ($users['user_list'] as $userEmail) {
                if ($i > 0)
                    echo ",";
                $userEmail['newsletter_subscription_id'];
                echo $userEmail['user_email'];
                $i++;
            }
        } elseif ($user_status == '2') {
            $status_to_pass = "Blocked";
            $users['user_list'] = $this->newsletter_model->getAllUsersByStatus($user_status);
            $i = 0;
            foreach ($users['user_list'] as $userEmail) {
                if ($i > 0)
                    echo ",";
                $userEmail['newsletter_subscription_id'];
                echo $userEmail['user_email'];
                $i++;
            }
        } elseif ($user_status == '3') {
            $status_to_pass = "Subscribed";
            $users['user_list'] = $this->newsletter_model->getAllUsersByStatus($user_status);
            $i = 0;
            foreach ($users['user_list'] as $userEmail) {
                if ($i > 0)
                    echo ",";
                $userEmail['newsletter_subscription_id'];
                echo $userEmail['user_email'];
                $i++;
            }
        }
    }

    public function chkEmailDuplicate() {
        $this->load->model('register_model');
        $user_email = $this->input->post('user_email');
        $table_to_pass = 'trans_newsletter_subscription';
        $fields_to_pass = array('user_email');
        $condition_to_pass = array("user_email" => $user_email);
        $arr_login_data = $this->register_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        if (count($arr_login_data)) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function addNewsletterSubscriber() {

        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        /* checking user has privilige for the Manage Admin */
        $data['global'] = $this->common_model->getGlobalSettings();
        $user_email = $this->input->post('user_email');
        $table_to_pass = 'trans_newsletter_subscription';
        $fields_to_pass = array('user_email');
        $condition_to_pass = array("user_email" => $user_email, "subscribe_status" => 'Active');
        $data['newsletetter_info'] = $this->subscriber_model->getSubscriberUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass);
        if (count($data['newsletetter_info']) > 0) {
            $newsletter_code = $data['newsletetter_info'][0]['user_subscription_code'];
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
                $activation_link = '<a href="' . base_url() . 'newsletter-unsubscribe/' . $user_subscription_code . '">Unsubscribe</a>';
                /* setting reserved_words for email content */
                $macros_array_details = array();
                $macros_array_details = $this->common_model->getRecords(TABLES::$EMAIL_TEMPLATE_MACROS, $fields_to_pass = 'macros,value', $condition_to_pass = '', $order_by = '', $limit = '', $debug = 0);
                $macros_array = array();
                foreach ($macros_array_details as $row) {
                    $macros_array[$row['macros']] = $row['value'];
                }
                $reserved_words = array(
                    "||SITE_TITLE||" => stripslashes($data['global']['site_title']),
                    "||SITE_PATH||" => base_url(),
                    "||USER_NAME||" => $this->input->post('user_email'),
                    "||UNSUBSCRIBE_LINK||" => $activation_link,
                    "||SITE_URL||" => '<a href="' . base_url() . '">' . base_url() . '</a>'
                );

                $reserved = array_replace_recursive($macros_array, $reserved_words);

                /* getting mail subect and mail message using email template title and lang_id and reserved works */
                $email_content = $this->common_model->getEmailTemplateInfo('newsletter-subscription', $reserved);

                $mail = $this->common_model->sendEmail(array($this->input->post('user_email')), array("email" => $data['global']['site_email'], "name" => stripslashes($data['global']['site_title'])), $email_content['subject'], $email_content['content'], $email_content['USER'], $email_content['unsubscribe_linK']);

                $this->session->set_userdata("success_message", "You have successfully subscribed to our newsletter.");
                redirect(base_url() . "cms/thank-you");
            }
        }
    }

    public function newsletterUnsubscribed($unsubscribe_code) { 
        //Get global settings.
        $data['global'] = $this->common_model->getGlobalSettings();
       
        $fields_to_pass = array('newsletter_subscription_id', 'user_email', 'subscribe_status', 'is_subscribe_for_daily');
        /* get user details to verify the email address */
        $data['newsletetter_info'] = $this->common_model->getRecords(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION, $fields_to_pass, array("user_subscription_code" => $unsubscribe_code));

        if ($data['newsletetter_info'][0]['subscribe_status'] == 'Inactive') {
            $this->session->set_userdata('contact_fail', 'You have already unsubscribed from our newsletter.');
            redirect(base_url());
        } else if ($data['newsletetter_info'][0]['subscribe_status'] == 'Active') {
            $update_data = array(
                'subscribe_status' => 'Inactive',
            );
            //echo '<pre>';print_r($update_data);die;
            $this->common_model->updateRow(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION, $update_data, array("user_subscription_code" => $unsubscribe_code));
            /* Activation link  */
            $activation_link = '<a href="' . base_url() . 'newsletter-subscribe/' . $unsubscribe_code . '">Subscribe Newsletter.</a>';
            /* setting reserved_words for email content */
            $macros_array_details = array();
            $macros_array_details = $this->common_model->getRecords(TABLES::$EMAIL_TEMPLATE_MACROS, $fields_to_pass = 'macros,value', $condition_to_pass = '', $order_by = '', $limit = '', $debug = 0);
            $macros_array = array();
            foreach ($macros_array_details as $row) {
                $macros_array[$row['macros']] = $row['value'];
            }

            $reserved_words = array(
                "||SITE_TITLE||" => stripslashes($data['global']['site_title']),
                "||SITE_PATH||" => base_url(),
                "||USER_NAME||" => $data['newsletetter_info'][0]['user_email'],
                "||SUBSCRIBE_LINK||" => $activation_link,
                "||SITE_URL||" => '<a href="' . base_url() . '">' . base_url() . '</a>'
            );
            $reserved = array_replace_recursive($macros_array, $reserved_words);
            /* getting mail subect and mail message using email template title and lang_id and reserved works */
            $email_content = $this->common_model->getEmailTemplateInfo('newsletter-unsubscription', $reserved);
            $mail = $this->common_model->sendEmail(array($data['newsletetter_info'][0]['user_email']), array("email" => $data['global']['site_email'], "name" => stripslashes($data['global']['site_title'])), $email_content['subject'], $email_content['content'], $email_content['USER'], $email_content['unsubscribe_linK']);
            if ($mail) {
                $this->session->set_flashdata("msg", "You have successfully unsubscribed from our newsletter.");
                redirect(base_url() . "#footernews");
            }
        } else {
            /* if any error invalid activation link found account */
            $this->session->set_flashdata("msg", '<div class="alert alert-error">Invalid unsubscribe code.</div>');
//            $_SESSION['msg'] = '<div class="alert alert-error">Invalid unsubscribe code.</div>';
        }
        redirect(base_url() . "#footernews");
    }

    public function newsletterSubscribed($subscribed_code) {
        //Get global settings.
        $data['global'] = $this->common_model->getGlobalSettings();

        $fields_to_pass = array('newsletter_subscription_id', 'user_email', 'subscribe_status', 'is_subscribe_for_daily');
        /* get user details to verify the email address */
        $arr_login_data = $this->common_model->getRecords(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION, $fields_to_pass, array("user_subscription_code" => $subscribed_code));
        if (count($arr_login_data)) {
            $user_unsubscription_code = rand(9999, 1000000000);
            /* if email already verified */
            if ($arr_login_data[0]['subscribe_status'] == "Active") {
                $this->session->set_userdata('contact_fail', 'You have already subscribed to our newsletter.');
            } else {
                /* if email not verified. */
                $update_data = array('subscribe_status' => 'Active',
                );
                $this->common_model->updateRow(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION, $update_data, array("user_subscription_code" => $subscribed_code));
                /* Send newsletter subscription email */

                /* Activation link  */
                $activation_link = '<a href="' . base_url() . 'newsletter-unsubscribe/' . $user_unsubscription_code . '">unsubscribe.</a>';
                /* setting reserved_words for email content */
                $macros_array_details = array();
                $macros_array_details = $this->common_model->getRecords(TABLES::$EMAIL_TEMPLATE_MACROS, $fields_to_pass = 'macros,value', $condition_to_pass = '', $order_by = '', $limit = '', $debug = 0);
                $macros_array = array();
                foreach ($macros_array_details as $row) {
                    $macros_array[$row['macros']] = $row['value'];
                }

                $reserved_words = array(
                    "||SITE_TITLE||" => stripslashes($data['global']['site_title']),
                    "||SITE_PATH||" => base_url(),
                    "||USER_NAME||" => $arr_login_data[0]['user_email'],
                    "||UNSUBSCRIBE_LINK||" => $activation_link,
                    "||SITE_URL||" => '<a href="' . base_url() . '">' . base_url() . '</a>'
                );

                $reserved = array_replace_recursive($macros_array, $reserved_words);
                /* getting mail subect and mail message using email template title and lang_id and reserved works */
                $email_content = $this->common_model->getEmailTemplateInfo('newsletter-subscription', $reserved);
                $mail = $this->common_model->sendEmail(array($arr_login_data[0]['user_email']), array("email" => $data['global']['site_email'], "name" => stripslashes($data['global']['site_title'])), $email_content['subject'], $email_content['content'], $email_content['USER'], $email_content['unsubscribe_linK']);

                if ($mail) {
                    $this->session->set_flashdata("msg", "You subscribed our newsletter successfully.");
                    redirect(base_url() . "#footernews");
                }
            }
        } else {
            /* if any error invalid activation link found account */
            $_SESSION['permission_msg'] = '<div class="alert alert-error">Invalid unsubscribe code.</div>';
        }
        redirect(base_url());
    }

}
