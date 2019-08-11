<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog_category extends MY_Model {

    public $_table = 'it_blog_category';
    public $primary_key = 'id';
    protected $soft_delete = true;
    protected $soft_delete_key = 'isactive';

    function get_by_id($blogId) {
        $this->db->select('ib.*');
        $this->db->from('it_blog_category ib');
        $this->db->where('ib.id', $blogId);
        $query = $this->db->get();
        return $query->result_array();
    }

}
