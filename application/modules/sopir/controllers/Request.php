<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Request extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in')) {
			redirect(base_url('login'));
		}
		check_access('sopir');

		$this->load->model('datatable_model');
		$this->load->model('global_model');
		$this->load->library('form_validation');
		$this->load->library('email');
		$this->load->library('security');
	}

	function index()
	{
		$getMobil = $this->global_model->get_all_mobil()->result();
		$data = [
			'mobil' => $getMobil
		];
		$this->load->view('view_request', $data);
	}

	public function base64UrlSafeDecode($data)
	{
		// Replace URL-safe characters back to original base64 characters
		$base64 = str_replace(['-', '_'], ['+', '/'], $data);

		// Add padding if needed (base64 requires the length to be a multiple of 4)
		$padding = strlen($base64) % 4;
		if ($padding > 0) {
			$base64 .= str_repeat('=', 4 - $padding);
		}

		// Decode the base64 string
		$decoded = base64_decode($base64, true);

		// Return the decoded string, or null if decoding failed
		return $decoded;
	}

	public function get_request_datatable()
	{
		$query = $this->datatable_model->get_request_datatable();

		header('Content-Type: application/json');
		echo json_encode($query);
		exit(); // Stop further script execution
	}

	public function submit_bbm()
	{
		$mobil_id 		= $this->input->post('mobil_id');
		$jenis_bbm 		= $this->input->post('jenis_bbm');
		$jumlah_isi 	= $this->input->post('jumlah_isi');


		if (empty($mobil_id) || empty($jenis_bbm) || empty($jumlah_isi)) {
			echo json_encode([
				'statusCode' 	=> 400,
				'message' 		=> 'Harap isi semua data yang wajib diisi.'
			]);
			return;
		}

		$this->db->trans_start();

		$data = [
			'sopir_id' 		=> $this->session->userdata('user_id'),
			'mobil_id' 		=> $mobil_id,
			'jenis_bbm' 	=> $jenis_bbm,
			'jumlah_liter' 	=> $jumlah_isi,
			'created_at' 	=> date('Y-m-d H:i:s')
		];

		$this->db->insert('request_pengisian_bbm', $data);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			echo json_encode([
				'statusCode' => 500,
				'message' => 'Gagal menyimpan data. Silakan coba lagi.'
			]);
			return;
		}

		echo json_encode([
			'statusCode' 	=> 200,
			'message' 		=> 'Data berhasil disimpan.'
		]);
	}

	function get_edit_request()
	{
		$id = $this->input->get('data');

		if (!$id) {
			echo json_encode([
				'statusCode' 	=> 400,
				'message' 		=> 'Data tidak ditemukan.'
			]);
			return;
		}

		$request_id 	= $this->base64UrlSafeDecode($id);
		$request 			= $this->global_model->get_approval_by_id($request_id)->row();

		echo json_encode([
			'statusCode' 	=> 200,
			'data' 			=> $request
		]);
		return;
	}

	public function update_request()
	{
		$mobil_id 		= $this->security->xss_clean($this->input->post('mobil_id'));
		$jenis_bbm 		= $this->input->post('jenis_bbm');
		$jumlah_isi 	= $this->input->post('jumlah_isi');

		if (empty($mobil_id) || empty($jenis_bbm) || empty($jumlah_isi)) {
			echo json_encode([
				'statusCode' 	=> 400,
				'message' 		=> 'Harap isi semua data yang wajib diisi.'
			]);
			return;
		}

		$request_id 	= $this->input->post('idRequest');
		$this->db->trans_start();

		$data = [
			'sopir_id' 		=> $this->session->userdata('user_id'),
			'mobil_id' 		=> $mobil_id,
			'jenis_bbm' 	=> $jenis_bbm,
			'jumlah_liter' 	=> $jumlah_isi,
		];

		$this->db->where('request_id', $request_id)->update('request_pengisian_bbm', $data);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			echo json_encode([
				'statusCode' => 500,
				'message' => 'Gagal menyimpan data. Silakan coba lagi.'
			]);
			return;
		}

		echo json_encode([
			'statusCode' 	=> 200,
			'message' 		=> 'Data berhasil di-update.'
		]);
	}

	public function delete_request()
	{
		$request_id = $this->input->get('id');

		if (!$request_id) {
			echo json_encode([
				'statusCode' 	=> 400,
				'message'	 	=> 'ID tidak ditemukan.'
			]);
			return;
		}

		if ($this->global_model->delete_request(base64_decode($request_id)) == true) {
			echo json_encode([
				'statusCode' 	=> 200,
				'message' 		=> 'Data request berhasil dihapus.'
			]);
		} else {
			echo json_encode([
				'statusCode' 	=> 500,
				'message' 		=> 'Gagal menghapus data. Silakan coba lagi.'
			]);
		}
	}
}
