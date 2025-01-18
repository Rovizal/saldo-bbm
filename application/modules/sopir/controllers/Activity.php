<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Activity extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in')) {
			redirect(base_url('login'));
		}
		check_access('sopir');

		$this->load->library('session');
		$this->load->library('security');
		$this->load->library('form_validation');
		$this->load->model('datatable_model');
		$this->load->model('global_model');
	}

	public function index()
	{
		$getMobil = $this->global_model->get_all_mobil()->result();
		$data = [
			'mobil' => $getMobil
		];
		$this->load->view('view_activity', $data);
	}

	public function get_activity_datatable()
	{
		$query = $this->datatable_model->get_activity_datatable_sopir();

		header('Content-Type: application/json');
		echo json_encode($query);
		exit();
	}

	public function submit_activity()
	{
		$mobil_id = $this->security->xss_clean($this->input->post('mobil_id'));
		$jarak_tempuh_aktifitas = $this->security->xss_clean($this->input->post('jarak_tempuh_aktifitas'));

		if (empty($mobil_id) || empty($jarak_tempuh_aktifitas)) {
			echo json_encode([
				'statusCode' => 400,
				'message' => 'Harap isi semua data yang wajib diisi.'
			]);
			return;
		}

		$getMobil = $this->global_model->get_mobil_by_id($mobil_id)->row();
		if (!$getMobil) {
			echo json_encode([
				'statusCode' => 404,
				'message' => 'Data mobil tidak ditemukan.'
			]);
			return;
		}

		if ($getMobil->jarak_tempuh_per_liter <= 0) {
			echo json_encode([
				'statusCode' => 400,
				'message' => 'Data jarak tempuh per liter tidak valid.'
			]);
			return;
		}

		$bbm_terpakai = $jarak_tempuh_aktifitas / $getMobil->jarak_tempuh_per_liter;

		if ($bbm_terpakai > $getMobil->saldo_awal) {
			echo json_encode([
				'statusCode' => 400,
				'message' => 'BBM mobil tidak cukup.'
			]);
			return;
		}

		$this->db->trans_start();

		$data = [
			'sopir_id' => $this->session->userdata('user_id'),
			'mobil_id' => $mobil_id,
			'jarak_tempuh_aktifitas' => $jarak_tempuh_aktifitas,
			'bbm_terpakai' => $bbm_terpakai,
			'created_at' => date('Y-m-d H:i:s')
		];

		$this->db->insert('aktifitas_mobil', $data);

		$this->db->set('saldo_awal', 'saldo_awal - ' . $bbm_terpakai, FALSE)
			->where('mobil_id', $mobil_id)
			->update('master_mobil');

		$dataLog = [
			'mobil_id' 			=> $mobil_id,
			'tipe_aktivitas' 	=> 'penggunaan',
			'jumlah_saldo' 		=> $bbm_terpakai,
			'keterangan' 		=> 'Pemakaian BBM',
			'created_at' 		=> date('Y-m-d H:i:s')
		];
		$this->db->insert('saldo_bbm_log', $dataLog);

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
			'message' => 'Data berhasil disimpan.'
		]);
	}
}
