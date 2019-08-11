<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_Model_marketing extends CI_Model {
    /* Function For Getting Records From Table Start */

    public function getRecords($table, $fields = '', $condition = '', $order_by = '', $limit = '', $debug = 0) {
        $str_sql = '';
        if (is_array($fields)) {  #$fields passed as array
            $str_sql.=implode(",", $fields);
        } elseif ($fields != "") {   #$fields passed as string
            $str_sql .= $fields;
        } else {
            $str_sql .= '*';  #$fields passed blank
        }
        $this->db->select($str_sql, FALSE);
        if (is_array($condition)) {  #$condition passed as array
            if (count($condition) > 0) {
                foreach ($condition as $field_name => $field_value) {
                    if ($field_name != '' && $field_value != '') {
                        $this->db->where($field_name, $field_value);
                    }
                }
            }
        } else if ($condition != "") { #$condition passed as string
            $this->db->where($condition);
        }
        if ($limit != "")
            $this->db->limit($limit);#limit is not blank

        if (is_array($order_by)) {
            $this->db->order_by($order_by[0], $order_by[1]);  #$order_by is not blank
        } else if ($order_by != "") {
            $this->db->order_by($order_by);  #$order_by is not blank
        }
        $this->db->from($table);
        $query = $this->db->get();
        if ($debug) {
            die($this->db->last_query());
        }
        //echo $this->db->last_query();
        return $query->result_array();
    }

    /* Function For Getting Records From Table End */



    /* Function For Getting Global Setting File From Table Start */

    public function commonFunction() {
        $global = array();
//        $lang_id = 17; #default is 17 for english set lang id from session if global setting required for different language.
        #geting global settings from file
//        $lang_id = $this->session->userdata('lang_id'); #default is 17 for english set lang id from session if global setting required for different language.
        $file_name = "global-settings";
        $resp = file_get_contents($this->absolutePath() . "application/config/" . $file_name);
        $data['global'] = unserialize($resp);
        $data['absolute_path'] = $this->absolutePath();
        $data['user_account'] = $this->session->userdata('user_account');
        if (!(empty($data['user_account']))) {
            $this->isLoggedIn();
        }

        return($data);
    }

    /* Function For Getting Global Setting File From Table End */



    /* Function For Checkin If User Is Logged Blocked, Inactive Or Deleted For Sysytem Start */

    public function isLoggedIn() {
        $user_account = $this->session->userdata('user_account');
        if (isset($user_account['user_id']) && $user_account['user_id'] != '') {
            $absolute_path = $this->absolutePath();
            if (file_exists($absolute_path . "assets/frontend/user-status/blocked-user")) {
                $blocked_user = $this->read_file($absolute_path . "assets/frontend/user-status/blocked-user");
                if (in_array($user_account['user_id'], $blocked_user)) {
                    $this->session->unset_userdata('user_account');
                    $this->session->unset_userdata('user_id');
                    $this->session->unset_userdata('user_email');
                    $this->session->unset_userdata('user_name');
                    if ($user_account['user_type'] == "1") {
                        $msg = '<div class="alert alert-block"><strong>Sorry!</strong> Your account has been blocked by Administrator.</div>';
                        $this->session->set_userdata("msg", $msg);
                        redirect(base_url() . "backend/login");
                    } else {
                        $msg = array('msg_type' => 'warning', 'msg_slogan' => 'Info', 'msg_detail' => 'Your account has been blocked by Administrator.');
                        $this->session->set_userdata('flash_message', $msg);
                        redirect(base_url() . "signin");
                    }
                }
            }

            if (file_exists($absolute_path . "assets/frontend/user-status/inactive-user")) {
                $inactive_user = $this->read_file($absolute_path . "assets/frontend/user-status/inactive-user");

                if (in_array($user_account['user_id'], $inactive_user)) {

                    $this->session->unset_userdata('user_account');
                    $this->session->unset_userdata('user_id');
                    $this->session->unset_userdata('user_email');
                    $this->session->unset_userdata('user_name');

                    if ($user_account['user_type'] == "1") {
                        $msg = '<div class="alert alert-block"><strong>Sorry!</strong> Your account has been inactivated due to your email address updated by Administrator, please contact with Administrator for more detail.</div>';
                        $this->session->set_userdata("msg", $msg);
                        redirect(base_url() . "backend/login");
                    } else {
                        $msg = array('msg_type' => 'warning', 'msg_slogan' => 'Info', 'msg_detail' => 'Your account has been inactivated due to your email address updated, please activate your account by clicking on email link.');
                        $this->session->set_userdata('flash_message', $msg);
                        redirect(base_url() . "signin");
                    }
                }
            }
            if (file_exists($absolute_path . "assets/frontend/user-status/deleted-user")) {
                $deleted_user = $this->read_file($absolute_path . "assets/frontend/user-status/deleted-user");
                if (in_array($user_account['user_id'], $deleted_user)) {

                    $this->session->unset_userdata('user_account');
                    $this->session->unset_userdata('user_id');
                    $this->session->unset_userdata('user_email');
                    $this->session->unset_userdata('user_name');
                    if ($user_account['user_type'] == "1") {
                        $msg = '<div class="alert alert-block"><strong>Sorry!</strong> Your account has been deleted by Administrator.</div>';
                        $this->session->set_userdata("msg", $msg);
                        redirect(base_url() . "backend/login");
                    } else {
                        $this->session->set_userdata('error_msg', 'Your account has been deleted by Administrator.');
                        redirect(base_url() . "signin");
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /* Function For Checkin If User Is Logged Blocked, Inactive Or Deleted For Sysytem End */

    /* Function For Checkin If User Is Logged Blocked, Inactive Or Deleted For Sysytem Start */

    public function isLoggedInFront() {
        $user_account = $this->session->userdata('user_account_front');
        if (isset($user_account['user_id']) && $user_account['user_id'] != '') {
            $absolute_path = $this->absolutePath();
            if (file_exists($absolute_path . "assets/frontend/user-status/blocked-user")) {
                $blocked_user = $this->read_file($absolute_path . "assets/frontend/user-status/blocked-user");
                if (in_array($user_account['user_id'], $blocked_user)) {
                    $this->session->unset_userdata('user_account');
                    $this->session->unset_userdata('user_id');
                    $this->session->unset_userdata('user_email');
                    $this->session->unset_userdata('user_name');
                    if ($user_account['user_type'] == "1") {
                        $msg = '<div class="alert alert-block"><strong>Sorry!</strong> Your account has been blocked by Administrator.</div>';
                        $this->session->set_userdata("msg", $msg);
                        redirect(base_url() . "backend/login");
                    } else {
                        $msg = array('msg_type' => 'warning', 'msg_slogan' => 'Info', 'msg_detail' => 'Your account has been blocked by Administrator.');
                        $this->session->set_userdata('flash_message', $msg);
                        redirect(base_url() . "signin");
                    }
                }
            }

            if (file_exists($absolute_path . "assets/frontend/user-status/inactive-user")) {
                $inactive_user = $this->read_file($absolute_path . "assets/frontend/user-status/inactive-user");

                if (in_array($user_account['user_id'], $inactive_user)) {

                    $this->session->unset_userdata('user_account');
                    $this->session->unset_userdata('user_id');
                    $this->session->unset_userdata('user_email');
                    $this->session->unset_userdata('user_name');

                    if ($user_account['user_type'] == "1") {
                        $msg = '<div class="alert alert-block"><strong>Sorry!</strong> Your account has been inactivated due to your email address updated by Administrator, please contact with Administrator for more detail.</div>';
                        $this->session->set_userdata("msg", $msg);
                        redirect(base_url() . "backend/login");
                    } else {
                        $msg = array('msg_type' => 'warning', 'msg_slogan' => 'Info', 'msg_detail' => 'Your account has been inactivated due to your email address updated, please activate your account by clicking on email link.');
                        $this->session->set_userdata('flash_message', $msg);
                        redirect(base_url() . "signin");
                    }
                }
            }
            if (file_exists($absolute_path . "assets/frontend/user-status/deleted-user")) {
                $deleted_user = $this->read_file($absolute_path . "assets/frontend/user-status/deleted-user");
                if (in_array($user_account['user_id'], $deleted_user)) {

                    $this->session->unset_userdata('user_account');
                    $this->session->unset_userdata('user_id');
                    $this->session->unset_userdata('user_email');
                    $this->session->unset_userdata('user_name');
                    if ($user_account['user_type'] == "1") {
                        $msg = '<div class="alert alert-block"><strong>Sorry!</strong> Your account has been deleted by Administrator.</div>';
                        $this->session->set_userdata("msg", $msg);
                        redirect(base_url() . "backend/login");
                    } else {
                        $this->session->set_userdata('error_msg', 'Your account has been deleted by Administrator.');
                        redirect(base_url() . "signin");
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /* Function For Checkin If User Is Logged Blocked, Inactive Or Deleted For Sysytem End */

    /* Function For Inserting Record In Table Start */

    public function insertRow($insert_data, $table_name) {
        $this->db->insert($table_name, $insert_data);
        return $this->db->insert_id();
    }

    /* Function For Inserting Record In Table End */




    /* Function For Update Record In Table Start */

    public function updateRow($table_name, $update_data, $condition) {
        if (is_array($condition)) {
            if (count($condition) > 0) {
                foreach ($condition as $field_name => $field_value) {
                    if ($field_name != '' && $field_value != '') {
                        $this->db->where($field_name, $field_value);
                    }
                }
            }
        } else if ($condition != "") {
            $this->db->where($condition);
        }
        $this->db->update($table_name, $update_data);

        return TRUE;
    }

    /* Function For Update Record In Table End */




    /* Function For Update Record In Table Start */

    public function deleteRows($arr_delete_array, $table_name, $field_name) {
        if (count($arr_delete_array) > 0) {
            foreach ($arr_delete_array as $id) {
                $this->db->where($field_name, $id);
                $query = $this->db->delete($table_name);
            }
        }
    }

    /* Function For Delete Record In Table Start */



    /* Function For Abosulute Path  Start */

    public function absolutePath($path = '') {
      $abs_path = str_replace('', $path, BASEPATH);
        //Add a trailing slash if it doesn't exist.
        $abs_path = preg_replace("#([^/])/*$#", "\\1/", $abs_path);
        
        return $abs_path;
    }
    
    
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

    /* Function For Abosulute Path End */



    /* Function For Send Email Start */

    public function sendEmail($recipeinets, $from, $subject, $message) {

//         echo "reviepient is ".$recipeinets ."<br>from is ".$from . "<br>subject is ".$subject."<br>messag is ".$message;
//         die;
        // ci email helper initialization
        $config['protocol'] = 'mail';
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
        return $this->email->send();
    }

    /* Function For Send Email End */
    
//    public function twilioSms($from, $to, $msg) {
//        echo 'from'.$from.' to'.$to.' '.$msg;
//        $this->load->library('Twilio');
//        $response = $this->Twilio->sms($from, $to, $msg);
//        echo '<pre>';print_R($response);die;
//        if ($response->IsError)
//
//            return $response->ErrorMessage;
//
//        else
//
//            return true;
//
//    }
    


    /* Function To Writer Serialize Data To File Start */

    public function write_file($file_path, $file_data) {
        $fp = fopen($file_path, "w+");
        fwrite($fp, serialize($file_data));
        fclose($fp);
    }

    /* Function To Writer Serialize Data To File Start */



    /* Function To Read Serialize Data To File Start */

    public function read_file($file_path) {
        /* reading content for file */
        $file_content = file_get_contents($file_path);
        /* returning the unsearilized array of file data */
        return unserialize($file_content);
    }

    /* Function To Read Serialize Data To File End */




    /* Function To Get Seo Url From Give Url Start */

    public function seoUrl($string) {
        $string = trim($string);
        $string = strtolower($string);
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        $string = preg_replace("/[\s-]+/", " ", $string);
        $string = preg_replace("/[\s_]/", "-", $string);
        if ($string != "") {
            return $string;
        } else {
            return time();
        }
    }

    /* Function To Get Seo Url From Give Url End */



    /* Function To Delete Row From Table Start */

    public function deleteItem($table_name, $conditions) {
        $this->db->delete($table_name, $conditions);
    }

    /* Function To Delete Row From Table End */



    /* Function To Delete Row From Table Start */

    public function getGlobalSettings() {
        $global = array();
        $this->db->select('mst_global.*,trans_global.*');
        $this->db->from(TABLES::$MST_GLOBAL_SETTING . ' as mst_global');
        $this->db->join(TABLES::$TRANS_GLOBAL_SETTING . ' as trans_global', 'mst_global.global_name_id = trans_global.global_name_id', 'left');
        $result = $this->db->get();
        foreach ($result->result_array() as $row) {
            $global[$row['name']] = $row['value'];
        }
        return $global;
    }

    /* Function To Delete Row From Table End */


    /* Function To Get Email Template Start */

    public function getEmailTemplateInfo($template_title, $reserved_words) {

        // gather information for database table
        $template_data = $this->getRecords('mst_email_templates', '', array("email_template_title" => $template_title));

        $content = $template_data[0]['email_template_content'];
        $subject = $template_data[0]['email_template_subject'];

        // replace reserved words if any
        foreach ($reserved_words as $k => $v) {
            $content = str_replace($k, $v, $content);
        }
        return array("subject" => $subject, "content" => $content);
    }

    /* Function To Get Email Template Start */

    /* Function To Get posted days start */

    function daysAgo($datetime, $full = false) {
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

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}



public function sendEmailNew($recipeinets, $from, $subject, $message) {
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
       
        return $this->email->send();
    }
    
    function getPageType($condition,$order) {
        $this->db->select("mp.*,tp.*");
        $this->db->from("mst_page_type as mp");
        $this->db->join("trans_page_type as tp", "mp.page_type_id=tp.page_type_id_fk", "left");
        
        if ($condition != '')
            $this->db->where($condition);
        if ($order != '')
            $this->db->order_by($order);
        if ($limit != '')
            $this->db->limit($limit);

        $query = $this->db->get();
       // echo $this->db->last_query();die;
        return $query->result_array();
    }
    
    function getPageList($condition,$order) {
        $this->db->select("mp.*,tp.*,tpt.page_name as page_type_name,tm.name as parent_menu,tm.menu_id_fk as menu_id");
        $this->db->from("mst_page as mp");
        $this->db->join("trans_page as tp", "mp.page_id=tp.page_id_fk", "left");
        $this->db->join("trans_page_type as tpt", "tp.page_type=tpt.page_type_id_fk", "left");
        $this->db->join("trans_menu as tm", "tp.parent_menu=tm.menu_id_fk", "left");
        
        if ($condition != '')
            $this->db->where($condition);
        if ($order != '')
            $this->db->order_by($order);
        if ($limit != '')
            $this->db->limit($limit);
        $this->db->group_by('tp.page_id_fk');
        $query = $this->db->get();
       // echo $this->db->last_query();die;
        return $query->result_array();
    }
    
    function getMenuList($condition,$order) {
        $this->db->select("mm.*,tm.*");
        $this->db->from("mst_menu as mm");
        $this->db->join("trans_menu as tm", "mm.menu_id=tm.menu_id_fk", "left");
        
        if ($condition != '')
            $this->db->where($condition);
        if ($order != '')
            $this->db->order_by($order);
        if ($limit != '')
            $this->db->limit($limit);

        $query = $this->db->get();
       // echo $this->db->last_query();die;
        return $query->result_array();
    }
    
    
    function getPageListWebservice($condition,$order,$limit) {
        $this->db->select("mp.*,tp.*,tpt.page_name as page_type_name,tm.name as parent_menu");
        $this->db->from("mst_page as mp");
        $this->db->join("trans_page as tp", "mp.page_id=tp.page_id_fk", "left");
        $this->db->join("trans_page_type as tpt", "tp.page_type=tpt.page_type_id_fk", "left");
        $this->db->join("trans_menu as tm", "tp.page_type=tpt.page_type_id_fk", "left");
        if ($condition != '')
            $this->db->where($condition);
        if ($order != '')
            $this->db->order_by($order);
        if ($limit != ''){
            $this->db->limit($limit);
        }
        $this->db->group_by('tp.page_id_fk');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $query->result_array();
    }
    
    
    function getSenderList($condition) {
        $this->db->select("u.email,u.first_name,u.last_name,u.phone,ms.list_name");
        $this->db->from("mst_sender_list as ms");
        $this->db->join("trans_sender_list as ts", "ms.id=ts.list_id", "left");
        $this->db->join("users as u", "ts.user_id=u.id", "left");
         if ($condition != '')
            $this->db->where($condition);
//        if ($order != '')
//            $this->db->order_by($order);
//        if ($limit != ''){
//            $this->db->limit($limit);
//        }
        $this->db->group_by('u.id');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $query->result_array();
    }
    
    
    function getSubMenu($condition) {
        $this->db->select("tp.page_id_fk,tp.page_name,file_name,tm.name as menu_name");
        $this->db->from("trans_menu as tm");
        //$this->db->join("trans_menu as tm", "mm.menu_id=tm.menu_id_fk", "inner");
        $this->db->join("trans_page as tp", "tm.menu_id_fk=tp.parent_menu", "left");
        if ($condition != '')
            $this->db->where($condition);
//        if ($order != '')
//            $this->db->order_by($order);
//        if ($limit != ''){
//            $this->db->limit($limit);
//        }
        //$this->db->group_by('tp.page_id_fk');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $query->result_array();
    }
    
    function getMainMenu($condition){
        $this->db->select("page_type,page_name,page_id_fk,parent_menu,page_name,file_name");
        $this->db->from("trans_page as tm");
        
        if ($condition != ''){
            $this->db->where($condition);
        }
       
        $this->db->order_by('trans_page_id DESC');
        
        $query = $this->db->get();
        return $query->result_array();
    }


    /* Function To Get posted days start */
}



?>
