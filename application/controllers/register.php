<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->load->model('user'); //load MODEL
		$this->load->library('form_validation'); //load form validate rules
		$this->load->helper('captcha'); //load CAPTCHA library
		
		//mail config settings
		$this->load->library('email'); //load email library
		//$config['protocol'] = 'sendmail';
		//$config['mailpath'] = '/usr/sbin/sendmail';
		//$config['charset'] = 'iso-8859-1';
		//$config['wordwrap'] = TRUE;
		
		//$this->email->initialize($config);
    }
	
	public function index() {
		if($this->session->userdata('logged_in') == TRUE){ 
			redirect(base_url(), 'location');
		}
		
		if($_POST){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$dept = $_POST['dept'];
			
			$password = md5($password);
			
			$reg_data = array(
				'centre_id' => $dept,
				'username' => $username,
				'password' => $password,
				'firstname' => $firstname,
				'lastname' => $lastname,
				'role' => 'User',
			);
			
			if($this->user->reg_rec('bz_user', $reg_data) > 0){
				$data['err_msg'] = '<div class="alert alert-info"><h5>Registration completed</h5></div>';
			} else {
				$data['err_msg'] = '<div class="alert alert-info"><h5>There is problem this time. Try later</h5></div>';
			}
		}
		
		$data['alldept'] = $this->user->query_rec('bz_department');
		$data['title'] = 'Register';

	  	$this->load->view('designs/hm_header', $data);
	  	$this->load->view('register', $data);
	  	$this->load->view('designs/hm_footer', $data);
	}
}