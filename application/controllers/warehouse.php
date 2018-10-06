<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Warehouse extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('user_id')==NULL){
			redirect('login','refresh');
		}
		$this->load->model('warehouse_model','warehouse_model',TRUE);
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
	public function index($warehouse_id=0)
	{
		$data						=	array();
		$data['page_title']			=	"Inventory - Warehouse";

		$nav_data					=	array();
		$nav_data['dev_key']		=	"warehouse";
		$nav_data['selected']		=	"add_warehouse";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$warehouse_data					=	array();
		$warehouse_data['warehouse_list']	=	$this->warehouse_model->get_all_warehouses();

		if($warehouse_id!=0)
		{
			$warehouse_data['warehouse_detail']	=	$this->warehouse_model->get_warehouse_by_id($warehouse_id);
		}else{
			$warehouse_data['warehouse_detail']	=	NULL;
		}

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/warehouse',$warehouse_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}
	public function view_warehouses()
	{
		$data						=	array();
		$data['page_title']			=	"Inventory - warehouse list";
		$nav_data['dev_key']		=	"warehouse";
		$nav_data['selected']		=	"all_warehouses";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$warehouse_data					=	array();
		$warehouse_data['warehouse_list']	=	$this->warehouse_model->get_all_warehouses();
		$warehouse_data['permission']	= 	$this->module_model->get_permission_by_module_id_and_user_id(16,$this->session->userdata('user_id'));

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/warehouse_list',$warehouse_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}
	public function add_warehouse()
	{
		$warehouse_data							=	array();
		$warehouse_data['user_id']				=	$this->session->userdata('user_id');
		$warehouse_data['user_name']			=	$this->session->userdata('user_name');
		$warehouse_data['warehouse_name']		=	$this->input->post('warehouse_name','',TRUE);
		$warehouse_data['warehouse_location']	=	$this->input->post('warehouse_location','',TRUE);

		$result									=	$this->warehouse_model->add_warehouse($warehouse_data);

		redirect('warehouse/view_warehouses','refresh');
	}

	public function update_warehouse($warehouse_id)
	{
		$warehouse_data					=	array();
		$warehouse_data['user_id']				=	$this->session->userdata('user_id');
		$warehouse_data['user_name']			=	$this->session->userdata('user_name');
		$warehouse_data['warehouse_name']		=	$this->input->post('warehouse_name','',TRUE);
		$warehouse_data['warehouse_location']	=	$this->input->post('warehouse_location','',TRUE);

		$result						=	$this->warehouse_model->update_warehouse($warehouse_data,$warehouse_id);

		redirect('warehouse/view_warehouses','refresh');
	}
	public function delete_warehouse($warehouse_id)
	{
		$item_result			=	$this->item_model->get_item_by_parent_id($warehouse_id);
		$delete 				=	TRUE;

		if($item_result!=NULL){
			$sdata	=	array();
			$sdata['deletion_error']	= 'Sorry! can not delete '.$item_result[0]->warehouse_name.'! first you have to delete the child items under this warehouse..';
			$this->session->set_userdata($sdata);
			redirect('warehouse/view_warehouses','refresh');
			$delete 	=	FALSE;
		}
		
		if($delete==TRUE){
			$this->warehouse_model->delete_warehouse($warehouse_id);
		}

		redirect('warehouse/view_warehouses','refresh');
	}


	//-----------------------------WAREHOUSE SLOT ---------------------------------------------------------------------

	public function warehouse_slot($warehouse_slot_id=0)
	{
		$data						=	array();
		$data['page_title']			=	"Inventory - Warehouse Slot";

		$nav_data					=	array();
		$nav_data['dev_key']		=	"warehouse";
		$nav_data['selected']		=	"add_warehouse_slot";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$warehouse_slot_data							=	array();
		$warehouse_slot_data['warehouse_slot_list']		=	$this->warehouse_model->get_all_warehouse_slots();
		$warehouse_slot_data['warehouse_list']			=	$this->warehouse_model->get_all_warehouses();

		if($warehouse_slot_id!=0)
		{
			$warehouse_slot_data['warehouse_slot_detail']	=	$this->warehouse_model->get_warehouse_slot_by_id($warehouse_slot_id);
		}else{
			$warehouse_slot_data['warehouse_slot_detail']	=	NULL;
		}

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/warehouse_slot',$warehouse_slot_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}
	public function view_warehouse_slots()
	{
		$data						=	array();
		$data['page_title']			=	"Inventory - warehouse list";
		$nav_data['dev_key']		=	"warehouse";
		$nav_data['selected']		=	"all_warehouse_slots";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$warehouse_slot_data						=	array();
		$warehouse_slot_data['warehouse_slot_list']	=	$this->warehouse_model->get_all_warehouse_slots();
		$warehouse_slot_data['warehouse_list']		=	$this->warehouse_model->get_all_warehouses();
		$warehouse_slot_data['permission']			= 	$this->module_model->get_permission_by_module_id_and_user_id(18,$this->session->userdata('user_id'));

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/warehouse_slot_list',$warehouse_slot_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}
	public function add_warehouse_slot()
	{
		$warehouse_slot_data							=	array();
		$warehouse_slot_data['user_id']					=	$this->session->userdata('user_id');
		$warehouse_slot_data['user_name']				=	$this->session->userdata('user_name');
		$warehouse_slot_data['warehouse_id']			=	$this->input->post('warehouse_id','',TRUE);
		$warehouse_slot_data['slot_identifier']			=	$this->input->post('slot_identifier','',TRUE);
		$warehouse_slot_data['description']				=	$this->input->post('description','',TRUE);

		$result											=	$this->warehouse_model->add_warehouse_slot($warehouse_slot_data);

		redirect('warehouse/view_warehouses','refresh');
	}

	public function update_warehouse_slot()
	{
		$warehouse_slot_data							=	array();
		$warehouse_slot_data['user_id']					=	$this->session->userdata('user_id');
		$warehouse_slot_data['user_name']				=	$this->session->userdata('user_name');
		$warehouse_slot_data['warehouse_slot_id']		=	$this->input->post('warehouse_slot_id','',TRUE);
		$warehouse_slot_data['warehouse_id']			=	$this->input->post('warehouse_id','',TRUE);
		$warehouse_slot_data['slot_identifier']			=	$this->input->post('slot_identifier','',TRUE);
		$warehouse_slot_data['description']				=	$this->input->post('description','',TRUE);

		$result						=	$this->warehouse_model->update_warehouse_slot($warehouse_slot_data,$warehouse_slot_data['warehouse_slot_id']);

		redirect('warehouse/view_warehouse_slots','refresh');
	}
	public function delete_warehouse_slot($warehouse_id)
	{
		$item_result			=	$this->item_model->get_item_by_parent_id($warehouse_id);
		$delete 				=	TRUE;

		if($item_result!=NULL){
			$sdata	=	array();
			$sdata['deletion_error']	= 'Sorry! can not delete '.$item_result[0]->warehouse_name.'! first you have to delete the child items under this warehouse..';
			$this->session->set_userdata($sdata);
			redirect('warehouse/view_warehouses','refresh');
			$delete 	=	FALSE;
		}
		
		if($delete==TRUE){
			$this->warehouse_model->delete_warehouse($warehouse_id);
		}

		redirect('warehouse/view_warehouses','refresh');
	}

}
