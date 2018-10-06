<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Money_Receipt extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('user_id')==NULL){
			redirect('login','refresh');
		}
		$this->load->model('money_receipt_model','mr_model',TRUE);
		$this->load->model('sales_model','sales_model',TRUE);
		$this->load->model('sales_order_model','sales_order_model',TRUE);
		$this->load->model('dealer_model','dealer_model',TRUE);
		$this->load->model('item_model','item_model',TRUE);
		$this->load->model('stock_model','stock_model',TRUE);
		$this->load->model('warehouse_model','warehouse_model',TRUE);
		$this->load->library('form_validation');
		$this->load->model('company_model','company_model',TRUE);
		$this->load->model('convert_model','convert_model',TRUE);
		$this->load->model('module_model','module_model',TRUE);
		$this->load->model('company_model','company_model',TRUE);
		$this->load->model('user_model','user_model',TRUE);

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
	
	public function index ($money_receipt_id=0)
	{
		$data							=	array();
		$data['page_title']				=	"Inventory Management";

		$nav_data						=	array();
		$nav_data['dev_key']			=	"money_receipt";
		$nav_data['selected']			=	"add_money_receipt";
		$nav_data['company_name']   	=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$money_receipt_data						=	array();
		if($money_receipt_id!=0){
			$money_receipt_data['money_receipt']	=	$this->mr_model->get_money_receipt_by_id($money_receipt_id);
		}else{
			$money_receipt_data['money_receipt']	=	NULL;
		}

		$data['navigation']				=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']					=	$this->load->view('templates/footer','',TRUE);
		$data['content']				=	$this->load->view('partials/money_receipt',$money_receipt_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function view_money_receipts()
	{
		$data							=	array();
		$data['page_title']				=	"Inventory Management";
		$nav_data['dev_key']			=	"money_receipt";
		$nav_data['selected']			=	"all_money_receipts";
		$nav_data['company_name']   	=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$money_receipt_data				=	array();
		$money_receipt_data['money_receipt_list']	=	$this->mr_model->get_all_money_receipts();
		$money_receipt_data['permission']		= 	$this->module_model->get_permission_by_module_id_and_user_id(10,$this->session->userdata('user_id'));

		$data['navigation']				=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']					=	$this->load->view('templates/footer','',TRUE);
		$data['content']				=	$this->load->view('partials/money_receipt_list',$money_receipt_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	

	public function add_money_receipt()
	{
		$money_receipt_data							=	array();
		$money_receipt_data['user_id']				=	$this->session->userdata('user_id');
		$money_receipt_data['user_name']			=	$this->session->userdata('user_name');

		$payment_mode 								=	$this->input->post('payment_mode');

		$session_data 								=	array();
		if($payment_mode == 2){
			$session_data['error']					=	"Select Payment Mode!!!";
			$this->session->set_userdata($session_data);
			redirect('money_receipt','refresh');
		}elseif ($payment_mode == 0) {
			$money_receipt_data['sales_order_id']	=	$this->input->post('sales_order_id','',TRUE);
			$sales_detail							=	$this->sales_order_model->get_sales_order_by_id($money_receipt_data['sales_order_id']);
		}elseif ($payment_mode == 1) {
			$money_receipt_data['sales_id']			=	$this->input->post('sales_id','',TRUE);
			$sales_detail							=	$this->sales_model->get_sales_by_id($money_receipt_data['sales_id']);
		}

		$money_receipt_data['payment_mode']			=	$payment_mode;
		$money_receipt_data['customer_id']			=	$sales_detail->customer_id;
		$money_receipt_data['customer_name']		=	$sales_detail->customer_name;
		$money_receipt_data['dealer_id']			=	$sales_detail->dealer_id;
		$money_receipt_data['dealer_name']			=	$sales_detail->dealer_name;
		
		$money_receipt_data['received_amount']		=	$this->input->post('received_amount','',TRUE);
		$money_receipt_data['money_receipt_date']	=	$this->input->post('money_receipt_date','',TRUE);

		// $this->form_validation->set_rules('sales_id', 'Invoice No', 'required|integer');
		$this->form_validation->set_rules('received_amount', 'received amount', 'required|numeric');
		$this->form_validation->set_rules('money_receipt_date', 'receipt date', 'required');

        if ($this->form_validation->run() != FALSE) {

			$result				=	$this->mr_model->add_money_receipt($money_receipt_data);
			redirect('money_receipt/view_money_receipts','refresh');
		}else{
			redirect('money_receipt','refresh');
		}
	}

	public function update_money_receipt()
	{
		$money_receipt_id 							=	$this->input->post('money_receipt_id','',TRUE);

		$money_receipt_data							=	array();
		$money_receipt_data['user_id']				=	$this->session->userdata('user_id');
		$money_receipt_data['user_name']			=	$this->session->userdata('user_name');

		$payment_mode 								=	$this->input->post('payment_mode');

		$session_data 								=	array();
		if($payment_mode == 2){
			$session_data['error']					=	"Select Payment Mode!!!";
			$this->session->set_userdata($session_data);
			redirect('money_receipt','refresh');
		}elseif ($payment_mode == 0) {
			$money_receipt_data['sales_order_id']	=	$this->input->post('sales_order_id','',TRUE);
			$sales_detail							=	$this->sales_order_model->get_sales_order_by_id($money_receipt_data['sales_order_id']);
		}elseif ($payment_mode == 1) {
			$money_receipt_data['sales_id']			=	$this->input->post('sales_id','',TRUE);
			$sales_detail							=	$this->sales_model->get_sales_by_id($money_receipt_data['sales_id']);
		}

		$money_receipt_data['payment_mode']			=	$payment_mode;
		$money_receipt_data['customer_id']			=	$sales_detail->customer_id;
		$money_receipt_data['customer_name']		=	$sales_detail->customer_name;
		$money_receipt_data['dealer_id']			=	$sales_detail->dealer_id;
		$money_receipt_data['dealer_name']			=	$sales_detail->dealer_name;
		
		$money_receipt_data['received_amount']		=	$this->input->post('received_amount','',TRUE);
		$money_receipt_data['money_receipt_date']	=	$this->input->post('money_receipt_date','',TRUE);

		// $this->form_validation->set_rules('sales_id', 'Invoice No', 'required|integer');
		$this->form_validation->set_rules('received_amount', 'received amount', 'required|numeric');
		$this->form_validation->set_rules('money_receipt_date', 'receipt date', 'required');

        if ($this->form_validation->run() != FALSE) {

			$result				=	$this->mr_model->update_money_receipt($money_receipt_data, $money_receipt_id);
			redirect('money_receipt/view_money_receipts','refresh');
		}else{
			redirect('money_receipt','refresh');
		}
	}
	public function delete_money_receipt($money_receipt_id)
	{
		
		$this->mr_model->delete_money_receipt($money_receipt_id);

		redirect('money_receipt/view_money_receipts','refresh');
	}


	public function print_money_receipt (){
		$money_receipt_data 							=	array();

		$money_receipt_data['page_title']				=	"Money Receipt !!!";

		$money_receipt_data['company_detail']   		=   $this->company_model->get_company_by_id(1);

		$money_receipt_data['user_detail']				=	$this->user_model->get_user_by_id($this->session->userdata('user_id'));

		$money_receipt_data['user_permission']			=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$money_receipt_id								=	$this->input->post('money_receipt_id','',TRUE);
		

		$money_receipt_data['money_receipt']			=	$this->mr_model->get_money_receipt_by_id($money_receipt_id);

		$money_receipt_data['received_amount_in_words'] =	$this->convert_model->convert_number(
															$money_receipt_data['money_receipt']->received_amount);

		// echo '<pre>';print_r($money_receipt_data);echo '</pre>';exit();
	
		$this->load->view('partials/money_receipt_print',$money_receipt_data);
	}

	
}
