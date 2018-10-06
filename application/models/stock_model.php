<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Stock_Model extends CI_Model {

    public function get_all_stocks(){
        $this->db->select('*');
        $this->db->from('tbl_stock');
        $this->db->order_by('time_stamp','asc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function add_stock_quantity($item_id, $warehouse_id, $quantity){
        $this->db->where('item_id',$item_id);
        $this->db->where('warehouse_id',$warehouse_id);
        $this->db->set('quantity','quantity+'.$quantity,FALSE);
        $this->db->update('tbl_stock');
    }

    public function subtract_stock_quantity($item_id, $warehouse_id, $quantity){
        $this->db->where('item_id',$item_id);
        $this->db->where('warehouse_id',$warehouse_id);
        $this->db->set('quantity','quantity-'.$quantity,FALSE);
        $this->db->update('tbl_stock');
    }

    public function add_broken_stock_quantity($item_id, $warehouse_id, $quantity){
        $this->db->where('item_id',$item_id);
        $this->db->where('warehouse_id',$warehouse_id);
        $this->db->set('broken_quantity','broken_quantity+'.$quantity,FALSE);
        $this->db->update('tbl_stock');
    }

    public function get_stock_by_item_and_warehouse_id($item_id, $warehouse_id){
        $this->db->select('*');
        $this->db->where('item_id',$item_id);
        $this->db->where('warehouse_id',$warehouse_id);
        $this->db->from('tbl_stock');
        $result_query   =   $this->db->get();
        $result         =   $result_query->row();
        return $result;
    }

    public function get_stock_by_id($stock_id){
        $this->db->select('*');
        $this->db->from('tbl_stock');
        $this->db->where('stock_id',$stock_id);
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }

    public function get_item_by_warehouse_id($warehouse_id){
        $this->db->select('tbl_stock.*,tbl_item.part_no, tbl_item.item_price');
        $this->db->from('tbl_stock');
        $this->db->join('tbl_item','tbl_item.item_id = tbl_stock.item_id');
        $this->db->where('tbl_stock.warehouse_id',$warehouse_id);
        $this->db->where('tbl_stock.quantity !=',0);
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }
    
    
    public function add_stock($data){
        
        $this->db->insert('tbl_stock',$data);
        $result=$this->db->insert_id();
        return $result;
    }
   
    public function update_stock($data,$stock_id){
        
        $this->db->where('stock_id',$stock_id);
        $this->db->update('tbl_stock',$data);
    }
   
    public function delete_stock($stock_id){
        $this->db->where('stock_id',$stock_id);
        $this->db->delete('tbl_stock');
    }

    //---------------- Warehouse Inventory Model Section ---------------------------
    public function get_all_items_by_warehouse_id($warehouse_id){
        $this->db->select('tbl_item.*,tbl_stock.quantity as stock_quantity, tbl_stock.broken_quantity');
        $this->db->from('tbl_stock');
        $this->db->join('tbl_item','tbl_item.item_id = tbl_stock.item_id');
        if($warehouse_id != ''){
           $this->db->where('tbl_stock.warehouse_id',$warehouse_id); 
        }
        // $this->db->where('tbl_stock.quantity !=',0);
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }
}
?>
