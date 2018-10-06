<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Inventory extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('user_id')==NULL){
			redirect('login','refresh');
		}
		$this->load->model('inventory_model','inventory_model',TRUE);
		$this->load->model('warehouse_model','warehouse_model',TRUE);
		$this->load->model('group_model','group_model',TRUE);
		$this->load->model('item_model','item_model',TRUE);
		$this->load->model('stock_model','stock_model',TRUE);
		$this->load->model('stock_transfer_model','stock_transfer_model',TRUE);
		$this->load->model('company_model','company_model',TRUE);
		$this->load->model('purchase_model','purchase_model',TRUE);
		$this->load->model('module_model','module_model',TRUE);
		$this->load->library('form_validation');
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
	public function index()
	{
		$data						=	array();
		$data['page_title']			=	"Inventory Management";
		$nav_data['dev_key']		=	"inventory";
		$nav_data['selected']		=	"individual_report";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));


		$item_data					=	array();
		$item_data['item_list']		=	$this->item_model->get_all_items();

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('report/individual_inventory_report',$item_data,TRUE);

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


	public function generate_item_name(){
		if (isset($_GET['term'])){
	      $search_key = strtolower($_GET['term']);
	      $this->item_model->get_item_like_name_id($search_key);
	    }
	}

	public function generate_individual_inventory_detail(){
		$item_id 		=	$this->input->post('item_id',TRUE);
		$from_date 		=	$this->input->post('from_date',TRUE);
		$to_date 		=	$this->input->post('to_date',TRUE);

		$purchase_quantity 	=	0;
		$purchase_rate  	=	0;
		$stock_value 		=	0;

		$sales_quantity 	=	0;
		$sales_price		=	0;

		$search_result 	= 	array();

		$opening_purchase_quantity 					=	$this->inventory_model->get_opening_item_purchase_quantity_by_item_id_and_date($item_id,$from_date);

		$opening_sales_quantity 					=	$this->inventory_model->get_opening_item_sales_quantity_by_item_id_and_date($item_id,$from_date);

		if($opening_purchase_quantity){
			$search_result['opening_purchase_quantity']	=	$opening_purchase_quantity->purchase_quantity;
		}else{
			$search_result['opening_purchase_quantity'] =	0;
		}

		if($opening_sales_quantity){
			$search_result['opening_sales_quantity']	=	$opening_sales_quantity->sales_quantity;
		}else{
			$search_result['opening_sales_quantity']	=	0;
		}


		$search_result['sales_data'] 	=	$this->inventory_model->get_sales_by_item_id_and_date($item_id,$from_date,$to_date);

		$search_result['purchase_data'] =	$this->inventory_model->get_purchase_by_item_id_and_date($item_id,$from_date,$to_date);

		$sales_qty 						=	$this->inventory_model->get_item_sales_quantity_by_item_id_and_date($item_id,$to_date);

		$purchase_qty_and_price			=	$this->inventory_model->get_item_purchase_quantity_by_item_id_and_date($item_id,$to_date);

		$item_detail 					=	$this->item_model->get_item_by_id($item_id);

		if($purchase_qty_and_price != NULL){
			$purchase_quantity 			=	$purchase_qty_and_price->purchase_quantity;
			$purchase_rate 				=	$purchase_qty_and_price->item_rate;
			$stock_value 				=	$purchase_qty_and_price->stock_value;
		}

		// echo "<pre>";print_r($purchase_qty_and_price); echo "</pre>";exit();

		$search_result['stock'] 		=	$item_detail->quantity;

		$search_result['item_rate']		=	$purchase_rate;

		$search_result['stock_value']	=	$stock_value;

		// echo "<pre>";print_r($search_result); echo "</pre>";

		$output 						=	$this->load->view('report/individual_inventory_table',$search_result,TRUE);

        $error_message = 'Its a dummy error '.$item_id.$from_date.$to_date;
        echo json_encode($output);

	}

	public function individual_inventory_pdf(){
		$this->load->library('pdf');

		$item_name 		=	$this->input->post('item_name',TRUE);
		$from_date 		=	$this->input->post('from_date',TRUE);
		$to_date 		=	$this->input->post('to_date',TRUE);

		$search_result 	= 	array();

		$opening_purchase_quantity 					=	$this->inventory_model->get_opening_item_purchase_quantity_by_item_name_and_date($item_name,$from_date);

		$opening_sales_quantity 					=	$this->inventory_model->get_opening_item_sales_quantity_by_item_name_and_date($item_name,$from_date);

		if($opening_purchase_quantity){
			$search_result['opening_purchase_quantity']	=	$opening_purchase_quantity->purchase_quantity;
		}else{
			$search_result['opening_purchase_quantity'] =	0;
		}

		if($opening_sales_quantity){
			$search_result['opening_sales_quantity']	=	$opening_sales_quantity->sales_quantity;
		}else{
			$search_result['opening_sales_quantity']	=	0;
		}

		$search_result['sales_data'] 	=	$this->inventory_model->get_sales_by_item_name_and_date($item_name,$from_date,$to_date);

		$search_result['purchase_data'] =	$this->inventory_model->get_purchase_by_item_name_and_date($item_name,$from_date,$to_date);

		$purchase_qty_and_price			=	$this->inventory_model->get_item_purchase_quantity_by_item_name_and_date($item_name,$to_date);

		$sales_qty 						=	$this->inventory_model->get_item_sales_quantity_by_item_name_and_date($item_name,$to_date);

		$search_result['stock'] 		=	$purchase_qty_and_price->purchase_quantity - $sales_qty->sales_quantity;

		$search_result['item_rate']		=	$purchase_qty_and_price->item_rate;

		$search_result['stock_value']	=	$purchase_qty_and_price->stock_value;

    	$this->pdf->load_view('report/individual_inventory_pdf',$search_result,$item_name.'_inventory_report');


	}

	//-----------------------GROUP INVENTORY------------------

	public function group_inventory()
	{
		$data						=	array();
		$data['page_title']			=	"Inventory Management";
		$nav_data['dev_key']		=	"inventory";
		$nav_data['selected']		=	"group_inventory";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));


		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('report/group_inventory_report','',TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function generate_group_inventory_detail(){
		$from_date 		=	$this->input->post('from_date',TRUE);
		$to_date 		=	$this->input->post('to_date',TRUE);

		$search_result 	= 	array();

		$search_result['item_data']					=	$this->item_model->get_all_items();

		$search_result['purchase_data'] 			=	$this->inventory_model->get_group_purchase_inventory_data_by_date($from_date,$to_date);

		$search_result['sales_data'] 				=	$this->inventory_model->get_group_sales_inventory_data_by_date($from_date,$to_date);

		$search_result['total_purchase_quantity']	=	$this->inventory_model->get_purchase_quantity_by_date($to_date);

		$search_result['total_sales_quantity']		=	$this->inventory_model->get_sales_quantity_by_date($to_date);
		

		$output 									=	$this->load->view('report/group_inventory_table',$search_result,TRUE);

        $error_message = 'Its a dummy error '.$from_date.$to_date;

        echo json_encode($output);

	}

	public function group_inventory_pdf(){
		$from_date 		=	$this->input->post('from_date',TRUE);
		$to_date 		=	$this->input->post('to_date',TRUE);

		$search_result 	= 	array();

		$search_result['item_data']					=	$this->item_model->get_all_items();

		$search_result['purchase_data'] 			=	$this->inventory_model->get_group_purchase_inventory_data_by_date($from_date,$to_date);

		$search_result['sales_data'] 				=	$this->inventory_model->get_group_sales_inventory_data_by_date($from_date,$to_date);

		$search_result['total_purchase_quantity']	=	$this->inventory_model->get_purchase_quantity_by_date($to_date);

		$search_result['total_sales_quantity']		=	$this->inventory_model->get_sales_quantity_by_date($to_date);

    	$html 										=	$this->load->view('report/group_inventory_pdf',$search_result,TRUE);
 
        $pdfFilePath 								= 	"group_inventory.pdf";
 
        $this->load->library('m_pdf');
 
        $this->m_pdf->pdf->WriteHTML($html);
 
        $this->m_pdf->pdf->Output($pdfFilePath, "D");  
	}

	//----------------WAREHOUSE INVENTORY---------------

	public function warehouse_inventory()
	{
		$data						=	array();
		$data['page_title']			=	"Inventory Management";
		$nav_data['dev_key']		=	"inventory";
		$nav_data['selected']		=	"warehouse_inventory";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$warehouse_inventory_data	=	array();
		$warehouse_inventory_data['warehouse_list'] =	$this->warehouse_model->get_all_warehouses();

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('report/warehouse_inventory_report',$warehouse_inventory_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function generate_warehouse_inventory_detail(){
		$warehouse_id 	=	$this->input->post('warehouse_id',TRUE);
		$from_date 		=	$this->input->post('from_date',TRUE);
		$to_date 		=	$this->input->post('to_date',TRUE);

		$search_result 	= 	array();

		$search_result['item_data']					=	$this->stock_model->get_all_items_by_warehouse_id($warehouse_id);
		

		$search_result['purchase_data'] 			=	$this->inventory_model->get_group_purchase_inventory_data_by_date_and_warehouse_id($warehouse_id, $from_date,$to_date);

		$search_result['sales_data'] 				=	$this->inventory_model->get_group_sales_inventory_data_by_date_and_warehouse_id($warehouse_id,$from_date,$to_date);

		$search_result['sent_stock_data'] 			=	$this->stock_transfer_model->get_sent_stock_transfer_data_by_date_and_warehouse_id($warehouse_id,$from_date,$to_date);

		$search_result['received_stock_data'] 		=	$this->stock_transfer_model->get_received_stock_transfer_data_by_date_and_warehouse_id($warehouse_id,$from_date,$to_date);

		$search_result['total_purchase_quantity']	=	$this->inventory_model->get_purchase_quantity_by_date($to_date);

		$search_result['total_sales_quantity']		=	$this->inventory_model->get_sales_quantity_by_date($to_date);

		// echo '<pre>';print_r($search_result);echo '</pre>';exit();

		$output 									=	$this->load->view('report/warehouse_inventory_table',$search_result,TRUE);

        $error_message = 'Its a dummy error '.$from_date.$to_date;

        echo json_encode($output);

	}

	public function warehouse_inventory_pdf(){
		$warehouse_id 	=	$this->input->post('warehouse_id',TRUE);
		$from_date 		=	$this->input->post('from_date',TRUE);
		$to_date 		=	$this->input->post('to_date',TRUE);

		$warehouse_detail 							=	$this->warehouse_model->get_warehouse_by_id($warehouse_id);

		$search_result 	= 	array();

		$search_result['item_data']					=	$this->stock_model->get_all_items_by_warehouse_id($warehouse_id);
		

		$search_result['purchase_data'] 			=	$this->inventory_model->get_group_purchase_inventory_data_by_date_and_warehouse_id($warehouse_id, $from_date,$to_date);

		$search_result['sales_data'] 				=	$this->inventory_model->get_group_sales_inventory_data_by_date_and_warehouse_id($warehouse_id,$from_date,$to_date);

		$search_result['sent_stock_data'] 			=	$this->stock_transfer_model->get_sent_stock_transfer_data_by_date_and_warehouse_id($warehouse_id,$from_date,$to_date);

		$search_result['received_stock_data'] 		=	$this->stock_transfer_model->get_received_stock_transfer_data_by_date_and_warehouse_id($warehouse_id,$from_date,$to_date);

		$search_result['total_purchase_quantity']	=	$this->inventory_model->get_purchase_quantity_by_date($to_date);

		$search_result['total_sales_quantity']		=	$this->inventory_model->get_sales_quantity_by_date($to_date);

        $html 										=	$this->load->view('report/warehouse_inventory_pdf',$search_result,TRUE);
 
        $pdfFilePath 								= 	"warehouse_inventory.pdf";
 
        $this->load->library('m_pdf');

 		$this->m_pdf->pdf->SetHeader('Warehouse Stock Report of '.$warehouse_detail->warehouse_name);

 		$this->m_pdf->pdf->AddPage('L');

        $this->m_pdf->pdf->WriteHTML($html);

        $this->m_pdf->pdf->Output($pdfFilePath, "D");   
	}

}
