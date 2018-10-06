<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Stock_Transfer_Model extends CI_Model {

    public function get_all_stock_transfers(){
        $this->db->select('*');
        $this->db->from('tbl_stock_transfer');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_sent_stock_transfer_data_by_date_and_warehouse_id($warehouse_id,$from_date,$to_date){
        $this->db->select('tbl_stock_transfer_detail.item_id, tbl_stock_transfer_detail.item_name, sum(tbl_stock_transfer_detail.quantity) as total_sent_quantity');
        $this->db->from('tbl_stock_transfer_detail');
        $this->db->where('DATE(tbl_stock_transfer.stock_transfer_date) >=',$from_date);
        $this->db->where('DATE(tbl_stock_transfer.stock_transfer_date) <=',$to_date);
        $this->db->where('tbl_stock_transfer_detail.previous_warehouse_id',$warehouse_id);
        $this->db->join('tbl_stock_transfer','tbl_stock_transfer.stock_transfer_id = tbl_stock_transfer_detail.stock_transfer_id');
        $this->db->group_by('tbl_stock_transfer_detail.item_id');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_received_stock_transfer_data_by_date_and_warehouse_id($warehouse_id,$from_date,$to_date){
        $this->db->select('tbl_stock_transfer_detail.item_id, tbl_stock_transfer_detail.item_name, sum(tbl_stock_transfer_detail.quantity) as total_received_quantity');
        $this->db->from('tbl_stock_transfer_detail');
        $this->db->where('DATE(tbl_stock_transfer.stock_transfer_date) >=',$from_date);
        $this->db->where('DATE(tbl_stock_transfer.stock_transfer_date) <=',$to_date);
        $this->db->where('tbl_stock_transfer_detail.current_warehouse_id',$warehouse_id);
        $this->db->join('tbl_stock_transfer','tbl_stock_transfer.stock_transfer_id = tbl_stock_transfer_detail.stock_transfer_id');
        $this->db->group_by('tbl_stock_transfer_detail.item_id');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }
    public function get_stock_transfer_by_id($stock_transfer_id){
        $this->db->select('*');
        $this->db->from('tbl_stock_transfer');
        $this->db->where('stock_transfer_id',$stock_transfer_id);
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }

    public function get_stock_transfer_like_id($stock_transfer_id){
        $this->db->select('stock_transfer_id');
        $this->db->like('stock_transfer_id', $stock_transfer_id);
        $query = $this->db->get('tbl_stock_transfer');
        if($query->num_rows() > 0){
          foreach ($query->result_array() as $row){
            $row_set[] = htmlentities(stripslashes($row['stock_transfer_id'])); //build an array
          }
          echo json_encode($row_set); //format the array into json data
        }
    }

    
    public function get_stock_transfer_detail_by_transfer_id($stock_transfer_id){
        $this->db->select('*');
        $this->db->from('tbl_stock_transfer_detail');
        $this->db->where('stock_transfer_id', $stock_transfer_id);
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }
    
    public function add_stock_transfer($data){
        $this->db->insert('tbl_stock_transfer',$data);
        $result = $this->db->insert_id();
        return $result;
    }
   
    public function update_stock_transfer($data,$stock_transfer_id){
        
        $this->db->where('stock_transfer_id',$stock_transfer_id);
        $this->db->update('tbl_stock_transfer',$data);
    }
   
    public function delete_stock_transfer($stock_transfer_id){
        $this->db->where('stock_transfer_id',$stock_transfer_id);
        $this->db->delete('tbl_stock_transfer');
    }

//---stock_transfer DETAIL SECTION START HERE----------------

    public function get_all_stock_transfer_details(){
        $this->db->select('*');
        $this->db->from('tbl_stock_transfer_detail');
        $this->db->order_by('time_stamp','asc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_stock_transfer_detail_by_item_id($item_id){
        $this->db->select('*');
        $this->db->from('tbl_stock_transfer_detail');
        $this->db->where('item_id',$item_id);
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_stock_transfer_details_by_id($stock_transfer_id){
        $this->db->select('*');
        $this->db->from('tbl_stock_transfer_detail');
        $this->db->where('stock_transfer_id',$stock_transfer_id);
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_stock_transfer_details_by_stock_transfer_id_and_item_id($stock_transfer_id,$item_id){
        $this->db->select('*');
        $this->db->from('tbl_stock_transfer_detail');
        $this->db->where('stock_transfer_id',$stock_transfer_id);
        $this->db->where('item_id',$item_id);
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function add_stock_transfer_detail($data){
        $this->db->insert('tbl_stock_transfer_detail',$data);
        $result = $this->db->insert_id();
        return $result;
    }
   
    public function update_stock_transfer_detail($data,$stock_transfer_detail_id){
        
        $this->db->where('stock_transfer_id',$stock_transfer_detail_id);
        $this->db->update('tbl_stock_transfer_detail',$data);
    }
   
    public function delete_stock_transfer_detail($stock_transfer_id){
        $this->db->where('stock_transfer_id',$stock_transfer_id);
        $this->db->delete('tbl_stock_transfer_detail');
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
