<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dealer extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('user_id')==NULL){
			redirect('login','refresh');
		}
		$this->load->model('dealer_model','dealer_model',TRUE);
		$this->load->model('item_model','item_model',TRUE);
		$this->load->library('form_validation');
		$this->load->model('company_model','company_model',TRUE);
		$this->load->model('convert_model','convert_model',TRUE);
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
	

	//---------------------Dealer SECTION STARTS HERE
	public function index($dealer_id = 0)
	{
		$data							=	array();
		$data['page_title']				=	"Inventory Management";
		$nav_data['dev_key']			=	"dealer";
		$nav_data['selected']			=	"add_dealer";
		$nav_data['company_name']   	=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission'] 	=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$dealer_data					=	array();
		if($dealer_id!=0){
			$dealer_data['dealer_detail']		=	$this->dealer_model->get_dealer_by_id($dealer_id);	
		}else{
			$dealer_data['dealer_detail']		=	NULL;
		}

		$data['navigation']				=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']					=	$this->load->view('templates/footer','',TRUE);
		$data['content']				=	$this->load->view('partials/dealer',$dealer_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}
	public function view_dealers()
	{
		$data								=	array();
		$data['page_title']					=	"Inventory Management";
		$nav_data['dev_key']				=	"dealer";
		$nav_data['selected']				=	"all_dealers";
		$nav_data['company_name']   		=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission'] 		=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$dealer_data						=	array();
		$dealer_data['dealer_list']			=	$this->dealer_model->get_all_dealers();
		$dealer_data['permission']			= 	$this->module_model->get_permission_by_module_id_and_user_id(19,$this->session->userdata('user_id'));

		$data['navigation']					=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']						=	$this->load->view('templates/footer','',TRUE);
		$data['content']					=	$this->load->view('partials/dealer_list',$dealer_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function add_dealer()
	{
		$dealer_data						=	array();
		$dealer_data['user_id']				=	$this->session->userdata('user_id');
		$dealer_data['user_name']			=	$this->session->userdata('user_name');
		$dealer_data['dealer_name']			=	$this->input->post('dealer_name','',TRUE);
		$dealer_data['dealer_category']		=	$this->input->post('dealer_category','',TRUE);
		$dealer_data['present_address']				=	$this->input->post('present_address','',TRUE);
		$dealer_data['phone_no']			=	$this->input->post('phone_no','',TRUE);

		$result								=	$this->dealer_model->add_dealer($dealer_data);

		redirect('dealer/view_dealers','refresh');
	}

	public function update_dealer()
	{
		$dealer_data						=	array();
		$dealer_data['user_id']				=	$this->session->userdata('user_id');
		$dealer_data['user_name']			=	$this->session->userdata('user_name');
		$dealer_data['dealer_id']			=	$this->input->post('dealer_id','',TRUE);
		$dealer_data['dealer_name']			=	$this->input->post('dealer_name','',TRUE);
		$dealer_data['dealer_category']		=	$this->input->post('dealer_category','',TRUE);
		$dealer_data['present_address']				=	$this->input->post('present_address','',TRUE);
		$dealer_data['phone_no']			=	$this->input->post('phone_no','',TRUE);

		$result								=	$this->dealer_model->update_dealer($dealer_data,$dealer_data['dealer_id']);

		redirect('dealer/view_dealers','refresh');
	}
	public function delete_dealer($dealer_id)
	{
		
		$this->dealer_model->delete_dealer($dealer_id);

		redirect('dealer/view_dealers','refresh');
	}

	//---------------------dealer SECTION ENDS HERE

	
}
