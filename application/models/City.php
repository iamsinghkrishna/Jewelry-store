<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class City extends MY_Model {

    public $_table = 'it_city';
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
            $obj = $this->db->select('cityname')->get_where('it_city', array('id' => $id))->row();
            if (isset($obj)) {
                return $obj->cityname;
            }
        }

        return null;
    }

    function get_city_name() {

        $this->db->select('id,cityname');
        $this->db->from('it_city');
        $query = $this->db->get();
        $obj = $query->result_array();

        if (isset($obj)) {

            return $obj;
        }
    }

    function get_CityListById($id) {

        $this->db->select('id,cityname');
        $this->db->from('it_city');
        $this->db->where('state_id', $id);
        $query = $this->db->get();
        $obj = $query->result_array();

        if (isset($obj)) {

            return $obj;
        }
    }

}

/* End of file country_model.php */
/* Location: ./models/city.php */