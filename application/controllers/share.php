<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Share extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->load->model('user'); //load MODEL
		$this->load->helper('text'); //for content limiter
		$this->load->helper('url'); //for content limiter
		$this->load->library('form_validation'); //load form validate rules
		
		//mail config settings
		$this->load->library('email'); //load email library
		//$config['protocol'] = 'sendmail';
		//$config['mailpath'] = '/usr/sbin/sendmail';
		//$config['charset'] = 'iso-8859-1';
		//$config['wordwrap'] = TRUE;
		
		//$this->email->initialize($config);
    }
	
	public function index() {
		if($this->session->userdata('logged_in')==FALSE){ 
			redirect(base_url().'login/', 'location');
		}
		
		$log_user = $this->session->userdata('log_user_id');
		
		//query uploads
		$dept_id = $this->session->userdata('itc_user_centre');
		$data['dept_id'] = $dept_id;
		$data['role'] = $this->session->userdata('itc_user_role');
		if($this->session->userdata('itc_user_role') == 'Admin'){
			$data['allup'] = $this->user->query_rec('bz_share');
		} else {
			$data['allup'] = $this->user->query_rec_single('to_dept', $dept_id, 'bz_share');
		}
		
		$data['log_username'] = $this->session->userdata('log_username');
	  
	  	$data['title'] = 'Share Documents';
		$data['page_act'] = 'share';

	  	$this->load->view('designs/header', $data);
		$this->load->view('designs/leftmenu', $data);
	  	$this->load->view('share', $data);
	  	$this->load->view('designs/footer', $data);
	}
}