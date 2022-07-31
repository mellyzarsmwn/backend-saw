<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AlternativeValueDetailModel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function all()
	{
		return $this->db->select('avd.*')
			->where('deleted_at is null')
			->order_by('id desc')
			->get('alternative_value_detail avd');
	}

	public function getWhere($where)
	{
		$this->db->where($where);
		return $this->db->get('alternative_value_detail');
	}

	public function insert($data)
	{
		return $this->db->insert('alternative_value_detail', $data);
	}

	public function update($data, $where)
	{
		$this->db->where($where);
		return $this->db->update('alternative_value_detail', $data);
	}

	public function delete($where)
	{
		$data = array(
			'deleted_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		);

		$this->db->where($where);
		return $this->db->update('alternative_value_detail', $data);
	}
}
