
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Model {

    public function checkUser($data = array()) {

        $this->db->select('id');
        $this->db->from('users');
        //$this->db->where(array('oauth_provider' => $data['oauth_provider'], 'oauth_uid' => $data['oauth_uid'], 'email' => $data['email']));
        $this->db->where(array('email' => $data['email']));
        $query = $this->db->get();
        $check = $query->num_rows();

        if ($check > 0) {
            $prevResult = $query->row_array();
            $data['modified'] = date("Y-m-d H:i:s");
            $update = $this->db->update('users', $data, array('id' => $prevResult['id']));
            $userID = $prevResult['id'];
        } else {
            
            $data['created'] = date("Y-m-d H:i:s");
            $data['modified'] = date("Y-m-d H:i:s");
            $insert = $this->db->insert('users', $data);
            $userID = $this->db->insert_id();
            $arr = array('user_id' => $userID);
            $this->db->insert('users_address_details',$arr);
            $this->db->insert('users_groups',array('user_id'=>$userID,'group_id'=>2));
        }

        return $userID ? $userID : FALSE;
    }
    
    public function getUserAddress(){
        $user_id = $this->session->userdata('user_id');
        $this->db->select('u.email,u.profileimg,u.phone,u.picture_url,u.profile_url,uad.*');
        $this->db->from('users u');
        $this->db->join('users_address_details uad','u.id=uad.user_id');
        $this->db->where('uad.user_id',$user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

}
