<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Report_Sales extends CI_Controller {
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
		$sales_data['money_receipt']	=	$this->mr_model->get_all_money_receipts();

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
		$sales_data['customer_list']	=	$this->customer_model->get_all_customers();
		$sales_data['dealer_list']		=	$this->dealer_model->get_all_dealers();

		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('report/individual_receivable',$sales_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function generate_individual_receivable_statement(){
		$customer_id 	=	$this->input->post('customer_id',TRUE);
		$dealer_id 		=	$this->input->post('dealer_id',TRUE);
		$from_date 		=	$this->input->post('from_date',TRUE);
		$to_date 		=	$this->input->post('to_date',TRUE);

		$search_result 	= 	array();

		$search_result['sales_data']			=	$this->sales_model->get_all_sales_by_date_and_customer_id_or_dealer_id($customer_id, $dealer_id, $from_date, $to_date);
		$search_result['money_receipt_data']	=	$this->mr_model->get_all_money_receipts_by_date_and_customer_id_or_dealer_id($customer_id, $dealer_id,$from_date,$to_date);
		// echo '<pre>'; print_r($search_result);echo '</pre>'; exit();
		$output 						=	$this->load->view('report/individual_receivable_table',$search_result,TRUE);

        $error_message = 'Its a dummy error '.$customer_id.$from_date.$to_date;
        echo json_encode($output);

	}

	public function individual_receivable_pdf(){
		
		$this->load->library('pdf');

		$customer_id 	=	$this->input->post('customer_id',TRUE);
		$dealer_id 		=	$this->input->post('dealer_id',TRUE);
		$from_date 		=	$this->input->post('from_date',TRUE);
		$to_date 		=	$this->input->post('to_date',TRUE);

		$search_result 	= 	array();

		$search_result['sales_data']			=	$this->sales_model->get_all_sales_by_date_and_customer_id_or_dealer_id($customer_id, $dealer_id, $from_date, $to_date);
		$search_result['money_receipt_data']	=	$this->mr_model->get_all_money_receipts_by_date_and_customer_id_or_dealer_id($customer_id, $dealer_id,$from_date,$to_date);
		// echo '<pre>'; print_r($search_result);echo '</pre>'; exit();
        $html 										=	$this->load->view('report/individual_receivable_pdf',$search_result,TRUE);
 
        $pdfFilePath 								= 	"receivable.pdf";
 
        $this->load->library('m_pdf');

 		$this->m_pdf->pdf->SetHeader('Receivable');

 		$this->m_pdf->pdf->AddPage('L');

        $this->m_pdf->pdf->WriteHTML($html);

        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 

	}

	public function group_receivable()
	{
		$data							=	array();
		$data['page_title']				=	"Inventory Management";
		$nav_data['dev_key']			=	"receivable";
		$nav_data['selected']			=	"group_receivable";
		$nav_data['company_name']  		=   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']	=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$sales_data 					= 	array();
		$sales_data['sales']			=	$this->sales_model->get_all_sales();
		$sales_data['money_receipt']	=	$this->mr_model->get_all_money_receipts();


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

		$search_result['money_receipt']	=	$this->mr_model->get_all_money_receipts_by_date($from_date,$to_date);

		$output 						=	$this->load->view('report/group_receivable_table',$search_result,TRUE);

        $error_message = 'Its a dummy error '.$from_date.$to_date;
        echo json_encode($output);

	}
	

	public function group_receivable_pdf(){
		
		$from_date 		=	$this->input->post('from_date',TRUE);
		$to_date 		=	$this->input->post('to_date',TRUE);

		$search_result 	= 	array();

		$search_result['sales']			=	$this->sales_model->get_all_sales_by_date($from_date,$to_date);

		$search_result['money_receipt']	=	$this->mr_model->get_all_money_receipts_by_date($from_date,$to_date);

		$html 							=	$this->load->view('report/group_receivable_pdf',$search_result,TRUE);
 
        $pdfFilePath 					= 	"receivable.pdf";
 
        $this->load->library('m_pdf');

 		$this->m_pdf->pdf->SetHeader('Receivable');

 		$this->m_pdf->pdf->AddPage('L');

        $this->m_pdf->pdf->WriteHTML($html);

        $this->m_pdf->pdf->Output($pdfFilePath, "D");

	}

	public function generate_customer_name(){
		if (isset($_GET['term'])){
	      $search_key = strtolower($_GET['term']);
	      $this->sales_model->get_customer_like_customer_id($search_key);
	    }
	}
		
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
		$search_result['payments']		=	$this->mr_model->get_individual_money_receipt_by_date_and_customer_name($customer_name,$from_date,$to_date);

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
}?>
