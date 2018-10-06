<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Payment_Model extends CI_Model {


    public function get_all_payments(){
        $this->db->select('*');
        $this->db->from('tbl_payment');
        $this->db->order_by('time_stamp','desc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_payment_by_id($payment_id){
        $this->db->select('*');
        $this->db->from('tbl_payment');
        $this->db->where('payment_id',$payment_id);
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }
    
    
    public function add_payment($data){
        $this->db->insert('tbl_payment',$data);
        $result = $this->db->insert_id();
        return $result;
    }
   
    public function update_payment($data,$payment_id){
        
        $this->db->where('payment_id',$payment_id);
        $this->db->update('tbl_payment',$data);
    }
   
    public function delete_payment($payment_id){
        $this->db->where('payment_id',$payment_id);
        $this->db->delete('tbl_payment');
    }
}
?>
