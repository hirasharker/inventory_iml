<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bank extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('user_id')==NULL){
			redirect('login','refresh');
		}
		$this->load->library('form_validation');
		$this->load->model('company_model','company_model',TRUE);
		$this->load->model('convert_model','convert_model',TRUE);
		$this->load->model('module_model','module_model',TRUE);
		$this->load->model('bank_model','bank_model',TRUE);
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
	

	//---------------------bank SECTION STARTS HERE
	
	/**
	 * [index description]
	 * @param  integer $bank_id [description]
	 * @return void           	[description]
	 */
	public function index($bank_id = 0)
	{
		$data							=	array();
		$data['page_title']				=	"Inventory Management";
		$nav_data['dev_key']			=	"bank";
		$nav_data['selected']			=	"add_bank";
		$nav_data['company_name']   	=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission'] 	=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$bank_data					=	array();
		if($bank_id!=0){
			$bank_data['bank_detail']		=	$this->bank_model->get_bank_by_id($bank_id);	
		}else{
			$bank_data['bank_detail']		=	NULL;
		}

		$data['navigation']				=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']					=	$this->load->view('templates/footer','',TRUE);
		$data['content']				=	$this->load->view('partials/bank',$bank_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function view_banks()
	{
		$data								=	array();
		$data['page_title']					=	"Inventory Management";
		$nav_data['dev_key']				=	"bank";
		$nav_data['selected']				=	"all_banks";
		$nav_data['company_name']   		=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission'] 		=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$bank_data							=	array();
		$bank_data['bank_list']				=	$this->bank_model->get_all_banks();
		$bank_data['permission']			= 	$this->module_model->get_permission_by_module_id_and_user_id(20,$this->session->userdata('user_id'));

		$data['navigation']					=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']						=	$this->load->view('templates/footer','',TRUE);
		$data['content']					=	$this->load->view('partials/bank_list',$bank_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function add_bank()
	{
		$bank_data						=	array();
		$bank_data['user_id']			=	$this->session->userdata('user_id');
		$bank_data['bank_name']			=	$this->input->post('bank_name','',TRUE);
		$bank_data['bank_code']			=	$this->input->post('bank_code','',TRUE);
		$bank_data['address']			=	$this->input->post('address','',TRUE);

		$result							=	$this->bank_model->add_bank($bank_data);

		redirect('bank/view_banks','refresh');
	}

	public function update_bank()
	{
		$bank_data						=	array();

		$bank_data['user_id']			=	$this->session->userdata('user_id');
		
		$bank_data['bank_id']			=	$this->input->post('bank_id','',TRUE);
		$bank_data['bank_name']			=	$this->input->post('bank_name','',TRUE);
		$bank_data['bank_code']			=	$this->input->post('bank_code','',TRUE);
		$bank_data['address']			=	$this->input->post('address','',TRUE);

		$result								=	$this->bank_model->update_bank($bank_data,$bank_data['bank_id']);

		redirect('bank/view_banks','refresh');
	}
	public function delete_bank($bank_id)
	{
		
		$this->bank_model->delete_bank($bank_id);

		redirect('bank/view_banks','refresh');
	}

	//---------------------bank SECTION ENDS HERE

	
}
