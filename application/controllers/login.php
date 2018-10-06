<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
  public function __construct()
  {
          parent::__construct();
          $this->load->model('login_model','l_model',TRUE);
          if($this->session->userdata('user_id')!=NULL){
            redirect('dashboard','refresh');
          }
          $this->load->model('company_model','company_model',TRUE);
  }

  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   *    http://example.com/index.php/welcome
   *  - or -
   *    http://example.com/index.php/welcome/index
   *  - or -
   * Since this controller is set as the default controller in
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/welcome/<method_name>
   * @see https://codeigniter.com/user_guide/general/urls.html
   */
  public function index()
  {
    $login_data       =   array();
    $login_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
    $this->load->view('login',$login_data);
  }

  public function check_user(){
    $user_name=$this->input->post('user_name','',TRUE);
    // $password=md5($this->input->post('password','',TRUE));
    $password=md5($this->input->post('password','',TRUE));

    $result=$this->l_model->check_user($user_name,$password);
    
    $sdata=array();

    if(!$result){
      $sdata['error']= 'Please type correct user name and password';
      $this->session->set_userdata($sdata);
      redirect('login','refresh');
    } else {
      $sdata['user_id']=$result->user_id;
      $sdata['user_name']= $result->user_name;
      $sdata['user_type']=$result->user_type;
      $this->session->set_userdata($sdata);
      redirect('dashboard','refresh');
    }
  }
  public function log_out(){
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_name');
        session_destroy();
       
        redirect('login','refresh');
    }

}
