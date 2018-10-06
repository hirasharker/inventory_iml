<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Dealer_Model extends CI_Model {


    public function get_all_dealers(){
        $this->db->select('*');
        $this->db->from('tbl_dealer');
        $this->db->order_by('time_stamp','asc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_dealer_by_id($dealer_id){
        $this->db->select('*');
        $this->db->from('tbl_dealer');
        $this->db->where('dealer_id',$dealer_id);
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }
    
    
    public function add_dealer($data){
        $this->db->insert('tbl_dealer',$data);
        $result = $this->db->insert_id();
        return $result;
    }
   
    public function update_dealer($data,$dealer_id){
        
        $this->db->where('dealer_id',$dealer_id);
        $this->db->update('tbl_dealer',$data);
    }
   
    public function delete_dealer($dealer_id){
        $this->db->where('dealer_id',$dealer_id);
        $this->db->delete('tbl_dealer');
    }

   
}?>
