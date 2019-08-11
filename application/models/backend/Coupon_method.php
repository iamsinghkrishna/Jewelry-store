<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Coupon_method extends MY_Model {

    public $_table = 'discount_methods';
    public $primary_key = 'disc_method_id';
   // protected $soft_delete = true;
   // protected $soft_delete_key = 'isactive';

    function get_all_method_by_type_id($type_id) {

        $result = $this->db->where('disc_method_type_fk',$type_id)->get('discount_methods');
        return $result->result_array();
        //echo $this->db->last_query();exit;
    }

}
