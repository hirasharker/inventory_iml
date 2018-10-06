<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Group_Model extends CI_Model {

    public function get_all_groups(){
        $this->db->select('*');
        $this->db->from('tbl_group');
        $this->db->order_by('time_stamp','asc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_group_by_parent_id($group_id){
        $this->db->select('*');
        $this->db->where('parent_id',$group_id);
        $this->db->from('tbl_group');
        $result_query   =   $this->db->get();
        $result         =   $result_query->result();
        return $result;
    }

    public function get_group_by_id($group_id){
        $this->db->select('*');
        $this->db->from('tbl_group');
        $this->db->where('group_id',$group_id);
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }
    
    
    public function add_group($data){
        
        $this->db->insert('tbl_group',$data);
        $result=$this->db->insert_id();
        return $result;
    }
   
    public function update_group($data,$group_id){
        
        $this->db->where('group_id',$group_id);
        $this->db->update('tbl_group',$data);
    }
   
    public function delete_group($group_id){
        $this->db->where('group_id',$group_id);
        $this->db->delete('tbl_group');
    }
    
}
?>
