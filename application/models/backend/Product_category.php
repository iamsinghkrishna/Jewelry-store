<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_category extends MY_Model {

    public $_table = 'it_product_category';
    public $primary_key = 'id';
    protected $soft_delete = true;
    protected $soft_delete_key = 'isactive';

    function get_level($group_id) {

        $result = $this->db->get_where('main_groups', array('id' => $group_id))->row();
        return $result->level;
        //echo $this->db->last_query();exit;
    }

    function get_all_details() {
        $this->db->select('ipc.*,pa.attrubute_value');
        $this->db->from('it_product_category ipc');
        $this->db->join('it_product_sub_category ipcs', 'ipc.id=ipcs.p_category_id', 'left');
        $this->db->join('p_attributes pa', 'pa.id=ipcs.p_sub_category_id', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    function delete_cat($pId) {
        $this->db->where('id', $pId);
        $this->db->delete('it_product_category');
    }

    function get_category_name_by_id($categoryId) {
        $this->db->select('ipc.name,ipc.description');
        $this->db->from('it_product_category ipc');
        $this->db->where('id', $categoryId);
        $query = $this->db->get();
        $name = $query->result_array();
//        echo '<pre>';print_r($name[0]);die;
        if (isset($name[0]))
            return $name[0];
        else
            return NULL;
    }
   
function service_category() {
     //   $this->db->where('id', $pId);
        $q=$this->db->limit(3)->get('it_product_category');
        return $q->result_array();
    }
}
