<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CriteriaModel extends CI_Model
{
	const TYPE_BENEFIT = 1;
	const TYPE_COST = 2;

	public function __construct()
	{
		parent::__construct();
		//melakukan koneksi database
		$this->load->database();
	}

	private function getCriteriaStrType($type_id)
	{
		switch ($type_id) {
			case self::TYPE_BENEFIT :
				return "Benefit";
			case self::TYPE_COST :
				return "Cost";
		}
	}

	public function getActiveCriteria()
	{
		$data = array();

		$criterias = $this->db
			->where('deleted_at is null')
			->get('criteria')
			->result();

		foreach ($criterias as $value) {
			$data[$value->id] = $value->name;
		}

		return $data;
	}

	public function getSubCriteria($sub_criteria, $criteria_id)
	{
		$response = array();
		foreach ($sub_criteria as $key => $value) {
			if ($value->criteria_id == $criteria_id) {
				$response[$value->id] = $value->name;
			}
		}
		return $response;
	}

	public function getActiveCriteriaWithSubCriteria()
	{
		$data = array();

		$criterias = $this->db
			->where('deleted_at is null')
			->get('criteria')
			->result();

		$criteria_id_arr = array();
		foreach ($criterias as $key => $val) {
			$criteria_id_arr[$key] = $val->id;
		}
		$criteria_ids = implode(',', $criteria_id_arr);

		$sub_criterias = $this->db
			->where('sc.deleted_at is null')
			->where('sc.criteria_id in (' . $criteria_ids . ')')
			->get('sub_criteria sc')
			->result();

		foreach ($criterias as $key => $value) {

			$data[$key]['id'] = $value->id;
			$data[$key]['name'] = $value->name . ' - (' . $this->getCriteriaStrType($value->type) . ')';
			$data[$key]['sub_criterias'] = $this->getSubCriteria($sub_criterias, $value->id);
		}

		return $data;
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
