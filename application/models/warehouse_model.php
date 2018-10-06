<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class warehouse_Model extends CI_Model {

    public function get_all_warehouses(){
        $this->db->select('*');
        $this->db->from('tbl_warehouse');
        $this->db->order_by('time_stamp','asc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_warehouse_by_id($warehouse_id){
        $this->db->select('*');
        $this->db->from('tbl_warehouse');
        $this->db->where('warehouse_id',$warehouse_id);
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }

    public function get_warehouses_except_this_id($warehouse_id){
        $this->db->select('*');
        $this->db->from('tbl_warehouse');
        $this->db->where('warehouse_id !=',$warehouse_id);
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }
    
    
    public function add_warehouse($data){
        
        $this->db->insert('tbl_warehouse',$data);
        $result=$this->db->insert_id();
        return $result;
    }
   
    public function update_warehouse($data,$warehouse_id){
        
        $this->db->where('warehouse_id',$warehouse_id);
        $this->db->update('tbl_warehouse',$data);
    }
   
    public function delete_warehouse($warehouse_id){
        $this->db->where('warehouse_id',$warehouse_id);
        $this->db->delete('tbl_warehouse');
    }




    //--------------------WAREHOUSE SLOT---------------------------

    public function get_all_warehouse_slots(){
        $this->db->select('*');
        $this->db->from('tbl_warehouse_slot');
        $this->db->order_by('time_stamp','asc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_warehouse_slot_by_id($warehouse_slot_id){
        $this->db->select('*');
        $this->db->from('tbl_warehouse_slot');
        $this->db->where('warehouse_slot_id',$warehouse_slot_id);
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }

    public function get_warehouse_slots_except_this_id($warehouse_slot_id){
        $this->db->select('*');
        $this->db->from('tbl_warehouse_slot');
        $this->db->where('warehouse_slot_id !=',$warehouse_slot_id);
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }
    
    
    public function add_warehouse_slot($data){
        
        $this->db->insert('tbl_warehouse_slot',$data);
        $result=$this->db->insert_id();
        return $result;
    }
   
    public function update_warehouse_slot($data,$warehouse_slot_id){
        
        $this->db->where('warehouse_slot_id',$warehouse_slot_id);
        $this->db->update('tbl_warehouse_slot',$data);
    }
   
    public function delete_warehouse_slot($warehouse_slot_id){
        $this->db->where('warehouse_slot_id',$warehouse_slot_id);
        $this->db->delete('tbl_warehouse_slot');
    }


    
}
?>
