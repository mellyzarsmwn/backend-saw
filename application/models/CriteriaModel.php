<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CriteriaModel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		//melakukan koneksi database
		$this->load->database();
	}

	public function all()
	{
		return $this->db->select('c.*')
			->where('deleted_at is null')
			->order_by('id desc')
			->get('criteria c');
	}

	public function getWhere($where)
	{
		$this->db->where($where);
		return $this->db->get('criteria');
	}

	public function insert($data)
	{
		// melakukan insert ke tabel users
		return $this->db->insert('criteria', $data);
	}

	public function update($data, $where)
	{
		//melakukan update ke tabel users
		$this->db->where($where);
		return $this->db->update('criteria', $data);
	}

	public function delete($where)
	{
		//menghapus data pada tabel users sesuai kriteria
		$data = array(
			'deleted_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		);

		$this->db->where($where);
		return $this->db->update('criteria', $data);
	}

}
