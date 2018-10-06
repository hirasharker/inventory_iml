<?php 

class Customer_Model extends CI_Model {

    public function get_all_customers(){
        $this->db->select('*');
        $this->db->from('tbl_customer');
        $this->db->order_by('time_stamp','asc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_customer_by_id($customer_id){
        $this->db->select('*');
        $this->db->from('tbl_customer');
        $this->db->where('customer_id',$customer_id);
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }
    
    
    public function add_customer($data){
        $this->db->insert('tbl_customer',$data);
        $result = $this->db->insert_id();
        return $result;
    }
   
    public function update_customer($data,$customer_id){
        
        $this->db->where('customer_id',$customer_id);
        $this->db->update('tbl_customer',$data);
    }
   
    public function delete_customer($customer_id){
        $this->db->where('customer_id',$customer_id);
        $this->db->delete('tbl_customer');
    }





}?>
