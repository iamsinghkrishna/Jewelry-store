<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class subscriber_Model extends CI_Model {
    #function to get newsletter list from the database

    public function getSubscriberNewsletterDetails() {
        $this->db->select('*');
        $query = $this->db->get(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION);
        return $query->result_array();
    }

    public function updateSubcriberNewsletterDetails($data, $condition) {
        $this->db->where($condition);
        $this->db->update(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION, $data); 
    }

    public function getSubcriberNewsletterDetailsById($id) {
        $this->db->select('*');
        $this->db->where('newsletter_subscription_id', $id);
        $query = $this->db->get(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION);
        return $query->result_array();
    }
    
    public function getSubscriberUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0) {
        $this->db->select($fields_to_pass, FALSE);
        $this->db->from($table_to_pass);
        if ($condition_to_pass != '')
            $this->db->where($condition_to_pass);
        if ($order_by_to_pass != '')
            $this->db->order_by($order_by_to_pass);
        if ($limit_to_pass != '')
            $this->db->limit($limit_to_pass);
        $query = $this->db->get();
        if ($debug_to_pass)
            echo $this->db->last_query();

        return $query->result_array();
    }
    
    public function insertNewsletterSubscriber($arr_fields) {
        
        $this->db->insert(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION, $arr_fields);
        return $this->db->insert_id();
    }
       
    }
 