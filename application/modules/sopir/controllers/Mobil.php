<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mobil extends MX_Controller
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
		$this->load->library('encryption');
	}

	function index()
	{
		$this->load->view('view_daftar_mobil');
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

	public function get_mobil_datatable()
	{
		$query = $this->datatable_model->get_mobil_datatable();

		header('Content-Type: application/json');
		echo json_encode($query);
		exit();
	}

	public function get_history_mobil_datatable()
	{
		$id = $this->input->get('data');

		$idMobil = $this->base64UrlSafeDecode($id);
		$query = $this->datatable_model->get_history_mobil_datatable($idMobil);

		header('Content-Type: application/json');
		echo json_encode($query);
		exit();
	}

	public function get_tipe_mobil()
	{
		$id_merek = $this->input->post('id_merek');
		$tipe = $this->db->get_where('tipe_mobil', ['id_merek' => $id_merek])->result();

		header('Content-Type: application/json');
		echo json_encode($tipe);
	}

	public function save_mobil()
	{
		// Validasi input
		$this->form_validation->set_rules('merek', 'Merek', 'required');
		$this->form_validation->set_rules('tipe', 'Tipe', 'required');
		$this->form_validation->set_rules('nomor_plat', 'Nomor Plat', 'required');
		$this->form_validation->set_rules('jarak_tempuh_perliter', 'Jarak Tempuh Perliter', 'required|numeric');
		$this->form_validation->set_rules('saldo_awal', 'Saldo Awal BBM', 'required|numeric');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode([
				'statusCode' 	=> 400,
				'message' 		=> validation_errors()
			]);
			return;
		}

		// Proses file upload jika ada
		if (!empty($_FILES['gambar_mobil']['name'])) {
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = 2048; // 2MB

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('gambar_mobil')) {
				echo json_encode([
					'statusCode' 	=> 500,
					'message' 		=> $this->upload->display_errors()
				]);
				return;
			} else {
				$uploadData = $this->upload->data();
				$gambarPath = $uploadData['file_name'];
			}
		} else {
			$gambarPath = null; // Jika tidak ada gambar diunggah
		}

		// Tentukan merek
		$merk = '';
		if ($this->input->post('merek') == 1) {
			$merk = 'Toyota';
		} else if ($this->input->post('merek') == 2) {
			$merk = 'Honda';
		} else if ($this->input->post('merek') == 3) {
			$merk = 'Suzuki';
		}

		$data = [
			'nomor_plat' 				=> $this->input->post('nomor_plat'),
			'merk' 						=> $merk,
			'type' 						=> $this->input->post('tipe'),
			'jarak_tempuh_per_liter' 	=> $this->input->post('jarak_tempuh_perliter'),
			'saldo_awal' 				=> $this->input->post('saldo_awal'),
			'gambar_mobil' 				=> $gambarPath,
			'created_at' 				=> date('Y-m-d H:i:s')
		];

		$this->db->trans_start();

		$insertResult = $this->global_model->insert_mobil($data);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE || !$insertResult) {
			echo json_encode([
				'statusCode' 	=> 500,
				'message' 		=> 'Gagal menyimpan data mobil.'
			]);
			return;
		}

		echo json_encode([
			'statusCode' 	=> 200,
			'message' 		=> 'Data mobil berhasil disimpan.'
		]);
	}



	public function view_detail()
	{
		$mobil_id = $this->input->get('data');
		if (!$mobil_id) {
			echo json_encode([
				'statusCode' 	=> 400,
				'message' 		=> 'ID mobil tidak ditemukan.'
			]);
			return;
		}

		$mobil = $this->global_model->get_mobil_detail(base64_decode($mobil_id));
		if ($mobil) {
			echo json_encode([
				'statusCode' 	=> 200,
				'data' 			=> $mobil->row()
			]);
		} else {
			echo json_encode([
				'statusCode' 	=> 500,
				'message' 		=> 'Detail mobil tidak ditemukan.'
			]);
		}
	}

	public function delete_mobil()
	{
		$mobil_id = $this->input->get('id');

		if (!$mobil_id) {
			echo json_encode([
				'statusCode' 	=> 400,
				'message'	 	=> 'ID mobil tidak ditemukan.'
			]);
			return;
		}

		$getMobil = $this->global_model->get_mobil_by_id(base64_decode($mobil_id))->row();

		if (!$getMobil) {
			echo json_encode([
				'statusCode' 	=> 404,
				'message' 		=> 'Data mobil tidak ditemukan.'
			]);
			return;
		}

		$gambarPath = './uploads/' . $getMobil->gambar_mobil;
		if (!empty($getMobil->gambar_mobil) && file_exists($gambarPath)) {
			unlink($gambarPath);
		}

		if ($this->global_model->delete_mobil(base64_decode($mobil_id)) == true) {
			echo json_encode([
				'statusCode' 	=> 200,
				'message' 		=> 'Data berhasil dihapus.'
			]);
		} else {
			echo json_encode([
				'statusCode' 	=> 500,
				'message' 		=> 'Gagal menghapus data. Silakan coba lagi.'
			]);
		}
	}

	public function detail()
	{
		$id = $this->input->get('data');

		if (!$id) {
			$this->session->set_flashdata('notifikasi_error', validation_errors());
			redirect(base_url('admin/mobil'));
		}
		$mobil_id 	= $this->base64UrlSafeDecode($id);
		$mobil 		= $this->global_model->get_mobil_detail($mobil_id)->row();

		$data = [
			'mobil_id' 					=> $mobil->mobil_id,
			'nomor_plat' 				=> $mobil->nomor_plat,
			'merk' 						=> $mobil->merk,
			'type' 						=> $mobil->type,
			'saldo_awal' 				=> $mobil->saldo_awal,
			'jarak_tempuh_per_liter' 	=> $mobil->jarak_tempuh_per_liter,
			'gambar_mobil' 				=> $mobil->gambar_mobil,
			'biaya_bbm' 				=> $mobil->biaya_bbm,
			'jarak_tempuh' 				=> $mobil->jarak_tempuh,
			'liter_per_100km' 			=> $mobil->liter_per_100km,
			'total_bbm_terpakai' 		=> $mobil->total_bbm_terpakai,
			'created_at' 				=> $mobil->created_at,
			'updated_at' 				=> $mobil->updated_at,
		];

		$this->load->view('view_detail_mobil', $data);
	}
}
