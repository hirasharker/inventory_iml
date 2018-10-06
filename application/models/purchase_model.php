<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Purchase_Model extends CI_Model {


    public function get_all_purchases(){
        $this->db->select('tbl_purchase.purchase_id, tbl_purchase.purchase_discount, tbl_purchase.vendor_id, tbl_purchase.vendor_name,tbl_purchase.user_id, tbl_purchase.user_name
            , tbl_purchase.purchase_date, GROUP_CONCAT(tbl_purchase_detail.item_name SEPARATOR ",") as item_name
            , sum(tbl_purchase_detail.purchase_price * tbl_purchase_detail.quantity)*(1-.01*tbl_purchase_detail.purchase_discount) as total_price'); 
        $this->db->from('tbl_purchase');
        $this->db->join('tbl_purchase_detail','tbl_purchase_detail.purchase_id = tbl_purchase.purchase_id');
        $this->db->group_by('tbl_purchase_detail.purchase_id');
        $this->db->order_by('tbl_purchase.time_stamp','desc');
        $this->db->order_by('tbl_purchase.vendor_name','desc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_purchase_by_id($purchase_id){
        $this->db->select('*');
        $this->db->from('tbl_purchase');
        $this->db->where('purchase_id',$purchase_id);
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }

    public function get_purchase_like_id($purchase_id){
        $this->db->select('purchase_id');
        $this->db->like('purchase_id', $purchase_id);
        $query = $this->db->get('tbl_purchase');
        if($query->num_rows() > 0){
          foreach ($query->result_array() as $row){
            $row_set[] = htmlentities(stripslashes($row['purchase_id'])); //build an array
          }
          echo json_encode($row_set); //format the array into json data
        }
    }
    
    public function add_purchase($data){
        $this->db->insert('tbl_purchase',$data);
        $result = $this->db->insert_id();
        return $result;
    }
   
    public function update_purchase($data,$purchase_id){
        
        $this->db->where('purchase_id',$purchase_id);
        $this->db->update('tbl_purchase',$data);
    }
   
    public function delete_purchase($purchase_id){
        $this->db->where('purchase_id',$purchase_id);
        $this->db->delete('tbl_purchase');
    }

//---purchase DETAIL SECTION START HERE----------------

    public function get_all_purchase_details(){
        $this->db->select('*');
        $this->db->from('tbl_purchase_detail');
        $this->db->order_by('time_stamp','asc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_purchase_detail_by_item_id($item_id){
        $this->db->select('*');
        $this->db->from('tbl_purchase_detail');
        $this->db->where('item_id',$item_id);
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_purchase_details_by_id($purchase_id){
        $this->db->select('*');
        $this->db->from('tbl_purchase_detail');
        $this->db->where('purchase_id',$purchase_id);
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_purchase_details_by_purchase_id_and_item_id($purchase_id,$item_id){
        $this->db->select('*');
        $this->db->from('tbl_purchase_detail');
        $this->db->where('purchase_id',$purchase_id);
        $this->db->where('item_id',$item_id);
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function add_purchase_detail($data){
        $this->db->insert('tbl_purchase_detail',$data);
        $result = $this->db->insert_id();
        return $result;
    }
   
    public function update_purchase_detail($data,$purchase_detail_id){
        
        $this->db->where('purchase_id',$purchase_detail_id);
        $this->db->update('tbl_purchase_detail',$data);
    }
   
    public function delete_purchase_detail($purchase_id){
        $this->db->where('purchase_id',$purchase_id);
        $this->db->delete('tbl_purchase_detail');
    }


    /////----VENDOR SECTION START HERE...................

    public function get_all_vendors(){
        $this->db->select('*');
        $this->db->from('tbl_vendor');
        $this->db->order_by('time_stamp','asc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_vendor_by_id($vendor_id){
        $this->db->select('*');
        $this->db->from('tbl_vendor');
        $this->db->where('vendor_id',$vendor_id);
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }
    
    
    public function add_vendor($data){
        $this->db->insert('tbl_vendor',$data);
        $result = $this->db->insert_id();
        return $result;
    }
   
    public function update_vendor($data,$vendor_id){
        
        $this->db->where('vendor_id',$vendor_id);
        $this->db->update('tbl_vendor',$data);
    }
   
    public function delete_vendor($vendor_id){
        $this->db->where('vendor_id',$vendor_id);
        $this->db->delete('tbl_vendor');
    }

    ////----VENDOR SECTION ENDS HERE-----
    
}
?>
