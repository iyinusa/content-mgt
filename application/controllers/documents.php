<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documents extends CI_Controller {
	
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
		
		//check for update
		$get_id = $this->input->get('edit');
		if($get_id != ''){
			$gq = $this->user->query_rec_single('id', $get_id, 'bz_document');
			foreach($gq as $item){
				$data['e_id'] = $item->id;
				$data['e_cat_id'] = $item->cat_id;	
				$data['e_name'] = $item->name;
				$data['e_details'] = $item->details;
				$data['e_size'] = $item->size;
				$data['e_type'] = $item->type;
				$data['e_path'] = $item->path;
				$data['e_item'] = $item->item;
			}
		}
		
		//check record delete
		$del_id = $this->input->get('del');
		if($del_id != ''){
			if($this->user->delete_rec('id', $del_id, 'bz_document') > 0){
				$data['err_msg'] = '<div class="alert alert-info"><h5>Deleted</h5></div>';
			} else {
				$data['err_msg'] = '<div class="alert alert-info"><h5>There is problem this time. Try later</h5></div>';
			}
		}
		
		//check if ready for post
		if($_POST){
			$doc_id = $_POST['doc_id'];
			$cat_id = $_POST['cat_id'];
			$name = $_POST['name'];
			$details = $_POST['details'];
			$doc = $_POST['doc_path'];
			$doc_type = $_POST['doc_type'];
			$doc_size = $_POST['doc_size'];
			$item = $_POST['item'];
			
			$error = FALSE;
			
			//Upload code
			$config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'pdf|doc|docx|xls|xlsx|pps|ppsx|zip|rar|jpg|jpeg|png';
			
			$this->load->library('upload', $config);
			
			if(!$this->upload->do_upload('doc')){
				$doc = $this->upload->display_errors();
				$error = TRUE;
			} else {
				$docall = $this->upload->data();
				$doc = $docall['file_name'];
				$doc_type = $docall['file_ext'];
				$doc_size = $docall['file_size'];
			}
			
			if($item == ''){$protect = 0;} else {$protect = 1;}
			
			if($error == TRUE && $doc_id == '') {
				$data['err_msg'] = '<div class="alert alert-info"><h5>'.$doc.'</h5></div>';
			} else {
				//check for update
				if($doc_id != ''){
					$upd_data = array(
						'cat_id' => $cat_id,
						'name' => $name,
						'details' => $details,
						'size' => $doc_size,
						'type' => $doc_type,
						'path' => $doc,
						'protect' => $protect,
						'item' => $item,
					);
					
					if($this->user->update_rec('id', $doc_id, 'bz_document', $upd_data) > 0){
						$data['err_msg'] = '<div class="alert alert-info"><h5>Successfully</h5></div>';
					} else {
						$data['err_msg'] = '<div class="alert alert-info"><h5>No Changes Made</h5></div>';
					}
				} else {
					$reg_data = array(
						'user_id' => $log_user,
						'cat_id' => $cat_id,
						'name' => $name,
						'details' => $details,
						'size' => $doc_size,
						'type' => $doc_type,
						'path' => $doc,
						'protect' => $protect,
						'item' => $item,
					);
					
					if($this->user->reg_rec('bz_document', $reg_data) > 0){
						$data['err_msg'] = '<div class="alert alert-info"><h5>Successfully</h5></div>';
					} else {
						$data['err_msg'] = '<div class="alert alert-info"><h5>There is problem this time. Try later</h5></div>';
					}
				}
			}
		}
		
		//query uploads
		$data['dept_id'] = $this->session->userdata('itc_user_centre');
		$data['role'] = $this->session->userdata('itc_user_role');
		$data['allup'] = $this->user->query_rec('bz_document');
		$data['allcat'] = $this->user->query_rec('bz_category');
		
		$data['log_username'] = $this->session->userdata('log_username');
	  
	  	$data['title'] = 'Documents';
		$data['page_act'] = 'document';

	  	$this->load->view('designs/header', $data);
		$this->load->view('designs/leftmenu', $data);
	  	$this->load->view('document', $data);
	  	$this->load->view('designs/footer', $data);
	}
	
	public function view() {
		if($this->session->userdata('logged_in')==FALSE){ 
			redirect(base_url().'login/', 'location');
		}
		
		$log_user = $this->session->userdata('log_user_id');
		$data['role'] = $this->session->userdata('itc_user_role');
		
		$get_id = $this->input->get('id');
		if($get_id == ''){
			redirect(base_url('documents'), 'refresh');
		} else {
			$data['protected'] = FALSE;
			$gq = $this->user->query_rec_single('id', $get_id, 'bz_document');
			foreach($gq as $item){
				$data['id'] = $item->id;
				$data['cat_id'] = $item->cat_id;	
				$data['name'] = $item->name;
				$data['details'] = $item->details;
				$data['size'] = $item->size;
				$data['type'] = $item->type;
				$data['path'] = $item->path;
				$data['item'] = $item->item;
				
				if($item->item != ''){
					$data['protected'] = TRUE;	
				}
				
				if(isset($_POST['password'])){
					if($_POST['password'] == $item->item){$data['protected'] = FALSE;}
				}
				
				//get category
				$gc = $this->user->query_rec_single('id', $item->cat_id, 'bz_category');
				if(!empty($gc)){
					foreach($gc as $c){
						$data['category'] = $c->name;
						
						//get department
						$gd = $this->user->query_rec_single('id', $c->dept_id, 'bz_department');
						if(!empty($gd)){
							foreach($gd as $d){
								$data['dept_id'] = $d->id;
								$data['department'] = $d->name;
							}
						}
					}
				}
				
				//post for comment
				if(isset($_POST['comment'])){
					if($_POST['comment'] != ''){
						$comment = $_POST['comment'];
						$regc_data = array(
							'user_id' => $log_user,
							'doc_id' => $item->id,
							'comment' => $comment,
						);
						
						if($this->user->reg_rec('bz_comment', $regc_data) > 0){
							$data['err_msg'] = '<div class="alert alert-info"><h5>Remark posted</h5></div>';
						} else {
							$data['err_msg'] = '<div class="alert alert-info"><h5>There is problem this time. Try later</h5></div>';
						}
					}
				}
				
				//post for share
				if(isset($_POST['cat_id'])){
					if($_POST['cat_id'] != ''){
						$cat_id = $_POST['cat_id'];
						$permission = $_POST['permission'];
						$count = count($permission);
						$check = '';
						for($i=0; $i<$count; $i++){
							$check .= $permission[$i].'|';
						}
						
						$regs_data = array(
							'doc_id' => $item->id,
							'from_dept' => $item->cat_id,
							'to_dept' => $cat_id,
							'rights' => $check
						);
						
						if($this->user->reg_rec('bz_share', $regs_data) > 0){
							$data['err_msg'] = '<div class="alert alert-info"><h5>Document shared</h5></div>';
						} else {
							$data['err_msg'] = '<div class="alert alert-info"><h5>There is problem this time. Try later</h5></div>';
						}
					}
				}
				
				//get all comments
				$data['allcom'] = $this->user->query_rec_single('doc_id', $item->id,'bz_comment');
			}
		}
		
		$data['allcat'] = $this->user->query_rec('bz_category');
		
		$data['title'] = 'Documents';
		$data['page_act'] = 'document';

	  	$this->load->view('designs/header', $data);
		$this->load->view('designs/leftmenu', $data);
	  	$this->load->view('view_document', $data);
	  	$this->load->view('designs/footer', $data);
	}
}