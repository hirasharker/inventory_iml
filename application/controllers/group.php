<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Group extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('user_id')==NULL){
			redirect('login','refresh');
		}
		$this->load->model('group_model','group_model',TRUE);
		$this->load->model('company_model','company_model',TRUE);
		$this->load->model('item_model','item_model',TRUE);
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
	public function index($group_id=0)
	{
		$data						=	array();
		$data['page_title']			=	"Group";

		$nav_data					=	array();
		$nav_data['dev_key']		=	"group";
		$nav_data['selected']		=	"add_group";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$group_data					=	array();
		$group_data['group_list']	=	$this->group_model->get_all_groups();

		if($group_id!=0)
		{
			$group_data['group']	=	$this->group_model->get_group_by_id($group_id);
		}else{
			$group_data['group']	=	NULL;
		}

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/group',$group_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}
	public function view_groups()
	{
		$data						=	array();
		$data['page_title']			=	"Group";
		$nav_data['dev_key']		=	"group";
		$nav_data['selected']		=	"all_groups";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$group_data					=	array();
		$group_data['group_list']	=	$this->group_model->get_all_groups();
		$group_data['permission']	= 	$this->module_model->get_permission_by_module_id_and_user_id(1,$this->session->userdata('user_id'));

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/group_list',$group_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}
	public function add_group()
	{
		$group_data					=	array();
		$group_data['user_id']		=	$this->session->userdata('user_id');
		$group_data['user_name']	=	$this->session->userdata('user_name');
		$group_data['group_name']	=	$this->input->post('group_name','',TRUE);
		$group_data['parent_id']	=	$this->input->post('parent_id','',TRUE);
		if($group_data['parent_id']!=0){
			$group_data['parent_group']	=	$this->group_model->get_group_by_id($group_data['parent_id'])->group_name;
		}
		$group_data['description']	=	$this->input->post('description','',TRUE);

		$result						=	$this->group_model->add_group($group_data);

		redirect('group/view_groups','refresh');
	}

	public function update_group($group_id)
	{
		$group_data					=	array();
		$group_data['user_id']		=	$this->session->userdata('user_id');
		$group_data['user_name']	=	$this->session->userdata('user_name');
		$group_data['group_name']	=	$this->input->post('group_name','',TRUE);
		$group_data['parent_id']	=	$this->input->post('parent_id','',TRUE);
		if($group_data['parent_id']!=0){
			$group_data['parent_group']	=	$this->group_model->get_group_by_id($group_data['parent_id'])->group_name;
		}else{
			$group_data['parent_group']	=	NULL;
		}
		$group_data['description']	=	$this->input->post('description','',TRUE);

		$result						=	$this->group_model->update_group($group_data,$group_id);

		redirect('group/view_groups','refresh');
	}
	public function delete_group($group_id)
	{
		$group_result			=	$this->group_model->get_group_by_parent_id($group_id);
		$item_result			=	$this->item_model->get_item_by_parent_id($group_id);
		$delete 				=	TRUE;

		if($group_result!=NULL){
			$sdata	=	array();
			$sdata['deletion_error']	= 'Sorry! can not delete '.$group_result[0]->parent_group.'! first you have to delete the child groups under this group..';
			$this->session->set_userdata($sdata);
			redirect('group/view_groups','refresh');
			$delete 	=	FALSE;
		}

		if($item_result!=NULL){
			$sdata	=	array();
			$sdata['deletion_error']	= 'Sorry! can not delete '.$item_result[0]->group_name.'! first you have to delete the child items under this group..';
			$this->session->set_userdata($sdata);
			redirect('group/view_groups','refresh');
			$delete 	=	FALSE;
		}
		
		if($delete==TRUE){
			$this->group_model->delete_group($group_id);
		}

		redirect('group/view_groups','refresh');
	}

}
