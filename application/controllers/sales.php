<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sales extends CI_Controller {
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
	public function index($sales_id = 0, $error_count = 0)
	{
		$data						=	array();
		$data['page_title']			=	"Inventory Management";

		$nav_data					=	array();
		$nav_data['dev_key']		=	"sales_invoice";
		$nav_data['selected']		=	"add_sales";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$sales_data					=	array();
		
		$sales_data['warehouse_list']	=	$this->warehouse_model->get_all_warehouses();
		$sales_data['customer_list']	=	$this->customer_model->get_all_customers();
		$sales_data['dealer_list']		=	$this->dealer_model->get_all_dealers();
		$sales_data['sales_order_list']	=	$this->sales_order_model->get_all_unused_sales_orders();

		if($sales_id != 0){
			$sales_data['sales']		=	$this->sales_model->get_sales_by_id($sales_id);
			$sales_data['sales_detail']	=	$this->sales_model->get_sales_details_by_id($sales_id , $sales_data['sales']->warehouse_id);
			$sales_data['item_list']	=	$this->stock_model->get_item_by_warehouse_id($sales_data['sales']->warehouse_id);
			$sales_data['customer_type']	=	$sales_data['sales']->customer_type;
		}else{
			$sales_data['sales']		=	NULL;
			$sales_data['sales_detail']	=	NULL;
		}
		if($error_count != 0){
			$sales_data['error_content']			=	$error_count +1;
		}else{
			$sales_data['error_content']			=	NULL;
		}

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/sales',$sales_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}
	public function view_sales()
	{
		$data						=	array();
		$data['page_title']			=	"Inventory Management";
		$nav_data['dev_key']		=	"sales_invoice";
		$nav_data['selected']		=	"all_sales";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$sales_data 				= 	array();
		$sales_data['sales_list']	=	$this->sales_model->get_all_sales();
		$sales_data['permission']	= 	$this->module_model->get_permission_by_module_id_and_user_id(9,$this->session->userdata('user_id'));

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/sales_list',$sales_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function generate_sales_id(){
		if (isset($_GET['term'])){
	      $sales_id = strtolower($_GET['term']);
	      $this->sales_model->get_sales_like_id($sales_id);
	    }
	}

	public function ajax_count_item(){
		$count						=	$this->input->post('count',TRUE);

		$data 						=	array();
		$data['count']				=	$count+1;
		$data['error_content']		=	$this->load->view('partials/form_validation_tag',$data,TRUE);

		// $error_message			=	$count +1;

        echo json_encode($data['error_content']);
	}

	public function add_sales()
	{
		$sales_data						=	array();
		$sales_data['user_id']			=	$this->session->userdata('user_id');
		$sales_data['user_name']		=	$this->session->userdata('user_name');

		$sales_data['customer_type']	=	$this->input->post('customer_type','',TRUE);

		$sales_data['sales_date']		=	$this->input->post('sales_date','',TRUE);

		$sales_against_order 			=	$this->input->post('sales_against_order','',TRUE);

		if($sales_against_order == 1){
			$sales_data['sales_order_id']=	$this->input->post('sales_order_id','',TRUE);
			$this->add_sales_against_sales_order($sales_data['sales_order_id'], $sales_data['sales_date']);
			redirect('sales','refresh');
		}
		
		$sales_data['warehouse_id']		=	$this->input->post('warehouse_id','',TRUE);
		$sales_data['warehouse_name']	=	$this->warehouse_model->get_warehouse_by_id($sales_data['warehouse_id'])->warehouse_name;
		
		$sales_data['customer_id']		=	$this->input->post('customer_id','',TRUE);
		if($sales_data['customer_id']!= NULL){
			$sales_data['customer_name']	=	$this->customer_model->get_customer_by_id($sales_data['customer_id'])->customer_name;
		}
		
		$sales_data['dealer_id']		=	$this->input->post('dealer_id','',TRUE);
		if($sales_data['dealer_id']!= NULL){
			$sales_data['dealer_name']		=	$this->dealer_model->get_dealer_by_id($sales_data['dealer_id'])->dealer_name;
		}
		
		
		$sales_data['overall_discount']	=	$this->input->post('sales_discount','',TRUE);

		$error_count					=	$this->input->post('count','',TRUE);

		$item_id						=	$this->input->post('item_id','',TRUE);
		$item_name						=	$this->input->post('item_name','',TRUE);
		$sales_price					=	$this->input->post('sales_price','',TRUE);
		$discount 						=	$this->input->post('discount','',TRUE);
		$quantity						=	$this->input->post('quantity','',TRUE);
		$stock[]						=	array();

		for ($i=0; $i < $error_count ; $i++) { 
			$stock[$i]					=	$this->item_model->get_item_by_id($item_id[$i])->quantity;
			$this->form_validation->set_rules('discount['.$i.']', 'Discount', 'required|numeric');
        	$this->form_validation->set_rules('quantity['.$i.']', 'Quantity', 'required|numeric|less_than_equal_to['.$stock[$i].']');
        	$this->form_validation->set_message('less_than_equal_to', 'There are only {param} {field} left');
		}

		$this->form_validation->set_rules('sales_price[]', 'Sales price', 'required|numeric');
        $this->form_validation->set_rules('sales_date', 'Sales Date', 'required');

        if ($this->form_validation->run() != FALSE) {

			$result							=	$this->sales_model->add_sales($sales_data);

			$sales_detail_data				=	array();

			$sales_detail_data['warehouse_id']				=	$sales_data['warehouse_id'];
			$sales_detail_data['dealer_id']					=	$sales_data['dealer_id'];
			$sales_detail_data['customer_id']				=	$sales_data['customer_id'];

			for ($i=0; $i < $error_count ; $i++) { 
				$sales_detail_data['sales_id']				=	$result;
				$sales_detail_data['item_id']				=	$item_id[$i];
				$sales_detail_data['item_name']				=	$item_name[$i];
				$sales_detail_data['sales_price']			=	$sales_price[$i];
				$sales_detail_data['individual_discount']	=	$discount[$i];
				$sales_detail_data['overall_discount']		=	$sales_data['overall_discount'];
				$sales_detail_data['sales_date']			=	$sales_data['sales_date'];
				$sales_detail_data['quantity']				=	$quantity[$i];
				$detail_result								=	$this->sales_model->add_sales_detail($sales_detail_data);

				$this->item_model->subtract_item_quantity($sales_detail_data['item_id'],$sales_detail_data['quantity']);

				$this->stock_model->subtract_stock_quantity($sales_detail_data['item_id'], $sales_detail_data['warehouse_id'], $sales_detail_data['quantity']);
			}
			redirect('sales/view_sales','refresh');
		}else{
			$this->index(0,$error_count);
		}
	}

	public function add_sales_against_sales_order($sales_order_id, $sales_date){
		$session_data 					=	array();
		$sales_data						=	array();
		$sales_data['user_id']			=	$this->session->userdata('user_id');
		$sales_data['user_name']		=	$this->session->userdata('user_name');

		$sales_data['sales_order_id']	=	$sales_order_id;

		$sales_order 					=	$this->sales_order_model->get_sales_order_by_id($sales_order_id);
		$sales_order_detail				=	$this->sales_order_model->get_sales_order_details_by_id($sales_order_id, $sales_order->warehouse_id);

		$sales_data['customer_type']	=	$sales_order->customer_type;
		$sales_data['warehouse_id']		=	$sales_order->warehouse_id;
		$sales_data['warehouse_name']	=	$sales_order->warehouse_name;
		
		$sales_data['customer_id']		=	$sales_order->customer_id;
		if($sales_data['customer_id']!= 0){
			$sales_data['customer_name']	=	$this->customer_model->get_customer_by_id($sales_data['customer_id'])->customer_name;
		}
		
		$sales_data['dealer_id']		=	$sales_order->dealer_id;
		if($sales_data['dealer_id']!= 0){
			$sales_data['dealer_name']		=	$this->dealer_model->get_dealer_by_id($sales_data['dealer_id'])->dealer_name;
		}
		
		$sales_data['sales_date']		=	$sales_date;
		$sales_data['overall_discount']	=	$sales_order->overall_discount;

		
		$i 								=	0;

		$result 						=	0;

		foreach($sales_order_detail as $value) {
			$stock						=	$this->item_model->get_item_by_id($value->item_id)->quantity;
        	if($value->quantity > $stock){
        		$session_data['error_message']	=	'You only have '.$stock.' '.$value->item_name.' left in stock!!';

        		$this->session->set_userdata($session_data);
        		redirect('sales','refresh');
        	}

        	$sales_detail_data				=	array();

        	if($i==0){
        		$result										=	$this->sales_model->add_sales($sales_data);
        	}
        	$sales_detail_data['warehouse_id']			=	$sales_data['warehouse_id'];
			$sales_detail_data['dealer_id']				=	$sales_data['dealer_id'];
			$sales_detail_data['customer_id']			=	$sales_data['customer_id'];
			$sales_detail_data['sales_id']				=	$result;
			$sales_detail_data['item_id']				=	$value->item_id;
			$sales_detail_data['item_name']				=	$value->item_name;
			$sales_detail_data['sales_price']			=	$value->sales_order_price;
			$sales_detail_data['individual_discount']	=	$value->individual_discount;
			$sales_detail_data['overall_discount']		=	$sales_data['overall_discount'];
			$sales_detail_data['sales_date']			=	$sales_date;
			$sales_detail_data['quantity']				=	$value->quantity;
			$detail_result								=	$this->sales_model->add_sales_detail($sales_detail_data);

			$this->item_model->subtract_item_quantity($value->item_id , $value->quantity);

			$this->stock_model->subtract_stock_quantity($value->item_id, $sales_detail_data['warehouse_id'], $value->quantity);

			$i++;
		} //foreach

		redirect('sales/view_sales','refresh');
	}

	public function update_sales($sales_id)
	{
		$sales_data						=	array();
		$sales_data['user_id']			=	$this->session->userdata('user_id');
		$sales_data['user_name']		=	$this->session->userdata('user_name');
		
		$sales_data['warehouse_id']		=	$this->input->post('warehouse_id','',TRUE);
		$sales_data['warehouse_name']	=	$this->warehouse_model->get_warehouse_by_id($sales_data['warehouse_id'])->warehouse_name;

		$sales_data['customer_id']		=	$this->input->post('customer_id','',TRUE);
		if($sales_data['customer_id']!= NULL){
			$sales_data['customer_name']	=	$this->customer_model->get_customer_by_id($sales_data['customer_id'])->customer_name;
		}
		
		$sales_data['dealer_id']		=	$this->input->post('dealer_id','',TRUE);
		if($sales_data['dealer_id']!= NULL){
			$sales_data['dealer_name']		=	$this->dealer_model->get_dealer_by_id($sales_data['dealer_id'])->dealer_name;
		}
		
		$sales_data['sales_date']		=	$this->input->post('sales_date','',TRUE);
		$sales_data['overall_discount']	=	$this->input->post('sales_discount','',TRUE);

		$error_count					=	$this->input->post('count','',TRUE);

		$item_id						=	$this->input->post('item_id','',TRUE);
		$item_name						=	$this->input->post('item_name','',TRUE);
		$sales_price					=	$this->input->post('sales_price','',TRUE);
		$discount 						=	$this->input->post('discount','',TRUE);
		$quantity						=	$this->input->post('quantity','',TRUE);

		$sales_detail					=	$this->sales_model->get_sales_details_by_id($sales_id, $sales_data['warehouse_id']);

		$stock[]						=	array();

		for ($i=0; $i < $error_count ; $i++) {
			$stock[$i]					=	$this->item_model->get_item_by_id($item_id[$i])->quantity;
        	$this->form_validation->set_rules('quantity['.$i.']', 'Quantity', 'required|numeric|less_than_equal_to['.$stock[$i].']');
        	$this->form_validation->set_message('less_than_equal_to', 'There are only {param} {field} left');
		}

		$this->form_validation->set_rules('sales_price[]', 'Sales price', 'required|numeric');
	    $this->form_validation->set_rules('sales_date', 'Sales Date', 'required');

        if ($this->form_validation->run() != FALSE) {

			$this->sales_model->update_sales($sales_data,$sales_id);

			$this->delete_sales_detail($sales_id,$sales_data['warehouse_id']);

			$count							=	$this->input->post('count','',TRUE);

			$sales_detail_data				=	array();

			$sales_detail_data['warehouse_id']				=	$sales_data['warehouse_id'];

			for ($i=0; $i < $count ; $i++) {
				$sales_detail_data['sales_id']				=	$sales_id;
				$sales_detail_data['customer_id']			=	$sales_data['customer_id'];
				$sales_detail_data['item_id']				=	$item_id[$i];
				$sales_detail_data['item_name']				=	$item_name[$i];
				$sales_detail_data['sales_price']			=	$sales_price[$i];
				$sales_detail_data['individual_discount']	=	$discount[$i];
				$sales_detail_data['overall_discount']		=	$sales_data['overall_discount'];
				$sales_detail_data['quantity']				=	$quantity[$i];
				$sales_detail_data['sales_date']			=	$sales_data['sales_date'];
				
				$detail_result								=	$this->sales_model->add_sales_detail($sales_detail_data);

				$sales_detail 								=	$this->sales_model->get_sales_details_by_sales_id_and_item_id($sales_id,$sales_detail_data['item_id']);

				$this->item_model->subtract_item_quantity($sales_detail_data['item_id'],$quantity[$i]);

				$this->stock_model->subtract_stock_quantity($sales_detail_data['item_id'], $sales_data['warehouse_id'], $sales_detail_data['quantity']);
			}

			redirect('sales/view_sales','refresh');
		}else{
			$this->index($sales_id,$error_count);
		}
	}

	public function delete_sales($sales_id, $warehouse_id=NULL)
	{
		if($warehouse_id==NULL){
			$warehouse_id 		=	$this->sales_model->get_sales_by_id($sales_id)->warehouse_id;
		}
		$this->sales_model->delete_sales($sales_id);
		$this->delete_sales_detail($sales_id,$warehouse_id);
		redirect('sales/view_sales','refresh');
	}

	private function delete_sales_detail($sales_id,$warehouse_id)
	{
		$sales_detail 		=	$this->sales_model->get_sales_details_by_id($sales_id,$warehouse_id);
		foreach ($sales_detail as $value) {
			$this->item_model->add_item_quantity($value->item_id,$value->quantity);
			$this->stock_model->add_stock_quantity($value->item_id, $warehouse_id, $value->quantity);
		}
		$this->sales_model->delete_sales_detail($sales_id);
	}

	public function get_item_by_warehouse_id(){
		$warehouse_id = $this->input->post('warehouseId');

		$item_list 						=	$this->stock_model->get_item_by_warehouse_id($warehouse_id);

		echo json_encode($item_list);
		// a die here helps ensure a clean ajax call
		die();
	}

	public function ajax_get_sales_total(){
		$price 						=	$this->input->post('sales_price');

		$qty 						=	$this->input->post('quantity');

		$discount 					=	$this->input->post('discount');

		$count 						=	count($price);

		$sub_total 					=	0;

		for ($i=0; $i < $count; $i++) { 
			$sub_total				+=	($qty[$i] * $price[$i]);
		}

		$total_price				=	$sub_total - ($sub_total * $discount * .01);
		
		
		$result_summary 		=	array();

		$result_summary['total_price']	=	$total_price;

		$result_summary['sub_total']	=	$sub_total;

		$result_summary['discount']		=	($sub_total * $discount * .01);
		echo json_encode($result_summary);
		// a die here helps ensure a clean ajax call
	}


	//---------------------CUSTOMER SECTION STARTS HERE
	public function customer($customer_id = 0)
	{
		$data							=	array();
		$data['page_title']				=	"Inventory Management";
		$nav_data['dev_key']			=	"customer";
		$nav_data['selected']			=	"add_customer";
		$nav_data['company_name']   	=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

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
		$customer_data['customer_name']		=	$this->input->post('customer_name','',TRUE);
		$customer_data['address']			=	$this->input->post('address','',TRUE);
		$customer_data['phone_no']			=	$this->input->post('phone_no','',TRUE);

		$result								=	$this->customer_model->add_customer($customer_data);

		redirect('sales/view_customers','refresh');
	}

	public function update_customer($customer_id)
	{
		$customer_data						=	array();
		$customer_data['user_id']			=	$this->session->userdata('user_id');
		$customer_data['user_name']			=	$this->session->userdata('user_name');
		$customer_data['customer_name']		=	$this->input->post('customer_name','',TRUE);
		$customer_data['address']			=	$this->input->post('address','',TRUE);
		$customer_data['phone_no']			=	$this->input->post('phone_no','',TRUE);

		$result								=	$this->customer_model->update_customer($customer_data,$customer_id);

		redirect('sales/view_customers','refresh');
	}
	public function delete_customer($customer_id)
	{
		
		$this->customer_model->delete_customer($customer_id);

		redirect('sales/view_customers','refresh');
	}

	//---------------------customer SECTION ENDS HERE

	//--------------------money_receipt SECTION START HERE

	public function money_receipt($money_receipt_id=0)
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
			$money_receipt_data['money_receipt']	=	$this->sales_model->get_money_receipt_by_id($money_receipt_id);
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
		$money_receipt_data['money_receipt_list']	=	$this->sales_model->get_all_money_receipts();
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
		$money_receipt_data['sales_id']				=	$this->input->post('sales_id','',TRUE);
		
		$sales_detail								=	$this->sales_model->get_sales_by_id($money_receipt_data['sales_id']);
		$money_receipt_data['customer_id']			=	$sales_detail->customer_id;
		$money_receipt_data['customer_name']		=	$sales_detail->customer_name;
		$money_receipt_data['dealer_id']			=	$sales_detail->dealer_id;
		$money_receipt_data['dealer_name']			=	$sales_detail->dealer_name;
		
		$money_receipt_data['received_amount']		=	$this->input->post('received_amount','',TRUE);
		$money_receipt_data['money_receipt_date']	=	$this->input->post('money_receipt_date','',TRUE);

		$this->form_validation->set_rules('sales_id', 'Invoice No', 'required|integer');
		$this->form_validation->set_rules('received_amount', 'received amount', 'required|numeric');
		$this->form_validation->set_rules('money_receipt_date', 'receipt date', 'required');

        if ($this->form_validation->run() != FALSE) {

			$result				=	$this->sales_model->add_money_receipt($money_receipt_data);
			redirect('sales/view_money_receipts','refresh');
		}else{
			$this->money_receipt();
		}
	}

	public function update_money_receipt($money_receipt_id)
	{
		$money_receipt_data							=	array();
		$money_receipt_data['user_id']				=	$this->session->userdata('user_id');
		$money_receipt_data['user_name']			=	$this->session->userdata('user_name');
		$money_receipt_data['sales_id']				=	$this->input->post('sales_id','',TRUE);
		
		$sales_detail								=	$this->sales_model->get_sales_by_id($money_receipt_data['sales_id']);
		$money_receipt_data['customer_id']			=	$sales_detail->customer_id;
		$money_receipt_data['customer_name']		=	$sales_detail->customer_name;
		$money_receipt_data['dealer_id']			=	$sales_detail->dealer_id;
		$money_receipt_data['dealer_name']			=	$sales_detail->dealer_name;

		$money_receipt_data['received_amount']		=	$this->input->post('received_amount','',TRUE);
		$money_receipt_data['money_receipt_date']	=	$this->input->post('money_receipt_date','',TRUE);

		$this->form_validation->set_rules('sales_id', 'Invoice No', 'required|integer');
		$this->form_validation->set_rules('received_amount', 'received amount', 'required|numeric');
		$this->form_validation->set_rules('money_receipt_date', 'receipt date', 'required');

        if ($this->form_validation->run() != FALSE) {

			$result				=	$this->sales_model->update_money_receipt($money_receipt_data,$money_receipt_id);
			redirect('sales/view_money_receipts','refresh');
		}else{
			$this->money_receipt($money_receipt_id);
		}
	}
	public function delete_money_receipt($money_receipt_id)
	{
		
		$this->sales_model->delete_money_receipt($money_receipt_id);

		redirect('sales/view_money_receipts','refresh');
	}

	///----------------RECEIVABLE STATUS----------

	public function generate_customer_name(){
		if (isset($_GET['term'])){
	      $search_key = strtolower($_GET['term']);
	      $this->sales_model->get_customer_like_customer_id($search_key);
	    }
	}


	public function receivable()
	{
		$data							=	array();
		$data['page_title']				=	"Inventory Management";
		$nav_data['dev_key']			=	"receivable";
		$nav_data['selected']			=	"receivable";
		$nav_data['company_name']  		=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$sales_data 					= 	array();
		$sales_data['sales']			=	$this->sales_model->get_all_sales();
		$sales_data['money_receipt']	=	$this->sales_model->get_all_money_receipts();


		// echo '<pre>';
		// print_r($sales_data['sales']);
		// print_r($sales_data['money_receipt']);
		// echo '</pre>';
		// exit();

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/receivable',$sales_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function individual_receivable()
	{
		$data							=	array();
		$data['page_title']				=	"Inventory Management";
		$nav_data['dev_key']			=	"receivable";
		$nav_data['selected']			=	"individual_receivable";
		$nav_data['company_name']  		=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$sales_data 					= 	array();
		// $sales_data 					=	$this->
		$sales_data['sales']			=	$this->sales_model->get_all_sales();
		$sales_data['money_receipt']	=	$this->mr_model->get_all_money_receipts();

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('report/individual_receivable',$sales_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function generate_individual_receivable_statement(){
		$customer_name 	=	$this->input->post('customer_name',TRUE);
		$from_date 		=	$this->input->post('from_date',TRUE);
		$to_date 		=	$this->input->post('to_date',TRUE);

		$search_result 	= 	array();

		$search_result['sales']			=	$this->sales_model->get_all_sales_by_date_and_customer_id_or_($customer_name,$from_date,$to_date);
		$search_result['money_receipt']	=	$this->sales_model->get_all_money_receipts_by_date_and_customer_name($customer_name,$from_date,$to_date);

		$output 						=	$this->load->view('report/individual_receivable_table',$search_result,TRUE);

        $error_message = 'Its a dummy error '.$customer_name.$from_date.$to_date;
        echo json_encode($output);

	}

	public function individual_receivable_pdf(){
		
		$this->load->library('pdf');

		$customer_name 	=	$this->input->post('customer_name',TRUE);
		$from_date 		=	$this->input->post('from_date',TRUE);
		$to_date 		=	$this->input->post('to_date',TRUE);

		$search_result 	= 	array();

		$search_result['sales']			=	$this->sales_model->get_all_sales_by_date_and_customer_name($customer_name,$from_date,$to_date);
		$search_result['money_receipt']	=	$this->sales_model->get_all_money_receipts_by_date_and_customer_name($customer_name,$from_date,$to_date);


        $this->pdf->load_view('report/individual_receivable_pdf',$search_result);

	}

	public function group_receivable()
	{
		$data							=	array();
		$data['page_title']				=	"Inventory Management";
		$nav_data['dev_key']			=	"receivable";
		$nav_data['selected']			=	"group_receivable";
		$nav_data['company_name']  		=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$sales_data 					= 	array();
		$sales_data['sales']			=	$this->sales_model->get_all_sales();
		$sales_data['money_receipt']	=	$this->sales_model->get_all_money_receipts();


		// echo '<pre>';
		// print_r($sales_data['sales']);
		// print_r($sales_data['money_receipt']);
		// echo '</pre>';
		// exit();

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('report/group_receivable',$sales_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function generate_group_receivable_statement(){
		$from_date 		=	$this->input->post('from_date',TRUE);
		$to_date 		=	$this->input->post('to_date',TRUE);

		$search_result 	= 	array();

		$search_result['sales']			=	$this->sales_model->get_all_sales_by_date($from_date,$to_date);

		$search_result['money_receipt']	=	$this->sales_model->get_all_money_receipts_by_date($from_date,$to_date);

		$output 						=	$this->load->view('report/group_receivable_table',$search_result,TRUE);

        $error_message = 'Its a dummy error '.$from_date.$to_date;
        echo json_encode($output);

	}
	

	public function group_receivable_pdf(){
		
		$this->load->library('pdf');

		$from_date 		=	$this->input->post('from_date',TRUE);
		$to_date 		=	$this->input->post('to_date',TRUE);

		$search_result 	= 	array();

		$search_result['sales']			=	$this->sales_model->get_all_sales_by_date($from_date,$to_date);

		$search_result['money_receipt']	=	$this->sales_model->get_all_money_receipts_by_date($from_date,$to_date);

        $this->pdf->load_view('report/group_receivable_pdf',$search_result);

	}


	///----------------END RECEIVABLE STATUS----------



	///----------------SALES REPORT-------------------

	
	public function individual_sales_report()
	{
		$data							=	array();
		$data['page_title']				=	"Sales Report";
		$nav_data['dev_key']			=	"sales_report";
		$nav_data['selected']			=	"individual_sales_report";
		$nav_data['company_name']  		=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']	=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$sales_data 					= 	array();
		$sales_data['sales']			=	$this->sales_model->get_all_sales();
		$sales_data['customer_list']	=	$this->customer_model->get_all_customers();
		$sales_data['dealer_list']		=	$this->dealer_model->get_all_dealers();

		// echo '<pre>';
		// print_r($sales_data['sales']);
		// print_r($sales_data['money_receipt']);
		// echo '</pre>';
		// exit();

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('report/individual_sales_report',$sales_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function generate_individual_sales_statement(){
		$customer_id 	=	$this->input->post('customer_id',TRUE);
		$dealer_id 	 	=	$this->input->post('dealer_id',TRUE);
		$from_date 		=	$this->input->post('from_date',TRUE);
		$to_date 		=	$this->input->post('to_date',TRUE);

		$invoice_balance 					=	0;
		$paid_amount 						=	0;

		$search_result 	= 	array();

		if($customer_id != ""){
			$search_result['sales']			=	$this->sales_model->get_individual_sales_report_by_date_and_customer_id($customer_id,$from_date,$to_date);
			$search_result['payments']		=	$this->sales_model->get_individual_money_receipt_by_date_and_customer_id($customer_id,$from_date,$to_date);
			$invoice_balance 				=	$this->sales_model->get_invoice_balance_by_customer_id($customer_id);
			$paid_amount					=	$this->sales_model->get_paid_amount_by_customer_id($customer_id);
		} elseif($dealer_id !=""){
			$search_result['sales']			=	$this->sales_model->get_individual_sales_report_by_date_and_dealer_id($dealer_id,$from_date,$to_date);
			$search_result['payments']		=	$this->sales_model->get_individual_money_receipt_by_date_and_dealer_id($dealer_id,$from_date,$to_date);
			$invoice_balance 				=	$this->sales_model->get_invoice_balance_by_dealer_id($dealer_id);
			$paid_amount					=	$this->sales_model->get_paid_amount_by_dealer_id($dealer_id);
		}

		$search_result['balance']			=	$invoice_balance[0]->invoice_balance - $paid_amount->paid_amount;

		$output 							=	$this->load->view('report/individual_sales_table',$search_result,TRUE);

        $error_message = 'Its a dummy error '.$customer_id.$from_date.$to_date;
        echo json_encode($output);

	}

	public function individual_sales_pdf(){

		$this->load->library('pdf');

		$customer_name 	=	$this->input->post('customer_name',TRUE);
		$from_date 		=	$this->input->post('from_date',TRUE);
		$to_date 		=	$this->input->post('to_date',TRUE);

		$search_result 	= 	array();

		$search_result['sales']			=	$this->sales_model->get_individual_sales_report_by_date_and_customer_name($customer_name,$from_date,$to_date);
		$search_result['payments']		=	$this->sales_model->get_individual_money_receipt_by_date_and_customer_name($customer_name,$from_date,$to_date);

        $this->pdf->load_view('report/individual_sales_pdf',$search_result);
	}


	public function group_sales_report()
	{
		$data							=	array();
		$data['page_title']				=	"Sales Report";
		$nav_data['dev_key']			=	"sales_report";
		$nav_data['selected']			=	"group_sales_report";
		$nav_data['company_name']  		=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$sales_data 					= 	array();
		$sales_data['sales']			=	$this->sales_model->get_all_sales();

		// echo '<pre>';
		// print_r($sales_data['sales']);
		// print_r($sales_data['money_receipt']);
		// echo '</pre>';
		// exit();

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('report/group_sales_report',$sales_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function generate_group_sales_statement(){
		$from_date 		=	$this->input->post('from_date',TRUE);
		$to_date 		=	$this->input->post('to_date',TRUE);

		$search_result 	= 	array();

		$search_result['sales']			=	$this->sales_model->get_group_sales_report_by_date($from_date,$to_date);

		$output 						=	$this->load->view('report/group_sales_table',$search_result,TRUE);

        $error_message = 'Its a dummy error '.$from_date.$to_date;
        echo json_encode($output);

	}

	public function group_sales_pdf(){

		$this->load->library('pdf');

		$from_date 		=	$this->input->post('from_date',TRUE);
		$to_date 		=	$this->input->post('to_date',TRUE);

		$search_result 	= 	array();

		$search_result['sales']			=	$this->sales_model->get_group_sales_report_by_date($from_date,$to_date);

        $this->pdf->load_view('report/group_sales_pdf',$search_result);
	}



	//-----------------INVOICE ---------------


	public function sales_invoice($sales_id){
		$this->load->library('mypdf');
		$pdf = $this->mypdf->load();

		$invoice_balance 				=	0;
		$paid_amount 					=	0;

		$sales_data 					= 	array();

		$sales_data['company_detail']	=	$this->company_model->get_company_by_id('1');
		
		$sales_data['sales']			=	$this->sales_model->get_sales_by_id($sales_id);
		$sales_data['sales_detail']		=	$this->sales_model->get_sales_details_by_id($sales_id,$sales_data['sales']->warehouse_id);

		if($sales_data['sales']->customer_id!=0){
			$sales_data['customer']		 	=	$this->customer_model->get_customer_by_id($sales_data['sales']->customer_id);
			$invoice_balance 				=	$this->sales_model->get_invoice_balance_by_customer_id($sales_data['sales']->customer_id);
			$paid_amount					=	$this->sales_model->get_paid_amount_by_customer_id($sales_data['sales']->customer_id);
		}elseif ($sales_data['sales']->dealer_id!=0){
			$sales_data['dealer']		 	=	$this->dealer_model->get_dealer_by_id($sales_data['sales']->dealer_id);
			$invoice_balance 				=	$this->sales_model->get_invoice_balance_by_dealer_id($sales_data['sales']->dealer_id);
			$paid_amount					=	$this->sales_model->get_paid_amount_by_dealer_id($sales_data['sales']->dealer_id);
		}
		
		$sales_data['balance'] 			=	$invoice_balance[0]->invoice_balance - $paid_amount->paid_amount;

		$sales_data['total_in_words']	=	$this->convert_model->convert_number($sales_data['sales']->total_price);


		// echo '<pre>';print_r($invoice_balance); echo '</pre>'; exit();

		$data 							= 	$this->load->view('partials/sales_invoice',$sales_data,TRUE);
		
		$pdf->writeHTML($data);
		$pdf->Output();

		// $this->load->view('partials/purchase_invoice1');
	}

	//------------------SALES RETURN---------------------

	public function sales_return($sales_return_id = 0, $error_count = 0)
	{
		$data						=	array();
		$data['page_title']			=	"Inventory Management";

		$nav_data					=	array();
		$nav_data['dev_key']		=	"sales";
		$nav_data['selected']		=	"sales_return";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$sales_data					=	array();
		$sales_data['item_list']	=	$this->item_model->get_all_items();
		$sales_data['customer_list']=	$this->customer_model->get_all_customers();

		if($sales_id != 0){
			$sales_data['sales']		=	$this->sales_model->get_sales_by_id($sales_id);
			$sales_data['sales_detail']	=	$this->sales_model->get_sales_details_by_id($sales_id);
		}else{
			$sales_data['sales']		=	NULL;
			$sales_data['sales_detail']	=	NULL;
		}
		if($error_count != 0){
			$sales_data['error_content']			=	$error_count +1;
		}else{
			$sales_data['error_content']			=	NULL;
		}

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/sales',$sales_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}
	public function view_sales_return()
	{
		$data						=	array();
		$data['page_title']			=	"Inventory Management";
		$nav_data['dev_key']		=	"sales";
		$nav_data['selected']		=	"all_sales";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$sales_data 				= 	array();
		$sales_data['sales_list']	=	$this->sales_model->get_all_sales();
		$sales_data['permission']	= 	$this->module_model->get_permission_by_module_id_and_user_id(9,$this->session->userdata('user_id'));

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/sales_list',$sales_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}


	public function add_sales_return()
	{
		$sales_data						=	array();
		$sales_data['user_id']			=	$this->session->userdata('user_id');
		$sales_data['user_name']		=	$this->session->userdata('user_name');
		
		$sales_data['customer_id']		=	$this->input->post('customer_id','',TRUE);
		$sales_data['customer_name']	=	$this->customer_model->get_customer_by_id($sales_data['customer_id'])->customer_name;
		
		$sales_data['sales_date']		=	$this->input->post('sales_date','',TRUE);
		$sales_data['overall_discount']	=	$this->input->post('sales_discount','',TRUE);

		$error_count					=	$this->input->post('count','',TRUE);

		$item_id						=	$this->input->post('item_id','',TRUE);
		$item_name						=	$this->input->post('item_name','',TRUE);
		$sales_price					=	$this->input->post('sales_price','',TRUE);
		$discount 						=	$this->input->post('discount','',TRUE);
		$quantity						=	$this->input->post('quantity','',TRUE);
		$stock[]						=	array();

		for ($i=0; $i < $error_count ; $i++) { 
			$stock[$i]					=	$this->item_model->get_item_by_id($item_id[$i])->quantity;
			$this->form_validation->set_rules('discount['.$i.']', 'Discount', 'required|numeric');
        	$this->form_validation->set_rules('quantity['.$i.']', 'Quantity', 'required|numeric|less_than_equal_to['.$stock[$i].']');
        	$this->form_validation->set_message('less_than_equal_to', 'There are only {param} {field} left');
		}

		$this->form_validation->set_rules('sales_price[]', 'Sales price', 'required|numeric');
        $this->form_validation->set_rules('sales_date', 'Sales Date', 'required');

        if ($this->form_validation->run() != FALSE) {

			$result							=	$this->sales_model->add_sales($sales_data);

			$sales_detail_data				=	array();

			for ($i=0; $i < $error_count ; $i++) { 
				$sales_detail_data['sales_id']				=	$result;
				$sales_detail_data['customer_id']			=	$sales_data['customer_id'];
				$sales_detail_data['item_id']				=	$item_id[$i];
				$sales_detail_data['item_name']				=	$item_name[$i];
				$sales_detail_data['sales_price']			=	$sales_price[$i];
				$sales_detail_data['individual_discount']	=	$discount[$i];
				$sales_detail_data['overall_discount']		=	$sales_data['overall_discount'];
				$sales_detail_data['sales_date']			=	$sales_data['sales_date'];
				$sales_detail_data['quantity']				=	$quantity[$i];
				$detail_result								=	$this->sales_model->add_sales_detail($sales_detail_data);

				$this->item_model->subtract_item_quantity($sales_detail_data['item_id'],$sales_detail_data['quantity']);
			}
			redirect('sales/view_sales','refresh');
		}else{
			$this->index(0,$error_count);
		}
	}

	public function update_sales_return($sales_id)
	{
		$sales_data						=	array();
		$sales_data['user_id']			=	$this->session->userdata('user_id');
		$sales_data['user_name']		=	$this->session->userdata('user_name');
		

		$sales_data['customer_id']		=	$this->input->post('customer_id','',TRUE);
		$sales_data['customer_name']	=	$this->customer_model->get_customer_by_id($sales_data['customer_id'])->customer_name;

		
		$sales_data['sales_date']		=	$this->input->post('sales_date','',TRUE);
		$sales_data['overall_discount']	=	$this->input->post('sales_discount','',TRUE);

		$error_count					=	$this->input->post('count','',TRUE);

		$item_id						=	$this->input->post('item_id','',TRUE);
		$item_name						=	$this->input->post('item_name','',TRUE);
		$sales_price					=	$this->input->post('sales_price','',TRUE);
		$discount 						=	$this->input->post('discount','',TRUE);
		$quantity						=	$this->input->post('quantity','',TRUE);

		$sales_detail					=	$this->sales_model->get_sales_details_by_id($sales_id);

		$stock[]						=	array();

		for ($i=0; $i < $error_count ; $i++) {
			$stock[$i]					=	$this->item_model->get_item_by_id($item_id[$i])->quantity;
        	$this->form_validation->set_rules('quantity['.$i.']', 'Quantity', 'required|numeric|less_than_equal_to['.$stock[$i].']');
        	$this->form_validation->set_message('less_than_equal_to', 'There are only {param} {field} left');
		}

		$this->form_validation->set_rules('sales_price[]', 'Sales price', 'required|numeric');
	    $this->form_validation->set_rules('sales_date', 'Sales Date', 'required');

        if ($this->form_validation->run() != FALSE) {

			$this->sales_model->update_sales($sales_data,$sales_id);

			$this->delete_sales_detail($sales_id);

			$count							=	$this->input->post('count','',TRUE);

			$sales_detail_data				=	array();

			for ($i=0; $i < $count ; $i++) {
				$sales_detail_data['sales_id']				=	$sales_id;
				$sales_detail_data['customer_id']			=	$sales_data['customer_id'];
				$sales_detail_data['item_id']				=	$item_id[$i];
				$sales_detail_data['item_name']				=	$item_name[$i];
				$sales_detail_data['sales_price']			=	$sales_price[$i];
				$sales_detail_data['individual_discount']	=	$discount[$i];
				$sales_detail_data['overall_discount']		=	$sales_data['overall_discount'];
				$sales_detail_data['quantity']				=	$quantity[$i];
				$sales_detail_data['sales_date']			=	$sales_data['sales_date'];
				
				$detail_result								=	$this->sales_model->add_sales_detail($sales_detail_data);

				$sales_detail 								=	$this->sales_model->get_sales_details_by_sales_id_and_item_id($sales_id,$sales_detail_data['item_id']);

				$this->item_model->subtract_item_quantity($sales_detail_data['item_id'],$quantity[$i]);
			}

			redirect('sales/view_sales','refresh');
		}else{
			$this->index($sales_id,$error_count);
		}
	}

	public function delete_sales_return($sales_id)
	{
		
		$this->sales_model->delete_sales($sales_id);
		$this->delete_sales_detail($sales_id);
		redirect('sales/view_sales','refresh');
	}

	
}
