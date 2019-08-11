<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mst_model extends MY_Model {

    public $_table = 'it_mst_model';
    public $primary_key = 'id';

//    protected $soft_delete = true;
//    protected $soft_delete_key = 'isactive';

    function get_level($group_id) {

        $result = $this->db->get_where('main_groups', array('id' => $group_id))->row();
        return $result->level;
        //echo $this->db->last_query();exit;
    }

    public function get_make_detail() {
        $this->db->select('imm.*,imk.name as make_name, imy.name as year_name');
        $this->db->from('it_mst_model imm');
        $this->db->join('it_mst_make imk', 'imm.make_id=imk.id', 'left');
        $this->db->join('it_mst_year imy', 'imm.year_id=imy.id', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_model_by_id($yearId, $makeId) {
        $this->db->select('imm.name,imm.id');
        $this->db->from('it_mst_model imm');
        $this->db->where('make_id', $makeId);
        $this->db->where('year_id', $yearId);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete_model($model_id) {
        $this->db->where('id', $model_id);
        $this->db->delete('it_mst_model');
        return TRUE;
    }

    public function update_model($model_id, $data) {
        $this->db->where('id', $model_id);
        $this->db->update('it_mst_model', $data);
        return TRUE;
    }

}

/* End of file Mst_Model.php */
/* Location: ./master/Mst_Model.php */