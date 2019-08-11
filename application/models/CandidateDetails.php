<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CandidateDetails extends MY_Model {

    public $_table = 'main_req_candidate_details';
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
            $obj = $this->db->select('cityname')->get_where('main_city', array('id' => $id))->row();
            if (isset($obj)) {
                return $obj->cityname;
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

    function get_requisition_code_byId($id) {
        if ($id != null) {
            $obj = $this->db->select('req_code')->get_where('main_req_requisition', array('id' => $id))->row();
            if (isset($obj)) {
                return $obj->req_code;
            }
        }
        return null;
    }

    function get_candidate_status() {
        $this->db->select('id,cand_status');
        $this->db->from('main_candidate_status');
        $query = $this->db->get();
        $obj = $query->result_array();
        if (isset($obj)) {
            return $obj;
        }
    }

    function get_last_id() {
        $this->db->select('req_code');
        $this->db->from('main_req_requisition');
        $query = $this->db->get();
        $curId = $query->last_row();
        return $curId;
    }

    function get_all_openings() {
        $this->db->select('rq.id,jt.jobtitlename,rq.req_no_positions,rq.filled_positions,rq.onboard_date,rq.req_exp_years_from,rq.req_exp_years_to,rq.opening_status');
        $this->db->from('main_req_requisition rq');
        $this->db->join('main_jobtitle jt', 'rq.jobtitle=jt.id');
        $query = $this->db->get();
        //echo $this->check_graffiti_record($id);
        //echo $this->db->last_query();die;
        return $query->result_array();
    }

    function update_position($id, $round_id) {
        $this->db->where('id', $id);
        $updatePosition = array(
            'position' => $round_id
        );
        $this->db->update('main_req_candidate_details', $updatePosition);
        // echo $this->db->last_query();die;
    }

    function update_colorcode($id, $color_id) {
        $this->db->where('id', $id);
        $updateColorcode = array(
            'color_code' => $color_id
        );
        $this->db->update('main_req_candidate_details', $updateColorcode);
    }

    function get_candidateOfferDetails($id) {

        $this->db->select('rq.*,emp.userfullname,rq.id as user_id,cd.title,pos.positioname,dept.deptname,rd.interviewer_id');
        //$this->db->select('rq.*,interview_mode,rd.interview_time,rd.interview_date');
        $this->db->from('main_req_candidate_details rq');
        $this->db->join('main_req_interviewrounddetails rd', 'rd.candidate_id=rq.id', 'left');
        $this->db->join('main_color_code cd', 'cd.id=rq.color_code', 'left');
        $this->db->join('main_req_skillset rs', 'rs.candidate_id=rq.id', 'left');
        $this->db->join('main_skills s', 's.id=rs.skillset_id', 'left');
        $this->db->join('main_req_requisition req', 'req.id=rq.requisition_id', 'left');
        $this->db->join('main_position pos', 'pos.id=req.position_id', 'left');
        $this->db->join('main_departments dept', 'dept.id=req.department_id', 'left');
        $this->db->join('main_employees_summary emp', 'emp.user_id=rd.interviewer_id', 'left');
        $this->db->where('rq.id', $id);
        $this->db->where('rd.interview_round_completed', 5);

        //$this->db->group_by('rq.id');
        // $this->db->where('position', '0');
        $query = $this->db->get();

        // echo $this->db->last_query();die;
        $obj = $query->result_array();
        if (isset($obj)) {
            return $obj;
        }
    }

    function get_candidatedetailsByid($id) {

        $this->db->select('rq.*,rq.id as user_id,cd.title');
        //$this->db->select('rq.*,interview_mode,rd.interview_time,rd.interview_date');
        $this->db->from('main_req_candidate_details rq');
        // $this->db->join('main_req_interviewrounddetails rd', 'rd.candidate_id=rq.id','left');
        $this->db->join('main_color_code cd', 'cd.id=rq.color_code', 'left');
        $this->db->join('main_req_skillset rs', 'rs.candidate_id=rq.id', 'left');
        $this->db->join('main_skills s', 's.id=rs.skillset_id', 'left');
        $this->db->where('requisition_id', $id);
        $this->db->group_by('rq.id');
        // $this->db->where('position', '0');
        $query = $this->db->get();
        $obj = $query->result_array();

//        echo $this->db->last_query();die;
//        var_dump(count($obj));die;
        $dataRes = array();
        $i = 0;
        foreach ($obj as $result) {
            $skill_details = $this->recruitmentskills->get_by_id($result['id']);
            if ($skill_details != NULL) {
//                    foreach ($skill_details as $skillsetData) {     
//                        var_dump($skillsetData);die
                $obj[$i]['skill_detail'] = $skill_details;
//                    }
            }
            $i++;
        }
//            var_dump($obj);die;
        if (isset($obj)) {
            return $obj;
        }
    }

    function check_client_interview($id) {
        $this->db->select('client_interview_status');
        $this->db->from('main_req_requisition');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_reschedule_data($user_id, $candidate_id, $interview_round_number) {
        $this->db->select('resch.interview_round_number as res_interview_round_number,rd.interview_round_completed as res_interview_round_completed, resch.interview_date as res_interview_date, resch.interview_time as res_interview_time,ity.name as res_interview_mode,emp.userfullname as res_interviewer_name,resch.reschedule_comment,resch.schedule_comment,resch.createddate as schedulecreateddate');
        $this->db->from('main_req_reschedule resch');
        $this->db->join('main_req_interviewrounddetails rd', 'rd.id=resch.reschedule_id', 'left');
        $this->db->join('main_req_candidate_details rq', 'rq.id=rd.candidate_id', 'left');
        $this->db->join('main_employees_summary emp', 'emp.user_id=resch.interviewer_id', 'left');
        $this->db->join('main_interview_type ity', 'ity.id=resch.interview_mode', 'left');
        if ($user_id != null)
            $this->db->where('resch.interviewer_id', $user_id);
        // if(isset($candidate_id))
        $this->db->where('resch.candidate_id', $candidate_id);
        $this->db->where('resch.interview_round_number', $interview_round_number);
        $this->db->order_by('resch.interview_date', 'ASC');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $reschedule_obj = $query->result_array();
        return $reschedule_obj;
        //    var_dump($reschedule_obj); 
    }

    function get_schedule_interviews($user_id, $params = array()) {
        $this->db->select('rq.*,dept.deptname,jt.jobtitlename,ity.name as interview_mode,rd.id as id,cd.title,rd.round_status,rd.candidate_id,rd.interview_time,rd.interview_date,rd.schedule_comment,rd.interview_round_number,rd.interview_round_completed,rd.interviewer_comments,rd.interviewer_rating,rd.reschedule_id,rd.feedback_status');
        //$this->db->select('rq.*,interview_mode,rd.interview_time,rd.interview_date');
        $this->db->from('main_req_candidate_details rq');
        $this->db->join('main_req_interviewrounddetails rd', 'rd.candidate_id=rq.id', 'left');
        //$this->db->join('main_interview_type ty', 'ty.id=rd.interview_mode','left');
        $this->db->join('main_color_code cd', 'cd.id=rq.color_code', 'left');
        $this->db->join('main_interview_type ity', 'ity.id=rd.interview_mode', 'left');
        $this->db->join('main_req_requisition req', 'req.id=rq.requisition_id', 'left');
        $this->db->join('main_jobtitle jt', 'req.id=jt.id', 'left');
        $this->db->join('main_departments dept', 'dept.id=req.department_id', 'LEFT');
        $this->db->where('rd.interviewer_id', $user_id);
        $this->db->where('rq.isactive', 0);
        //$this->db->order_b('rd.interviewer_id', $user_id);
        //filter data by searched keywords
        if (!empty($params['search']['keywords'])) {
            $this->db->like('rq.candidate_name', $params['search']['keywords']);
        }
        //var_dump( $params['search']['sortBy']);die;
//sort data by ascending or desceding order
        if (!empty($params['search']['sortBy']) && $params['search']['sortBy'] != '0') {
            $this->db->order_by('rq.candidate_name', $params['search']['sortBy']);
        } else {
            $this->db->order_by('rd.createddate', 'DESC');
        }
//set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();
        $obj = $query->result_array();

        foreach ($obj as $k => $res) {
            if ($res['reschedule_id'] == '1') {
                $obj[$k]['reschedule_details'] = $this->get_reschedule_data($user_id, $res['candidate_id'], $res['interview_round_number']);
            }
        }

        foreach ($obj as $k => $res) {
            $obj[$k]['skill_set'] = $this->recruitmentskills->get_by_id($res['candidate_id']);
        }

        foreach ($obj as $k => $res) {
            $obj[$k]['skill_rating'] = $this->recruitmentfeedback->get_by_id($res['candidate_id'], $res['interview_round_number']);
        }
//var_dump($obj);
        if (isset($obj)) {
            return $obj;
        }
    }

    /* Function : 
      Usage : getiing second timeline data
     */

    function get_round_status($screening_id, $candidate_id) {
        $this->db->select('MAX(rd.interview_round_number)as max_round_reached');
        $this->db->from('main_req_interviewrounddetails rd');
        $this->db->where('req_id', $screening_id);
        $this->db->where('candidate_id', $candidate_id);
        // $this->db->group_by('candidate_id', $candidate_id);
        $query = $this->db->get();
        //  echo $this->db->last_query();die;

        $obj = $query->result_array();
        if (isset($obj)) {
            return $obj;
        }
    }

    function get_firstround_status($id, $position) {
        $this->db->select('MAX(rd.interview_round_number)as max_round_reached,rd.candidate_id');
        $this->db->from('main_req_interviewrounddetails rd');
        $this->db->join('main_req_candidate_details rq', 'rq.id=rd.candidate_id', 'left');
        $this->db->where('position', $position);
        $this->db->where('requisition_id', $id);
        $this->db->where('round_status', 'schedule');
        $this->db->group_by('rd.candidate_id');
        $query = $this->db->get();
        //echo $this->db->last_query();         die;
        $obj = $query->result_array();
        if (isset($obj)) {
            return $obj;
        }
    }

    function get_feedback_status($id, $position) {
        $this->db->select('MAX(rd.interview_round_completed)as max_round_reached,rd.candidate_id');
        $this->db->from('main_req_interviewrounddetails rd');
        $this->db->join('main_req_candidate_details rq', 'rq.id=rd.candidate_id', 'left');
        $this->db->where('position', $position);
        $this->db->where('requisition_id', $id);
        $this->db->group_by('rd.candidate_id');
        $query = $this->db->get();
        //echo $this->db->last_query();         die;
        $obj = $query->result_array();
        if (isset($obj)) {
            return $obj;
        }
    }

    function get_feedback_Wordstatus($id, $position) {
        $this->db->select('rd.round_status,rd.candidate_id');
        $this->db->from('main_req_interviewrounddetails rd');
        $this->db->join('main_req_candidate_details rq', 'rq.id=rd.candidate_id', 'left');
        $this->db->where('position', $position);
        $this->db->where('interview_round_completed', $position);
        $this->db->where('requisition_id', $id);
        //$this->db->group_by('rd.candidate_id');
        $query = $this->db->get();
        //echo $this->db->last_query();         die;
        $obj = $query->result_array();
        // var_dump( $obj);
        if (isset($obj)) {
            return $obj;
        }
    }

    function get_skip_status($id, $position) {
        $this->db->select('MAX(rd.interview_round_number)as max_round_skip,rd.candidate_id');
        $this->db->from('main_req_interviewrounddetails rd');
        $this->db->join('main_req_candidate_details rq', 'rq.id=rd.candidate_id', 'left');
        $this->db->where('position', $position);
        $this->db->where('requisition_id', $id);
        $this->db->where('rd.schedule_id', '0');
        $this->db->where('rd.interview_round_completed', '0');
        $this->db->group_by('rd.candidate_id');
        $query = $this->db->get();
        //   echo $this->db->last_query();
//        echo '<hr><br>';
        $obj = $query->result_array();
        if (isset($obj)) {
            return $obj;
        }
    }

//       function reschedule_details($id, $position) {
//        $this->db->select('MAX(rd.interview_round_number)as max_round_skip,rd.candidate_id');
//        $this->db->from('main_req_interviewrounddetails rd');
//        $this->db->join('main_req_candidate_details rq', 'rq.id=rd.candidate_id', 'left');
//        $this->db->where('position', $position);
//        $this->db->where('requisition_id', $id);
//        $this->db->where('rd.schedule_id', '0');
//        $this->db->where('rd.interview_round_completed', '0');
//        $this->db->group_by('rd.candidate_id');
//        $query = $this->db->get();
//     //   echo $this->db->last_query();
////        echo '<hr><br>';
//        $obj = $query->result_array();
//        if (isset($obj)) {
//            return $obj;
//        }
//    }

    function get_skipDetails_status($id, $position) {
        $this->db->select('MAX(skp.interview_round_number)as max_round_skip_details,skp.candidate_id');
        $this->db->from('main_req_skipround skp');
        $this->db->join('main_req_candidate_details rq', 'rq.id=skp.candidate_id', 'left');
        $this->db->where('rq.position', $position);
        $this->db->where('skp.req_id', $id);
        //$this->db->where('interview_round_completed', '0');
        $this->db->group_by('skp.candidate_id');
        $query = $this->db->get();
        //  echo $this->db->last_query();
        $obj = $query->result_array();
        if (isset($obj)) {
            return $obj;
        }
    }

    function get_rescheduleStatusDetails($id, $position) {
        $this->db->select('MAX(rech.interview_round_number)as max_rechedule,rech.candidate_id');
        $this->db->from('main_req_reschedule rech');
        $this->db->join('main_req_candidate_details rq', 'rq.id=rech.candidate_id', 'left');
        $this->db->where('rech.position', $position);
        $this->db->where('rech.req_id', $id);
        //$this->db->where('interview_round_completed', '0');
        $this->db->group_by('rech.candidate_id');
        $query = $this->db->get();
        // echo $this->db->last_query();
        $obj = $query->result_array();
        if (isset($obj)) {
            return $obj;
        }
    }

    function get_holdDetails($id, $candidate_id) {
        $this->db->select('*');
        $this->db->from('main_req_holdoffer hold');
        $this->db->join('main_req_candidate_details rq', 'rq.id=hold.candidate_id', 'left');
        $this->db->where('hold.req_id', $id);
        $this->db->where('hold.candidate_id', $candidate_id);
        //$this->db->where('interview_round_completed', '0');
        // $this->db->group_by('hold.candidate_id');
        $query = $this->db->get();
        //   echo $this->db->last_query();die;
        $obj = $query->result_array();
        if (isset($obj)) {
            return $obj;
        }
    }

    function get_feedback_detalis($id, $position, $rounds, $candidate_id = null) {

        $this->db->select('rq.*,rd.round_status,rd.round_date,rd.interview_round_number,rd.interview_date,rd.interview_time,rd.createdby as scheduleby,rd.schedule_comment,rd.schedule_id,rd.interview_round_completed,rd.interviewer_rating,rd.interviewer_comments,ity.name as interview_mode,rd.interview_date,emp.userfullname as interviewer_name,rd.candidate_id as candidate_id,rd.interviewer_createddate');
        $this->db->from('main_req_candidate_details rq');
        $this->db->join('main_req_interviewrounddetails rd', 'rd.candidate_id=rq.id', 'left');
        $this->db->join('main_employees_summary emp', 'emp.user_id=rd.interviewer_id', 'left');
        $this->db->join('main_interview_type ity', 'ity.id=rd.interview_mode', 'left');
        //  $this->db->join('main_req_skipround skp', 'skp.interview_round_number=rd.skip_id', 'left');
        if (isset($candidate_id))
            $this->db->where('rd.candidate_id', $candidate_id);
        $this->db->where('requisition_id', $id);
        $this->db->where('position', $position);
        //$this->db->where('skip_id', '1');
        $this->db->where_in('rd.interview_round_number', $rounds);
        $this->db->order_by('rd.interview_round_number', 'DESC');
        $query = $this->db->get();
        //  echo $this->db->last_query();
        $obj = $query->result_array();
        foreach ($obj as $k => $data) {
            $obj[$k]['skill_rating'] = $this->recruitmentfeedback->get_by_id($data['candidate_id'], $data['interview_round_number']);
        }
        //var_dump($obj);
        if (isset($obj)) {
            return $obj;
        }
    }

    function get_rating_detalis($id, $position, $rounds, $candidate_id = null) {

        $this->db->select('rq.*,rd.round_status,rd.interview_round_number,rd.interview_date,rd.interview_time,rd.createdby as scheduleby,rd.schedule_comment,rd.schedule_id,rd.interview_round_completed,rd.interviewer_rating,rd.interviewer_comments,ity.name as interview_mode,rd.interview_date,emp.userfullname as interviewer_name,rd.candidate_id as candidate_id');
        $this->db->from('main_req_candidate_details rq');
        $this->db->join('main_req_interviewrounddetails rd', 'rd.candidate_id=rq.id', 'left');
        $this->db->join('main_employees_summary emp', 'emp.user_id=rd.interviewer_id', 'left');
        $this->db->join('main_interview_type ity', 'ity.id=rd.interview_mode', 'left');
        //  $this->db->join('main_req_skipround skp', 'skp.interview_round_number=rd.skip_id', 'left');
        if (isset($candidate_id))
            $this->db->where('rd.candidate_id', $candidate_id);
        $this->db->where('requisition_id', $id);
        $this->db->where('position', $position);
        //$this->db->where('skip_id', '1');
        $this->db->where_in('rd.interview_round_number', $rounds);
        $this->db->order_by('rd.interview_round_number', 'DESC');
        $query = $this->db->get();
        //  echo $this->db->last_query();
        $obj = $query->result_array();
        if (isset($obj)) {
            return $obj;
        }
    }

    function get_rescheduleData($rounds, $candidate_id, $id, $position) {
        $this->db->select('resch.candidate_id,resch.interview_round_number as res_interview_round_number, resch.interview_date as res_interview_date, resch.interview_time as res_interview_time,ity.name as res_interview_mode,emp.userfullname as res_interviewer_name,resch.reschedule_comment');
        $this->db->from('main_req_reschedule resch');
        $this->db->join('main_req_interviewrounddetails rd', 'rd.id=resch.reschedule_id', 'left');
        $this->db->join('main_req_candidate_details rq', 'rq.id=rd.candidate_id', 'left');
        $this->db->join('main_employees_summary emp', 'emp.user_id=resch.interviewer_id', 'left');
        $this->db->join('main_interview_type ity', 'ity.id=resch.interview_mode', 'left');
        if (isset($candidate_id))
            $this->db->where('rd.candidate_id', $candidate_id);
        $this->db->where('rq.requisition_id', $id);
        $this->db->where('rq.position', $position);
        $this->db->where_in('resch.interview_round_number', $rounds);
        $this->db->order_by('resch.interview_date', 'ASC');
        $query = $this->db->get();
        //  echo $this->db->last_query();
        $reschedule_obj = $query->result_array();
        // var_dump($reschedule_obj);
        return $reschedule_obj;
    }

    /* to get schedule status */

    function get_schedule_status($id, $position, $rounds, $candidate_id = null) {
//        var_dump($rounds);
        $this->db->select('rd.*,ity.name as interview_mode');
        $this->db->from('main_req_candidate_details rq');
        $this->db->join('main_req_interviewrounddetails rd', 'rd.candidate_id=rq.id', 'left');
        $this->db->join('main_employees_summary emp', 'emp.user_id=rd.interviewer_id', 'left');
        $this->db->join('main_interview_type ity', 'ity.id=rd.interview_mode', 'left');
        if (isset($candidate_id))
            $this->db->where('rd.candidate_id', $candidate_id);
        $this->db->where('requisition_id', $id);
        $this->db->where('position', $position);
        $this->db->order_by('rd.id', 'DESC');

        $query = $this->db->get();
        // echo $this->db->last_query();
        $obj = $query->result_array();

        foreach ($obj as $k => $res) {
            if (($res['reschedule_id']) == '1') {

                $round_number = $res['interview_round_number'];
                $obj[$k]['reschedule_details'] = $this->get_rescheduleData($round_number, $candidate_id, $id, $position);
                //$obj[$k]['reschedule_details'] = $this->get_rescheduleData($rounds,$candidate_id,$id,$position);
            }
        }

//            var_dump($obj);die;
        if (isset($obj)) {
            return $obj;
        }
    }
    function get_round_completion($id, $position, $rounds, $candidate_id) {
       //var_dump($id);
        $this->db->select('interview_round_number,interview_round_completed');
        $this->db->from('main_req_interviewrounddetails rd');
        $this->db->join('main_req_candidate_details rq', 'rq.requisition_id=rd.req_id', 'left');
        $this->db->where('rd.candidate_id', $candidate_id);
        $this->db->where('rd.req_id', $id);
        $this->db->where('rq.position', $position);
        $query = $this->db->get();
       //  echo $this->db->last_query();
        $obj = $query->result_array();
 $x=0;
        foreach ($obj as $k => $data) {
            if($data['interview_round_number'] != $data['interview_round_completed']){
                $x=  'false';
                }
                else{
                    $x= 'true';
                }
                
        }
         return ($x);
       

    }

    /* to get reschedule data */

    function get_reschedule_status($reschedule_id) {

        $this->db->select('mrr.*');
        $this->db->from('main_req_reschedule mrr');
        $this->db->where('mrr.id', $reschedule_id);
        $query = $this->db->get();
        // echo $this->db->last_query();
        $obj = $query->result_array();
//        var_dump($obj);die;
        if (isset($obj[0])) {
            return $obj[0];
        }
    }

    function get_skip_comments_detalis($id, $position, $rounds, $skip_id, $candidate_id = null) {
        $this->db->select('skp.interview_round_number,skp.skip_comment,skp.candidate_id as candidate_id');
        $this->db->from('main_req_skipround skp');
        $this->db->join('main_req_candidate_details cand', 'cand.id=skp.candidate_id', 'left');

        if (isset($candidate_id))
            $this->db->where('skp.candidate_id', $candidate_id);
        $this->db->where('skp.req_id', $id);
        $this->db->where('cand.position', $position);
        $this->db->where_in('skp.interview_round_number', $skip_id);

        $query = $this->db->get();
        // echo $this->db->last_query();
        $obj = $query->result_array();
        if (isset($obj)) {
            return $obj;
        }
    }

    function get_round_detalis($screening_id, $round, $candidate_id = null) {
        $this->db->select('rd.round_date,hold.createddate as holddate,hold.hold_offer_comment,rd.createddate as schedulecreateddate,rd.interview_time as scheduletime, rd.interview_date  as scheduledate,skp.createddate as skipdate,rej.createddate as rejcandate,rd.interviewer_createddate as interviewerdate,rd.round_status,rej.reject_comment,rd.interview_round_number,rejOf.createddate as offerrejectdate,rejOf.reject_offer_comment,rd.schedule_id,rd.schedule_comment,rd.interview_round_completed,rd.interviewer_rating,rd.interviewer_comments,skp.skip_comment,ity.name as interview_mode,rd.interview_date,emp.userfullname as interviewer_name,rd.candidate_id as candidate_id,rd.reschedule_id');
        $this->db->from('main_req_candidate_details rq');
        $this->db->join('main_req_interviewrounddetails rd', 'rd.candidate_id=rq.id', 'left');
        $this->db->join('main_employees_summary emp', 'emp.user_id=rd.interviewer_id', 'left');
        $this->db->join('main_interview_type ity', 'ity.id=rd.interview_mode', 'left');
        $this->db->join('main_req_skipround skp', 'skp.skip_id=rd.id', 'left');
        $this->db->join('main_req_rejectcandidate rej', 'rej.reject_id=rd.id', 'left');
        $this->db->join('main_req_rejectoffer rejOf', 'rejOf.reject_offer_id=rd.id', 'left');
        $this->db->join('main_req_holdoffer hold', 'hold.hold_offer_id=rd.id', 'left');
        if (isset($candidate_id))
            $this->db->where('rd.candidate_id', $candidate_id);
        $this->db->where('rq.requisition_id', $screening_id);
        if ($round == 1) {
            $rounds = array(1, 2, 3, 4);
        } else {
            $rounds = array(5, 6, 7);
        }
        $this->db->where_in('rd.interview_round_number', $rounds);
        $query = $this->db->get();
        // echo $this->db->last_query();

        $obj = $query->result_array();
        //var_dump($obj);
        
         foreach ($obj as $k => $data) {
            $obj[$k]['skill_rating'] = $this->recruitmentfeedback->get_by_id($data['candidate_id'], $data['interview_round_number']);
        }
        
         //var_dump($obj);

        foreach ($obj as $k => $res) {
            if ($res['reschedule_id'] == '1')
                $obj[$k]['reschedule_details'] = $this->get_reschedule_data(null, $res['candidate_id'], $res['interview_round_number']);
        }
        //var_dump($obj);

        if ($round == 1) {
            $client_round = $this->check_client_interview($screening_id);
            $client_round = $client_round[0]['client_interview_status'];
            if ($client_round == 1)
                $total_round = 4;
            else
                $total_round = 3;

            $completed_rounds = count($obj);
            $count_fill = $total_round - $completed_rounds;
//                                echo 'total'.$total_round.'<br>';
//        echo 'cur'.$completed_rounds.'<br>';
            for ($i = $completed_rounds + 1; $i <= $total_round; $i++) {
                //var_dump($obj);
                $obj[$i]['interview_round_number'] = $i;
                $obj[$i]['schedule_comment'] = null;
            }
        } else {
            $total_round = 7;
            $current_round = $this->get_round_status($screening_id, $candidate_id);

            if (isset($current_round) && $current_round != 'null' && !empty($current_round))
                $current_round = $current_round[0]['max_round_reached'];
            else
                $current_round == 0;


            if ($current_round == 0 || $current_round < 5)
                $current_round = 4;
            else
                $current_round = $current_round;

//                    echo 'total'.$total_round.'<br>';
//        echo 'cur'.$current_round.'<br>';
            // echo 'fill'. $count_fill.'<br>';

            $completed_rounds = count($obj);
            for ($i = $current_round + 1; $i <= $total_round; $i++) {
                //var_dump($obj);
                $obj[$i]['interview_round_number'] = $i;
                $obj[$i]['schedule_comment'] = null; //"Not yey scedule " . $i;
            }
        }


        if (isset($obj)) {
            return $obj;
        }
    }

    function getmax_round_number($screening_id, $candidate_id) {
        $this->db->select('MAX(rd.interview_round_number) as max_interview_round_number');
        //$this->db->select('rq.*,interview_mode,rd.interview_time,rd.interview_date');
        $this->db->from('main_req_interviewrounddetails rd');
        $this->db->where('req_id', $screening_id);
        $this->db->where('candidate_id', $candidate_id);
        $query = $this->db->get();

        $max_round = $query->result_array();
        return $max_round[0]['max_interview_round_number'];
    }

    function getmax_round_status($screening_id, $candidate_id, $interview_id) {
        $this->db->select('MAX(rd.round_status) as max_round_status');
        //$this->db->select('rq.*,interview_mode,rd.interview_time,rd.interview_date');
        $this->db->from('main_req_interviewrounddetails rd');
        $this->db->where('req_id', $screening_id);
        $this->db->where('candidate_id', $candidate_id);
        $this->db->where('interview_round_number', $interview_id);
        $query = $this->db->get();
        // echo $this->db->last_query();die;
        $max_round = $query->result_array();
        return $max_round[0]['max_round_status'];
    }

    function get_candidate_list($screening_id, $params = array()) {
//        var_dump($params);
        $this->db->select('rq.*,rd.reschedule_id,cd.title,bt.title as business_type,rd.interview_round_number,rd.round_status');

        //$this->db->select('rq.*,interview_mode,rd.interview_time,rd.interview_date');
        $this->db->from('main_req_candidate_details rq');
        $this->db->join('main_req_interviewrounddetails rd', 'rd.candidate_id=rq.id', 'left');
        $this->db->join('main_color_code cd', 'cd.id=rq.color_code', 'left');
        $this->db->join('main_business_entity bt', 'bt.id=rq.business_entity_id', 'left');
        $this->db->join('main_req_skillset rs', 'rs.candidate_id=rq.id', 'left');
        $this->db->join('main_skills s', 's.id=rs.skillset_id', 'left');

        $this->db->where('requisition_id', $screening_id);
        $this->db->group_by('rq.id');



        //filter data by searched keywords
        if (!empty($params['search']['keywords'])) {
            $this->db->like('rq.candidate_name', $params['search']['keywords']);
        }
//sort data by ascending or desceding order
        if (!empty($params['search']['sortBy']) && $params['search']['sortBy'] != 0) {
            $this->db->order_by('rq.candidate_name', $params['search']['sortBy']);
        } else {
            $this->db->order_by('rq.id', 'ASC');
        }
//set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
//            echo 'first';
            $this->db->limit($params['limit'], $params['start']);
        } else if (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
//        var_dump($params);


        $query = $this->db->get();
//         echo $this->db->last_query();die;
        // echo $this->db->last_query();die;
        $candidate_list = $query->result_array();


        $dataRes = array();
        $i = 0;
        foreach ($candidate_list as $result) {
            $skill_details = $this->recruitmentskills->get_by_id($result['id']);
            //  echo $this->db->last_query();

            if ($skill_details != NULL) {
                $candidate_list[$i]['skill_detail'] = $skill_details; //                    }
            }
            $i++;
        }


       


        $round1 = 1;
        $round2 = 2;

        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['firstround_details'] = $this->get_round_detalis($screening_id, $round1, $list['id']);
        }
        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['secondround_details'] = $this->get_round_detalis($screening_id, $round2, $list['id']);
        }

        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['max_interview_round_number'] = $this->getmax_round_number($screening_id, $list['id']);
            if (isset($candidate_list[$id]['max_interview_round_number']))
                $candidate_list[$id]['max_round_status'] = $this->getmax_round_status($screening_id, $list['id'], $candidate_list[$id]['max_interview_round_number']);
        }
//        echo $this->db->last_query();die;
        // return ($candidate_list->num_rows() > 0) ? $query->result_array() : FALSE;
        // var_dump($candidate_list);
        if (isset($candidate_list)) {
            return $candidate_list;
        }
    }

    function get_candidatelist_byId($screening_id, $params = array()) {
//        var_dump($params);
        $user_id = $this->session->userdata('user_id');
        $this->db->select('rq.*,cd.title,bt.title as business_type');
        //$this->db->select('rq.*,interview_mode,rd.interview_time,rd.interview_date');
        $this->db->from('main_req_candidate_details rq');
        $this->db->join('main_req_interviewrounddetails rd', 'rd.candidate_id=rq.id', 'left');
        $this->db->join('main_color_code cd', 'cd.id=rq.color_code', 'left');
        $this->db->join('main_business_entity bt', 'bt.id=rq.business_entity_id', 'left');
        $this->db->join('main_req_skillset rs', 'rs.candidate_id=rq.id', 'left');
        $this->db->join('main_skills s', 's.id=rs.skillset_id', 'left');
        $this->db->join('main_req_requisition mrq', 'mrq.id=rq.requisition_id', 'left');
        $this->db->where('requisition_id', $screening_id);
        $this->db->where('mrq.createdby', $user_id);
        $this->db->group_by('rq.id');



        //filter data by searched keywords
        if (!empty($params['search']['keywords'])) {
            $this->db->like('rq.candidate_name', $params['search']['keywords']);
        }
//sort data by ascending or desceding order
        if (!empty($params['search']['sortBy']) && $params['search']['sortBy'] != 0) {
            $this->db->order_by('rq.candidate_name', $params['search']['sortBy']);
        } else {
            $this->db->order_by('rq.id', 'ASC');
        }
//set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
//            echo 'first';
            $this->db->limit($params['limit'], $params['start']);
        } else if (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
//        var_dump($params);


        $query = $this->db->get();
//         echo $this->db->last_query();die;
        // echo $this->db->last_query();die;
        $candidate_list = $query->result_array();


        $dataRes = array();
        $i = 0;
        foreach ($candidate_list as $result) {
            $skill_details = $this->recruitmentskills->get_by_id($result['id']);
            //  echo $this->db->last_query();

            if ($skill_details != NULL) {
                $candidate_list[$i]['skill_detail'] = $skill_details; //                    }
            }
            $i++;
        }




        $round1 = 1;
        $round2 = 2;

        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['firstround_details'] = $this->get_round_detalis($screening_id, $round1, $list['id']);
        }
        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['secondround_details'] = $this->get_round_detalis($screening_id, $round2, $list['id']);
        }

        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['max_interview_round_number'] = $this->getmax_round_number($screening_id, $list['id']);
            if (isset($candidate_list[$id]['max_interview_round_number']))
                $candidate_list[$id]['max_round_status'] = $this->getmax_round_status($screening_id, $list['id'], $candidate_list[$id]['max_interview_round_number']);
        }
//        echo $this->db->last_query();die;
        // return ($candidate_list->num_rows() > 0) ? $query->result_array() : FALSE;
        // var_dump($candidate_list);
        if (isset($candidate_list)) {
            return $candidate_list;
        }
    }

//    function get_candidatelist_byId($screening_id, $params = array()) {
//        $user_id = $this->session->userdata('user_id');
//        $this->db->select('rq.*,cd.title,bt.title as business_type');
//        //$this->db->select('rq.*,interview_mode,rd.interview_time,rd.interview_date');
//        $this->db->from('main_req_candidate_details rq');
//        $this->db->join('main_req_requisition mrq', 'mrq.id=rq.requisition_id', 'left');
//        $this->db->join('main_color_code cd', 'cd.id=rq.color_code', 'left');
//        $this->db->join('main_business_entity bt', 'bt.id=rq.business_entity_id', 'left');
//        $this->db->where('rq.requisition_id', $screening_id);
//        $this->db->where('mrq.createdby', $user_id);
//
//
//
//
//        //filter data by searched keywords
//        if (!empty($params['search']['keywords'])) {
//            $this->db->like('rq.candidate_name', $params['search']['keywords']);
//        }
////sort data by ascending or desceding order
//        if (!empty($params['search']['sortBy'])) {
//            $this->db->order_by('rq.candidate_name', $params['search']['sortBy']);
//        } else {
//            $this->db->order_by('rq.id', 'ASC');
//        }
////set start and limit
//        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
//            $this->db->limit($params['limit'], $params['start']);
//        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
//            $this->db->limit($params['limit']);
//        }
//
//
//        $query = $this->db->get();
//        // echo $this->db->last_query();die;
//        $candidate_list = $query->result_array();
//        $round1 = 1;
//        $round2 = 2;
//
//        foreach ($candidate_list as $id => $list) {
//            $candidate_list[$id]['firstround_details'] = $this->get_round_detalis($screening_id, $round1, $list['id']);
//        }
//        foreach ($candidate_list as $id => $list) {
//            $candidate_list[$id]['secondround_details'] = $this->get_round_detalis($screening_id, $round2, $list['id']);
//        }
//
//        // return ($candidate_list->num_rows() > 0) ? $query->result_array() : FALSE;
//        // var_dump($candidate_list);
//        if (isset($candidate_list)) {
//            return $candidate_list;
//        }
//    }

    function get_candidate_details($id) {
        $this->db->select('rq.*,cd.title');
        //$this->db->select('rq.*,interview_mode,rd.interview_time,rd.interview_date');
        $this->db->from('main_req_candidate_details rq');
        // $this->db->join('main_req_interviewrounddetails rd', 'rd.candidate_id=rq.id','left');
        $this->db->join('main_color_code cd', 'cd.id=rq.color_code', 'left');

        $this->db->where('requisition_id', $id);
        $this->db->where('position', '0');
        $this->db->where('rq.isactive', '0');
        $query = $this->db->get();
        $obj = $query->result_array();
        if (isset($obj)) {
            return $obj;
        }
    }

    function get_candidate_details1($screening_id) {
        $this->db->select('rq.*,cd.title');
        //$this->db->select('rq.*,interview_mode,rd.interview_time,rd.interview_date');
        $this->db->from('main_req_candidate_details rq');
        // $this->db->join('main_req_interviewrounddetails rd', 'rd.candidate_id=rq.id','left');
        $this->db->join('main_color_code cd', 'cd.id=rq.color_code', 'left');
        $this->db->where('requisition_id', $screening_id);
        $this->db->where('position', '1');
        $this->db->where('rq.isactive', '0');
        // $this->db->where('rd.interview_round_number', '1');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $candidate_list = $query->result_array();
        $position = 1;
        $rounds = array(1);


        $round_word_status = $this->get_feedback_Wordstatus($screening_id, $position);
        $count_word_rounds = count($round_word_status);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_word_rounds; $j++) {
                if ($list['id'] == $round_word_status[$j]['candidate_id']) {
                    $candidate_list[$id]['round_word_status'] = $round_word_status[$j]['round_status'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_word_status']))
                $candidate_list[$id]['round_word_status'] = NULL;
        }


        $round_status = $this->get_feedback_status($screening_id, $position);
        $count_rounds = count($round_status);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_rounds; $j++) {
                if ($list['id'] == $round_status[$j]['candidate_id']) {
                    $candidate_list[$id]['round_status'] = $round_status[$j]['max_round_reached'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_status']))
                $candidate_list[$id]['round_status'] = NULL;
        }


        $firstround_status = $this->get_firstround_status($screening_id, $position);
        $cnt = count($firstround_status);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $cnt; $j++) {
                if ($list['id'] == $firstround_status[$j]['candidate_id']) {
                    $candidate_list[$id]['firstround_status'] = $firstround_status[$j]['max_round_reached'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['firstround_status']))
                $candidate_list[$id]['firstround_status'] = NULL;
        }


        $reschedule_status = $this->get_rescheduleStatusDetails($screening_id, $position);
        $cnt = count($reschedule_status);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $cnt; $j++) {
                if ($list['id'] == $reschedule_status[$j]['candidate_id']) {
                    $candidate_list[$id]['reschedule_status'] = $reschedule_status[$j]['max_rechedule'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['reschedule_status']))
                $candidate_list[$id]['reschedule_status'] = NULL;
        }





        $round_skipstatus = $this->get_skip_status($screening_id, $position);
        $count_skiprounds = count($round_skipstatus);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_skiprounds; $j++) {
                if ($list['id'] == $round_skipstatus[$j]['candidate_id']) {
                    $candidate_list[$id]['round_skipstatus'] = $round_skipstatus[$j]['max_round_skip'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_skipstatus']))
                $candidate_list[$id]['round_skipstatus'] = NULL;
        }

        $round_skipDetails = $this->get_skipDetails_status($screening_id, $position);
        $count_skipDetails = count($round_skipDetails);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_skipDetails; $j++) {
                if ($list['id'] == $round_skipDetails[$j]['candidate_id']) {
                    $candidate_list[$id]['round_skipDetails'] = $round_skipDetails[$j]['max_round_skip_details'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_skipDetails']))
                $candidate_list[$id]['round_skipDetails'] = NULL;
        }


        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['interview_round_details'] = $this->get_feedback_detalis($screening_id, $position, $rounds, $list['id']);
            $candidate_list[$id]['schedule_details'] = $this->get_schedule_status($screening_id, $position, $rounds, $list['id']);
            $candidate_list[$id]['round_completion'] = $this->get_round_completion($screening_id, $position, $rounds, $list['id']);
//            if ($candidate_list[$id]['schedule_details']['round_status'] > 0) {
//                $candidate_list[$id]['schedule_details'] = $this->get_reschedule_status($candidate_list[$id]['schedule_details']['reschedule_id']);
//            }
        }


        // var_dump($candidate_list);

        if (isset($candidate_list)) {
            return $candidate_list;
        }
    }

    function get_candidate_details2($screening_id) {

        //echo "uuuuuuuu".$id;die;
        $this->db->select('rq.*,cd.title');
        //$this->db->select('rq.*,interview_mode,rd.interview_time,rd.interview_date');
        $this->db->from('main_req_candidate_details rq');
        // $this->db->join('main_req_interviewrounddetails rd', 'rd.candidate_id=rq.id','left');
        $this->db->join('main_color_code cd', 'cd.id=rq.color_code', 'left');
        $this->db->where('requisition_id', $screening_id);
        $this->db->where('position', '2');
        $this->db->where('rq.isactive', '0');
        $query = $this->db->get();
        $candidate_list = $query->result_array();
        //echo $this->db->last_query();die;
        $position = 2;
        $rounds = array(1, 2);
        $skip_id = array(1);


        $round_word_status = $this->get_feedback_Wordstatus($screening_id, $position);
        $count_word_rounds = count($round_word_status);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_word_rounds; $j++) {
                if ($list['id'] == $round_word_status[$j]['candidate_id']) {
                    $candidate_list[$id]['round_word_status'] = $round_word_status[$j]['round_status'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_word_status']))
                $candidate_list[$id]['round_word_status'] = NULL;
        }







        $round_status = $this->get_feedback_status($screening_id, $position);
        $count_rounds = count($round_status);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_rounds; $j++) {
                if ($list['id'] == $round_status[$j]['candidate_id']) {
                    $candidate_list[$id]['round_status'] = $round_status[$j]['max_round_reached'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_status']))
                $candidate_list[$id]['round_status'] = NULL;
        }



        $round_skipstatus = $this->get_skip_status($screening_id, $position);
        $count_skiprounds = count($round_skipstatus);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_skiprounds; $j++) {
                if ($list['id'] == $round_skipstatus[$j]['candidate_id']) {
                    $candidate_list[$id]['round_skipstatus'] = $round_skipstatus[$j]['max_round_skip'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_skipstatus']))
                $candidate_list[$id]['round_skipstatus'] = NULL;
        }

        //$position1=1;
        $round_skipDetails = $this->get_skipDetails_status($screening_id, $position);
        $count_skipDetails = count($round_skipDetails);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_skipDetails; $j++) {
                if ($list['id'] == $round_skipDetails[$j]['candidate_id']) {
                    $candidate_list[$id]['round_skipDetails'] = $round_skipDetails[$j]['max_round_skip_details'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_skipDetails']))
                $candidate_list[$id]['round_skipDetails'] = NULL;
        }

        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['interview_round_details'] = $this->get_feedback_detalis($screening_id, $position, $rounds, $list['id']);
            //   $candidate_list[$id]['skill_rating'] = $this->get_rating_detalis($screening_id, $position, $rounds, $list['id']);
            $candidate_list[$id]['schedule_details'] = $this->get_schedule_status($screening_id, $position, $rounds, $list['id']);
            $candidate_list[$id]['round_completion'] = $this->get_round_completion($screening_id, $position, $rounds, $list['id']);
//            var_dump($candidate_list[$id]['schedule_details']);die;
//            if ($candidate_list[$id]['schedule_details']['reschedule_id'] > 0) {
//                $candidate_list[$id]['schedule_details'] = $this->get_reschedule_status($candidate_list[$id]['schedule_details']['reschedule_id']);
//            }
        }
//        var_dump($rounds);
//        var_dump($candidate_list[$id]['schedule_details']);die;
        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['interview_skip_details'] = $this->get_skip_comments_detalis($screening_id, $position, $rounds, $skip_id, $list['id']);
        }

        // var_dump($candidate_list);
        if (isset($candidate_list)) {
            return $candidate_list;
        }
    }

    function get_candidate_details3($screening_id) {
        $this->db->select('rq.*,cd.title');
        //$this->db->select('rq.*,interview_mode,rd.interview_time,rd.interview_date');
        $this->db->from('main_req_candidate_details rq');
        // $this->db->join('main_req_interviewrounddetails rd', 'rd.candidate_id=rq.id','left');
        $this->db->join('main_color_code cd', 'cd.id=rq.color_code', 'left');
        $this->db->where('requisition_id', $screening_id);
        $this->db->where('position', '3');
        $this->db->where('rq.isactive', '0');
        $query = $this->db->get();
        $candidate_list = $query->result_array();
        $position = 3;
        $rounds = array(1, 2, 3);
        $skip_id = array(1, 2);


        $round_word_status = $this->get_feedback_Wordstatus($screening_id, $position);
        $count_word_rounds = count($round_word_status);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_word_rounds; $j++) {
                if ($list['id'] == $round_word_status[$j]['candidate_id']) {
                    $candidate_list[$id]['round_word_status'] = $round_word_status[$j]['round_status'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_word_status']))
                $candidate_list[$id]['round_word_status'] = NULL;
        }

        $round_status = $this->get_feedback_status($screening_id, $position);
        $count_rounds = count($round_status);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_rounds; $j++) {
                if ($list['id'] == $round_status[$j]['candidate_id']) {
                    $candidate_list[$id]['round_status'] = $round_status[$j]['max_round_reached'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_status']))
                $candidate_list[$id]['round_status'] = NULL;
        }


        $round_skipstatus = $this->get_skip_status($screening_id, $position);
        $count_skiprounds = count($round_skipstatus);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_skiprounds; $j++) {
                if ($list['id'] == $round_skipstatus[$j]['candidate_id']) {
                    $candidate_list[$id]['round_skipstatus'] = $round_skipstatus[$j]['max_round_skip'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_skipstatus']))
                $candidate_list[$id]['round_skipstatus'] = NULL;
        }

        $round_skipDetails = $this->get_skipDetails_status($screening_id, $position);
        $count_skipDetails = count($round_skipDetails);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_skipDetails; $j++) {
                if ($list['id'] == $round_skipDetails[$j]['candidate_id']) {
                    $candidate_list[$id]['round_skipDetails'] = $round_skipDetails[$j]['max_round_skip_details'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_skipDetails']))
                $candidate_list[$id]['round_skipDetails'] = NULL;
        }


        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['interview_round_details'] = $this->get_feedback_detalis($screening_id, $position, $rounds, $list['id']);
            $candidate_list[$id]['schedule_details'] = $this->get_schedule_status($screening_id, $position, $rounds, $list['id']);
            $candidate_list[$id]['round_completion'] = $this->get_round_completion($screening_id, $position, $rounds, $list['id']);
//            if ($candidate_list[$id]['schedule_details']['reschedule_id'] > 0) {
//                $candidate_list[$id]['schedule_details'] = $this->get_reschedule_status($candidate_list[$id]['schedule_details']['reschedule_id']);
//            }
        }

        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['interview_skip_details'] = $this->get_skip_comments_detalis($screening_id, $position, $rounds, $skip_id, $list['id']);
        }
        if (isset($candidate_list)) {
            return $candidate_list;
        }
    }

    function get_candidate_details4($screening_id) {
        $this->db->select('rq.*,cd.title');
        //$this->db->select('rq.*,interview_mode,rd.interview_time,rd.interview_date');
        $this->db->from('main_req_candidate_details rq');
        //  $this->db->join('main_req_interviewrounddetails rd', 'rq.position=rd.interview_round_number','left');
        $this->db->join('main_color_code cd', 'cd.id=rq.color_code', 'left');
        $this->db->where('rq.requisition_id', $screening_id);
        $this->db->where('rq.position', '4');
        $this->db->where('rq.isactive', '0');
        $query = $this->db->get();
        $candidate_list = $query->result_array();
        //echo $this->db->last_query();die;
        $position = 4;
        $rounds = array(1, 2, 3, 4);
        $skip_id = array(1, 2, 3);


        $round_word_status = $this->get_feedback_Wordstatus($screening_id, $position);
        $count_word_rounds = count($round_word_status);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_word_rounds; $j++) {
                if ($list['id'] == $round_word_status[$j]['candidate_id']) {
                    $candidate_list[$id]['round_word_status'] = $round_word_status[$j]['round_status'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_word_status']))
                $candidate_list[$id]['round_word_status'] = NULL;
        }

        $round_status = $this->get_feedback_status($screening_id, $position);
        $count_rounds = count($round_status);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_rounds; $j++) {
                if ($list['id'] == $round_status[$j]['candidate_id']) {
                    $candidate_list[$id]['round_status'] = $round_status[$j]['max_round_reached'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_status']))
                $candidate_list[$id]['round_status'] = NULL;
        }

        $round_skipstatus = $this->get_skip_status($screening_id, $position);
        $count_skiprounds = count($round_skipstatus);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_skiprounds; $j++) {
                if ($list['id'] == $round_skipstatus[$j]['candidate_id']) {
                    $candidate_list[$id]['round_skipstatus'] = $round_skipstatus[$j]['max_round_skip'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_skipstatus']))
                $candidate_list[$id]['round_skipstatus'] = NULL;
        }

        $round_skipDetails = $this->get_skipDetails_status($screening_id, $position);
        $count_skipDetails = count($round_skipDetails);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_skipDetails; $j++) {
                if ($list['id'] == $round_skipDetails[$j]['candidate_id']) {
                    $candidate_list[$id]['round_skipDetails'] = $round_skipDetails[$j]['max_round_skip_details'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_skipDetails']))
                $candidate_list[$id]['round_skipDetails'] = NULL;
        }

        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['interview_round_details'] = $this->get_feedback_detalis($screening_id, $position, $rounds, $list['id']);
            $candidate_list[$id]['schedule_details'] = $this->get_schedule_status($screening_id, $position, $rounds, $list['id']);
            $candidate_list[$id]['round_completion'] = $this->get_round_completion($screening_id, $position, $rounds, $list['id']);
//            if ($candidate_list[$id]['schedule_details']['reschedule_id'] > 0) {
//                $candidate_list[$id]['schedule_details'] = $this->get_reschedule_status($candidate_list[$id]['schedule_details']['reschedule_id']);
//            }
        }

        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['interview_skip_details'] = $this->get_skip_comments_detalis($screening_id, $position, $rounds, $skip_id, $list['id']);
        }
        if (isset($candidate_list)) {
            return $candidate_list;
        }
    }

    function get_candidate_details5($screening_id) {
        $this->db->select('rq.*,cd.title');
        //$this->db->select('rq.*,interview_mode,rd.interview_time,rd.interview_date');
        $this->db->from('main_req_candidate_details rq');
        //  $this->db->join('main_req_interviewrounddetails rd', 'rd.candidate_id=rq.id','left');
        $this->db->join('main_color_code cd', 'cd.id=rq.color_code', 'left');
        $this->db->where('requisition_id', $screening_id);
        $this->db->where('position', '5');
        $this->db->where('rq.isactive', '0');
        $query = $this->db->get();
        $candidate_list = $query->result_array();
        $position = 5;
        $rounds = array(1, 2, 3, 4, 5);
        $skip_id = array(1, 2, 3, 4);

        $round_word_status = $this->get_feedback_Wordstatus($screening_id, $position);
        $count_word_rounds = count($round_word_status);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_word_rounds; $j++) {
                if ($list['id'] == $round_word_status[$j]['candidate_id']) {
                    $candidate_list[$id]['round_word_status'] = $round_word_status[$j]['round_status'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_word_status']))
                $candidate_list[$id]['round_word_status'] = NULL;
        }

        $round_status = $this->get_feedback_status($screening_id, $position);
        $count_rounds = count($round_status);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_rounds; $j++) {
                if ($list['id'] == $round_status[$j]['candidate_id']) {
                    $candidate_list[$id]['round_status'] = $round_status[$j]['max_round_reached'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_status']))
                $candidate_list[$id]['round_status'] = NULL;
        }

        $round_skipstatus = $this->get_skip_status($screening_id, $position);
        $count_skiprounds = count($round_skipstatus);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_skiprounds; $j++) {
                if ($list['id'] == $round_skipstatus[$j]['candidate_id']) {
                    $candidate_list[$id]['round_skipstatus'] = $round_skipstatus[$j]['max_round_skip'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_skipstatus']))
                $candidate_list[$id]['round_skipstatus'] = NULL;
        }


        $round_skipDetails = $this->get_skipDetails_status($screening_id, $position);
        $count_skipDetails = count($round_skipDetails);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_skipDetails; $j++) {
                if ($list['id'] == $round_skipDetails[$j]['candidate_id']) {
                    $candidate_list[$id]['round_skipDetails'] = $round_skipDetails[$j]['max_round_skip_details'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_skipDetails']))
                $candidate_list[$id]['round_skipDetails'] = NULL;
        }

        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['interview_round_details'] = $this->get_feedback_detalis($screening_id, $position, $rounds, $list['id']);
$candidate_list[$id]['round_completion'] = $this->get_round_completion($screening_id, $position, $rounds, $list['id']);

            $candidate_list[$id]['schedule_details'] = $this->get_schedule_status($screening_id, $position, $rounds, $list['id']);
//            if ($candidate_list[$id]['schedule_details']['reschedule_id'] > 0) {
//                $candidate_list[$id]['schedule_details'] = $this->get_reschedule_status($candidate_list[$id]['schedule_details']['reschedule_id']);
//            }
        }

        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['interview_skip_details'] = $this->get_skip_comments_detalis($screening_id, $position, $rounds, $skip_id, $list['id']);
        }
        if (isset($candidate_list)) {
            return $candidate_list;
        }
    }

    function get_candidate_details6($screening_id) {
        $this->db->select('rq.*,cd.title');
        //$this->db->select('rq.*,interview_mode,rd.interview_time,rd.interview_date');
        $this->db->from('main_req_candidate_details rq');
        //  $this->db->join('main_req_interviewrounddetails rd', 'rd.candidate_id=rq.id','left');
        $this->db->join('main_color_code cd', 'cd.id=rq.color_code', 'left');
        $this->db->where('requisition_id', $screening_id);
        $this->db->where('position', '6');
        $this->db->where('rq.isactive', '0');
        $query = $this->db->get();
        $candidate_list = $query->result_array();

        $position = 6;
        $rounds = array(1, 2, 3, 4, 5, 6);
        $skip_id = array(1, 2, 3, 4, 5);


        $round_word_status = $this->get_feedback_Wordstatus($screening_id, $position);
        $count_word_rounds = count($round_word_status);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_word_rounds; $j++) {
                if ($list['id'] == $round_word_status[$j]['candidate_id']) {
                    $candidate_list[$id]['round_word_status'] = $round_word_status[$j]['round_status'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_word_status']))
                $candidate_list[$id]['round_word_status'] = NULL;
        }

        $round_status = $this->get_feedback_status($screening_id, $position);
        $count_rounds = count($round_status);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_rounds; $j++) {
                if ($list['id'] == $round_status[$j]['candidate_id']) {
                    $candidate_list[$id]['round_status'] = $round_status[$j]['max_round_reached'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_status']))
                $candidate_list[$id]['round_status'] = NULL;
        }

        $round_skipstatus = $this->get_skip_status($screening_id, $position);
        $count_skiprounds = count($round_skipstatus);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_skiprounds; $j++) {
                if ($list['id'] == $round_skipstatus[$j]['candidate_id']) {
                    $candidate_list[$id]['round_skipstatus'] = $round_skipstatus[$j]['max_round_skip'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_skipstatus']))
                $candidate_list[$id]['round_skipstatus'] = NULL;
        }

        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['interview_round_details'] = $this->get_feedback_detalis($screening_id, $position, $rounds, $list['id']);
            $candidate_list[$id]['schedule_details'] = $this->get_schedule_status($screening_id, $position, $rounds, $list['id']);
            $candidate_list[$id]['round_completion'] = $this->get_round_completion($screening_id, $position, $rounds, $list['id']);
//            if ($candidate_list[$id]['schedule_details']['reschedule_id'] > 0) {
//                $candidate_list[$id]['schedule_details'] = $this->get_reschedule_status($candidate_list[$id]['schedule_details']['reschedule_id']);
//            }
        }
        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['interview_skip_details'] = $this->get_skip_comments_detalis($screening_id, $position, $rounds, $skip_id, $list['id']);
        }

        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['interview_hold_details'] = $this->get_holdDetails($screening_id, $list['id']);
        }


        if (isset($candidate_list)) {
            return $candidate_list;
        }
    }

    function get_candidate_details7($screening_id) {
        //$this->db->select('rq.*,interview_mode,rd.interview_time,rd.interview_date');
        $this->db->select('rq.*,cd.title');
        $this->db->from('main_req_candidate_details rq');
        //  $this->db->join('main_req_interviewrounddetails rd', 'rd.candidate_id=rq.id','left');
        $this->db->join('main_color_code cd', 'cd.id=rq.color_code', 'left');
        $this->db->where('requisition_id', $screening_id);
        $this->db->where('position', '7');
        $this->db->where('rq.isactive', '0');
        $query = $this->db->get();
        $candidate_list = $query->result_array();
        $position = 7;
        $rounds = array(1, 2, 3, 4, 5, 6, 7);
        $skip_id = array(1, 2, 3, 4, 5, 6);


        $round_word_status = $this->get_feedback_Wordstatus($screening_id, $position);
        $count_word_rounds = count($round_word_status);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_word_rounds; $j++) {
                if ($list['id'] == $round_word_status[$j]['candidate_id']) {
                    $candidate_list[$id]['round_word_status'] = $round_word_status[$j]['round_status'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_word_status']))
                $candidate_list[$id]['round_word_status'] = NULL;
        }

        $round_status = $this->get_feedback_status($screening_id, $position);
        $count_rounds = count($round_status);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_rounds; $j++) {
                if ($list['id'] == $round_status[$j]['candidate_id']) {
                    $candidate_list[$id]['round_status'] = $round_status[$j]['max_round_reached'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_status']))
                $candidate_list[$id]['round_status'] = NULL;
        }

        $round_skipstatus = $this->get_skip_status($screening_id, $position);
        $count_skiprounds = count($round_skipstatus);
        foreach ($candidate_list as $id => $list) {
            for ($j = 0; $j < $count_skiprounds; $j++) {
                if ($list['id'] == $round_skipstatus[$j]['candidate_id']) {
                    $candidate_list[$id]['round_skipstatus'] = $round_skipstatus[$j]['max_round_skip'];
                }
            }
        }
        foreach ($candidate_list as $id => $list) {
            if (!isset($list['round_skipstatus']))
                $candidate_list[$id]['round_skipstatus'] = NULL;
        }

        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['interview_round_details'] = $this->get_feedback_detalis($screening_id, $position, $rounds, $list['id']);
            $candidate_list[$id]['schedule_details'] = $this->get_schedule_status($screening_id, $position, $rounds, $list['id']);
            $candidate_list[$id]['round_completion'] = $this->get_round_completion($screening_id, $position, $rounds, $list['id']);
//            if ($candidate_list[$id]['schedule_details']['reschedule_id'] > 0) {
//                $candidate_list[$id]['schedule_details'] = $this->get_reschedule_status($candidate_list[$id]['schedule_details']['reschedule_id']);
//            }
        }

        foreach ($candidate_list as $id => $list) {
            $candidate_list[$id]['interview_skip_details'] = $this->get_skip_comments_detalis($screening_id, $position, $rounds, $skip_id, $list['id']);
        }
        if (isset($candidate_list)) {
            return $candidate_list;
        }
    }

    function get_slected_candidate($req_code) {
        $this->db->select('COUNT(id.isactive) as selected');
        $this->db->from('main_req_candidate_details id');
        $this->db->where('id.requisition_code', $req_code);
        $this->db->where('id.isactive', 5);
        $query = $this->db->get();
        $selected = $query->result_array();
        return ($selected[0]['selected']);
    }

    function get_apllied_candidate($req_code) {
        $this->db->select('COUNT(id.id) as applied');
        $this->db->from('main_req_candidate_details id');
        $this->db->where('id.requisition_code', $req_code);
        $query = $this->db->get();
        $applied = $query->result_array();
        return ($applied[0]['applied']);
    }

    function get_screening_count($screening_id) {
        $this->db->select('candidate.*,mrq.ispublished,mrq.req_no_positions,mrq.close_date,mrq.opening_status');
        $this->db->from('main_req_candidate_details candidate');
        $this->db->join('main_req_requisition mrq', 'mrq.id=candidate.requisition_id');
        $this->db->where('candidate.requisition_id', $screening_id);
        $query = $this->db->get();
        $screening = $query->result_array();

        foreach ($screening as $id => $list) {
            $screening[$id]['selected'] = $this->get_slected_candidate($list['requisition_code']);
            $screening[$id]['applied'] = $this->get_apllied_candidate($list['requisition_code']);
        }
//        var_dump($candidate_list);die;
        return $screening;
    }

    /* change candidate status */

    public function candidate_status($candidate_id) {
        $data = array('isactive' => '6');
        $this->db->where('id', $candidate_id);
        $this->db->update('main_req_candidate_details', $data);
        return true;
    }

    public function get_candidate_details_by_id($candidate_id) {
        $this->db->select('candidate.id as candidate_id,candidate.*,mrq.*');
        $this->db->from('main_req_candidate_details candidate');
        $this->db->join('main_req_requisition mrq', 'mrq.id=candidate.requisition_id');
        $this->db->where('candidate.id', $candidate_id);
        $query = $this->db->get();
        $candidate_list = $query->result_array();
        return $candidate_list[0];
//        var_dump($candidate_list);die;
    }

}

/* End of file country_model.php */
/* Location: ./models/city.php */