<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_attribute extends MY_Model {

    public $_table = 'it_product_attributes';
    public $primary_key = 'product_id';

//    protected $soft_delete = true;
//    protected $soft_delete_key = 'isactive';

    function get_level($group_id) {

        $result = $this->db->get_where('main_groups', array('id' => $group_id))->row();
        return $result->level;
        //echo $this->db->last_query();exit;
    }

    function get_by_id($productId) {
        $this->db->select('ipa.*');
        $this->db->from('it_product_attributes ipa');
        $this->db->join('it_products ip', 'ipa.product_id = ip.id');
        $this->db->where('ipa.product_id', $productId);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_details_by_id($productId) {
        $this->db->select('ipa.*,ipas.sub_name as subattribute_name');
        $this->db->from('it_product_attributes ipa');
        $this->db->join('it_products ip', 'ipa.product_id = ip.id');
        $this->db->join('p_sub_attributes ipas', 'ipas.id = ipa.sub_attribute_id');
//        $this->db->join('p_sub_attributes ipas', 'ipas.id = ipa.sub_attribute_dp_id','LEFT');
        $this->db->where('ipa.product_id', $productId);
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    function update_attr($attr_id, $data) {
        $this->db->where('id', $attr_id);
        $this->db->update('it_product_attributes', $data);
    }

}

/* End of file Product.php */
/* Location: ./models/backend/Product_Attribute.php */