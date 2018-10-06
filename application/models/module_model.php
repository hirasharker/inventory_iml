<?php
class Module_Model extends CI_Model{
    
    
  public function get_all_modules(){
    $this->db->select('*');
    $this->db->from('tbl_modules');
    $this->db->order_by('timestamp');
    $result_query = $this->db->get();
    $result = $result_query->result();
    return $result;
  }

  public function add_module_permission($data){
    $this->db->insert('tbl_permission',$data);
  }

  public function get_permission_by_user_id($user_id){
    $this->db->select('tbl_permission.*,tbl_modules.module_type');
    $this->db->from('tbl_permission');
    $this->db->where('tbl_permission.user_id',$user_id);
    $this->db->join('tbl_modules','tbl_modules.module_id = tbl_permission.module_id');
    $this->db->order_by('tbl_modules.module_id');
    $result_query = $this->db->get();
    $result = $result_query->result();
    return $result;   
  }
  
  public function get_permission_by_module_id_and_user_id($module_id,$user_id){
    $this->db->select('*');
    $this->db->from('tbl_permission');
    $this->db->where('user_id',$user_id);
    $this->db->where('module_id',$module_id);
    $this->db->order_by('module_id');
    $result_query = $this->db->get();
    $result = $result_query->row();
    return $result;   
  }

  public function update_module_permission($module_permission,$permission_id){
    $this->db->where('permission_id',$permission_id);
    $this->db->update('tbl_permission',$module_permission);
  }

  public function count_module_data(){
    $this->db->select('module_id');
    $this->db->from('tbl_modules');
    $result_query = $this->db->get();
    $result = $result_query->num_rows();
    return $result;
  }

    



}




?>
