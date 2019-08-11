<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->model('blog_model');
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
        $this->load->library('form_validation');

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

    public function index($the_url = '', $pg = 0) {

        //$data['global'] = $this->common_model->getGlobalSettings();
        //$data['arr_all_languages'] = $this->common_model->getRecords("mst_languages", "lang_id,lang_name", array("status" => 'A'));
//        $data['category_tree'] = $this->getBlogCategoriesTreeStructure();
       // $data['user_session'] = $this->session->userdata('user_account');
        
        $posted_key = mysqli_real_escape_string($this->db->conn_id, $this->input->post('search'));
        if ($this->input->post('search_null') == '1' && $posted_key == '') {
            $this->session->unset_userdata('search');
        }
        if ($posted_key != '') {
            $posted_key = $posted_key;
            $this->session->unset_userdata('search');
        } elseif ($this->session->userdata('search') != '') {
            $posted_key = mysqli_real_escape_string($this->db->conn_id, $this->session->userdata('search'));
        } else {
            $this->session->unset_userdata('search');
        }
        if ($posted_key != "" && (is_numeric($the_url) || $the_url == '')) {

            if ((is_numeric($the_url))) {
                $pg = $the_url;
            } else {
                $pg = 0;
            }
            $this->session->set_userdata('search', $posted_key);
            $data['header'] = array("title" => "Search results for " . $posted_key, "keywords" => "", "description" => "");
            if ($this->session->userdata('lang_id') != "") {
                $condition_to_pass = "b.`status` = '1' and (tb.`post_title` like '%" . $posted_key . "%' or tb.`post_short_description` like '%" . $posted_key . "%' or tb.`post_content` like '%" . $posted_key . "%' or tb.`post_tags` like '%" . $posted_key . "%')";
            } else {
                $condition_to_pass = "b.`status` = '1' and (b.`post_title` like '%" . $posted_key . "%' or b.`post_short_description` like '%" . $posted_key . "%' or b.`post_content` like '%" . $posted_key . "%' or b.`post_tags` like '%" . $posted_key . "%')";
            }
            $this->data['blog_posts_one'] = $this->blog_model->getAllBlog('', $condition_to_pass);

            $this->load->library('pagination');
            $data['count'] = count($data['blog_posts_one']);
            $config['base_url'] = base_url() . 'blog/';
            $config['total_rows'] = count($data['blog_posts_one']);
            $config['total_rows'];
            $config['per_page'] = 10;
            $config['cur_page'] = $pg;
            $data['cur_page'] = $pg;
            $config['num_links'] = 2;
            $config['full_tag_open'] = ' <ul class="pagination pagination-lg">';
            $config['full_tag_close'] = '</ul>';
            $this->pagination->initialize($config);
            $this->data['create_links'] = $this->pagination->create_links();
            $this->data['blog_posts_two'] = $this->blog_model->getAllBlog('', $condition_to_pass, '', $config['per_page'], $pg);
            $data['page'] = $pg; //$pg is used to pass limit 
            /** Pagination end here * */
            foreach ($data['blog_posts_two'] as $key => $value) {
                $this->data['blog_posts'][$key] = $value;
                $result = $this->getPostComments($value['post_id']);
                $this->data['blog_posts'][$key]['comment_count'] = count($result);
            }
//            $data['latest_blogs'] = $this->blog_model->getRecentBlogs();
            $this->data['site_title'] = 'Blog';

            //list $this->load->view('front/includes/header', $data);
           // $this->load->view('blogs/list', $data);
             $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
         $this->data['page_title'] = 'Administrator Dashboard';

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'blogs/list', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
            // $this->load->view('includes/footer');
        } else {
            $this->session->unset_userdata('search');
            if ((is_numeric($the_url)) || $the_url == '') {
                if ((is_numeric($the_url))) {
                    $pg = $the_url;
                } else {
                    $pg = 0;
                }
                $data['blog_posts_one'] = $this->getFrontBlogs();

                $this->load->library('pagination');
                $data['count'] = count($data['blog_posts_one']);
                $config['base_url'] = base_url() . 'blog/';
                $config['total_rows'] = count($data['blog_posts_one']);
                $config['total_rows'];
                $config['per_page'] = 10;
                $config['cur_page'] = $pg;
                $data['cur_page'] = $pg;
                $config['num_links'] = 2;
                $config['full_tag_open'] = ' <ul class="pagination pagination-lg">';
                $config['full_tag_close'] = '</ul>';
                $this->pagination->initialize($config);
                $this->data['create_links'] = $this->pagination->create_links();
                $this->data['blog_posts_two'] = $this->blog_model->getAllBlog('', '', '', $config['per_page'], $pg);
//                echo '<pre>', print_r($pg);die;
                $data['page'] = $pg; //$pg is used to pass limit 
                /** Pagination end here * */
                foreach ($this->data['blog_posts_two'] as $key => $value) {
                    $this->data['blog_posts'][$key] = $value;
                    $result = $this->getPostComments($value['post_id']);
                    $this->data['blog_posts'][$key]['comment_count'] = count($result);
                }

                 $user_id = $this->session->userdata('user_id');
                $this->data['dataHeader'] = $this->users->get_allData($user_id);
                $this->data['latest_blogs'] = $this->blog_model->getRecentBlogs();
                $this->data['site_title'] = 'Blogs';
                $this->data['page_title'] = 'Administrator Dashboard';
                $this->template->set_master_template('template.php');
                $this->template->write_view('header', 'backend/header', $this->data);
                $this->template->write_view('sidebar', 'backend/sidebar', NULL);
                $this->template->write_view('content', 'blogs/list', $this->data);
                $this->template->write_view('footer', 'backend/footer', '', TRUE);
                $this->template->render();
                // $this->load->view('front/includes/footer', $data);
            } else {
                $the_page_info = $this->common_model->getPageInfoByUrl($the_url);

                if (count($the_page_info) > 0) {
                    $the_page_info = end($the_page_info);

                    if ($the_page_info['type'] == 'blog-category') {

                        $category_id = $the_page_info['rel_id'];

//                        $category_info = $this->blog_model->getCategories('*', array('category_id' => $category_id));
                        $this->data['header'] = array("title" => $category_info[0]['page_title'], "keywords" => $category_info[0]['page_keywords'], "description" => $category_info[0]['page_description']);
                        $this->data['blog_posts'] = $this->getFrontBlogs('', "b.`category_id` ='" . $category_id . "'");
                        $this->data['site_title'] = 'Blog';
                              $this->data['page_title'] = 'Administrator Dashboard';
        
 $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'blogs/list', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
                    } elseif ($the_page_info['type'] == 'blog-post') {

                        $post_id = $the_page_info['rel_id'];
                        $data['blog_posts'] = $this->getFrontBlogs('', "b.`post_id` ='" . $post_id . "'");
                        if ($data['blog_posts'][0]['status'] == '1') {
                            $data['header'] = array("title" => $data['blog_posts'][0]['page_title'], "keywords" => $data['blog_posts'][0]['post_keywords'], "description" => $data['blog_posts'][0]['post_short_description']);
                            $data['post_id'] = $post_id;
                            $data['post_comments'] = $this->getPostComments($post_id);
                            $data['comment_count'] = count($data['post_comments']);
                        } else {
                            redirect(base_url() . "blog");
                        }
                        $data['meta_description'] = $data['blog_posts'][0]['post_short_description'];
                        $data['meta_keywords'] = $data['blog_posts'][0]['post_keywords'];
                        $data['meta_title'] = $data['blog_posts'][0]['page_title'];
                        $data['site_title'] = 'Blog post';
                        $data['latest_blogs'] = $this->blog_model->getRecentBlogs();
                       
                       $this->data['page_title'] = 'Administrator Dashboard';
       
                        $user_id = $this->session->userdata('user_id');
                        $this->data['dataHeader'] = $this->users->get_allData($user_id);
                        $this->template->set_master_template('template.php');
                        $this->template->write_view('header', 'backend/header', $this->data);
                        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
                        $this->template->write_view('content', 'blogs/list', $this->data);
                        $this->template->write_view('footer', 'backend/footer', '', TRUE);
                        $this->template->render();
                    }
                } else {

                    echo "<h2>404 - Page not found</h2>";
                }
            }
        }
    }

    /*
     * Function will return all blog categories with category tree in desired format
     */

    public function getBlogCategoriesTreeStructure($type = 'ul') {

        if ($this->session->userdata('lang_id') != "") {
            $lang_id = $this->session->userdata('lang_id');
        } else {
            $lang_id = 17;
        }
        return $this->blog_model->getCategoryTreeResponse($type, $lang_id);
    }

    /*
     *  End Blog Categories Tree Structure function
     */
    /*
     *  Function to get all blog posts
     */

    private function getPosts($fields = '', $condition = '', $order_by) {
        if ($this->session->userdata("lang_id") != "") {
            $lang_id = $this->session->userdata("lang_id");
        } else {
            $lang_id = 17;
        }
        return $this->blog_model->getPosts($fields, $condition, $order_by, '', 0, $lang_id);
    }

    private function getFrontBlogs($fields = '', $condition = '', $order_by = '', $limit = '', $offset = '') {
        if ($this->session->userdata("lang_id") != "") {
            $lang_id = $this->session->userdata("lang_id");
        } else {
            $lang_id = 17;
        }
        return $this->blog_model->getAllBlog($fields, $condition, $order_by, $limit = '', $offset = '', '', $lang_id);
    }

    /*
     *  Function to search blog posts
     */

    private function searchPosts($searchKey) {
        return $this->blog_model->searchPosts($searchKey);
    }

    private function getPostComments($post_id) {
        $limit = "10";
        $condition_to_pass = array("post_id" => $post_id, "status" => "1");
        $order = ('comment_on desc');
        $arr_comments = $this->blog_model->getPostComments("", $condition_to_pass, $order, $limit);
        return $arr_comments;
    }

    public function add_comment() {
        $post_id = $this->input->post('p');
        $post_comment = $this->input->post('msg_comment');
        $posted_by = $this->input->post('posted_by');
        $user_id = $this->input->post('user_id');
        $arr_blog_comment = array();
        $arr_blog_comment["post_id"] = $post_id;
        $arr_blog_comment["comment"] = ($post_comment);
        $arr_blog_comment["comment_on"] = date("Y-m-d H:i:s");
        $arr_blog_comment["commented_by"] = $posted_by;
        $arr_blog_comment["commented_user_id"] = $user_id;

        $arr_blog_comment["status"] = "1";

        $arr_insert_data = $this->blog_model->add_comment($arr_blog_comment);
        $this->session->set_userdata('blog_comment', 'Your comment has been posted successfully.');
        echo json_encode(array("error" => "0"));
    }

    public function edit_category($post_id = '') {
        /*         * checking admin is logged in or not ** */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "admin/login");
        }
        /** using the email template model ** */
        $data = $this->common_model->commonFunction();
        $arr_privileges = array();
        //checking for admin privilages
        if ($data['user_account']['role_id'] != 1) {
            $arr_privileges = $this->common_model->getRecords('trans_role_privileges', 'privilege_id', array("role_id" => $data['user_account']['role_id']));
            if (count($arr_privileges) > 0) {
                foreach ($arr_privileges as $privilege) {
                    $user_privileges[] = $privilege['privilege_id'];
                }
            }
            $arr_login_admin_privileges = $user_privileges;
            if (in_array('13', $arr_login_admin_privileges) == FALSE) {
                /* an admin which is not super admin not privileges to access Manage Role
                 * setting session for displaying notiication message. */
                $this->session->set_userdata("permission_msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
                redirect(base_url() . "admin/home");
                exit();
            }
        }

        $post_category = $this->input->post("category_name");
        if ($post_category != "") {

            $edit_id = $this->input->post("edit_id");
            // this is update request
            $arr_forum_comment = array();
            $arr_forum_comment["category_name"] = ($post_category);
            $arr_forum_comment["parent_id"] = "" . $this->input->post("parent_category");
            $arr_update_condition = array("category_id" => $edit_id);
            $this->blog_model->updateCategory($arr_forum_comment, $arr_update_condition);
            $url = $post_category;
            $rel_id = $edit_id;
            $arr_update_url = array();
            $arr_update_url['url'] = preg_replace('/[^A-Za-z0-9\-_.]/', '', str_replace(" ", "-", $url));
            $where_field = array("type" => 'blog-category', "rel_id" => $rel_id);
            $this->common_model->updateURI($arr_update_url, $where_field);
            $this->session->set_userdata("msg", "<span class='success'>Record updated successfully!</span>");

            redirect(base_url() . "admin/blog/blog-category");
        }

        $arr_categories = $this->blog_model->getCategories();
        $data["title"] = "Edit Blog Category";
        $data["arr_categories"] = $arr_categories;
        $data["category_id"] = $post_id;
        $arr_cat_info = $this->blog_model->getCategories("*", array("category_id" => $post_id));
        $data["arr_cat_info"] = $arr_cat_info[0];
        $this->load->view('admin/blogs/edit-category', $data);
    }

    public function delete_category() {

        $post_id = $this->input->post("post_id");
        $post_ids = $this->input->post("post_ids");

        $this->load->model("blog_model");

        if ($post_id != "")
            $this->blog_model->deleteCategory(array("category_id" => "" . intval($post_id)));
        elseif ($post_ids != "") {
            foreach ($post_ids as $post_id) {

                $arr_delete = array("category_id" => "" . intval($post_id));
                $this->blog_model->deleteCategory($arr_delete);
            }
        }
        $this->session->set_userdata("msg", "<span class='success'>Record(s) deleted successfully!</span>");
        echo json_encode(array("msg" => "success", "error" => "0"));
    }

    public function manage_blog_posts() {
        /*         * checking admin is logged in or not ** */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "admin/login");
        }
        /*         * using the email template model ** */

        $data = $this->common_model->commonFunction();
        $arr_privileges = array();

        //checking for admin privilages
        if ($data['user_account']['role_id'] != 1) {
            $arr_privileges = $this->common_model->getRecords('trans_role_privileges', 'privilege_id', array("role_id" => $data['user_account']['role_id']));
            if (count($arr_privileges) > 0) {
                foreach ($arr_privileges as $privilege) {
                    $user_privileges[] = $privilege['privilege_id'];
                }
            }
            $arr_login_admin_privileges = $user_privileges;
            if (in_array('13', $arr_login_admin_privileges) == FALSE) {
                /* an admin which is not super admin not privileges to access Manage Role
                 * setting session for displaying notiication message. */
                $this->session->set_userdata("permission_msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
                redirect(base_url() . "admin/home");
                exit();
            }
        }

        $data['blog_posts'] = $this->getPosts('', '', 'post_id DESC');
        $data["title"] = "Manage Blog Posts";
        $this->load->view('admin/blogs/list', $data);
    }

    public function editPost($post_id = '') {
       // $post_id = '';
        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $data["post_info"] = NULL;

        $data = $this->common_model->commonFunction();
//        $this->data['category'] = $this->common_model->getRecords('trans_category_details');
      // $this->data['category'] = array('trans_category_details');
       

//        $condition = array('user_type' => '1');
//        $fields = 'user_id,first_name,last_name';
//        $data['helpers'] = $this  ->common_model->getRecords('mst_users');
        //checking for admin privilages
        $post_title = $this->input->post("inputName");
        if ($this->input->post('inputPostShortDescription') != '') {

            if ($_FILES['blog_image']['name'] != '') {

                $this->load->library('upload');
                $file_explode = explode('.', $_FILES['blog_image']['name']);
                $type = explode('/', $_FILES['blog_image']['type']);
                $blog_image = time() . '.' . end($file_explode);
                $config['upload_path'] ='media/backend/img/blog_image/';
                $config['allowed_types'] = 'gif|jpeg|png|jpg';
                $config['file_name'] = $blog_image;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('blog_image')) {
                    $error = array('error' => $this->upload->display_errors());

                    $this->session->set_userdata("msg", "<span class='success'>Please upload valid image of format gif,jpg,pn,jpeg </span>");
                } else {

                    $image_data = $this->upload->data();
                    $source_img = $_FILES['blog_image']['tmp_name'];
                    $image_main ='media/backend/img/blog_image/' . $blog_image;
                    $image_main = $this->common_model->compress_image($source_img, $image_main, 80);
                    /* for iphone image */
                    $exif = exif_read_data($_FILES['blog_image']['tmp_name']);
                    if ($exif['Orientation'] == 6 || $exif['Orientation'] == 3 || $exif['Orientation'] == 8) {
                        $imagePath = $image_data['full_path'];
                        $newImagePath = $image_data['file_path'] . $image_data['file_name'];
                        $newImageQuality = 100;
                        $image = imagecreatefromjpeg($imagePath);
                        if ($image) {
                            switch ($exif['Orientation']) {
                                case 8: $rotate = imagerotate($image, 90, 0);
                                    break;
                                case 3: $rotate = imagerotate($image, 180, 0);
                                    break;
                                case 6: $rotate = imagerotate($image, -90, 0);
                                    break;
                            } if ($rotate != '') {
                                if (imagejpeg($rotate, $newImagePath, $newImageQuality)) {
                                    $this->session->set_userdata('msg', "The new image was created successfully without the EXIF metadata.");
                                } else {
                                    $this->session->set_userdata('msg', "The new image failed to be created. Make sure that the new folder path has write permissions set properly.");
                                }
                                imagedestroy($image);
                            }
                        } else {
                            $this->session->set_userdata('msg', "Unable to open the original image. Make sure that it exists.");
                        }
                    }
                    /* for iphone image ends */
                    $image_main = 'media/backend/img/blog_image/' . $blog_image;
                    $thumbs_image = 'media/backend/img/blog_image/thumbs/' . $blog_image;
                    $str_console = "convert " . $image_main . " -geometry x100 " . $thumbs_image;
                    exec($str_console);
                }
            }
            if ($blog_image != '') {
                $blog_image = $blog_image;
            } else {
                $blog_image = '';
            }

            $post_title = $this->input->post("inputName");
            if ($post_title != "") {
                $edit_id = $this->input->post("edit_id");
                if ($edit_id != "") {
                    $arr_post_data = array(
                        "post_title" => ($this->input->post('inputName')),
                        'post_short_description' => ($this->input->post('inputPostShortDescription')),
                        'post_content' => ($this->input->post('inputPostDescription')),
                        'page_title' => ($this->input->post('inputPostPageTitle')),
                        'post_tags' => ($this->input->post('inputPostTags')),
                        'post_keywords' => ($this->input->post('inputPostKeywords')),
                        'category_id' => $this->input->post('category'),
                        'suburb' => ($this->input->post('search_location')),
                       'helper_id' => $this->input->post('helper'),
                        'blog_image' => $blog_image,
                        'video_link' => $this->input->post('blog_video'),
                        'posted_by' => $this->session->userdata("user_id"),
                        'posted_on' => date("Y-m-d H:i:s"),
                        'status' => $this->input->post('inputPublishStatus')
                    );
                    $arr_update_condition = array("post_id" => $edit_id);
                    $this->blog_model->updatePost($arr_post_data, $arr_update_condition);
                    $this->session->set_userdata("msg", "<span class='success'>Record updated successfully!</span>");
                } else {
                    $arr_post_data = array(
                        "post_title" => ($this->input->post('inputName')),
                        'post_short_description' => ($this->input->post('inputPostShortDescription')),
                        'post_content' => ($this->input->post('inputPostDescription')),
                        'page_title' => ($this->input->post('inputPostPageTitle')),
                        'post_tags' => ($this->input->post('inputPostTags')),
                        'post_keywords' => ($this->input->post('inputPostKeywords')),
                        'category_id' => $this->input->post('category'),
                        'suburb' => ($this->input->post('search_location')),
                        'helper_id' => $this->input->post('helper'),
                        'blog_image' => $blog_image,
                        'video_link' => $this->input->post('blog_video'),
                        'posted_by' => $this->session->userdata("user_id"),
                        'posted_on' => date("Y-m-d H:i:s"),
                        'status' => $this->input->post('inputPublishStatus'));
                    $new_post_id = $this->blog_model->insertNewPost($arr_post_data);
                    $this->session->set_userdata("msg", "<span class='success'>Record inserted successfully!</span>");
                }
                redirect(base_url() . "admin/blog");
            }
        }
//        $data['arr_get_language'] = $this->common_model->getLanguages();
//        $arr_categories = $this->blog_model->getCategories();
        if ($post_id == "") {
            if ($this->input->post("edit_id") == '') {
               $this->data["post_info"] = NULL;
               // $this->data["title"] = "Add Blog Post";
//                $data["arr_categories"] = $arr_categories;
                //$this->load->view('admin/blogs/add', $data);
               $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
                 $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'blogs/add', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
            } else {
                $this->data["title"] = "Update Blog Post";
//                $data["arr_categories"] = $arr_categories;
                $this->data["post_id"] = $post_id;
                $arr_post_info = $this->blog_model->getPosts("", array("post_id" => $this->input->post("edit_id")));

                $this->data["post_info"] = $arr_post_info[0];
              //  $this->load->view('admin/blogs/edit', $data);
                $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
                 $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'blogs/edit', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
            }
        } else {
            echo $post_id;
            $this->data["title"] = "Update Blog Post";
//            $data["arr_categories"] = $arr_categories;
            $this->data["post_id"] = $post_id;
            $arr_post_info = $this->blog_model->getPosts("", array("post_id" => $post_id));

            $this->data["post_info"] = $arr_post_info[0];
//            $this->load->view('admin/blogs/edit', $data);
            $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
                       $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'blogs/edit', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
        }
    }

    public function delete_post() {
        $post_id = $this->input->post("post_id");
        $post_ids = $this->input->post("post_ids");

        $this->load->model("blog_model");

        if ($post_id != "")
            $this->blog_model->deletePost(array("post_id" => "" . intval($post_id)));
        elseif ($post_ids != "") {
            foreach ($post_ids as $post_id) {

                $arr_delete = array("post_id" => "" . intval($post_id));
                $this->blog_model->deletePost($arr_delete);
            }
        }
        $this->session->set_userdata("msg", "<span class='success'>Record(s) deleted successfully!</span>");
        echo json_encode(array("msg" => "success", "error" => "0"));
    }

    public function delete_post_comment() {
        $comment_id = $this->input->post("comment_id");
        $comment_ids = $this->input->post("comment_ids");

        if ($comment_id != "")
            $this->blog_model->deletePostComment(array("comment_id" => "" . intval($comment_id)));
        elseif ($comment_ids != "") {
            foreach ($comment_ids as $comment_id) {

                $arr_delete = array("comment_id" => "" . intval($comment_id));
                $this->blog_model->deletePostComment($arr_delete);
            }
        }
        $this->session->set_userdata("msg", "<span class='success'>Record(s) deleted successfully!</span>");
        echo json_encode(array("msg" => "success", "error" => "0"));
    }

    public function view_post_comments($post_id) {
 
        $post_comments = $this->blog_model->getPostComments("", array("post_id" => $post_id), 'comment_id DESC');
        $this->data["title"] = "Blog Post Comments";
        $this->data["post_id"] = $post_id;
        $this->data["arr_post_comments"] = $post_comments;
       // $this->load->view('admin/blogs/post_comments', $data);
                            $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'blogs/post_comments', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function add_post_comment($post_id='') {

   
        /*         * checking admin is logged in or not ** */
//        if (!$this->common_model->isLoggedIn()) {
//            redirect(base_url() . "backend/login");
//        }
        /*         * using the email template model ** */

     
        //checking for admin privilages
  
        $post_comment = $this->input->post("inputComment");

        /*
         *
         * Post request check
         *
         */
   
        if ($post_comment != "") {
           //echo $data['user_session'] = $this->session->userdata('user_account');
            $post_id = $this->input->post('post_id');
            $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
            $comment_by = $this->data['dataHeader']['username'];
           
            $arr_blog_comment = array();
            $arr_blog_comment["post_id"] = $post_id;
            $arr_blog_comment["comment"] = stripcslashes($post_comment);
            $arr_blog_comment["comment_on"] = date("Y-m-d H:i:s");
            $arr_blog_comment["commented_by"] = $comment_by;
            $arr_blog_comment["status"] = "" . $this->input->post("inputPublishStatus");
            $this->blog_model->add_comment($arr_blog_comment);
            $this->session->set_userdata("msg", "<span class='success'>Record added successfully!</span>");
            redirect(base_url() . "admin/blog/view-comments/" . $post_id);
        }
 else {
     //echo 'teset';
       $this->data["title"] = "Add Post Comment - Post Comments Management ";
        $this->data["post_id"] = $post_id;

       // $this->load->view('admin/blogs/add-post-comment', $data);
   $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Administrator Dashboard';
        

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'blogs/add-post-comment', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
 }

      
    }

    public function edit_post_comment($post_id, $comment_id) {

        

        $post_comment = stripcslashes($this->input->post("inputComment"));

        /*
         *
         * Post request check
         *
         */

        if ($post_comment != "") {
            $post_id = $this->input->post('post_id');
            $comment_id = $this->input->post("comment_id");
            $arr_blog_comment = array();

            $arr_blog_comment["comment"] = $post_comment;
            $arr_blog_comment["status"] = "" . $this->input->post("inputPublishStatus");

            $this->blog_model->update_comment($arr_blog_comment, array("post_id" => $post_id, "comment_id" => $comment_id));
            $this->session->set_userdata("msg", "<span class='success'>Record updated successfully!</span>");
            redirect(base_url() . "admin/blog/view-comments/" . $post_id);
        }

        $post_comment_info = $this->blog_model->getPostComments("*", array("comment_id" => $comment_id));

        $this->data["title"] = "Update Post Comments - Post Comments Management ";
        $this->data["post_id"] = $post_id;
        $this->data["comment_id"] = $comment_id;
        $this->data["arr_post_comment_info"] = $post_comment_info[0];

        //$this->load->view('admin/blogs/edit-post-comment', $data);
        
         $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Administrator Dashboard';
        

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'blogs/edit-post-comment', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function add_post_data() {
        if (!$this->common_model->isLoggedInfront()) {
            redirect('signin');
        }

        $post_title = $this->input->post("inputName");
        if ($this->input->post("inputName") != "" && $this->input->post('inputPostShortDescription') != '' && $this->input->post('inputPostPageTitle') != '' && $this->input->post('inputPostKeywords') != '') {
            if ($_FILES['blog_image']['name'][0] != '') {
                $config['file_name'] = time();
                $config['upload_path'] = './media/backend/blog_image/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '5000000000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('blog_image')) {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_userdata('images_error', $error['error']);
                    redirect(base_url() . 'blog/add-post-front');
                    die;
                } else {
                    $this->load->library('image_lib');
                    $data = array('upload_data' => $this->upload->data());
                    $image_data = $this->upload->data();
                    $file_name = $image_data['file_name'];
                    $image_data = $this->upload->data();
                    $width = 500;
                    $height = 150;
                    $config = array(
                        'source_image' => $image_data['full_path'],
                        'new_image' => base_url().'media/backend/blog_image/thumb/',
                        'maintain_ration' => false,
                        'width' => $width,
                        'height' => $height
                    );
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                }
            }
            $arr_post_data = array(
                "post_title" => mysqli_real_escape_string($this->db->conn_id, $this->input->post('inputName')),
                "lang_id" => mysqli_real_escape_string($this->db->conn_id, $this->input->post('lang_id')),
                'post_short_description' => ($this->input->post('inputPostShortDescription')),
                'post_content' => ($this->input->post('inputPostDescription')),
                'page_title' => mysql_escape_string($this->input->post('inputPostPageTitle')),
                'post_tags' => ($this->input->post('inputPostTags')),
                'post_keywords' => ($this->input->post('inputPostKeywords')),
                'category_id' => ($this->input->post('inputParentCategory')),
                'blog_image' => $file_name,
                'posted_by' => $this->session->userdata("user_id"),
                'posted_on' => date("Y-m-d H:i:s"),
                'status' => '0'
            );
            $new_post_id = $this->blog_model->insertNewPost($arr_post_data);
            $rel_id = $new_post_id;
            $url = $post_title;
            $arr_update_url = array("type" => 'blog-post', "rel_id" => $rel_id);
            $arr_update_url['url'] = preg_replace('/[^A-Za-z0-9\-_.]/', '', str_replace(" ", "-", $url));
            $this->common_model->insertURI($arr_update_url, $where_field);
            $this->session->set_userdata("blog_success", "Your blog has been posted successfully.");
            redirect(base_url() . 'blog');
        }
        $arr_categories = $this->blog_model->getCategories();
        $data["title"] = "Add Blog Post";
        $data["arr_categories"] = $arr_categories;
        $data['arr_get_language'] = $this->common_model->getLanguages();
        $this->load->view('front/includes/header', $data);
//        $this->load->view('front/includes/top-nav', $data);
        $this->load->view('front/blogs/add-blog', $data);
        $this->load->view('front/includes/footer');
    }

    public function lang_post($post_id) {
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
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
            if (in_array('13', $arr_login_admin_privileges) == FALSE) {
                /* an admin which is not super admin not privileges to access Manage Role
                 * setting session for displaying notiication message. */
                $this->session->set_userdata("permission_msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
                redirect(base_url() . "backend/home");
                exit();
            }
        }
        $lang_id = intval($this->input->post("lang"));
        if ($lang_id > 0) {
            $post_id = intval($this->input->post("post_id"));
            if ($post_id > 0) {
                $is_inserted = $this->input->post('is_inserted');
                if ($is_inserted == 'Y') {
                    $arr_to_update = array(
                        "post_title" => mysql_escape_string($this->input->post('inputName')),
                        'page_title' => mysql_escape_string($this->input->post('inputPageTitle')),
                        'post_keywords' => mysql_escape_string($this->input->post('inputPostKeywords')),
                        'post_tags' => mysql_escape_string($this->input->post('inputPostTags')),
                        'post_short_description' => mysql_escape_string($this->input->post('inputPostShortDescription')),
                        'post_content' => mysql_escape_string($this->input->post('inputPostDescription')),
                    );

                    $where_field = array("post_id" => $post_id, "lang_id" => $lang_id);

                    $this->blog_model->updateLanguageValuesForPost($arr_to_update, $where_field);
                } else {

                    $arr_to_insert = array(
                        "post_title" => mysql_escape_string($this->input->post('inputName')),
                        'page_title' => mysql_escape_string($this->input->post('inputPageTitle')),
                        'post_keywords' => mysql_escape_string($this->input->post('inputPostKeywords')),
                        'post_tags' => mysql_escape_string($this->input->post('inputPostTags')),
                        'post_short_description' => mysql_escape_string($this->input->post('inputPostShortDescription')),
                        'post_content' => mysql_escape_string($this->input->post('inputPostDescription')),
                        'post_id' => $post_id,
                        'lang_id' => $lang_id
                    );

                    $this->blog_model->insertLanguageValuesForPost($arr_to_insert);
                }
            }

            redirect(base_url() . "backend/blog/");
        }

        $arr_languages = $this->common_model->getNonDefaultLanguages();


        $data["title"] = "Blog Module - Post Language Management ";
        $data["post_id"] = $post_id;
        $data["arr_languages"] = $arr_languages;
        $this->load->view('backend/blogs/lang-post', $data);
    }

    public function get_language_for_posts() {
        $lang_id = intval($this->input->post('lang'));
        $post_id = intval($this->input->post('post_id'));

        if ($lang_id > 0) {
            $this->load->model("blog_model");
            $arr_language_values = $this->blog_model->getLangValForPost("" . $lang_id, "" . $post_id);

            $arr_to_return = array();

            if (count($arr_language_values) > 0) {
                $arr_to_return["post_title"] = $arr_language_values[0]["post_title"];
                $arr_to_return["page_title"] = $arr_language_values[0]["page_title"];
                $arr_to_return["post_keywords"] = $arr_language_values[0]["post_keywords"];
                $arr_to_return["post_tags"] = $arr_language_values[0]["post_tags"];
                $arr_to_return["post_short_description"] = $arr_language_values[0]["post_short_description"];
                $arr_to_return["post_content"] = $arr_language_values[0]["post_content"];
                $arr_to_return["is_inserted"] = "Y";
            } else {
                $arr_to_return["post_title"] = '';
                $arr_to_return["page_title"] = '';
                $arr_to_return["post_keywords"] = '';
                $arr_to_return["post_tags"] = '';
                $arr_to_return["post_short_description"] = '';
                $arr_to_return["post_content"] = '';
                $arr_to_return["is_inserted"] = "N";
            }
            echo json_encode($arr_to_return);
        }
    }

    public function switchLanguage() {
        if ($this->input->post('lang_id') != "") {
            $this->session->set_userdata('lang_id', $this->input->post('lang_id'));
        } else {
            $this->session->set_userdata('lang_id', 17);
        }
    }

    public function blogCategory() {
        /*         * checking admin is logged in or not ** */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /** using the email template model ** */
        $data = $this->common_model->commonFunction();
        $arr_privileges = array();

        //checking for admin privilages
        if ($data['user_account']['role_id'] != 1) {
            $arr_privileges = $this->common_model->getRecords('trans_role_privileges', 'privilege_id', array("role_id" => $data['user_account']['role_id']));
            if (count($arr_privileges) > 0) {
                foreach ($arr_privileges as $privilege) {
                    $user_privileges[] = $privilege['privilege_id'];
                }
            }
            $arr_login_admin_privileges = $user_privileges;
            if (in_array('13', $arr_login_admin_privileges) == FALSE) {
                /* an admin which is not super admin not privileges to access Manage Role
                 * setting session for displaying notiication message. */
                $this->session->set_userdata("permission_msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
                redirect(base_url() . "auth/home");
                exit();
            }
        }

        $post_categories = $this->blog_model->getCategories('', '', 'category_id desc');
        $data["title"] = "Manage Blog Categories";
        $data["arr_post_categories"] = $post_categories;
        $this->load->view('backend/blogs/blog-category', $data);
    }

    public function add_category() {

        /*         * checking admin is logged in or not ** */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /*         * using the email template model ** */

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
            if (in_array('13', $arr_login_admin_privileges) == FALSE) {
                /* an admin which is not super admin not privileges to access Manage Role
                 * setting session for displaying notiication message. */
                $this->session->set_userdata("permission_msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
                redirect(base_url() . "backend/home");
                exit();
            }
        }

        $post_category = $this->input->post("category_name");

        if ($post_category != "") {

            $arr_blog_comment = array();
            $arr_blog_comment["category_name"] = ($post_category);
            $arr_blog_comment["parent_id"] = "" . $this->input->post("parent_category");
            $arr_blog_comment["created_on"] = date("Y-m-d H:i:s");
//            $inserted_id = $this->blog_model->add_category($arr_blog_comment);

            $arr_to_insert_uri = array(
                "url" => str_replace(" ", "-", ($this->input->post('blog_model'))),
                'type' => 'blog-category',
                'rel_id' => $inserted_id,
            );

            $this->blog_model->insertURI($arr_to_insert_uri);
            $this->session->set_userdata("msg", "<span class='success'>Record added successfully!</span>");

            redirect(base_url() . "backend/blog/blog-category");
        }

//        $arr_categories = $this->blog_model->getCategories();

        $data["title"] = "Add Blog Category";
        $data["arr_categories"] = $arr_categories;
        $this->load->view('backend/blogs/add_category', $data);
    }

    public function year_details($year, $month) {
        $data['global'] = $this->common_model->getGlobalSettings();

        $year_info = $this->blog_model->getYearsForBlog('*', array('year' => $year, 'month' => $month));
        if (count($year_info) > 0) {
            $data['header'] = array("title" => $year_info[0]['post_title'],
                "keywords" => $year_info[0]['post_keywords'],
                "description" => $year_info[0]['post_short_description']);
        }
        $data['year_info'] = $year_info;
        $data['category_tree'] = $this->getBlogCategoriesTreeStructure();
        $data['blog_posts'] = $this->blog_model->getYearsForBlog('', array('year' => $year, 'month' => $month), '', '');
        $data['site_title'] = 'Blog';
        $this->load->view('front/includes/header', $data);
//        $this->load->view('front/includes/top-nav', $data);
        $this->load->view('front/blogs/blog-home1', $data);
        $this->load->view('front/includes/footer');
    }

    public function checkCategoryName() {
        //checking admin is logged in or not
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        $data = $this->common_model->commonFunction();
        $category_name = $this->input->post('category_name');
        $parent_category_id = $this->input->post('parent_category');
        $get_category_list = $this->blog_model->getCategoryList($parent_category_id, $category_name);
        if (count($get_category_list) > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }

    public function checkEditCategoryName() {
        //checking admin is logged in or not
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        $data = $this->common_model->commonFunction();
        $category_name = $this->input->post('category_name');
        $old_category_name = $this->input->post('old_category_name');
        $parent_category_id = $this->input->post('parent_category');
        $get_category_list = $this->blog_model->getCategoryList($parent_category_id, $category_name);

        if (count($get_category_list) > 0) {
            if ($get_category_list[0]['category_name'] == $old_category_name) {
                echo "true";
            } else {
                echo "false";
            }
        } else {
            echo "true";
        }
    }

    function findExtension($filename) {
        $filename = strtolower($filename);
        $exts = explode(".", $filename);
        $file_name = '';
        for ($i = 0; $i <= count($exts) - 2; $i++) {
            $file_name .= $exts[$i];
        }
        $n = count($exts) - 1;
        $exts = $exts[$n];
        $arr_return = array(
            'file_name' => $file_name,
            'ext' => $exts
        );
        return $arr_return;
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */