<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Slider_home extends MY_Model {
    
     public function get_slider() {
        $q = $this->db->get('it_mst_slider');
        return $q->result_array();
    }
  public function get_slider_edit($id) {
        $q = $this->db->where('id',$id)->get('it_mst_slider');
        return $q->result_array();
    }
    public function add_slider_backend($arr)
    {
       return $this->db->insert('it_mst_slider',$arr);
    }
    
    public function update_slider_backend($arr,$id)
    {
       return $this->db->where('id',$id)->update('it_mst_slider',$arr);
    }

    public function delete_backend($id) {
        return $this->db->where('id',$id)->delete('it_mst_slider');
        
    }
    
}

/* End of file Product.php */
/* Location: ./models/backend/Product.php */