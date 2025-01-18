<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Daftar_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function insert_user($data)
	{
		$query = $this->db->insert('users', $data);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
}
