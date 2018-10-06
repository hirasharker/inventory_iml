<?php
class Login_Model extends CI_Model{
    
    
public function check_user($user_name,$password){
    
    $this->db->select('*');
    $this->db->from('tbl_user');
    $this->db->where('user_name',$user_name);
    $this->db->where('password',$password);
    $result_query=$this->db->get();
    $result=$result_query->row();
    return $result;
}    
public function find_user_by_id($user_id){
    $this->db->select('*');
    $this->db->from('tbl_user');
    $this->db->where('user_id',$user_id);
    $result_query=$this->db->get();
    $result=$result_query->row();
    return $result;
}

public function update_user_info($user_id,$admin_data){
    $this->db->where('user_id',$user_id);
    $this->db->update('tbl_user',$admin_data);
}

public function add_user_info($data){
    
    $this->db->insert('tbl_user',$data);
}

public function find_all_users(){
    $this->db->select('*');
    $this->db->from('tbl_user');
    $result_query=$this->db->get();
    $result=$result_query->result();
    return $result;
}
public function update_all_users(){
    $this->db->update('user_name');
    $data = array(
   array(
      'title' => 'My title' ,
      'name' => 'My Name 2' ,
      'date' => 'My date 2'
   ),
   array(
      'title' => 'Another title' ,
      'name' => 'Another Name 2' ,
      'date' => 'Another date 2'
   )
);
}
    
}




?>
