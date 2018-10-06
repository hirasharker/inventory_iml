<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Customer extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('user_id')==NULL){
			redirect('login','refresh');
		}
		$this->load->model('sales_model','sales_model',TRUE);
		$this->load->model('money_receipt_model','mr_model',TRUE);
		$this->load->model('sales_order_model','sales_order_model',TRUE);
		$this->load->model('dealer_model','dealer_model',TRUE);
		$this->load->model('customer_model','customer_model',TRUE);
		$this->load->model('item_model','item_model',TRUE);
		$this->load->model('stock_model','stock_model',TRUE);
		$this->load->model('warehouse_model','warehouse_model',TRUE);
		$this->load->library('form_validation');
		$this->load->model('company_model','company_model',TRUE);
		$this->load->model('convert_model','convert_model',TRUE);
		$this->load->model('module_model','module_model',TRUE);
		$this->load->model('company_model','company_model',TRUE);

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
	public function index($customer_id = 0)
	{
		$data							=	array();
		$data['page_title']				=	"Inventory Management";
		$nav_data['dev_key']			=	"customer";
		$nav_data['selected']			=	"add_customer";
		$nav_data['company_name']   	=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']	=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$customer_data					=	array();
		if($customer_id!=0){
			$customer_data['customer']	=	$this->customer_model->get_customer_by_id($customer_id);	
		}else{
			$customer_data['customer']	=	NULL;
		}

		$data['navigation']				=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']					=	$this->load->view('templates/footer','',TRUE);
		$data['content']				=	$this->load->view('partials/customer',$customer_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}
	public function view_customers()
	{
		$data								=	array();
		$data['page_title']					=	"Inventory Management";
		$nav_data['dev_key']				=	"customer";
		$nav_data['selected']				=	"all_customers";
		$nav_data['company_name']   		=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission'] 		=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$customer_data						=	array();
		$customer_data['customer_list']		=	$this->customer_model->get_all_customers();
		$customer_data['permission']		= 	$this->module_model->get_permission_by_module_id_and_user_id(8,$this->session->userdata('user_id'));

		$data['navigation']					=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']						=	$this->load->view('templates/footer','',TRUE);
		$data['content']					=	$this->load->view('partials/customer_list',$customer_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function add_customer()
	{
		$customer_data						=	array();
		$customer_data['user_id']			=	$this->session->userdata('user_id');
		$customer_data['user_name']			=	$this->session->userdata('user_name');
		$customer_data['customer_type']		=	$this->input->post('customer_type','',TRUE);
		$customer_data['customer_name']		=	$this->input->post('customer_name','',TRUE);
		$customer_data['customer_category']	=	$this->input->post('customer_category','',TRUE);
		$customer_data['address']			=	$this->input->post('address','',TRUE);
		$customer_data['phone_no']			=	$this->input->post('phone_no','',TRUE);

		$result								=	$this->customer_model->add_customer($customer_data);

		redirect('customer/view_customers','refresh');
	}

	public function update_customer($customer_id)
	{
		$customer_data						=	array();
		$customer_data['user_id']			=	$this->session->userdata('user_id');
		$customer_data['user_name']			=	$this->session->userdata('user_name');
		$customer_data['customer_type']		=	$this->input->post('customer_type','',TRUE);
		$customer_data['customer_name']		=	$this->input->post('customer_name','',TRUE);
		$customer_data['customer_category']	=	$this->input->post('customer_category','',TRUE);
		$customer_data['address']			=	$this->input->post('address','',TRUE);
		$customer_data['phone_no']			=	$this->input->post('phone_no','',TRUE);

		$result								=	$this->customer_model->update_customer($customer_data,$customer_id);

		redirect('customer/view_customers','refresh');
	}
	public function delete_customer($customer_id)
	{
		
		$this->customer_model->delete_customer($customer_id);

		redirect('customer/view_customers','refresh');
	}

}
?>
