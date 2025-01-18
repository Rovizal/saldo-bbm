<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('check_access')) {
	function check_access($required_role)
	{
		$CI = &get_instance();
		$user_role = $CI->session->userdata('role');

		if ($user_role !== $required_role) {
			redirect('not_authorized'); // Redirect ke halaman akses ditolak
			exit;
		}
	}
}
