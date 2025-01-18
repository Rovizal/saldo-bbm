<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Daftar extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('daftar_model');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('User_model');
	}

	public function index()
	{
		$data['title'] = "Daftar";
		$this->load->view('view_daftar', $data);
	}

	public function attempt_register()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[4]|is_unique[users.username]', [
			'required' => 'Username wajib diisi.',
			'min_length' => 'Username minimal 4 karakter.',
			'is_unique' => 'Username sudah terdaftar.'
		]);
		$this->form_validation->set_rules('role', 'Role', 'required', [
			'required' => 'Role wajib dipilih.'
		]);
		$this->form_validation->set_rules(
			'password',
			'Password',
			'required|min_length[8]',
			[
				'required' => 'Password wajib diisi.',
				'min_length' => 'Password minimal 8 karakter.'
			]
		);
		$this->form_validation->set_rules('password2', 'Konfirmasi Password', 'required|matches[password]', [
			'required' => 'Konfirmasi password wajib diisi.',
			'matches' => 'Konfirmasi password tidak cocok.'
		]);

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('notifikasi_error', validation_errors());
			redirect('daftar');
		} else {
			$cekPass = $this->validate_password($this->input->post('password'));
			if (!$cekPass) {
				$this->session->set_flashdata('notifikasi_error', 'Password harus mengandung huruf besar, huruf kecil, dan angka.');
				redirect('daftar');
			}

			$data = [
				'username' 		=> $this->input->post('username'),
				'role' 			=> $this->input->post('role'),
				'password_hash' => password_hash($this->input->post('password'), PASSWORD_BCRYPT)
			];

			// Simpan data ke database melalui model
			if ($this->User_model->insert_user($data)) {
				$this->session->set_flashdata('notifikasi', 'Pendaftaran berhasil.');
				redirect('login');
			} else {
				$this->session->set_flashdata('notifikasi_error', 'Terjadi kesalahan. Coba lagi.');
				redirect('daftar');
			}
		}
	}

	public function validate_password($password)
	{
		if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
			return FALSE;
		}
		return TRUE;
	}
}
