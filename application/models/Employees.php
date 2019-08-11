<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of hr
 *
 * @author admin
 */
class Employees extends MY_Model {

    //put your code here
    public $_table = 'main_employees';
    public $primary_key = 'user_id';
    public $belongs_to = array('main_users');

    //public $before_create = array('timestamps_bc');


    public function get_record_count() {

        $query = $this->db->query("SELECT count(id) as count FROM main_employees;");
        $count_record = $query->result();
//       var_dump($count_record[0]->count);die;
        if ($count_record[0]->count == '0')
            return 1; 
       else
            return 0;

//       
    }

    //to get reporting manager by department id
    public function get_repman_by_id($deptid) {
        return $this->db->get_where('main_employees_summary', array('firstname' => $deptid))->row();
    }

    //get all position by jobtitle id
    public function get_position_by_id($jobtitleid) {
//         echo 'in models'; var_dump($jobtitleid);exit;
        $this->db->select('positioname,id as position_id');
        $this->db->from('main_position');
        $this->db->where('jobtitle_id', $jobtitleid);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_position_by_id($jobtitleid) {
//         echo 'in models'; var_dump($jobtitleid);exit;
        $options = array('' => 'Select Position');
        $this->db->select('positioname,id');
        $this->db->from('main_position');
        $this->db->where('jobtitle_id', $jobtitleid);
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        $position = $query->result_array();
//        var_dump($position);die;
        foreach ($position as $category)
            $options[$category['id']] = $category['positioname'];

//        var_dump($options);die;
        return $options;
    }

    //get all position by jobtitle id
//    public function get_position_by_jt_id($jobtitleid) {
////         echo 'in models'; var_dump($jobtitleid);exit;
//        $this->db->select('positioname, id');
//        $this->db->from('main_position');
//        $this->db->where('jobtitle_id', $jobtitleid);
//        $query = $this->db->get();
//        $data = $query->result_array();
//        return $data;
//    }

    public function get_position_by_jt_id($jobtitleid) {
        $this->db->select('positioname, id');
        $this->db->from('main_position');
        $this->db->where('jobtitle_id', $jobtitleid);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_employee_id() {

        $this->db->select('employeeId');
        $this->db->from('main_users');
        $query = $this->db->get();
        return $query->last_row();
    }

    public function insert_or_update($primary_value = NULL, $data, $skip_validation = FALSE) {
        if ($primary_value == NULL) {
            return $this->insert($data);
        } else {
            return $this->update($primary_value, $data);
        }
    }

    public function get_prefix_name() {
//         echo 'in models'; var_dump($jobtitleid);exit;
        $this->db->select('prefix, id');
        $this->db->from('main_prefix');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_position_name() {
//         echo 'in models'; var_dump($jobtitleid);exit;
        $this->db->select('positioname,id as position_id');
        $this->db->from('main_position');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_employement_mode_name() {
//         echo 'in models'; var_dump($jobtitleid);exit;
        $this->db->select('mode,id');
        $this->db->from('main_employmentmode');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_emp_role() {
        $option = array(0 => array('id' => 0, 'rolename' => 'Select Role'));
        $this->db->select('rolename,id');
        $this->db->from('main_roles');
        $query = $this->db->get();
        $option = array_merge($option, $query->result_array());
        return $option;
    }

    public function get_department_name() {
        $option = array(0 => array('id' => 0, 'deptname' => 'Select Department'));
        $this->db->select('id, deptname');
        $this->db->from('main_departments');
        $query = $this->db->get();
        $option = array_merge($option, $query->result_array());
//        var_dump($option);die;
        return $option;
    }

    public function get_jobtitle() {
        $option = array(0 => array('id' => 0, 'jobtitlename' => 'Select JobTitle'));
        $this->db->select('jobtitlename,id');
        $this->db->from('main_jobtitle');
        $query = $this->db->get();
        $option = array_merge($option, $query->result_array());
        return $option;
    }

    public function get_positions() {
        $options = array();
        $this->db->select('positioname,mp.id');
         $this->db->from('main_position mp');
        $this->db->join('main_jobtitle jb', 'jb.id = mp.jobtitle_id');   
        $this->db->order_by('mp.id','ASC');
        $query = $this->db->get();
        $result = $query->result_array();

        foreach ($result as $category)
                    $options[$category['id']] = $category['positioname'];
        
      
        return $options;
    }
    
      public function get_managers() {
          
         $this->db->select('mep.userfullname ,mep.user_id as id');
        $this->db->from('main_employees_summary mep');
        $this->db->join('main_position ps', 'ps.id = mep.position_id');
        $this->db->where('mep.position_id', '5');  
         $query = $this->db->get();
        $result = $query->result_array();
        
        foreach ($result as $category)
                    $options[$category['id']] = $category['userfullname'];
        
      
        return $options;
    }

    public function get_employement_status() {
        $this->db->select('emp_status,id ');
        $this->db->from('main_employment_status');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_employement_name() {
//         echo 'in models'; var_dump($jobtitleid);exit;
        $this->db->select('emp_status,id as emp_status_id');
        $this->db->from('main_employment_status');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_holiday_group_name() {
        $this->db->select('groupname,id');
        $this->db->from('main_holidaygroups');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_reporting_manager_by__id($departmentid) {
//        var_dump($departmentid);die;
        $this->db->select('u.firstname ,mep.user_id as reporting_manager');
        $this->db->from('main_employees mep');
        $this->db->join('main_users u', 'u.id = mep.user_id');
        $this->db->where('mu.id', $param);
        if (!empty($departmentid) && $departmentid != 0)
            $this->db->where('mep.department_id', $departmentid);


        $query = $this->db->get();
        $repres = $query->result();

        if (empty($repres)) {
            $this->db->select('u.firstname ,mep.user_id as reporting_manager');
            $this->db->from('main_employees mep');
            $this->db->join('main_users u', 'u.id = mep.user_id');
            $query = $this->db->get();
            return $query->result();
        }
//        echo '<pre>',  print_r($query->result());die;
        return $query->result();
    }

    public function get_name_by_id($param) {
//        echo ''.$param;die;
        $name = $this->db->select('userfullname')->get_where('main_employees_summary', array('user_id' => $param))->row();
//        var_dump($this->db->last_query());die;
        if ($name !== false && !empty($name)) {
            return $name->userfullname;
        }
        return false;
    }
    public function get_super_approver($user_id) {
        $name = $this->db->select('userfullname')->get_where('main_users', array('id' => $user_id))->row();
        if ($name !== false && !empty($name)) {
            return $name->userfullname;
        }
        return false;
    }

    public function get_userfullname_by_user_id($param) {

//        var_dump($param);die;
        $this->db->select('mes.userfullname');
        $this->db->from('main_users mu');
//        $this->db->join('main_users mu', 'mu.id=mad.user_id');
        $this->db->join('main_employees_summary mes', 'mes.user_id=mu.id');
        $this->db->where('mu.id', $param);
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        $userfullnamedata = $query->result();
        if ($userfullnamedata !== false && !empty($userfullnamedata)) {
            return $userfullnamedata[0]->userfullname;
        }
        return false;
    }

    //to get userfullname 
    public function get_userfullname_by_doc($param) {

        $this->db->select('mes.userfullname');
        $this->db->from('main_associatedocuments mad');
//        $this->db->join('main_users mu', 'mu.id=mad.user_id');
        $this->db->join('main_employees_summary mes', 'mes.user_id=mad.user_id');
        $this->db->where('mad.id', $param);
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        $userfullnamedata = $query->result();
        if ($userfullnamedata !== false && !empty($userfullnamedata)) {
            return $userfullnamedata[0]->userfullname;
        }
        return false;
    }

    public function get_userfullname_by_leave_id($param) {

        $this->db->select('mes.userfullname');
        $this->db->from('main_employeeleaves mel');
//        $this->db->join('main_users mu', 'mu.id=mad.user_id');
        $this->db->join('main_employees_summary mes', 'mes.user_id=mel.user_id');
        $this->db->where('mel.id', $param);
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        $userfullnamedata = $query->result();
        if ($userfullnamedata !== false && !empty($userfullnamedata)) {
            return $userfullnamedata[0]->userfullname;
        }
        return false;
    }

    public function get_userfullname_by_holiday_id($param) {

        $this->db->select('mes.userfullname');
        $this->db->from('main_empholidays meh');
//        $this->db->join('main_users mu', 'mu.id=mad.user_id');
        $this->db->join('main_employees_summary mes', 'mes.user_id=meh.user_id');
        $this->db->where('meh.id', $param);
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        $userfullnamedata = $query->result();
        if ($userfullnamedata !== false && !empty($userfullnamedata)) {
            return $userfullnamedata[0]->userfullname;
        }
        return false;
    }

    public function get_userfullname_by_personal_id($param) {

        $this->db->select('mes.userfullname');
        $this->db->from('main_emppersonaldetails epd');
//        $this->db->join('main_users mu', 'mu.id=mad.user_id');
        $this->db->join('main_employees_summary mes', 'mes.user_id=epd.user_id');
        $this->db->where('epd.id', $param);
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        $userfullnamedata = $query->result();
        if ($userfullnamedata !== false && !empty($userfullnamedata)) {
            return $userfullnamedata[0]->userfullname;
        }
        return false;
    }

    public function get_userfullname_by_contact_id($param) {

        $this->db->select('mes.userfullname');
        $this->db->from('main_empcommunicationdetails ecd');
//        $this->db->join('main_users mu', 'mu.id=mad.user_id');
        $this->db->join('main_employees_summary mes', 'mes.user_id=ecd.user_id');
        $this->db->where('ecd.id', $param);
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        $userfullnamedata = $query->result();
        if ($userfullnamedata !== false && !empty($userfullnamedata)) {
            return $userfullnamedata[0]->userfullname;
        }
        return false;
    }

    public function get_userfullname_by_skill_id($param) {

        $this->db->select('mes.userfullname');
        $this->db->from('main_empskills ems');
//        $this->db->join('main_users mu', 'mu.id=mad.user_id');
        $this->db->join('main_employees_summary mes', 'mes.user_id=ems.user_id');
        $this->db->where('ems.id', $param);
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        $userfullnamedata = $query->result();
        if ($userfullnamedata !== false && !empty($userfullnamedata)) {
            return $userfullnamedata[0]->userfullname;
        }
        return false;
    }

    public function get_userfullname_by_jobhistory_id($param) {

        $this->db->select('mes.userfullname');
        $this->db->from('main_empjobhistory ejh');
//        $this->db->join('main_users mu', 'mu.id=mad.user_id');
        $this->db->join('main_employees_summary mes', 'mes.user_id=ejh.user_id');
        $this->db->where('ejh.id', $param);
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        $userfullnamedata = $query->result();
        if ($userfullnamedata !== false && !empty($userfullnamedata)) {
            return $userfullnamedata[0]->userfullname;
        }
        return false;
    }

    public function get_userfullname_by_certification_id($param) {

        $this->db->select('mes.userfullname');
        $this->db->from('main_empcertificationdetails mecd');
//        $this->db->join('main_users mu', 'mu.id=mad.user_id');
        $this->db->join('main_employees_summary mes', 'mes.user_id=mecd.user_id');
        $this->db->where('mecd.id', $param);
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        $userfullnamedata = $query->result();
        if ($userfullnamedata !== false && !empty($userfullnamedata)) {
            return $userfullnamedata[0]->userfullname;
        }
        return false;
    }

    public function get_userfullname_by_visa_id($param) {

        $this->db->select('mes.userfullname');
        $this->db->from('main_empvisadetails evd');
//        $this->db->join('main_users mu', 'mu.id=mad.user_id');
        $this->db->join('main_employees_summary mes', 'mes.user_id=evd.user_id');
        $this->db->where('evd.id', $param);
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        $userfullnamedata = $query->result();
        if ($userfullnamedata !== false && !empty($userfullnamedata)) {
            return $userfullnamedata[0]->userfullname;
        }
        return false;
    }

    public function get_userfullname_by_experience_id($param) {

        $this->db->select('mes.userfullname');
        $this->db->from('main_empexperiancedetails exd');
//        $this->db->join('main_users mu', 'mu.id=mad.user_id');
        $this->db->join('main_employees_summary mes', 'mes.user_id=exd.user_id');
        $this->db->where('exd.id', $param);
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        $userfullnamedata = $query->result();
        if ($userfullnamedata !== false && !empty($userfullnamedata)) {
            return $userfullnamedata[0]->userfullname;
        }
        return false;
    }

    public function get_userfullname_by_education_id($param) {

        $this->db->select('mes.userfullname');
        $this->db->from('main_empeducationdetails eed');
//        $this->db->join('main_users mu', 'mu.id=mad.user_id');
        $this->db->join('main_employees_summary mes', 'mes.user_id=eed.user_id');
        $this->db->where('eed.id', $param);
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        $userfullnamedata = $query->result();
        if ($userfullnamedata !== false && !empty($userfullnamedata)) {
            return $userfullnamedata[0]->userfullname;
        }
        return false;
    }

    public function get_priority() {
        $this->db->select('title,id');
        $this->db->from('main_priority');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_user_slug_by_id($assoId) {
//        echo ''.$param;die;
        
        return $this->db->select("salt")->get_where('main_users', array('id' => $assoId))->row()->salt;
        

//        $name = $this->db->select('salt')->get_where('main_users', array('id' => $assoId));
//
//        return $name;
    }

}
