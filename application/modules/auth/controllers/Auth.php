<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->model(array('users'));
        $this->load->helper(array('url', 'language'));
        $this->load->library('user_agent');
        $this->load->model('Common_model_marketing');
        $this->load->model('common_model');
        $this->load->model('Demo_cart_model');

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
//$this->data['csrf'] = $this->_get_csrf_nonce();
//                $this->data['code'] = $code;
        $this->lang->load('auth');
        $this->store_salt = $this->config->item('store_salt', 'ion_auth');
    }

    // redirect if needed, otherwise display the user list
    public function index() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } elseif (!$this->ion_auth->is_admin()) { // remove this elseif if you want to enable this for non-admins
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        } else {
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            //list the users
            $this->data['users'] = $this->ion_auth->users()->result();
            
            foreach ($this->data['users'] as $k => $user) {
                $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
            }

            $user_id = $this->session->userdata('user_id');
            $data['dataHeader'] = $this->users->get_allData($user_id);


            $this->template->set_master_template('template.php');
            $this->template->write_view('header', 'backend/header', (isset($data) ? $data : NULL));
            $this->template->write_view('sidebar', 'backend/sidebar', (isset($this->data) ? $this->data : NULL));
            $this->template->write_view('content', 'index', (isset($this->data) ? $this->data : NULL), TRUE);
            $this->template->write_view('footer', 'backend/footer', '', TRUE);
            $this->template->render();
        }
    }

    // log the user in
    public function login() {


//        $url = $_SERVER['HTTP_REFERER'];
        $this->data['title'] = $this->lang->line('login_heading');

        //validate form input
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

        if ($this->form_validation->run() == true) {
            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                //if the login is successful
                //redirect them back to the home page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                if ($this->ion_auth->is_admin()) {

                    if (strpos($_SERVER['HTTP_REFERER'], "cart"))
                        redirect('/home/cart', 'refresh');
                    else
                        redirect('/admin', 'refresh');
                } else {
                    if (strpos($_SERVER['HTTP_REFERER'], "cart"))
                        redirect('/home/cart', 'refresh');
                    else
                        redirect('/home', 'refresh');
                }
            } else {
                // if the login was un-successful
                // redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {
            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'class' => 'form-control',
                'data-error' => '.lgnErorr1',
                'autofocus' => 'autofocus',
                'placeholder' => 'Username',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => 'Password',
                'data-error' => '.lgnErorr2',
            );
            // regisration
            $this->data['first_name'] = array(
                'name' => 'first_name',
                'id' => 'first_name',
                'class' => 'form-control',
                'data-error' => '.regErorr1',
                'autofocus' => 'autofocus',
                'type' => 'text',
                'placeholder' => 'Fist Name',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name' => 'last_name',
                'id' => 'last_name',
                'class' => 'form-control',
                'data-error' => '.regErorr2',
                'type' => 'text',
                'placeholder' => 'Last Name',
                'value' => $this->form_validation->set_value('last_name'),
            );
//        
            $this->data['email'] = array(
                'name' => 'email',
                'id' => 'email',
                'type' => 'text',
                'class' => 'form-control',
                'data-error' => '.regErorr4',
                'placeholder' => 'Email',
                'value' => $this->form_validation->set_value('email'),
            );
//        
            $this->data['phone'] = array(
                'name' => 'phone',
                'id' => 'phone',
                'type' => 'text',
                'class' => 'form-control',
                'data-error' => '.regErorr6',
                'placeholder' => 'Phone',
                'value' => $this->form_validation->set_value('phone'),
            );
            $this->data['password'] = array(
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'class' => 'form-control',
                'data-error' => '.regErorr7',
                'placeholder' => 'Password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name' => 'password_confirm',
                'id' => 'password_confirm',
                'type' => 'password',
                'class' => 'form-control',
                'data-error' => '.regErorr8',
                'placeholder' => 'Confirm Password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );


            //$this->_render_page('login', $this->data);
            $this->template->set_master_template('login_template.php');
            $this->template->write_view('content', '_login', (isset($this->data) ? $this->data : NULL), TRUE);
            $this->template->render();
        }
    }

    // log the user out
    public function logout() {
        $this->data['title'] = "Logout";

        // log the user out
        $logout = $this->ion_auth->logout();

        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('', 'refresh');
    }

    public function logout_home() {
        $this->load->library('facebook');
        $this->data['title'] = "Logout";

        // log the user out
        $logout = $this->ion_auth->logout();
        $this->facebook->destroy_session();
        $this->facebook->logout_url();
        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('home', 'refresh');
    }

    // change password
    public function change_password() {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

//        if (!$this->ion_auth->logged_in()) {
//            redirect('auth/login', 'refresh');
//        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() == false) {
            // display the form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
                'class' => 'form-control',
                'data-error' => '.regErorr8',
                'placeholder' => 'Old Password'
            );
            $this->data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                'class' => 'form-control',
                'data-error' => '.regErorr8',
                'placeholder' => 'New Password'
            );
            $this->data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                'class' => 'form-control',
                'data-error' => '.regErorr8',
                'placeholder' => 'New Confirm Password'
            );

            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $user->id,
            );

            // render
            // $this->_render_page('auth/change_password', $this->data);
            $this->template->set_master_template('login_template.php');
            $this->template->write_view('content', 'change_password', (isset($this->data) ? $this->data : NULL), TRUE);
            $this->template->render();
        } else {
            $identity = $this->session->userdata('identity');

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change) {
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->logout();
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/change_password', 'refresh');
            }
        }
    }

    // forgot password
    public function forgot_password() {

        // setting validation rules by checking whether identity is username or email
        if ($this->config->item('identity', 'ion_auth') != 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
        } else {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }


        if ($this->form_validation->run() == false) {
            $this->data['type'] = $this->config->item('identity', 'ion_auth');
            // setup the input

            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'class' => 'form-control',
                'data-error' => '.lgnErorr1',
                'autofocus' => 'autofocus',
                'placeholder' => 'Email',
                'value' => $this->form_validation->set_value('identity'),
            );

            if ($this->config->item('identity', 'ion_auth') != 'email') {
                $this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
            } else {
                $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }

            // set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            //$this->_render_page('auth/forgot_password', $this->data);
            $this->template->set_master_template('login_template.php');
            $this->template->write_view('content', 'forgot_password', (isset($this->data) ? $this->data : NULL), TRUE);
            $this->template->render();
        } else {
            $identity_column = $this->config->item('identity', 'ion_auth');
            $identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

            if (empty($identity)) {

                if ($this->config->item('identity', 'ion_auth') != 'email') {
                    $this->ion_auth->set_error('forgot_password_identity_not_found');
                } else {
                    $this->ion_auth->set_error('forgot_password_email_not_found');
                }

                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
            }

            // run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

            if ($forgotten) {
                // if there were no errors
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
            }
        }
    }

    // reset password - final step for forgotten password
    public function reset_password($code = NULL) {
        if (!$code) {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {
            // if the code is valid then display the password reset form

            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() == false) {
                // display the form
                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                );
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;

                // render
                $this->_render_page('auth/reset_password', $this->data);
            } else {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

                    // something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_error($this->lang->line('error_csrf'));
                } else {
                    // finally change the password
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change) {
                        // if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect("auth/login", 'refresh');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('auth/reset_password/' . $code, 'refresh');
                    }
                }
            }
        } else {
            // if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    // activate the user
    public function activate($id, $code = false) {
        if ($code !== false) {
            $activation = $this->ion_auth->activate($id, $code);
        } else if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation) {
            // redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth", 'refresh');
        } else {
            // redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    // deactivate the user
    public function deactivate($id = NULL) {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        }

        $id = (int) $id;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() == FALSE) {
            // insert csrf check
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['user'] = $this->ion_auth->user($id)->row();
            $user_id = $this->session->userdata('user_id');
            $data['dataHeader'] = $this->users->get_allData($user_id);
            $this->template->set_master_template('template.php');
            $this->template->write_view('header', 'backend/header', (isset($data) ? $data : NULL));
            $this->template->write_view('sidebar', 'backend/sidebar', (isset($this->data) ? $this->data : NULL));
            $this->template->write_view('content', 'deactivate_user', (isset($this->data) ? $this->data : NULL), TRUE);
            $this->template->write_view('footer', 'backend/footer', '', TRUE);
            $this->template->render();

            $this->_render_page('auth/deactivate_user', $this->data);
        } else {
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes') {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                    show_error($this->lang->line('error_csrf'));
                }

                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
                    $this->ion_auth->deactivate($id);
                }
            }

            // redirect them back to the auth page
            redirect('auth', 'refresh');
        }
    }

    //register user
    public function register_user() {

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if ($identity_column !== 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        } else {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true) {
            $email = strtolower($this->input->post('email'));
            $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');
            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'phone' => $this->input->post('phone'),
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data)) {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth/login");
        } else {

            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->session->set_flashdata('message', $this->data['message']);
            redirect("auth/login#signup");
        }
    }

    // create a new user
    public function create_user() {

        $user_id = $this->session->userdata('user_id');
        $data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['title'] = $this->lang->line('create_user_heading');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth/login#signup', 'refresh');
        }

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if ($identity_column !== 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        } else {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true) {
            $email = strtolower($this->input->post('email'));
            $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');



            /* Upload profile picture */
//            if (isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != '') {
//                $targetDir = "uploads/";
//                $fileName = $_FILES['profile_image']['name'];
//                $targetFile = $targetDir . $fileName;
//
//                $slug = $this->input->post('name');
//
//                $fileExt = pathinfo($_FILES['profile_image']['name']);
//                $dataDocumentDetail['type'] = $fileExt['extension'];
//
//
//                $uploded_file_path = $this->handleUploadUser($slug);
//                if ($uploded_file_path != '')
//                    $data['profileimg'] = $slug . '/profile/' . $uploded_file_path;
//                //echo $slug . '/profile/' . $uploded_file_path;die;
//            }
            
            
            
            
            
            if ($_FILES['profile_image']['name'] != '') {
                    $_FILES['profile_image']['name'];
                    $_FILES['profile_image']['type'];
                    $_FILES['profile_image']['tmp_name'];
                    $_FILES['profile_image']['error'];
                    $_FILES['profile_image']['size'];
                    $config['file_name'] = time() . rand();
                    $config['upload_path'] = FCPATH . 'media/backend/img/profile';
                    $config['allowed_types'] = 'jpg|jpeg|gif|png';
                    $config['max_size'] = '9000000';
                    $this->load->library('upload');
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('profile_image')) {
                        $data['upload_data'] = $this->upload->data();
                        //$ar = list($width, $height) = getimagesize($data['full_path']);
                        $upload_result = $this->upload->data();
                        /* for image */
                        $image_config = array(
                            'source_image' => $upload_result['full_path'],
                            'new_image' => FCPATH . "media/backend/img/profile/300x300/",
                            'maintain_ratio' => false,
                            'width' => 300,
                            'height' => 300
                        );
                        $this->load->library('image_lib');
                        $this->image_lib->initialize($image_config);
                        $resize_rc = $this->image_lib->resize();
                        /* for image  540x360 */
                        


                        $img_path = $upload_result['file_name'];
                    } else {
                        $error = array('error' => $this->upload->display_errors());
                    }
                } else {
                    $img_path = '';
                }
            
            
            
            

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
                'profileimg' => $img_path,
                'birth_date' => date('y-m-d', strtotime($this->input->post('birth_date'))),
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data)) {
            // check to see if we are creating the user
            // redirect them back to the admin page
             $this->session->set_userdata('msg','User created successfully.');
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            //redirect("auth/login#signup");
            redirect("auth");
        } else {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['first_name'] = array(
                'name' => 'first_name',
                'id' => 'first_name',
                'class' => 'form-control',
                'data-error' => '.regErorr1',
                'autofocus' => 'autofocus',
                
                'type' => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name' => 'last_name',
                'id' => 'last_name',
                'class' => 'form-control',
                'data-error' => '.regErorr2',
                'type' => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['identity'] = array(
                'name' => 'identity',
                'id' => 'identity',
                'class' => 'form-control',
                'data-error' => '.regErorr3',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['email'] = array(
                'name' => 'email',
                'onblur'=>"checkDuplicateEmail(this.value);",
                'id' => 'email',
                'type' => 'text',
                'class' => 'form-control',
                'data-error' => '.regErorr4',
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['company'] = array(
                'name' => 'company',
                'id' => 'company',
                'type' => 'text',
                'class' => 'form-control',
                'data-error' => '.regErorr5',
                'value' => $this->form_validation->set_value('company'),
            );
            $this->data['phone'] = array(
                'name' => 'phone',
                'id' => 'phone',
                'type' => 'text',
                'class' => 'form-control',
                'data-error' => '.regErorr6',
                'value' => $this->form_validation->set_value('phone'),
            );
            $this->data['password'] = array(
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'class' => 'form-control',
                'data-error' => '.regErorr7',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name' => 'password_confirm',
                'id' => 'password_confirm',
                'type' => 'password',
                'class' => 'form-control',
                'data-error' => '.regErorr8',
                'value' => $this->form_validation->set_value('password_confirm'),
            );
            $this->data['birth_date'] = array(
                'type' => 'date',
                'name' => 'birth_date',
                'id' => 'birth_date',
                'class' => 'form-control has-feedback-left',
                'data-error' => '.regErorr9',
                'value' => $this->form_validation->set_value('birth_date'),
            );
            $this->data['profile_image'] = array(
                'name' => 'profile_image',
                'id' => 'profile_image',
                'type' => 'file',
                'class' => 'form-control',
                'data-error' => '.regErorr10',
                'onchange'=> "chkFile(this.value,'profile_image');",
                'value' => $this->form_validation->set_value('profile_image'),
            );


            $this->template->set_master_template('template.php');
            $this->template->write_view('header', 'backend/header', (isset($data) ? $data : NULL));
            $this->template->write_view('sidebar', 'backend/sidebar', (isset($this->data) ? $this->data : NULL));
            $this->template->write_view('content', 'create_user', (isset($this->data) ? $this->data : NULL), TRUE);
            $this->template->write_view('footer', 'backend/footer', '', TRUE);
            $this->template->render();
        }
    }

    // edit a user
    public function edit_user($id) {
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
        $this->data['title'] = $this->lang->line('edit_user_heading');

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
            redirect('auth', 'refresh');
        }
        
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $user = $this->ion_auth->user($id)->row();
         //echo '<pre>';print_R($user);die;
        $groups = $this->ion_auth->groups()->result_array();
       
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
//        $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
//            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
//                show_error($this->lang->line('error_csrf'));
//            }

            // update the password if it was posted
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
            }

            if ($this->form_validation->run() === TRUE) {
                
                
                if ($_FILES['profile_image']['name'] != '') {
                    $_FILES['profile_image']['name'];
                    $_FILES['profile_image']['type'];
                    $_FILES['profile_image']['tmp_name'];
                    $_FILES['profile_image']['error'];
                    $_FILES['profile_image']['size'];
                    $config['file_name'] = time() . rand();
                    $config['upload_path'] = FCPATH . 'media/backend/img/profile';
                    $config['allowed_types'] = 'jpg|jpeg|gif|png';
                    $config['max_size'] = '9000000';
                    $this->load->library('upload');
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('profile_image')) {
                        $data['upload_data'] = $this->upload->data();
                        //$ar = list($width, $height) = getimagesize($data['full_path']);
                        $upload_result = $this->upload->data();
                        /* for image */
                        $image_config = array(
                            'source_image' => $upload_result['full_path'],
                            'new_image' => FCPATH . "media/backend/img/profile/300x300/",
                            'maintain_ratio' => false,
                            'width' => 300,
                            'height' => 300
                        );
                        $this->load->library('image_lib');
                        $this->image_lib->initialize($image_config);
                        $resize_rc = $this->image_lib->resize();
                        /* for image  540x360 */
                        


                        $img_path = base_url() . "media/backend/img/profile/300x300/".$upload_result['file_name'];
                    } else { 
                        $error = array('error' => $this->upload->display_errors());
                    }
                } else {
                    $img_path = $this->input->post('profile_image_old');
                }
                
                
                
                
                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'company' => $this->input->post('company'),
                    'phone' => $this->input->post('phone'),
                    'picture_url' => $img_path,
                );
               //echo '<pre>';print_R($data);die;
                // update the password if it was posted
                if ($this->input->post('password')) {
                    $data['password'] = $this->input->post('password');
                }



                // Only allow updating groups if user is admin
                if ($this->ion_auth->is_admin()) {
                    //Update the groups user belongs to
                    $groupData = $this->input->post('groups');

                    if (isset($groupData) && !empty($groupData)) {

                        $this->ion_auth->remove_from_group('', $id);

                        foreach ($groupData as $grp) {
                            $this->ion_auth->add_to_group($grp, $id);
                        }
                    }
                }

                // check to see if we are updating the user
                if ($this->ion_auth->update($user->id, $data)) {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    //$this->session->set_flashdata('message', $this->ion_auth->messages());
                    $this->session->set_flashdata('msg','User updated successfully.');
                    if ($this->ion_auth->is_admin()) {
                        redirect('auth', 'refresh');
                    } else {
                        redirect('/', 'refresh');
                    }
                } else {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('msg', $this->ion_auth->errors());
                    if ($this->ion_auth->is_admin()) {
                        redirect('auth', 'refresh');
                    } else {
                        redirect('/', 'refresh');
                    }
                }
            }
        }

        // display the edit user form
        $this->data['csrf'] = $this->_get_csrf_nonce();

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;

        $this->data['first_name'] = array(
            'name' => 'first_name',
            'class' => 'form-control',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'class' => 'form-control',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
        );
        $this->data['company'] = array(
            'name' => 'company',
            'id' => 'company',
            'class' => 'form-control',
            'type' => 'text',
            'value' => $this->form_validation->set_value('company', $user->company),
        );
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'class' => 'form-control',
            'type' => 'text',
            'value' => $this->form_validation->set_value('phone', $user->phone),
        );
        $this->data['password'] = array(
            'name' => 'password',
            'id' => 'password',
            'class' => 'form-control',
            'type' => 'password'
        );
        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'class' => 'form-control',
            'type' => 'password'
        );
        $this->data['profile_image'] = array(
                'name' => 'profile_image',
                'id' => 'profile_image',
                'type' => 'file',
                'class' => 'form-control',
                'data-error' => '.regErorr10',
                'onchange'=> "chkFile(this.value,'profile_image');",
                'value' => $this->form_validation->set_value('profile_image'),
            );
//        $this->data['profile_image_old'] = array(
//            'name' => 'profile_image_old',
//            'id' => 'profile_image_old',
//            'class' => 'form-control',
//            'type' => 'text',
//            'value' => $this->form_validation->set_value('profile_image_old', $user->profileimg),
//        );
        $this->data['profile_image_old'] = $user->picture_url;
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', (isset($this->data) ? $this->data : NULL));
        $this->template->write_view('sidebar', 'backend/sidebar', (isset($this->data) ? $this->data : NULL));
        $this->template->write_view('content', 'edit_user', (isset($this->data) ? $this->data : NULL), TRUE);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
//        $this->_render_page('auth/edit_user', $this->data);
    }

    public function delete_user($id) { 
        if ($id != '') {
             $arr_user_date = $this->common_model->getRecords('users', '*', array("id" => $id));
             if(count($arr_user_date) > 0){
                $user = array($id);
                $this->common_model->deleteRows($user, "users", "id");
             }
             
             $this->session->unset_userdata('msg');
             $this->session->set_userdata('msg','User deleted successfully.');
            redirect('auth');
        }
        
         redirect('auth');
    }

    // create a new group
    public function create_group() {
        
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['title'] = $this->lang->line('create_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }
       
        // validate form input
        //$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), '');

        if (trim($this->input->post('group_name')) != '') {
           //echo 'hisfai';die;
            $arr_groups = $this->Common_model_marketing->getRecords('groups', 'name', array('name' => trim($this->input->post('group_name'))));
            if(count($arr_groups) < 1 && trim($this->input->post('group_name')) != ''){
                $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
                $this->session->set_userdata('msg','Group created successfully');
                 redirect("auth", 'refresh');   
            }else{
                $this->session->set_userdata('msg','Group already available,please enter another group');
                redirect("auth", 'refresh');   
            }
            if ($new_group_id) {
                // check to see if we are creating the group
                // redirect them back to the admin page
               // $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth", 'refresh');
            }
        } else { 
            // display the create group form
            // set the flash data error message if there is one
            //echo 'hidd';die;
           // $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

           
            $this->data['group_name'] = array(
                'name' => 'group_name',
                'id' => 'group_name',
                'type' => 'text',
                'onblur' => "checkGroupName(this.value,'group_name')",
                'value' => $this->form_validation->set_value('group_name'),
            );
            $this->data['description'] = array(
                'name' => 'description',
                'id' => 'description',
                'type' => 'text',
                'value' => $this->form_validation->set_value('description'),
            );

            $this->template->set_master_template('template.php');
            $this->template->write_view('header', 'backend/header', (isset($this->data) ? $this->data : NULL));
            $this->template->write_view('sidebar', 'backend/sidebar', (isset($this->data) ? $this->data : NULL));
            $this->template->write_view('content', 'create_group', (isset($this->data) ? $this->data : NULL), TRUE);
            $this->template->write_view('footer', 'backend/footer', '', TRUE);
            $this->template->render();

//            $this->_render_page('auth/create_group', $this->data);
        }
    }

    // edit a group
    public function edit_group($id) {
        // bail if no group id given
        if (!$id || empty($id)) {
            redirect('auth', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['title'] = $this->lang->line('edit_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        $group = $this->ion_auth->group($id)->row();

        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

                if ($group_update) {
                    $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                }
                redirect("auth", 'refresh');
            }
        }

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $this->data['group'] = $group;

        $readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

        $this->data['group_name'] = array(
            'name' => 'group_name',
            'id' => 'group_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_name', $group->name),
            $readonly => $readonly,
        );
        $this->data['group_description'] = array(
            'name' => 'group_description',
            'id' => 'group_description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_description', $group->description),
        );




        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', (isset($this->data) ? $this->data : NULL));
        $this->template->write_view('sidebar', 'backend/sidebar', (isset($this->data) ? $this->data : NULL));
        $this->template->write_view('content', 'edit_group', (isset($this->data) ? $this->data : NULL), TRUE);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();

//        $this->_render_page('auth/edit_group', $this->data);
    }

    public function _get_csrf_nonce() {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    public function _valid_csrf_nonce() {
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function _render_page($view, $data = null, $returnhtml = false) {//I think this makes more sense
        $this->viewdata = (empty($data)) ? $this->data : $data;

        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

        if ($returnhtml)
            return $view_html; //This will return html on 3rd argument being true
    }

    function handleUploadCommon($slug) {
        $fileTypes = array('jpeg', 'png', 'jpg'); // File extensions
        $fileParts = pathinfo($_FILES['profile_image']['name']);

        if (!in_array(strtolower($fileParts['extension']), $fileTypes)) {
            $this->session->set_flashdata('msg', 'File type not supported.');
//            $data['flashdata'] = array('type' => 'error', 'msg' => 'File type not supported.');
            return false;
        }

        $user_slug = $slug;
        $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $targetURL = '/assets/uploads/clients' . $user_slug . '/profile'; // Relative to the root
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'clients' . DIRECTORY_SEPARATOR . $user_slug . '/profile';

        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        $tempFile = $_FILES['profile_image']['tmp_name'];
        $fileName = $_FILES['profile_image']['name'];
        $fileName = $slug . '-profile-' . $fileName;
        $targetPath .= DIRECTORY_SEPARATOR . $fileName;
        $upload_status = move_uploaded_file($tempFile, $targetPath);
        $dataDocumentDetail['type'] = $fileParts['extension'];
        if (isset($upload_status))
            return $fileName;
    }

    // if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action = 'edit' && $modal_id) {


    function handleUploadUser($slug) {
        $fileTypes = array('jpeg', 'png', 'jpg'); // File extensions
        $fileParts = pathinfo($_FILES['profile_image']['name']);

        if (!in_array(strtolower($fileParts['extension']), $fileTypes)) {
            $this->session->set_flashdata('msg', 'File type not supported.');
//            $data['flashdata'] = array('type' => 'error', 'msg' => 'File type not supported.');
            return false;
        }

        $user_slug = $slug;
        $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $targetURL = '/assets/uploads/users' . $user_slug . '/profile'; // Relative to the root
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . $user_slug . DIRECTORY_SEPARATOR . 'profile';

        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        $tempFile = $_FILES['profile_image']['tmp_name'];
        $fileName = $_FILES['profile_image']['name'];
        $fileName = $slug . '-profile-' . $fileName;
        $targetPath .= DIRECTORY_SEPARATOR . $fileName;
        $upload_status = move_uploaded_file($tempFile, $targetPath);
        $dataDocumentDetail['type'] = $fileParts['extension'];
        if (isset($upload_status))
            return $fileName;
    }

    function ajaxLoginSubmit() {
        //validate form input
        $this->form_validation->set_rules('username', str_replace(':', '', $this->lang->line('login_username_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');
      
        if ($this->form_validation->run() == true) {
            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool) $this->input->post('remember');
            if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'), FALSE)) {
                $this->Demo_cart_model->retainCart();
                echo json_encode(array('status' => '1', 'msg' => 'Login success...Please wait..'));
            } else {
                echo json_encode(array('status' => '0', 'msg' => 'Invalid username or password'));
            }
        } else {
            echo json_encode(array('status' => '0', 'msg' => validation_errors()));
        }
    }

    public function ajaxUserRegisterSubmit() {
 
        $email_exist = $this->Common_model_marketing->getRecords('users', 'email', array('email' => $this->input->post('email')));

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if ($identity_column !== 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'required');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        }else{
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true) { 
            $email = strtolower($this->input->post('email'));
            $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');



            /* Upload profile picture */
            if (isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != '') {
                $targetDir = "uploads/";
                $fileName = $_FILES['profile_image']['name'];
                $targetFile = $targetDir . $fileName;

                $slug = $this->input->post('name');

                $fileExt = pathinfo($_FILES['profile_image']['name']);
                $dataDocumentDetail['type'] = $fileExt['extension'];


                $uploded_file_path = $this->handleUploadUser($slug);
                if ($uploded_file_path != '')
                    $data['profileimg'] = $slug . '/profile/' . $uploded_file_path;
            }
        }
        $salt = $this->store_salt ? $this->ion_auth_model->salt() : FALSE;
        $password1 = $this->ion_auth->hash_password($password, $salt);
//        $password = $this->ion_auth->hash_password($this->input->post('password'));
        $additional_data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'company' => $this->input->post('company'),
            'phone' => $this->input->post('phone'),
            'username' => $this->input->post('email'),
            'password' => $password1,
            'active' => '1',
        );
        if($this->form_validation->run() == false) {
            $this->form_validation->set_error_delimiters('', '');
            echo json_encode(array('status' => '0', 'msg' => validation_errors()));
            exit;
        }
        if (count($email_exist) > 0) {
//            $update = $this->Common_model_marketing->updateRow('users', $additional_data, array('email' => $this->input->post('email')));
//            $this->ion_auth->login($this->input->post('email'), $this->input->post('password'), FALSE);
            echo json_encode(array('status' => '0', 'msg' => "This email address is already registered. Please login to continue."));
        } else if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data)) {
            $this->ion_auth->login($identity, $password, FALSE);
            // check to see if we are creating the user
            // redirect them back to the admin page
			
        $edata['name'] = $this->input->post('first_name').' '.$this->input->post('last_name');
                $edata['email']    = $this->input->post('email');
                $edata['password'] = $this->input->post('password');
                $html              = $this->load->view('email_templates/new-user-register',
                    $edata, true);
                $mail              = $this->common_model->sendEmail(array($email),
                    array("email" => config_item('site_email'), "name" => config_item('website_name')),
                    'Registration successfull', $html);
                
                //echo '<pre>';print_r($mail);die;
            
			
            echo json_encode(array('status' => '1', 'msg' => "Registration successfull.We've send you the confirmation email."));
			}
                        
                        
    }
    
    
    
    public function chkEmailDuplicateNew() {
        if (isset($_POST['type'])) {

#checking user email already exist or not for edit user

            if (strtolower(trim($this->input->post('email'))) == strtolower(trim($this->input->post('old_email')))) {

                echo 1;

            } else {

                $arr_admin_detail = $this->common_model->getRecords('users', 'email', array("email" => trim($this->input->post('email'))));

                if (count($arr_admin_detail) == 0) {

                    echo 1;

                } else {

                    echo 0;

                }

            }

        } else {

#checking user email already exist or not for add user

            $arr_admin_detail = $this->common_model->getRecords('users', 'email', array("email" => trim($this->input->post('email'))));

            if (count($arr_admin_detail) == 0) {

                echo 1;

            } else {

                echo 0;

            }

        }

    }
    
    
    public function chkGroupName(){
#checking user email already exist or not for edit user
        if( trim($this->input->post('group_name')) != ''){
        $arr_admin_detail = $this->common_model->getRecords('groups', 'name', array("name" => trim($this->input->post('group_name'))));

            if (count($arr_admin_detail) == 0) {

                echo 1;

            } else {

                echo 0;

            }

    }else{
       echo 0;  
    }
    }

}
