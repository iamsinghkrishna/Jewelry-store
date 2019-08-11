<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orders_summary extends MY_Model {

    public $_table = 'order_summary';
    public $primary_key = 'ord_order_number';

//    protected $soft_delete = true;
//    protected $soft_delete_key = 'isactive';

    function get_by_id($user_id) {

        $this->db->select('p.id,p.category_id,,ipm.url,p.product_name,os.*,od.*');
        $this->db->from('order_details od');
        $this->db->join('order_summary os', 'os.ord_order_number = od.ord_det_order_number_fk', 'LEFT');
        $this->db->join('it_products p', 'p.id = od.ord_det_item_fk', 'LEFT');
        $this->db->join('it_products_image ipm', 'ipm.product_id = p.id', 'LEFT');
        $this->db->where('os.ord_user_fk', $user_id);
        $this->db->where('os.ord_status !=', 1);
        $this->db->order_by('ord_order_number','DESC');
        $this->db->group_by('ord_order_number');
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    function get_all_orders() {
        $this->db->select('p.*,os.*,od.*,ipm.url');
        $this->db->from('order_details od');
        $this->db->join('order_summary os', 'os.ord_order_number = od.ord_det_order_number_fk', 'LEFT');
        $this->db->join('it_products p', 'p.id = od.ord_det_item_fk', 'LEFT');
        $this->db->join('it_products_image ipm', 'ipm.product_id = p.id', 'LEFT');
         $this->db->order_by('od.ord_det_id DESC');
        $this->db->group_by('ord_order_number');
        $query = $this->db->get();
       // echo $this->db->last_query();die;
        return $query->result_array();
    }

}

/* End of file Orders_summary.php */
/* Location: ./models/backend/Orders_summary.php */