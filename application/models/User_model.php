<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
	protected $table = 'users';

	public function insert_user($data)
	{
		return $this->db->insert($this->table, $data);
	}

	public function get_user_by_username($username)
	{
		return $this->db->get_where($this->table, ['username' => $username])->row_array();
	}
}
