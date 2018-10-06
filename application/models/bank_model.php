<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Bank_Model extends CI_Model {

    /**
     * [get_all_banks description]
     * @return ArrayList [description]
     */
    public function get_all_banks(){
        $this->db->select('*');
        $this->db->from('tbl_bank');
        $this->db->order_by('time_stamp','asc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }
    /**
     * [get_bank_by_id description]
     * @param  int $bank_id [description]
     * @return Array
     */
    public function get_bank_by_id($bank_id){
        $this->db->select('*');
        $this->db->from('tbl_bank');
        $this->db->where('bank_id',$bank_id);
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }
    
    
    public function add_bank($data){
        $this->db->insert('tbl_bank',$data);
        $result = $this->db->insert_id();
        return $result;
    }
   
    public function update_bank($data,$bank_id){
        
        $this->db->where('bank_id',$bank_id);
        $this->db->update('tbl_bank',$data);
    }
   
    public function delete_bank($bank_id){
        $this->db->where('bank_id',$bank_id);
        $this->db->delete('tbl_bank');
    }

   
}?>
