<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class subscriber_Newsletter_Model extends CI_Model {
    #function to get newsletter list from the database

    public function getSubscriberNewsletterDetails() {
        $this->db->select('*');
        $query = $this->db->get(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION);
        
        $error = $this->db->_error_message();
            $error_number = $this->db->_error_number();
            if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                 'error_number' => $error_number,
                 'model_name' => 'subscriber_newsletter_model',
                 'model_method_name' => 'getSubscriberNewsletterDetails',
                 'controller_name' => $controller,
                 'controller_method_name' => $method
                );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            }
            
        return $query->result_array();
    }

    function updateSubcriberNewsletterDetails($data, $condition) {
        $this->db->where($condition);
        $this->db->update(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION, $data); 
        
        $error = $this->db->_error_message();
            $error_number = $this->db->_error_number();
            if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                 'error_number' => $error_number,
                 'model_name' => 'subscriber_newsletter_model',
                 'model_method_name' => 'updateSubcriberNewsletterDetails',
                 'controller_name' => $controller,
                 'controller_method_name' => $method
                );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            }
            
    }

    function getSubcriberNewsletterDetailsById($id) {
        $this->db->select('*');
        $this->db->where('newsletter_subscription_id', $id);
        $query = $this->db->get(TABLES::$TRANS_NEWSLETTER_SUBSCRIPTION);
        
        $error = $this->db->_error_message();
            $error_number = $this->db->_error_number();
            if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                 'error_number' => $error_number,
                 'model_name' => 'subscriber_newsletter_model',
                 'model_method_name' => 'getSubcriberNewsletterDetailsById',
                 'controller_name' => $controller,
                 'controller_method_name' => $method
                );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            }
            
        return $query->result_array();
    }
       
    }
 ?>