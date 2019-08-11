<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mst_make extends MY_Model {

    public $_table = 'it_mst_make';
    public $primary_key = 'id';
//    protected $soft_delete = true;
//    protected $soft_delete_key = 'isactive';

    function get_level($group_id) {

        $result = $this->db->get_where('main_groups', array('id' => $group_id))->row();
        return $result->level;
        //echo $this->db->last_query();exit;
    }

}

/* End of file Mst_Make.php */
/* Location: ./master/Mst_Make.php */