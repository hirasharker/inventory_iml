<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Item_Model extends CI_Model {

    public function get_all_items(){
        $this->db->select('*');
        $this->db->from('tbl_item');
        $this->db->order_by('time_stamp','asc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_item_by_parent_id($group_id){
        $this->db->select('*');
        $this->db->where('group_id',$group_id);
        $this->db->from('tbl_item');
        $result_query = $this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_item_by_id($item_id){
        $this->db->select('*');
        $this->db->from('tbl_item');
        $this->db->where('item_id',$item_id);
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }

    public function get_item_by_warehouse_id($warehouse_id){
        $this->db->select('*');
        $this->db->from('tbl_item');
        $this->db->where('warehouse_id',$warehouse_id);
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }
    
    public function add_item($data){
        
        $this->db->insert('tbl_item',$data);
        $result=$this->db->insert_id();
        return $result;
    }
   
    public function update_item($data,$item_id){
        
        $this->db->where('item_id',$item_id);
        $this->db->update('tbl_item',$data);
    }

    public function add_item_quantity($item_id,$quantity){
        $this->db->where('item_id',$item_id);
        $this->db->set('quantity','quantity+'.$quantity,FALSE);
        $this->db->update('tbl_item');
    }

    public function subtract_item_quantity($item_id,$quantity){
        $this->db->where('item_id',$item_id);
        $this->db->set('quantity','quantity-'.$quantity,FALSE);
        $this->db->update('tbl_item');
    }

    public function add_broken_item_quantity($item_id, $quantity){
        $this->db->where('item_id',$item_id);
        $this->db->set('broken_quantity','broken_quantity+'.$quantity,FALSE);
        $this->db->update('tbl_item');
    }
   
    public function delete_item($item_id){
        $this->db->where('item_id',$item_id);
        $this->db->delete('tbl_item');
    }

    public function get_item_like_name_id($search_key){
        $this->db->select('item_name');
        $this->db->like('item_name', $search_key);
        $this->db->or_like('item_id', $search_key);
        $query = $this->db->get('tbl_item');
        if($query->num_rows() > 0){
          foreach ($query->result_array() as $row){
            $row_set[] = htmlentities(stripslashes($row['item_name'])); //build an array
          }
          echo json_encode($row_set); //format the array into json data
        }
    }
    
}
?>
