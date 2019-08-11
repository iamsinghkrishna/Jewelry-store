<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Group_model extends MY_Model {

    public $_table = 'main_groups';
    public $primary_key = 'id';
    public $belongs_to = array('country', 'state');
    public $before_create = array('timestamps_bc');

function get_level($group_id) {
      
   $result= $this->db->get_where('main_groups', array('id' => $group_id))->row();
    return $result->level;
    //echo $this->db->last_query();exit;
    }
    
}