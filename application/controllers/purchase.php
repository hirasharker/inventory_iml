<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Purchase extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('user_id')==NULL){
			redirect('login','refresh');
		}
		$this->load->model('purchase_model','purchase_model',TRUE);
		$this->load->model('sales_model','sales_model',TRUE);
		$this->load->model('payment_model','payment_model',TRUE);
		$this->load->model('warehouse_model','warehouse_model',TRUE);
		$this->load->model('stock_model','stock_model',TRUE);
		$this->load->model('item_model','item_model',TRUE);
		$this->load->library('form_validation');
		$this->load->model('company_model','company_model',TRUE);
		$this->load->model('module_model','module_model',TRUE);

		$this->load->model('upload_model','upload_model',TRUE);
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
	public function index($purchase_id=0,$error_count=0)
	{
		$data							=	array();
		$data['page_title']				=	"Inventory Management";

		$nav_data						=	array();
		$nav_data['dev_key']			=	"purchase";
		$nav_data['selected']			=	"add_purchase";
		$nav_data['company_name']   	=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$purchase_data					=	array();
		$purchase_data['item_list']		=	$this->item_model->get_all_items();
		$purchase_data['vendor_list']	=	$this->purchase_model->get_all_vendors();
		$purchase_data['warehouse_list']=	$this->warehouse_model->get_all_warehouses();
		$purchase_data['warehouse_slot_list']=	$this->warehouse_model->get_all_warehouse_slots();
		if($purchase_id!=0){
			$purchase_data['purchase']			=	$this->purchase_model->get_purchase_by_id($purchase_id);
			$purchase_data['purchase_detail']	=	$this->purchase_model->get_purchase_details_by_id($purchase_id);
		}else{
			$purchase_data['purchase']			=	NULL;
			$purchase_data['purchase_detail']	=	NULL;
		}
		if($error_count != 0){
			$purchase_data['error_content']	=	$error_count+1;	
		}else{
			$purchase_data['error_content']	=	NULL;
		}

		$data['navigation']				=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']					=	$this->load->view('templates/footer','',TRUE);
		$data['content']				=	$this->load->view('partials/purchase',$purchase_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}


	public function view_purchases()
	{
		$data							=	array();
		$data['page_title']				=	"Inventory Management";
		$nav_data['dev_key']			=	"purchase";
		$nav_data['selected']			=	"all_purchases";
		$nav_data['company_name']   	=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission'] 	=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$purchase_data					=	array();
		$purchase_data['purchase_list']	=	$this->purchase_model->get_all_purchases();
		$purchase_data['permission']	= 	$this->module_model->get_permission_by_module_id_and_user_id(5,$this->session->userdata('user_id'));

		$data['navigation']				=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']					=	$this->load->view('templates/footer','',TRUE);
		$data['content']				=	$this->load->view('partials/purchase_list',$purchase_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	

	public function add_purchase()
	{
		$purchase_data						=	array();
		$purchase_data['user_id']			=	$this->session->userdata('user_id');
		$purchase_data['user_name']			=	$this->session->userdata('user_name');

		$purchase_data['purchase_id']		=	$this->input->post('purchase_id','',TRUE);
		$purchase_data['vendor_id']			=	$this->input->post('vendor_id','',TRUE);
		$purchase_data['vendor_name']		=	$this->purchase_model->get_vendor_by_id($purchase_data['vendor_id'])->vendor_name;
		$purchase_data['warehouse_id']		=	$this->input->post('warehouse_id','',TRUE);

		$purchase_data['purchase_date']		=	$this->input->post('purchase_date','',TRUE);
		$purchase_data['purchase_discount']	=	$this->input->post('purchase_discount','',TRUE);

		$item_insertion_mode 				=	$this->input->post('item_insertion_mode','',TRUE);

		if($item_insertion_mode == 2){

			$session_data										=	array();

			$file_name 											=	NULL;

			$purchase_upload									=	$this->upload_model->upload_file('purchase_list',''); //after upload
			if(isset($purchase_upload['file_name'])){
				$file_name 			 							=	$purchase_upload['file_name'];
			}else{
				$session_data['error'] 							=	$purchase_upload['error'];
				$this->session->set_userdata($session_data);
				redirect('purchase','refresh');
			}
			
			$this->upload_purchase($purchase_data, $file_name);

			redirect('purchase/view_purchases','refresh');
		}

		$error_count					=	$this->input->post('count','',TRUE);

		$item_id						=	$this->input->post('item_id','',TRUE);
		$item_name						=	$this->input->post('item_name','',TRUE);
		$purchase_price					=	$this->input->post('purchase_price','',TRUE);
		$quantity						=	$this->input->post('quantity','',TRUE);

		for ($i=0; $i < $error_count ; $i++) { 
        	$this->form_validation->set_rules('quantity['.$i.']', 'Quantity', 'required|numeric|greater_than[0]');
        	$this->form_validation->set_message('less_than_equal_to', 'Quantity must be greater than 0');
		}

		$this->form_validation->set_rules('purchase_price[]', 'Purchase price', 'required|numeric');
        $this->form_validation->set_rules('purchase_date', 'Purchase date', 'required');

        if ($this->form_validation->run() != FALSE) {

			$result										=	$this->purchase_model->add_purchase($purchase_data);

			$purchase_detail_data						=	array();

			$purchase_detail_data['warehouse_id']		=	$purchase_data['warehouse_id'];

			$purchase_detail_data['purchase_date']		=	$purchase_data['purchase_date'];

			for ($i=0; $i < $error_count ; $i++) { 
				// $purchase_detail_data['purchase_id']		=	$result;
				$purchase_detail_data['purchase_id']		=	$purchase_data['purchase_id'];
				$purchase_detail_data['item_id']			=	$item_id[$i];
				$purchase_detail_data['item_name']			=	$item_name[$i];
				$purchase_detail_data['purchase_price']		=	$purchase_price[$i];
				$purchase_detail_data['quantity']			=	$quantity[$i];
				$purchase_detail_data['purchase_discount']	=	$purchase_data['purchase_discount'];
				$detail_result								=	$this->purchase_model->add_purchase_detail($purchase_detail_data);

				$this->item_model->add_item_quantity($purchase_detail_data['item_id'],$purchase_detail_data['quantity']);

				$stock_found 								=	$this->stock_model->get_stock_by_item_and_warehouse_id($purchase_detail_data['item_id'], $purchase_detail_data['warehouse_id']);

				if($stock_found == NULL){
					$stock_data 							=	array();
					$stock_data['item_id']					=	$item_id[$i];
					$stock_data['warehouse_id']				=	$purchase_detail_data['warehouse_id'];
					$stock_data['item_name']				=	$item_name[$i];
					$stock_data['quantity']					=	$quantity[$i];

					$stock_result 							=	$this->stock_model->add_stock($stock_data);
				} else {
					$this->stock_model->add_stock_quantity($purchase_detail_data['item_id'], $purchase_detail_data['warehouse_id'], $purchase_detail_data['quantity']);
				}

			}
			redirect('purchase/view_purchases','refresh');
		}else{
			$this->index(0,$error_count);
		}
	}

	public function upload_purchase($purchase_data, $file_name){
		
		$this->load->library('csvreader');

		$result												=	$this->csvreader->parse_file($file_name);

		$count 												=	0;

		$purchase_detail_data 								=	array();

		$purchase_detail_data['purchase_id']				=	$purchase_data['purchase_id'];

		$purchase_detail_data['warehouse_id']				=	$purchase_data['warehouse_id'];

		$purchase_detail_data['purchase_date']				=	$purchase_data['purchase_date'];

		
		$this->form_validation->set_rules('purchase_date', 'Purchase date', 'required');

        if ($this->form_validation->run() != FALSE) {

			$detail_result										=	$this->purchase_model->add_purchase($purchase_data);

			for ($i=1; $i <= count($result) ; $i++) {
				$purchase_detail_data['item_id'] 				=	$result[$i]['id'];
				$purchase_detail_data['item_name'] 				=	$result[$i]['name'];
				$purchase_detail_data['purchase_price'] 		=	$result[$i]['price'];
				$purchase_detail_data['quantity'] 				=	$result[$i]['quantity'];
				$purchase_detail_data['purchase_discount']		=	0;

				$detail_result								=	$this->purchase_model->add_purchase_detail($purchase_detail_data);

				$this->item_model->add_item_quantity($purchase_detail_data['item_id'],$purchase_detail_data['quantity']);

				$stock_found 								=	$this->stock_model->get_stock_by_item_and_warehouse_id($purchase_detail_data['item_id'], $purchase_detail_data['warehouse_id']);

				if($stock_found == NULL){
					$stock_data 							=	array();
					$stock_data['item_id']					=	$result[$i]['id'];
					$stock_data['warehouse_id']				=	$purchase_detail_data['warehouse_id'];
					$stock_data['item_name']				=	$result[$i]['name'];
					$stock_data['quantity']					=	$result[$i]['quantity'];

					$stock_result 							=	$this->stock_model->add_stock($stock_data);
				} else {

					$this->stock_model->add_stock_quantity($purchase_detail_data['item_id'], $purchase_detail_data['warehouse_id'], $purchase_detail_data['quantity']);
				}

			}
		redirect('purchase/view_purchases','refresh');
		}else{
			$this->index(0,$error_count);
		}
	}

	public function update_purchase($purchase_id)
	{
		$purchase_data						=	array();
		$purchase_data['user_id']			=	$this->session->userdata('user_id');
		$purchase_data['user_name']			=	$this->session->userdata('user_name');
		
		$purchase_data['purchase_id']		=	$this->input->post('purchase_id','',TRUE);
		$purchase_data['vendor_id']			=	$this->input->post('vendor_id','',TRUE);
		$purchase_data['vendor_name']		=	$this->purchase_model->get_vendor_by_id($purchase_data['vendor_id'])->vendor_name;
		$purchase_data['warehouse_id']		=	$this->input->post('warehouse_id','',TRUE);

		
		$purchase_data['purchase_date']		=	$this->input->post('purchase_date','',TRUE);
		$purchase_data['purchase_discount']	=	$this->input->post('purchase_discount','',TRUE);

		$error_count					=	$this->input->post('count','',TRUE);

		$item_id						=	$this->input->post('item_id','',TRUE);
		$item_name						=	$this->input->post('item_name','',TRUE);
		$purchase_price					=	$this->input->post('purchase_price','',TRUE);
		$quantity						=	$this->input->post('quantity','',TRUE);

		$purchase_detail				=	$this->purchase_model->get_purchase_details_by_id($purchase_id);

		for ($i=0; $i < $error_count ; $i++) { 
        	$this->form_validation->set_rules('quantity['.$i.']', 'Quantity', 'required|numeric|greater_than[0]');
        	$this->form_validation->set_message('less_than_equal_to', 'Quantity must be greater than 0');
		}

		$this->form_validation->set_rules('purchase_price[]', 'purchase price', 'required|numeric');
	    $this->form_validation->set_rules('purchase_date', 'purchase Date', 'required');

        if ($this->form_validation->run() != FALSE) {

			$this->purchase_model->update_purchase($purchase_data,$purchase_id);

			$this->delete_purchase_detail($purchase_id);

			$count							=	$this->input->post('count','',TRUE);

			$purchase_detail_data				=	array();

			$purchase_detail_data['warehouse_id']		=	$purchase_data['warehouse_id'];

			$purchase_detail_data['purchase_date']		=	$purchase_data['purchase_date'];

			for ($i=0; $i < $count ; $i++) { 
				$purchase_detail_data['purchase_id']		=	$purchase_id;
				$purchase_detail_data['item_id']			=	$item_id[$i];
				$purchase_detail_data['item_name']			=	$item_name[$i];
				$purchase_detail_data['purchase_price']		=	$purchase_price[$i];
				$purchase_detail_data['quantity']			=	$quantity[$i];
				$purchase_detail_data['purchase_discount']	=	$purchase_data['purchase_discount'];
				$detail_result								=	$this->purchase_model->add_purchase_detail($purchase_detail_data);

				$purchase_detail 							=	$this->purchase_model->get_purchase_details_by_purchase_id_and_item_id($purchase_id,$purchase_detail_data['item_id']);

				$this->item_model->add_item_quantity($purchase_detail_data['item_id'],$quantity[$i]);

				$stock_found 								=	$this->stock_model->get_stock_by_item_and_warehouse_id($purchase_detail_data['item_id'], $purchase_detail_data['warehouse_id']);

				if($stock_found == NULL){
					$stock_data 							=	array();
					$stock_data['item_id']					=	$item_id[$i];
					$stock_data['warehouse_id']				=	$purchase_detail_data['warehouse_id'];
					$stock_data['item_name']				=	$item_name[$i];
					$stock_data['quantity']					=	$quantity[$i];

					$stock_result 							=	$this->stock_model->add_stock($stock_data);
				} else {
					$this->stock_model->add_stock_quantity($purchase_detail_data['item_id'], $purchase_detail_data['warehouse_id'], $purchase_detail_data['quantity']);
				}
			}

			redirect('purchase/view_purchases','refresh');
		}else{
			$this->index($purchase_id,$error_count);
		}
	}
	public function delete_purchase($purchase_id)
	{
		$this->delete_purchase_detail($purchase_id);

		$this->purchase_model->delete_purchase($purchase_id);

		redirect('purchase/view_purchases','refresh');
	}
	private function delete_purchase_detail($purchase_id)
	{
		$purchase_detail 		=	$this->purchase_model->get_purchase_details_by_id($purchase_id);

		foreach ($purchase_detail as $value) {
			$this->item_model->subtract_item_quantity($value->item_id,$value->quantity);
			$this->stock_model->subtract_stock_quantity($value->item_id, $value->warehouse_id, $value->quantity);
		}
		$this->purchase_model->delete_purchase_detail($purchase_id);
		
	}




	//---------------------VENDOR SECTION STARTS HERE
	public function vendor($vendor_id=0)
	{
		$data						=	array();
		$data['page_title']			=	"Inventory Management";
		$nav_data['dev_key']		=	"vendor";
		$nav_data['selected']		=	"add_vendor";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$vendor_data				=	array();
		if($vendor_id!=0){
			$vendor_data['vendor']	=	$this->purchase_model->get_vendor_by_id($vendor_id);	
		}else{
			$vendor_data['vendor']	=	NULL;
		}
		

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/vendor',$vendor_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}
	public function view_vendors()
	{
		$data						=	array();
		$data['page_title']			=	"Inventory Management";
		$nav_data['dev_key']		=	"vendor";
		$nav_data['selected']		=	"all_vendors";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$vendor_data				=	array();
		$vendor_data['vendor_list']	=	$this->purchase_model->get_all_vendors();
		$vendor_data['permission']	= 	$this->module_model->get_permission_by_module_id_and_user_id(4,$this->session->userdata('user_id'));

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/vendor_list',$vendor_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function add_vendor()
	{
		$vendor_data					=	array();
		$vendor_data['user_id']			=	$this->session->userdata('user_id');
		$vendor_data['user_name']		=	$this->session->userdata('user_name');
		$vendor_data['vendor_name']		=	$this->input->post('vendor_name','',TRUE);
		$vendor_data['address']			=	$this->input->post('address','',TRUE);
		$vendor_data['phone_no']		=	$this->input->post('phone_no','',TRUE);

		$result							=	$this->purchase_model->add_vendor($vendor_data);

		redirect('purchase/view_vendors','refresh');
	}

	public function update_vendor($vendor_id)
	{
		$vendor_data					=	array();
		$vendor_data['user_id']			=	$this->session->userdata('user_id');
		$vendor_data['user_name']		=	$this->session->userdata('user_name');
		$vendor_data['vendor_name']		=	$this->input->post('vendor_name','',TRUE);
		$vendor_data['address']			=	$this->input->post('address','',TRUE);
		$vendor_data['phone_no']		=	$this->input->post('phone_no','',TRUE);

		$result							=	$this->purchase_model->update_vendor($vendor_data,$vendor_id);

		redirect('purchase/view_vendors','refresh');
	}
	public function delete_vendor($vendor_id)
	{
		
		$this->purchase_model->delete_vendor($vendor_id);

		redirect('purchase/view_vendors','refresh');
	}

	//---------------------VENDOR SECTION ENDS HERE


	//--------------PAYABLE STARTS HERE

	public function payable()
	{
		$data							=	array();
		$data['page_title']				=	"Inventory Management";

		$nav_data						=	array();
		$nav_data['dev_key']			=	"purchase";
		$nav_data['selected']			=	"payable";
		$nav_data['company_name']   	=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$purchase_data					=	array();
		$purchase_data['item_list']		=	$this->item_model->get_all_items();
		$purchase_data['purchase_list']	=	$this->purchase_model->get_all_purchases();
		$purchase_data['payment_list']	=	$this->payment_model->get_all_payments();

		$data['navigation']				=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']					=	$this->load->view('templates/footer','',TRUE);
		$data['content']				=	$this->load->view('partials/payable',$purchase_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}




///////////// PDF section start Here-------------------

	public function purchase_invoice(){
		$this->load->helper(array('My_Pdf'));   //  Load helper
		$data 				=	$this->load->view('partials/purchase_invoice','',TRUE);
		writeHTML($data);
		Output();
		// create_pdf($data);
	}

	public function purchase_invoice_br(){
		$this->load->library('mypdf');
		$pdf = $this->mypdf->load();
		$data 	=	$this->load->view('partials/purchase_invoice','',TRUE);
		$data 	= 	$this->load->view('partials/purchase_invoice1','',TRUE);
		$pdf->writeHTML($data);
		$pdf->Output();

		// $this->load->view('partials/purchase_invoice1');
	}

	public function invoice_dom_pdf(){
		$this->load->library('pdf');
    	$this->pdf->load_view('partials/purchase_invoice');
	}

	public function invoice_pdf_tcpdf(){
		$data							=	array();
		$data['page_title']				=	"Inventory Management";
		$nav_data['dev_key']			=	"purchase";
		$nav_data['selected']			=	"all_purchases";
		$nav_data['company_name']   	=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$purchase_data					=	array();
		$purchase_data['purchase_list']	=	$this->purchase_model->get_all_purchases();

		$data['navigation']				=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']					=	$this->load->view('templates/footer','',TRUE);
		$data['content']				=	$this->load->view('partials/purchase_list',$purchase_data,TRUE);

		$pdf_view 						=	$this->load->view('templates/main_template',$data,TRUE);

		$invoice 						=	$this->load->view('partials/purchase_invoice','',TRUE);

		$this->load->library('Pdf');

		$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Hira Sharker');
		$pdf->SetTitle('Purchase Invoice');
		// $pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// set default header data
		$pdf->SetHeaderData('', 0, 'Companay Name'.'', 'Header String');

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', 'B', 20);

		// add a page
		$pdf->AddPage();

		// $pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

		$pdf->SetFont('helvetica', '', 8);

		// -----------------------------------------------------------------------------

		$pdf->writeHTML($invoice , true, false, false, false, '');
		$pdf->Output('example_048.pdf', 'I');
		
	}





}
