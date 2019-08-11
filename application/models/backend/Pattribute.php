<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pattribute extends MY_Model {

    public $_table = 'p_attributes';
    public $primary_key = 'id';
    protected $soft_delete = true;
    protected $soft_delete_key = 'isactive';

    function get_level($group_id) {

        $result = $this->db->get_where('main_groups', array('id' => $group_id))->row();
        return $result->level;
        //echo $this->db->last_query();exit;
    }

    function get_attributes_dt() {
        $this->db->select('pt.*,pts.*');
        $this->db->from('p_attributes pt');
        $this->db->from('p_sub_attributes pts', 'pt.id=pts.attribute_id');
//        $this->db->group_by('pts.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_brands() {
        $this->db->select('pt.id as brand_id,pt.*,pts.*');
        $this->db->from('p_attributes pt');
        $this->db->from('p_sub_attributes pts', 'pt.id=pts.attribute_id');
        $this->db->where('pt.is_brand', 1);
        $this->db->group_by('pt.id');
        $query = $this->db->get();
        return $query->result_array();
    }

}
