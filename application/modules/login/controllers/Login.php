<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('User_model');
	}

	public function index()
	{
		if (!empty($this->session->userdata('logged_in'))) {
		}
		$this->load->view('view_login');
	}

	public function attempt_login()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|trim', [
			'required' => 'Username wajib diisi.'
		]);
		$this->form_validation->set_rules('password', 'Password', 'required', [
			'required' => 'Password wajib diisi.'
		]);

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('notifikasi_error', validation_errors());
			redirect(base_url('/'));
		} else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$user = $this->User_model->get_user_by_username($username);

			if ($user) {
				if (password_verify($password, $user['password_hash'])) {
					if ($user['role'] == 'admin') {
						$this->session->set_userdata([
							'user_id' 		=> $user['user_id'],
							'username' 		=> $user['username'],
							'role' 			=> $user['role'],
							'logged_in' 	=> TRUE
						]);

						redirect(base_url('admin/dashboard'));
					} elseif ($user['role'] == 'sopir') {
						$this->session->set_userdata([
							'user_id' 		=> $user['user_id'],
							'username' 		=> $user['username'],
							'role' 			=> $user['role'],
							'logged_in' 	=> TRUE
						]);

						redirect(base_url('sopir/dashboard'));
					} else {
						$this->session->set_flashdata('notifikasi_error', 'Username tidak ditemukan.');
						redirect(base_url('/'));
					}
				} else {
					$this->session->set_flashdata('notifikasi_error', 'Password salah.');
					redirect(base_url('/'));
				}
			} else {
				$this->session->set_flashdata('notifikasi_error', 'Username tidak ditemukan.');
				redirect(base_url('/'));
			}
		}
	}

	public function logout()
	{
		// Hapus semua data session
		$this->session->unset_userdata(['user_id', 'username', 'role', 'logged_in']);

		// Atau untuk menghapus seluruh session
		// $this->session->sess_destroy();

		// Set pesan logout berhasil (opsional)
		$this->session->set_flashdata('success', 'Anda telah berhasil logout.');

		// Redirect ke halaman login atau halaman lain
		redirect('login');
	}
}
