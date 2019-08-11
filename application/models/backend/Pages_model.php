<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages_model extends MY_Model {
    
    public $_table = 'it_mst_pages';
    public $primary_key = 'id';
//    protected $soft_delete = true;
//    protected $soft_delete_key = '0';
    
       function get_record($id) {
        $query= $this->db->where('id',$id)->get('it_mst_pages');
        return $query->result_array();
    }
    
}

/* End of file Product.php */
/* Location: ./models/backend/Product.php */