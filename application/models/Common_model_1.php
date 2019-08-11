<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_Model extends CI_Model {
    /* function to get global setttings from the database */

//    public function getGlobalSettings($lang_id = ''){
//        $global = array();
//        $this->db->select('mst_global.*,trans_global.*');
//        $this->db->from('mst_global_settings as mst_global');
//        $this->db->join('trans_global_settings as trans_global', 'mst_global.global_name_id = trans_global.global_name_id', 'left');
//        if ($lang_id != '') {
//            $this->db->where("trans_global.lang_id", $lang_id); /* for lnag id passed ie. english */
//        } else {
//            $this->db->where("trans_global.lang_id", 17); /* for default language ie. english */
//        }
//        $result = $this->db->get();
//        
//        foreach ($result->result_array() as $row) {
//            $global[$row['name']] = $row['value'];
//        }
//        $error = $this->db->_error_message();
//        $error_number = $this->db->_error_number();
//        if ($error) {
//            $controller = $this->router->fetch_class();
//            $method = $this->router->fetch_method();
//            $error_details = array(
//                'error_name' => $error,
//                'error_number' => $error_number,
//                'model_name' => 'common_model',
//                'model_method_name' => 'getGlobalSettings',
//                'controller_name' => $controller,
//                'controller_method_name' => $method
//            );
//            $this->common_model->errorSendEmail($error_details);
//            redirect(base_url() . 'page-not-found');
//            exit();
//        }
//        return $global;
//    }
    public function getNames($mydata) {
        $this->db->select($mydata['field']);
        $this->db->from($mydata['table_name']);
        $this->db->where_in($mydata['column_name'],  $mydata['ids']  );
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    public function insert_query($data){
        $query="INSERT INTO `p1060wp_posts` (`post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`,  `post_status`,  `post_type` )"
                .                            " VALUES ({$data['helper_id']}, '{$data['date']}', '{$data['date']}', '{$data['content']}', '{$data['title']}', 'pending','post' );";
                die($query);
        $this->db->query($query);
    }

    // get all users who have set radius and the project is posted within that radius
     public function getUserListForDistance($latitude, $longitude) {
        $sql = "SELECT `u`.user_id,`u`.user_lat,`u`.user_long,`u`.travel_preference, (((acos(sin(($latitude*pi()/180)) * sin((u.user_lat*pi()/180))+cos(($latitude*pi()/180)) * cos((u.user_lat*pi()/180)) * cos((($longitude - u.user_long)*pi()/180))))*180/pi())*60*1.1515*1.609344) AS distance "
                . "FROM (`" . $this->db->dbprefix . "mst_users` as u) "
                . "HAVING distance <= `u`.travel_preference "
                . "ORDER BY `u`.user_id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
     public function getUserListForSendQuoteNotification($latitude, $longitude,$cat_id) {
        $sql = "SELECT `u`.user_id,`u`.user_lat,`u`.user_long,`u`.travel_preference, (((acos(sin(($latitude*pi()/180)) * sin((u.user_lat*pi()/180))+cos(($latitude*pi()/180)) * cos((u.user_lat*pi()/180)) * cos((($longitude - u.user_long)*pi()/180))))*180/pi())*60*1.1515*1.609344) AS distance "
                . "FROM (`" . $this->db->dbprefix . "trans_user_category` as c) "
                ." left join ".$this->db->dbprefix."mst_users as u on c.user_id=u.user_id"
                ." where user_status='1' and "
                ."  categories=".$cat_id
                . "  HAVING distance <= `u`.travel_preference "
                . " ORDER BY `u`.user_id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function timeAgo($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full)
        $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}    

    /* common function to get records from the database table */
    public function get_details($id)
    {
        $q= $this->db->where('testimonial_id',$id)->get('mst_testimonial');
        return $q->result_array();
    }

    public function getRecords($table, $fields = '', $condition = '', $order_by = '', $limit = '', $debug = 0) {
        $str_sql = '';
        if (is_array($fields)) { /* $fields passed as array */
            $str_sql.=implode(",", $fields);
        } elseif ($fields != "") { /* $fields passed as string */
            $str_sql .= $fields;
        } else {
            $str_sql .= '*';  /* $fields passed blank */
        }
        $this->db->select($str_sql, FALSE);
        if (is_array($condition)) { /* $condition passed as array */
            if (count($condition) > 0) {
                foreach ($condition as $field_name => $field_value) {
                    if ($field_name != '' && $field_value != '') {
                        $this->db->where($field_name, $field_value);
                    }
                }
            }
        } else if ($condition != "") { /* $condition passed as string */
            $this->db->where($condition);
        }
        if ($limit != "") {
            $this->db->limit($limit); /* limit is not blank */
        }
        if (is_array($order_by)) {
            $this->db->order_by($order_by[0], $order_by[1]);  /* $order_by is not blank */
        } else if ($order_by != "") {
            $this->db->order_by($order_by);  /* $order_by is not blank */
        }
        $this->db->from($table);  /* getting record from table name passed */
        $query = $this->db->get();
        if ($debug) {
            die($this->db->last_query());
        }
        $error = $this->db->_error_message();
        $error_number = $this->db->_error_number();
        if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                'error_number' => $error_number,
                'model_name' => 'common_model',
                'model_method_name' => 'getRecords',
                'controller_name' => $controller,
                'controller_method_name' => $method
            );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            exit();
        }
        return $query->result_array();
    }

    /* function to get common record for the user	ie. absoulute path, global settings. */

    public function commonFunction() {
        $global = array();
        /* geting global settings from file */
        $lang_id = 17; /* default is 17 for english set lang id from session if global setting required for different language. */
        $file_name = "global-settings";
        $resp = file_get_contents(APPPATH. "config/" . $file_name);
        $data['global'] = unserialize($resp);
//        $data['absolute_path'] = $this->absolutePath();
        $data['user_account'] = $this->session->userdata('user_account');
        
        if($data['user_account']['user_id']!="" && $data['user_account']['user_id'] != '1'){
        $data['user_details']=  $this->getRecords("mst_users", "charge_for_your_time,register_date,user_id,user_email,profile_picture,dob,is_both,user_type,user_address,contact_number,about_me,first_name,last_name,id_confirmed,phone_confirmed,account_confirmed,travel_preference,rate_per_hour,user_lat,user_long,linked_in_page_url,facebook_page_url,storage_pair_hands,available_to_help,stripe_acc_id,stripe_cust_id,payment_type,suburb,stripe_acc_id,stripe_cust_id,is_both,payment_type,base_id,user_identification,account_holder_name,account_number,BSB,bank_name,is_verified_bank_account", array("user_id"=>$data['user_account']['user_id']), $order_by, $limit, $debug);
        $data['message_count']=end($this->getRecords("mst_ims", "count(ims_id) as unread_count ", array("ims_read_status"=>'Unread','ims_to'=>$data['user_account']['user_id'])));
        $data['total_ims_per_user']=end($this->getRecords("mst_ims", "ims_id", array("ims_read_status"=>'Unread','ims_to'=>$data['user_account']['user_id'])));
        $data['lattest_message']=end($this->getMessages($data['user_account']['user_id']));
        }
        
//        $data['help_types']=  $this->getRecords("trans_category_details","*",'','category_name ASC');
        
        //$data['latest_blogs'] = $this->getLatestBlog();
        return($data);
    }
    public function getMessages($user_id) {
        $this->db->select('u.profile_picture,m.ims_time,m.ims_id,m.ims_from,m.ims_to,m.ims_subject,ims_contents,ims_date,u.first_name,m.rel_id');
        $this->db->from("mst_ims as m");
        $this->db->join("mst_users as u",'u.user_id=m.ims_from','inner');
        $this->db->where('m.ims_to',$user_id);
        $this->db->where('m.ims_read_status','Unread');
        $this->db->order_by('m.ims_id', 'DESC');
        $this->db->limit('1');        
        $query = $this->db->get();
        return $query->result_array();
    }

    /* function to check user loged in or not. */

    public function isLoggedIn(){
        $user_account = $this->session->userdata('user_account');
        $path_info = $this->uri->segment(1);

        if (isset($path_info) && ($path_info == 'admin' || $path_info == 'backend')) {

            if ($user_account['user_type'] != '') {

                if ($user_account['user_type'] != 2) {
                    $this->session->set_userdata('login_error', 'It seems you are already logged in with some other user. Please <a href=' . base_url() . 'backend/log-out>Logout</a> first!!');
                    redirect(base_url() );
                    exit();
                }
            } else {
                redirect(base_url() . "backend/login");
                exit();
            }
        } else { 
            if ($user_account['user_type'] != '') {
                if ($user_account['user_type'] == 2) {
                    $msg = '<div class="alert alert-block"><strong>Sorry!</strong>"It seems you are already logged in with admin user. Please <a href=' . base_url() . 'logout>Logout</a> first. <div>';
                    $this->session->set_userdata("msg", $msg);
                    redirect(base_url() . "backend/login");
                    exit();
                }
            } 
        }

        if (isset($user_account['user_id']) && $user_account['user_id'] != '') {
            //For checking the changed email verification
            $arr_ad_detail = $this->common_model->getRecords("mst_users", "*", array("user_id" => $user_account['user_id']));
            
            if (count($arr_ad_detail) > 0) {
                if (($arr_ad_detail[0]['user_status'] == 0) && $arr_ad_detail[0]['email_verified'] == 0) {
                    //account is already activated to this p1060 project
                    $this->session->unset_userdata("user_account");
                    $msg = '<div class="alert alert-block"><strong>Sorry!</strong> Your account is not activated yet, Please activate it and get log in.</div>';
                    $this->session->set_userdata("msg", $msg);
                    redirect(base_url() . "backend/login");
                    exit();
                }
                /* checking if user into blocked list or not 
                  checking file is exists or not */
                $absolute_path = $this->absolutePath();
                if (file_exists($absolute_path . "media/front/user-status/blocked-user")) {
                    /* getting all blocked user from file */
                    $blocked_user = $this->read_file($absolute_path . "media/front/user-status/blocked-user");
                    if (in_array($user_account['user_id'], $blocked_user)) {
                        /* removing the user from the bloked file list */
                        $key = array_search($user_account['user_id'], $blocked_user);
                        if ($key !== false) {
                            unset($blocked_user[$key]);
                        }
                        $this->write_file($absolute_path . "media/front/user-status/blocked-user", $blocked_user);
                        /* unsetting the session and redirecting to user to login */
                        if ($user_account['user_type'] == '2') {
                            $this->session->unset_userdata("user_account");
                            $msg = '<div class="alert alert-block"><strong>Sorry!</strong> Your account has been blocked by Administrator.</div>';
                            $this->session->set_userdata("msg", $msg);
                            redirect(base_url() . "backend/login");
                            exit();
                        } else {
                            $this->session->unset_userdata("user_account");
                            $this->session->set_userdata('login_error', "Your account has been blocked by administrator.");
                            $this->session->set_userdata('error', "Your account has been blocked by administrator.");
                            redirect(base_url());
                            exit();
                        }
                    }
                }

                /* checking if user into deleted list or not */
                if (file_exists($absolute_path . "media/front/user-status/deleted-user")) {
                    /* getting all blocked user from file */
                    $deleted_user = $this->read_file($absolute_path . "media/front/user-status/deleted-user");
                    if (in_array($user_account['user_id'], $deleted_user)) {
                        /* removing the user from the deleted file list */
                        $key = array_search($user_account['user_id'], $deleted_user);
                        if ($key !== false) {
                            unset($deleted_user[$key]);
                        }
                        $this->write_file($absolute_path . "media/front/user-status/deleted-user", $deleted_user);
                        /* unsetting the session and redirecting to user to login */
                        if ($user_account['user_type'] == '2') {
                            $this->session->unset_userdata("user_account");
                            $msg = '<div class="alert alert-block"><strong>Sorry!</strong> Your account has been deleted by Administrator.</div>';
                            $this->session->set_userdata("msg", $msg);
                            redirect(base_url() . "backend/login");
                            exit();
                        } else {
                            $this->session->unset_userdata("user_account");
                            $this->session->set_userdata('login_error', "1");
                            $this->session->set_userdata('error', "Your account has been deleted by administrator.");
                            redirect(base_url() );
                            exit();
                        }
                    }
                }
                $error = $this->db->_error_message();
                $error_number = $this->db->_error_number();
                if ($error) {
                    $controller = $this->router->fetch_class();
                    $method = $this->router->fetch_method();
                    $error_details = array(
                        'error_name' => $error,
                        'error_number' => $error_number,
                        'model_name' => 'common_model',
                        'model_method_name' => 'isLoggedIn',
                        'controller_name' => $controller,
                        'controller_method_name' => $method
                    );
                    $this->common_model->errorSendEmail($error_details);
                    redirect(base_url() . 'page-not-found');
                    exit();
                }
                return true;
            } else {
                if ($user_account['user_type'] == '2') {
                    $this->session->unset_userdata("user_account");
                    $msg = '<div class="alert alert-block"><strong>Sorry!</strong> Your account has been deleted by Administrator.</div>';
                    $this->session->set_userdata("msg", $msg);
                    redirect(base_url() . "backend/login");
                    exit();
                } else {
                    $this->session->unset_userdata("user_account");
                    $this->session->set_userdata('error', "Your account has been deleted by administrator.");
                    redirect(base_url());
                    exit();
                }
            }
        } else {
            $error = $this->db->_error_message();
            $error_number = $this->db->_error_number();
            if ($error) {
                $controller = $this->router->fetch_class();
                $method = $this->router->fetch_method();
                $error_details = array(
                    'error_name' => $error,
                    'error_number' => $error_number,
                    'model_name' => 'common_model',
                    'model_method_name' => 'isLoggedIn',
                    'controller_name' => $controller,
                    'controller_method_name' => $method
                );
                $this->common_model->errorSendEmail($error_details);
                redirect(base_url() . 'page-not-found');
                exit();
            }
            return false;
        }
    }

    /* unction to insert record into the database */

    public function insertRow($insert_data, $table_name) {
        $this->db->insert($table_name, $insert_data);
//        $error = $this->db->_error_message();
//        $error_number = $this->db->_error_number();
//        if ($error) {
//            $controller = $this->router->fetch_class();
//            $method = $this->router->fetch_method();
//            $error_details = array(
//                'error_name' => $error,
//                'error_number' => $error_number,
//                'model_name' => 'common_model',
//                'model_method_name' => 'insertRow',
//                'controller_name' => $controller,
//                'controller_method_name' => $method
//            );
//            $this->common_model->errorSendEmail($error_details);
//            redirect(base_url() . 'page-not-found');
//            exit();
//        }
        return $this->db->insert_id();
    }

    /* function to update record in the database
     * Modified by Arvind	
     */

    public function updateRow($table_name, $update_data, $condition) {

        if (is_array($condition)) {
            if (count($condition) > 0) {
                foreach ($condition as $field_name => $field_value) {
                    if ($field_name != '' && $field_value != '' && $field_value != NULL) {
                        $this->db->where($field_name, $field_value);
                    }
                }
            }
        } else if ($condition != "" && $condition != NULL) {
            $this->db->where($condition);
        }
        $this->db->update($table_name, $update_data);
//        $error = $this->db->_error_message();
//        $error_number = $this->db->_error_number();
//        if ($error) {
//            $controller = $this->router->fetch_class();
//            $method = $this->router->fetch_method();
//            $error_details = array(
//                'error_name' => $error,
//                'error_number' => $error_number,
//                'model_name' => 'common_model',
//                'model_method_name' => 'updateRow',
//                'controller_name' => $controller,
//                'controller_method_name' => $method
//            );
//            $this->common_model->errorSendEmail($error_details);
//            redirect(base_url() . 'page-not-found');
//            exit();
//        }
    }

    /* common function to delete rows from the table
     * Modified by Arvind
     */

    public function deleteRows($arr_delete_array, $table_name, $field_name) {
        if (count($arr_delete_array) > 0) {
            foreach ($arr_delete_array as $id) {
                if ($id) {
                    $this->db->where($field_name, $id);
                    $query = $this->db->delete($table_name);
                }
            }
        }
    }

    /*
     * function to get absolute path for project
     */

    public function absolutePath($path = '') {
        $abs_path = str_replace('', $path, BASEPATH);
        //Add a trailing slash if it doesn't exist.
        $abs_path = preg_replace("#([^/])/*$#", "\\1/", $abs_path);
        $error = $this->db->_error_message();
        $error_number = $this->db->_error_number();
        if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                'error_number' => $error_number,
                'model_name' => 'common_model',
                'model_method_name' => 'absolutePath',
                'controller_name' => $controller,
                'controller_method_name' => $method
            );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            exit();
        }
        return $abs_path;
    }

    public function getEmailTemplateInfo($template_title, $lang_id, $reserved_words) {

        // gather information for database table
        $template_data = $this->getRecords('mst_email_templates', '', array("email_template_title" => $template_title, "lang_id" => $lang_id));

        $content = $template_data[0]['email_template_content'];
        $subject = $template_data[0]['email_template_subject'];

        // replace reserved words if any
        foreach ($reserved_words as $k => $v) {
            $content = str_replace($k, $v, $content);
        }
        $error = $this->db->_error_message();
        $error_number = $this->db->_error_number();
        if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                'error_number' => $error_number,
                'model_name' => 'common_model',
                'model_method_name' => 'getEmailTemplateInfo',
                'controller_name' => $controller,
                'controller_method_name' => $method
            );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            exit();
        }
        return array("subject" => $subject, "content" => $content);
    }

    public function sendEmail($recipeinets, $from, $subject, $message) {
        // ci email helper initialization
        $config['protocol'] = 'smtp';
        $config['wordwrap'] = FALSE;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $this->load->library('email', $config);
        $this->email->initialize($config);

        // set the from address
        $this->email->from($from['email'], $from['name']);

        // set the subject
        $this->email->subject($subject);

        // set recipeinets
        $this->email->to($recipeinets);

        // set mail message
        $this->email->message($message);

        // return boolean value for email send
        $error = $this->db->_error_message();
        $error_number = $this->db->_error_number();
        if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                'error_number' => $error_number,
                'model_name' => 'common_model',
                'model_method_name' => 'sendEmail',
                'controller_name' => $controller,
                'controller_method_name' => $method
            );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            exit();
        }
        return $this->email->send();
    }

    public function getPageInfoByUrl($uri) {
        $arr_to_return = $this->getRecords(
                "mst_uri_map", "*", array("url" => $uri)
        );
        $error = $this->db->_error_message();
        $error_number = $this->db->_error_number();
        if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                'error_number' => $error_number,
                'model_name' => 'common_model',
                'model_method_name' => 'getPageInfoByUrl',
                'controller_name' => $controller,
                'controller_method_name' => $method
            );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            exit();
        }
        return $arr_to_return;
    }

    public function validateUriForExists($arr, $arr_exists) {
        $str_condition = "`url` = '" . $arr['uri'] . "' and `type` = '" . $arr['type'] . "'";

        if (count($arr_exists) > 0) {
            $str_condition.=" and rel_id !='" . $arr_exists['rel_id'] . "'";
        }

        $arr_to_return = $this->getRecords(
                "mst_uri_map", "*", $str_condition
        );
        $error = $this->db->_error_message();
        $error_number = $this->db->_error_number();
        if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                'error_number' => $error_number,
                'model_name' => 'common_model',
                'model_method_name' => 'validateUriForExists',
                'controller_name' => $controller,
                'controller_method_name' => $method
            );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            exit();
        }
        return $arr_to_return;
    }

    public function updateURI($arr_fields, $arr_condition) {
        $this->db->update("mst_uri_map", $arr_fields, $arr_condition);
        $error = $this->db->_error_message();
        $error_number = $this->db->_error_number();
        if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                'error_number' => $error_number,
                'model_name' => 'common_model',
                'model_method_name' => 'updateURI',
                'controller_name' => $controller,
                'controller_method_name' => $method
            );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            exit();
        }
    }

    public function insertURI($arr_fields) {
        $this->db->insert("mst_uri_map", $arr_fields);
        $error = $this->db->_error_message();
        $error_number = $this->db->_error_number();
        if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                'error_number' => $error_number,
                'model_name' => 'common_model',
                'model_method_name' => 'insertURI',
                'controller_name' => $controller,
                'controller_method_name' => $method
            );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            exit();
        }
    }

//    public function getNonDefaultLanguages() {
//        $arr_to_return = $this->getRecords(
//                "mst_languages", "*", array("is_default" => 'N')
//        );
//        $error = $this->db->_error_message();
//        $error_number = $this->db->_error_number();
//        if ($error) {
//            $controller = $this->router->fetch_class();
//            $method = $this->router->fetch_method();
//            $error_details = array(
//                'error_name' => $error,
//                'error_number' => $error_number,
//                'model_name' => 'common_model',
//                'model_method_name' => 'getNonDefaultLanguages',
//                'controller_name' => $controller,
//                'controller_method_name' => $method
//            );
//            $this->common_model->errorSendEmail($error_details);
//            redirect(base_url() . 'page-not-found');
//            exit();
//        }
//        return $arr_to_return;
//    }

    /* function to writer serialize data to file */

    public function write_file($file_path, $file_data) {
        /* Opening the file for writing. */
        $fp = fopen($file_path, "w+");
        /* wrinting into file */
        fwrite($fp, serialize($file_data));
        /* closing the file for writing. */
        fclose($fp);
        $error = $this->db->_error_message();
        $error_number = $this->db->_error_number();
        if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                'error_number' => $error_number,
                'model_name' => 'common_model',
                'model_method_name' => 'write_file',
                'controller_name' => $controller,
                'controller_method_name' => $method
            );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            exit();
        }
    }

    /* function to read file from the specified path */

//    public function read_file($file_path) {
//        /* reading content for file */
//        $file_content = file_get_contents($file_path);
//        /* returning the unsearilized array of file data */
//        $error = $this->db->_error_message();
//        $error_number = $this->db->_error_number();
//        if ($error) {
//            $controller = $this->router->fetch_class();
//            $method = $this->router->fetch_method();
//            $error_details = array(
//                'error_name' => $error,
//                'error_number' => $error_number,
//                'model_name' => 'common_model',
//                'model_method_name' => 'read_file',
//                'controller_name' => $controller,
//                'controller_method_name' => $method
//            );
//            $this->common_model->errorSendEmail($error_details);
//            redirect(base_url() . 'page-not-found');
//            exit();
//        }
//        return unserialize($file_content);
//    }

    public function errorSendEmail($error_details) {
        // ci email helper initialization
        $config['protocol'] = 'smtp';
        $config['wordwrap'] = FALSE;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $this->load->library('email', $config);
        $this->email->initialize($config);
        // set the from address
        $data['global'] = $this->getGlobalSettings();
        $from = array(
            'email' => $data['global']['site_email'],
            'name' => $data['global']['site_title']
        );
        $this->email->from($from['email'], $from['name']);

        // set the subject
        $subject = 'Error in model file';
        $this->email->subject($subject);

        // set recipeinets
        $recipeinets = 'joy@panaceatek.com';
        $this->email->to($recipeinets);

        // set mail message
        $message = 'You got an error  <b>' . $error_details['error_name'] .
                '</b> error no - <b>' . $error_details['error_number'] . '</b><br/> Model Name:- <b>' . $error_details['model_name'] . '</b> <br/>  model method is :-<b>' . $error_details['model_method_name'] . '</b><br/> Controller <b>' . $error_details['controller_name'] . '</b>  <br/> Controller method is :<b>' . $error_details['controller_method_name'] . '</b>';


        $this->email->message($message);

        // return boolean value for email send
        return $this->email->send();
    }

    public function getURIInfo($data) {
        //$table, $fields = '', $condition = '', $order_by = '', $limit = '', $debug = 0
        $arr_to_return = $this->getRecords(
                "mst_uri_map", "*", $data, "", "", "");

        $error = $this->db->_error_message();
        $error_number = $this->db->_error_number();
        if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                'error_number' => $error_number,
                'model_name' => 'common_model',
                'model_method_name' => 'getURIInfo',
                'controller_name' => $controller,
                'controller_method_name' => $method
            );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            exit();
        }

        return $arr_to_return;
    }

//    public function getDefaultLanguageId() {
//        $arr_to_return = $this->getRecords("mst_languages", "lang_id", array("is_default" => 'Y'));
//
//        $error = $this->db->_error_message();
//        $error_number = $this->db->_error_number();
//        if ($error) {
//            $controller = $this->router->fetch_class();
//            $method = $this->router->fetch_method();
//            $error_details = array(
//                'error_name' => $error,
//                'error_number' => $error_number,
//                'model_name' => 'common_model',
//                'model_method_name' => 'getDefaultLanguageId',
//                'controller_name' => $controller,
//                'controller_method_name' => $method
//            );
//            $this->common_model->errorSendEmail($error_details);
//            redirect(base_url() . 'page-not-found');
//            exit();
//        }
//
//        return $arr_to_return[0]['lang_id'];
//    }

    // function to get seo url from give url
    public function seoUrl($string) {
        $string = trim($string);
        //Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )
        $string = strtolower($string);
        //Strip any unwanted characters
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);

        /* if string becomes empty then it will take current time stamp */
        if ($string != "") {
            return $string;
        } else {
            return time();
        }
        $error = $this->db->_error_message();
        $error_number = $this->db->_error_number();
        if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                'error_number' => $error_number,
                'model_name' => 'common_model',
                'model_method_name' => 'seoUrl',
                'controller_name' => $controller,
                'controller_method_name' => $method
            );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            exit();
        }
    }

    public function getTestimonial($limit = '', $offset = 0) {
        $field_to_pass = ('t.user_id,t.name,t.testimonial,u.first_name,u.last_name');
        $this->db->select($field_to_pass);
        $this->db->from('mst_testimonial as t');
        $this->db->join('mst_users as u', 'u.user_id = t.user_id', 'left');
        $this->db->where('t.status', 'Active');
        $this->db->order_by('t.testimonial_id DESC');
        if ($limit != '')
            $this->db->limit($limit, $offset);

        $query = $this->db->get();
        $error = $this->db->_error_message();
        $error_number = $this->db->_error_number();
        if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                'error_number' => $error_number,
                'model_name' => 'common_model',
                'model_method_name' => 'getDefaultLanguageId',
                'controller_name' => $controller,
                'controller_method_name' => $method
            );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            exit();
        }
        return $query->result_array();
    }

    //get all languages

//    public function getAllLanguages() {
//
//        $this->db->select('*');
//        $this->db->from('mst_languages');
//        $this->db->where('lang_id <>', '17');
//        $this->db->where('status', 'A');
//
//        $query = $this->db->get();
//        // $query = $this->db->get_where('mst_category', $arr);
//        /*         * * this is to print error message ** */
//        $error = $this->db->_error_message();
//
//        /*         * * this is to print number ** */
//        $error_number = $this->db->_error_number();
//        if ($error) {
//            $controller = $this->router->fetch_class();
//            $method = $this->router->fetch_method();
//            $error_details = array(
//                'error_name' => $error,
//                'error_number' => $error_number,
//                'model_name' => 'category_model',
//                'method_name' => 'getAllLanguages',
//                'controller_name' => $controller,
//                'controller_method_name' => $method
//            );
//            $this->common_model->errorSendEmail($error_details);
//            redirect(base_url() . 'error-redirect');
//            exit();
//        }
//        return $query->result_array();
//    }

//    public function getLanguages() {
//
//        $this->db->select('*');
//        $this->db->from('mst_languages');
////        $this->db->where('lang_id <>', '17');
//        $this->db->where('status', 'A');
//
//        $query = $this->db->get();
//        // $query = $this->db->get_where('mst_category', $arr);
//        /*         * * this is to print error message ** */
//        $error = $this->db->_error_message();
//
//        /*         * * this is to print number ** */
//        $error_number = $this->db->_error_number();
//        if ($error) {
//            $controller = $this->router->fetch_class();
//            $method = $this->router->fetch_method();
//            $error_details = array(
//                'error_name' => $error,
//                'error_number' => $error_number,
//                'model_name' => 'common_model',
//                'method_name' => 'getLanguages',
//                'controller_name' => $controller,
//                'controller_method_name' => $method
//            );
//            $this->common_model->errorSendEmail($error_details);
//            redirect(base_url() . 'error-redirect');
//            exit();
//        }
//        return $query->result_array();
//    }

    public function getWebsiteUsersCount($user_type) {

        $this->db->select('*');
        $this->db->from('mst_users');
        $this->db->where_not_in('user_type', '2');
        $this->db->where($user_type);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function wsIsLoggedIn($user_id) {

        if ($user_id != '') {
            $absolute_path = $this->absolutePath();
            //For checking the changed email verification
            $arr_ad_detail = $this->common_model->getRecords("mst_users", "*", array("user_id" => $user_id));
            if (count($arr_ad_detail) > 0) {
                $flag = 0;
                if (($arr_ad_detail[0]['user_status'] == 0) && ($arr_ad_detail[0]['email_verified'] == 0)) {
                    $flag = 1;
                    $arr_to_return = array('error_code' => "1", "msg" => "Your account is not activated yet, Please activate it and get log in.");
                }
                if (file_exists($absolute_path . "media/front/user-status/blocked-user")) {

                    /* getting all blocked user from file */
                    $blocked_user = $this->read_file($absolute_path . "media/front/user-status/blocked-user");
                    if (in_array($arr_ad_detail[0]['user_id'], $blocked_user)) {
                        $flag = 1;
                        $arr_to_return = array('error_code' => "2", "msg" => "Your account has been blocked by administrator.");
                        /* removing the user from the bloked file list */
                        $key = array_search($arr_ad_detail[0]['user_id'], $blocked_user);
                        if ($key !== false) {
                            unset($blocked_user[$key]);
                        }
                        $this->write_file($absolute_path . "media/front/user-status/blocked-user", $blocked_user);
                        /* unsetting the session and redirecting to user to login */
                        $arr_to_return = array('error_code' => "2", "msg" => "Your account has been blocked by administrator.");
                    }
                }
                if (file_exists($absolute_path . "media/front/user-status/deleted-user")) {
                    /* getting all blocked user from file */
                    $deleted_user = $this->read_file($absolute_path . "media/front/user-status/deleted-user");
                    if (in_array($arr_ad_detail[0]['user_id'], $deleted_user)) {
                        $flag = 1;
                        /* removing the user from the deleted file list */
                        $key = array_search($arr_ad_detail[0]['user_id'], $deleted_user);
                        if ($key !== false) {
                            unset($deleted_user[$key]);
                        }
                        $this->write_file($absolute_path . "media/front/user-status/deleted-user", $deleted_user);
                        /* unsetting the session and redirecting to user to login */
                        $arr_to_return = array('error_code' => "3", "msg" => "Your account has been deleted by administrator.");
                    }
                }
                if ($flag == 0) {
                    $user_image = $arr_ad_detail[0]['profile_picture'];
                    $user_info = array(
                        'user_id' => $arr_ad_detail[0]['user_id'],
                        'firstname' => $arr_ad_detail[0]['first_name'],
                        'lastname' => $arr_ad_detail[0]['last_name'],
                        'username' => $arr_ad_detail[0]['user_name'],
                        'email' => $arr_ad_detail[0]['user_email'],
                        'user_type' => $arr_ad_detail[0]['user_type'],
                        'user_status' => $arr_ad_detail[0]['user_status'],
                        'email_verified' => $arr_ad_detail[0]['email_verified'],
                        'register_date' => $arr_ad_detail[0]['register_date'],
                        'profile_image' => $user_image
                    );
                    $arr_to_return = array('error_code' => "0", "msg" => "success", 'login_arr' => $user_info);
                }
            } else {
                $arr_to_return = array('error_code' => "3", "msg" => "Your account has been deleted by administrator.");
            }
        } else {
            $arr_to_return = array('error_code' => "3", "msg" => "Please login to proceed further.");
        }
        return $arr_to_return;
    }
    
    /*
     * get lat long for suburb added by archana gandhi on 24/10/2016
     */
    
    public function getLatLong($address) {
        $address = addslashes($address);
        $suburb_data = $this->common_model->getRecords('mst_suburbs', '', array('suburb_name' => $address));
        $Lat = $suburb_data[0]['lat'];
        $Long = $suburb_data[0]['long'];
        return array('latitude' => $Lat, 'logitude' => $Long);
    }
    
     public function compress_image($source_url, $destination_url, $quality) {
        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($source_url);
        } elseif ($info['mime'] == 'image/gif') {
            $image = imagecreatefromgif($source_url);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source_url);
        }
        imagejpeg($image, $destination_url, $quality);
        $image_info = getimagesize($destination_url);
        return $destination_url;
    }
    
    /* get recent blog*/
    function getRecentBlogs() {
        $this->db->select('b.post_short_description,user.first_name,user.last_name,u.url,b.blog_image,b.post_title,b.posted_on');
        $this->db->from("mst_blog_posts as b");
        $this->db->join("mst_users as user",'user.user_id=b.posted_by','inner');     
        $this->db->join("mst_uri_map as u", 'u.rel_id = b.post_id and type="blog-post"','left');
        $this->db->where('b.status','1');
        $this->db->order_by('b.posted_on', 'DESC');
        $this->db->limit('2');
        $this->db->group_by('b.post_id');
        $query = $this->db->get();
        return $query->result_array();
    }
    function getLatestBlog() { //For home page
         $condition ="(blog.post_status='publish' or blog.post_status='future') and post_type='post'";
            $limit = 2;
        $sql = "select blog.* from {$this->db->dbwpprefix}posts as blog";
        $sql.=" where $condition";
        $sql.=" order by blog.ID DESC limit $limit";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
     public function commonFunctionToDeleteSingleRecord($table_name, $field_name1 = '', $field_value1 = '', $field_name2 = '', $field_value2 = '', $field_name3 = '', $field_value3 = '') {

        if ($field_name1 != '' && $field_value1 != '') {
            $this->db->where($field_name1, $field_value1);
        }
        if ($field_name2 != '' && $field_value2 != '') {
            $this->db->where($field_name2, $field_value2);
        }
        if ($field_name3 != '' && $field_value3 != '') {
            $this->db->where($field_name3, $field_value3);
        }
        $query = $this->db->delete($table_name);
    }

    /* get recent blog*/
    
    
    public function deleteByCondition($table_name, $condition) {
        $this->db->where($condition);
        $query = $this->db->delete($table_name);
    }
    
    public function TagAreaAutoComplete($condition,$user_suburbs){
         $this->db->select('*');
         $this->db->from("mst_suburbs");
         if($condition != ''){
            $this->db->where($condition);
         }
        if (count($user_suburbs) > 0){
         $this->db->where_in("suburb_name", $user_suburbs);
        }
        $this->db->order_by('suburb_name', 'DESC');
        $this->db->limit('5');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getDataForBase($user_id) {
        $helps_requested = $this->getRecords('mst_help', 'help_budget,total_budget', 'helpee_id = ' . $user_id . ' AND help_status != "canceled"');

        $helps_provided = $this->getRecords('mst_help', 'help_budget,total_budget', 'helper_id = ' . $user_id . ' AND (help_status = "accepted" || help_status = "completed" || help_status = "closed")');

        $total_helps_requsted_to_me = $this->getRecords('mst_help', 'help_budget,total_budget', array('helper_id' => $user_id));

        $total_helps_paid_for = $this->getRecords('mst_help', 'help_budget,total_budget', 'helpee_id = ' . $user_id . ' AND (help_status = "completed" || help_status = "closed")');

        $total_helps_accepted = $this->getRecords('mst_help', 'help_budget,total_budget', 'helper_id = ' . $user_id . ' AND (help_status = "accepted" || help_status = "completed" || help_status = "closed")');

        $total_helps_rejected = $this->getRecords('mst_help', 'help_budget,total_budget', 'helper_id = ' . $user_id . ' AND (help_status = "canceled")');

        $ratings = $this->getRecords('mst_ratings', 'avg(rating) as avg_rating', array('to_id' => $user_id));

        $user_data = $this->getRecords('mst_users', 'last_login,no_of_logins', 'user_id = ' . $user_id);

        $avg_ratings = round($ratings[0]['avg_rating']);
        if (count($total_helps_requsted_to_me) == 0 || count($total_helps_accepted) == 0) {
            $acceptance_rate = "NA";
        } else if (count($total_helps_requsted_to_me) == count($total_helps_rejected)) {
            $acceptance_rate = '0%';
        } else {
            $acceptance_rate = round((count($total_helps_accepted) / count($total_helps_requsted_to_me)) * 100) . '%';
        }
        $total_requested_count = count($helps_requested);
        $total_provided_count = count($helps_provided);
        $total_amount_paid = 0;
        foreach ($total_helps_paid_for as $key => $help) {
            $total_amount_paid = $total_amount_paid + $help['total_budget'];
        }
        $total_amount_earned = 0;
        foreach ($helps_provided as $key => $help) {
            $total_amount_earned = $total_amount_earned + $help['help_budget'];
        }
        $arr_return = array(
            "ratings" => $avg_ratings,
            "acceptance_rate" => $acceptance_rate,
            "number_of_help_requested" => $total_requested_count,
            "number_of_help_provided" => $total_provided_count,
            "amount_of_help_requested" => $total_amount_paid,
            "amount_of_help_provided" => $total_amount_earned,
            "last_login" => $user_data[0]['last_login'],
            "no_of_logins" => $user_data[0]['no_of_logins']
        );
        return $arr_return;
    }
    
}