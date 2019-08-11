<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Country extends MY_Model {

    public $_table = 'it_country';
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
            $obj = $this->db->select('countryname')->get_where('it_country', array('id' => $id))->row();
            if (isset($obj)) {
                return $obj->countryname;
            }
        }

        return null;
    }

//    public $validate = array(
//        array('field' => 'alpha2',
//            'label' => 'Alpha2',
//            'rules' => 'required|max_length[2]'),
//        array('field' => 'alpha3',
//            'label' => 'Alpha3',
//            'rules' => 'required|max_length[3]'),
//        array('field' => 'name',
//            'label' => 'Name',
//            'rules' => 'required'),
//        array('field' => 'numeric_code',
//            'label' => 'Numeric Code',
//            'rules' => 'required|max_length[3]'),
//        array('field' => 'phone',
//            'label' => 'Phone'),
//        array('field' => 'region_label',
//            'label' => 'Regions Label'),
//        array('field' => 'flag',
//            'label' => 'Flag')
//            /* array('field' => 'lang',
//              'label' => 'Language'), */
//    );
    
      function get_country_list(){
        
          $this->db->select('id,name');
        $this->db->from('country');       
        $query = $this->db->get();
        $obj=$query->result_array();

        if (isset($obj)) {
       
                return $obj;
            }
        
    }
    
    function get_country_name(){
        
        $this->db->select('id,countryname');
        $this->db->from('it_country');       
        $query = $this->db->get();
        $obj=$query->result_array();

        if (isset($obj)) {
       
                return $obj;
            }
        
    }   


}

/* End of file country_model.php */
/* Location: ./application/modules/account/models/country_model.php */