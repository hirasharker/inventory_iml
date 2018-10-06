<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Item extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('user_id')==NULL){
			redirect('login','refresh');
		}
		$this->load->model('group_model','group_model',TRUE);
		$this->load->model('item_model','item_model',TRUE);
		$this->load->model('company_model','company_model',TRUE);
		$this->load->model('purchase_model','purchase_model',TRUE);
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
	public function index($item_id=0)
	{
		$data						=	array();
		$data['page_title']			=	"Inventory Management";

		$nav_data					=	array();
		$nav_data['dev_key']		=	"item";
		$nav_data['selected']		=	"add_item";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$item_data					=	array();
		$item_data['group_list']	=	$this->group_model->get_all_groups();
		if($item_id!=0){
			$item_data['item']		=	$this->item_model->get_item_by_id($item_id);
		}else{
			$item_data['item']		=	NULL;
		}

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/item',$item_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}
	public function view_items()
	{
		$data						=	array();
		$data['page_title']			=	"Inventory Management";
		$nav_data['dev_key']		=	"item";
		$nav_data['selected']		=	"all_items";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$item_data					=	array();
		$item_data['item_list']		=	$this->item_model->get_all_items();
		$item_data['permission']	= 	$this->module_model->get_permission_by_module_id_and_user_id(2,$this->session->userdata('user_id'));

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/item_list',$item_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}
	public function add_item()
	{
		$item_data					=	array();

		$item_data['user_id']		=	$this->session->userdata('user_id');
		$item_data['user_name']		=	$this->session->userdata('user_name');

		$item_data['part_no']		=	$this->input->post('part_no','',TRUE);
		$item_data['item_name']		=	$this->input->post('item_name','',TRUE);
		$item_data['group_id']		=	$this->input->post('group_id','',TRUE);
		$item_data['group_name']	=	$this->group_model->get_group_by_id($item_data['group_id'])->group_name;
		$item_data['description']	=	$this->input->post('description','',TRUE);
		$item_data['item_price']	=	$this->input->post('item_price','',TRUE);
		$item_data['product_life']	=	$this->input->post('product_life','',TRUE);
		$item_data['unit']			=	$this->input->post('unit','',TRUE);

		$result						=	$this->item_model->add_item($item_data);

		redirect('item/view_items','refresh');
	}

	public function update_item($item_id)
	{
		$item_data					=	array();
		$item_data['user_id']		=	$this->session->userdata('user_id');
		$item_data['user_name']		=	$this->session->userdata('user_name');

		$item_data['part_no']		=	$this->input->post('part_no','',TRUE);
		$item_data['item_name']		=	$this->input->post('item_name','',TRUE);
		$item_data['group_id']		=	$this->input->post('group_id','',TRUE);
		$item_data['group_name']	=	$this->group_model->get_group_by_id($item_data['group_id'])->group_name;
		$item_data['description']	=	$this->input->post('description','',TRUE);
		$item_data['item_price']	=	$this->input->post('item_price','',TRUE);
		$item_data['product_life']	=	$this->input->post('product_life','',TRUE);
		$item_data['unit']			=	$this->input->post('unit','',TRUE);

		$result						=	$this->item_model->update_item($item_data, $item_id);

		redirect('item/view_items','refresh');
	}
	public function delete_item($item_id)
	{

		$result			=	$this->purchase_model->get_purchase_detail_by_item_id($item_id);

		if($result!=NULL){
			$sdata	=	array();
			$sdata['deletion_error']	= 'Sorry! can not delete '.$result[0]->item_name.'! you already have purchase invoices associated with '.$result[0]->item_name;
			$this->session->set_userdata($sdata);
			redirect('item/view_items','refresh');
		}else{
			$this->item_model->delete_item($item_id);
		}

		redirect('item/view_items','refresh');
	}
}
