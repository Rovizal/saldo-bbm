<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in')) {
			redirect(base_url('login'));
		}
		check_access('admin');

		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('User_model');
		$this->load->model('global_model');
	}

	public function index()
	{
		$countApprovalApproved 		= $this->global_model->countApprovalApproved()->num_rows();
		$countApprovalPending 		= $this->global_model->countApprovalPending()->num_rows();
		$countApprovalRejected 		= $this->global_model->countApprovalRejected()->num_rows();
		$countMobil 				= $this->global_model->countMobil()->num_rows();

		$data = [
			'approval_aproved' 		=>  $countApprovalApproved,
			'approval_pending' 		=>  $countApprovalPending,
			'approval_rejected' 	=>  $countApprovalRejected,
			'mobil_registered' 		=>  $countMobil,
		];
		$this->load->view('view_dashboard', $data);
	}
}
