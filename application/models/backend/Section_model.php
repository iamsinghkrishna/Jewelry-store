<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Section_model extends MY_Model {
    
    public $_table = 'mst_cms';
    public $primary_key = 'cms_id';
    protected $soft_delete = true;
    protected $soft_delete_key = '0';
    
     public function get_slider()
    {
      $q= $this->db->limit(5)->get('it_mst_slider');
      return $q->result_array();
    }

    public function add_slider_backend($arr)
    {
       return $this->db->insert('it_mst_slider',$arr);
    }

    public function delete_backend($id) {
        return $this->db->where('id',$id)->delete('it_mst_slider');
        
    }
    
      public function get_home_title($id) {
        return $this->db->where('cms_id',$id)->get('mst_cms');
        
    }
    public function get_home_page_section($id) {
//        echo $id;
//        exit;
        $q= $this->db->where('cms_id',$id)->get('trans_cms');
        return $q->result_array();
    }
     public function get_slider_page_section($id) {
//        echo $id;
//        exit;
        $q= $this->db->where('cms_id',$id)->get('it_mst_slider');
        return $q->result_array();
    }
}

/* End of file Product.php */
/* Location: ./models/backend/Product.php */