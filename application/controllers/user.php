<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('user_id')==NULL){
			redirect('login','refresh');
		}
		$this->load->model('user_model','user_model',TRUE);
		$this->load->model('company_model','company_model',TRUE);
		$this->load->model('module_model','module_model',TRUE);
	}


	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index($user_id=0)
	{
		$data						=	array();
		$data['page_title']			=	"User";

		$nav_data					=	array();
		$nav_data['dev_key']		=	"user";
		$nav_data['selected']		=	"add_user";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));


		$user_data					=	array();

		if($user_id!=0){
			$user_data['result']	=	$this->user_model->get_user_by_id($user_id);
		}else{
			$user_data['result']	=	NULL;
		}
		

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/user',$user_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}
	public function add_user()
	{
		$user_data					=	array();
		$user_data['user_name']		=	$this->input->post('user_name',TRUE);
		$user_data['password']		=	md5($this->input->post('password',TRUE));
		$user_data['email_address']	=	$this->input->post('email_address',TRUE);
		$user_data['phone']			=	$this->input->post('phone_no',TRUE);
		$user_data['user_type']		=	$this->input->post('user_type',TRUE);

		$result						=	$this->user_model->add_user($user_data);

		$modules 					=	$this->module_model->get_all_modules();

		$module_permission 			=	array();

		foreach ($modules as $value) {

			$module_permission['module_id'] 		=	$value->module_id;
			$module_permission['module_name']		=	$value->module_name;
			$module_permission['user_id']			=	$result;
			$module_permission['user_name']			=	$user_data['user_name'];
			$module_permission['admin_id']			=	$this->session->userdata('user_id');
			$module_permission['admin_name']		=	$this->session->userdata('user_name');
			

			if($user_data['user_type']==1){
				$module_permission['permission_allow']	=	1;
				$module_permission['permission_view']	=	1;
				$module_permission['permission_add']	=	1;
				$module_permission['permission_edit']	=	1;
				$module_permission['permission_delete']	=	1;
			}else{
				$module_permission['permission_allow']	=	0;
				$module_permission['permission_view']	=	0;
				$module_permission['permission_add']	=	0;
				$module_permission['permission_edit']	=	0;
				$module_permission['permission_delete']	=	0;
			}
			$this->module_model->add_module_permission($module_permission);
		}
		
		redirect('user/view_users','refresh');
	}
	public function update_user($user_id)
	{
		$user_data					=	array();
		$user_data['user_name']		=	$this->input->post('user_name',TRUE);
		$user_data['password']		=	md5($this->input->post('password',TRUE));
		$user_data['email_address']	=	$this->input->post('email_address',TRUE);
		$user_data['phone']			=	$this->input->post('phone_no',TRUE);
		$user_data['user_type']		=	$this->input->post('user_type',TRUE);

		$permission_result 			=	$this->module_model->get_permission_by_user_id($user_id);

		foreach($permission_result as $value){

			$module_permission 		=	array();

			if($user_data['user_type']==1){
				$module_permission['permission_allow']	=	1;
				$module_permission['permission_view']	=	1;
				$module_permission['permission_add']	=	1;
				$module_permission['permission_edit']	=	1;
				$module_permission['permission_delete']	=	1;
			}else{
				$module_permission['permission_allow']	=	0;
				$module_permission['permission_view']	=	0;
				$module_permission['permission_add']	=	0;
				$module_permission['permission_edit']	=	0;
				$module_permission['permission_delete']	=	0;
			}
			$this->module_model->update_module_permission($module_permission,$value->permission_id);

		}

		$this->user_model->update_user($user_data , $user_id);

		redirect('user/view_users','refresh');
	}

	public function view_users()
	{
		$data						=	array();
		$data['page_title']			=	"Group";
		$nav_data['dev_key']		=	"group";
		$nav_data['selected']		=	"all_groups";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$user_data					=	array();
		$user_data['result']		=	$this->user_model->get_all_users();

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/user_list',$user_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}
	public function delete_user($user_id)
	{

		$this->user_model->delete_user($user_id);


		redirect('user/view_users','refresh');
	}

	public function permission($user_id){
		$data						=	array();
		$data['page_title']			=	"User";

		$nav_data					=	array();
		$nav_data['dev_key']		=	"user";
		$nav_data['selected']		=	"add_user";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$user_data					=	array();

		if($user_id!=0){
			$user_data['result']	=	$this->user_model->get_user_by_id($user_id);
			$user_data['permission']=	$this->module_model->get_permission_by_user_id($user_id);
		}else{
			$user_data['result']	=	NULL;
		}
		// $user_data['modules'] 		= 	$this->module_model->get_all_modules();
		

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/permission',$user_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function update_user_allow_permission(){

		$permission_data	=	array();

		$permission_id 		=	$this->input->post('permission_id',TRUE);
		$permission_data['permission_allow'] 		=	$this->input->post('checked_value',TRUE);

		$this->module_model->update_module_permission($permission_data,$permission_id);

		$output 						=	'permision changed!'.'<br/>';

        echo json_encode($output);

	}

	public function update_user_view_permission(){

		$permission_data	=	array();

		$permission_id 		=	$this->input->post('permission_id',TRUE);
		$checked_value		=	$this->input->post('checked_value',TRUE);

		$permission_data['permission_view'] 		=	$checked_value;
		// $permission_data['permission_add']			=	0;
		$permission_data['permission_edit']			=	0;
		$permission_data['permission_delete']		=	0;

		$this->module_model->update_module_permission($permission_data,$permission_id);

		$output 						=	'permision changed!'.'<br/>';

        echo json_encode($output);

	}
	public function update_user_add_permission(){

		$permission_data	=	array();

		$permission_id 		=	$this->input->post('permission_id',TRUE);
		$checked_value		=	$this->input->post('checked_value',TRUE);

		$permission_data['permission_add'] 		=	$checked_value;
		
		$this->module_model->update_module_permission($permission_data,$permission_id);

		$output 						=	'permision changed!'.'<br/>';

        echo json_encode($output);

	}
	public function update_user_edit_permission(){

		$permission_data	=	array();

		$permission_id 		=	$this->input->post('permission_id',TRUE);
		$checked_value		=	$this->input->post('checked_value',TRUE);

		$permission_data['permission_edit'] 		=	$checked_value;

		if($checked_value==1){
			$permission_data['permission_view'] 		=	1;
		}

		$this->module_model->update_module_permission($permission_data,$permission_id);

		$output 						=	'permision changed!'.'<br/>';

        echo json_encode($output);

	}
	public function update_user_delete_permission(){

		$permission_data	=	array();

		$permission_id 		=	$this->input->post('permission_id',TRUE);
		$checked_value		=	$this->input->post('checked_value',TRUE);

		$permission_data['permission_delete'] 		=	$checked_value;

		if($checked_value==1){
			$permission_data['permission_view'] 		=	1;
		}

		$this->module_model->update_module_permission($permission_data,$permission_id);

		$output 						=	'permision changed!'.'<br/>';

        echo json_encode($output);

	}


	
		
}
