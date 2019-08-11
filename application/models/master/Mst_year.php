<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mst_year extends MY_Model {

    public $_table = 'it_mst_year';
    public $primary_key = 'id';

//    protected $soft_delete = true;
//    protected $soft_delete_key = 'isactive';

    function get_level($group_id) {

        $result = $this->db->get_where('main_groups', array('id' => $group_id))->row();
        return $result->level;
        //echo $this->db->last_query();exit;
    }

    function get_all_year_by_make_id($make_id) {
        $this->db->select('*');
        $this->db->from('it_mst_year imy');
        $this->db->where('make_id', $make_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function delete_make($make_id) {
        $this->db->where('make_id', $make_id);
        $this->db->delete('it_mst_year');
    }
    function delete_year($make_id,$year) {
        $this->db->where('make_id', $make_id);
        $this->db->where('name', $year);
        $this->db->delete('it_mst_year');
    }

}

/* End of file Mst_Year.php */
/* Location: ./master/Mst_Year.php */