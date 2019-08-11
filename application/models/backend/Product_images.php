<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_images extends MY_Model {

    public $_table = 'it_products_image';
    public $primary_key = 'product_id';
    protected $soft_delete = true;
    protected $soft_delete_key = 'isactive';

    function get_level($group_id) {

        $result = $this->db->get_where('main_groups', array('id' => $group_id))->row();
        return $result->level;
        //echo $this->db->last_query();exit;
    }

    function get_by_id($productId) {
        $this->db->select('ipm.*');
        $this->db->from('it_products_image ipm');
        $this->db->join('it_products ip', 'ipm.product_id = ip.id');
        $this->db->where('ipm.product_id', $productId);
//        $this->db->where('ipm.is_wheel_plugin', '!=1');
        $query = $this->db->get();
        return $query->result_array();
    }
    function delet_img($imgId) {
        $this->db->where('id', $imgId);
        $this->db->delete('it_products_image');
    }

}

/* End of file Product.php */
/* Location: ./models/backend/Product.php */