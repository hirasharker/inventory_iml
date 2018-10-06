<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Utility extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('user_id')==NULL){
			redirect('login','refresh');
		}
		$this->load->model('company_model','company_model',TRUE);
		$this->load->model('utility_model','utility_model',TRUE);
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
	public function index()
	{
		$data						=	array();
		$data['page_title']			=	"Inventory Management";

		$nav_data					=	array();
		$nav_data['dev_key']		=	"utility";
		$nav_data['selected']		=	"company";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$company_data				=	array();
		$company_data['company']	=	$this->company_model->get_company_by_id(1);


		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('partials/company',$company_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function backup($company_id=1)
	{
		$data						=	array();
		$data['page_title']			=	"Inventory Management";

		$nav_data					=	array();
		$nav_data['dev_key']		=	"utility";
		$nav_data['selected']		=	"backup";
		$nav_data['company_name']   =   $this->company_model->get_company_by_id(1)->company_name;
		$nav_data['user_permission']=	$this->module_model->get_permission_by_user_id($this->session->userdata('user_id'));

		$company_data				=	array();
		$company_data['company']	=	$this->company_model->get_company_by_id(1);


		$data['navigation']			=	$this->load->view('templates/navigation',$nav_data,TRUE);
		$data['footer']				=	$this->load->view('templates/footer','',TRUE);
		$data['content']			=	$this->load->view('utility/backup',$company_data,TRUE);

		$this->load->view('templates/main_template',$data);
	}

	public function get_backup(){

		$file_name 		=	$this->input->post('file_name',TRUE);

		$this->utility_model->get_backup_of_database($file_name);

	}

	public function test(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        echo $ip;

        $mac = system('ipconfig /all');
		echo $mac;

		// $macAddr=false;
	 //    $arp=`arp -n`;
	 //    $lines=explode("\n", $arp);

	 //    foreach($lines as $line){
	 //        $cols=preg_split('/\s+/', trim($line));

	 //        if ($cols[0]==$_SERVER['REMOTE_ADDR']){
	 //            $macAddr=$cols[2];
	 //        }
	 //    }

	 //    echo $macAddr;

	}
}
