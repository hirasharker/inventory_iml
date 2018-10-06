<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Report_Warranty_Claim extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('user_id')==NULL){
			redirect('login','refresh');
		}
		$this->load->model('warranty_claim_model','warranty_claim_model',TRUE);
		$this->load->model('group_model','group_model',TRUE);
		$this->load->model('item_model','item_model',TRUE);
		$this->load->model('company_model','company_model',TRUE);
		$this->load->model('purchase_model','purchase_model',TRUE);
		$this->load->model('module_model','module_model',TRUE);
		$this->load->library('form_validation');
	}


	public function index()
	{
		$data						=	array();
		$data['page_title']			=	"Warranty Claim Status";
		$nav_data['dev_key']		=	"warranty_claim_report";
		$nav_data['selected']		=	"claim_status_report";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$warranty_claim_data									=	array();
		$warranty_claim_data['warranty_claim_type_list']					=	$this->warranty_claim_model->get_all_warranty_claim_types();

		$data['navigation']										=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']											=	$this->load->view('templates/footer','',TRUE);
		$data['content']										=	$this->load->view('report/warranty_claim_status_report',$warranty_claim_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function warranty_claim_status_pdf(){
		$this->load->library('pdf');

		$claim_status 									=	$this->input->post('claim_status',TRUE);
		$warranty_claim_type_id 						=	$this->input->post('warranty_claim_type_id',TRUE);
		$from_date 										=	$this->input->post('from_date',TRUE);
		$to_date 										=	$this->input->post('to_date',TRUE);

		$search_result 									= 	array();

		$search_result['warranty_claim_status_list']	=	$this->warranty_claim_model->get_warranty_claim_status($claim_status, 
															$warranty_claim_type_id, $from_date, $to_date);
		// print_r($search_result);exit();						

    	$this->pdf->load_view('report/warranty_claim_status_pdf',$search_result,$from_date.'_to_'.$to_date.'_wc_status');


	}


	//---------------Warranty_claim_Settlement_Status_SECTION----------------------------

	public function warranty_claim_settlement_status()
	{
		$data						=	array();
		$data['page_title']			=	"Warranty Claim Status";
		$nav_data['dev_key']		=	"warranty_claim_report";
		$nav_data['selected']		=	"claim_status_report";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$warranty_claim_data									=	array();
		$warranty_claim_data['warranty_claim_type_list']		=	$this->warranty_claim_model->get_all_warranty_claim_types();

		$data['navigation']										=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']											=	$this->load->view('templates/footer','',TRUE);
		$data['content']										=	$this->load->view('report/warranty_claim_status_report',$warranty_claim_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function warranty_claim_settlement_pdf(){
		$this->load->library('pdf');

		$claim_status 									=	$this->input->post('claim_status',TRUE);
		$warranty_claim_type_id 						=	$this->input->post('warranty_claim_type_id',TRUE);
		$from_date 										=	$this->input->post('from_date',TRUE);
		$to_date 										=	$this->input->post('to_date',TRUE);

		$search_result 									= 	array();

		$search_result['warranty_claim_status_list']	=	$this->warranty_claim_model->get_warranty_claim_status($claim_status, 
															$warranty_claim_type_id, $from_date, $to_date);
		// print_r($search_result);exit();						

    	$this->pdf->load_view('report/warranty_claim_status_pdf',$search_result,$from_date.'_to_'.$to_date.'_wc_status');


	}




	//----------------AJAX Section  --------------------------------------------

	public function generate_item_name(){
		if (isset($_GET['term'])){
	      $search_key = strtolower($_GET['term']);
	      $this->item_model->get_item_like_name_id($search_key);
	    }
	}

	public function generate_warranty_claim_status(){
		$claim_status 									=	$this->input->post('claim_status',TRUE);
		$warranty_claim_type_id 						=	$this->input->post('warranty_claim_type_id',TRUE);
		$from_date 										=	$this->input->post('from_date',TRUE);
		$to_date 										=	$this->input->post('to_date',TRUE);

		$search_result 									= 	array();

		$search_result['warranty_claim_status_list']	=	$this->warranty_claim_model->get_warranty_claim_status($claim_status, 
															$warranty_claim_type_id, $from_date, $to_date);
		$search_result['warranty_claim_type_list']		=	$this->warranty_claim_model->get_all_warranty_claim_types();

		$output 						=	$this->load->view('report/warranty_claim_status_table',$search_result,TRUE);

        $error_message = 'Its a dummy error '.$search_result['warranty_claim_status_list'][0]->warranty_claim_id.$from_date.$to_date;
        echo json_encode($output);

	}

	

	


}