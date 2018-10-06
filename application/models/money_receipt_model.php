<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Money_Receipt_Model extends CI_Model {
    //------Money Receipt------------------

    public function get_all_money_receipts(){
        $this->db->select('*');
        $this->db->from('tbl_money_receipt');
        $this->db->order_by('time_stamp','desc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_all_money_receipts_by_date_and_customer_id_or_dealer_id($customer_id, $dealer_id,$from_date,$to_date){
        $this->db->select('*');
        $this->db->from('tbl_money_receipt');
        $this->db->where('money_receipt_date >=',$from_date);
        $this->db->where('money_receipt_date <=',$to_date);
        if($customer_id != ""){
            $this->db->where('customer_id',$customer_id); 
        }
        if($dealer_id != ""){
            $this->db->where('dealer_id',$dealer_id);
        }
        $this->db->order_by('time_stamp','desc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_individual_money_receipt_by_date_and_customer_id($customer_id,$from_date,$to_date){
        $this->db->select('*');
        $this->db->from('tbl_money_receipt');
        $this->db->where('money_receipt_date >=',$from_date);
        $this->db->where('money_receipt_date <=',$to_date);
        $this->db->where('customer_id',$customer_id);
        $this->db->order_by('time_stamp','desc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_individual_money_receipt_by_date_and_dealer_id($dealer_id,$from_date,$to_date){
        $this->db->select('*');
        $this->db->from('tbl_money_receipt');
        $this->db->where('money_receipt_date >=',$from_date);
        $this->db->where('money_receipt_date <=',$to_date);
        $this->db->where('dealer_id',$dealer_id);
        $this->db->order_by('time_stamp','desc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_all_money_receipts_by_date($from_date,$to_date){
        $this->db->select('*');
        $this->db->from('tbl_money_receipt');
        $this->db->where('money_receipt_date >=',$from_date);
        $this->db->where('money_receipt_date <=',$to_date);
        $this->db->order_by('time_stamp','desc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_money_receipt_by_id($money_receipt_id){
        $this->db->select('tbl_money_receipt.*,tbl_sales.sales_date, tbl_sales_order.sales_order_date');
        $this->db->from('tbl_money_receipt');
        $this->db->join('tbl_sales','tbl_money_receipt.sales_id = tbl_sales.sales_id','left');
        $this->db->join('tbl_sales_order','tbl_money_receipt.sales_order_id = tbl_sales_order.sales_order_id','left');
        $this->db->where('money_receipt_id',$money_receipt_id);
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }

    public function add_money_receipt($data){
        $this->db->insert('tbl_money_receipt',$data);
        $result = $this->db->insert_id();
        return $result;
    }
   
    public function update_money_receipt($data,$money_receipt_id){
        $this->db->where('money_receipt_id',$money_receipt_id);
        $this->db->update('tbl_money_receipt',$data);
    }
   
    public function delete_money_receipt($money_receipt_id){
        $this->db->where('money_receipt_id',$money_receipt_id);
        $this->db->delete('tbl_money_receipt');
    }
}
?>
