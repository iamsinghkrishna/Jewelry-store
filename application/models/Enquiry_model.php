<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Enquiry_model extends MY_Model {

    public $_table = 'it_product_enquiry';
    public $primary_key = 'id';

 
    public function contact_us($contact) {
        return $this->db->insert('it_contact_us',$contact);
    }
    
    public function delete_inq($id) {
        return $this->db->where('id',$id)->delete('it_product_enquiry');
    }
    
    public function get_conatact() {
        $q=$this->db->order_by('id', 'DESC')->get('it_contact_us');
        return $q->result_array();
    }
    public function delete_contact($id) {
        return $this->db->where('id',$id)->delete('it_contact_us');
    }
}
