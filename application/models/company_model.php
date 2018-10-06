<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Company_Model extends CI_Model {

    public function get_all_companies(){
        $this->db->select('*');
        $this->db->from('tbl_company');
        $this->db->order_by('time_stamp','asc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_company_by_id($company_id){
        $this->db->select('*');
        $this->db->from('tbl_company');
        $this->db->where('company_id',$company_id);
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }
    
    public function update_company($data,$company_id){
        
        $this->db->where('company_id',$company_id);
        $this->db->update('tbl_company',$data);
    }

}
?>
