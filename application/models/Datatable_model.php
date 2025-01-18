<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datatable_model extends CI_Model
{
	public function get_mobil_datatable()
	{
		$this->db->select('*');
		$this->db->from('master_mobil');

		$limit = $this->input->get('length') ?? 10;
		$start = $this->input->get('start') ?? 0;
		$search = $this->input->get('search')['value'] ?? '';

		$totalData = $this->db->count_all_results('', false);

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('nomor_plat', $search);
			$this->db->or_like('merk', $search);
			$this->db->or_like('type', $search);
			$this->db->group_end();
		}

		$totalFiltered = $this->db->count_all_results('', false);

		$this->db->order_by('mobil_id', 'DESC');
		$this->db->limit($limit, $start);
		$mobil = $this->db->get()->result_array();

		$data = [];
		foreach ($mobil as $row) {
			$this->db->select([
				'SUM(jarak_tempuh_aktifitas) AS jarak_tempuh',
				'SUM(bbm_terpakai) AS bbm_terpakai'
			]);
			$this->db->from('aktifitas_mobil');
			$this->db->where('mobil_id', $row['mobil_id']);
			$result = $this->db->get()->row();

			$jarak_tempuh = $result->jarak_tempuh ?? 0;
			$bbm_terpakai = $result->bbm_terpakai ?? 0;

			$data[] = [
				'mobil_id'     					=> $row['mobil_id'],
				'nomor_plat'     				=> $row['nomor_plat'],
				'merk'     						=> $row['merk'],
				'type'     						=> $row['type'],
				'saldo'     					=> $row['saldo_awal'],
				'jarak_tempuh_per_liter'     	=> $row['jarak_tempuh_per_liter'],
				'jarak_tempuh'     				=> $jarak_tempuh ?? 0,
				'bbm_terpakai'     				=> $bbm_terpakai ?? 0,
			];
		}

		$data = [
			"draw" 				=> intval($this->input->post('draw')),
			"recordsTotal" 		=> intval($totalData),
			"recordsFiltered" 	=> intval($totalFiltered),
			"data" 				=> $data
		];
		return $data;
	}

	public function get_request_datatable()
	{
		$this->db->select([
			'a.*',
			'b.username',
			'c.merk',
			'c.type',
		]);
		$this->db->from('request_pengisian_bbm as a');
		$this->db->join('users as b', 'b.user_id = a.sopir_id', 'left');
		$this->db->join('master_mobil as c', 'c.mobil_id = a.mobil_id', 'left');

		$limit = $this->input->get('length') ?? 10;
		$start = $this->input->get('start') ?? 0;
		$search = $this->input->get('search')['value'] ?? '';
		$status = $this->input->get('status');

		if ($status) {
			$this->db->where('a.status', $status);
		}

		$this->db->where('a.sopir_id', $this->session->userdata('user_id'));

		$totalData = $this->db->count_all_results('', false);

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('a.jenis_bbm', $search);
			$this->db->or_like('b.username', $search);
			$this->db->or_like('c.merk', $search);
			$this->db->or_like('c.type', $search);
			$this->db->group_end();
		}

		$totalFiltered = $this->db->count_all_results('', false);

		$this->db->order_by('a.request_id', 'DESC');
		$this->db->limit($limit, $start);
		$request = $this->db->get()->result_array();

		$data = [];
		foreach ($request as $row) {

			$approvedBy = '-';
			if ($row['approved_by']) {
				$this->db->select('*');
				$this->db->from('users');
				$this->db->where('user_id', $row['approved_by']);
				$query = $this->db->get()->row();
				$approvedBy = $query->username . ' (' . $row['approved_at'] . ')' ?? '-';
			}

			switch ($row['jenis_bbm']) {
				case 'pertamax':
					$harga = $row['jumlah_liter'] * 13500;
					break;
				case 'pertalite':
					$harga = $row['jumlah_liter'] * 10000;
					break;
				case 'solar':
					$harga = $row['jumlah_liter'] * 7000;
					break;
				case 'pertadex':
					$harga = $row['jumlah_liter'] * 15000;
					break;
				default:
					$harga = 0;
					break;
			}

			$data[] = [
				'request_id'     		=> $row['request_id'],
				'nama_supir'     		=> $row['username'],
				'nama_mobil'     		=> $row['merk'] . ' ' . $row['type'],
				'jumlah_liter'     		=> $row['jumlah_liter'],
				'status'     			=> $row['status'],
				'approved_by'     		=> $approvedBy,
				'harga'     			=> 'Rp. ' . number_format($harga, 0, '.', '.'),
				'jenis_bbm'     		=> $row['jenis_bbm'],
				'created_at'     		=> $row['created_at'],
			];
		}

		$data = [
			"draw" 				=> intval($this->input->post('draw')),
			"recordsTotal" 		=> intval($totalData),
			"recordsFiltered" 	=> intval($totalFiltered),
			"data" 				=> $data
		];
		return $data;
	}

	public function get_activity_datatable_sopir()
	{
		$this->db->select([
			'a.*',
			'b.username',
			'c.merk',
			'c.type',
		]);
		$this->db->from('aktifitas_mobil as a');
		$this->db->join('users as b', 'b.user_id = a.sopir_id', 'left');
		$this->db->join('master_mobil as c', 'c.mobil_id = a.mobil_id', 'left');

		$limit = $this->input->get('length') ?? 10;
		$start = $this->input->get('start') ?? 0;
		$search = $this->input->get('search')['value'] ?? '';

		$this->db->where('a.sopir_id', $this->session->userdata('user_id'));

		$totalData = $this->db->count_all_results('', false);

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('b.username', $search);
			$this->db->or_like('c.merk', $search);
			$this->db->or_like('c.type', $search);
			$this->db->group_end();
		}

		$totalFiltered = $this->db->count_all_results('', false);

		$this->db->order_by('a.aktifitas_id', 'DESC');
		$this->db->limit($limit, $start);
		$activity = $this->db->get()->result_array();

		$data = [];
		foreach ($activity as $row) {

			$data[] = [
				'aktifitas_id'     			=> $row['aktifitas_id'],
				'nama_supir'     			=> $row['username'],
				'jarak_tempuh_aktifitas'	=> $row['jarak_tempuh_aktifitas'],
				'bbm_terpakai'				=> $row['bbm_terpakai'],
				'nama_mobil'     			=> $row['merk'] . ' ' . $row['type'],
				'created_at'     			=> $row['created_at'],
			];
		}

		$data = [
			"draw" 				=> intval($this->input->post('draw')),
			"recordsTotal" 		=> intval($totalData),
			"recordsFiltered" 	=> intval($totalFiltered),
			"data" 				=> $data
		];
		return $data;
	}

	public function get_activity_datatable_mobil($mobil_id)
	{
		$this->db->select([
			'a.*',
			'b.username',
			'c.merk',
			'c.type',
		]);
		$this->db->from('aktifitas_mobil as a');
		$this->db->join('users as b', 'b.user_id = a.sopir_id', 'left');
		$this->db->join('master_mobil as c', 'c.mobil_id = a.mobil_id', 'left');

		$limit = $this->input->get('length') ?? 10;
		$start = $this->input->get('start') ?? 0;
		$search = $this->input->get('search')['value'] ?? '';

		$this->db->where('a.mobil_id', $mobil_id);

		$totalData = $this->db->count_all_results('', false);

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('b.username', $search);
			$this->db->or_like('c.merk', $search);
			$this->db->or_like('c.type', $search);
			$this->db->group_end();
		}

		$totalFiltered = $this->db->count_all_results('', false);

		$this->db->order_by('a.aktifitas_id', 'DESC');
		$this->db->limit($limit, $start);
		$activity = $this->db->get()->result_array();

		$data = [];
		foreach ($activity as $row) {

			$data[] = [
				'aktifitas_id'     			=> $row['aktifitas_id'],
				'nama_supir'     			=> $row['username'],
				'jarak_tempuh_aktifitas'	=> $row['jarak_tempuh_aktifitas'],
				'bbm_terpakai'				=> $row['bbm_terpakai'],
				'nama_mobil'     			=> $row['merk'] . ' ' . $row['type'],
				'created_at'     			=> $row['created_at'],
			];
		}

		$data = [
			"draw" 				=> intval($this->input->post('draw')),
			"recordsTotal" 		=> intval($totalData),
			"recordsFiltered" 	=> intval($totalFiltered),
			"data" 				=> $data
		];
		return $data;
	}

	public function get_approval_datatable()
	{
		$this->db->select([
			'a.*',
			'b.username',
			'c.merk',
			'c.type',
		]);
		$this->db->from('request_pengisian_bbm as a');
		$this->db->join('users as b', 'b.user_id = a.sopir_id', 'left');
		$this->db->join('master_mobil as c', 'c.mobil_id = a.mobil_id', 'left');

		$limit = $this->input->get('length') ?? 10;
		$start = $this->input->get('start') ?? 0;
		$search = $this->input->get('search')['value'] ?? '';
		$status = $this->input->get('status');

		if ($status) {
			$this->db->where('a.status', $status);
		}

		$totalData = $this->db->count_all_results('', false);

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('a.jenis_bbm', $search);
			$this->db->or_like('b.username', $search);
			$this->db->or_like('c.merk', $search);
			$this->db->or_like('c.type', $search);
			$this->db->group_end();
		}

		$totalFiltered = $this->db->count_all_results('', false);

		$this->db->order_by('a.request_id', 'DESC');
		$this->db->limit($limit, $start);
		$approv = $this->db->get()->result_array();

		$data = [];
		foreach ($approv as $row) {
			$approvedBy = '-';
			if ($row['approved_by']) {
				$this->db->select('*');
				$this->db->from('users');
				$this->db->where('user_id', $row['approved_by']);
				$query = $this->db->get()->row();
				$approvedBy = $query->username . ' (' . $row['approved_at'] . ')' ?? '-';
			}

			switch ($row['jenis_bbm']) {
				case 'pertamax':
					$harga = $row['jumlah_liter'] * 13500;
					break;
				case 'pertalite':
					$harga = $row['jumlah_liter'] * 10000;
					break;
				case 'solar':
					$harga = $row['jumlah_liter'] * 7000;
					break;
				case 'pertadex':
					$harga = $row['jumlah_liter'] * 15000;
					break;
				default:
					$harga = 0;
					break;
			}

			$data[] = [
				'request_id'     		=> $row['request_id'],
				'nama_supir'     		=> $row['username'],
				'nama_mobil'     		=> $row['merk'] . ' ' . $row['type'],
				'jumlah_liter'     		=> $row['jumlah_liter'],
				'status'     			=> $row['status'],
				'approved_by'     		=> $approvedBy,
				'harga'     			=> 'Rp. ' . number_format($harga, 0, '.', '.'),
				'jenis_bbm'     		=> $row['jenis_bbm'],
				'created_at'     		=> $row['created_at'],
			];
		}

		$data = [
			"draw" 				=> intval($this->input->post('draw')),
			"recordsTotal" 		=> intval($totalData),
			"recordsFiltered" 	=> intval($totalFiltered),
			"data" 				=> $data
		];
		return $data;
	}

	public function get_history_mobil_datatable($idMobil)
	{
		$this->db->select('*');
		$this->db->from('saldo_bbm_log');
		$this->db->where('mobil_id', $idMobil);

		$limit = $this->input->get('length') ?? 10;
		$start = $this->input->get('start') ?? 0;
		$search = $this->input->get('search')['value'] ?? '';

		$totalData = $this->db->count_all_results('', false);

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('tipe_aktivitas', $search);
			$this->db->or_like('keterangan', $search);
			$this->db->group_end();
		}

		$totalFiltered = $this->db->count_all_results('', false);

		$this->db->order_by('log_id', 'DESC');
		$this->db->limit($limit, $start);
		$approv = $this->db->get()->result_array();

		$data = [];
		foreach ($approv as $row) {

			if ($row['tipe_aktivitas'] == 'saldo awal') {
				$tipe = 'Saldo Awal';
			} else if ($row['tipe_aktivitas'] == 'pengisian') {
				$tipe = 'Pengisian BBM';
			} else {
				$tipe = 'Pemakaian BBM';
			}
			$data[] = [
				'log_id'     		=> $row['log_id'],
				'mobil_id'     		=> $row['mobil_id'],
				'tipe_aktivitas'  	=> $tipe,
				'jumlah_saldo'   	=> $row['jumlah_saldo'],
				'keterangan'     	=> $row['keterangan'],
				'created_at'     	=> $row['created_at'],
			];
		}

		$data = [
			"draw" 				=> intval($this->input->post('draw')),
			"recordsTotal" 		=> intval($totalData),
			"recordsFiltered" 	=> intval($totalFiltered),
			"data" 				=> $data
		];
		return $data;
	}
}
