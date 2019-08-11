<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Review_model extends MY_Model {

    public $_table = 'it_product_review';
    public $primary_key = 'id';

//    protected $soft_delete = true;
//    protected $soft_delete_key = 'isactive';

    public function check_review_product($id, $user_id) {
        $arr = array('product_id' => $id, 'user_id'=> $user_id);
//        print_r($arr);
        $q = $this->db->where($arr)->get('it_product_review');
        
//        echo $this->db->last_query();die();;
        if ($q->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_review($user_id, $product_id) {
       $arr = array('product_id' => $product_id, 'user_id'=> $user_id);
        $this->db->join('users u', 'u.id=ip.user_id');
        $q = $this->db->where($arr)->get('it_product_review ip');
        $revData = $q->result_array();
        return $revData;
    }

    public function get_all_reiview_products($product_id) {
        $arr = array('product_id' => $product_id);
        $this->db->join('users u', 'u.id=ip.user_id');
        $q = $this->db->where($arr)->order_by('ip.id', 'DESC')->get('it_product_review ip');
        $revData = $q->result_array();
        return $revData;
    }

    public function get_review_edit($user_id, $product_id) {
        $arr = array('product_id' => $product_id, 'user_id'=> $user_id);
//        print_r($arr);die();
        $q = $this->db->where($arr)->get('it_product_review ip');
        $revData = $q->result_array();
        return $revData;
    }

}
