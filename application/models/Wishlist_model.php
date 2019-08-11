<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wishlist_model extends MY_Model {

    public $_table = 'product_wish_list';
    public $primary_key = 'id';
//    protected $soft_delete = true;
//    protected $soft_delete_key = 'isactive';

      public function check_review_product($id,$user_id) {
        $arr = array('product_id' => $id, 'user_id' => $user_id);
        //echo '<pre>';print_R($arr);die;
        $q = $this->db->where($arr)->get('product_wish_list');
        //echo $this->db->last_query();die;
        if ($q->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
      }
        public function get_list($user_id) {
//            echo $user_id;
//        $arr = array();
        $q = $this->db->where('user_id', $user_id)->get('product_wish_list');
       return $q->result_array();
      }
      
      public function delete_re($id) {
          return $this->db->where('id',$id)->delete('product_wish_list');
      }
}
