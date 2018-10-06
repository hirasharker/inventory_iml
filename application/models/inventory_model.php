<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Inventory_Model extends CI_Model {

    public function get_sales_by_item_id_and_date($item_id,$from_date,$to_date){
        $this->db->select('tbl_sales_detail.*,tbl_customer.customer_name');
        $this->db->from('tbl_sales_detail');
        $this->db->where('item_id',$item_id);
        $this->db->where('DATE(sales_date) >=',$from_date);
        $this->db->where('DATE(sales_date) <=',$to_date);
        $this->db->join('tbl_customer','tbl_customer.customer_id = tbl_sales_detail.customer_id');
        $this->db->order_by('tbl_sales_detail.time_stamp','asc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_purchase_by_item_id_and_date($item_id,$from_date,$to_date){
        $this->db->select('*');
        $this->db->from('tbl_purchase_detail');
        $this->db->where('item_id',$item_id);
        $this->db->where('DATE(purchase_date) >=',$from_date);
        $this->db->where('DATE(purchase_date) <=',$to_date);
        $this->db->order_by('tbl_purchase_detail.time_stamp','asc');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_item_purchase_quantity_by_item_id_and_date($item_id,$to_date){
        $this->db->select('sum(quantity) as purchase_quantity, sum(quantity*purchase_price)/sum(quantity) as item_rate, sum(purchase_price*quantity) as stock_value ');
        $this->db->from('tbl_purchase_detail');
        $this->db->where('item_id',$item_id);
        $this->db->where('purchase_date <=',$to_date);
        $this->db->group_by('item_id');
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }
    
    public function get_opening_item_purchase_quantity_by_item_id_and_date($item_id,$from_date){
        $this->db->select('sum(quantity) as purchase_quantity, sum(quantity*purchase_price)/sum(quantity) as item_rate, sum(purchase_price*quantity) as stock_value ');
        $this->db->from('tbl_purchase_detail');
        $this->db->where('item_id',$item_id);
        $this->db->where('purchase_date <',$from_date);
        $this->db->group_by('item_id');
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }

    public function get_opening_item_sales_quantity_by_item_id_and_date($item_id,$from_date){
        $this->db->select('sum(quantity) as sales_quantity');
        $this->db->from('tbl_sales_detail');
        $this->db->where('item_id',$item_id);
        $this->db->where('sales_date <',$from_date);
        $this->db->group_by('item_id');
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }


    public function get_item_sales_quantity_by_item_id_and_date($item_id,$to_date){
        $this->db->select('sum(quantity) as sales_quantity');
        $this->db->from('tbl_sales_detail');
        $this->db->where('item_id',$item_id);
        $this->db->where('sales_date <=',$to_date);
        $this->db->group_by('item_id');
        $result_query=$this->db->get();
        $result=$result_query->row();
        return $result;
    }



    //---------GROUP INVENTORY----------------
    
   
    public function get_group_purchase_inventory_data_by_date($from_date,$to_date){
        $this->db->distinct();
        $this->db->select('coalesce(sum(distinct(tbl_purchase_detail.quantity)),0) as purchase_quantity
            ,coalesce(sum(purchase_price*tbl_purchase_detail.quantity)/sum(tbl_purchase_detail.quantity),0) as item_rate
            ,tbl_purchase_detail.item_name, tbl_purchase_detail.item_id');
        $this->db->from('tbl_purchase_detail');
        $this->db->group_by('tbl_purchase_detail.item_id');
        $this->db->where('tbl_purchase_detail.purchase_date >=',$from_date);
        $this->db->where('tbl_purchase_detail.purchase_date <=',$to_date);

        $result_query = $this->db->get();
        $result = $result_query->result();
        return $result;
    }

    public function get_group_sales_inventory_data_by_date($from_date,$to_date){
        $this->db->distinct();
        $this->db->select('coalesce(sum(distinct(tbl_sales_detail.quantity)),0) as sales_quantity
            ,tbl_sales_detail.item_name, tbl_sales_detail.item_id');
        $this->db->from('tbl_sales_detail');
        $this->db->group_by('tbl_sales_detail.item_id');
        $this->db->where('tbl_sales_detail.sales_date >=',$from_date);
        $this->db->where('tbl_sales_detail.sales_date <=',$to_date);

        $result_query = $this->db->get();
        $result = $result_query->result();
        return $result;
    }

    public function get_purchase_quantity_by_date($to_date){
        $this->db->select('sum(distinct(tbl_purchase_detail.quantity)) as total_purchase_quantity, tbl_purchase_detail.item_id');
        $this->db->from('tbl_purchase_detail');
        $this->db->group_by('tbl_purchase_detail.item_id');
        $this->db->where('tbl_purchase_detail.purchase_date <=',$to_date);
        $this->db->group_by('tbl_purchase_detail.item_id');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    public function get_sales_quantity_by_date($to_date){
        $this->db->select('sum(distinct(tbl_sales_detail.quantity)) as total_sales_quantity, tbl_sales_detail.item_id');
        $this->db->from('tbl_sales_detail');
        $this->db->group_by('tbl_sales_detail.item_id');
        $this->db->where('tbl_sales_detail.sales_date <=',$to_date);
        $this->db->group_by('tbl_sales_detail.item_id');
        $result_query=$this->db->get();
        $result=$result_query->result();
        return $result;
    }

    //--------warehouse_inventory SECTION -------------------------
    public function get_group_purchase_inventory_data_by_date_and_warehouse_id($warehouse_id,$from_date,$to_date){
        $this->db->distinct();
        $this->db->select('coalesce(sum(distinct(tbl_purchase_detail.quantity)),0) as purchase_quantity
            ,coalesce(sum(purchase_price*tbl_purchase_detail.quantity)/sum(tbl_purchase_detail.quantity),0) as item_rate
            ,tbl_purchase_detail.item_name, tbl_purchase_detail.item_id');
        $this->db->from('tbl_purchase_detail');
        $this->db->group_by('tbl_purchase_detail.item_id');

        if($warehouse_id != ''){
            $this->db->where('tbl_purchase_detail.warehouse_id',$warehouse_id);
        }
        $this->db->where('tbl_purchase_detail.purchase_date >=',$from_date);
        $this->db->where('tbl_purchase_detail.purchase_date <=',$to_date);

        $result_query = $this->db->get();
        $result = $result_query->result();
        return $result;
    }

    public function get_group_sales_inventory_data_by_date_and_warehouse_id($warehouse_id, $from_date,$to_date){
        $this->db->distinct();
        $this->db->select('coalesce(sum(distinct(tbl_sales_detail.quantity)),0) as sales_quantity
            ,tbl_sales_detail.item_name, tbl_sales_detail.item_id');
        $this->db->from('tbl_sales_detail');
        $this->db->group_by('tbl_sales_detail.item_id');

        if($warehouse_id != ''){
            $this->db->where('tbl_sales_detail.warehouse_id',$warehouse_id);
        }

        $this->db->where('tbl_sales_detail.sales_date >=',$from_date);
        $this->db->where('tbl_sales_detail.sales_date <=',$to_date);

        $result_query = $this->db->get();
        $result = $result_query->result();
        return $result;
    }


}
?>
