<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Global_model extends CI_Model
{
	public function insert_mobil($data)
	{
		return $this->db->insert('master_mobil', $data);
	}

	public function update_mobil($idMobil, $dataMobil)
	{
		$this->db->where('mobil_id', $idMobil);
		$query = $this->db->update('master_mobil', $dataMobil);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function get_mobil_by_id($mobil_id)
	{
		$this->db->select('*');
		$this->db->from('master_mobil');
		$this->db->where('mobil_id', $mobil_id);
		$query = $this->db->get();
		return $query;
	}

	public function get_merek_by_name($merek)
	{
		$this->db->select('*');
		$this->db->from('merek_mobil');
		$this->db->where('nama_merek', $merek);
		$query = $this->db->get();
		return $query;
	}

	public function get_tipe_by_name($nama_tipe)
	{
		$this->db->select('*');
		$this->db->from('tipe_mobil');
		$this->db->where('nama_tipe', $nama_tipe);
		$query = $this->db->get();
		return $query;
	}

	public function get_tipe_by_merek_id($id_merek)
	{
		$this->db->select('*');
		$this->db->from('tipe_mobil');
		$this->db->where('id_merek', $id_merek);
		$query = $this->db->get();
		return $query;
	}

	public function get_all_mobil()
	{
		$this->db->select('*');
		$this->db->from('master_mobil');
		$query = $this->db->get();
		return $query;
	}

	public function update_saldo_mobil($idMobil, $dataMobil)
	{
		$this->db->where('mobil_id', $idMobil);
		$query = $this->db->update('master_mobil', $dataMobil);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function get_approval_by_id($request_id)
	{
		$this->db->select('*');
		$this->db->from('request_pengisian_bbm');
		$this->db->where('request_id', $request_id);
		$query = $this->db->get();
		return $query;
	}

	public function countMobil()
	{
		$this->db->select('*');
		$this->db->from('master_mobil');
		$query = $this->db->get();
		return $query;
	}

	public function countApprovalApproved()
	{
		$this->db->select('*');
		$this->db->from('request_pengisian_bbm');
		$this->db->where('status', 'approved');
		$query = $this->db->get();
		return $query;
	}

	public function countApprovalPending()
	{
		$this->db->select('*');
		$this->db->from('request_pengisian_bbm');
		$this->db->where('status', 'pending');
		$query = $this->db->get();
		return $query;
	}

	public function countApprovalRejected()
	{
		$this->db->select('*');
		$this->db->from('request_pengisian_bbm');
		$this->db->where('status', 'rejected');
		$query = $this->db->get();
		return $query;
	}

	public function get_mobil_detail($mobil_id)
	{
		$this->db->select([
			'a.*',
			'COALESCE(SUM(b.jarak_tempuh_aktifitas), 0) AS jarak_tempuh',
			'COALESCE(SUM(b.bbm_terpakai), 0) AS total_bbm_terpakai',
			'COALESCE(SUM(c.jumlah_liter * (CASE 
            WHEN c.jenis_bbm = "pertalite" THEN 10000 
            WHEN c.jenis_bbm = "pertamax" THEN 13500 
            WHEN c.jenis_bbm = "solar" THEN 7000 
            WHEN c.jenis_bbm = "pertadex" THEN 15000 
            ELSE 0 
        END)), 0) AS biaya_bbm',
			// Rumus Liter/100km
			'CASE 
            WHEN SUM(b.jarak_tempuh_aktifitas) > 0 
            THEN ROUND(SUM(b.bbm_terpakai) * 100 / SUM(b.jarak_tempuh_aktifitas), 2)
            ELSE 0
        END AS liter_per_100km'
		]);
		$this->db->from('master_mobil as a');
		$this->db->join('aktifitas_mobil as b', 'a.mobil_id = b.mobil_id', 'left');
		$this->db->join('request_pengisian_bbm as c', 'a.mobil_id = c.mobil_id', 'left');
		$this->db->where('a.mobil_id', $mobil_id);
		$this->db->group_by('a.mobil_id');
		$query = $this->db->get();

		return $query;
	}

	public function delete_mobil($mobil_id)
	{
		$this->db->trans_start();

		$this->db->delete('master_mobil', ['mobil_id' => $mobil_id]);
		$this->db->delete('request_pengisian_bbm', ['mobil_id' => $mobil_id]);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return false;
		}

		return true;
	}


	public function delete_request($request_id)
	{
		$this->db->trans_start();

		$this->db->delete('request_pengisian_bbm', ['request_id' => $request_id]);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return false;
		}

		return true;
	}
}
