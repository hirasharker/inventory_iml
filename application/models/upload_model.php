
<?php  class Upload_Model extends CI_Model {

public function upload_file($type,$path){
    $this->load->library('upload');
    $config['upload_path']='./'.$path.'/';
    $config['allowed_types']='gif|jpg|png|pdf|csv';
    $config['max_size']='500000';
    $config['max_width']='3000';
    $config['max_height']='3000';
    if($type=='purchase_list'){
        $config['overwrite']=TRUE;
    }

    $this->upload->initialize($config);
    unset($config);
    // $this->load->library('upload', $config);

    if(!$this->upload->do_upload($type)){
            return $upload_error[] = array('error' => $this->upload->display_errors());
        // echo 'upload failed';exit();
    } else {
        $udata                  =   array('u_data' => $this->upload->data());
        $full_path              =   $udata['u_data']['full_path'];
        $file_name              =   $udata['u_data']['file_name'];
        
        $file_upload  =array();

        $file_upload['file_name'] = $file_name;
        return $file_upload;
    } // END  if(!$this->upload->do_upload){
        
}//upload_file



}?>