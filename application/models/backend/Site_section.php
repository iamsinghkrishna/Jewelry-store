<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Site_section extends MY_Model {
    
    public $_table = 'trans_cms';
    public $primary_key = 'cms_val_id';
    protected $soft_delete = true;
    protected $soft_delete_key = '0';
    
     public function home_page_sction()
    {
      $q= $this->db->where('cms_id','1')->get('trans_cms');
      return $q->result_array();
    }
     public function about_page_sction()
    {
      $q= $this->db->where('cms_id','2')->get('trans_cms');
      return $q->result_array();
    }
    
     public function contact_page_sction()
    {
      $q= $this->db->where('cms_id','3')->get('trans_cms');
      return $q->result_array();
    }

    public function ourservices_page_sction()
    {
      $q= $this->db->where('cms_id','6')->get('trans_cms');
      return $q->result_array();
    }
    public function update_d($data) {
       
        $this->db->update_batch('trans_cms', $data, 'cms_val_id');
    }
    public function get_home_page_section($id) {
        $q= $this->db->where('cms_id',$id)->get('trans_cms');
        return $q->result_array();
    }
    
     public function insert_slider($data) {
        //$q= $this->db->where('cms_id',$id)->get('trans_cms');
        return  $this->db->insert_batch('it_mst_slider', $data);
    }
    
     public function update_s($data) {
       
        $this->db->update_batch('it_mst_slider', $data, 'id');
    }
    
}

/* End of file Product.php */
/* Location: ./models/backend/Product.php */