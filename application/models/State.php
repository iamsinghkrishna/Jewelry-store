<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class State extends MY_Model {

    public $_table = 'it_state';
    public $primary_key = 'id';

//    protected $soft_delete = true;
//    protected $soft_delete_key = 'isactive';

    protected function data_process($row) {
        $row[$this->callback_parameters[0]] = $this->_process($row[$this->callback_parameters[0]]);

        return $row;
    }

    /**
     * Get name by id
     *
     * @access public
     * @param string $id
     * @return string name
     */
    function get_name_by_id($id) {
        if ($id != null) {
            $obj = $this->db->select('statename')->get_where('it_state', array('id' => $id))->row();
            if (isset($obj)) {
                return $obj->statename;
            }
        }

        return null;
    }

    function get_country_list() {

        $this->db->select('id,name');
        $this->db->from('country');
        $query = $this->db->get();
        $obj = $query->result_array();

        if (isset($obj)) {

            return $obj;
        }
    }

    function get_state_name() {

        $this->db->select('id,statename');
        $this->db->from('it_state');
        $query = $this->db->get();
        $obj = $query->result_array();

        if (isset($obj)) {

            return $obj;
        }
    }

    function get_StateListById($id) {

        $this->db->select('id,statename');
        $this->db->from('it_state');
        $this->db->where('country_id', $id);
        $query = $this->db->get();
        $obj = $query->result_array();

        if (isset($obj)) {

            return $obj;
        }
    }

}

/* End of file country_model.php */
/* Location: ./models/state.php */