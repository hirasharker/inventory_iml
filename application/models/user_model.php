<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class User_Model extends CI_Model {

    public function get_all_users(){
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->order_by('time_stamp','asc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_user_by_id($user_id){
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('user_id',$user_id);
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }
    
    
    public function add_user($data){
        
        $this->db->insert('tbl_user',$data);
        $result=$this->db->insert_id();
        return $result;
    }
   
    public function update_user($data,$user_id){
        
        $this->db->where('user_id',$user_id);
        $this->db->update('tbl_user',$data);
    }
   
    public function delete_user($user_id){
        $this->db->where('user_id',$user_id);
        $this->db->delete('tbl_user');
    }
    
}
?>
