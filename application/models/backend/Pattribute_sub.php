<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pattribute_sub extends MY_Model {

    public $_table = 'p_sub_attributes';
    public $primary_key = 'attribute_id';
    protected $soft_delete = true;
    protected $soft_delete_key = 'isactive';

    function get_level($group_id) {

        $result = $this->db->get_where('main_groups', array('id' => $group_id))->row();
        return $result->level;
        //echo $this->db->last_query();exit;
    }

    function get_sub_attributes_at_id($attr_id) {
        $this->db->select('pts.*');
        $this->db->from('p_sub_attributes pts');
        $this->db->where('pts.attribute_id', $attr_id);
//        $this->db->group_by('pts.id');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function get_sub_attributes_at_category_id($attr_id) {
//        $this->db->select('pts.*');
//        $this->db->from('p_sub_attributes pts');
//        $this->db->where('pts.attribute_id', $attr_id);
//        $this->db->group_by('pts.id');
         $this->db->select('ipc.*,');
        $this->db->from('it_product_sub_category ipc');
        $this->db->join('p_attributes pa', 'pa.id=ipc.p_sub_category_id', 'left');
        $this->db->join('p_sub_attributes ipas', 'pa.id=ipas.attribute_id', 'left');
        
        $this->db->where('pa.is_brand',1);
        $this->db->where('ipc.p_category_id',$attr_id);
        $query = $this->db->get();
//        echo $this->db->last_query();
//      die();
        return $query->result_array();
    }

    function delet_attr($attrId) {
        $this->db->where('attribute_id', $attrId);
        $this->db->delete('p_sub_attributes');
    }

}
