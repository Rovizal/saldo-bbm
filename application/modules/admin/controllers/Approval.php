<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Approval extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in')) {
			redirect(base_url('login'));
		}
		check_access('admin');

		$this->load->model('datatable_model');
		$this->load->model('global_model');
		$this->load->library('form_validation');
		$this->load->library('email');
		$this->load->library('encryption');
	}

	function index()
	{
		$this->load->view('view_approval');
	}

	public function get_approval_datatable()
	{
		$query = $this->datatable_model->get_approval_datatable();

		header('Content-Type: application/json');
		echo json_encode($query);
		exit();
	}

	public function approve_request()
	{
		$request_id = $this->input->post('request_id');
		if (!$request_id) {
			echo json_encode([
				'statusCode' => 400,
				'message' => 'ID Request tidak ditemukan.'
			]);
			return;
		}

		$getApproval = $this->global_model->get_approval_by_id($request_id)->row();
		if (!$getApproval) {
			echo json_encode([
				'statusCode' => 404,
				'message' => 'Request tidak ditemukan.'
			]);
			return;
		}

		$jml 		= $getApproval->jumlah_liter;
		$idMobil 	= $getApproval->mobil_id;

		$data = [
			'mobil_id' => $idMobil,
			'tipe_aktivitas' => 'pengisian',
			'jumlah_saldo' => $jml,
			'keterangan' => 'Isi BBM',
			'created_at' => date('Y-m-d H:i:s')
		];

		$this->db->trans_start();

		$this->db->set([
			'status'		=> 'approved',
			'approved_by'	=> $this->session->userdata('username') ?? 'unknown',
			'approved_at'	=> date('Y-m-d H:i:s'),
		])
			->where('request_id', $request_id)
			->update('request_pengisian_bbm');

		$this->db->insert('saldo_bbm_log', $data);

		$this->db->set('saldo_awal', 'saldo_awal + ' . $jml, FALSE)
			->where('mobil_id', $idMobil)
			->update('master_mobil');

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			echo json_encode([
				'statusCode' => 500,
				'message' => 'Gagal menyimpan data. Silakan coba lagi.'
			]);
			return;
		}

		echo json_encode([
			'statusCode' => 200,
			'message' => 'Request berhasil di-approve.'
		]);
	}

	public function reject_request()
	{
		$request_id = $this->input->post('request_id');
		if (!$request_id) {
			echo json_encode([
				'statusCode' => 400,
				'message' => 'ID Request tidak ditemukan.'
			]);
			return;
		}

		$getApproval = $this->global_model->get_approval_by_id($request_id)->row();
		if (!$getApproval) {
			echo json_encode([
				'statusCode' => 404,
				'message' => 'Request tidak ditemukan.'
			]);
			return;
		}

		$this->db->trans_start();

		$this->db->set('status', 'rejected')
			->where('request_id', $request_id)
			->update('request_pengisian_bbm');

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			echo json_encode([
				'statusCode' => 500,
				'message' => 'Gagal menyimpan data. Silakan coba lagi.'
			]);
			return;
		}

		echo json_encode([
			'statusCode' => 200,
			'message' => 'Request berhasil di-reject.'
		]);
	}
}
