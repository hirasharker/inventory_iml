<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Stock_Transfer extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('user_id')==NULL){
			redirect('login','refresh');
		}
		$this->load->model('stock_transfer_model','stock_transfer_model',TRUE);
		$this->load->model('sales_model','sales_model',TRUE);
		$this->load->model('payment_model','payment_model',TRUE);
		$this->load->model('item_model','item_model',TRUE);
		$this->load->model('warehouse_model','warehouse_model',TRUE);
		$this->load->model('stock_model','stock_model',TRUE);
		$this->load->model('stock_transfer_model','stock_transfer_model',TRUE);
		$this->load->library('form_validation');
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
	public function index($stock_transfer_id=0,$error_count=0)
	{
		$data							=	array();
		$data['page_title']				=	"Inventory Management";

		$nav_data						=	array();
		$nav_data['dev_key']			=	"stock_transfer";
		$nav_data['selected']			=	"create_transfer";
		$nav_data['company_name']   	=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']	=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$stock_transfer_data							=	array();
		$stock_transfer_data['item_list']				=	$this->item_model->get_all_items();
		$stock_transfer_data['warehouse_list']			=	$this->warehouse_model->get_all_warehouses();
		
		if($stock_transfer_id!=0){
			$stock_transfer_data['stock_transfer']		=	$this->stock_transfer_model->get_stock_transfer_by_id($stock_transfer_id);
			$stock_transfer_data['stock_transfer_detail']=	$this->stock_transfer_model->get_stock_transfer_detail_by_transfer_id($stock_transfer_id);
		}else{
			$stock_transfer_data['stock_transfer']		=	NULL;
		}

		if($error_count != 0){
			$stock_transfer_data['error_content']		=	$error_count+1;	
		}else{
			$stock_transfer_data['error_content']		=	NULL;
		}

		$data['navigation']				=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']					=	$this->load->view('templates/footer','',TRUE);
		$data['content']				=	$this->load->view('partials/stock_transfer',$stock_transfer_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function add_stock_transfer(){
		$stock_transfer_data							=	array();
		
		$stock_transfer_data['previous_warehouse_id']				=	$this->input->post('previous_warehouse_id','',TRUE);
		$stock_transfer_data['current_warehouse_id']				=	$this->input->post('current_warehouse_id','',TRUE);
		$stock_transfer_data['stock_transfer_date']					=	$this->input->post('stock_transfer_date','',TRUE);

		$stock_transfer_data['user_id']								=	$this->session->userdata('user_id');
		$stock_transfer_data['user_name']							=	$this->session->userdata('user_name');

		$error_count					=	$this->input->post('count','',TRUE);

		$item_id						=	$this->input->post('item_id','',TRUE);
		$item_name						=	$this->input->post('item_name','',TRUE);
		$quantity						=	$this->input->post('quantity','',TRUE);

		$pre_warehouse_id 				=	$stock_transfer_data['previous_warehouse_id'];
		$curr_warehouse_id 				=	$stock_transfer_data['current_warehouse_id'];


		$stock[]						=	array();

		for ($i=0; $i < $error_count ; $i++) { 
			$stock[$i]					=	$this->stock_model->get_stock_by_item_and_warehouse_id($item_id[$i], $pre_warehouse_id)->quantity;
        	$this->form_validation->set_rules('quantity['.$i.']', 'Quantity', 'required|numeric|less_than_equal_to['.$stock[$i].']');
        	$this->form_validation->set_message('less_than_equal_to', 'There are only {param} {field} left');
		}

        $this->form_validation->set_rules('stock_transfer_date', 'Transfer date', 'required');

        if ($this->form_validation->run() != FALSE) {

			$result											=	$this->stock_transfer_model->add_stock_transfer($stock_transfer_data);

			$stock_transfer_detail_data						=	array();


			for ($i=0; $i < $error_count ; $i++) { 
				$stock_transfer_detail_data['stock_transfer_id']		=	$result;
				$stock_transfer_detail_data['item_id']					=	$item_id[$i];
				$stock_transfer_detail_data['item_name']				=	$item_name[$i];
				$stock_transfer_detail_data['quantity']					=	$quantity[$i];

				$stock_transfer_detail_data['previous_warehouse_id']	=	$pre_warehouse_id;
				$stock_transfer_detail_data['current_warehouse_id']		=	$curr_warehouse_id;

				$detail_result											=	$this->stock_transfer_model->add_stock_transfer_detail($stock_transfer_detail_data);

				$stock_found 											=	$this->stock_model->get_stock_by_item_and_warehouse_id($stock_transfer_detail_data['item_id'], $stock_transfer_detail_data['current_warehouse_id']);

				$this->stock_model->subtract_stock_quantity($stock_transfer_detail_data['item_id'], $stock_transfer_detail_data['previous_warehouse_id'], $stock_transfer_detail_data['quantity']);

				if($stock_found == NULL){
					$stock_data 							=	array();
					$stock_data['item_id']					=	$item_id[$i];
					$stock_data['warehouse_id']				=	$stock_transfer_detail_data['current_warehouse_id'];
					$stock_data['item_name']				=	$item_name[$i];
					$stock_data['quantity']					=	$quantity[$i];

					$stock_result 							=	$this->stock_model->add_stock($stock_data);
				
				} else {
					
					$this->stock_model->add_stock_quantity($stock_transfer_detail_data['item_id'], $stock_transfer_detail_data['current_warehouse_id'], $stock_transfer_detail_data['quantity']);

				}

			}
			redirect('stock_transfer/view_transfer_records','refresh');
		}else{
			$this->index(0,$error_count);
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



	public function view_transfer_records()
	{
		$data							=	array();
		$data['page_title']				=	"Stock Transfer - Inventory Management";
		$nav_data['dev_key']			=	"stock_transfer";
		$nav_data['selected']			=	"all_transfer_records";
		$nav_data['company_name']   	=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission'] 	=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$stock_transfer_data							=	array();
		$stock_transfer_data['stock_transfer_list']		=	$this->stock_transfer_model->get_all_stock_transfers();
		$stock_transfer_data['warehouse_list']			=	$this->warehouse_model->get_all_warehouses();
		$stock_transfer_data['permission']				= 	$this->module_model->get_permission_by_module_id_and_user_id(15,$this->session->userdata('user_id'));

		$data['navigation']								=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']									=	$this->load->view('templates/footer','',TRUE);
		$data['content']								=	$this->load->view('partials/stock_transfer_list',$stock_transfer_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}


	public function get_warehouse_list_without_previous_warehouse(){
		$warehouse_id = $this->input->post('previousWarehouseId');

		$warehouse_list 				=	$this->warehouse_model->get_warehouses_except_this_id($warehouse_id);

		echo json_encode($warehouse_list);
		// a die here helps ensure a clean ajax call
		die();
	}

	public function get_item_by_warehouse_id(){
		$warehouse_id = $this->input->post('warehouseId');

		$item_list 						=	$this->stock_model->get_item_by_warehouse_id($warehouse_id);

		echo json_encode($item_list);
		// a die here helps ensure a clean ajax call
		die();
	}

	

}
